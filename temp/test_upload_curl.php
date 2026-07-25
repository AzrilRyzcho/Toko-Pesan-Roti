<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

// Ensure password for azril@gmail.com is set to 'password' for testing
$user = App\Models\User::where('email', 'azril@gmail.com')->first();
if ($user) {
    $user->password = Illuminate\Support\Facades\Hash::make('password');
    $user->save();
}

$baseUrl = 'http://127.0.0.1:8000';
$jar = new CookieJar();
$client = new Client([
    'cookies' => $jar,
    'allow_redirects' => true,
    'http_errors' => false
]);

echo "1. Getting login page CSRF token...\n";
$response = $client->get($baseUrl . '/login');
$body = (string) $response->getBody();

preg_match('/name="_token" value="([^"]+)"/', $body, $matches);
$csrfToken = $matches[1] ?? '';
echo "Initial CSRF Token: " . $csrfToken . "\n";

echo "2. Logging in as azril@gmail.com...\n";
$loginResp = $client->post($baseUrl . '/login', [
    'form_params' => [
        '_token' => $csrfToken,
        'email' => 'azril@gmail.com',
        'password' => 'password'
    ]
]);
echo "Login Status: " . $loginResp->getStatusCode() . "\n";

echo "3. Fetching order page /orders/6 for session CSRF token...\n";
$orderResp = $client->get($baseUrl . '/orders/6');
$orderBody = (string) $orderResp->getBody();

preg_match('/name="_token" value="([^"]+)"/', $orderBody, $matches);
$orderCsrf = $matches[1] ?? '';
echo "Order CSRF Token: " . $orderCsrf . "\n";

echo "4. Submitting payment proof file (temp/sample_proof.jpg)... \n";
$proofPath = __DIR__ . '/sample_proof.jpg';

$uploadResp = $client->post($baseUrl . '/orders/6/proof', [
    'headers' => [
        'X-CSRF-TOKEN' => $orderCsrf,
        'Referer' => $baseUrl . '/orders/6'
    ],
    'multipart' => [
        [
            'name' => '_token',
            'contents' => $orderCsrf
        ],
        [
            'name' => 'payment_proof',
            'contents' => fopen($proofPath, 'r'),
            'filename' => 'sample_proof.jpg',
            'headers'  => ['Content-Type' => 'image/jpeg']
        ]
    ]
]);

echo "Upload Status Code: " . $uploadResp->getStatusCode() . "\n";
$finalBody = (string) $uploadResp->getBody();

if (preg_match('/<div class="alert alert-danger[^">]*">(.*?)<\/div>/s', $finalBody, $errMatch)) {
    echo "RESULT: FAILED with Error: " . trim(strip_tags($errMatch[1])) . "\n";
} elseif (preg_match('/<div class="alert alert-success[^">]*">(.*?)<\/div>/s', $finalBody, $succMatch)) {
    echo "RESULT: SUCCESS with Message: " . trim(strip_tags($succMatch[1])) . "\n";
} else {
    if (preg_match('/<title>(.*?)<\/title>/', $finalBody, $titleMatch)) {
        echo "Page response title: " . $titleMatch[1] . "\n";
    }
}
