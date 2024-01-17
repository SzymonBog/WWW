<!DOCTYPE html>
<html>

<head>
<style>
/*body {
	background-image: url("background.jpg");
	background-size: cover;
	background-repeat: no-repeat;
	background-color: navy;
	color: white;
	} */
h1 {
	color: gray;
	margin-left: 40px;
	}
</style>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="js/kolorujtlo.js" type="text/javascript"></script>
<script src="js/timedate.js" type="text/javascript"></script>

<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="Author" content="Szymon Bogdański" />
<title>Moje hobby to tworzenie gier komputerowych</title>
</head>

<body onload="startclock()">
    <div id="zegarek"></div>
    <div id="data"></div>
<?php
include("php/cfg.php");
include("php/contact.php");
include("php/showpage.php");
include("admin/admin.php");
//include("categories.php");
include("php/cart.php");

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
/* po tym komentarzu będzie kod do dynamicznego ładowania stron */
//$strona = "podstrony/glowna.html";
//include($strona);

$dbFail = False;

if($_GET['id']=='1'){
	echo PokazPodstrone(1);
} elseif($_GET['id']=='2'){
	echo PokazPodstrone(2);
} elseif($_GET['id']=='3'){
	echo PokazPodstrone(3);
} elseif($_GET['id']=='4'){
	echo PokazPodstrone(4);
} elseif($_GET['id']=='5'){
	echo PokazPodstrone(5);
} elseif($_GET['id']=='6'){
	echo PokazPodstrone(6);
} elseif($_GET['id']=='7'){
	echo PokazPodstrone(7);
	echo PokazKontakt();
	WyslijMailaKontakt("log@wp.pl");
	PrzypomnijHaslo("log@wp.pl");
} elseif($_GET['id']=='8'){
	echo PokazPodstrone(8);
} elseif($_GET['id']=='98'){
	include(PokazPodstrone(9));
	echo DodajKategorie();
} elseif($_GET['id']=='99'){
	include(PokazPodstrone(9));
	EdytujKategorie($_GET['val']);
} elseif($_GET['id']=='101'){
	include(PokazPodstrone(9));
	echo DodajPodstrone();
} elseif($_GET['id']=='102'){
	include(PokazPodstrone(9));
	echo EdytujPodstrone($_GET['val']);
} else {
	$dbFail = True;
	//echo PokazPodstrone(1);
}

if($dbFail == True){
	if($_GET['idp']=='0'){
		include(PokazPodstroneIDP(0));
	} elseif($_GET['idp']=='1'){
		include(PokazPodstroneIDP(1));
	} elseif($_GET['idp']=='2'){
		include(PokazPodstroneIDP(2));
	} elseif($_GET['idp']=='3'){
		include(PokazPodstroneIDP(3));
	} elseif($_GET['idp']=='4'){
		include(PokazPodstroneIDP(4));
	} elseif($_GET['idp']=='5'){
		include(PokazPodstroneIDP(5));
	} elseif($_GET['idp']=='6'){
		include(PokazPodstroneIDP(6));
		echo PokazKontakt();
		WyslijMailaKontakt("log@wp.pl");
		PrzypomnijHaslo("log@wp.pl");
	} elseif($_GET['idp']=='7'){
		include(PokazPodstroneIDP(7));
	} elseif($_GET['idp']=='98'){
		include(PokazPodstroneIDP(8));
		echo DodajKategorie();
	} elseif($_GET['idp']=='99'){
		include(PokazPodstroneIDP(8));
		echo EdytujKategorie($_GET['val']);
	} elseif($_GET['idp']=='101'){
		include(PokazPodstroneIDP(9));
		echo DodajPodstrone();
	} elseif($_GET['idp']=='102'){
		include(PokazPodstroneIDP(9));
		echo EdytujPodstrone($_GET['val']);
	} elseif($_GET['idp']=='103'){
		include(PokazPodstroneIDP(8));
		EditForm($_GET['val']);
	} else {
		echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=0";</script>';
		//include(PokazPodstroneIDP(1));
	}
}

?>

<?php
$nr_indeksu = '164345';
$nrGrupy = '1';

echo 'Autor: Szymon Bogdański '. $nr_indeksu.' grupa: '. $nrGrupy.'<br/><br/>';
?>

</body>
</html>