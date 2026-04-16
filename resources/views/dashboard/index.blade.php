@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Dashboard Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-muted">Your Trademark Applications Dashboard</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h3 class="text-warning">{{ $pendingPayments }}</h3>
                        <p class="text-muted mb-0">Pending Payment</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h3 class="text-info">{{ $underReview }}</h3>
                        <p class="text-muted mb-0">Under Review</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h3 class="text-primary">{{ $applications->count() }}</h3>
                        <p class="text-muted mb-0">Total Applications</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h3 class="text-success">{{ $registered }}</h3>
                        <p class="text-muted mb-0">Registered</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Application Button -->
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{ route('trademark.type-selection') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Start New Trademark Application
                </a>
            </div>
        </div>

        <!-- Applications List -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">My Applications</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($applications->count())
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Trademark</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applications as $app)
                                            <tr>
                                                <td>
                                                    <strong>{{ $app->brand_name }}</strong>
                                                    @if ($app->application_number)
                                                        <br><small class="text-muted">{{ $app->application_number }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($app->entity_type) }}</td>
                                                <td>
                                                    @php
                                                        $statusColor = [
                                                            'draft' => 'secondary',
                                                            'payment_pending' => 'warning',
                                                            'payment_completed' => 'info',
                                                            'pending_documents' => 'info',
                                                            'pending_admin' => 'warning',
                                                            'approved' => 'success',
                                                            'filed' => 'primary',
                                                            'registered' => 'success',
                                                            'rejected' => 'danger',
                                                        ];
                                                    @endphp
                                                    <span class="badge bg-{{ $statusColor[$app->status] ?? 'secondary' }}">
                                                        {{ ucfirst(str_replace('_', ' ', $app->status)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $payment = $app
                                                            ->payments()
                                                            ->where('status', 'completed')
                                                            ->first();
                                                    @endphp
                                                    @if ($payment)
                                                        <span class="text-success"><i class="fas fa-check"></i> Done</span>
                                                    @else
                                                        <span class="text-warning"><i class="fas fa-clock"></i>
                                                            Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $app->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        @if ($app->status === 'payment_pending')
                                                            <a href="{{ route('payment.show', $app->id) }}"
                                                                class="btn btn-primary" title="Complete Payment">
                                                                <i class="fas fa-credit-card"></i> Pay
                                                            </a>
                                                        @elseif($app->status === 'payment_completed')
                                                            <a href="{{ route('trademark.detailed-form', $app->id) }}"
                                                                class="btn btn-info" title="Continue Application">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        @elseif($app->status === 'pending_documents')
                                                            <a href="{{ route('documents.upload', $app->id) }}"
                                                                class="btn btn-warning" title="Upload Documents">
                                                                <i class="fas fa-file"></i> Upload
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('trademark.status', $app->id) }}"
                                                            class="btn btn-info" title="View Status">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-5 text-center">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No applications yet.</p>
                                <a href="{{ route('trademark.type-selection') }}" class="btn btn-primary">
                                    Start Your First Application
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
