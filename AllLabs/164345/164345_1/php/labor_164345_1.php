<?php
$nr_indeksu = '164345';
$nrGrupy = 'I';

echo 'Szymon Bogdanski ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br/>';

echo 'Zastosowanie metody include()<br/>';

include 'labor_164345_1_2.php';

echo "A $color $fruit<br/>";

define('_ROOT_', dirname(__FILE__));
require_once(_ROOT_.'/labor_164345_1.php');
echo 'Szymon Bogdanski ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br/>';

echo '<br/>';
echo 'Punkt b) Warunki if, else, elseif, switch<br/>';

$ocena = 3;

if ($ocena >= 4.5) {
    echo 'Ocena jest bardzo dobra';
} elseif ($ocena >= 3.5) {
    echo 'Ocena jest dobra';
} else {
    echo 'Ocena jest niedostateczna';
}

echo '<br/>';

$dzienTygodnia = 'wtorek';

switch ($dzienTygodnia) {
    case 'poniedziałek':
        echo 'Dziś jest poniedziałek.';
        break;
    case 'wtorek':
        echo 'Dziś jest wtorek.';
        break;
    case 'środa':
        echo 'Dziś jest środa.';
        break;
    default:
        echo 'Dziś jest inny dzień tygodnia.';
}


echo '<br/>';

echo '<br/>';
echo 'Punkt c) Pętla while() i for()<br/>';

$licznikWhile = 1;
while ($licznikWhile <= 4) {
    echo "Pętla while, iteracja numer: $licznikWhile<br/>";
    $licznikWhile++;
}

for ($i = 1; $i <= 4; $i++) {
    echo "Pętla for, iteracja numer: $i<br/>";
}

echo '<br/>';
echo 'Punkt d) Typy zmiennych $_GET, $_POST, $_SESSION<br/>';

if (isset($_GET['parametr'])) {
    $parametrGet = $_GET['parametr'];
    echo "Zmienna \$parametrGet (z $_GET): $parametrGet<br/>";
} else {
    echo 'Brak zmiennej $_GET "parametr".<br/>';
}

if (isset($_POST['formularz'])) {
    $formularzPost = $_POST['formularz'];
    echo "Zmienna \$formularzPost (z $_POST): $formularzPost<br/>";
} else {
    echo 'Brak zmiennej $_POST "formularz".<br/>';
}

session_start();
if (isset($_SESSION['sesja'])) {
    $sesjaSession = $_SESSION['sesja'];
    echo "Zmienna \$sesjaSession (z $_SESSION): $sesjaSession<br/>";
} else {
    echo 'Brak zmiennej $_SESSION "sesja".<br/>';
}
?>