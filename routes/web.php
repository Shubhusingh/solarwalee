<?php

use App\Models\SingleRowData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lead\LeadStatusController;

use App\Http\Controllers\HomeController;

Route::get('/', function () {


    return view('auth.login');
});



Route::get('lang/{locale}', function($locale){
    if (! in_array($locale, ['en', 'hi'])) {
        abort(400);
    }
    App::setLocale($locale);
    session()->put('applocale', $locale);
    return redirect()->back();
});

Auth::routes([
    'register'=>false
]);


Route::get('/home', [HomeController::class, 'index'])->name('home');
 Route::get('/lead/interest', [LeadStatusController::class, 'interest'])->name('lead.status');


