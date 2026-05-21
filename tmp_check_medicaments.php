<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ids = [1,2,3,6,7,49,5,21];
$found = Illuminate\Support\Facades\DB::table('medicaments')->whereIn('id', $ids)->pluck('id')->all();
echo 'Found: ' . implode(',', $found) . "\n";
