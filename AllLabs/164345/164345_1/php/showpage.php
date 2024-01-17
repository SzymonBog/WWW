<?php
// show page from db
function PokazPodstrone($id)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    //czyscimy $id, aby przez GET ktoś nie próbował wykonać ataku SQL INJECTION
    $id_clear = htmlspecialchars($id);
    $link = new mysqli($dbhost,$dbuser,$dbpass,$db);

    $query="SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    //wywoływanie strony z bazy
    if(empty($row['id']))
    {
        $web = '[nie_znaleziono_strony]';
    }
    else
    {
        $web = $row['page_content'];
    }
    return $web;
}

// show page from local files
function PokazPodstroneIDP($idp)
{
    if($_GET['idp'] == '0') {$strona='podstrony/glowna.html';}
    if($_GET['idp'] == '1') {$strona='podstrony/podstrona1.html';}
    elseif($_GET['idp'] == '2') {$strona='podstrony/podstrona2.html';}
    elseif($_GET['idp'] == '3') {$strona='podstrony/podstrona3.html';}
    elseif($_GET['idp'] == '4') {$strona='podstrony/podstrona4.html';}
    elseif($_GET['idp'] == '5') {$strona='podstrony/podstrona5.html';}
    elseif($_GET['idp'] == '6') {$strona='podstrony/kontakt.html';}
    elseif($_GET['idp'] == '7') {$strona='podstrony/filmy.html';}
    elseif($_GET['idp'] == '96') {$strona='podstrony/zarzkat.html';}
    elseif($_GET['idp'] == '97') {$strona='podstrony/zarzkat.html';}
    elseif($_GET['idp'] == '98') {$strona='podstrony/zarzkat.html';}
    elseif($_GET['idp'] == '99') {$strona='podstrony/zarzkat.html';}
    elseif($_GET['idp'] == '100') {$strona='podstrony/zarzstr.html';}
    elseif($_GET['idp'] == '101') {$strona='podstrony/zarzstr.html';}
    elseif($_GET['idp'] == '102') {$strona='podstrony/zarzstr.html';}
    else {$strona='podstrony/glowna.html';}
    return $strona;
}
?>