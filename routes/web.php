<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SenryuController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMemberController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/info', function () {
    return view('info');
})->name('info');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])
    ->name('login.google');

Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
    ->name('login.google.callback');

Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');

Route::get('/register-user', function () {
    return view('register_user');
})->name('register.user')->middleware('auth');

Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');

Route::post('/groups', [GroupController::class, 'store'])->name('groups.store')->middleware('auth');
Route::post('/group-members', [GroupMemberController::class, 'store'])->name('group_members.store')->middleware('auth');


Route::post('/stamp/store', [StampController::class, 'store'])->name('stamp.store');
Route::get('/stamps/create', [StampController::class, 'create'])->name('stamp.create');
Route::get('/stamps', [StampController::class, 'index'])->name('stamp.index');
Route::delete('/stamps/{stamp}', [StampController::class, 'destroy'])->name('stamp.destroy');

Route::resource('tweets', TweetController::class);

Route::post('/transcribe', [TweetController::class, 'transcribe'])->name('transcribe');
Route::middleware(['auth'])->group(function () {
    Route::resource('tweets', TweetController::class);
});
Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
Route::get('/tweets', [TweetController::class, 'index'])->name('tweets.index');
Route::get('/tweets/messages', [TweetController::class, 'getMessages'])->name('tweets.messages');

Route::get('/chat', function () {
    return view('chat.index');
})->name('chat.index');

Route::get('/conversation-history', [ChatController::class, 'getConversationHistory']);

Route::post('/chat', [ChatController::class, 'handle'])->name('chat');
Route::get('/api/openai-key', [OpenAIController::class, 'getApiKey']);


Route::resource('senryus', SenryuController::class);
Route::post('/senryus/{id}/iine', [SenryuController::class, 'incrementIine'])->name('senryu.incrementIine');
Route::get('/senryu', [SenryuController::class, 'index'])->name('senryu.index');


use App\Http\Controllers\YouTubeController;

Route::get('/youtube', [YouTubeController::class, 'index'])->name('youtube.index');
Route::post('/store', [YouTubeController::class, 'store'])->name('youtube.store');
Route::post('/update-likes/{id}', [YouTubeController::class, 'updateLikes'])->name('youtube.updateLikes');
Route::delete('/destroy/{id}', [YouTubeController::class, 'destroy'])->name('youtube.destroy');
