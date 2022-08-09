<?php
require_once './FileHandler.php';
// az adatszerkezetem, amit minden feladatnál használok egy tömb, ami a sorokat tartalmazza.
$elemek = $resultArray;
$column_ev = 0;
$column_nev = 1;
$column_vegyjel = 2;
$column_rendszam = 3;
$column_felfedezo = 4;

/** 3. Feladat - Elemek száma * */
echo("3. feladat: Elemek száma: " . count($elemek) . '<br>');

/** 4. Feladat - Okori elemek szama * */
$okorielemek = 0;
foreach ($elemek as $elem) {
    if ($elem[0] == 'Ókor') {
        $okorielemek++;
    }
}
echo("4. feladat: Felfedezések száma az ókorban: " . $okorielemek) . '<br>';

/** 5. feladat - Kerjegyn be a felhasznalotol egy vegyjelet! * */
?>
<form method="GET" action="">
    <label for="name">5. feladat: Kérek egy vegyjelet: </label>
    <input type="text" id="vegyjel" name="vegyjel" style="border: 0px">
    <br>
    <?php
    if (isset($_GET['vegyjel'])) {
        $vegyjel = $_GET['vegyjel'];
        
        while (true) {  
            if (print ('Kérek egy vegyjelet: ' . $vegyjel ) . '<br>') {              
            } else {         
                print (preg_match("/^[a-zA-Z0-9]{1,2}$/", $vegyjel)) . '<br>';
            } break;
        } 
        

    /** 6. feladat - Keresse meg az elozo feladatban emgadott elemet es irja ki **/
    $vegyjel_elem = NULL;
    foreach ($elemek as $elem) {
        if (strtolower($elem[$column_vegyjel]) == strtolower($vegyjel)) {
            $vegyjel_elem = $elem;
            break;
        }
    }

    echo("6. feladat: Keresés: ") . '<br>';
    if ($vegyjel_elem != NULL) {
        echo("Az elem vegyjele: " . $vegyjel_elem[$column_vegyjel]) . '<br>';
        echo("Az elem neve: " . $vegyjel_elem[$column_nev]) . '<br>';
        echo("Rendszáma: " . $vegyjel_elem[$column_rendszam]) . '<br>';
        echo("Felfedezés éve: " . $vegyjel_elem[$column_ev]) . '<br>';
        echo("Felfedezo: " . $vegyjel_elem[$column_felfedezo]) . '<br>';
    } else {
        echo("Nincs ilyen elem az adatforrásban!") . '<br>';
    }
 }
    /** 7. Feladat - Leghosszabb idoszak ket felfedezes kozott * */
    $evszamok = [];
    $leghosszabb = 0;

// kigyujtom az evszamokat
    foreach ($elemek as $elem) {
        if (is_numeric($elem[$column_ev])) {
            $evszamok[] = intval($elem[$column_ev]);
        }
    }

    if (count($evszamok) > 0) {
        // evszamokat sorba rendezem
        asort($evszamok);
        $elozo = $evszamok[0];
        for ($i = 1; $i < count($evszamok); $i++) {
            $temp = $evszamok[$i] - $elozo;
            $elozo = $evszamok[$i];
            if ($temp > $leghosszabb) {
                $leghosszabb = $temp;
            }
        }
    }

    echo("7. feladat: $leghosszabb . év volt a leghosszabb idoszak két elem felfedezése között." ) . '<br>';

    /** 8. Feladat - Jelenitse meg azokat az eveket, amelyekben tobb mint harom elemet fedeztek fel * */
    $csoportositva_evek_szerint = [];
    foreach ($elemek as $elem) {
        $ev = $elem[$column_ev];
        if (is_numeric($ev)) {
            if (array_key_exists($ev, $csoportositva_evek_szerint)) {
                ++$csoportositva_evek_szerint[$ev];
            } else {
                $csoportositva_evek_szerint[$ev] = 1;
            }
        }
    }

    echo("8. feladat: Statisztika") . '<br>';
    foreach ($csoportositva_evek_szerint as $key => $value) {
        if ($value > 3) {
            print($key . ': ' . $value . ' db') . '<br>';
        }
    }
