<?php

require_once './FileHandler.php';
// az adatszerkezetem, amit minden feladatnál használok egy tömb, ami a sorokat tartalmazza.
// taxi_id;indulas;idotartam;tavolsag;viteldij;borravalo;fizetes_modja
$fuvaradatok = $resultArray;
$column_taxi_azonosito = 0;
$column_indulas = 1;
$column_idotartam = 2;
$column_tavolsag = 3;
$column_dij = 4;
$column_borravalo = 5;
$column_fizetesimod = 6;

function rendezes_indulas($a, $b) {
    global $column_indulas, $column_indulas;
    return strcmp($a[$column_indulas], $b[$column_indulas]);
}

echo "3. Feladat. <br>";
/** 3. Feladat - Hany utazas kerult feljegyzesre * */
echo('Utazások száma:' . count($fuvaradatok)) . '<br>';

echo ('4. feladat.:') . '<br>';
/** 4. Feladat - 6185-ös taxisnak mennyi volt a bevetele * */
$bevetel = 0;
$fuvarokszama = 0;
foreach ($fuvaradatok as $fuvar) {
    if ($fuvar[$column_taxi_azonosito] == "6185") {
        $fuvarokszama++;
        $bevetel = ((float)$fuvar[$column_dij] + (float)$fuvar[$column_borravalo]);
    }
}

echo("fuvar: " . $fuvarokszama .'alatt:' . $bevetel) . '<br>';

echo("5. feladat:") . '<br>';
/** 5. Feladat - Osszesitse, hogy egyes fizetesi modokat hanyszor valasztottak az utazasok soran * */
$csoportositva_fizetesimod = [];
foreach ($fuvaradatok as $fuvar) {
    $fizetesimod = $fuvar[$column_fizetesimod];
    if (array_key_exists($fizetesimod, $csoportositva_fizetesimod)) {
        ++$csoportositva_fizetesimod[$fizetesimod];
    } else {
        $csoportositva_fizetesimod[$fizetesimod] = 1;
    }
}

foreach ($csoportositva_fizetesimod as $key => $value) {
    echo( $key .': '. $value . " fuvar") . '<br>';
}


echo("6. feladat:") . '<br>';
/** 6. Feladat - Osszesen hany km-t tettek meg a taxisok ( 1 mérföld = 1.6 km ) * */
$osszeskm = 0.0;
foreach ($fuvaradatok as $fuvar) {
    $osszeskm += (float)$fuvar[$column_tavolsag] * 1.6;
}
echo(round($osszeskm,2) . 'km') . '<br>';

echo("7. feladat:") . '<br>';
/** 7. Feladat - Irja ki idoben a leghosszabb fuvar adatait * */
if (count($fuvaradatok) > 0) {
    $leghosszabb = NULL;
    foreach ($fuvaradatok as $fuvar) {
        if ($leghosszabb == NULL || $leghosszabb[$column_idotartam] < $fuvar[$column_idotartam]) {
            $leghosszabb = $fuvar;
        }
    }
    echo("Leghosszabb fuvar: ") . '<br>';
    echo("Fuvar hossza másodpercben: " . $leghosszabb[$column_idotartam]) . '<br>';
    echo("Taxi azonosító: " . $leghosszabb[$column_taxi_azonosito]) . '<br>';
    echo("Megtett távolság: " . $leghosszabb[$column_tavolsag] . 'km') . '<br>'; // minta km-et ír, de merföld az adat, mintát követem
    echo("Viteldij: " . $leghosszabb[$column_dij]) . '<br>';
}


echo("8. feladat:") . '<br>';
/** 8. Feladat - Hibak.txt * */
// idotartam es viteldij > 0, tavolsag == 0
// indulasi idopont szerint novekvo
$hibasak = [];
foreach ($fuvaradatok as $fuvar) {
    if ((float)$fuvar[$column_tavolsag] == 0.0 && (float)$fuvar[$column_dij] > 0.0 && (float)$fuvar[$column_idotartam] > 0.0) {
        $hibasak[] = $fuvar;
    }
}

// kimentem fajlba az eredmenyt
$output = fopen("hibak.txt", 'w+');
fwrite($output, "taxi_id;indulas;idotartam;tavolsag;viteldij;borravalo;fizetes_modja\r\n");
foreach($hibasak as $fuvar) {
    $line = ($fuvar[0].';'.$fuvar[1].';'.$fuvar[2].';'.($fuvar[3]).';'.($fuvar[4]).';'.($fuvar[5]).';'.$fuvar[6]); 
    fwrite($output, $line);
}
fclose($output);
echo("hibak.txt");
