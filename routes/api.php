<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/', function(){
     $BOT_TOKEN = '5717737611:AAHWBoCma3HawHq1xkxtRvniwPBUxMNAbK0'; // токен вашего бота

    $data = file_get_contents('php://input'); // весь ввод перенаправляем в $data
    $data = json_decode($data, true);
    file_put_contents(storage_path() . '/message.txt', print_r($data, true));

// Основной код: получаем сообщение, что юзер отправил боту и
// заполняем переменные для дальнейшего использования
    if (!empty($data['message']['text'])) {
        $chat_id = $data['message']['from']['id'];
        $user_name = $data['message']['from']['username'];
        $first_name = $data['message']['from']['first_name'];
        $last_name = $data['message']['from']['last_name'];
        $text = trim($data['message']['text']);
        $text_array = explode(" ", $text);


        switch ($text) {
            case '/start':
                $this->start($BOT_TOKEN, $chat_id);
                break;
            case '/new_wallet':
                echo "i equals 1";
                break;
            case '/balance':
                echo "i equals 2";
                break;
        }


    }
});

function start ($BOT_TOKEN, $chat_id){

    $text_return = "Привет я empera_wallet_bot";
    $keyboard = json_encode([
        "inline_keyboard" => [
            [
                [
                    "text" => "Новый",
                    "callback_data" => "new"
                ],
                [
                    "text" => "Существующий",
                    "callback_data" => "/start"
                ],
                [
                    "text" => "Баланс",
                    "callback_data" => "/balance"
                ]
            ]
        ]
    ]);


    message_to_telegram($BOT_TOKEN, $chat_id, $text_return, $keyboard);
}
