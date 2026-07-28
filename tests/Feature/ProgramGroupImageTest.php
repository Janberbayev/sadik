<?php

use App\Models\ProgramGroup;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('program group store saves uploaded image', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('dashboard.program-groups.store'), [
        'title' => "Test group\n3-4 years",
        'items_raw' => "Line one\nLine two",
        'image' => UploadedFile::fake()->create('group.jpg', 100, 'image/jpeg'),
    ]);

    $response->assertRedirect(route('dashboard').'#panel-program-groups');

    $group = ProgramGroup::query()->where('title', 'like', 'Test group%')->first();

    expect($group)->not->toBeNull();
    expect($group->image_path)->not->toBeNull();
    Storage::disk('public')->assertExists($group->image_path);
});

test('program group update replaces uploaded image', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $group = ProgramGroup::query()->create([
        'title' => 'Old',
        'items' => ['One'],
        'sort_order' => 0,
    ]);

    $response = $this->actingAs($user)->post(route('dashboard.program-groups.update', $group), [
        '_method' => 'patch',
        'title' => 'Old',
        'items_raw' => 'One',
        'image' => UploadedFile::fake()->create('new.jpg', 100, 'image/jpeg'),
    ]);

    $response->assertRedirect(route('dashboard').'#panel-program-groups');

    $group->refresh();
    expect($group->image_path)->not->toBeNull();
    Storage::disk('public')->assertExists($group->image_path);
});
