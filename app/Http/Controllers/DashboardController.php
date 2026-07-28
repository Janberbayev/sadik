<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSiteContactRequest;
use App\Models\GalleryItem;
use App\Models\ProgramGroup;
use App\Models\SiteContact;
use App\Models\SiteDocument;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'siteContact' => SiteContact::forForm(),
            'programGroups' => ProgramGroup::query()->ordered()->get(),
            'teachers' => Teacher::query()->ordered()->get(),
            'galleryItems' => GalleryItem::query()->ordered()->get(),
            'siteDocuments' => SiteDocument::query()->ordered()->get(),
        ]);
    }

    public function updateSiteContacts(UpdateSiteContactRequest $request): RedirectResponse
    {
        $contact = SiteContact::current() ?? new SiteContact;
        $payload = Arr::except($request->validated(), '_section');
        $contact->fill($payload);
        $contact->save();

        return redirect()->route('dashboard')->with([
            'status' => 'contacts-saved',
            'saved_section' => $request->string('_section')->toString(),
        ]);
    }
}
