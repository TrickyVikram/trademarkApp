<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Show user's documents dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $applications = $user->applications()->with('documents', 'payments')->get();

        $stats = [
            'userApplicationCount' => $applications->count(),
            'approvedCount' => $applications->where('status', 'approved')->count(),
            'totalDocuments' => $applications->sum(fn($app) => $app->documents->count()),
            'verifiedCount' => Document::whereIn('application_id', $applications->pluck('id'))->where('verified_at', '!=', null)->count(),
        ];

        return view('user.documents', array_merge(
            ['applications' => $applications],
            $stats
        ));
    }

    /**
     * View document in browser
     */
    public function view(Document $document)
    {
        // Verify ownership
        if ($document->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Document not found');
        }

        return response()->file($filePath);
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        // Verify ownership
        if ($document->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Document not found');
        }

        return response()->download(
            $filePath,
            $document->file_name
        );
    }

    /**
     * Upload signed document
     */
    public function uploadSigned(Request $request)
    {
        $validated = $request->validate([
            'document_id' => 'required|exists:documents,id',
            'application_id' => 'required|exists:applications,id',
            'signed_document' => 'required|file|max:10240', // 10MB
            'signature_notes' => 'nullable|string|max:1000',
        ]);

        $document = Document::findOrFail($validated['document_id']);
        $application = Application::findOrFail($validated['application_id']);

        // Verify user owns this application
        if ($application->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            // Store signed document
            $file = $request->file('signed_document');
            $filename = 'signed-' . $document->document_type . '-' . $application->id . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
            $path = 'documents/signed/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($file));

            // Create new document record for signed version
            $signedDoc = Document::create([
                'application_id' => $application->id,
                'user_id' => Auth::id(),
                'document_type' => $document->document_type . ' (Signed)',
                'file_path' => $path,
                'file_name' => $filename,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'status' => 'signed',
                'verification_notes' => $validated['signature_notes'] ?? 'User uploaded signed document',
            ]);

            // Update original document status
            $document->update([
                'status' => 'signed'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Signed document uploaded successfully. Admin will review it shortly.',
                'document' => $signedDoc
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List user's documents (API endpoint)
     */
    public function listDocuments()
    {
        $user = Auth::user();
        $documents = Document::whereIn(
            'application_id',
            $user->applications()->pluck('id')
        )->get();

        return response()->json($documents);
    }
}
