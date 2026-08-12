<?php

namespace App\Http\Controllers;

use App\Models\LogEntry;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->hasRole('student')) {
        $internship = $user->internship;

        $thisWeekCount = 0;
        $thisMonthCount = 0;
        $recentEntries = collect();

        if ($internship) {
            $thisWeekCount = $internship->logEntries()
                ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            $thisMonthCount = $internship->logEntries()
                ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
                ->count();

            $recentEntries = $internship->logEntries()
                ->orderBy('date', 'desc')
                ->take(5)
                ->get();
        }
       
        return view('dashboard', compact('internship', 'thisWeekCount', 'thisMonthCount', 'recentEntries'));
    }

    if ($user->hasRole('company_supervisor') || $user->hasRole('university_supervisor')) {
        $pendingEntries = \App\Models\LogEntry::where('status', 'submitted')
            ->whereHas('internship', function ($query) use ($user) {
                $query->where('company_supervisor_id', $user->id)
                      ->orWhere('university_supervisor_id', $user->id);
            })
            ->with('internship.student')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $pendingCount = $pendingEntries->count();

        $internships = \App\Models\Internship::where('company_supervisor_id', $user->id)
            ->orWhere('university_supervisor_id', $user->id)
            ->with(['student', 'evaluation'])
            ->get();

        return view('dashboard', compact('pendingEntries', 'pendingCount', 'internships'));
    }

   if ($user->hasRole('admin')) {
    $departments = \App\Models\Department::orderBy('name')->get();

    $departmentStats = $departments->map(function ($department) {
        $yearBreakdown = [];
        foreach ([2, 3] as $year) {
            $yearBreakdown[$year] = [
                'students_count' => \App\Models\Internship::where('department_id', $department->id)
                    ->where('year_of_study', $year)
                    ->count(),
                'pending_reviews_count' => \App\Models\LogEntry::where('status', 'submitted')
                    ->whereHas('internship', fn ($q) => $q->where('department_id', $department->id)->where('year_of_study', $year))
                    ->count(),
            ];
        }

        return [
            'name' => $department->name,
            'years' => $yearBreakdown,
        ];
    });

    $facultyTotals = [
        'students' => \App\Models\User::role('student')->count(),
        'internships' => \App\Models\Internship::count(),
        'pending_reviews' => \App\Models\LogEntry::where('status', 'submitted')->count(),
    ];

    return view('dashboard', compact('departmentStats', 'facultyTotals'));
}

    return view('dashboard');
}
}