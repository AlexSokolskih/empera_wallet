<?php

use Illuminate\Support\Facades\Route;

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
/*Route::post('/', function () {
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/


// функция отправки сообщени в от бота в диалог с юзером
function message_to_telegram($BOT_TOKEN, $chat_id, $text, $reply_markup = '')
{
    $ch = curl_init();
    $ch_post = [
        CURLOPT_URL => 'https://api.telegram.org/bot' . $BOT_TOKEN . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
            'reply_markup' => $reply_markup,
        ]
    ];

    curl_setopt_array($ch, $ch_post);
    curl_exec($ch);

}



require __DIR__.'/auth.php';
