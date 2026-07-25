<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SettingService;

echo "Current Maintenance Mode: " . (SettingService::get('maintenance_mode') ? 'ON' : 'OFF') . "\n";
