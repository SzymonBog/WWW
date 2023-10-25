<?php
	//$nr_indeksu = '164345';
	//$nrGrupy = 'I';
	
	include 'labor_164345_1_2.php';
	
	echo 'Szymon Bogdanski ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br/>';
	
	echo 'Zastosowanie metody include()<br/>';
	
	
	define('__ROOT__', dirname(__FILE__));
	require_once(__ROOT__.'/labor_164345_1_2.php');
	echo "A $color $fruit<br/>";
	
	echo 'Zastosowanie metody require_once()<br/>';
	
	
	if ($color == 'red') {
		echo "An $fruit is $color"
	}
?>