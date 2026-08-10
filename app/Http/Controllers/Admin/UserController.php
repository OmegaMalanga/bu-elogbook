<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->orderBy('name')->paginate(25)->withQueryString();

        $roles = ['student', 'company_supervisor', 'university_supervisor', 'admin'];
        $departments = \App\Models\Department::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'departments'));
    }

public function updateRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|in:student,company_supervisor,university_supervisor,admin',
        'department_id' => 'nullable|exists:departments,id',
    ]);

    $user->syncRoles([$request->role]);

    if ($request->role === 'university_supervisor') {
        $user->update(['department_id' => $request->department_id]);
    }

    return back()->with('success', $user->name . "'s role updated to " . $request->role);
}
}