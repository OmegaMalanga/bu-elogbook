<?php

namespace App\Http\Controllers\DepartmentAdmin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Internship::with(['student', 'universitySupervisor'])
            ->where('department_id', $user->department_id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $internships = $query->paginate(25)->withQueryString();

        $universitySupervisors = User::role('university_supervisor')
            ->where('department_id', $user->department_id)
            ->get(['id', 'name']);

        return view('department-admin.internships.index', compact(
            'internships', 'universitySupervisors'
        ));
    }

    public function update(Request $request, Internship $internship)
    {
        $user = auth()->user();

        abort_unless($internship->department_id === $user->department_id, 403);

        $validated = $request->validate([
            'university_supervisor_id' => 'nullable|exists:users,id',
        ]);

        $oldUniversitySupervisorId = $internship->university_supervisor_id;

        $internship->update($validated);

        $newUniversitySupervisorId = $validated['university_supervisor_id'] ?? null;
        if ($newUniversitySupervisorId && $newUniversitySupervisorId != $oldUniversitySupervisorId) {
            $supervisor = User::find($newUniversitySupervisorId);
            if ($supervisor) {
                \Illuminate\Support\Facades\Mail::to($supervisor->email)
                    ->send(new \App\Mail\UniversitySupervisorAssigned($supervisor, $internship->student));
            }
        }

        return redirect()->route('department.internships.index')
            ->with('success', 'Internship updated.');
    }
}