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
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('gender', $application->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $application->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $application->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nationality') is-invalid @enderror"
                                        id="nationality" name="nationality"
                                        value="{{ old('nationality', $application->nationality) }}" placeholder="e.g., Indian" required>
                                    @error('nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" rows="2" required>{{ old('address', $application->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
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

                            <!-- Logo Display -->
                            @if($application->logo_path)
                                <div class="mb-4">
                                    <label class="form-label">Brand Logo</label>
                                    <div class="card border-light">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('storage/' . $application->logo_path) }}" 
                                                alt="Brand Logo" 
                                                style="max-width: 100%; max-height: 300px; object-fit: contain; border: 1px solid #dee2e6; padding: 10px; border-radius: 5px;">
                                            <p class="text-muted mt-2"><small>Logo size: Upload during application</small></p>
                                        </div>
                                    </div>
                                </div>
                            @endif

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
                            <div class="mb-4">
                                <label class="form-label">Select Classes <span class="text-danger">*</span></label>
                                <div class="form-text mb-3">Search and select all applicable classes for your trademark:</div>

                                <!-- Search Dropdown -->
                                <div class="mb-3">
                                    <select class="form-select" id="classSearchDropdown" data-placeholder="Search and select a class...">
                                        <option value="">-- Search by class number or name --</option>
                                        @php
                                            $trademarkClasses = [
                                                '1' => 'Class 1: Chemicals - Chemical products for use in industry, science and agriculture',
                                                '2' => 'Class 2: Paints - Paints, varnishes and lacquers; preservatives against rust and deterioration',
                                                '3' => 'Class 3: Cosmetics - Bleaching preparations and detergents for use in manufacturing',
                                                '4' => 'Class 4: Industrial oils - Industrial oils and greases; fuels; dust absorbing agents',
                                                '5' => 'Class 5: Pharmaceuticals - Pharmaceutical preparations and medical products',
                                                '6' => 'Class 6: Metals - Metals and metal alloys; metal ores for smelting',
                                                '7' => 'Class 7: Machinery - Machines, machine tools, motors and engines',
                                                '8' => 'Class 8: Hand tools - Hand-operated tools and implements; cutlery',
                                                '9' => 'Class 9: Electronics - Electrical and electronic apparatus and instruments',
                                                '10' => 'Class 10: Medical devices - Surgical and medical apparatus and instruments',
                                                '11' => 'Class 11: Lighting - Installation, apparatus for lighting, heating, steam generation',
                                                '12' => 'Class 12: Vehicles - Vehicles; apparatus for locomotion by land, air or water',
                                                '13' => 'Class 13: Explosives - Firearms; ammunition and projectiles; pyrotechnic articles',
                                                '14' => 'Class 14: Jewelry - Precious metals and their alloys; jewelry; horological articles',
                                                '15' => 'Class 15: Musical instruments - Musical instruments and parts and accessories',
                                                '16' => 'Class 16: Paper products - Paper, cardboard and goods made of these materials',
                                                '17' => 'Class 17: Rubber products - Rubber, gutta-percha, gum, asbestos, mica and articles',
                                                '18' => 'Class 18: Leather goods - Leather and imitation leather; articles made of these',
                                                '19' => 'Class 19: Building materials - Non-metallic mineral building materials and materials',
                                                '20' => 'Class 20: Furniture - Furniture and goods not included in other classes',
                                                '21' => 'Class 21: Household items - Household or kitchen utensils and containers',
                                                '22' => 'Class 22: Textiles - Ropes, string, nets, tents, awnings, tarpaulins and sails',
                                                '23' => 'Class 23: Yarns - Yarns and threads for textile use',
                                                '24' => 'Class 24: Fabrics - Textiles and substitutes for textiles',
                                                '25' => 'Class 25: Clothing - Clothing, footwear, headgear',
                                                '26' => 'Class 26: Accessories - Lace, braid and embroidery; haberdashery',
                                                '27' => 'Class 27: Floor coverings - Floor coverings',
                                                '28' => 'Class 28: Sports equipment - Games, toys and playthings; sports equipment',
                                                '29' => 'Class 29: Meat & dairy - Meat, fish, poultry and game; meat extracts',
                                                '30' => 'Class 30: Foodstuffs - Coffee, tea, cocoa and coffee substitutes; cereals',
                                                '31' => 'Class 31: Agricultural products - Animal feed; seeds for agriculture and gardening',
                                                '32' => 'Class 32: Beverages - Beverages including alcohol',
                                                '33' => 'Class 33: Spirits - Alcoholic beverages (except beers)',
                                                '34' => 'Class 34: Tobacco - Tobacco and tobacco substitutes; smokers\' articles',
                                                '35' => 'Class 35: Advertising - Advertising; business and retail services',
                                                '36' => 'Class 36: Insurance - Insurance; financial and monetary affairs',
                                                '37' => 'Class 37: Construction - Building construction; repair; installation services',
                                                '38' => 'Class 38: Telecommunications - Telecommunications services',
                                                '39' => 'Class 39: Transport - Transport; travel organization services',
                                                '40' => 'Class 40: Materials processing - Treatment of materials by physical and chemical',
                                                '41' => 'Class 41: Education - Education; entertainment; sports activities',
                                                '42' => 'Class 42: Scientific services - Scientific and technology services; design services',
                                                '43' => 'Class 43: Catering - Food and beverage services; temporary accommodation',
                                                '44' => 'Class 44: Medical services - Medical services; veterinary services; hygienic care',
                                                '45' => 'Class 45: Legal services - Legal services; security services; personal and social',
                                            ];
                                        @endphp

                                        @foreach ($trademarkClasses as $classNumber => $classDesc)
                                            <option value="{{ $classNumber }}" data-description="{{ $classDesc }}">
                                                {{ $classDesc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Selected Classes Display -->
                                <div class="card border-light">
                                    <div class="card-body">
                                        <!-- <h6 class="card-title mb-3">Selected Classes:</h6> -->
                                        <div id="selectedClassesContainer">
                                            <ul class="list-unstyled">
                                                @foreach (old('classes', []) as $class)
                                                    <li>{{ $trademarkClasses[$class] ?? $class }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden inputs wrapper -->
                                <div id="hiddenClassesWrapper"></div>

                                @error('classes')
                                    <div class="text-danger mt-2">{{ $message }}</div>
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

                            <!-- Trademark Usage Status -->
                            <div class="mb-3">
                                <label for="usage" class="form-label">Trademark Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('usage') is-invalid @enderror" id="usage" name="usage" required>
                                    <option value="">Select whether your trademark is already in use or proposed to be used</option>
                                    <option value="used" {{ old('usage') === 'used' ? 'selected' : '' }}>Already in Use</option>
                                    <option value="proposed" {{ old('usage') === 'proposed' ? 'selected' : '' }}>Proposed to be Used</option>
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

    <!-- Add Select2 for searchable dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .selected-class-badge {
            display: inline-flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            margin: 5px;
            font-size: 14px;
        }

        .selected-class-badge .remove-btn {
            cursor: pointer;
            margin-left: 8px;
            font-weight: bold;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .selected-class-badge .remove-btn:hover {
            opacity: 1;
        }
    </style>

    <script>
        $(document).ready(function() {
            var selectedClasses = {};

            $('#classSearchDropdown').select2({
                placeholder: 'Search and select a class...',
                width: '100%',
                allowClear: false,
                language: {
                    noResults: function() {
                        return 'No classes found';
                    }
                }
            });

            $('#classSearchDropdown').on('change', function() {
                var classNumber = $(this).val();

                if (classNumber && !selectedClasses[classNumber]) {
                    var classText = $(this).find('option:selected').data('description');
                    selectedClasses[classNumber] = classText;
                    updateClassesDisplay();
                }

                $(this).val('').trigger('change.select2');
            });

            $(document).on('click', '.remove-btn', function() {
                var classNumber = $(this).data('class-number');
                delete selectedClasses[classNumber];
                updateClassesDisplay();
            });

            function updateClassesDisplay() {
                var container = $('#selectedClassesContainer');
                var hiddenWrapper = $('#hiddenClassesWrapper');

                container.empty();
                hiddenWrapper.empty();

                if (Object.keys(selectedClasses).length === 0) {
                    container.html(
                        '<div class="alert alert-secondary mb-0"><small>No classes selected yet. Select from dropdown above.</small></div>'
                    );
                    return;
                }

                var html = '<div style="display:flex; flex-wrap:wrap; gap:8px;">';

                $.each(selectedClasses, function(classNumber, classText) {
                    html += '<div class="selected-class-badge">' +
                        classText.split(' - ')[0] +
                        '<span class="remove-btn" data-class-number="' + classNumber + '" title="Remove">✕</span>' +
                        '</div>';

                    hiddenWrapper.append(
                        '<input type="hidden" name="classes[]" value="' + classNumber + '">'
                    );
                });

                html += '</div>';
                container.html(html);
            }

            $('form').on('submit', function(e) {
                if (Object.keys(selectedClasses).length === 0) {
                    e.preventDefault();
                    alert('Please select at least one trademark class.');
                    $('#classSearchDropdown').focus();
                    return false;
                }
            });

            @if (is_array(old('classes')))
                @foreach (old('classes') as $classNumber)
                    var option = $('#classSearchDropdown').find('option[value="{{ $classNumber }}"]');
                    if (option.length > 0) {
                        selectedClasses['{{ $classNumber }}'] = option.data('description');
                    }
                @endforeach
                updateClassesDisplay();
            @endif
        });
    </script>
@endsection