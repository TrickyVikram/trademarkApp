@component('mail::message')
# Payment {{ ucfirst($status) }}

Hello {{ $user->name }},

@if ($status === 'approved')
**Good news!** Your payment has been approved successfully.

**Payment Details:**
- Amount: ₹{{ number_format($payment->amount, 2) }}
- Transaction ID: {{ $payment->transaction_id ?? 'N/A' }}
- Application: {{ $payment->application->brand_name ?? 'N/A' }}
- Date: {{ $payment->paid_at?->format('d M Y H:i A') ?? now()->format('d M Y H:i A') }}

You can now proceed with your trademark application.

@else
We regret to inform you that your payment could not be processed.

**Payment Details:**
- Amount: ₹{{ number_format($payment->amount, 2) }}
- Transaction ID: {{ $payment->transaction_id ?? 'N/A' }}
- Application: {{ $payment->application->brand_name ?? 'N/A' }}

@if ($reason)
**Reason:** {{ $reason }}
@endif

Please review your payment details and try again, or contact our support team for assistance.

@endif

@component('mail::button', ['url' => route('dashboard')])
View Dashboard
@endcomponent

If you have any questions, please don't hesitate to contact us.

Best regards,  
**Legal Bruz Team**
@endcomponent
