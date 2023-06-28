<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
 return view('home');
});

Route::get('/pricing', function () {
 return view('pricing');
});

Route::get('/faq', function () {
 return view('faq');
});

Route::get('/assessments/{any}', function ($any) {
 $payload_array = [
  'username'     => 'new_user@gmail.com',
  'user_details' => [
   'first_name' => 'First',
   'last_name'  => 'Last',
   'email'      => 'new_user@gmail.com',
  ],
  'route_prefix' => "/assessments",
 ];

 $payload_string = json_encode($payload_array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

 $hmac_payload = hash_hmac(
  'sha256',
  $payload_string,
  env('SOC_CLIENT_SECRET'),
  true
 );

 $hmac_payload_base_encoded = base64_encode($hmac_payload);

 $soc_allowed_content_screens = explode(",", env('SOC_ALLOWED_CONTENT_SCREENS'));

 return view('socratease-entry', [
  'payload_string'              => $payload_string,
  'hmac_payload'                => $hmac_payload_base_encoded,
  'soc_allowed_content_screens' => $soc_allowed_content_screens,
  'soc_version'                 => env('SOC_VERSION'),
  'soc_client_id'               => env('SOC_CLIENT_ID'),
  'soc_route_prefix'            => env('SOC_ROUTE_PREFIX'),
  'brand_name'                  => env('BRAND_NAME'),
  'soc_api_host'                => env('SOC_API_HOST'),
 ]);

})->where('any', '.*');
