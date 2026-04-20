<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Trademark Registration Flow | Legal Bruz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/RegistrationGuide.css') }}">
</head>

<body>
    <!-- ============ NAVBAR ============ -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-shield-check" style="margin-right: 8px;"></i>Legal Bruz
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#flow">Flow</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('trademark.type-selection') }}">Start</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- ============ HERO ============ -->
    <section class="hero-section">
        <div class="container">
            <h1>Complete Trademark Registration Flow</h1>
            <p>Understand every step from signup to registration completion</p>
        </div>
    </section>

    <!-- ============ QUICK FLOW TIMELINE ============ -->
    <section class="flow-section" id="flow">
        <div class="container">
            <div class="section-title">
                <h2>8-Step Registration Journey</h2>
                <p>See how your trademark moves from application to registration</p>
            </div>

            <div class="flow-container">
                <div class="flow-timeline">
                    <div class="flow-step">
                        <div class="step-circle">1️⃣</div>
                        <div class="step-title">Sign Up</div>
                        <div class="step-description">Create account & receive welcome email</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">2️⃣</div>
                        <div class="step-title">Choose Type</div>
                        <div class="step-description">Individual, Company, or LLP</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">3️⃣</div>
                        <div class="step-title">Payment & Docs</div>
                        <div class="step-description">Pay 50% + view requirements</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">4️⃣</div>
                        <div class="step-title">Fill Form</div>
                        <div class="step-description">Complete application details</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">5️⃣</div>
                        <div class="step-title">Generate Docs</div>
                        <div class="step-description">Affidavit & POA created</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">6️⃣</div>
                        <div class="step-title">Admin Review</div>
                        <div class="step-description">Check & filing by admin</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">7️⃣</div>
                        <div class="step-title">Download</div>
                        <div class="step-description">Get application document</div>
                    </div>
                    <div class="flow-step">
                        <div class="step-circle">8️⃣</div>
                        <div class="step-title">Track Status</div>
                        <div class="step-description">Monitor in dashboard</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ DETAILED FLOW ============ -->
    <section style="padding: 100px 0; background: var(--light-bg);">
        <div class="container">
            <div class="section-title">
                <h2>Detailed Step-by-Step Guide</h2>
                <p>Complete information about each stage of the registration process</p>
            </div>

            <div class="detailed-steps">
                <!-- Step 1 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">1</div>
                        <div class="step-header-content">
                            <h3>User Signup & Welcome</h3>
                            <p>Account creation and email verification</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>New users register with their email and password. An automatic welcome email is sent
                            confirming their registration.</p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>What Happens</h5>
                            <ul>
                                <li>Account created in system</li>
                                <li>Verification email sent</li>
                                <li>Welcome message displayed</li>
                                <li>User dashboard ready</li>
                            </ul>
                        </div>
                        <span class="actor-badge user">User Action</span>
                        <span class="actor-badge system" style="margin-left: 10px;">System Automated</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">2</div>
                        <div class="step-header-content">
                            <h3>Choose Entity Type</h3>
                            <p>Select business structure for registration</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>User selects the appropriate entity type based on their business structure. This affects KYC
                            requirements and documentation.</p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>Available Options</h5>
                            <ul>
                                <li><strong>Individual</strong> - Self-employed professionals & solo entrepreneurs</li>
                                <li><strong>Company</strong> - Registered businesses & corporations</li>
                                <li><strong>LLP</strong> - Limited Liability Partnerships</li>
                            </ul>
                        </div>
                        <span class="actor-badge user">User Action</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">3</div>
                        <div class="step-header-content">
                            <h3>Payment & Document Requirements</h3>
                            <p>50% advance payment and document checklist</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>User reviews required documents and makes 50% advance payment. The system displays a clear
                            checklist of what documents are needed based on entity type.</p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>For Individuals</h5>
                            <ul>
                                <li>PAN Card</li>
                                <li>Address Proof (Aadhar/Passport)</li>
                                <li>Email & Phone verification</li>
                                <li>Trademark Logo (if any)</li>
                            </ul>
                        </div>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>For Companies</h5>
                            <ul>
                                <li>Certificate of Incorporation</li>
                                <li>PAN Certificate</li>
                                <li>GST Certificate (if available)</li>
                                <li>Authorized Signatory ID Proof</li>
                                <li>Trademark Logo</li>
                            </ul>
                        </div>
                        <div class="info-box">
                            <h5>💰 Payment Details</h5>
                            <p><strong>₹2,500</strong> for Individual | <strong>₹3,500</strong> for Company (50% advance
                                + 18% GST)</p>
                        </div>
                        <span class="actor-badge user">User Action</span>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">4</div>
                        <div class="step-header-content">
                            <h3>Fill Application Form</h3>
                            <p>Complete trademark registration details</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>User fills comprehensive application form with trademark details, business information, and
                            classification. The form saves automatically as they progress.</p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>Form Sections</h5>
                            <ul>
                                <li>Trademark name/mark description</li>
                                <li>Goods & services classification (Nice classes)</li>
                                <li>Business details & address</li>
                                <li>Applicant information</li>
                                <li>Contact details for correspondence</li>
                            </ul>
                        </div>
                        <span class="actor-badge user">User Action</span>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">5</div>
                        <div class="step-header-content">
                            <h3>Generate Affidavit & POA</h3>
                            <p>Auto-generate legal documents after form submission</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>After form submission, system automatically generates Affidavit (sworn statement) and Power
                            of Attorney (POA) documents based on the information provided. User can review and download.
                        </p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>Generated Documents</h5>
                            <ul>
                                <li>Affidavit (sworn statement about trademark ownership)</li>
                                <li>Power of Attorney (authorization to our legal team)</li>
                                <li>Declaration forms</li>
                                <li>All formatted as per IPO requirements</li>
                            </ul>
                        </div>
                        <span class="actor-badge system">System Automated</span>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">6</div>
                        <div class="step-header-content">
                            <h3>Admin Review & Filing</h3>
                            <p>Expert verification and official submission to IPO</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>Our expert team reviews all documents for completeness and accuracy. Once verified,
                            application is officially filed with Indian Patent Office (IPO) on behalf of the applicant.
                        </p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>Admin Verification</h5>
                            <ul>
                                <li>Check all documents for completeness</li>
                                <li>Verify trademark eligibility</li>
                                <li>Ensure correct classification</li>
                                <li>Review legal requirements</li>
                                <li>File with IPO</li>
                            </ul>
                        </div>
                        <div class="info-box">
                            <h5>⏱️ Timeline</h5>
                            <p>Usually completed within 24-48 hours of document upload</p>
                        </div>
                        <span class="actor-badge admin">Admin Action</span>
                    </div>
                </div>

                <!-- Step 7 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">7</div>
                        <div class="step-header-content">
                            <h3>Download Application</h3>
                            <p>Client receives official application document</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>After admin filing, user can download the official application document and filing receipt.
                            This document is essential for tracking and can be saved for records.</p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>Available Downloads</h5>
                            <ul>
                                <li>Official application receipt from IPO</li>
                                <li>Filing confirmation document</li>
                                <li>Application reference number</li>
                                <li>Filing date & timeline</li>
                            </ul>
                        </div>
                        <span class="actor-badge user">User Action</span>
                    </div>
                </div>

                <!-- Step 8 -->
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number-badge">8</div>
                        <div class="step-header-content">
                            <h3>Track Status in Dashboard</h3>
                            <p>Real-time monitoring and updates on registration progress</p>
                        </div>
                    </div>
                    <div class="step-content">
                        <p>User can log into their dashboard anytime to check the current status of their trademark
                            application. Real-time updates from IPO are automatically reflected.</p>
                        <div class="requirements-list">
                            <h5><i class="bi bi-check-circle" style="margin-right: 8px;"></i>Dashboard Shows</h5>
                            <ul>
                                <li>Current application status</li>
                                <li>Examination report (when available)</li>
                                <li>Any IPO queries or objections</li>
                                <li>Timeline and next steps</li>
                                <li>All uploaded documents</li>
                                <li>Payment history</li>
                            </ul>
                        </div>
                        <div class="info-box">
                            <h5>📊 Registration Timeline</h5>
                            <p><strong>6-12 months</strong> - Complete registration process (subject to examination &
                                opposition period)</p>
                        </div>
                        <span class="actor-badge system">System Live Updates</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ COMPLETE TIMELINE VIEW ============ -->
    <section style="padding: 100px 0; background: var(--white);">
        <div class="container">
            <div class="section-title">
                <h2>Complete Timeline View</h2>
                <p>Visual representation of the entire registration journey</p>
            </div>

            <div class="timeline-visual">
                <div class="timeline-line"></div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h4>🎯 Week 1: Registration & Preparation</h4>
                        <p><strong>Day 1-2:</strong> User signup and entity type selection</p>
                        <p><strong>Day 3-5:</strong> KYC verification and document submission</p>
                        <p><strong>Day 6-7:</strong> Payment and form filling</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h4>📝 Week 2: Document Generation & Admin Filing</h4>
                        <p><strong>Day 8-10:</strong> Affidavit & POA auto-generation</p>
                        <p><strong>Day 11-14:</strong> Admin review and official IPO filing</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h4>✅ Week 3: Confirmation & Monitoring</h4>
                        <p><strong>Day 15-21:</strong> Download application receipt</p>
                        <p><strong>Ongoing:</strong> Track status in dashboard</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h4>🎁 3-12 Months: IPO Processing</h4>
                        <p><strong>Examination:</strong> IPO examines your application</p>
                        <p><strong>Opposition Period:</strong> 4-month public notice period</p>
                        <p><strong>Registration:</strong> Certificate issued after 10-year term</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ KEY POINTS ============ -->
    <section style="padding: 100px 0; background: var(--light-bg);">
        <div class="container">
            <div class="section-title">
                <h2>Important Key Points</h2>
                <p>Essential information to know before starting</p>
            </div>

            <div class="row g-4" style="margin-top: 50px;">
                <div class="col-md-6">
                    <div class="info-box">
                        <h5>💡 50% Advance Payment Policy</h5>
                        <p>You pay 50% (₹2,500 for Individual) in advance. Remaining 50% is paid after admin approval
                            and before or at IPO filing. No filing happens without payment.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <h5>📋 Auto-Generated Documents</h5>
                        <p>Affidavit and POA are auto-generated based on your form inputs. You get to review them before
                            admin submission. All documents follow IPO format requirements.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <h5>⚡ Fast Admin Processing</h5>
                        <p>Admin team reviews and files your application within 24-48 hours. You don't need to manually
                            file anything - we handle IPO filing on your behalf.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <h5>📊 Real-Time Dashboard</h5>
                        <p>Your dashboard shows live updates from IPO. You'll see examination reports, any queries, and
                            exact status at every stage of the process.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <h5>📞 24/7 Support Available</h5>
                        <p>Our expert team is available 24/7 to answer your questions, clarify any confusion, and guide
                            you through the entire process.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <h5>✅ 98% Success Rate</h5>
                        <p>With our expert guidance and proper documentation, 98% of applications are approved. We
                            handle oppositions and queries professionally.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section
        style="padding: 80px 0; background: linear-gradient(135deg, var(--navy) 0%, #2d4a73 100%); color: var(--white); text-align: center;">
        <div class="container">
            <h2 style="color: var(--white); font-size: 2.5rem; margin-bottom: 20px;">Ready to Start Your Registration?
            </h2>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 40px;">Join thousands of registered trademarks.
                Complete process in just 3 weeks!</p>
            @auth
                <a href="{{ route('trademark.type-selection') }}" class="btn-primary-custom">Start Now</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary-custom">Sign Up Free</a>
            @endauth
        </div>
    </section>

    <!-- ============ FOOTER ============ -->
    <footer>
        <p>&copy; 2026 Legal Bruz - India's Fastest Trademark Registration Platform</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
