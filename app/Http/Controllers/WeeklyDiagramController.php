<?php

namespace App\Http\Controllers;

use App\Models\WeeklyDiagram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeeklyDiagramController extends Controller
{
    public function store(Request $request)
    {
        $internship = auth()->user()->internship;

        if (!$internship) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have an internship record yet.');
        }

        $request->validate([
            'diagram' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $weekStart = WeeklyDiagram::currentWeekStart();

        $existing = WeeklyDiagram::where('internship_id', $internship->id)
            ->where('week_start_date', $weekStart)
            ->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->file_path);
        }

        $path = $request->file('diagram')->store('weekly-diagrams', 'public');

        WeeklyDiagram::updateOrCreate(
            [
                'internship_id' => $internship->id,
                'week_start_date' => $weekStart,
            ],
            [
                'file_path' => $path,
                'original_filename' => $request->file('diagram')->getClientOriginalName(),
                'uploaded_at' => now(),
            ]
        );

        return redirect()->route('dashboard')
            ->with('diagram_success', 'Weekly diagram uploaded successfully.');
    }
}