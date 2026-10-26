<?php

namespace App\Services\Api\Admin;

use App\Models\ContactMessage;
use App\Models\ContactNote;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CrmContactService
{
    /** @param array<string, mixed> $filters */
    public function index(array $filters): LengthAwarePaginator
    {
        $query = ContactMessage::query()
            ->with(['handler', 'notes'])
            ->orderByDesc('created_at');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('crm_status', $filters['status']);
        }

        if (($filters['priority'] ?? null) !== null && $filters['priority'] !== '' && $filters['priority'] !== 'all') {
            $query->where('priority', $filters['priority']);
        }

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('visitor_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        return $query->paginate($filters['per_page'] ?? 20);
    }

    public function find(string $id): ContactMessage
    {
        return ContactMessage::query()->with(['handler', 'notes.user'])->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function updateStatus(string $id, array $data, User $user): ContactMessage
    {
        $contact = ContactMessage::query()->findOrFail($id);
        $updateData = ['crm_status' => $data['crm_status']];

        if (isset($data['priority'])) {
            $updateData['priority'] = $data['priority'];
        }

        if (array_key_exists('handled_by', $data)) {
            $updateData['handled_by'] = $data['handled_by'] ?: $user->id;
        } elseif (! $contact->handled_by) {
            $updateData['handled_by'] = $user->id;
        }

        if ($data['crm_status'] !== 'new') {
            $updateData['last_contacted_at'] = now();
        }

        $contact->update($updateData);

        return $contact->load(['handler', 'notes']);
    }

    public function addNote(string $id, string $note, ?User $user): ContactNote
    {
        $contact = ContactMessage::query()->findOrFail($id);

        $contactNote = ContactNote::query()->create([
            'contact_message_id' => $contact->id,
            'user_id' => $user?->id,
            'author_name' => $user?->name ?? 'Staff CRM',
            'note' => $note,
        ]);

        $contact->update([
            'last_contacted_at' => now(),
            'handled_by' => $user?->id ?? $contact->handled_by,
        ]);

        return $contactNote;
    }

    public function delete(string $id): void
    {
        ContactMessage::query()->findOrFail($id)->delete();
    }
}
