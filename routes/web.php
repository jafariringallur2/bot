<?php

use Illuminate\Support\Facades\Http;
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

    $response_msg = "Hi";
    if($message == "/start"){
        $response_msg = "Hello! How can I help you today? I'm an AI chatbot created by Jafar Swadhique.";
    }else{
        $url = 'https://api.aichatting.net/aigc/chat';
        $data = [
            'content' => $message,
        ];
    
        $response = Http::post($url, $data);
        
        if ($response->successful()) {
            $responseData = $response->json();
            $response_msg = $responseData['data']['replyContent'] ?? "something went wrong";
        }else{
            $response_msg = "something went wrong";
        }
    }
    // Send the response back to the user
    Telegram::sendMessage([
        'chat_id' => $update['message']['chat']['id'],
         'text' => $response_msg
    ]);
    return response('OK');
});