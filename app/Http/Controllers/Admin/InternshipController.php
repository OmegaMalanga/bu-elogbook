<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Internship::with(['student', 'department', 'companySupervisor', 'universitySupervisor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $internships = $query->paginate(25)->withQueryString();

        $departments = Department::orderBy('name')->get();

        $companySupervisors = User::role('company_supervisor')->get(['id', 'name', 'department_id']);
        $universitySupervisors = User::role('university_supervisor')->get(['id', 'name', 'department_id']);

        return view('admin.internships.index', compact(
            'internships', 'departments', 'companySupervisors', 'universitySupervisors'
        ));
    }

   public function update(Request $request, Internship $internship)
{
    $validated = $request->validate([
        'department_id' => 'nullable|exists:departments,id',
        'company_supervisor_id' => 'nullable|exists:users,id',
        'university_supervisor_id' => 'nullable|exists:users,id',
    ]);

    // If admin is manually assigning a company supervisor, clear any outstanding invite
    if (!empty($validated['company_supervisor_id'])) {
        $validated['pending_company_supervisor_email'] = null;
        $validated['company_supervisor_invite_token'] = null;
        $validated['pending_company_supervisor_name'] = null;
    }

    $oldUniversitySupervisorId = $internship->university_supervisor_id;

    $internship->update($validated);

    // Notify the university supervisor only if they're newly assigned or changed
    $newUniversitySupervisorId = $validated['university_supervisor_id'] ?? null;
    if ($newUniversitySupervisorId && $newUniversitySupervisorId != $oldUniversitySupervisorId) {
        $supervisor = \App\Models\User::find($newUniversitySupervisorId);
        if ($supervisor) {
            \Illuminate\Support\Facades\Mail::to($supervisor->email)
                ->send(new \App\Mail\UniversitySupervisorAssigned($supervisor, $internship->student));
        }
    }

    return redirect()->route('admin.internships.index')
        ->with('success', 'Internship updated.');
}
}