<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Models\Teacher;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TeacherController extends Controller
{
    public function edit(Teacher $teacher): View
    {
        return view('dashboard.teachers.edit', [
            'teacher' => $teacher,
        ]);
    }

    public function store(TeacherStoreRequest $request): RedirectResponse
    {
        Teacher::query()->create([
            'full_name' => $request->validated('full_name'),
            'position' => $request->validated('position'),
            'experience' => $request->validated('experience'),
            'sort_order' => $request->validatedNextSort(),
        ]);

        return redirect()->route('dashboard')->with([
            'status' => 'teacher-saved',
            'saved_section' => 'teachers',
        ]);
    }

    public function update(TeacherUpdateRequest $request, Teacher $teacher): RedirectResponse
    {
        $teacher->update([
            'full_name' => $request->validated('full_name'),
            'position' => $request->validated('position'),
            'experience' => $request->validated('experience'),
        ]);

        return redirect()->route('dashboard')->with([
            'status' => 'teacher-saved',
            'saved_section' => 'teachers',
        ]);
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route('dashboard')->with([
            'status' => 'teacher-deleted',
            'saved_section' => 'teachers',
        ]);
    }
}
