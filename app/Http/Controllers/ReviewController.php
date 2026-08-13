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

        $query = LogEntry::with('internship.student');

        if ($user->hasRole('company_supervisor')) {
            $query->where('status', 'submitted')
                ->whereHas('internship', function ($q) use ($user) {
                    $q->where('company_supervisor_id', $user->id);
                });
        } elseif ($user->hasRole('university_supervisor')) {
            $query->where('status', 'company_reviewed')
                ->whereHas('internship', function ($q) use ($user) {
                    $q->where('university_supervisor_id', $user->id);
                });
        } else {
            $query->whereRaw('1 = 0'); // no other role should see this list
        }

        $logEntries = $query->orderBy('date', 'desc')
            ->get()
            ->filter(fn ($logEntry) => $logEntry->isReviewable())
            ->values();

        return view('reviews.index', compact('logEntries'));
    }

    public function show(LogEntry $logEntry)
    {
        $user = auth()->user();

        if (! $logEntry->isReviewable()) {
            return redirect()->route('reviews.index')
                ->with('error', 'This report can only be reviewed starting Friday of its week.');
        }

        if ($user->hasRole('university_supervisor') && $logEntry->status !== 'company_reviewed') {
            return redirect()->route('reviews.index')
                ->with('error', 'The company supervisor must review this report first.');
        }

        $logEntry->load('internship.student');

        return view('reviews.show', compact('logEntry'));
    }

    public function store(Request $request, LogEntry $logEntry)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'status' => 'required|in:approved,needs_revision',
            'comment' => 'nullable|string|max:1000',
        ]);

        if (! $logEntry->isReviewable()) {
            return redirect()->route('reviews.index')
                ->with('error', 'This report can only be reviewed starting Friday of its week.');
        }

        if ($user->hasRole('university_supervisor') && $logEntry->status !== 'company_reviewed') {
            return redirect()->route('reviews.index')
                ->with('error', 'The company supervisor must review this report first.');
        }

        Review::updateOrCreate(
            [
                'log_entry_id' => $logEntry->id,
                'reviewer_id' => $user->id,
            ],
            [
                'status' => $validated['status'],
                'comment' => $validated['comment'],
            ]
        );

        if ($validated['status'] === 'needs_revision') {
            $logEntry->update(['status' => 'draft']);
        } elseif ($user->hasRole('company_supervisor')) {
            $logEntry->update(['status' => 'company_reviewed']);
        } elseif ($user->hasRole('university_supervisor')) {
            $logEntry->update(['status' => 'reviewed']);
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Review submitted.');
    }
}