<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #2A9D8F; color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .content { background-color: #f9f9f9; padding: 20px; border-radius: 5px; }
        .button { background-color: #2A9D8F; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0; }
        .footer { color: #999; font-size: 12px; margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📋 Document Approved!</h2>
        </div>
        
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            
            <p>Great news! Your document <strong>{{ $document->document_type }}</strong> for application <strong>#{{ $application->id }}</strong> ({{ $application->brand_name }}) has been <strong>approved</strong> by our admin team.</p>
            
            <div style="background-color: #e8f5e9; padding: 15px; border-left: 4px solid #2A9D8F; margin: 20px 0;">
                <strong>Document Details:</strong><br>
                Document Type: {{ $document->document_type }}<br>
                Application: {{ $application->brand_name }}<br>
                Status: ✅ Approved<br>
                Approved on: {{ $document->updated_at->format('M d, Y H:i A') }}
            </div>
            
            <p>You can now download this document or upload a signed version if required.</p>
            
            <a href="{{ route('user.documents') }}" class="button">View My Documents</a>
            
            <p>If you have any questions, please feel free to contact us.</p>
            
            <p>Best regards,<br><strong>Legal Bruz Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply to this address.</p>
        </div>
    </div>
</body>
</html>
