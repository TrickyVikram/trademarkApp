<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentGenerator
{
    /**
     * Generate Affidavit document with editable content
     */
    public static function generateAffidavit(Application $application)
    {
        $appNumber = $application->application_number ?? 'TM-' . now()->format('Y') . '-' . $application->id;
        $date = now()->format('d.m.Y');

        $classes = self::formatClasses($application->classes ?? '');

        $applicantName = $application->applicant_name ?? 'N/A';
        $brandName = $application->brand_name ?? 'N/A';
        $industry = $application->industry ?? 'business';
        $description = $application->description ?? 'business';
        $entityType = $application->entity_type ?? 'individual';

        // Get from database instead of guessing
        $address = $application->address ?? '____________________________';
        $gender = $application->gender ?? '________';
        $nationality = $application->nationality ?? 'Indian';
        $designation = self::getDesignation($entityType);

        // Create document record first to get ID
        $document = Document::create([
            'application_id' => $application->id,
            'user_id' => $application->user_id ?? 1,
            'document_type' => 'affidavit',
            'file_path' => 'temp',
            'file_name' => 'affidavit-temp.html',
            'file_type' => 'html',
            'file_size' => 0,
            'status' => 'generated',
        ]);

        // Generate HTML with document ID embedded
        $affidavitContent = self::createAffidavitHTML(
            $appNumber,
            $date,
            $applicantName,
            $brandName,
            $industry,
            $classes,
            $description,
            $address,
            $designation,
            $gender,
            $nationality,
            $document->id,
            $application->members_details
        );

        // Update file path and save
        $filename = 'affidavit-' . $application->id . '-' . $document->id . '.html';
        $path = 'documents/affidavits/' . $filename;

        Storage::disk('public')->put($path, $affidavitContent);

        // Update document with actual path
        $document->update([
            'file_path' => $path,
            'file_name' => $filename,
            'file_size' => strlen($affidavitContent),
        ]);

        return $document;
    }

    /**
     * Generate Authorization / POA document with editable content
     */
    public static function generatePOA(Application $application)
    {
        $appNumber = $application->application_number ?? 'TM-' . now()->format('Y') . '-' . $application->id;
        $date = now()->format('d.m.Y');

        $classes = self::formatClasses($application->classes ?? '');

        $applicantName = $application->applicant_name ?? 'N/A';
        $brandName = $application->brand_name ?? 'N/A';
        $entityType = $application->entity_type ?? 'individual';

        // Get from database instead of guessing
        $address = $application->address ?? '____________________________';
        $gender = $application->gender ?? '________';
        $nationality = $application->nationality ?? 'Indian';
        $designation = self::getDesignation($entityType);

        $attorneyName = config('app.trademark_attorney_name', 'Vilas Sharma Advocate');
        $lawFirmName = config('app.law_firm_name', 'LEGAL BRUZ LLP (LAW FIRM)');
        $lawFirmAddress = config('app.law_firm_address', '34 KRISHNA NAGAR, AMBALA CANTT, HARYANA-133001, India');

        // Create document record first to get ID
        $document = Document::create([
            'application_id' => $application->id,
            'user_id' => $application->user_id ?? 1,
            'document_type' => 'poa',
            'file_path' => 'temp',
            'file_name' => 'poa-temp.html',
            'file_type' => 'html',
            'file_size' => 0,
            'status' => 'generated',
        ]);

        // Generate HTML with document ID embedded
        $poaContent = self::createPOAHTML(
            $appNumber,
            $date,
            $applicantName,
            $brandName,
            $classes,
            $address,
            $designation,
            $gender,
            $nationality,
            $attorneyName,
            $lawFirmName,
            $lawFirmAddress,
            $document->id,
            $application->members_details
        );

        // Update file path and save
        $filename = 'poa-' . $application->id . '-' . $document->id . '.html';
        $path = 'documents/poa/' . $filename;

        Storage::disk('public')->put($path, $poaContent);

        // Update document with actual path
        $document->update([
            'file_path' => $path,
            'file_name' => $filename,
            'file_size' => strlen($poaContent),
        ]);

        return $document;
    }

    /**
     * Decode classes JSON like "[\"2\"]" or ["2","35"]
     */
    private static function formatClasses($classesRaw): string
    {
        if (empty($classesRaw)) {
            return '________';
        }

        $decoded = json_decode($classesRaw, true);

        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        if (is_array($decoded)) {
            return implode(', ', array_filter($decoded));
        }

        return (string) $classesRaw;
    }

    private static function getDesignation($entityType): string
    {
        return match (strtolower((string) $entityType)) {
            'partnership' => 'Partner',
            'company', 'pvt ltd', 'private limited', 'llp' => 'Authorized Signatory',
            default => 'Proprietor',
        };
    }

    private static function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Common editable wrapper with data attribute for tracking
     */
    private static function editable(string $value, string $cls = '', string $key = ''): string
    {
        $safe = self::e($value);
        $dataAttr = $key ? 'data-field="' . self::e($key) . '"' : '';
        return '<span class="editable ' . $cls . '" contenteditable="true" ' . $dataAttr . '>' . $safe . '</span>';
    }

    /**
     * Shared style + JS for inline editing and saving
     */
    private static function commonHead(string $title, int $documentId = 0): string
    {
        $safeTitle = self::e($title);

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$safeTitle}</title>
    <style>
        @page {
            margin: 28px 38px;
        }

        /* * {
            box-sizing: border-box;
        } */

        body {
            margin: 0;
            padding: 16px;
            background: #efefef;
            font-family: "Times New Roman", Times, serif;
            color: #000;
        }

        .toolbar {
            max-width: 820px;
            margin: 0 auto 14px auto;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            background: #f8f9fa;
            padding: 12px;
            border-radius: 4px;
        }

        .toolbar button {
            border: 1px solid #007bff;
            background: #fff;
            color: #007bff;
            padding: 8px 14px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .toolbar button:hover {
            background: #007bff;
            color: white;
        }

        .toolbar button.save-btn {
            border-color: #28a745;
            color: #28a745;
        }

        .toolbar button.save-btn:hover {
            background: #28a745;
            color: white;
        }

        .toolbar button.danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .toolbar button.danger:hover {
            background: #dc3545;
            color: white;
        }

        .toolbar .status {
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 13px;
            align-self: center;
        }

        .toolbar .status.editing {
            background: #fff3cd;
            color: #856404;
        }

        .toolbar .status.saved {
            background: #d4edda;
            color: #155724;
        }

        .page {
            width: 794px;
            min-height: 1123px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 38px 36px 38px;
            box-shadow: 0 0 10px rgba(0,0,0,0.12);
            line-height: 1.28;
            position: relative;
        }

        .page[data-editing="true"] {
            outline: 2px dashed #007bff;
        }

        .title {
            text-align: center;
            font-weight: 700;
            font-size: 22px;
            margin: 18px 0 26px;
        }

        p {
            margin: 0 0 18px 0;
            /* text-align: justify; */
        }

        .intro {
            font-weight: 700;
            margin-bottom: 30px;
        }

        .numbered-row {
            display: table;
            width: 100%;
            margin-bottom: 18px;
        }

        .num {
            display: table-cell;
            width: 30px;
            vertical-align: top;
        }

        .text {
            display: table-cell;
            vertical-align: top;
        }

        table {
            width: 82%;
            margin: 10px 0 14px 55px;
            border-collapse: collapse;
            font-size: 17px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
            text-align: left;
        }

        th {
            font-weight: 700;
        }

        .deponent {
            text-align: right;
            font-weight: 700;
            margin-top: 54px;
            margin-right: 34px;
        }

        .verification-title {
            text-align: center;
            font-weight: 700;
            font-size: 20px;
            margin-top: 56px;
            margin-bottom: 20px;
        }

        .firm-block {
            margin-top: 55px;
            margin-bottom: 40px;
            font-weight: 700;
            white-space: pre-line;
        }

        .signature-block {
            margin-top: 18px;
        }

        .editable {
            min-width: 8px;
            display: inline-block;
            outline: none;
            border-radius: 2px;
            padding: 0 2px;
            cursor: text;
        }

        .editable:hover,
        .editable:focus {
            background: #fff6bf;
            box-shadow: 0 0 3px rgba(255,193,7,0.5);
        }

        .underline-space {
            border-bottom: 1px solid #000;
            min-width: 120px;
        }

        .small-gap {
            display: inline-block;
            width: 24px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .toolbar {
                display: none !important;
            }

            .page {
                box-shadow: none;
                margin: 0;
                width: auto;
                min-height: auto;
                padding: 0;
                outline: none;
            }

            .editable:hover,
            .editable:focus {
                background: transparent;
                box-shadow: none;
            }
        }
    </style>
</head>
<body data-document-id="{$documentId}">
    <div class="toolbar">
        <button type="button" id="printBtn" onclick="window.print()">
            <i class="fas fa-print"></i> Print / Save PDF
        </button>
        <button type="button" id="editBtn" onclick="toggleEditMode(true)">
            <i class="fas fa-edit"></i> Enable Edit
        </button>
        <button type="button" id="lockBtn" onclick="toggleEditMode(false)" style="display:none;">
            <i class="fas fa-lock"></i> Lock Edit
        </button>
        <button type="button" id="saveBtn" class="save-btn" onclick="saveDocument()" style="display:none;">
            <i class="fas fa-save"></i> Save Changes
        </button>
        <div class="status" id="status" style="display:none;"></div>
    </div>

    <script>
        // CSRF token from meta tag or cookie
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || 
                   document.cookie.split('; ').find(row => row.startsWith('XSRF-TOKEN='))?.split('=')[1];
        }

        let isEditing = false;
        const documentId = document.body.getAttribute('data-document-id');

        function toggleEditMode(enable) {
            isEditing = enable;
            const editBtn = document.getElementById('editBtn');
            const lockBtn = document.getElementById('lockBtn');
            const saveBtn = document.getElementById('saveBtn');
            const page = document.querySelector('.page');
            const status = document.getElementById('status');

            document.querySelectorAll('.editable').forEach(el => {
                el.contentEditable = enable;
                if (enable) {
                    el.style.cursor = 'text';
                } else {
                    el.style.cursor = 'default';
                }
            });

            editBtn.style.display = enable ? 'none' : 'block';
            lockBtn.style.display = enable ? 'block' : 'none';
            saveBtn.style.display = enable ? 'block' : 'none';
            page.setAttribute('data-editing', enable);

            if (enable) {
                status.textContent = '✎ Editing Mode Active';
                status.className = 'status editing';
                status.style.display = 'block';
            } else {
                status.style.display = 'none';
            }
        }

        async function saveDocument() {
            if (!isEditing || !documentId) {
                alert('Cannot save. Not in edit mode.');
                return;
            }

            // Get full page content
            const pageElement = document.querySelector('.page');
            const content = pageElement.innerHTML;

            const status = document.getElementById('status');

            try {
                const response = await fetch('/documents/save-edited', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        document_id: documentId,
                        content: content,
                    }),
                });

                const data = await response.json();

                if (response.ok) {
                    status.textContent = '✓ Saved successfully';
                    status.className = 'status saved';
                    status.style.display = 'block';
                    
                    setTimeout(() => {
                        status.style.display = 'none';
                    }, 3000);
                } else {
                    alert('Error: ' + (data.message || 'Failed to save'));
                    status.textContent = '✗ Save failed';
                    status.className = 'status';
                    status.style.display = 'block';
                }
            } catch (error) {
                console.error('Save error:', error);
                alert('Error saving document: ' + error.message);
                status.textContent = '✗ Save failed';
                status.className = 'status';
                status.style.display = 'block';
            }
        }

        // Prevent pasting formatted content
        document.addEventListener('paste', function(e) {
            const target = document.activeElement;
            if (target && target.classList.contains('editable')) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData).getData('text');
                document.execCommand('insertText', false, text);
            }
        });

        // Prevent unsafe formatting
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'b') e.preventDefault();
            if (e.ctrlKey && e.key === 'i') e.preventDefault();
            if (e.ctrlKey && e.key === 'u') e.preventDefault();
        });
    </script>
</body>
</html>
HTML;
    }

    /**
     * Affidavit editable HTML
     */
    private static function createAffidavitHTML(
        $appNumber,
        $date,
        $applicantName,
        $brandName,
        $industry,
        $classes,
        $description,
        $address,
        $designation,
        $gender,
        $nationality,
        int $documentId = 0,
        $membersDetails = null
    ): string {
        $title = 'Affidavit - ' . $appNumber;

        $brandNameE = self::editable($brandName, 'bold-text', 'brand_name');
        $addressE = self::editable($address, '', 'address');
        $classesE = self::editable($classes, '', 'classes');
        $applicantNameE = self::editable($applicantName, '', 'applicant_name');
        $designationE = self::editable($designation, '', 'designation');
        $descriptionE = self::editable($description, '', 'description');
        $genderE = self::editable($gender, '', 'gender');
        $nationalityE = self::editable($nationality, '', 'nationality');
        $dateE = self::editable($date, '', 'date');
        $placeE = self::editable('______________', 'underline-space', 'place');

        // Generate member rows if available
        $memberRows = '';
        if ($membersDetails && is_array($membersDetails)) {
            $seqNo = 2;
            foreach ($membersDetails as $member) {
                $memberName = self::editable($member['name'] ?? '', '', 'member_name_' . $seqNo);
                $memberDesignation = self::editable($member['designation'] ?? '', '', 'member_designation_' . $seqNo);
                $memberGender = self::editable($member['gender'] ?? '', '', 'member_gender_' . $seqNo);
                $memberNationality = self::editable($member['nationality'] ?? '', '', 'member_nationality_' . $seqNo);
                
                $memberRows .= <<<HTML
            <tr>
                <td>{$seqNo}.</td>
                <td>{$memberName}</td>
                <td>{$memberDesignation}</td>
                <td>{$memberGender}</td>
                <td>{$memberNationality}</td>
            </tr>
HTML;
                $seqNo++;
            }
        }

        $html = self::commonHead($title, $documentId) . <<<HTML
    <div class="page">
        <div class="title">AFFIDAVIT</div>

        <p class="intro">
            In the matter of trademark application for {$brandNameE}, having their address {$addressE} in Class {$classesE}.
        </p>

        <p>
            I, {$applicantNameE}, resident of {$addressE} and being an Indian national, do hereby in the capacity of {$designationE}
            above said applicant, do solemnly state and affirm as under: -
        </p>

        <div class="numbered-row">
            <div class="num">1.</div>
            <div class="text">
                That the applicant is the owner of the trade mark as detailed in paragraph number 6 under class {$classesE}
                and is carrying on business at {$addressE} and I am thoroughly familiar &amp; aware with its affairs.
            </div>
        </div>

        <div class="numbered-row">
            <div class="num">2.</div>
            <div class="text">
                That following are the partners of the partnership.
            </div>
        </div>

        <table>
            <tr>
                <th style="width: 11%;">S. No</th>
                <th style="width: 27%;">Name of Partner</th>
                <th style="width: 19%;">Designation</th>
                <th style="width: 19%;">Gender</th>
                <th style="width: 24%;">Nationality</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>{$applicantNameE}</td>
                <td>{$designationE}</td>
                <td>{$genderE}</td>
                <td>{$nationalityE}</td>
            </tr>
            {$memberRows}
        </table>

        <div class="numbered-row" style="margin-top: 20px;">
            <div class="num">3.</div>
            <div class="text">
                That the applicant is engaged in the business of {$descriptionE} as described in trade mark application in form TM-A.
            </div>
        </div>

        <div class="numbered-row">
            <div class="num">4.</div>
            <div class="text">
                That the Trademark Category is: {$industry}
            </div>
        </div>

        <div class="numbered-row">
            <div class="num">5.</div>
            <div class="text">
                That the said trademark was conceived and adopted by the applicant and it is proposed to be used openly,
                continuously, uninterruptedly, and extensively.
            </div>
        </div>

        <div class="numbered-row">
            <div class="num">6.</div>
            <div class="text">
                That the trademark is as under: <b>{$brandNameE}</b>
            </div>
        </div>

        <div class="deponent">DEPONENT</div>

        <div class="verification-title">VERIFICATION</div>

        <p>
            Verified today on {$dateE} at {$placeE} that the contents of aforesaid affidavit are true and correct to the best
            of our knowledge and that nothing material has been concealed therefrom.
        </p>

        <div class="deponent" style="margin-top: 66px;">DEPONENT</div>
    </div>
</body>
</html>
HTML;

        return $html;
    }

    /**
     * POA editable HTML
     */
    private static function createPOAHTML(
        $appNumber,
        $date,
        $applicantName,
        $brandName,
        $classes,
        $address,
        $designation,
        $gender,
        $nationality,
        $attorneyName,
        $lawFirmName,
        $lawFirmAddress,
        int $documentId = 0,
        $membersDetails = null
    ): string {
        $title = 'Authorization - ' . $appNumber;

        $applicantNameE = self::editable($applicantName, '', 'applicant_name');
        $addressE = self::editable($address, '', 'address');
        $designationE = self::editable($designation, '', 'designation');
        $genderE = self::editable($gender, '', 'gender');
        $nationalityE = self::editable($nationality, '', 'nationality');
        $attorneyNameE = self::editable($attorneyName, '', 'attorney_name');
        $lawFirmNameE = self::editable($lawFirmName, '', 'law_firm_name');
        $lawFirmAddressE = self::editable($lawFirmAddress, '', 'law_firm_address');
        $dateE = self::editable($date, '', 'date');

        // Generate member rows if available
        $memberRows = '';
        if ($membersDetails && is_array($membersDetails)) {
            $seqNo = 2;
            foreach ($membersDetails as $member) {
                $memberName = self::editable($member['name'] ?? '', '', 'poa_member_name_' . $seqNo);
                $memberDesignation = self::editable($member['designation'] ?? '', '', 'poa_member_designation_' . $seqNo);
                $memberGender = self::editable($member['gender'] ?? '', '', 'poa_member_gender_' . $seqNo);
                $memberNationality = self::editable($member['nationality'] ?? '', '', 'poa_member_nationality_' . $seqNo);
                
                $memberRows .= <<<HTML
            <tr>
                <td>{$seqNo}.</td>
                <td>{$memberName}</td>
                <td>{$memberDesignation}</td>
                <td>{$memberGender}</td>
                <td>{$memberNationality}</td>
            </tr>
HTML;
                $seqNo++;
            }
        }

        return self::commonHead($title, $documentId) . <<<HTML
    <div class="page">
        <div class="title">
            Authorisation to Trademark Attorney in the matters of<br>
            Trademark Registration and Representation in Relation thereto
        </div>

        <p>
            I, {$applicantNameE}, resident of {$addressE} and in the capacity of {$designationE} / authorized representative
            of the applicant having its registered address/office at {$addressE}, on behalf of all partners of the partnership
            firm as per the table below:
        </p>

        <table style="width: 92%; margin-left: 0;">
            <tr>
                <th style="width: 7%;">S. No</th>
                <th style="width: 31%;">Name of Partner</th>
                <th style="width: 23%;">Designation</th>
                <th style="width: 18%;">Gender</th>
                <th style="width: 21%;">Nationality</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>{$applicantNameE}</td>
                <td>{$designationE}</td>
                <td>{$genderE}</td>
                <td>{$nationalityE}</td>
            </tr>
            {$memberRows}
        </table>

        <p>
            do hereby authorize Mr. {$attorneyNameE} Advocate of {$lawFirmNameE} having their office at {$lawFirmAddressE}
            to act jointly or severally as our advocate/attorney for filing the application for registrations, oppositions,
            objections, assignments, rectifications, withdrawals and in all such matters where our above-mentioned firm is
            the party or interested in the prosecution.
        </p>

        <p>
            I/We further authorize our said attorney to appear in the respective office before the competent authorities and
            to give any statement, declarations, undertakings, affidavits and to make any corrections, modifications,
            alterations, deletions, additions to the documents, statements filed or to be filed by us before the said
            authorities and to receive any letter, notice, certificates for and on behalf of us as may be required.
        </p>

        <p>
            We also authorize our said advocate(s) to appoint any person or persons on our behalf to attend and conduct
            the case(s) and/or proceedings. I/We hereby ratify and agree to ratify all acts and deeds done by our said
            advocate(s). I/We hereby revoke all previous authorization, if any, in respect of the proceedings. All
            communications relating to this application may be sent to the following address in India:
        </p>

        <div class="firm-block">{$lawFirmNameE}
{$lawFirmAddressE}</div>

        <div class="signature-block">
            <p>
                SIGNATURE<br>
                (NAME OF SIGNATORY IN LETTERS: {$applicantNameE})<br>
                Dated: {$dateE}
            </p>

            <p style="margin-top: 28px;">
                To<br>
                The Registrar of Trademarks
            </p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}