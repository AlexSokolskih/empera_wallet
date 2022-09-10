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
  $response = Http::post('http://dappsgate.com:88/api/v2/CreateAccount', [
      'Name' => 'PrivTest02',
      'PrivKey' => '7E7C353B062FBCABACE786277A33557AFC8DB53CE088094B44013DC49CFE15BD',
      'Currency' => '0',
      'Confirm' => '1',
  ]);

  $accountFields['result']      = $response->json('result');
  $accountFields['text']        = $response->json('text');
  $accountFields['TxID']        = $response->json('TxID');
  $accountFields['BlockNum']    = $response->json('BlockNum');
  $accountFields['TrNum']       = $response->json('TrNum');


    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
