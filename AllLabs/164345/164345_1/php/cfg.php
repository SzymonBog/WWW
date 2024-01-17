<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'moja_strona';
$login = 'admin';
$pass = 'admin123';

$link = new mysqli($dbhost,$dbuser,$dbpass,$db) or die("Connect failed: $s\n". $link -> error);

// connect with database
if (!$link) echo '<b>przerwane połączenie</b>';
if(!mysqli_select_db($link, $db)) echo 'nie wybrano bazy';
?>