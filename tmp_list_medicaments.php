<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meds = Illuminate\Support\Facades\DB::table('medicaments')->limit(20)->get();
foreach ($meds as $m) {
    echo 'Med#' . $m->id . ' nom=' . $m->nom . "\n";
}
