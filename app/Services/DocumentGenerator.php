<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentGenerator
{
    /**
     * Generate Affidavit document for application
     */
    public static function generateAffidavit(Application $application)
    {
        // Get application data
        $appNumber = $application->application_number ?? 'TM-' . now()->format('Y') . '-' . $application->id;
        $date = now()->format('d M Y');
        $applicantName = $application->applicant_name ?? 'N/A';
        $brandName = $application->brand_name ?? 'N/A';
        $industry = $application->industry ?? 'N/A';
        $description = $application->description ?? 'N/A';

        // Create affidavit content
        $affidavitContent = self::createAffidavitHTML($appNumber, $date, $applicantName, $brandName, $industry, $description);

        // Generate filename
        $filename = 'affidavit-' . $application->id . '-' . Str::random(8) . '.html';
        $path = 'documents/affidavits/' . $filename;

        // Store the file
        Storage::disk('public')->put($path, $affidavitContent);

        // Create document record
        $document = Document::create([
            'application_id' => $application->id,
            'user_id' => $application->user_id ?? 1,
            'document_type' => 'Affidavit',
            'file_path' => $path,
            'file_name' => $filename,
            'file_type' => 'html',
            'file_size' => strlen($affidavitContent),
            'status' => 'generated',
        ]);

        return $document;
    }

    /**
     * Generate Power of Attorney document for application
     */
    public static function generatePOA(Application $application)
    {
        // Get application data
        $appNumber = $application->application_number ?? 'TM-' . now()->format('Y') . '-' . $application->id;
        $date = now()->format('d M Y');
        $applicantName = $application->applicant_name ?? 'N/A';
        $brandName = $application->brand_name ?? 'N/A';
        $industry = $application->industry ?? 'N/A';

        // Create POA content
        $poaContent = self::createPOAHTML($appNumber, $date, $applicantName, $brandName, $industry);

        // Generate filename
        $filename = 'poa-' . $application->id . '-' . Str::random(8) . '.html';
        $path = 'documents/poa/' . $filename;

        // Store the file
        Storage::disk('public')->put($path, $poaContent);

        // Create document record
        $document = Document::create([
            'application_id' => $application->id,
            'user_id' => $application->user_id ?? 1,
            'document_type' => 'Power of Attorney',
            'file_path' => $path,
            'file_name' => $filename,
            'file_type' => 'html',
            'file_size' => strlen($poaContent),
            'status' => 'generated',
        ]);

        return $document;
    }

    /**
     * Create Affidavit HTML
     */
    private static function createAffidavitHTML($appNumber, $date, $applicantName, $brandName, $industry, $description)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affidavit - $appNumber</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.8;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .ref-number {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .content {
            margin-bottom: 20px;
            text-align: justify;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table td, table th {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .editable {
            cursor: pointer;
            padding: 2px 4px;
        }
        .editable:hover {
            background-color: #ffffcc;
            border-bottom: 1px dashed #999;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 40%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">AFFIDAVIT</div>
        <div class="ref-number">Application No: <span class="editable">$appNumber</span></div>
        <div class="ref-number">Date: <span class="editable">$date</span></div>
    </div>

    <div class="content">
        <div class="section">
            <p>I, <span class="editable">$applicantName</span>, do hereby solemnly affirm and declare as follows:</p>
        </div>

        <div class="section">
            <div class="section-title">1. APPLICANT DETAILS</div>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><span class="editable">$applicantName</span></td>
                </tr>
                <tr>
                    <td>Trademark/Brand Name</td>
                    <td><span class="editable">$brandName</span></td>
                </tr>
                <tr>
                    <td>Industry/Class</td>
                    <td><span class="editable">$industry</span></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><span class="editable">$description</span></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p>That the particulars mentioned above are true and correct to the best of my knowledge and belief.</p>
        </div>

        <div class="section">
            <p>That I am fully aware of the consequences of making false statement in this affidavit.</p>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Place: <span class="editable">_____________</span></p>
        </div>
        <div class="signature-box">
            <p>Date: <span class="editable">$date</span></p>
        </div>
    </div>

    <div class="signature-section" style="margin-top: 20px;">
        <div class="signature-box">
            <div class="signature-line">
                Signature of Declarant
            </div>
            <p>(<span class="editable">$applicantName</span>)</p>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Signature of Authorized Representative
            </div>
            <p>Name: <span class="editable">_____________</span></p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.editable').forEach(el => {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
                const currentValue = this.textContent.trim();
                const newValue = prompt('Edit this field:', currentValue);
                if (newValue !== null && newValue !== '') {
                    this.textContent = newValue;
                }
            });
        });
    </script>
</body>
</html>
HTML;
    }

    /**
     * Create POA HTML
     */
    private static function createPOAHTML($appNumber, $date, $applicantName, $brandName, $industry)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power of Attorney - $appNumber</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.8;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .ref-number {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .content {
            margin-bottom: 20px;
            text-align: justify;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table td, table th {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .editable {
            cursor: pointer;
            padding: 2px 4px;
        }
        .editable:hover {
            background-color: #ffffcc;
            border-bottom: 1px dashed #999;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 40%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">POWER OF ATTORNEY</div>
        <div class="ref-number">Application No: <span class="editable">$appNumber</span></div>
    </div>

    <div class="content">
        <div class="section">
            <p>Know all men by these presents that I, <span class="editable">$applicantName</span>, have hereby constituted, appointed and authorized my attorney to file, prosecute and protect the application for registration of my trademark <span class="editable">$brandName</span> in Class <span class="editable">$industry</span> before the Trademark Registry.</p>
        </div>

        <div class="section">
            <div class="section-title">1. APPLICANT DETAILS</div>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
                <tr>
                    <td>Applicant Name</td>
                    <td><span class="editable">$applicantName</span></td>
                </tr>
                <tr>
                    <td>Trademark/Brand Name</td>
                    <td><span class="editable">$brandName</span></td>
                </tr>
                <tr>
                    <td>Class</td>
                    <td><span class="editable">$industry</span></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">2. ATTORNEY DETAILS</div>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
                <tr>
                    <td>Attorney Name</td>
                    <td><span class="editable">_____________</span></td>
                </tr>
                <tr>
                    <td>Registration Number</td>
                    <td><span class="editable">_____________</span></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><span class="editable">_____________</span></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p>In witness whereof I have executed this Power of Attorney on this <span class="editable">$date</span>.</p>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Signature of Principal
            </div>
            <p>(<span class="editable">$applicantName</span>)</p>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Signature of Attorney
            </div>
            <p>Name: <span class="editable">_____________</span></p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.editable').forEach(el => {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
                const currentValue = this.textContent.trim();
                const newValue = prompt('Edit this field:', currentValue);
                if (newValue !== null && newValue !== '') {
                    this.textContent = newValue;
                }
            });
        });
    </script>
</body>
</html>
HTML;
    }
}
