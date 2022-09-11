<?php

namespace App\Services;

class Empera
{
    private const LINK = 'http://dappsgate.com:88';
    private $privateKey;

    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public static function generateKeys()
    {
        $response = Http::get(LINK.'/api/v2/GenerateKeys');

        $keys['PrivKey'] = $response->json('PrivKey');
        $keys['PubKey']  = $response->json('PubKey');

        return($keys);
    }

    public function createAccount($name)
    {

        $response = Http::post(LINK.'/api/v2/CreateAccount', [
            'Name' => $name,
            'PrivKey' => $this->privateKey,
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

    public function getBalance()
    {

    }

    public function getHistoryTransactions()
    {

    }

}
