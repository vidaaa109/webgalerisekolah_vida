<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['reporter:id,name,email', 'reportable'])
            ->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        $reports = $query->paginate(12)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,action_taken',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $report->status = $request->status;
        $report->admin_note = $request->admin_note;
        $report->save();

        return back()->with('success', 'Laporan diperbarui.');
    }
}

