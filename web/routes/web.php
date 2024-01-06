<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\Api\User\AddMoneyController as UserAddMoneyController;
use App\Http\Controllers\User\AddMoneyController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Stripe\Stripe;
use Stripe\Issuing\Card;

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

//landing page
Route::controller(SiteController::class)->group(function(){
    Route::get('/','home')->name('index');
    Route::get('about','about')->name('about');
    Route::get('services','services')->name('services');
    Route::get('announcement','blog')->name('announcement');
    Route::get('announcement/details/{id}/{slug}','blogDetails')->name('blog.details');
    Route::get('announcement/by/category/{id}/{slug}','blogByCategory')->name('blog.by.category');
    Route::get('contact','contact')->name('contact');
    Route::post('contact/store','contactStore')->name('contact.store');
    Route::get('change/{lang?}','changeLanguage')->name('lang');
    Route::get('page/{slug}','usefulPage')->name('useful.link');
    Route::get('cookie/accept','cookieAccept')->name('cookie.accept');
    Route::get('cookie/decline','cookieDecline')->name('cookie.decline');
});

//for sslcommerz callback urls(web)
Route::controller(AddMoneyController::class)->prefix("add-money")->name("add.money.")->group(function(){
    //sslcommerz
    Route::post('sslcommerz/success','sllCommerzSuccess')->name('ssl.success');
    Route::post('sslcommerz/fail','sllCommerzFails')->name('ssl.fail');
    Route::post('sslcommerz/cancel','sllCommerzCancel')->name('ssl.cancel');
});
//for sslcommerz callback urls(api)
Route::controller(UserAddMoneyController::class)->prefix("api-add-money")->name("api.add.money.")->group(function(){
    //sslcommerz
    Route::post('sslcommerz/success','sllCommerzSuccess')->name('ssl.success');
    Route::post('sslcommerz/fail','sllCommerzFails')->name('ssl.fail');
    Route::post('sslcommerz/cancel','sllCommerzCancel')->name('ssl.cancel');
});
Route::get('vc',function(){
    $client = new \GuzzleHttp\Client();

// $response = $client->request('POST', 'https://api.sandbox.checkbook.io/v3/account/vcc', [
//   'body' => '{"address":{"city":"Anytown","country":"string","line_1":"1234 N. 1st Street","state":"US","zip":"55555"},"email":"john@example.com","phone":"string"}',
//   'headers' => [
//     'Authorization' => 'bf2d903f19fb444a99d11f10c5be5816:FobBDdUHsyydhysGLlEQtYGXrvUYg7',
//     'accept' => 'application/json',
//     'content-type' => 'application/json',
//   ],
// ]);

// echo $response->getBody();

$response = $client->request('DELETE', 'https://api.sandbox.checkbook.io/v3/account/vcc/f8a0cc39543149489c1704b29c050a36', [
    'headers' => [
      'Authorization' => 'bf2d903f19fb444a99d11f10c5be5816:FobBDdUHsyydhysGLlEQtYGXrvUYg7',
      'accept' => 'application/json',
    ],
  ]);

  echo $response->getBody();

});

