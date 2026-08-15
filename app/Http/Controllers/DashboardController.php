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
                $weeklyDiagram = \App\Models\WeeklyDiagram::where('internship_id', $internship->id)
                    ->where('week_start_date', \App\Models\WeeklyDiagram::currentWeekStart())
                    ->first();
            } else {
                $weeklyDiagram = null;
            }
        
       
        return view('dashboard', compact('internship', 'thisWeekCount', 'thisMonthCount', 'recentEntries','weeklyDiagram'));
    }

   if ($user->hasRole('company_supervisor') || $user->hasRole('university_supervisor')) {
            $query = \App\Models\LogEntry::with('internship.student')->orderBy('date', 'desc');

            if ($user->hasRole('company_supervisor')) {
                $query->where('status', 'submitted')
                    ->whereHas('internship', function ($q) use ($user) {
                        $q->where('company_supervisor_id', $user->id);
                    });
            } else {
                $query->where('status', 'company_reviewed')
                    ->whereHas('internship', function ($q) use ($user) {
                        $q->where('university_supervisor_id', $user->id);
                    });
            }

            $reviewableEntries = $query->get()
                ->filter(fn ($entry) => $entry->isReviewable())
                ->values();

            $pendingCount = $reviewableEntries->count();
            $pendingEntries = $reviewableEntries->take(5);

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