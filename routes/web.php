<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TrademarkController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\UserDocumentController;

Route::get('/', function () {
    return view('home');
});

// Flow Guide (Public)
Route::get('/flow-guide', function () {
    return view('flow-guide');
})->name('flow-guide');

// ADMIN LOGIN ROUTES (Public)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CLIENT ROUTES (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/application/{id}', [DashboardController::class, 'showApplication'])->name('dashboard.application');

    // Trademark Application Flow (Modern UI)
    Route::get('/trademark/type-selection', function () {
        return view('trademark.type-selection-modern');
    })->name('trademark.type-selection');

    Route::get('/trademark/kyc/{type}', function ($type) {
        $kycRequirements = [
            'individual' => [
                'PAN Card',
                'Address Proof (Aadhar/Voter ID/Utility Bill)',
                'Email & Phone',
                'Bank Account Details (Optional)',
            ],
            'company' => [
                'Certificate of Incorporation',
                'PAN Certificate',
                'GST Registration (if available)',
                'Authorized Signatory ID Proof',
                'Company Address Proof',
            ]
        ];

        return view('trademark.kyc-checklist-modern', [
            'type' => $type,
            'requirements' => $kycRequirements[$type] ?? []
        ]);
    })->name('trademark.kyc');

    Route::get('/trademark/form/{type}', function ($type) {
        return view('trademark.application-form-modern', ['entity_type' => $type]);
    })->name('trademark.application-form');
    Route::post('/trademark/store', [TrademarkController::class, 'storeApplication'])->name('trademark.store');

    // Payment Flow (Razorpay Integration)
    Route::get('/payment/{id}', [PaymentController::class, 'showPayment'])->name('payment.show');
    Route::post('/payment/{id}/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
    Route::post('/payment/{id}/verify-signature', [PaymentController::class, 'verifySignature'])->name('payment.verify-signature');
    Route::get('/payment/{id}/check-status', [PaymentController::class, 'checkPaymentStatus'])->name('payment.check-status');
    Route::get('/payments/history', [PaymentController::class, 'paymentHistory'])->name('payment.history');

    // Application Details (After Payment)
    Route::get('/trademark/{id}/details', [TrademarkController::class, 'showDetailedForm'])->name('trademark.detailed-form');
    Route::post('/trademark/{id}/details', [TrademarkController::class, 'storeDetailedForm'])->name('trademark.store-details');

    // Document Upload
    Route::get('/documents/{id}/upload', [TrademarkController::class, 'showDocumentUpload'])->name('documents.upload');
    Route::post('/documents/{id}/store', [TrademarkController::class, 'storeDocuments'])->name('documents.store');

    // Document Download - Affidavit & POA
    Route::get('/documents/{id}/download-page', [TrademarkController::class, 'showDocumentDownload'])->name('documents.download-page');
    Route::get('/documents/{id}/affidavit/download', [TrademarkController::class, 'downloadAffidavit'])->name('documents.affidavit.download');
    Route::get('/documents/{id}/poa/download', [TrademarkController::class, 'downloadPOA'])->name('documents.poa.download');

    // Status Tracking
    Route::get('/trademark/{id}/status', [TrademarkController::class, 'showStatus'])->name('trademark.status');

    // User Documents Management
    Route::get('/my-documents', [UserDocumentController::class, 'index'])->name('user.documents');
    Route::get('/documents/{document}/view', [UserDocumentController::class, 'view'])->name('user.document.view');
    Route::get('/documents/{document}/download', [UserDocumentController::class, 'download'])->name('user.document.download');
    Route::post('/documents/upload-signed', [UserDocumentController::class, 'uploadSigned'])->name('user.document.upload-signed');
    Route::get('/documents/list', [UserDocumentController::class, 'listDocuments'])->name('user.documents.list');
});

// ADMIN ROUTES (Protected by admin middleware - to be created)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/applications', [AdminController::class, 'listPendingApplications'])->name('admin.applications');
    Route::get('/applications/all', [AdminController::class, 'listAllApplications'])->name('admin.all-applications');
    Route::get('/application/{id}', [AdminController::class, 'viewApplication'])->name('admin.view-application');
    Route::get('/application/{id}/review', [AdminController::class, 'viewApplication'])->name('admin.review-application');

    // Approval/Rejection
    Route::post('/application/{id}/approve', [AdminController::class, 'approveApplication'])->name('admin.approve');
    Route::post('/application/{id}/reject', [AdminController::class, 'rejectApplication'])->name('admin.reject');

    // Filing
    Route::post('/application/{id}/file', [AdminController::class, 'fileApplication'])->name('admin.file');
    Route::post('/application/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.update-status');
});
