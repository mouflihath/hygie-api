<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cmds = App\Models\Commande::with('pharmacie')->orderByDesc('id')->take(30)->get();
foreach ($cmds as $c) {
    $p = $c->pharmacie;
    echo 'Cmd#' . $c->id . ' pharma_id=' . $c->pharmacie_id
        . ' nom_pharmacie=' . ($p?->nom_pharmacie ?? 'NULL')
        . ' name=' . ($p?->name ?? 'NULL')
        . ' email=' . ($p?->email ?? 'NULL') . PHP_EOL;
}
