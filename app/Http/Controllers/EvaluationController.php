<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Internship;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    // Company supervisor: show criteria evaluation form
    public function edit(Internship $internship)
    {
        if ($internship->company_supervisor_id !== auth()->id()) {
            abort(403);
        }

        $evaluation = $internship->evaluation ?? new Evaluation(['internship_id' => $internship->id]);

        return view('evaluations.edit', compact('internship', 'evaluation'));
    }

    // Company supervisor: store/update criteria scores
    public function update(Request $request, Internship $internship)
    {
        if ($internship->company_supervisor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'technical_competence' => 'required|integer|min:0|max:20',
            'punctuality_attendance' => 'required|integer|min:0|max:20',
            'initiative_problem_solving' => 'required|integer|min:0|max:20',
            'professionalism_work_ethic' => 'required|integer|min:0|max:20',
            'communication_teamwork' => 'required|integer|min:0|max:20',
        ]);

        $validated['company_supervisor_submitted_at'] = now();

        Evaluation::updateOrCreate(
            ['internship_id' => $internship->id],
            $validated
        );

        return redirect()->route('dashboard')
            ->with('success', 'Evaluation submitted successfully.');
    }

    // University supervisor: show final grade form
    public function editGrade(Internship $internship)
    {
        if ($internship->university_supervisor_id !== auth()->id()) {
            abort(403);
        }

        $allReviewed = $internship->logEntries()->where('status', '!=', 'reviewed')->doesntExist()
            && $internship->logEntries()->exists();

        $evaluation = $internship->evaluation;

        return view('evaluations.grade', compact('internship', 'evaluation', 'allReviewed'));
    }

    // University supervisor: store final grade
    public function updateGrade(Request $request, Internship $internship)
    {
        if ($internship->university_supervisor_id !== auth()->id()) {
            abort(403);
        }

        $allReviewed = $internship->logEntries()->where('status', '!=', 'reviewed')->doesntExist()
            && $internship->logEntries()->exists();

        if (!$allReviewed) {
            return redirect()->back()
                ->with('error', 'All log entries must be reviewed before a final grade can be assigned.');
        }

        $validated = $request->validate([
            'final_grade' => 'required|numeric|min:0|max:100',
        ]);

        $validated['university_supervisor_submitted_at'] = now();

        Evaluation::updateOrCreate(
            ['internship_id' => $internship->id],
            $validated
        );

        return redirect()->route('dashboard')
            ->with('success', 'Final grade submitted successfully.');
    }
}