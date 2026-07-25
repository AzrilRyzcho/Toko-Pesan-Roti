<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'azril@gmail.com')->first();
auth()->login($user);

$filePath = __DIR__ . '/sample_proof.jpg';
$file = new Illuminate\Http\UploadedFile(
    $filePath,
    'sample_proof.jpg',
    'image/jpeg',
    null,
    true
);

$orderService = app(App\Services\OrderService::class);
try {
    $updatedOrder = $orderService->uploadPaymentProof(6, $file);
    echo "SUCCESS! Updated order payment status: {$updatedOrder->payment_status}\n";
    echo "Payment proof path: {$updatedOrder->payment_proof}\n";
    echo "File exists in storage: " . (Illuminate\Support\Facades\Storage::disk('public')->exists($updatedOrder->payment_proof) ? 'YES' : 'NO') . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
