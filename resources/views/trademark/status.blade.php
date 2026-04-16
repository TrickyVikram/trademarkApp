@extends('layouts.app')

<style>
    h3,h5 {
        font-weight: 700;
        color: white !important;
    }
</style>
@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Status Timeline -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 >Application Status Tracking</h3>
                        <small>{{ $application->application_number ?? 'Draft' }}</small>
                    </div>
                    <div class="card-body p-5">
                        <div class="alert alert-info">
                            <strong>Current Status:</strong>
                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $application->status)) }}</span>
                        </div>

                        <!-- Timeline -->
                        <div class="timeline-container">
                            <!-- Step 1 -->
                            <div
                                class="timeline-step {{ in_array($application->status, ['draft', 'payment_pending', 'payment_completed', 'pending_documents', 'pending_admin', 'approved', 'filed', 'registered']) ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="timeline-body">
                                    <h5>Application Created</h5>
                                    <p class="text-muted mb-0">{{ $application->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div
                                class="timeline-step {{ in_array($application->status, ['payment_completed', 'pending_documents', 'pending_admin', 'approved', 'filed', 'registered']) ? 'completed' : (in_array($application->status, ['payment_pending']) ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="timeline-body">
                                    <h5>Payment Completed</h5>
                                    @if ($payments = $application->payments()->where('status', 'completed')->first())
                                        <p class="text-muted mb-0">{{ $payments->paid_at->format('d M Y, H:i') }}</p>
                                        <small>Transaction: {{ $payments->transaction_id }}</small>
                                    @else
                                        <p class="text-muted mb-0">Awaiting payment...</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div
                                class="timeline-step {{ in_array($application->status, ['pending_documents', 'pending_admin', 'approved', 'filed', 'registered']) ? 'completed' : (in_array($application->status, ['payment_completed']) ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-file"></i>
                                </div>
                                <div class="timeline-body">
                                    <h5>Documents Submitted</h5>
                                    @if ($application->documents()->count())
                                        <p class="text-muted mb-1">{{ $application->documents()->count() }} documents
                                            uploaded</p>
                                        <small>All documents verified</small>
                                    @else
                                        <p class="text-muted mb-0">Awaiting document submission...</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div
                                class="timeline-step {{ in_array($application->status, ['approved', 'filed', 'registered']) ? 'completed' : (in_array($application->status, ['pending_admin']) ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="timeline-body">
                                    <h5>Admin Review</h5>
                                    @if (in_array($application->status, ['rejected']))
                                        <p class="text-danger mb-1">Application Rejected</p>
                                        <small>{{ $application->rejection_reason }}</small>
                                    @elseif(in_array($application->status, ['approved', 'filed', 'registered']))
                                        <p class="text-success mb-1">Application Approved</p>
                                    @else
                                        <p class="text-muted mb-0">Under review...</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 5 -->
                            <div
                                class="timeline-step {{ in_array($application->status, ['filed', 'registered']) ? 'completed' : (in_array($application->status, ['approved']) ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="timeline-body">
                                    <h5>Filed with Registry</h5>
                                    @if ($application->filed_at)
                                        <p class="text-muted mb-1">{{ $application->filed_at->format('d M Y, H:i') }}</p>
                                        <small>Application Number: {{ $application->application_number }}</small>
                                    @else
                                        <p class="text-muted mb-0">Awaiting filing...</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 6 -->
                            <div class="timeline-step {{ $application->status === 'registered' ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="timeline-body">
                                    <h5>Trademark Registered</h5>
                                    @if ($application->registered_at)
                                        <p class="text-muted mb-0">{{ $application->registered_at->format('d M Y, H:i') }}
                                        </p>
                                    @else
                                        <p class="text-muted mb-0">Awaiting registration approval...</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Application Summary -->
            <div class="col-md-4">
                <!-- Summary Card -->
                <div class="card shadow mb-3">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Application Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">TRADEMARK</small>
                            <p class="mb-0"><strong>{{ $application->brand_name }}</strong></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">TYPE</small>
                            <p class="mb-0"><strong>{{ ucfirst($application->entity_type) }}</strong></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">APPLICANT</small>
                            <p class="mb-0"><strong>{{ $application->applicant_name }}</strong></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">INDUSTRY</small>
                            <p class="mb-0"><strong>{{ $application->industry }}</strong></p>
                        </div>
                        @if ($application->application_number)
                            <div>
                                <small class="text-muted">APPLICATION NO.</small>
                                <p class="mb-0"><strong>{{ $application->application_number }}</strong></p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="card shadow mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        @forelse($application->payments()->get() as $payment)
                            <div class="mb-2">
                                <strong>₹{{ number_format($payment->amount, 0) }}</strong>
                                <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                            <small class="text-muted">
                                {{ $payment->paid_at ? $payment->paid_at->format('d M Y') : 'Pending' }}
                            </small>
                        @empty
                            <p class="text-muted">No payments yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- Documents Checklist -->
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Documents ({{ $application->documents()->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @forelse($application->documents()->get() as $doc)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <small>
                                    <i class="fas fa-file"></i>
                                    {{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}
                                </small>
                                <span class="badge bg-{{ $doc->status === 'verified' ? 'success' : 'warning' }}">
                                    {{ ucfirst($doc->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No documents uploaded</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline-container {
            position: relative;
            padding-left: 40px;
        }

        .timeline-step {
            position: relative;
            margin-bottom: 30px;
            opacity: 0.6;
        }

        .timeline-step.completed,
        .timeline-step.active {
            opacity: 1;
        }

        .timeline-marker {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .timeline-step.completed .timeline-marker {
            background: #28a745;
            color: white;
        }

        .timeline-step.active .timeline-marker {
            background: #007bff;
            color: white;
            animation: pulse 2s infinite;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 30px;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }
        }
    </style>
@endsection
