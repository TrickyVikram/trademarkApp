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
                                <p class="mb-0">{{ $application->user->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color: #1D3557; font-weight: 600;">Submitted</label>
                                <p class="mb-0">{{ $application->created_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Card -->
                @if ($application->documents && $application->documents->count() > 0)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header" style="background-color: #2A9D8F; color: white;">
                            <h5 class="mb-0">📄 Generated Documents ({{ $application->documents->count() }})</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach ($application->documents as $doc)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>📄 {{ $doc->document_type }}</strong>
                                                <br>
                                                <small class="text-muted">{{ basename($doc->file_path) }}</small>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">
                                                    👁️ View
                                                </a>
                                                <a href="{{ Storage::url($doc->file_path) }}" download
                                                    class="btn btn-sm btn-success">
                                                    ⬇️ Download
                                                </a>
                                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-warning">
                                                    ✏️ Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
                                            @else
                                                <span class="badge bg-warning text-dark">⏳
                                                    {{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
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
                        @if ($application->status === 'pending_admin')
                            <!-- Approve Form -->
                            <form action="{{ route('admin.approve', $application->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="color: #1D3557; font-weight: 600;">Notes
                                        (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100"
                                    onclick="return confirm('Are you sure you want to approve this application?')">
                                    ✅ Approve Application
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form action="{{ route('admin.reject', $application->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="color: #1D3557; font-weight: 600;">Rejection Reason
                                        *</label>
                                    <textarea name="rejection_reason" class="form-control" rows="3" required
                                        placeholder="Please provide a reason for rejection..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Are you sure you want to reject this application?')">
                                    ❌ Reject Application
                                </button>
                            </form>
                        @elseif ($application->status === 'approved')
                            <div class="alert alert-success mb-3">
                                <strong>✅ Approved!</strong><br>
                                <small>Affidavit & POA documents have been generated and are available below. Click "Edit"
                                    to modify them if needed.</small>
                            </div>
                            <form action="{{ route('admin.file', $application->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm w-100"
                                    onclick="return confirm('Mark this application as filed with IP authorities?')">
                                    📁 File Application
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                <small>This application is at
                                    <strong>{{ ucfirst(str_replace('_', ' ', $application->status)) }}</strong>
                                    status.</small>
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
