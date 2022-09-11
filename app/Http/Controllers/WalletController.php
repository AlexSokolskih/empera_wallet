<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public const BOT_TOKEN = '5717737611:AAHWBoCma3HawHq1xkxtRvniwPBUxMNAbK0'; // токен вашего бота

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
                    $this->start($chat_id);
                    break;
                case '/new_wallet':
                    echo "i equals 1";
                    break;
                case '/balance':
                    echo "i equals 2";
                    break;
            }


        }
    }


    // функция отправки сообщени в от бота в диалог с юзером
    private function message_to_telegram($BOT_TOKEN, $chat_id, $text, $reply_markup = '')
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

    private function start ($chat_id){

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


        $this->message_to_telegram( $chat_id, $text_return, $keyboard);
    }
    private function new_wallet(){

    }

    private function balance(){

    }

}
