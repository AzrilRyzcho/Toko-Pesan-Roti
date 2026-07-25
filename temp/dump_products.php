<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Product::all() as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | Image: {$p->image}\n";
}
