<?php

namespace App\Services\Api\Admin;

use App\Models\Achievement;
use App\Models\Competition;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    /** @return array{crm_stats: array<string, int>, content_stats: array<string, int>, recent_inquiries: Collection} */
    public function index(): array
    {
        return [
            'crm_stats' => [
                'total' => ContactMessage::query()->count(),
                'new' => ContactMessage::query()->where('crm_status', 'new')->count(),
                'contacted' => ContactMessage::query()->where('crm_status', 'contacted')->count(),
                'in_progress' => ContactMessage::query()->where('crm_status', 'in_progress')->count(),
                'resolved' => ContactMessage::query()->where('crm_status', 'resolved')->count(),
                'closed' => ContactMessage::query()->where('crm_status', 'closed')->count(),
            ],
            'content_stats' => [
                'teachers' => Teacher::query()->count(),
                'achievements' => Achievement::query()->count(),
                'competitions' => Competition::query()->count(),
                'galleries' => Gallery::query()->count(),
            ],
            'recent_inquiries' => ContactMessage::query()
                ->with(['handler', 'notes'])
                ->orderByDesc('created_at')
                ->limit(6)
                ->get(),
        ];
    }
}
