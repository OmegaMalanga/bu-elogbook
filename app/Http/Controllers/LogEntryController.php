<?php

namespace App\Http\Controllers;

use App\Models\LogEntry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LogEntryController extends Controller
{
    public function create()
    {
        $internship = auth()->user()->internship;

        if (!$internship) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have an internship record yet. Please contact your administrator.');
        }

        return view('log-entries.create', compact('internship'));
    }

    public function store(Request $request)
    {
        $internship = auth()->user()->internship;

        if (!$internship) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have an internship record yet.');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'operations_carried_out' => 'required|string|max:1000',
            'tools_equipment_used' => 'required|string|max:500',
            'challenges_faced' => 'nullable|string|max:500',
            'recommendations' => 'nullable|string|max:500',
        ]);
        $duplicateExists = \App\Models\LogEntry::where('internship_id', $internship->id)
            ->where('date', $validated['date'])
            ->exists();

if ($duplicateExists) {
    return back()->withInput()->withErrors([
        'date' => 'You have already submitted a report for this date.',
    ]);
}

       $validated['internship_id'] = $internship->id;
        $validated['status'] = $request->input('action') === 'submit' ? 'submitted' : 'draft';

        if ($validated['status'] === 'submitted') {
            $duplicateCheck = LogEntry::checkForDuplicate($internship->id, $validated['operations_carried_out']);
            $validated['flagged_duplicate'] = $duplicateCheck['flagged'];
            $validated['similar_to_log_entry_id'] = $duplicateCheck['similar_to_log_entry_id'];
        }

        LogEntry::create($validated);

        return redirect()->route('dashboard')
            ->with('success', $validated['status'] === 'submitted'
                ? 'Report submitted successfully.'
                : 'Report saved as draft.');
    }

    public function myReports(Request $request)
{
    $internship = auth()->user()->internship;

    $query = $internship
        ? $internship->logEntries()->orderBy('date', 'desc')
        : \App\Models\LogEntry::whereRaw('1 = 0'); // empty query if no internship

    // Apply filters
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    if ($request->filled('from_date')) {
        $query->whereDate('date', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('date', '<=', $request->to_date);
    }

    $entries = $query->get();

    // Stat counts (unfiltered totals, not affected by the filter above)
    $allEntries = $internship ? $internship->logEntries() : null;
    $totalCount = $allEntries ? $allEntries->count() : 0;
    $draftCount = $allEntries ? (clone $allEntries)->where('status', 'draft')->count() : 0;
        $submittedCount = $allEntries ? (clone $allEntries)->where('status', 'submitted')->count() : 0;
        $companyReviewedCount = $allEntries ? (clone $allEntries)->where('status', 'company_reviewed')->count() : 0;
        $reviewedCount = $allEntries ? (clone $allEntries)->where('status', 'reviewed')->count() : 0;

        return view('log-entries.my-reports', compact(
            'entries', 'totalCount', 'draftCount', 'submittedCount', 'companyReviewedCount', 'reviewedCount'
        ));
}
public function exportPdf(Request $request)
    {
        $internship = auth()->user()->internship;

        if (!$internship) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have an internship record yet.');
        }

        $query = $internship->logEntries()->orderBy('date', 'asc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $entries = $query->get();

        $pdf = Pdf::loadView('log-entries.pdf', [
            'entries' => $entries,
            'internship' => $internship,
            'student' => auth()->user(),
        ])->setPaper('a4', 'portrait');

        $filename = 'logbook-' . \Illuminate\Support\Str::slug(auth()->user()->name) . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    public function edit(LogEntry $logEntry)
{
    $internship = auth()->user()->internship;

    if (!$internship || $logEntry->internship_id !== $internship->id) {
        abort(403);
    }

    if ($logEntry->status !== 'draft') {
        return redirect()->route('dashboard')
            ->with('error', 'Only draft reports can be edited.');
    }

    return view('log-entries.edit', compact('logEntry'));
}

public function update(Request $request, LogEntry $logEntry)
{
    $internship = auth()->user()->internship;

    if (!$internship || $logEntry->internship_id !== $internship->id) {
        abort(403);
    }

    if ($logEntry->status !== 'draft') {
        return redirect()->route('dashboard')
            ->with('error', 'Only draft reports can be edited.');
    }

    $validated = $request->validate([
        'date' => 'required|date',
        'operations_carried_out' => 'required|string|max:1000',
        'tools_equipment_used' => 'required|string|max:500',
        'challenges_faced' => 'nullable|string|max:500',
        'recommendations' => 'nullable|string|max:500',
    ]);

    $duplicateExists = LogEntry::where('internship_id', $internship->id)
        ->where('date', $validated['date'])
        ->where('id', '!=', $logEntry->id)
        ->exists();

    if ($duplicateExists) {
        return back()->withInput()->withErrors([
            'date' => 'You have already submitted a report for this date.',
        ]);
    }

   $validated['status'] = $request->input('action') === 'submit' ? 'submitted' : 'draft';

        if ($validated['status'] === 'submitted') {
            $duplicateCheck = LogEntry::checkForDuplicate($internship->id, $validated['operations_carried_out'], $logEntry->id);
            $validated['flagged_duplicate'] = $duplicateCheck['flagged'];
            $validated['similar_to_log_entry_id'] = $duplicateCheck['similar_to_log_entry_id'];
        }

        $logEntry->update($validated);

    return redirect()->route('dashboard')
        ->with('success', $validated['status'] === 'submitted'
            ? 'Report submitted successfully.'
            : 'Report saved as draft.');
}
}