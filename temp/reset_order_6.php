<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$order = App\Models\Order::find(6);
if ($order) {
    $order->payment_status = 'unpaid';
    $order->payment_proof = null;
    $order->save();
    echo "Reset Order 6 payment_status to unpaid.\n";
}
