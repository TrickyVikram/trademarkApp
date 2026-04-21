@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0" style="color: #1D3557;">📋 Application Details</h1>
                        <p class="text-muted mb-0">Application #{{ $application->id }}</p>
                    </div>
                    <a href="{{ route('admin.applications') }}" class="btn btn-outline-secondary btn-sm">
                        ← Back to Pending
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✅ Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>❌ Error!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Main Application Info -->
            <div class="col-md-8">
                <!-- Application Details Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header" style="background-color: #2A9D8F; color: white;">
                        <h5 class="mb-0">📝 Application Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Trademark Name</label>
                                <p class="mb-0">{{ $application->brand_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Status</label>
                                <p class="mb-0">
                                    @switch($application->status)
                                        @case('pending_admin')
                                            <span class="badge bg-warning text-dark">⏳ Pending Review</span>
                                        @break

                                        @case('approved')
                                            <span class="badge bg-success">✅ Approved</span>
                                        @break

                                        @case('filed')
                                            <span class="badge bg-info">📁 Filed</span>
                                        @break

                                        @case('registered')
                                            <span class="badge bg-success">🏆 Registered</span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger">❌ Rejected</span>
                                        @break
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Industry</label>
                                <p class="mb-0">{{ $application->industry ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Type</label>
                                <p class="mb-0">{{ ucfirst($application->type ?? 'N/A') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Description</label>
                                <p class="mb-0">{{ $application->description ?? 'No description provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicant Details Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header" style="background-color: #2A9D8F; color: white;">
                        <h5 class="mb-0">👤 Applicant Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Name</label>
                                <p class="mb-0">{{ $application->user->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Email</label>
                                <p class="mb-0">{{ $application->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Phone</label>
                                <p class="mb-0">{{ $application->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Submitted</label>
                                <p class="mb-0">{{ $application->created_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manual Document Generation Card -->
                <!-- <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header" style="background-color: #E76F51; color: white;">
                        <h5 class="mb-0">⚙️ Manual Document Generation</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3"><small>Generate documents individually for review:</small></p>
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('admin.generate-affidavit', $application->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm w-100"
                                        onclick="return confirm('Generate Affidavit document?')">
                                        📋 Generate Affidavit
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.generate-poa', $application->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm w-100"
                                        onclick="return confirm('Generate POA document?')">
                                        ✍️ Generate POA
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Generated Documents Status Card -->
                @if ($application->documents && $application->documents->count() > 0)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header" style="background-color: #2A9D8F; color: white;">
                            <h5 class="mb-0">📄 Generated Documents ({{ $application->documents->count() }})</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group mb-3">
                                @foreach ($application->documents as $doc)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div style="flex: 1;">
                                                <strong>📄 {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ basename($doc->file_path) }}</small>
                                                <br>
                                                <span class="badge bg-info mt-2">
                                                    @if($doc->status === 'generated')
                                                        ✏️ Auto-Generated - Pending Review
                                                    @elseif($doc->status === 'approved')
                                                        ✅ Approved - Ready for User
                                                    @elseif($doc->status === 'uploaded')
                                                        📤 User Uploaded - Verified
                                                    @elseif($doc->status === 'pending')
                                                        ⏳ Pending Verification
                                                    @else
                                                        {{ ucfirst($doc->status) }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="d-flex gap-2 ms-3" style="flex-shrink: 0;">
                                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info" title="View document">
                                                    view
                                                </a>
                                                <a href="{{ Storage::url($doc->file_path) }}" download
                                                    class="btn btn-sm btn-info " title="Download document">
                                                    download
                                                </a>
                                                
                                                <!-- Approve Button -->
                                                @if($doc->status === 'pending')
                                                    <form action="{{ route('admin.approve-document', $doc->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info" title="Approve this document"
                                                            onclick="return confirm('Approve this {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}?')">
                                                            approve
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <!-- Verify Button (for uploaded signed documents) -->
                                                @if($doc->status === 'uploaded')
                                                    <form action="{{ route('admin.verify-document', $doc->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info " title="Verify this document"
                                                            onclick="return confirm('Mark this document as verified?')">
                                                            verify
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <!-- Reject Button -->
                                                @if($doc->status === 'pending' || $doc->status === 'approved')
                                                    <form action="{{ route('admin.reject-document', $doc->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm " title="Reject this document"
                                                            onclick="return confirm('Reject this {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}?')">
                                                            ❌
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Approve/Reject Buttons -->
                            @if ($application->status === 'pending_admin')
                                <hr>
                                <p class="mb-3 text-muted"><small>📋 Ready to approve? Documents will be auto-generated for download:</small></p>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Approve Form -->
                                        <form action="{{ route('admin.approve', $application->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Notes (Optional)</label>
                                                <textarea name="notes" class="form-control form-control-sm" rows="2"
                                                    placeholder="Add any notes..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm w-100"
                                                onclick="return confirm('Approve these documents? User will be able to download them.')">
                                                ✅ Approve & Generate Documents
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Reject Form -->
                                        <form action="{{ route('admin.reject', $application->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Reason *</label>
                                                <textarea name="rejection_reason" class="form-control form-control-sm" rows="2" required
                                                    placeholder="Why are you rejecting?"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                                onclick="return confirm('Reject these documents?')">
                                                ❌ Reject & Request Changes
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @elseif ($application->status === 'approved')
                                <div class="alert alert-success mb-0">
                                    <strong>✅ Approved!</strong><br>
                                    <small>Documents are approved. User can now download and upload signed versions.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Payments Card -->
                @if ($application->payments && $application->payments->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header" style="background-color: #2A9D8F; color: white;">
                            <h5 class="mb-0">💳 Payment Information</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($application->payments as $payment)
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #1D3557; font-weight: 600;">Amount
                                            Paid</label>
                                        <p class="mb-0">₹{{ number_format($payment->amount, 2) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #1D3557; font-weight: 600;">Status</label>
                                        <p class="mb-0">
                                            @if ($payment->status === 'completed')
                                                <span class="badge bg-success">✅ Completed</span>
                                            @elseif ($payment->status === 'approved')
                                                <span class="badge bg-success">✅ Approved</span>
                                            @elseif ($payment->status === 'rejected')
                                                <span class="badge bg-danger">❌ Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">⏳
                                                    {{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #1D3557; font-weight: 600;">Date</label>
                                        <p class="mb-0">{{ $payment->created_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #1D3557; font-weight: 600;">Transaction
                                            ID</label>
                                        <p class="mb-0 text-truncate" title="{{ $payment->razorpay_payment_id }}">
                                            {{ $payment->razorpay_payment_id ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Payment Action Buttons -->
                                @if ($payment->status === 'completed')
                                    <div class="d-grid gap-2 mb-3">
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#approvePaymentModal{{ $payment->id }}">
                                            ✅ Approve Payment
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#rejectPaymentModal{{ $payment->id }}">
                                            ❌ Reject Payment
                                        </button>
                                    </div>

                                    <!-- Approve Payment Modal -->
                                    <div class="modal fade" id="approvePaymentModal{{ $payment->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">✅ Approve Payment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.approve-payment', $payment->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to approve this payment of <strong>₹{{ number_format($payment->amount, 2) }}</strong>?</p>
                                                        <p class="text-muted mb-0"><small>The user will be notified via email and in-app notification.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">✅ Approve</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Payment Modal -->
                                    <div class="modal fade" id="rejectPaymentModal{{ $payment->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">❌ Reject Payment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.reject-payment', $payment->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="rejection_reason" rows="4" placeholder="Please provide a reason for rejecting this payment..." required></textarea>
                                                        <small class="text-muted d-block mt-2">The user will be notified with this reason.</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">❌ Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($payment->status === 'rejected')
                                    <div class="alert alert-danger mb-3">
                                        <strong>❌ Rejected</strong><br>
                                        <small><strong>Reason:</strong> {{ $payment->rejection_reason }}</small>
                                    </div>
                                @elseif ($payment->status === 'approved')
                                    <div class="alert alert-success mb-3">
                                        <strong>✅ Approved on {{ $payment->approved_at->format('M d, Y') }}</strong>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions Sidebar -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="position: sticky; top: 20px;">
                    <div class="card-header" style="background-color: #2A9D8F; color: white;">
                        <h5 class="mb-0">⚙️ Actions</h5>
                    </div>
                    <div class="card-body">
                        @if ($application->status === 'approved')
                            <div class="alert alert-success mb-3">
                                <strong>✅ Approved!</strong><br>
                                <small>Documents approved. Waiting for user to upload signed versions.</small>
                            </div>
                            
                            @php
                                // Check if key documents are verified (Affidavit (Signed) and POA (Signed))
                                $affidavitSigned = $application->documents
                                    ->where('document_type', 'affidavit (Signed)')
                                    ->where('status', 'verified')
                                    ->first();
                                
                                $poaSigned = $application->documents
                                    ->where('document_type', 'poa (Signed)')
                                    ->where('status', 'verified')
                                    ->first();
                                
                                $canFile = ($affidavitSigned && $poaSigned);
                            @endphp
                            
                            @if($canFile)
                                <div class="alert alert-info mb-3">
                                    <strong>✔️ Ready to File!</strong><br>
                                    <small>All required documents (Affidavit & POA) are verified and signed.</small>
                                </div>
                                <form action="{{ route('admin.file', $application->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm w-100"
                                        onclick="return confirm('Mark this application as filed with IP authorities?')">
                                        📁 File Application
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-warning mb-3">
                                    <strong>⏳ Awaiting Signed Documents</strong><br>
                                    <small>
                                        @if(!$affidavitSigned)
                                            ❌ Affidavit (Signed) - Not verified<br>
                                        @else
                                            ✔️ Affidavit (Signed) - Verified<br>
                                        @endif
                                        @if(!$poaSigned)
                                            ❌ POA (Signed) - Not verified
                                        @else
                                            ✔️ POA (Signed) - Verified
                                        @endif
                                    </small>
                                </div>
                                <button type="button" class="btn btn-info btn-sm w-100" disabled>
                                    📁 File Application (Pending verification)
                                </button>
                            @endif
                        @elseif ($application->status === 'rejected')
                            <div class="alert alert-danger mb-3">
                                <strong>❌ Rejected!</strong><br>
                                <small>{{ $application->rejection_reason ?? 'Documents rejected. User needs to resubmit.' }}</small>
                            </div>
                        @elseif ($application->status === 'filed')
                            <div class="alert alert-info mb-3">
                                <strong>📁 Filed!</strong><br>
                                <small>Application has been filed with the IP authorities.</small>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <small>👆 Review documents above and take action to Approve or Reject.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .list-group-item-action:hover {
            background-color: #f8f9fa !important;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
