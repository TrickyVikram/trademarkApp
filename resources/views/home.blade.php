<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legal Bruz - IPR & Trademark Registration | India's Fastest Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/RegistrationGuide.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- ============ NAVBAR ============ -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('logo.png') }}" alt="Legal Bruz " sizes="(max-width: 768px) 100vw, 50px"
                    srcset="{{ asset('logo.png') }} 1x, {{ asset('logo.png') }} 2x">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#why-us">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Reviews</a>
                    </li>
                    <li class="nav-item ms-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-nav-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
                            <a href="{{ route('register') }}" class="btn-nav-primary ms-2">Sign Up</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ============ HERO SECTION ============ -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Register Your <span>Trademark</span> in Days, Not Months</h1>
                    <p class="hero-subtitle">
                        India's fastest IPR platform. File Trademark, Copyright & Patent with expert guidance.
                        Get approved 50% faster with our hassle-free process.
                    </p>

                    <div class="hero-cta">
                        @auth
                            <a href="{{ route('trademark.type-selection') }}" class="btn-hero btn-hero-primary">
                                <i class="bi bi-arrow-right" style="margin-right: 8px;"></i>Start Registration
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">
                                <i class="bi bi-arrow-right" style="margin-right: 8px;"></i>Get Started Free
                            </a>
                        @endauth
                        <a href="#services" class="btn-hero btn-hero-secondary">
                            <i class="bi bi-play-circle" style="margin-right: 8px;"></i>See How It Works
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div class="stat">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Applications Filed</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Success Rate</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">₹2,500</div>
                            <div class="stat-label">Starting Price</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <div style="font-size: 200px; color: rgba(255,255,255,0.12); line-height: 1;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TRUST BADGES ============ -->
    <section class="trust-section">
        <div class="container">
            <div class="trust-content">
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-check2"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: var(--navy);">Govt Verified</div>
                        <div style="font-size: 0.85rem;">Filed with IPO</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: var(--navy);">48 Hour Filing</div>
                        <div style="font-size: 0.85rem;">Quick processing</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: var(--navy);">24/7 Support</div>
                        <div style="font-size: 0.85rem;">Expert guidance</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: var(--navy);">100% Secure</div>
                        <div style="font-size: 0.85rem;">Data protected</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SERVICES SECTION ============ -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-header">
                <h2>Our Services</h2>
                <p>Complete IPR protection solutions tailored for every business size and need</p>
            </div>

            <div class="row g-4">
                <!-- Trademark -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">™️</div>
                        <h4>Trademark Registration</h4>
                        <p>Protect your brand name, logo, and slogan with our comprehensive registration service.</p>
                        <ul class="service-features">
                            <li>Trademark Search & Report</li>
                            <li>Application Filing</li>
                            <li>Opposition Reply</li>
                            <li>10 Year Protection</li>
                            <li>Renewal Support</li>
                        </ul>
                        @auth
                            <a href="{{ route('trademark.type-selection') }}" class="service-btn">Apply Now</a>
                        @else
                            <a href="{{ route('register') }}" class="service-btn">Get Started</a>
                        @endauth
                    </div>
                </div>

                <!-- Copyright -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">©️</div>
                        <h4>Copyright Registration</h4>
                        <p>Safeguard your creative works - music, art, literature, software, and designs.</p>
                        <ul class="service-features">
                            <li>Instant Registration</li>
                            <li>Certificate Generation</li>
                            <li>Lifetime Protection</li>
                            <li>Infringement Support</li>
                            <li>Digital Archive</li>
                        </ul>
                        <button class="service-btn"
                            style="background: var(--slate); cursor: not-allowed; opacity: 0.7;">Coming Soon</button>
                    </div>
                </div>

                <!-- Patent -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon">🔬</div>
                        <h4>Patent Registration</h4>
                        <p>Secure your innovations with provisional and complete patent protection.</p>
                        <ul class="service-features">
                            <li>Prior Art Search</li>
                            <li>Provisional Filing</li>
                            <li>Complete Application</li>
                            <li>Expert Review</li>
                            <li>20 Year Protection</li>
                        </ul>
                        <button class="service-btn"
                            style="background: var(--slate); cursor: not-allowed; opacity: 0.7;">Coming Soon</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PROCESS SECTION ============ -->
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

            <div style="text-align: center; margin-top: 60px;">
                <a href="/flow-guide" class="btn btn-lg"
                    style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; font-weight: 700; padding: 15px 50px; border-radius: 8px; text-decoration: none; display: inline-block; transition: all 0.3s ease;">
                    <i class="bi bi-arrow-right" style="margin-right: 8px;"></i>View Complete Flow Guide
                </a>
            </div>
        </div>
    </section>

    <!-- ============ BENEFITS SECTION ============ -->
    <section class="benefits-section" id="why-us">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose Legal Bruz ?</h2>
                <p>We make trademark registration simple, affordable, and guaranteed</p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">⚡</div>
                    <h5>Lightning Fast</h5>
                    <p>Get approved within 48 hours of document submission with zero delays</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">💯</div>
                    <h5>100% Legal</h5>
                    <p>All documents prepared by certified legal professionals with expertise</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">💰</div>
                    <h5>Transparent Pricing</h5>
                    <p>Simple flat pricing with 50% upfront. No hidden charges ever</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">📱</div>
                    <h5>24/7 Support</h5>
                    <p>Chat, email, or phone. Our experts are always available to help</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">📊</div>
                    <h5>Live Tracking</h5>
                    <p>Monitor your application status in real-time from your dashboard</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">🎯</div>
                    <h5>Guaranteed Success</h5>
                    <p>98% success rate with expert guidance at every step</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PRICING SECTION ============ -->
    <section class="pricing-section" id="pricing">
        <div class="container">
            <div class="section-header">
                <h2>Simple, Transparent Pricing</h2>
                <p>Choose the perfect plan for your business needs</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card">
                    <h4>Individual</h4>
                    <p class="pricing-description">Perfect for startups and freelancers</p>
                    <div class="pricing-amount">₹2,500</div>
                    <p class="pricing-period">50% Advance • +18% GST</p>
                    <ul class="pricing-features">
                        <li>KYC Verification</li>
                        <li>Single Class Filing</li>
                        <li>Documents Prepared</li>
                        <li>Admin Review</li>
                        <li>Email Support</li>
                    </ul>
                    @auth
                        <a href="{{ route('trademark.type-selection') }}" class="pricing-btn">Apply Now</a>
                    @else
                        <a href="{{ route('register') }}" class="pricing-btn">Get Started</a>
                    @endauth
                </div>

                <div class="pricing-card featured">
                    <div class="pricing-badge">Most Popular</div>
                    <h4>Company</h4>
                    <p class="pricing-description">Best for established businesses</p>
                    <div class="pricing-amount">₹3,500</div>
                    <p class="pricing-period">50% Advance • +18% GST</p>
                    <ul class="pricing-features">
                        <li>Multi-Class Filing</li>
                        <li>Affidavit & POA</li>
                        <li>Documents Prepared</li>
                        <li>Priority Processing</li>
                        <li>24/7 Support</li>
                    </ul>
                    @auth
                        <a href="{{ route('trademark.type-selection') }}" class="pricing-btn">Apply Now</a>
                    @else
                        <a href="{{ route('register') }}" class="pricing-btn">Get Started</a>
                    @endauth
                </div>

                <div class="pricing-card">
                    <h4>Enterprise</h4>
                    <p class="pricing-description">For large-scale operations</p>
                    <div class="pricing-amount">Custom</div>
                    <p class="pricing-period">Contact for pricing</p>
                    <ul class="pricing-features">
                        <li>Unlimited Classes</li>
                        <li>International Filing</li>
                        <li>Dedicated Manager</li>
                        <li>Custom Solutions</li>
                        <li>Premium Support</li>
                    </ul>
                    <a href="#" class="pricing-btn" style="background: var(--slate);">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TESTIMONIALS SECTION ============ -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>Loved by Thousands</h2>
                <p>See what our customers say about their experience</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Fantastic service! My trademark got filed in just 2 days. The entire process was transparent
                        and hassle-free. Highly recommended!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">RP</div>
                        <div class="author-info">
                            <div class="author-name">Rahul Patel</div>
                            <div class="author-title">Founder, Tech Startup</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Excellent support from their team. They guided me through every step and my brand is now
                        officially registered!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">PK</div>
                        <div class="author-info">
                            <div class="author-name">Priya Kapoor</div>
                            <div class="author-title">Fashion Designer</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Best decision for my business. Their pricing is transparent and the support is outstanding.
                        5-star service!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">AK</div>
                        <div class="author-info">
                            <div class="author-name">Amit Kumar</div>
                            <div class="author-title">E-commerce Business</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA SECTION ============ -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Protect Your Brand?</h2>
                <p>Join thousands of satisfied customers. Start your trademark registration today and get 24/7 expert
                    support.</p>
                <div class="cta-buttons">
                    @auth
                        <a href="{{ route('trademark.type-selection') }}" class="cta-btn cta-btn-primary">
                            Start Registration Now
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="cta-btn cta-btn-primary">
                            Sign Up Free
                        </a>
                    @endauth
                    <a href="#" class="cta-btn cta-btn-secondary">
                        Schedule a Call
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>

<iframe
  src="https://www.quickcompany.in"
  width="100%"
  height="600px"
  style="border:none;">
</iframe>    </section>

    <!-- ============ FOOTER ============ -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h6>
                        <i class="bi bi-shield-check" style="margin-right: 8px;"></i>Legal Bruz
                    </h6>
                    <p>India's fastest IPR platform. Trademark, Copyright & Patent registration made simple.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="social-icon" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h6>Quick Links</h6>
                    <ul>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#testimonials">Reviews</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h6>Company</h6>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h6>Get In Touch</h6>
                    <p>
                        <strong>Email:</strong><br>
                        <a href="mailto:support@legalbruz.com">support@legalbruz.com</a>
                    </p>
                    <p style="margin-top: 15px;">
                        <strong>Phone:</strong><br>
                        <a href="tel:+919876543210">+91 9876 543 210</a>
                    </p>
                    <p style="margin-top: 15px;">
                        <strong>Office:</strong><br>
                        34 Krishna Nagar, Ambala Cantt,<br>
                        Haryana 133001, India
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 Legal Bruz . All rights reserved. | Registered with IP Office, India</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.service-card, .benefit-card, .pricing-card, .testimonial-card, .process-item').forEach(
            el => {
                el.style.opacity = '0';
                observer.observe(el);
            });

        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Active nav link on scroll
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            document.querySelectorAll('section').forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').slice(1) === current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
