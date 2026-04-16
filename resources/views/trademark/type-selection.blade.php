@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2>Select Applicant Type</h2>
                    </div>
                    <div class="card-body p-5">
                        <p class="lead mb-4">Please choose your entity type to proceed with trademark registration.</p>

                        <div class="row">
                            <!-- Individual Option -->
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('trademark.kyc', 'individual') }}" class="text-decoration-none">
                                    <div class="card h-100 border-2 text-center hover-shadow" style="transition: all 0.3s;">
                                        <div class="card-body p-4">
                                            <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                            <h3>Individual</h3>
                                            <p class="text-muted">Single person or sole proprietor</p>
                                            <button class="btn btn-primary">Choose</button>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Company Option -->
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('trademark.kyc', 'company') }}" class="text-decoration-none">
                                    <div class="card h-100 border-2 text-center hover-shadow" style="transition: all 0.3s;">
                                        <div class="card-body p-4">
                                            <i class="fas fa-building fa-3x text-success mb-3"></i>
                                            <h3>Company</h3>
                                            <p class="text-muted">Partnership or Corporation</p>
                                            <button class="btn btn-success">Choose</button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle"></i>
                            <strong>Need Help?</strong> Contact our support team for guidance on which type applies to you.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }
    </style>
@endsection
