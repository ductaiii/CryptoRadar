

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Models\User;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;

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
// user watchlist
Route::middleware('auth')->group(function () {
    // Watchlist JSON cho frontend sync ban đầu
    Route::get('/watchlist/json', [WatchlistController::class, 'json'])->name('watchlist.json');
    // Thêm 1 coin vào watchlist
    Route::post('/watchlist/add', [WatchlistController::class, 'store'])->name('watchlist.store');
    // xóa coin khỏi watchlist
    Route::delete('/watchlist/by-coin/{coinId}', [WatchlistController::class, 'destroyByCoin'])->name('watchlist.destroyByCoin');
});
// route cho admin


Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:view-any-user'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
});
//Route::prefix('superadmin')->name('superadmin.')
// → Tạo nhóm route có URL bắt đầu bằng /superadmin/... và tên route bắt đầu bằng superadmin.
// Route::resource('users', ...) → Tự sinh các route CRUD (index, create, edit...) cho users.
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'can:create-user'])->group(function () {
    Route::resource('users', SuperAdminUserController::class);
});
require __DIR__.'/auth.php';
