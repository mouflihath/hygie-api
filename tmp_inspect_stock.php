<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$stocks = App\Models\Stock::with('medicament')->take(10)->get();
foreach ($stocks as $s) {
    echo 'Stock#' . $s->id . ' med_id=' . $s->medicament_id . ' nom=' . ($s->medicament ? $s->medicament->nom : 'NULL') . "\n";
}
