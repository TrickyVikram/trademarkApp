<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Admin;
use App\Services\DocumentGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $application->update([
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Application approved! Affidavit & POA have been generated automatically.');
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

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // TODO: Send rejection email to user

        return redirect()->back()->with('success', 'Application rejected!');
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
}
