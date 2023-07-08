<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

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

// Example of POST Route:
Route::post('/<token>/webhook', function () {
  
    $update = Telegram::getWebhookUpdate();
    $message = $update['message']['text'];
   
    // Send the response back to the user
    Telegram::sendMessage([
        'chat_id' => $update['message']['chat']['id'],
        'text' => $message,
    ]);
    return response('OK');
});