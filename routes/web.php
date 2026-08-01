<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth', 'verified'])->name('user.dashboard');

Route::get('/dashboard', function () {
    $user = auth()->user();

    // redirect based on role
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'hod') return redirect()->route('hod.dashboard');

    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/create', [AdminController::class, 'createHod'])->name('admin.createHod');
    Route::post('/admin/store', [AdminController::class, 'storeHod'])->name('admin.storeHod');
    Route::get('/admin/hodList', [AdminController::class, 'hodList'])->name('admin.hodList');
    Route::get('/admin/thesisList', [AdminController::class, 'thesisList'])->name('admin.thesisList');
    Route::get('/admin/edit/{id}', [AdminController::class, 'editHod'])->name('admin.editHod');
    Route::put('/admin/update/{id}', [AdminController::class, 'updateHod'])->name('admin.updateHod');


    Route::get('/admin/thesis/{thesis}', [AdminController::class, 'thesisDetails'])->name('admin.thesisDetails');
    Route::get('/admin/thesis/{thesis}/pdf', [AdminController::class, 'viewPDF'])->name('admin.viewPDF');
    Route::post('/admin/thesis/{thesis}/download', [AdminController::class, 'downloadPDF'])
        ->name('admin.downloadPDF')
        ->middleware('auth');
});

Route::middleware(['auth', 'hod'])->group(function () {
    Route::get('/hod/dashboard', [HodController::class, 'index'])->name('hod.dashboard');
    Route::get('/hod/ownThesis', [HodController::class, 'myOwnThesis'])->name('hod.myOwnThesis');
    Route::get('/hod/create', [HodController::class, 'createThesis'])->name('hod.createThesis');
    Route::post('/hod/store', [HodController::class, 'storeThesis'])->name('hod.storeThesis');


    Route::get('/hod/allThesis', [HodController::class, 'allThesis'])->name('hod.allThesis');
    Route::get('/hod/requests', [HodController::class, 'viewRequests'])->name('hod.viewRequests');
    Route::post('/hod/requests/{id}/approve', [HodController::class, 'approveRequest'])->name('hod.requestsApprove');
    Route::post('/hod/requests/{id}/reject', [HodController::class, 'rejectRequest'])->name('hod.requestsReject');


    Route::get('/hod/{thesis}/edit', [HodController::class, 'editThesis'])->name('hod.editThesis');
    Route::put('/hod/{thesis}/update', [HodController::class, 'updateThesis'])->name('hod.updateThesis');
    Route::delete('/hod/{thesis}/delete', [HodController::class, 'deleteThesis'])->name('hod.deleteThesis');
    Route::get('/hod/{thesis}', [HodController::class, 'thesisDetails'])->name('hod.thesisDetails');
    Route::get('/hod/{thesis}/pdf', [HodController::class, 'viewPDF'])->name('hod.viewPDF');
    Route::get('/hod/request/{id}/pdf', [HodController::class, 'viewRequestPDF'])->name('hod.viewRequestPDF');
    Route::post('/hod/{thesis}/verify', [HodController::class, 'verifyThesis'])->name('hod.verifyThesis');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/ownThesis', [UserController::class, 'myOwnThesis'])->name('user.myOwnThesis');
    Route::get('/user/allThesis', [UserController::class, 'allThesis'])->name('user.allThesis');
    Route::get('/user/thesis/{thesis}', [UserController::class, 'thesisDetails'])->name('user.thesisDetails');
    Route::get('/user/thesis/{thesis}/pdf', [UserController::class, 'viewPDF'])->name('user.viewPDF');
    Route::post('/user/thesis/{thesis}/download', [UserController::class, 'downloadPDF'])
        ->name('user.downloadPDF')
        ->middleware('auth');
    // request upload routes
    Route::get('/user/request', [UserController::class, 'requestThesis'])->name('user.requestThesis');
    Route::get('/user/request/create', [UserController::class, 'createRequest'])->name('user.createRequest');
    Route::post('/user/request', [UserController::class, 'storeRequest'])->name('user.requestStore');
});



require __DIR__ . '/auth.php';
