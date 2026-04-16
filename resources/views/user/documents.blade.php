@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h2>📋 My Documents</h2>
                <p class="text-muted">Download and manage your trademark documents</p>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6 class="text-muted">My Applications</h6>
                        <h3>{{ $userApplicationCount }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6 class="text-muted">Approved</h6>
                        <h3>{{ $approvedCount }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6 class="text-muted">Total Documents</h6>
                        <h3>{{ $totalDocuments }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h6 class="text-muted">Signed & Verified</h6>
                        <h3>{{ $verifiedCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications with Documents -->
        @forelse($applications as $application)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-gradient"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                {{ $application->brand_name }}
                                <span
                                    class="badge
                                @if ($application->status === 'approved') bg-success
                                @elseif($application->status === 'filed') bg-info
                                @elseif($application->status === 'registered') bg-primary
                                @else bg-warning @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </h5>
                            <small>Application #{{ $application->id }} •
                                {{ $application->created_at->format('d M Y') }}</small>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-light text-dark">{{ $application->documents->count() }} Documents</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Application Info -->
                    <div class="row mb-4 pb-3 border-bottom">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>📝 Applicant:</strong></p>
                            <p class="text-muted">{{ $application->applicant_name }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>🏢 Industry/Class:</strong></p>
                            <p class="text-muted">{{ $application->industry }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>📱 Status:</strong></p>
                            <p class="text-muted">
                                @switch($application->status)
                                    @case('pending_admin')
                                        <span class="badge bg-warning">⏳ Pending Review</span>
                                    @break

                                    @case('approved')
                                        <span class="badge bg-success">✅ Approved</span>
                                    @break

                                    @case('filed')
                                        <span class="badge bg-info">📁 Filed</span>
                                    @break

                                    @case('registered')
                                        <span class="badge bg-primary">✔️ Registered</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($application->status) }}</span>
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    @if ($application->documents->count() > 0)
                        <h6 class="mb-3">📄 Generated Documents</h6>
                        <div class="row mb-4">
                            @foreach ($application->documents as $doc)
                                <div class="col-md-6 mb-3">
                                    <div
                                        class="card border-left-{{ $doc->document_type === 'Affidavit' ? 'primary' : 'info' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-0">
                                                        @if ($doc->document_type === 'Affidavit')
                                                            📋 Affidavit
                                                        @else
                                                            ✍️ Power of Attorney
                                                        @endif
                                                    </h6>
                                                    <small class="text-muted">{{ $doc->file_name }}</small>
                                                </div>
                                                <span
                                                    class="badge
                                                @if ($doc->status === 'verified') bg-success
                                                @elseif($doc->status === 'signed') bg-info
                                                @else bg-warning @endif">
                                                    {{ ucfirst($doc->status) }}
                                                </span>
                                            </div>

                                            <div class="btn-group" role="group" style="width: 100%;">
                                                <!-- View Button -->
                                                <a href="{{ route('user.document.view', $doc->id) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    👁️ View
                                                </a>

                                                <!-- Download Button -->
                                                <a href="{{ route('user.document.download', $doc->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    ⬇️ Download
                                                </a>

                                                <!-- Sign Button -->
                                                @if ($doc->status === 'generated')
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#signModal{{ $doc->id }}">
                                                        ✍️ Sign
                                                    </button>
                                                @endif
                                            </div>

                                            @if ($doc->verified_at)
                                                <div class="alert alert-success alert-sm mt-2 mb-0" role="alert">
                                                    ✔️ Verified on {{ $doc->verified_at->format('d M Y') }}
                                                    @if ($doc->verification_notes)
                                                        <br><small>{{ $doc->verification_notes }}</small>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Sign Modal -->
                                <div class="modal fade" id="signModal{{ $doc->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    @if ($doc->document_type === 'Affidavit')
                                                        📋 Sign Affidavit
                                                    @else
                                                        ✍️ Sign Power of Attorney
                                                    @endif
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info" role="alert">
                                                    <strong>Instructions:</strong>
                                                    <ol class="mb-0 mt-2">
                                                        <li>Click the "Download" button to save the document</li>
                                                        <li>Open the file in a word processor or PDF editor</li>
                                                        <li>Add your digital or printed signature</li>
                                                        <li>Save the signed document</li>
                                                        <li>Upload the signed document below</li>
                                                    </ol>
                                                </div>

                                                <!-- Upload Signed Document Form -->
                                                <form id="signForm{{ $doc->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="signedFile{{ $doc->id }}" class="form-label">
                                                            Upload Signed Document
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            id="signedFile{{ $doc->id }}" name="signed_document"
                                                            accept=".html,.pdf,.doc,.docx" required>
                                                        <small class="text-muted">Allowed formats: HTML, PDF, DOC,
                                                            DOCX</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="signatureNotes{{ $doc->id }}" class="form-label">
                                                            Signature Notes (Optional)
                                                        </label>
                                                        <textarea class="form-control" id="signatureNotes{{ $doc->id }}" name="signature_notes" rows="2"
                                                            placeholder="e.g., Signed digitally on iPad"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="uploadSignedDocument({{ $doc->id }}, {{ $application->id }})">
                                                    📤 Upload Signed Document
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <strong>⏳ Documents Not Generated Yet</strong><br>
                            Your documents will be generated once the admin approves your application.
                            Check back soon!
                        </div>
                    @endif
                </div>
            </div>
            @empty
                <div class="alert alert-info" role="alert">
                    <h4>📋 No Applications Found</h4>
                    <p>You haven't submitted any trademark applications yet. <a href="{{ route('home') }}">Start an
                            application now →</a></p>
                </div>
            @endforelse

        </div>

        <!-- Styles -->
        <style>
            .card {
                border: none;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            }

            .btn-group .btn {
                flex: 1;
            }

            .border-left-primary {
                border-left: 4px solid #667eea !important;
            }

            .border-left-info {
                border-left: 4px solid #17a2b8 !important;
            }

            .alert-sm {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }

            .bg-gradient {
                background-size: cover;
            }
        </style>

        <!-- JavaScript for Upload -->
        <script>
            function uploadSignedDocument(docId, appId) {
                const form = document.getElementById('signForm' + docId);
                const fileInput = document.getElementById('signedFile' + docId);
                const notesInput = document.getElementById('signatureNotes' + docId);

                if (!fileInput.files.length) {
                    alert('Please select a file to upload');
                    return;
                }

                const formData = new FormData();
                formData.append('document_id', docId);
                formData.append('application_id', appId);
                formData.append('signed_document', fileInput.files[0]);
                formData.append('signature_notes', notesInput.value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                // Show loading
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '⏳ Uploading...';

                fetch('{{ route('user.document.upload-signed') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Signed document uploaded successfully. Admin will verify it shortly.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to upload document'
                            });
                            btn.disabled = false;
                            btn.innerHTML = originalText;
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to upload document: ' + error.message
                        });
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    });
            }
        </script>
    @endsection
