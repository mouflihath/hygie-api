<?php
// Usage: php tmp_fill_nom_pharmacie.php
// Prévisualise, sauvegarde et remplit nom_pharmacie = name pour les lignes NULL.

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Démarrage du script tmp_fill_nom_pharmacie.php\n";

$affected = DB::table('pharmacies')->whereNull('nom_pharmacie')->count();
echo "Pharmacies avec nom_pharmacie NULL: $affected\n";

$rows = DB::table('pharmacies')->whereNull('nom_pharmacie')->get();

$timestamp = date('Ymd_His');
$backupDir = __DIR__ . '/storage/tmp';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}
$backupFile = $backupDir . "/pharmacies_nom_pharmacie_backup_{$timestamp}.json";
file_put_contents($backupFile, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Sauvegarde écrite: $backupFile\n";

$previewCount = min(10, count($rows));
if ($previewCount > 0) {
    echo "Aperçu (premières $previewCount lignes):\n";
    for ($i = 0; $i < $previewCount; $i++) {
        $r = $rows[$i];
        echo "id={$r->id} name={$r->name} nom_pharmacie=" . ($r->nom_pharmacie ?? 'NULL') . "\n";
    }
} else {
    echo "Aucun enregistrement à prévisualiser.\n";
}

if ($affected === 0) {
    echo "Rien à modifier. Fin.\n";
    exit(0);
}

// Appliquer la mise à jour
echo "\nApplication: mise à jour de nom_pharmacie = name pour les enregistrements NULL...\n";
$updated = DB::table('pharmacies')->whereNull('nom_pharmacie')->update(['nom_pharmacie' => DB::raw('name')]);

echo "Lignes mises à jour: $updated\n";

$remaining = DB::table('pharmacies')->whereNull('nom_pharmacie')->count();
echo "Restant avec NULL: $remaining\n";

echo "Terminé. Vérifie les sauvegardes dans $backupFile avant de pousser en production.\n";
