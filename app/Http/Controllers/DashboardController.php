<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show client dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $applications = $user->applications()->latest()->get();
        $pendingPayments = $applications->where('status', 'payment_pending')->count();
        $underReview = $applications->where('status', 'pending_admin')->count();
        $registered = $applications->where('status', 'registered')->count();

        return view('dashboard.index', [
            'applications' => $applications,
            'pendingPayments' => $pendingPayments,
            'underReview' => $underReview,
            'registered' => $registered,
        ]);
    }

    /**
     * Show application details
     */
    public function showApplication($applicationId)
    {
        $application = Auth::user()->applications()->findOrFail($applicationId);
        $documents = $application->documents()->get();
        $payments = $application->payments()->get();

        return view('dashboard.application-detail', [
            'application' => $application,
            'documents' => $documents,
            'payments' => $payments,
        ]);
    }
}
