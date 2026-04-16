@extends('layouts.app-modern')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="h2 mb-3" style="color: var(--navy); font-weight: 900;">
                        <i class="bi bi-file-earmark-pdf" style="font-size: 3rem; color: var(--emerald);"></i>
                    </h1>
                    <h2 class="mb-2">Download Your Documents</h2>
                    <p class="text-muted fs-5">Get your Affidavit & Power of Attorney documents ready</p>
                </div>

                <!-- Step Guide -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-4">
                        <h5 class="mb-0" style="color: var(--navy); font-weight: 800;">📋 What to Do Next</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex mb-4 pb-4 border-bottom">
                            <div
                                style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.5rem; flex-shrink: 0; margin-right: 20px;">
                                1
                            </div>
                            <div>
                                <h6 style="color: var(--navy); font-weight: 800;" class="mb-2">Download Documents</h6>
                                <p class="mb-0 text-muted">Click the download buttons below to get your Affidavit and Power
                                    of Attorney documents in HTML format.</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4 pb-4 border-bottom">
                            <div
                                style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.5rem; flex-shrink: 0; margin-right: 20px;">
                                2
                            </div>
                            <div>
                                <h6 style="color: var(--navy); font-weight: 800;" class="mb-2">Print the Documents</h6>
                                <p class="mb-0 text-muted">Open the HTML file in your browser and print both documents on A4
                                    paper. Make sure to include all pages.</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4 pb-4 border-bottom">
                            <div
                                style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.5rem; flex-shrink: 0; margin-right: 20px;">
                                3
                            </div>
                            <div>
                                <h6 style="color: var(--navy); font-weight: 800;" class="mb-2">Sign the Documents</h6>
                                <p class="mb-0 text-muted"><strong>Get them notarized</strong> or have them notarized by a
                                    First Class Magistrate or Notary Public. This is mandatory for legal validity.</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div
                                style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.5rem; flex-shrink: 0; margin-right: 20px;">
                                4
                            </div>
                            <div>
                                <h6 style="color: var(--navy); font-weight: 800;" class="mb-2">Upload Signed Copies</h6>
                                <p class="mb-0 text-muted">Scan or take clear photos of the signed and notarized documents,
                                    then upload them in the document upload section.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Note -->
                <div class="alert alert-warning border-0 rounded-lg p-4 mb-4"
                    style="background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(255, 107, 53, 0.05) 100%); border-left: 4px solid #FF6B35;">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill"
                            style="color: #FF6B35; font-size: 1.5rem; margin-right: 15px; flex-shrink: 0; margin-top: 2px;"></i>
                        <div>
                            <h6 style="color: var(--navy); font-weight: 800; margin-bottom: 8px;">⚠️ Important: Notarization
                                is Mandatory</h6>
                            <p class="mb-2 small">
                                Both Affidavit and Power of Attorney documents <strong>must be notarized</strong> by a
                                notary public or First Class Magistrate.
                                Without notarization, these documents will not be accepted by the Trademark Registry.
                            </p>
                            <p class="small mb-0">
                                <strong>Estimated Cost:</strong> ₹50-100 per document notarization | <strong>Time:</strong>
                                24-48 hours
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Document Cards -->
                <div class="row g-4 mb-5">
                    <!-- Affidavit -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow-lg transition">
                            <div class="card-body p-4 text-center">
                                <div style="font-size: 3rem; margin-bottom: 15px;">📄</div>
                                <h5 class="card-title" style="color: var(--navy); font-weight: 800;">Affidavit</h5>
                                <p class="card-text text-muted small mb-4">
                                    Sworn statement confirming your rights and information regarding the trademark
                                    application
                                </p>
                                <a href="{{ route('documents.affidavit.download', $applicationId) }}" class="btn w-100"
                                    style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; font-weight: 700; border-radius: 8px;">
                                    <i class="bi bi-download" style="margin-right: 8px;"></i> Download Affidavit
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Power of Attorney -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 hover-shadow-lg transition">
                            <div class="card-body p-4 text-center">
                                <div style="font-size: 3rem; margin-bottom: 15px;">⚖️</div>
                                <h5 class="card-title" style="color: var(--navy); font-weight: 800;">Power of Attorney (POA)
                                </h5>
                                <p class="card-text text-muted small mb-4">
                                    Legal authorization granting Legal Bruz LLP authority to represent you in the
                                    application
                                    process
                                </p>
                                <a href="{{ route('documents.poa.download', $applicationId) }}" class="btn w-100"
                                    style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; font-weight: 700; border-radius: 8px;">
                                    <i class="bi bi-download" style="margin-right: 8px;"></i> Download POA
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0 py-4">
                        <h5 class="mb-0" style="color: var(--navy); font-weight: 800;">❓ FAQ</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 border-bottom mb-3 pb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq1">
                                        <strong style="color: var(--navy);">Can I print the documents myself?</strong>
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-3">
                                        Yes, you can print the documents yourself at home or at any printing center. Make
                                        sure the print quality is clear and legible.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 border-bottom mb-3 pb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq2">
                                        <strong style="color: var(--navy);">Where can I get these documents
                                            notarized?</strong>
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-3">
                                        You can get documents notarized by:
                                        <ul class="mt-2 mb-0">
                                            <li>Any registered Notary Public</li>
                                            <li>First Class Magistrate in your district</li>
                                            <li>Local court office</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 border-bottom mb-3 pb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq3">
                                        <strong style="color: var(--navy);">How much does notarization cost?</strong>
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-3">
                                        Typically, notarization costs ₹50-100 per document or ₹100-200 for both documents
                                        combined. Charges may vary by location.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq4">
                                        <strong style="color: var(--navy);">Can I submit copies or must they be
                                            originals?</strong>
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-3">
                                        For online filing, you can submit scanned copies of the notarized documents. Make
                                        sure the scan quality is clear and all signatures are visible.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row g-3 mt-5">
                    <div class="col-md-6">
                        <a href="{{ route('documents.upload', $applicationId) }}" class="btn btn-lg w-100"
                            style="background: linear-gradient(135deg, var(--emerald) 0%, #228974 100%); color: white; font-weight: 700; border-radius: 8px; padding: 15px;">
                            <i class="bi bi-cloud-arrow-up" style="margin-right: 8px;"></i> Upload Documents
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('dashboard') }}" class="btn btn-lg w-100 btn-outline-secondary"
                            style="border-radius: 8px; padding: 15px; font-weight: 700;">
                            <i class="bi bi-house" style="margin-right: 8px;"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow-lg {
            transition: all 0.3s ease;
        }

        .hover-shadow-lg:hover {
            box-shadow: 0 15px 40px rgba(42, 157, 143, 0.15) !important;
            transform: translateY(-5px);
        }

        .transition {
            transition: all 0.3s ease;
        }

        .accordion-button:not(.collapsed) {
            background-color: transparent;
            color: var(--emerald);
            font-weight: 700;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--emerald);
        }
    </style>
@endsection
