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

/*Route::get('/', function(){
    $BOT_TOKEN = '5717737611:AAHWBoCma3HawHq1xkxtRvniwPBUxMNAbK0'; // токен вашего бота

    $data = $_GET; //file_get_contents('php://input'); // весь ввод перенаправляем в $data
    $data = json_encode($data);
    file_put_contents(storage_path() . '/message.txt', print_r($data, true));
});*/

Route::post('/', function(){
    $BOT_TOKEN = '5717737611:AAHWBoCma3HawHq1xkxtRvniwPBUxMNAbK0'; // токен вашего бота

    $data = file_get_contents('php://input'); // весь ввод перенаправляем в $data
    $data = json_decode($data, true);
    file_put_contents(storage_path() . '/message.txt', print_r($data, true));

    $message_text = $data->{'message'}->{'text'} ?? '';

// Основной код: получаем сообщение, что юзер отправил боту и
// заполняем переменные для дальнейшего использования
    if (!empty($message_text)) {
/*        $chat_id = $data['message']['from']['id'];
        $user_name = $data['message']['from']['username'];
        $first_name = $data['message']['from']['first_name'];
        $last_name = $data['message']['from']['last_name'];
        $text = trim($data['message']['text']);
        $text_array = explode(" ", $text);  */

        $chat_id    = $data->{'message'}->{'from'}->{'id'};
        $user_name  = $data->{'message'}->{'from'}->{'username'};
        $first_name = $data->{'message'}->{'from'}->{'first_name'};
        $last_name  = $data->{'message'}->{'from'}->{'last_name'};
        $text       = trim($data->{'message'}->{'text'});
        $text_array = explode(" ", $text);


        switch ($text) {
            case '/start':
                start($BOT_TOKEN, $chat_id);
                break;
            case '/new_wallet':
                new_wallet($BOT_TOKEN, $chat_id);
                break;
            case '/balance':
                echo "i equals 2";
                break;
        }


    }
});

function new_wallet($BOT_TOKEN, $chat_id){
    $keys = generateKeys();
    $accountFields = createAccount($chat_id.'', $keys['PrivKey']);



    $text_return = "Создал
    " . " Ключи
    приватный: ".$keys['PrivKey']."
    публичный: ".$keys['PubKey']."
    result: ".$accountFields['result']. "
    text: ". $accountFields['text'] ;

    message_to_telegram($BOT_TOKEN, $chat_id, $text_return);
}

function start ($BOT_TOKEN, $chat_id){

    $text_return = "Привет я empera_wallet_bot
    команды
    /new_wallet /start /balance";
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


function generateKeys()
{
    $response = Http::get('http://dappsgate.com:88'.'/api/v2/GenerateKeys');

    $keys['PrivKey'] = $response->json('PrivKey');
    $keys['PubKey']  = $response->json('PubKey');

    return($keys);
}

function createAccount($name, $privateKey)
{

    $response = Http::post('http://dappsgate.com:88'.'/api/v2/CreateAccount', [
        'Name' => '$name',
        'PrivKey' => $privateKey,
        'Currency' => '0',
        'Confirm' => '1',
    ]);

    $accountFields['result']      = $response->json('result');
    $accountFields['text']        = $response->json('text');
    $accountFields['TxID']        = $response->json('TxID');
    $accountFields['BlockNum']    = $response->json('BlockNum');
    $accountFields['TrNum']       = $response->json('TrNum');

    return $accountFields;

}
