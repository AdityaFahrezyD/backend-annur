<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AddContactNoteRequest;
use App\Http\Requests\Api\Admin\ContactIndexRequest;
use App\Http\Requests\Api\Admin\UpdateContactStatusRequest;
use App\Services\Api\Admin\CrmContactService;
use Illuminate\Http\JsonResponse;

class CrmContactController extends Controller
{
    public function __construct(private CrmContactService $crmContactService) {}

    public function index(ContactIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->crmContactService->index($request->validated()),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->crmContactService->find($id),
        ]);
    }

    public function updateStatus(UpdateContactStatusRequest $request, string $id): JsonResponse
    {
        $contact = $this->crmContactService->updateStatus(
            $id,
            $request->validated(),
            $request->user(),
        );

        return response()->json([
            'success' => true,
            'message' => 'Status CRM berhasil diperbarui.',
            'data' => $contact,
        ]);
    }

    public function addNote(AddContactNoteRequest $request, string $id): JsonResponse
    {
        $note = $this->crmContactService->addNote(
            $id,
            $request->validated('note'),
            $request->user(),
        );

        return response()->json([
            'success' => true,
            'message' => 'Catatan tindak lanjut berhasil ditambahkan.',
            'data' => $note,
        ], 201);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->crmContactService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Data kontak berhasil dihapus.',
        ]);
    }
}
