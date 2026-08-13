<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Internship;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'departments' => \App\Models\Department::orderBy('name')->get(),
            
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'department_id' => ['required', 'exists:departments,id'],
        'year_of_study' => ['required', 'integer', 'in:2,3'],
        'company_name' => ['required', 'string', 'max:255'],
        'pending_company_supervisor_name' => ['nullable', 'string', 'max:255'],
        'pending_company_supervisor_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
        
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->assignRole('student');

    $internship = Internship::create([
        'student_id' => $user->id,
        'department_id' => $request->department_id,
        'year_of_study' => $request->year_of_study,
        'company_name' => $request->company_name,
        'pending_company_supervisor_name' => $request->pending_company_supervisor_name,
        
    ]);

    // Company supervisor: match existing account by email, or queue an invite
    if ($request->pending_company_supervisor_email) {
        $existingSupervisor = \App\Models\User::where('email', $request->pending_company_supervisor_email)
            ->role('company_supervisor')
            ->first();

        if ($existingSupervisor) {
            $internship->update([
                'company_supervisor_id' => $existingSupervisor->id,
                'pending_company_supervisor_email' => null,
            ]);

            \Illuminate\Support\Facades\Mail::to($existingSupervisor->email)
                ->send(new \App\Mail\CompanySupervisorAssigned($existingSupervisor, $user, $internship));
       } else {
            $token = \Illuminate\Support\Str::random(40);

            $internship->update([
                'pending_company_supervisor_email' => $request->pending_company_supervisor_email,
                'company_supervisor_invite_token' => $token,
            ]);

            \Illuminate\Support\Facades\Mail::to($request->pending_company_supervisor_email)
                ->send(new \App\Mail\CompanySupervisorInvite($user, $internship, $token));
        }
    }

    event(new Registered($user));

   
    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}