<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/dashboard', [WelcomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

Route::get('/elements', [ElementController::class, 'index']);
Route::post('/elements', [ElementController::class, 'store']);
Route::get('/elements/{section_id}/create', [ElementController::class, 'create']);
Route::get('/elements/{id}', [ElementController::class, 'show']);
Route::put('/elements/{id}', [ElementController::class, 'update']);
Route::get('/elements/{id}/edit', [ElementController::class, 'edit']);
Route::get('/elements/{id}/sure', [ElementController::class, 'sure']);
Route::get('/elements/{id}/destroy', [ElementController::class, 'destroy']);

Route::get('/sections', [SectionController::class, 'index']);
Route::post('/sections', [SectionController::class, 'store']);
Route::get('/sections/create', [SectionController::class, 'create']);
Route::get('/sections/{id}', [SectionController::class, 'show']);
Route::put('/sections/{id}', [SectionController::class, 'update']);
Route::get('/sections/{id}/edit', [SectionController::class, 'edit']);
Route::get('/sections/{id}/sure', [SectionController::class, 'sure']);
Route::get('/sections/{id}/destroy', [SectionController::class, 'destroy']);
Route::get('/sections/{id}/on', [SectionController::class, 'on']);
Route::get('/sections/{id}/off', [SectionController::class, 'off']);


Route::get('/slideshows', [SlideshowController::class, 'index']);
Route::get('/slideshows/{admin}/list', [SlideshowController::class, 'list']);
Route::post('/slideshows', [SlideshowController::class, 'store']);
Route::get('/slideshows/create', [SlideshowController::class, 'create']);
Route::get('/slideshows/{admin}/one', [SlideshowController::class, 'one']);
Route::get('/slideshows/one', [SlideshowController::class, 'one']);
Route::get('/slideshows/{id}', [SlideshowController::class, 'show']);
Route::put('/slideshows/{id}', [SlideshowController::class, 'update']);
Route::get('/slideshows/{id}/edit', [SlideshowController::class, 'edit']);
Route::get('/slideshows/{id}/sure', [SlideshowController::class, 'sure']);
Route::get('/slideshows/{id}/destroy', [SlideshowController::class, 'destroy']);
Route::get('/slideshows/{year}/{admin}/year', [SlideshowController::class, 'year']);
Route::get('/slideshows/{id}/view', [SlideshowController::class, 'view']);

Route::get('/rituals', [RitualController::class, 'index']);
Route::post('/rituals', [RitualController::class, 'store']);
Route::get('/rituals/{admin}/list', [RitualController::class, 'list']);
Route::get('/rituals/create', [RitualController::class, 'create']);
Route::get('/rituals/one', [RitualController::class, 'one']);
Route::get('/rituals/{id}', [RitualController::class, 'show']);
Route::put('/rituals/{id}', [RitualController::class, 'update']);
Route::get('/rituals/{id}/edit', [RitualController::class, 'edit']);
Route::get('/rituals/{id}/sure', [RitualController::class, 'sure']);
Route::get('/rituals/{id}/destroy', [RitualController::class, 'destroy']);
Route::get('/rituals/{year}/{admin}/year', [RitualController::class, 'year']);
Route::get('/rituals/{id}/display', [RitualController::class, 'display']);
Route::get('/rituals/{id}/text', [RitualController::class, 'text']);
Route::get('/rituals/{id}/view', [RitualController::class, 'view']);
Route::get('/rituals/{id}/uploadlit', [GroveController::class, 'uploadlit']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/list', [BookController::class, 'list']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{cat}/cat', [BookController::class, 'cat']);
Route::get('/books/{id}/edit', [BookController::class, 'edit']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::get('/books/create', [BookController::class, 'create']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/{id}/sure', [BookController::class, 'sure']);
Route::get('/books/{id}/destroy', [BookController::class, 'destroy']);

Route::get('/contact', [ContactController::class, 'contactus']);
Route::get('/contacts/thanks', [ContactController::class, 'thanks']);
Route::post('/contacts/submit', [ContactController::class, 'submit']);
Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/contacts/{id}/spam', [ContactController::class, 'spam']);
Route::get('/contacts/{id}/reply', [ContactController::class, 'reply']);
Route::get('/contacts/{type}/list', [ContactController::class, 'list']);

Route::get('/grove/setup', [GroveController::class, 'setup']);
Route::get('/grove/hack', [GroveController::class, 'hack']);
Route::post('/grove/litfile', [GroveController::class, 'litfile']);
Route::post('/grove/picfile', [GroveController::class, 'picfile']);
Route::post('/grove/uploadFile', [GroveController::class, 'uploadfile']);
Route::get('/grove/upload', [GroveController::class, 'upload']);
Route::get('/grove/bylaws', [GroveController::class, 'bylaws']);
Route::get('/grove/pay', [GroveController::class, 'pay']);
Route::get('/grove/donate', [GroveController::class, 'donate']);
Route::get('/schedule', [GroveController::class, 'schedule']);
Route::put('/schedupdt/{id}', [GroveController::class, 'schedupdt']);
Route::get('/grove/', [GroveController::class, 'index']);

Route::get('/liturgy/find', [LiturgyController::class, 'find']);
Route::post('/liturgy/list', [LiturgyController::class, 'list']);
Route::get('/liturgy/{id}/get', [LiturgyController::class, 'get']);Route::get('/venues', [VenueController::class, 'index']);

Route::post('/venues', [VenueController::class, 'store']);
Route::get('/venues/create', [VenueController::class, 'create']);
Route::get('/venues/{id}', [VenueController::class, 'show']);
Route::put('/venues/{id}', [VenueController::class, 'update']);
Route::get('/venues/{id}/edit', [VenueController::class, 'edit']);
Route::get('/venues/{id}/sure', [VenueController::class, 'sure']);
Route::get('/venues/{id}/destroy', [VenueController::class, 'destroy']);

Route::get('/members', [MemberController::class, 'index']);
Route::get('/members/full', [MemberController::class, 'full']);
Route::get('/members/restore', [MemberController::class, 'restore']);
Route::get('/members/create', [MemberController::class, 'create']);
Route::post('/members', [MemberController::class, 'store']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::get('/members/{id}/edit', [MemberController::class, 'edit']);
Route::get('/members/{id}/sure', [MemberController::class, 'sure']);
Route::get('/members/{id}/destroy', [MemberController::class, 'destroy']);
Route::get('/members/join', [MemberController::class, 'join']);
Route::post('/members/join', [MemberController::class, 'savejoin']);


Route::get('/users', [UserController::class, 'index']);
Route::post('/users/create', [UserController::class, 'create']);
Route::put('/users/{id}/make', [UserController::class, 'make']);
Route::put('/users/{id}/superuser', [UserController::class, 'superuser']);
Route::put('/users/{id}/update', [UserController::class, 'update']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::get('/users/{id}/sure', [UserController::class, 'sure']);
Route::get('/users/{id}/destroy', [UserController::class, 'destroy']);

Route::get('/roles/create', [RoleController::class, 'create']);
Route::post('/roles/store', [RoleController::class, 'store']);
Route::get('/roles/{name}/sure', [RoleController::class, 'sure']);
Route::get('/roles/{name}/destroy', [RoleController::class, 'destroy']);
Route::get('/roles/pcreate', [RoleController::class, 'pcreate']);
Route::post('/roles/pstore', [RoleController::class, 'pstore']);
Route::get('/roles/{name}/edit', [RoleController::class, 'edit']);
Route::get('/roles/{name}/{pname}/remove', [RoleController::class, 'remove']);
Route::get('/roles/{name}/add', [RoleController::class, 'add']);
Route::get('/roles/{name}/set', [RoleController::class, 'set']);
Route::get('/roles/{name}/psure', [RoleController::class, 'psure']);
Route::get('/roles/{name}/pdestroy', [RoleController::class, 'pdestroy']);

Route::put('/announcements/{id}/update', [AnnouncementController::class, 'update']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::post('/announcements', [AnnouncementController::class, 'store']);
Route::get('/announcements/create', [AnnouncementController::class, 'create']);
Route::get('/announcements/{id}', [AnnouncementController::class, 'show']);
Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit']);
Route::get('/announcements/{id}/sure', [AnnouncementController::class, 'sure']);
Route::get('/announcements/{id}/destroy', [AnnouncementController::class, 'destroy']);
Route::get('/announcements/{id}/activate', [AnnouncementController::class, 'activate']);
Route::get('/announcements/{id}/uploadpic', [GroveController::class, 'uploadpic']);

Route::get('/votes', [VoteController::class, 'index']);
Route::get('/votes/admin', [VoteController::class, 'admin']);
Route::put('/votes/voted', [VoteController::class, 'voted']);
Route::post('/votes', [VoteController::class, 'store']);
Route::get('/votes/{id}/edit', [VoteController::class, 'edit']);
Route::get('/votes/{id}/sure', [VoteController::class, 'sure']);
Route::get('/votes/{id}/destroy', [VoteController::class, 'destroy']);
Route::get('/votes/review', [VoteController::class, 'review']);
Route::get('/votes/look/{id}', [VoteController::class, 'look']);
Route::get('/votes/reopen/{id}', [VoteController::class, 'reopen']);
Route::post('/votes/create', [VoteController::class, 'create']);

Route::get('/roles', [RoleController::class, 'roles']);
Route::get('/permissions', [RoleController::class, 'permissions']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
