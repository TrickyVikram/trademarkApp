@extends('layouts.app-modern')

@section('content')
    <div class="container">
        <!-- Progress Bar -->
        <div class="progress-section">
            <div class="step-tracker">
                <div class="step-item completed">
                    <div class="step-number">1</div>
                    <div class="step-label">Type</div>
                </div>
                <div class="step-item completed">
                    <div class="step-number">2</div>
                    <div class="step-label">KYC</div>
                </div>
                <div class="step-item active">
                    <div class="step-number">3</div>
                    <div class="step-label">Form</div>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-label">Payment</div>
                </div>
                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-label">Submit</div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h2>Trademark Application Form</h2>
                        <small>Step 1: Basic Information • Entity Type: {{ ucfirst($entity_type) }}</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('trademark.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="entity_type" value="{{ $entity_type }}">

                            <!-- Section 1: Applicant Details -->
                            <h5
                                style="color: var(--navy); font-weight: 800; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid var(--border);">
                                <i class="bi bi-person-check" style="margin-right: 10px; color: var(--emerald);"></i>
                                Applicant Details
                            </h5>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="applicant_name" class="form-label required">Full Name</label>
                                    <input type="text" class="form-control @error('applicant_name') is-invalid @enderror"
                                        id="applicant_name" name="applicant_name" value="{{ old('applicant_name') }}"
                                        placeholder="Enter your full name" required>
                                    @error('applicant_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label required">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}"
                                        placeholder="your.email@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label required">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="+91 9XXXXXXXXX" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="website" class="form-label">Website / Social Media</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                        id="website" name="website" value="{{ old('website') }}"
                                        placeholder="https://example.com">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section 2: Trademark Details -->
                            <h5
                                style="color: var(--navy); font-weight: 800; margin: 35px 0 25px 0; padding-bottom: 15px; border-bottom: 2px solid var(--border);">
                                <i class="bi bi-tag" style="margin-right: 10px; color: var(--emerald);"></i>
                                Trademark Details
                            </h5>

                            <div class="mb-4">
                                <label for="brand_name" class="form-label required">Brand Name / Trademark</label>
                                <input type="text" class="form-control @error('brand_name') is-invalid @enderror"
                                    id="brand_name" name="brand_name" value="{{ old('brand_name') }}"
                                    placeholder="Enter the brand name you want to protect" required>
                                <small class="form-text">The exact name, word, or phrase you want to register</small>
                                @error('brand_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="logo" class="form-label">Logo / Image (Optional)</label>
                                <div class="file-upload-area mb-3">
                                    <i class="bi bi-image"></i>
                                    <p class="upload-text">Click to upload or drag and drop</p>
                                    <p style="font-size: 0.85rem;">PNG, JPG, JPEG, GIF, WebP • Max 2MB</p>
                                    <input type="file" class="form-control d-none @error('logo') is-invalid @enderror"
                                        id="logo" name="logo"
                                        accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
                                </div>
                                <div id="fileValidationMessage" class="small mb-2"></div>
                                <div id="filePreview" class="mb-3"></div>
                                @error('logo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label required">Description of Goods/Services</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Describe what products or services you'll use this trademark for" required>{{ old('description') }}</textarea>
                                <small class="form-text">Be specific about your goods or services</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Section 3: Business Information -->
                            <h5
                                style="color: var(--navy); font-weight: 800; margin: 35px 0 25px 0; padding-bottom: 15px; border-bottom: 2px solid var(--border);">
                                <i class="bi bi-briefcase" style="margin-right: 10px; color: var(--emerald);"></i>
                                Business Information
                            </h5>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="industry" class="form-label required">Industry / Sector</label>
                                    <input type="text" class="form-control @error('industry') is-invalid @enderror"
                                        id="industry" name="industry" value="{{ old('industry') }}"
                                        placeholder="e.g., Technology, Fashion, Food & Beverage" required>
                                    @error('industry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="usage_type" class="form-label required">Usage Scope</label>
                                    <select class="form-select @error('usage_type') is-invalid @enderror" id="usage_type"
                                        name="usage_type" required>
                                        <option value="">Select usage type</option>
                                        <option value="india" {{ old('usage_type') === 'india' ? 'selected' : '' }}>India
                                            Only</option>
                                        <option value="international"
                                            {{ old('usage_type') === 'international' ? 'selected' : '' }}>International
                                        </option>
                                        <option value="both" {{ old('usage_type') === 'both' ? 'selected' : '' }}>Both
                                            India & International</option>
                                    </select>
                                    @error('usage_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="first_use_date" class="form-label">Date of First Use (Optional)</label>
                                    <input type="date"
                                        class="form-control @error('first_use_date') is-invalid @enderror"
                                        id="first_use_date" name="first_use_date" value="{{ old('first_use_date') }}">
                                    <small class="form-text">When did you start using this brand?</small>
                                    @error('first_use_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="currently_selling" class="form-label required">Currently Using This
                                        Brand?</label>
                                    <select class="form-select @error('currently_selling') is-invalid @enderror"
                                        id="currently_selling" name="currently_selling" required>
                                        <option value="">Select an option</option>
                                        <option value="1" {{ old('currently_selling') == '1' ? 'selected' : '' }}>
                                            Yes, currently selling</option>
                                        <option value="0" {{ old('currently_selling') == '0' ? 'selected' : '' }}>No,
                                            planning to use</option>
                                    </select>
                                    @error('currently_selling')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="alert alert-info mt-5">
                                <i class="bi bi-info-circle"></i>
                                <strong>Next Step:</strong> After submitting this form, you'll need to complete a 50%
                                advance payment (₹2,500 + 18% GST) before we file your application with the IP Office.
                            </div>

                            <div class="row mt-5 g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('trademark.kyc', $entity_type) }}"
                                        class="btn btn-outline-secondary w-100 btn-lg">
                                        <i class="bi bi-arrow-left" style="margin-right: 8px;"></i>Back
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                                        Continue to Payment<i class="bi bi-arrow-right" style="margin-left: 8px;"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload drag and drop
        const fileUploadArea = document.querySelector('.file-upload-area');
        const fileInput = document.getElementById('logo');
        const fileValidationMessage = document.getElementById('fileValidationMessage');
        const filePreview = document.getElementById('filePreview');

        // Allowed MIME types and extensions
        const allowedMimes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'];
        const maxFileSize = 2 * 1024 * 1024; // 2MB (matching PHP upload_max_filesize)

        function validateFile(file) {
            // Check file type
            if (!allowedMimes.includes(file.type)) {
                fileValidationMessage.innerHTML =
                    `<span class="text-danger">❌ Invalid file type. Allowed: PNG, JPG, JPEG, GIF, WebP</span>`;
                return false;
            }

            // Check file size
            if (file.size > maxFileSize) {
                fileValidationMessage.innerHTML =
                    `<span class="text-danger">❌ File is too large. Max size: 2MB (Your file: ${(file.size / 1024 / 1024).toFixed(2)}MB)</span>`;
                return false;
            }

            fileValidationMessage.innerHTML =
                `<span class="text-success">✅ File valid: ${file.name} (${(file.size / 1024).toFixed(2)}KB)</span>`;

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview.innerHTML =
                    `<div class="mt-2"><img src="${e.target.result}" alt="Preview" style="max-width: 200px; border-radius: 8px; border: 1px solid var(--emerald);"></div>`;
            };
            reader.readAsDataURL(file);
            return true;
        }

        // Handle file input change
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    validateFile(e.target.files[0]);
                }
            });
        }

        if (fileUploadArea) {
            fileUploadArea.addEventListener('click', () => fileInput.click());

            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.style.background =
                    'linear-gradient(135deg, rgba(42, 157, 143, 0.15) 0%, rgba(42, 157, 143, 0.08) 100%)';
                fileUploadArea.style.borderColor = '#228974';
            });

            fileUploadArea.addEventListener('dragleave', () => {
                fileUploadArea.style.background =
                    'linear-gradient(135deg, rgba(42, 157, 143, 0.05) 0%, rgba(42, 157, 143, 0.02) 100%)';
                fileUploadArea.style.borderColor = 'var(--emerald)';
            });

            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileInput.files = e.dataTransfer.files;
                if (fileInput.files.length > 0) {
                    validateFile(fileInput.files[0]);
                }
                fileUploadArea.style.background =
                    'linear-gradient(135deg, rgba(42, 157, 143, 0.05) 0%, rgba(42, 157, 143, 0.02) 100%)';
                fileUploadArea.style.borderColor = 'var(--emerald)';
            });
        }
    </script>
@endsection
