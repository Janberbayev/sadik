<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardDocumentsController;
use App\Http\Controllers\DocumentsPageController;
use App\Http\Controllers\GalleryItemController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProgramGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteDocumentController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\SetLocale;
use App\Models\GalleryItem;
use App\Models\ProgramGroup;
use App\Models\SiteContact;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'contactsForHome' => SiteContact::forPublicPage(SiteContact::current()),
        'programGroups' => ProgramGroup::query()->ordered()->get(),
        'teachers' => Teacher::query()->ordered()->get(),
        'galleryItems' => GalleryItem::query()->ordered()->get(),
    ]);
})->name('home');

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->whereIn('locale', SetLocale::SUPPORTED)
    ->name('locale.switch');

// Старые ссылки с языковым префиксом
Route::get('/ru', function () {
    session(['locale' => 'ru']);

    return redirect('/');
});
Route::get('/kk', function () {
    session(['locale' => 'kk']);

    return redirect('/');
});

Route::get('/documents', [DocumentsPageController::class, 'index'])->name('documents.index');
Route::post('/documents', [DocumentsPageController::class, 'storeTitle'])
    ->middleware('auth')
    ->name('documents.titles.store');
Route::get('/documents/{site_document}', [DocumentsPageController::class, 'show'])->name('documents.show');
Route::get('/documents/{site_document}/folder', [DocumentsPageController::class, 'folder'])->name('documents.folder');
Route::post('/documents/{site_document}/folders', [DocumentsPageController::class, 'storeFolder'])
    ->middleware('auth')
    ->name('documents.folders.store');
Route::post('/documents/{site_document}/file', [DocumentsPageController::class, 'storeFile'])
    ->middleware('auth')
    ->name('documents.file.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/contacts', [DashboardController::class, 'updateSiteContacts'])->name('dashboard.contacts.update');

    Route::post('/dashboard/program-groups', [ProgramGroupController::class, 'store'])->name('dashboard.program-groups.store');
    Route::get('/dashboard/program-groups/{program_group}/edit', [ProgramGroupController::class, 'edit'])
        ->name('dashboard.program-groups.edit');
    Route::patch('/dashboard/program-groups/{program_group}', [ProgramGroupController::class, 'update'])
        ->name('dashboard.program-groups.update');
    Route::delete('/dashboard/program-groups/{program_group}', [ProgramGroupController::class, 'destroy'])
        ->name('dashboard.program-groups.destroy');

    Route::post('/dashboard/teachers', [TeacherController::class, 'store'])->name('dashboard.teachers.store');
    Route::get('/dashboard/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('dashboard.teachers.edit');
    Route::patch('/dashboard/teachers/{teacher}', [TeacherController::class, 'update'])->name('dashboard.teachers.update');
    Route::delete('/dashboard/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('dashboard.teachers.destroy');

    Route::post('/dashboard/gallery-items', [GalleryItemController::class, 'store'])->name('dashboard.gallery-items.store');
    Route::get('/dashboard/gallery-items/{gallery_item}/edit', [GalleryItemController::class, 'edit'])->name('dashboard.gallery-items.edit');
    Route::patch('/dashboard/gallery-items/{gallery_item}', [GalleryItemController::class, 'update'])->name('dashboard.gallery-items.update');
    Route::delete('/dashboard/gallery-items/{gallery_item}', [GalleryItemController::class, 'destroy'])->name('dashboard.gallery-items.destroy');
    Route::delete('/dashboard/gallery-items', [GalleryItemController::class, 'bulkDestroy'])->name('dashboard.gallery-items.bulk-destroy');

    Route::post('/dashboard/documents', [SiteDocumentController::class, 'store'])->name('dashboard.documents.store');
    Route::delete('/dashboard/documents/{site_document}', [SiteDocumentController::class, 'destroy'])->name('dashboard.documents.destroy');

    Route::get('/dashboard/docs', [DashboardDocumentsController::class, 'index'])->name('dashboard.docs.index');
    Route::post('/dashboard/docs', [DashboardDocumentsController::class, 'storeTitle'])->name('dashboard.docs.titles.store');
    Route::get('/dashboard/docs/{site_document}', [DashboardDocumentsController::class, 'show'])->name('dashboard.docs.show');
    Route::patch('/dashboard/docs/{site_document}', [DashboardDocumentsController::class, 'renameTitle'])->name('dashboard.docs.title.rename');
    Route::get('/dashboard/docs/{site_document}/folder', [DashboardDocumentsController::class, 'folder'])->name('dashboard.docs.folder');
    Route::post('/dashboard/docs/{site_document}/folders', [DashboardDocumentsController::class, 'storeFolder'])->name('dashboard.docs.folders.store');
    Route::patch('/dashboard/docs/{site_document}/folder', [DashboardDocumentsController::class, 'renameFolder'])->name('dashboard.docs.folder.rename');
    Route::post('/dashboard/docs/{site_document}/file', [DashboardDocumentsController::class, 'storeFile'])->name('dashboard.docs.file.store');
    Route::delete('/dashboard/docs/{site_document}/files/{file}', [DashboardDocumentsController::class, 'destroyFile'])->name('dashboard.docs.file.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
