<?php
/**
 * Created by PhpStorm.
 * User: Tenek
 * Date: 2015-05-20
 * Time: 20:20
 */

if (in_array($plik_rozszerzenie, $dozwolone_rozszerzenia, true)) {
    if (move_uploaded_file($plik_lokalizacja, $folder_upload."/".$plik_nazwa)) {
        echo "Plik został zapisany.";
    }else echo"Nie udało się przenieść pliku.";
}else{
    echo "Niedozwolone rozszerzenie pliku.";
}

/* przeniesienie pliku z folderu tymczasowego do właściwej lokalizacji */
if (!move_uploaded_file($plik_lokalizacja, $folder_upload."/".$plik_nazwa)) {
    exit("Nie udało się przenieść pliku.");
}

