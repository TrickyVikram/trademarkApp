<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Document;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TrademarkController extends Controller
{
    /**
     * Show trademark type selection
     */
    public function showTypeSelection()
    {
        return view('trademark.type-selection');
    }

    /**
     * Show KYC checklist based on entity type
     */
    public function showKycChecklist($type)
    {
        $kycRequirements = [
            'individual' => [
                'PAN Card',
                'Address Proof',
                'Email & Phone',
            ],
            'company' => [
                'Certificate of Incorporation',
                'PAN',
                'GST (if available)',
                'Authorized Signatory ID Proof',
            ]
        ];

        return view('trademark.kyc-checklist', [
            'type' => $type,
            'requirements' => $kycRequirements[$type] ?? []
        ]);
    }

    /**
     * Show application form
     */
    public function showApplicationForm($type)
    {
        return view('trademark.application-form', ['entity_type' => $type]);
    }

    /**
     * Store trademark application
     */
    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => 'required|in:individual,company',
            'applicant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'brand_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'required|string',
            'industry' => 'required|string|max:255',
            'usage_type' => 'required|in:india,international,both',
            'first_use_date' => 'nullable|date',
            'currently_selling' => 'boolean',
            'website' => 'nullable|url',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $application = Application::create([
            'user_id' => Auth::id(),
            'type' => 'trademark',
            'entity_type' => $validated['entity_type'],
            'applicant_name' => $validated['applicant_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'brand_name' => $validated['brand_name'],
            'logo_path' => $logoPath,
            'description' => $validated['description'],
            'industry' => $validated['industry'],
            'usage_type' => $validated['usage_type'],
            'first_use_date' => $validated['first_use_date'] ?? null,
            'currently_selling' => $validated['currently_selling'] ?? false,
            'website' => $validated['website'] ?? null,
            'status' => 'payment_pending',
        ]);

        return redirect()->route('payment.show', $application->id)
            ->with('success', 'Application created. Please complete 50% payment.');
    }

    /**
     * Show payment page with requirements
     */
    public function showPayment($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $payment = $application->payments()->where('status', 'completed')->first();
        if ($payment) {
            return redirect()->route('trademark.detailed-form', $application->id)
                ->with('info', 'Payment already completed. Proceed with details.');
        }

        $amount = 2500;
        $totalAmount = 5000;

        return view('trademark.payment', [
            'application' => $application,
            'amount' => $amount,
            'totalAmount' => $totalAmount,
        ]);
    }

    /**
     * Show detailed application form
     */
    public function showDetailedForm($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $payment = $application->payments()->where('status', 'completed')->firstOrFail();

        return view('trademark.detailed-form', ['application' => $application]);
    }

    /**
     * Store detailed form
     */
    public function storeDetailedForm(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'description' => 'required|string',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'gender' => 'required|in:male,female,other',
            'classes' => 'required|array|min:1',
            'classes.*' => 'required|string|max:45',
            'goods_services' => 'required|string|min:10',
            'usage' => 'required|in:used,proposed',
        ]);

        $application->update([
            'applicant_name' => $validated['applicant_name'],
            'brand_name' => $validated['brand_name'],
            'description' => $validated['description'],
            'nationality' => $validated['nationality'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'classes' => json_encode($validated['classes']),
            'goods_services' => $validated['goods_services'],
            'usage' => $validated['usage'],
            'status' => 'pending_documents',
        ]);

        return redirect()->route('documents.upload', $application->id)
            ->with('success', 'Details saved. Please upload required documents.');
    }

    /**
     * Show document upload page
     */
    public function showDocumentUpload($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $documentTypes = [
            'individual' => [
                'pan_card' => 'PAN Card',
                'address_proof' => 'Address Proof',
                
            ],
            'company' => [
                'certificate_of_incorporation' => 'Certificate of Incorporation',
                'pan_card' => 'PAN Card',
                'gst_certificate' => 'GST Certificate',
                'authorized_signatory_id' => 'Authorized Signatory ID',
               
            ]
        ];

        return view('trademark.upload-documents', [
            'application' => $application,
            'documentTypes' => $documentTypes[$application->entity_type] ?? []
        ]);
    }

    /**
     * Store uploaded documents
     */
    public function storeDocuments(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key) && $key !== '_token') {
                $file = $request->file($key);
                $path = $file->store('documents/' . $application->id, 'public');

                Document::create([
                    'application_id' => $application->id,
                    'user_id' => Auth::id(),
                    'document_type' => $key,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'status' => 'pending',
                ]);
            }
        }

        $application->update(['status' => 'pending_admin']);

        return redirect()->route('dashboard')
            ->with('success', 'Application submitted for admin approval!');
    }

    /**
     * Show document download page
     */
    public function showDocumentDownload($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('trademark.document-download', ['applicationId' => $applicationId]);
    }

    /**
     * Show application status
     */
    public function showStatus($applicationId)
    {
        $application = Application::with('documents', 'payments')->findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('trademark.status', ['application' => $application]);
    }

    /**
     * Generate and download Affidavit
     */
    public function downloadAffidavit($applicationId)
    {
        $application = Application::with('user')->findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $html = $this->generateAffidavitHTML($application);

        return response($html)
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="Affidavit_' . $application->id . '_' . date('Ymd') . '.html"');
    }

    /**
     * Generate and download Power of Attorney (POA)
     */
    public function downloadPOA($applicationId)
    {
        $application = Application::with('user')->findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $html = $this->generatePOAHTML($application);

        return response($html)
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="POA_' . $application->id . '_' . date('Ymd') . '.html"');
    }

    /**
     * Generate Affidavit HTML
     */
    private function generateAffidavitHTML($application)
    {
        $user = $application->user;
        $date = now()->format('d.m.Y');
        $firstUseDate = $application->first_use_date ?? 'N/A';

        return <<<'HTML'
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
                    .header { text-align: center; font-weight: bold; margin-bottom: 30px; }
                    .title { font-size: 16px; font-weight: bold; text-align: center; margin: 20px 0; }
                    .content { text-align: justify; margin: 20px 0; }
                    .signature-section { margin-top: 60px; }
                    .signature-line { margin-top: 40px; display: inline-block; width: 250px; border-top: 1px solid black; text-align: center; }
                    .box { border: 1px solid black; padding: 20px; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>AFFIDAVIT</h2>
                </div>

                <div class="box">
                    <p><strong>AFFIDAVIT FOR TRADEMARK REGISTRATION</strong></p>

                    <div class="content">
HTML;

        $html .= '<p>I, <strong>' . htmlspecialchars($user->name) . '</strong>, Son/Daughter/Wife of ______________, ';
        $html .= 'resident of ______________, do hereby solemnly affirm and declare as follows:</p>';

        $html .= '<p><strong>1.</strong> That I am the applicant for Trademark Registration bearing ';
        $html .= 'Application No. <strong>' . htmlspecialchars($application->id) . '</strong>.</p>';

        $html .= '<p><strong>2.</strong> That the Brand/Trademark proposed to be registered is ';
        $html .= '<strong>"' . htmlspecialchars($application->brand_name) . '"</strong>.</p>';

        $html .= <<<'HTML'
                        <p><strong>3.</strong> That I have the rights to use this trademark and am the true
                        owner of the same.</p>

                        <p><strong>4.</strong> That the information provided in the application is true
                        and correct to the best of my knowledge and belief.</p>

                        <p><strong>5.</strong> That I shall use the said mark in connection with the goods/services
                        specified in the application.</p>

                        <p><strong>6.</strong> That no false information has been furnished in this application.</p>

                        <p><strong>7.</strong> That the Trademark has been first used in connection with the
                        goods/services on <strong>
HTML;

        $html .= htmlspecialchars($firstUseDate) . '</strong>.</p>';

        $html .= <<<'HTML'

                        <p>I solemnly declare that the contents of this Affidavit are true to the best of
                        my knowledge and belief. I am well acquainted with the facts stated herein.
                        I have not concealed any material fact.</p>
                    </div>
                </div>

                <div class="signature-section">
                    <p><strong>Affiant's Name:</strong>
HTML;

        $html .= htmlspecialchars($user->name) . '</p>';
        $html .= '<p><strong>Date:</strong> ' . htmlspecialchars($date) . '</p>';

        $html .= <<<'HTML'
                    <p><strong>Place:</strong> ____________________</p>

                    <div class="signature-line">
                        Signature of Affiant
                    </div>
                </div>

                <div style="text-align: center; margin-top: 60px; border-top: 1px solid black; padding-top: 20px;">
                    <p><strong>BEFORE ME:</strong></p>
                    <div class="signature-line">
                        Notary / First Class Magistrate
                    </div>
                </div>
            </body>
            </html>
HTML;

        return $html;
    }

    /**
     * Generate POA HTML
     */
    private function generatePOAHTML($application)
    {
        $user = $application->user;
        $date = now()->format('d.m.Y');

        $html = <<<'HTML'
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
                    .header { text-align: center; font-weight: bold; margin-bottom: 30px; }
                    .title { font-size: 16px; font-weight: bold; text-align: center; margin: 20px 0; }
                    .content { text-align: justify; margin: 20px 0; }
                    .signature-section { margin-top: 60px; }
                    .signature-line { margin-top: 40px; display: inline-block; width: 250px; border-top: 1px solid black; text-align: center; }
                    .box { border: 1px solid black; padding: 20px; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>POWER OF ATTORNEY</h2>
                </div>

                <div class="box">
                    <p><strong>POWER OF ATTORNEY FOR TRADEMARK REGISTRATION AND REPRESENTATION</strong></p>

                    <div class="content">
HTML;

        $html .= '<p>I, <strong>' . htmlspecialchars($user->name) . '</strong>, resident of ______________, ';
        $html .= 'do hereby authorize and appoint <strong>Legal Bruz  LLP (Law Firm)</strong>, ';
        $html .= 'having their office at 34 Krishna Nagar, Ambala Cantt, Haryana 133001, India, ';
        $html .= 'to act as my Attorney in the matter of registration of Trademark bearing ';
        $html .= 'Application No. <strong>' . htmlspecialchars($application->id) . '</strong>.</p>';

        $html .= <<<'HTML'

                        <p><strong>1. SCOPE OF AUTHORITY:</strong></p>
                        <p>I hereby authorize my said Attorney to:</p>
                        <ul>
                            <li>File the Trademark application with appropriate authorities</li>
                            <li>Appear in proceedings before the Trademark Registry</li>
                            <li>Make submissions and arguments on my behalf</li>
                            <li>Reply to all official communications</li>
                            <li>Execute necessary documents and affidavits</li>
                            <li>Conduct negotiations and correspondence</li>
                            <li>Receive all official letters and certificates</li>
                            <li>Withdraw or amend the application if necessary</li>
                            <li>Perform all acts necessary for the prosecution of the application</li>
                        </ul>

                        <p><strong>2. REPRESENTATION:</strong></p>
                        <p>The said Attorney is hereby authorized to represent me in all matters related
                        to Trademark Registration (Application No.
HTML;

        $html .= htmlspecialchars($application->id) . ') for the brand ';
        $html .= '<strong>"' . htmlspecialchars($application->brand_name) . '"</strong>.</p>';

        $html .= <<<'HTML'

                        <p><strong>3. RATIFICATION:</strong></p>
                        <p>I hereby ratify and confirm all acts and deeds done by my said Attorney
                        in relation to the above matter.</p>

                        <p><strong>4. REVOCATION:</strong></p>
                        <p>All previous authorizations, if any, in respect of this matter are hereby
                        revoked and superseded by this Power of Attorney.</p>

                        <p><strong>5. VALIDITY:</strong></p>
                        <p>This Power of Attorney shall remain valid until the matter is finally
                        disposed of or until revoked by me in writing.</p>
                    </div>
                </div>

                <div class="signature-section">
                    <p><strong>Constituting Attorney Name:</strong>
HTML;

        $html .= htmlspecialchars($user->name) . '</p>';
        $html .= '<p><strong>Date:</strong> ' . htmlspecialchars($date) . '</p>';

        $html .= <<<'HTML'
                    <p><strong>Place:</strong> ____________________</p>

                    <div class="signature-line">
                        Signature of Constituting Attorney
                    </div>
                </div>

                <div style="text-align: center; margin-top: 60px; border-top: 1px solid black; padding-top: 20px;">
                    <p><strong>BEFORE ME:</strong></p>
                    <div class="signature-line">
                        Notary / First Class Magistrate
                    </div>
                </div>
            </body>
            </html>
HTML;

        return $html;
    }
}
