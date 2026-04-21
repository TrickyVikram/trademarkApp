<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Admin;
use App\Models\Document;
use App\Models\Payment;
use App\Services\DocumentGenerator;
use App\Services\NotificationService;
use App\Mail\DocumentApprovedNotification;
use App\Mail\DocumentRejectedNotification;
use App\Mail\DocumentVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $pendingApplications = Application::where('status', 'pending_admin')->count();
        $approvedApplications = Application::where('status', 'approved')->count();
        $filedApplications = Application::where('status', 'filed')->count();
        $registeredApplications = Application::where('status', 'registered')->count();

        return view('admin.dashboard', [
            'pendingCount' => $pendingApplications,
            'approvedCount' => $approvedApplications,
            'filedCount' => $filedApplications,
            'registeredCount' => $registeredApplications,
        ]);
    }

    /**
     * List pending applications for review
     */
    public function listPendingApplications()
    {
        $applications = Application::where('status', 'pending_admin')
            ->with('user', 'documents', 'payments')
            ->latest()
            ->paginate(20);

        return view('admin.pending-applications', ['applications' => $applications]);
    }

    /**
     * Show application details for admin review
     */
    public function viewApplication($applicationId)
    {
        $application = Application::with('user', 'documents', 'payments')->findOrFail($applicationId);
        return view('admin.review-application', ['application' => $application]);
    }

    /**
     * Approve application
     */
    public function approveApplication(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        // Generate application number if not already generated
        if (!$application->application_number) {
            $applicationNumber = 'TM-' . now()->format('Y') . '-' . $application->id;
            $application->update(['application_number' => $applicationNumber]);
        }

        // Auto-generate affidavit and POA documents
        $affidavit = DocumentGenerator::generateAffidavit($application);
        $poa = DocumentGenerator::generatePOA($application);

        // Mark generated documents as approved (so users can download them)
        $application->documents()
            ->where('status', 'generated')
            ->update(['status' => 'approved']);

        $application->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Application approved! Affidavit & POA have been generated and are ready for download.');
    }

    /**
     * Reject application
     */
    public function rejectApplication(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        // Delete generated documents on rejection (so they can be regenerated)
        foreach ($application->documents()->where('status', 'generated')->get() as $doc) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
            $doc->delete();
        }

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // TODO: Send rejection email to user

        return redirect()->back()->with('success', 'Application rejected! User will need to resubmit.');
    }

    /**
     * Generate Affidavit document manually
     */
    public function generateAffidavit($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        // Generate application number if not already generated
        if (!$application->application_number) {
            $applicationNumber = 'TM-' . now()->format('Y') . '-' . $application->id;
            $application->update(['application_number' => $applicationNumber]);
        }

        // Delete existing affidavit if any
        $application->documents()
            ->where('document_type', 'affidavit')
            ->each(function($doc) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            });

        // Generate new affidavit
        $affidavit = DocumentGenerator::generateAffidavit($application);

        return redirect()->back()->with('success', '✅ Affidavit document generated successfully!');
    }

    /**
     * Generate POA document manually
     */
    public function generatePOA($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        // Generate application number if not already generated
        if (!$application->application_number) {
            $applicationNumber = 'TM-' . now()->format('Y') . '-' . $application->id;
            $application->update(['application_number' => $applicationNumber]);
        }

        // Delete existing POA if any
        $application->documents()
            ->where('document_type', 'poa')
            ->each(function($doc) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            });

        // Generate new POA
        $poa = DocumentGenerator::generatePOA($application);

        return redirect()->back()->with('success', '✅ POA document generated successfully!');
    }

    /**
     * File application with trademark registry
     */
    public function fileApplication($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved applications can be filed.');
        }

        // TODO: Integrate with actual trademark registry filing API

        $application->update([
            'status' => 'filed',
            'filed_at' => now(),
        ]);

        // TODO: Send filing confirmation email

        return redirect()->back()->with('success', 'Application filed successfully!');
    }

    /**
     * Update application status based on API response
     */
    public function updateStatus(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        $validated = $request->validate([
            'trademark_status' => 'required|string',
            'status' => 'required|string',
        ]);

        $application->update([
            'trademark_status' => $validated['trademark_status'],
            'status' => $validated['status'],
        ]);

        // TODO: Send status update email

        return response()->json(['success' => true]);
    }

    /**
     * List all applications
     */
    public function listAllApplications()
    {
        $applications = Application::with('user')->latest()->paginate(50);
        return view('admin.all-applications', ['applications' => $applications]);
    }

    /**
     * Approve individual document
     */
    public function approveDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        $application = $document->application;
        $user = $application->user;

        $document->update([
            'status' => 'approved'
        ]);

        // Send email notification
        Mail::to($user->email)->send(new DocumentApprovedNotification($user, $document, $application));

        // Create in-app notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'document_approved',
            'title' => '📋 Document Approved',
            'message' => ucfirst(str_replace('_', ' ', $document->document_type)) . ' has been approved!',
            'data' => [
                'document_id' => $document->id,
                'application_id' => $application->id,
                'document_type' => $document->document_type,
            ],
        ]);

        return redirect()->back()->with('success', '✅ ' . ucfirst(str_replace('_', ' ', $document->document_type)) . ' approved successfully! User notified via email.');
    }

    /**
     * Reject individual document
     */
    public function rejectDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        $application = $document->application;
        $user = $application->user;
        
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Change status back to pending (so user can re-upload)
        $document->update([
            'status' => 'pending'
        ]);

        // Send email notification
        Mail::to($user->email)->send(new DocumentRejectedNotification($user, $document, $application));

        // Create in-app notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'document_rejected',
            'title' => '❌ Document Rejected',
            'message' => ucfirst(str_replace('_', ' ', $document->document_type)) . ' has been rejected. Please resubmit.',
            'data' => [
                'document_id' => $document->id,
                'application_id' => $application->id,
                'document_type' => $document->document_type,
            ],
        ]);

        return redirect()->back()->with('success', '❌ ' . ucfirst(str_replace('_', ' ', $document->document_type)) . ' rejected. User notified via email to resubmit.');
    }

    /**
     * Verify individual document (mark as verified)
     */
    public function verifyDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        $application = $document->application;
        $user = $application->user;

        $document->update([
            'status' => 'verified',
            'verified_at' => now()
        ]);

        // Send email notification
        Mail::to($user->email)->send(new DocumentVerifiedNotification($user, $document, $application));

        // Create in-app notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'document_verified',
            'title' => '✔️ Document Verified',
            'message' => ucfirst(str_replace('_', ' ', $document->document_type)) . ' has been verified!',
            'data' => [
                'document_id' => $document->id,
                'application_id' => $application->id,
                'document_type' => $document->document_type,
            ],
        ]);

        return redirect()->back()->with('success', '✔️ ' . ucfirst(str_replace('_', ' ', $document->document_type)) . ' verified successfully! User notified via email.');
    }

    /**
     * Approve payment
     */
    public function approvePayment(Request $request, $paymentId)
    {
        $payment = \App\Models\Payment::findOrFail($paymentId);

        $payment->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        // Send notification to user
        \App\Services\NotificationService::sendPaymentApprovedNotification($payment);

        return redirect()->back()->with('success', '✅ Payment approved! User has been notified via email and in-app notification.');
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, $paymentId)
    {
        $payment = \App\Models\Payment::findOrFail($paymentId);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $payment->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason']
        ]);

        // Send notification to user
        \App\Services\NotificationService::sendPaymentRejectedNotification($payment, $validated['rejection_reason']);

        return redirect()->back()->with('success', '❌ Payment rejected! User has been notified with the reason.');
    }
}
