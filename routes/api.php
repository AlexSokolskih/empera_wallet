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

Route::post('/', function () {
    echo 'qqqq';
    $bot_token = '5717737611:AAHWBoCma3HawHq1xkxtRvniwPBUxMNAbK0'; // токен вашего бота
    $data = file_get_contents('php://input'); // весь ввод перенаправляем в $data
    $data = json_decode($data, true);
    file_put_contents(storage_path().'/message.txt', '$data');





// Основной код: получаем сообщение, что юзер отправил боту и
// заполняем переменные для дальнейшего использования
    if (!empty($data['message']['text'])) {
        $chat_id = $data['message']['from']['id'];
        $user_name = $data['message']['from']['username'];
        $first_name = $data['message']['from']['first_name'];
        $last_name = $data['message']['from']['last_name'];
        $text = trim($data['message']['text']);
        $text_array = explode(" ", $text);

        if ($text == '/help') {
            $text_return = "Привет, $first_name $last_name, вот команды, что я понимаю:
/help - список команд
/about - о нас
";
            message_to_telegram($bot_token, $chat_id, $text_return);
        }
        elseif ($text == '/about') {
            $text_return = "verysimple_bot:
Я пример самого простого бота для телеграм, написанного на простом PHP.
Мой код можно скачивать, дополнять, исправлять. Код доступен в этой статье:
https://www.novelsite.ru/kak-sozdat-prostogo-bota-dlya-telegram-na-php.html
";
            message_to_telegram($bot_token, $chat_id, $text_return);
        }

    }


});
