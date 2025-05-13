<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// Frontend Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;

// Backend (Admin) Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController; // Alias to avoid name conflict
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;

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

require __DIR__.'/auth.php';

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

// --- Frontend Routes (Customer Facing) ---

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Reservation Creation Process
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/confirmation', [ReservationController::class, 'confirmation'])->name('reservations.confirmation'); // Assuming a generic confirmation page

// Optional: User's Reservation History / Management
// If users need to log in to see their reservations, add ->middleware('auth')
// Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
// Route::get('/my-reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
// Route::delete('/my-reservations/{reservation}', [ReservationController::class, 'cancel'])->name('reservations.cancel');


// --- Backend Routes (Admin Panel) ---

// Grouping admin routes with URL prefix 'admin', name prefix 'admin.', and auth middleware
Route::middleware(['auth']) // Ensures only authenticated users can access these routes
    ->prefix('admin')      // Prepends '/admin' to all URLs in this group
    ->name('admin.')       // Prepends 'admin.' to all route names in this group
    ->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resourceful Routes for Admin Management

    // Reservation Management (CRUD)
    Route::resource('reservations', AdminReservationController::class)->names([
        'index' => 'reservations.index',     // admin.reservations.index
        'create' => 'reservations.create',   // admin.reservations.create (Might not be needed if admin only edits/views)
        'store' => 'reservations.store',     // admin.reservations.store (Might not be needed if admin only edits/views)
        'show' => 'reservations.show',       // admin.reservations.show
        'edit' => 'reservations.edit',       // admin.reservations.edit
        'update' => 'reservations.update',   // admin.reservations.update
        'destroy' => 'reservations.destroy', // admin.reservations.destroy
    ]);

    // Table Management (CRUD)
    Route::resource('tables', AdminTableController::class)->names([
        'index' => 'tables.index',     // admin.tables.index
        'create' => 'tables.create',   // admin.tables.create
        'store' => 'tables.store',     // admin.tables.store
        'show' => 'tables.show',       // admin.tables.show (Optional, maybe included in index/edit)
        'edit' => 'tables.edit',       // admin.tables.edit
        'update' => 'tables.update',   // admin.tables.update
        'destroy' => 'tables.destroy', // admin.tables.destroy
    ]);

    // Client Management (Optional - Primarily Index/Show as per guide example)
    // You can add/remove methods using ->only([...]) or ->except([...]) on Route::resource
    Route::resource('clients', AdminClientController::class)->names([
        'index' => 'clients.index',     // admin.clients.index
        'create' => 'clients.create',   // admin.clients.create (If needed)
        'store' => 'clients.store',     // admin.clients.store (If needed)
        'show' => 'clients.show',       // admin.clients.show
        'edit' => 'clients.edit',       // admin.clients.edit (If needed)
        'update' => 'clients.update',   // admin.clients.update (If needed)
        'destroy' => 'clients.destroy', // admin.clients.destroy (If needed)
    ]);

});

// --- Laravel's Default Authentication Routes ---
// If you installed a starter kit like Breeze or Jetstream,
// authentication routes (login, register, password reset, etc.)
// are typically defined elsewhere (e.g., in routes/auth.php or handled by the package).
// If you need to define them manually or ensure they are included:
// require __DIR__.'/auth.php'; // Common practice with Breeze/Jetstream

