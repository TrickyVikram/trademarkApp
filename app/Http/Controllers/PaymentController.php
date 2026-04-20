<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function showPayment($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $totalAmount = 10; // ₹5000 total, 50% advance = ₹2500
        $advanceAmount = round($totalAmount * 0.50);

        return view('payments.razorpay-form', [
            'application' => $application,
            'totalAmount' => $totalAmount,
            'advanceAmount' => $advanceAmount,
            'razorpayKeyId' => config('razorpay.key_id'),
        ]);
    }

    /**
     * Create Razorpay order
     */
    public function createOrder(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        // Get min and max from config
        $minAmount = config('razorpay.custom_payments.min_amount', 1);
        $maxAmount = config('razorpay.custom_payments.max_amount', 100000);

        $validated = $request->validate([
            'amount' => "required|numeric|min:$minAmount|max:$maxAmount",
            'payment_type' => 'required|in:advance,full,custom',
        ]);

        try {
            // Initialize Razorpay API using cURL (to avoid dependency)
            $razorpayKeyId = config('razorpay.key_id');
            $razorpaySecret = config('razorpay.key_secret');

            // Convert to paise (1 rupee = 100 paise)
            $amountInPaise = (int) ($validated['amount'] * 100);

            // Create Razorpay order via REST API
            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_USERPWD, "$razorpayKeyId:$razorpaySecret");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'receipt' => 'order_' . $application->id . '_' . time(),
                'description' => 'Trademark Registration - ' . $application->brand_name,
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                throw new \Exception('Failed to create Razorpay order');
            }

            $order = json_decode($response, true);

            // Save payment record with pending status
            $payment = Payment::create([
                'application_id' => $applicationId,
                'user_id' => Auth::id(),
                'amount' => $validated['amount'],
                'total_amount' => $validated['payment_type'] === 'full' ? $validated['amount'] : 5000,
                'percentage' => $validated['payment_type'] === 'advance' ? '50%' : '100%',
                'payment_method' => 'razorpay',
                'status' => 'pending',
                'reference_number' => $order['id'],
            ]);

            return response()->json([
                'status' => 'success',
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'key' => $razorpayKeyId,
                'user_email' => Auth::user()->email,
                'user_phone' => Auth::user()->phone ?? '',
                'user_name' => Auth::user()->name,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify Razorpay payment signature
     */
    public function verifySignature(Request $request, $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $validated = $request->validate([
                'razorpay_payment_id' => 'required|string',
                'razorpay_order_id' => 'required|string',
                'razorpay_signature' => 'required|string',
            ]);

            // Verify signature manually
            $orderId = $validated['razorpay_order_id'];
            $paymentId = $validated['razorpay_payment_id'];
            $signature = $validated['razorpay_signature'];

            $secret = config('razorpay.key_secret');

            // Create the expected signature
            $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

            if ($expectedSignature !== $signature) {
                throw new \Exception('Invalid payment signature');
            }

            // Update payment record
            $payment = Payment::where([
                'application_id' => $applicationId,
                'reference_number' => $orderId
            ])->firstOrFail();

            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'transaction_id' => $paymentId,
            ]);

            // Update application status
            $application->update(['status' => 'payment_completed']);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment verified successfully',
                'payment_id' => $payment->id,
                'redirect_url' => route('documents.download-page', $application->id),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Verify payment status (for status checking)
     */
    public function checkPaymentStatus($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $payment = $application->payments()->where('status', 'completed')->first();

        return response()->json([
            'paid' => $payment ? true : false,
            'payment' => $payment,
        ]);
    }

    /**
     * Process payment (Legacy method - redirects to showPayment)
     */
    public function processPayment($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('payment.show', $application->id);
    }

    /**
     * Show payment history
     */
    public function paymentHistory()
    {
        $payments = Auth::user()->payments()->with('application')->latest()->get();
        return view('payments.history', ['payments' => $payments]);
    }
}
