<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuth;
use App\Jobs\SmsSender;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistration;
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
    //return view('welcome');

    $data['recipient'] = "8801962702977";
    $data['message'] = "Queue Working SMS";
    $data['from'] = 'DLITS';

    //SmsSender::dispatch($data);

    dispatch(Mail::to('rakib8315@gmail.com')->send(new UserRegistration()));

    echo "Sms Send";

});

Route::get('registration',[UserAuth::class,'registration']);
Route::post('store',[UserAuth::class,'store'])->name('store');
