<?php
use App\Http\Controllers\DataTokoController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\FotoProfileController;
use App\Http\Controllers\DataAkunController;
use App\Http\Controllers\PostinganController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\DaftarUserController;
use App\Http\Controllers\RatingController;
use App\Exports\PostExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Middleware\isLogin;

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

// Route::get('/master', function () {
//    return view('layout.master');
// });

Route::get('/', function () {
    return view('home');
});
Route::view('/home', 'home')->name('home');

Route::get('/from_input', [PagesController::class, 'FromInput'])->name('from_input');
Route::match(['get', 'post'], '/welcome', [PagesController::class, 'welcome'])->name('pages.welcome')->middleware('isLogin');
Route::match(['get', 'post'], '/notifikasi', [PagesController::class, 'notifikasi'])->name('pages.notif')->middleware('isLogin');
Route::match(['get', 'post'], '/kedu', [PagesController::class, 'kedu'])->name('userAdmin.adminHome')->middleware('isLogin');

Route::get('/datatable', function () {
    return view('datatable.index');
});

Auth::routes();

Route::middleware('rate.limit:2,1')->group(function () {
    Route::get('/akun', [ResetPasswordController::class, 'reset-password-from'])->name('akun.reset-password-from')->Middleware('isLogin');
    Route::get('/fotoProfile', [FotoProfileController::class, 'index'])->name('fotoProfile.index')->middleware('isLogin');
    Route::get('/data-akun', [DataAkunController::class, 'index'])->name('dataAkun.index')->middleware('isLogin');
    Route::get('/postingan', [PostinganController::class, 'index'])->name('postingan.index')->middleware('isLogin');
    Route::get('/umum', [PostinganController::class, 'umum'])->name('umum')->middleware('isLogin');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('isLogin');
    Route::get('/statuses', [StatusController::class, 'index'])->name('statuses.index')->middleware('isLogin');
    Route::get('/like', [LikesController::class, 'index'])->name('like.status')->middleware('isLogin');
    Route::get('/follow', [FollowController::class, 'index'])->name('follow.index')->middleware('isLogin');
    Route::get('/data-toko/{userId}', [DataTokoController::class, 'showProfile2'])->name('datatoko.index')->middleware('isLogin');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index')->middleware('isLogin');
    Route::get('/setting', [DataAkunController::class, 'setting'])->name('dataAkun.setting')->middleware('isLogin');
});

// route login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'authenticate'])->name('login.authenticate');

//rute register
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('/edit/{id}', [RegisterController::class, 'edit'])->name('user.edit');
Route::put('/update/{id}', [RegisterController::class, 'update'])->name('update');

//route logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


//reset reset akun
Route::get('/reset/{username}', [ResetPasswordController::class, 'showResetForm'])->name('reset.password.form.show');
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset.password.form.show');

//rute foto profile
Route::get('/images/{username}/upload-image', [FotoProfileController::class, 'showUploadForm'])->name('profile.uploadImageForm');
Route::post('/images/upload-image', [FotoProfileController::class, 'uploadProfileImage'])->name('profile.uploadImage');
Route::post('images/upload', [FotoProfileController::class, 'store'])->name('images.store');
Route::get('/foto-profile/create', [FotoProfileController::class, 'create'])->name('foto-profile.create');
Route::get('/foto-profile/{user_id}/edit', [FotoProfileController::class, 'edit'])->name('foto-profile.edit');
Route::put('/foto-profile/{user_id}', [FotoProfileController::class, 'update'])->name('foto-profile.update');
Route::delete('/foto-profile/{foto_profile}', [FotoProfileController::class, 'destroy'])->name('foto-profile.destroy');
Route::get('images/{imagePath}', [FotoProfileController::class, 'showImage'])->name('images.showImage');

//rute profile
Route::get('/data-akun/create', [DataAkunController::class, 'create'])->name('dataAkun.create');
Route::post('/data-akun', [DataAkunController::class, 'store'])->name('dataAkun.store');
Route::get('/data-akun/{user_id}/edit', [DataAkunController::class, 'edit'])->name('dataAkun.edit');
Route::put('/data-akun/{id}', [DataAkunController::class, 'update'])->name('dataAkun.update');
Route::delete('/data-akun/{user_id}', [DataAkunController::class, 'destroy'])->name('dataAkun.destroy');
Route::get('/profile/{dataAkun}', [DataAkunController::class, 'show'])->name('profile.show');

//rute postingan
Route::get('/postingan/create', [PostinganController::class, 'create'])->name('postingan.create');
Route::post('/postingan', [PostinganController::class, 'store'])->name('postingan.store');
Route::get('/postingan/{id}/edit', [PostinganController::class, 'edit'])->name('postingan.edit');
Route::put('/postingan/{id}', [PostinganController::class, 'update'])->name('postingan.update');
Route::delete('/postingan/{id}', [PostinganController::class, 'destroy'])->name('postingan.destroy');
Route::get('/postingan/{id}', [PostinganController::class, 'show'])->name('postingan.show');
Route::get('/postingan/{id}', [PostinganController::class, 'show'])->name('detailProduct');

//rute product
Route::get('/products/create/{postingan_id}', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/toko-user', [ProductController::class, 'tokoUser'])->name('products.userToko');
Route::get('/tata-tertib', [ProductController::class, 'tataTertib'])->name('products.tata_tertib');
Route::post('/approve-order', [ProductController::class, 'approveOrder'])->name('approve.order');
Route::post('/reject-order', [ProductController::class, 'rejectOrder'])->name('products.rejectOrder');
Route::get('/sales-chart', [ProductController::class, 'salesChart']);
Route::post('/reset-notification-count', [ProductController::class, 'resetNotificationCount'])->name('reset.notification.count');

//rute status
Route::get('/statuses/create', [StatusController::class, 'create'])->name('statuses.create');
Route::post('/statuses', [StatusController::class, 'store'])->name('statuses.store');
Route::get('/status/{status_id}', [StatusController::class, 'show'])->name('status.show');
Route::get('/statuses/{status}/edit', [StatusController::class, 'edit'])->name('statuses.edit');
Route::put('/statuses/{id}', [StatusController::class, 'update'])->name('statuses.update');
Route::delete('/statuses/{id}', [StatusController::class, 'destroy'])->name('statuses.destroy');
Route::delete('/statuses/delete-profile/{id}', [StatusController::class, 'deleteProfile'])->name('statuses.deleteProfile');
Route::post('/commented-statuses/{status}', [StatusController::class, 'addComment'])->name('commented-statuses');
Route::get('/status/count', [StatusController::class, 'getStatusCountByUser'])->name('status.count');


//rute like
Route::post('/add-like/{status_id}', [LikesController::class, 'addLike'])->name('like.add');
Route::post('/add-comment/{status_id}', [LikesController::class, 'addComment'])->name('comment.add');
Route::get('/status/{status_id}/comments', [LikesController::class, 'showComments'])->name('like.comments');
Route::post('/reset-notification-count3', [LikesController::class, 'resetNotificationCount3'])->name('reset.notification.count3');

//rute history
Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.show');

//rute follow
Route::post('/follow/{userId}', [FollowController::class, 'follow'])->name('follow.follow');
Route::post('/unfollow/{userId}', [FollowController::class, 'unfollow'])->name('follow.unfollow');
Route::get('/followers/{userId}', [FollowController::class, 'followers'])->name('follow.followers');
Route::get('/following/{userId}', [FollowController::class, 'following'])->name('follow.following');
Route::get('/follow/{userId}', [FollowController::class, 'showProfile'])->name('follow.profile');
Route::post('/reset-notification-count2', [FollowController::class, 'resetNotificationCount2'])->name('reset.notification.count2');

//rute komentar toko
Route::get('/data-toko/create/{userId}', [DataTokoController::class, 'create'])->name('datatoko.create');
Route::post('/data-toko', [DataTokoController::class, 'store'])->name('datatoko.store');
Route::get('/data-toko/{user_id}/edit', [DataTokoController::class, 'edit'])->name('datatoko.edit');
Route::put('/data-toko/{id}', [DataTokoController::class, 'update'])->name('datatoko.update');
Route::delete('/data-toko/{user_id}', [DataTokoController::class, 'destroy'])->name('datatoko.destroy');

//rute keranjang
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambahItem'])->name('keranjang.tambahItem');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.hapus');

//rute daftar user
Route::get('/logins', [DaftarUserController::class, 'index'])->name('login.index');
Route::get('/user-chart', [LoginController::class, 'userChart']);

//rute rating
Route::get('/rating/create/{postingan_id}', [RatingController::class, 'create'])->name('rating.create');
Route::post('/rating/store', [RatingController::class, 'store'])->name('rating.store');
Route::get('/rating/{id}', [RatingController::class, 'show'])->name('rating.comen');