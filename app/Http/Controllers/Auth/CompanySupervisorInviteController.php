<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class CompanySupervisorInviteController extends Controller
{
    public function show(string $token): View
    {
        $internship = Internship::where('company_supervisor_invite_token', $token)->firstOrFail();

        return view('auth.company-supervisor-invite', [
            'internship' => $internship,
            'student' => $internship->student,
            'token' => $token,
        ]);
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        $internship = Internship::where('company_supervisor_invite_token', $token)->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $internship->pending_company_supervisor_email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('company_supervisor');

        $internship->update([
            'company_supervisor_id' => $user->id,
            'pending_company_supervisor_email' => null,
            'company_supervisor_invite_token' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}