@extends('layouts.app')

<style>
    h3,h5 {
        font-weight: 700;
        color: white !important;
    }
    .timeline-body h5{
        color: #343a40 !important;
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
                            <small class="text-muted">CLASSES</small>
                            @if($application->classes)
                                @php
                                    $classLabels = [
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
                                    // Decode classes if it's a string (JSON)
                                    $classes = is_string($application->classes) ? json_decode($application->classes, true) : $application->classes;
                                @endphp
                              <div>
    @if(is_array($classes) && count($classes) > 0)
        @foreach($classes as $classNum)
            <span 
                class="badge bg-primary me-1 mb-1 class-badge-tooltip"
                title="{{ $classLabels[$classNum] ?? ('Class ' . $classNum) }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
            >
                Class {{ $classNum }}
            </span>
        @endforeach
    @else
        <p class="mb-0 text-muted">Not selected</p>
    @endif
</div>
                            @else
                                <p class="mb-0 text-muted">Not selected</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">INDUSTRY</small>
                            <p class="mb-0"><strong>{{ $application->industry }}</strong></p>
                        </div>
                        @if ($application->application_number)
                            <div class="mb-3">
                                <small class="text-muted">APPLICATION NO.</small>
                                <p class="mb-0"><strong>{{ $application->application_number }}</strong></p>
                            </div>
                        @endif
                        <!-- @if ($application->usage)
                            <div class="mb-3">
                                <small class="text-muted">TRADEMARK STATUS</small>
                                <p class="mb-0"><strong>{{ ucfirst($application->usage) === 'Used' ? 'Already in Use' : 'Proposed to be Used' }}</strong></p>
                            </div>
                        @endif
                        @if ($application->goods_services)
                            <div>
                                <small class="text-muted">GOODS & SERVICES</small>
                                <p class="mb-0"><small>{{ $application->goods_services }}</small></p>
                            </div>
                        @endif -->
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
