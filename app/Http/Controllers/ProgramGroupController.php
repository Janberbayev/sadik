<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramGroupStoreRequest;
use App\Http\Requests\ProgramGroupUpdateRequest;
use App\Models\ProgramGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProgramGroupController extends Controller
{
    public function edit(ProgramGroup $program_group): View
    {
        return view('dashboard.program-groups.edit', [
            'group' => $program_group,
        ]);
    }

    public function store(ProgramGroupStoreRequest $request): RedirectResponse
    {
        $items = $request->parsedItems();
        if ($items === []) {
            throw ValidationException::withMessages([
                'items_raw' => ['Добавьте хотя бы одну строку в списке программ.'],
            ]);
        }

        ProgramGroup::query()->create([
            'title' => $request->validated('title'),
            'image_path' => $request->storedImagePathIfUploaded(),
            'items' => $items,
            'sort_order' => $request->validatedNextSort(),
        ]);

        return redirect()->route('dashboard')->with([
            'status' => 'program-group-saved',
            'saved_section' => 'program-groups',
        ])->withFragment('panel-program-groups');
    }

    public function update(ProgramGroupUpdateRequest $request, ProgramGroup $program_group): RedirectResponse
    {
        $items = $request->parsedItems();
        if ($items === []) {
            throw ValidationException::withMessages([
                'items_raw' => ['Добавьте хотя бы одну строку в списке программ.'],
            ]);
        }

        $data = [
            'title' => $request->validated('title'),
            'items' => $items,
        ];

        if ($request->hasFile('image')) {
            if (filled($program_group->image_path)) {
                Storage::disk('public')->delete($program_group->image_path);
            }
            $data['image_path'] = $request->storedImagePathIfUploaded();
        }

        $program_group->update($data);

        return redirect()->route('dashboard')->with([
            'status' => 'program-group-saved',
            'saved_section' => 'program-groups',
        ])->withFragment('panel-program-groups');
    }

    public function destroy(ProgramGroup $program_group): RedirectResponse
    {
        if (filled($program_group->image_path)) {
            Storage::disk('public')->delete($program_group->image_path);
        }

        $program_group->delete();

        return redirect()->route('dashboard')->with([
            'status' => 'program-group-deleted',
            'saved_section' => 'program-groups',
        ]);
    }
}
