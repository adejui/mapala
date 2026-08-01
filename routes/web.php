<?php

// --- CONTROLLERS FRONTEND ---

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\ActivityController;
use App\Http\Controllers\Dashboard\ActivityDetailController;
use App\Http\Controllers\Dashboard\ActivityDocumentController;
use App\Http\Controllers\Dashboard\ActivityMemberController;
use App\Http\Controllers\Dashboard\ActivityPhotoController;
use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ItemController;
use App\Http\Controllers\Dashboard\LoanController;
use App\Http\Controllers\Dashboard\LoanDetailController;
use App\Http\Controllers\Dashboard\OpaController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HistoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InventoryController;
use App\Http\Controllers\Frontend\ProfilOpaController;
use App\Http\Controllers\Frontend\ProfilUserController;
use App\Http\Controllers\Frontend\PublicActivityController;
use App\Http\Controllers\Frontend\PublicLoanController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PublicArticleController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ContactMessageController;

// Route::get('/test-mail', function () {
//     $loan = App\Models\Loan::first(); // contoh
//     Mail::to('chestnuthealer@gmail.com')->send(new LoanApprovedMail($loan));
//     return "Email dikirim!";
// });


Route::get('/test-email', function () {
    try {
        Mail::raw('Halo, ini email testing dari Laravel.', function ($message) {
            $message->to('chestnuthealer@gmail.com')
                ->subject('Testing Laravel Gmail SMTP');
        });

        return '<h2>BERHASIL</h2><p>Email berhasil diproses oleh Laravel.</p>';
    } catch (\Throwable $e) {
        return '<h2>GAGAL</h2><pre>' .
            $e->getMessage() .
            '</pre>';
    }
});

// --- FRONTEND ---
Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/contact', [ContactController::class, 'store'])
        ->name('contact.store');

    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact-send', [HomeController::class, 'send'])->name('contact.send');

    Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about');

    Route::get('/user/profile', [ProfilUserController::class, 'index'])->name('user.profile');

    Route::get('/opa/profile', [ProfilOpaController::class, 'index'])->name('opa.profile');
    Route::post('/opa/profile/update', [ProfilOpaController::class, 'update'])->name('opa.profile.update');
    Route::post('/opa/update-photo', [ProfilOpaController::class, 'updatePhotoOpa'])->name('opa.update-photo');
    Route::delete('/opa/delete-photo', [ProfilOpaController::class, 'deletePhotoOpa'])
        ->name('opa.delete-photo');

    // Route::post('/user/profile/passsword', [ProfilUserController::class, 'updatePassword'])->name('user.update.password');
    Route::post('/user/profile/update', [ProfilUserController::class, 'update'])->name('user.profile.update');
    Route::post('/user/profile/password', [ProfilUserController::class, 'updatePassword'])
        ->name('user.update.password');
    Route::post('/user/update-photo', [ProfilUserController::class, 'updatePhoto'])->name('user.update-photo');
    Route::delete('/user/delete-photo', [ProfilUserController::class, 'deletePhoto'])
        ->name('user.delete-photo');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');

    Route::get('/kegiatan', [PublicActivityController::class, 'index'])->name('kegiatan');
    Route::get('/kegiatan/{id}', [PublicActivityController::class, 'show'])->name('kegiatan.show');

    Route::post('/inventory/cart/add/{id}', [InventoryController::class, 'addToCart'])->name('inventory.cart.add');
    Route::post('/inventory/cart/update-qty', [InventoryController::class, 'updateQty'])
        ->name('inventory.cart.updateQty');

    Route::post('/inventory/cart/update/{id}', [InventoryController::class, 'updateCart'])->name('inventory.cart.update');
    Route::post('/inventory/cart/remove/{id}', [InventoryController::class, 'removeFromCart'])->name('inventory.cart.remove');

    Route::get('/pinjaman', [PublicLoanController::class, 'pinjamanForm'])->name('pinjaman');
    Route::post('/pinjaman/store', [PublicLoanController::class, 'store'])->name('pinjaman.store');
    Route::get('/pinjaman/sukses', [PublicLoanController::class, 'success'])->name('pinjaman.success');

    Route::get('/history', [HistoryController::class, 'history'])->name('history');

    Route::get('/artikel', [PublicArticleController::class, 'index'])->name('artikel');
    Route::get('/artikel/{slug}', [PublicArticleController::class, 'show'])->name('artikel.show');
    // Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('frontend.articles.show');
});

/* ===== GOOGLE LOGIN ===== */
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');

Route::middleware('auth:opa')->group(function () {
    Route::post('/logoutt', [GoogleAuthController::class, 'logout'])->name('opa.logout');

    // Route::get('/opa/history', [HistoryController::class, 'opaHistory'])
    //     ->name('history.opa');
});

/* ===== LOGIN MANUAL ===== */
Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

/* ===== LOGOUT ===== */
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Route::get('/history', [HistoryController::class, 'userHistory'])
    //     ->name('history.user');
});


// --- BACKEND ---
// --- Role: Admin dan Logistik ---
Route::middleware(['auth', 'role:admin,logistics'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



    Route::resource('items', ItemController::class);
    Route::get('/items/generate-code/{category}', [ItemController::class, 'generateCode']);

    Route::resource('categories', CategoryController::class);

    Route::resource('loans', LoanController::class);
    Route::get('/notifications/{loan}', [LoanController::class, 'showNotification'])->name('notifications.show');
    Route::get('/loans/manage/{loan}', [LoanController::class, 'manage'])->name('loans.manage');
    Route::post('loans/{loan}/accept', [LoanController::class, 'accept'])->name('loans.accept');
    Route::post('loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::post('loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('loans/{loan}/borrowed', [LoanController::class, 'borrowed'])->name('loans.borrowed');

    Route::resource('loan-details', LoanDetailController::class);
    Route::post('/loans/{loan}/details', [LoanDetailController::class, 'store'])->name('loan-details.store');

    // Export
    Route::get(
        '/categories-export',
        [CategoryController::class, 'export']
    )->name('categories.export');
    Route::get('/items-export', [ItemController::class, 'export'])
        ->name('items.export');
    Route::get('/loans-export', [LoanController::class, 'export'])
        ->name('loans.export');
    Route::get('/borrowers-export', [OpaController::class, 'export'])
        ->name('borrowers.export');
});

// --- Role: Admin ---
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('users', UserController::class);
    Route::put('/users/{id}/photo', [UserController::class, 'updatePhoto'])->name('users.update-photo');
    Route::delete('/users/{id}/photo', [UserController::class, 'deletePhoto'])->name('users.delete-photo');

    Route::get('/generate-nrp-password', [UserController::class, 'generateNrpPassword'])->name('generate.nrp.password');

    Route::resource('opas', OpaController::class);

    Route::get('/activities/events', [ActivityController::class, 'getEvents']);
    Route::resource('activities', ActivityController::class);
    Route::get('/activity-lists', [ActivityController::class, 'listActivity'])->name('list.activity');
    Route::get('/activities/manage/{activity}', [ActivityController::class, 'manage'])->name('manage.activity');

    Route::resource('activity-details', ActivityDetailController::class);
    Route::resource('activity-members', ActivityMemberController::class);
    Route::resource('activity-documents', ActivityDocumentController::class);
    Route::resource('activity-photos', ActivityPhotoController::class);
    Route::resource('articles', ArticleController::class);

    // Export
    Route::get('/users-export', [UserController::class, 'export'])->name('users.export');
    Route::get('/activities-export', [ActivityController::class, 'export'])
        ->name('activities.export');

    Route::prefix('dashboard')->name('messages.')->group(function () {
        Route::get('messages', [ContactMessageController::class, 'index'])->name('index');
        Route::get('messages/export', [ContactMessageController::class, 'export'])->name('export');
        Route::get('messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('show');
        Route::patch('messages/{contactMessage}/mark-as-read', [ContactMessageController::class, 'markAsRead'])->name('markAsRead');
        Route::delete('messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('destroy');
    });
});


// --- Role: Logistik ---
Route::middleware(['auth', 'role:logistics'])->group(function () {

    Route::get('/users/{user}/edit-profile', [UserController::class, 'editProfile'])
        ->name('users.editProfile');
});
