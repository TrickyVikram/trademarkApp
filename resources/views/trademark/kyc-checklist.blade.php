@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2>KYC Checklist - {{ ucfirst($type) }}</h2>
                    </div>
                    <div class="card-body p-5">
                        <p class="lead mb-4">Please prepare the following documents for verification:</p>

                        <div class="list-group mb-4">
                            @foreach ($requirements as $req)
                                <div class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="doc{{ $loop->index }}"
                                            disabled>
                                        <label class="form-check-label" for="doc{{ $loop->index }}">
                                            <strong>{{ $req }}</strong>
                                            <small class="text-muted d-block">Scanned copy required for verification</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Note:</strong> All documents must be clear, valid, and properly scanned for
                            verification.
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('trademark.type-selection') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('trademark.application-form', $type) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-arrow-right"></i> Proceed
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
