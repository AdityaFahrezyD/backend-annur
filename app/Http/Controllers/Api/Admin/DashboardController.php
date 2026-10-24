<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Competition;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $crmStats = [
            'total' => ContactMessage::count(),
            'new' => ContactMessage::where('crm_status', 'new')->count(),
            'contacted' => ContactMessage::where('crm_status', 'contacted')->count(),
            'in_progress' => ContactMessage::where('crm_status', 'in_progress')->count(),
            'resolved' => ContactMessage::where('crm_status', 'resolved')->count(),
            'closed' => ContactMessage::where('crm_status', 'closed')->count(),
        ];

        $contentStats = [
            'teachers' => Teacher::count(),
            'achievements' => Achievement::count(),
            'competitions' => Competition::count(),
            'galleries' => Gallery::count(),
        ];

        $recentInquiries = ContactMessage::with(['handler', 'notes'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'crm_stats' => $crmStats,
                'content_stats' => $contentStats,
                'recent_inquiries' => $recentInquiries,
            ]
        ]);
    }
}
