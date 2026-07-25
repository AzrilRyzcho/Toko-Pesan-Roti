<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = App\Models\Order::with('user')->get();
foreach ($orders as $o) {
    echo "Order ID: {$o->id} | Code: {$o->order_code} | User: {$o->user->email} (ID: {$o->user_id}) | Payment Status: {$o->payment_status} | Proof: {$o->payment_proof}\n";
}
