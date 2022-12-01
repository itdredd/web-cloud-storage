<?php

use App\Http\Controllers\ProfileController;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/upload', [App\Http\Controllers\UploadController::class, '__invoke'])->name('upload');

//api
Route::get('/api/user/{id}', function ($id) {
    return new UserResource(User::findOrFail($id));
});
Route::get('/api/users', function () {
    return new UserCollection(User::all());
});

//folder
Route::get('/folder', [\App\Http\Controllers\FolderController::class, 'list'])->name('folder.list');
Route::get('/folder/{folder}/show', [\App\Http\Controllers\FolderController::class, 'show'])->name('folder.show');
Route::match(['get', 'post'], '/folder/create', [\App\Http\Controllers\FolderController::class, 'create'])->name('folder.create');

//file
Route::match(['get', 'post'], '/file/upload', [\App\Http\Controllers\FileController::class, 'upload'])->name('file.upload');
Route::get('/file/{id}/download', [\App\Http\Controllers\FileController::class, 'download'])->name('file.download');
Route::get('/file/{id}/delete', [\App\Http\Controllers\FileController::class, 'delete'])->name('file.delete');
Route::match(['get', 'post'],'/file/{id}/rename', [\App\Http\Controllers\FileController::class, 'rename'])->name('file.rename');

require __DIR__.'/auth.php';
