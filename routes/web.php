<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialMediaAccountController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//    ]);
    return view('fbsdk');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/social-accounts', [SocialMediaAccountController::class, 'index'])->name('social-accounts.index');
    Route::get('/social-accounts/create', [SocialMediaAccountController::class, 'create'])->name('social-accounts.create');
    Route::post('/social-accounts', [SocialMediaAccountController::class, 'store'])->name('social-accounts.store');
    Route::delete('/social-accounts/{socialMediaAccount}', [SocialMediaAccountController::class, 'destroy'])->name('social-accounts.destroy');
});


// Mock API
Route::get('/mock-api/ad-accounts', function () {
    return response()->json(json_decode(file_get_contents(resource_path('data/mock/fake_ad_accounts.json'))));
});

Route::get('/mock-api/campaigns', function () {
    return response()->json(json_decode(file_get_contents(resource_path('data/mock/fake_campaigns.json'))));
});

Route::get('/mock-api/adsets', function () {
    return response()->json(json_decode(file_get_contents(resource_path('data/mock/fake_adsets.json'))));
});

Route::get('/mock-api/ads', function () {
    return response()->json(json_decode(file_get_contents(resource_path('data/mock/fake_ads.json'))));
});

Route::get('/mock-api/adcreatives', function () {
    return response()->json(json_decode(file_get_contents(resource_path('data/mock/fake_ad_creatives.json'))));
});

Route::get('/mock-api/insights', function () {
    return response()->json(json_decode(file_get_contents(resource_path('data/mock/fake_insights.json'))));
});


require __DIR__.'/auth.php';
