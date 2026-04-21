<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1D3557; color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .content { background-color: #f9f9f9; padding: 20px; border-radius: 5px; }
        .button { background-color: #2A9D8F; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0; }
        .footer { color: #999; font-size: 12px; margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px; }
        .steps { list-style: none; padding: 0; }
        .steps li { padding: 10px 0; border-bottom: 1px solid #ddd; }
        .steps li:before { content: "✓ "; color: #2A9D8F; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>👋 Welcome to Legal Bruz!</h2>
        </div>
        
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            
            <p>Welcome to <strong>Legal Bruz</strong> - Your trusted partner for trademark registration and IP protection!</p>
            
            <div style="background-color: #e3f2fd; padding: 15px; border-left: 4px solid #2A9D8F; margin: 20px 0;">
                <strong>Your Account Details:</strong><br>
                Name: {{ $user->name }}<br>
                Email: {{ $user->email }}<br>
                Registration Date: {{ $user->created_at->format('M d, Y') }}
            </div>
            
            <h3>Getting Started</h3>
            <ol class="steps">
                <li>Complete Your Profile - Add your details and preferences</li>
                <li>Start Application - Begin your trademark registration process</li>
                <li>Upload Documents - Submit required documents</li>
                <li>Get Approval - Our team will review and approve</li>
                <li>File & Track - File with trademark office and track status</li>
            </ol>
            
            <h3>Why Choose Legal Bruz?</h3>
            <ul>
                <li>✅ Easy-to-use platform</li>
                <li>✅ Professional guidance throughout</li>
                <li>✅ Fast processing</li>
                <li>✅ Transparent pricing</li>
                <li>✅ 24/7 support</li>
            </ul>
            
            <a href="{{ route('dashboard') }}" class="button">Go to Dashboard</a>
            
            <p>If you have any questions or need help, feel free to contact our support team.</p>
            
            <p>Best regards,<br><strong>Legal Bruz Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated welcome email. Please do not reply to this address.</p>
        </div>
    </div>
</body>
</html>
