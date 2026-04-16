@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3>Application Details</h3>
                        <small>Step 3: Enter Application Information</small>
                    </div>
                    <div class="card-body p-5">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Payment Successful!</strong> Your 50% advance payment has been received. Now please
                            provide detailed information.
                        </div>

                        <form action="{{ route('trademark.store-details', $application->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-3">Applicant Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="applicant_name" class="form-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('applicant_name') is-invalid @enderror"
                                        id="applicant_name" name="applicant_name"
                                        value="{{ old('applicant_name', $application->applicant_name) }}" required>
                                    @error('applicant_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="brand_name" class="form-label">Brand Name / Trademark <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('brand_name') is-invalid @enderror"
                                        id="brand_name" name="brand_name"
                                        value="{{ old('brand_name', $application->brand_name) }}" required>
                                    @error('brand_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trademark Details -->
                            <h5 class="mb-3 mt-4">Trademark Details</h5>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" required>{{ old('description', $application->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Classes Selection -->
                            <div class="mb-3">
                                <label class="form-label">Select Classes <span class="text-danger">*</span></label>
                                <div class="form-text mb-2">Select all applicable classes for your trademark:</div>
                                <div class="row">
                                    @foreach (['Class 1: Chemicals', 'Class 3: Cosmetics', 'Class 5: Pharmaceuticals', 'Class 6: Metals', 'Class 25: Clothing', 'Class 35: Advertising'] as $class)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="classes[]"
                                                    value="{{ $loop->index }}" id="class{{ $loop->index }}">
                                                <label class="form-check-label" for="class{{ $loop->index }}">
                                                    {{ $class }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('classes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Goods/Services -->
                            <div class="mb-3">
                                <label for="goods_services" class="form-label">Goods & Services Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('goods_services') is-invalid @enderror" id="goods_services" name="goods_services"
                                    rows="3" required placeholder="Describe the goods or services">{{ old('goods_services') }}</textarea>
                                @error('goods_services')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Usage -->
                            <div class="mb-3">
                                <label for="usage" class="form-label">Trademark Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('usage') is-invalid @enderror" id="usage"
                                    name="usage" required>
                                    <option value="">Select status</option>
                                    <option value="used" {{ old('usage') === 'used' ? 'selected' : '' }}>Already in Use
                                    </option>
                                    <option value="proposed" {{ old('usage') === 'proposed' ? 'selected' : '' }}>Proposed
                                        to be Used</option>
                                </select>
                                @error('usage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle"></i>
                                <strong>Next Step:</strong> After submitting this form, you'll upload all required documents
                                for verification.
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <a href="{{ route('payment.history') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-arrow-right"></i> Continue to Documents
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
