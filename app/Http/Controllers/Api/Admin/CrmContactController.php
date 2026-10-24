<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ContactNote;
use Illuminate\Http\Request;

class CrmContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::with(['handler', 'notes'])->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('crm_status', $request->status);
        }

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('visitor_name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        $messages = $query->paginate($request->input('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    public function show($id)
    {
        $contact = ContactMessage::with(['handler', 'notes.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $contact = ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'crm_status' => 'required|in:new,contacted,in_progress,resolved,closed',
            'priority' => 'nullable|in:low,normal,high,urgent',
            'handled_by' => 'nullable|exists:users,id',
        ]);

        $updateData = ['crm_status' => $validated['crm_status']];

        if (isset($validated['priority'])) {
            $updateData['priority'] = $validated['priority'];
        }

        if (array_key_exists('handled_by', $validated)) {
            $updateData['handled_by'] = $validated['handled_by'] ?: $request->user()->id;
        } else if (!$contact->handled_by) {
            $updateData['handled_by'] = $request->user()->id;
        }

        if ($validated['crm_status'] !== 'new') {
            $updateData['last_contacted_at'] = now();
        }

        $contact->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Status CRM berhasil diperbarui.',
            'data' => $contact->load(['handler', 'notes'])
        ]);
    }

    public function addNote(Request $request, $id)
    {
        $contact = ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'note' => 'required|string|min:3|max:2000',
        ]);

        $user = $request->user();

        $note = ContactNote::create([
            'contact_message_id' => $contact->id,
            'user_id' => $user ? $user->id : null,
            'author_name' => $user ? $user->name : 'Staff CRM',
            'note' => $validated['note'],
        ]);

        $contact->update([
            'last_contacted_at' => now(),
            'handled_by' => $user ? $user->id : $contact->handled_by,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catatan tindak lanjut berhasil ditambahkan.',
            'data' => $note
        ], 201);
    }

    public function destroy($id)
    {
        $contact = ContactMessage::findOrFail($id);
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data kontak berhasil dihapus.'
        ]);
    }
}
