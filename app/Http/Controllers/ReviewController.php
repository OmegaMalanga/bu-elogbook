<?php

namespace App\Http\Controllers;

use App\Models\LogEntry;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $logEntries = LogEntry::where('status', 'submitted')
            ->whereHas('internship', function ($query) use ($user) {
                $query->where('company_supervisor_id', $user->id)
                      ->orWhere('university_supervisor_id', $user->id);
            })
            ->with('internship.student')
            ->orderBy('date', 'desc')
            ->get();

        return view('reviews.index', compact('logEntries'));
    }
    public function show(LogEntry $logEntry)
{
    $logEntry->load('internship.student');

    return view('reviews.show', compact('logEntry'));
}

    public function store(Request $request, LogEntry $logEntry)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,needs_revision',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'log_entry_id' => $logEntry->id,
                'reviewer_id' => auth()->id(),
            ],
            [
                'status' => $validated['status'],
                'comment' => $validated['comment'],
            ]
        );

        if ($validated['status'] === 'needs_revision') {
            $logEntry->update(['status' => 'draft']);
        } else {
            $logEntry->update(['status' => 'reviewed']);
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Review submitted.');
    }
}