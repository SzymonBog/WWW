<?php

// add item to db
function DodajProdukt($tytul, $opis, $dataDod, $dataEd, $dataWyg, $cenaNetto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    $query = "INSERT INTO products (nazwa, opis, dataUtworzenia, dataModyfikacji, dataWygasniecia, cenaNetto, vat, ilosc, dostepny, kategoria, gabaryt, zdjecie) 
              VALUES ('$tytul', '$opis', '$dataDod', '$dataEd', '$dataWyg', '$cenaNetto', '$vat', '$ilosc', '$status', '$kategoria', '$gabaryt', '$zdjecie')";

    if ($link->query($query) === TRUE) {
        echo "Dodano nowy produkt.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

// remove item from db
function UsunProdukt($id) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    $query = "DELETE FROM products WHERE id = '$id'";

    if ($link->query($query) === TRUE) {
        echo "Usunięto produkt.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

// edit item in db
function EdytujProdukt($id, $tytul, $opis, $dataEd, $dataWyg, $cenaNetto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    $query = "UPDATE products SET 
              nazwa='$tytul', opis='$opis', dataModyfikacji='$dataEd', dataWygasniecia='$dataWyg', cenaNetto='$cenaNetto', vat='$vat', ilosc='$ilosc', dostepny='$status', 
              kategoria='$kategoria', gabaryt='$gabaryt', zdjecie='$zdjecie' WHERE id='$id'";

    if ($link->query($query) === TRUE) {
        echo "Zaktualizowano produkt.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

// show all items from db
function PokazProdukty() {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    $query = "SELECT * FROM products";
    $result = $link->query($query);

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nazwa</th><th>Opis</th><th>Data Utworzenia</th><th>Data Modyfikacji</th><th>Data Wygaśnięcia</th><th>Cena</th><th>VAT</th><th>Ilość</th><th>Status</th><th>Kategoria</th><th>Gabaryt</th><th>Zdjęcie</th><th>Akcje</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.$row['id'].'</td>';
            echo '<td>'.$row['nazwa'].'</td>';
            echo '<td>'.$row['opis'].'</td>';
            echo '<td>'.$row['dataUtworzenia'].'</td>';
            echo '<td>'.$row['dataModyfikacji'].'</td>';
            echo '<td>'.$row['dataWygasniecia'].'</td>';
            echo '<td>'.$row['cenaNetto'].'</td>';
            echo '<td>'.$row['vat'].'</td>';
            echo '<td>'.$row['ilosc'].'</td>';
            echo '<td>'.$row['dostepny'].'</td>';
            echo '<td>'.$row['kategoria'].'</td>';
            echo '<td>'.$row['gabaryt'].'</td>';
            echo '<td>';
            echo '<img src="obrazki/' . $row['zdjecie'] . '" alt="Brak zdjęcia">';
            echo '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<input type="submit" name="delete" value="Usuń">';
            echo '</form>';

            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<input type="hidden" name="nazwa" value="'.$row['nazwa'].'">';
            echo '<input type="hidden" name="opis" value="'.$row['opis'].'">';
            echo '<input type="hidden" name="dataDodania" value="'.$row['dataUtworzenia'].'">';
            echo '<input type="hidden" name="dataModyfikacji" value="'.$row['dataModyfikacji'].'">';
            echo '<input type="hidden" name="dataWygasniecia" value="'.$row['dataWygasniecia'].'">';
            echo '<input type="hidden" name="cenaNetto" value="'.$row['cenaNetto'].'">';
            echo '<input type="hidden" name="vat" value="'.$row['vat'].'">';
            echo '<input type="hidden" name="ilosc" value="'.$row['ilosc'].'">';
            echo '<input type="hidden" name="dostepny" value="'.$row['dostepny'].'">';
            echo '<input type="hidden" name="kategoria" value="'.$row['kategoria'].'">';
            echo '<input type="hidden" name="gabaryt" value="'.$row['gabaryt'].'">';
            echo '<input type="hidden" name="zdjecie" value="'.$row['zdjecie'].'">';
            echo '<input type="submit" name="editprod" value="Edytuj">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '<tr>';
        echo '<td>';
        // Formularz dodawania nowego produktu
        echo '<form method="post" action="" enctype="multipart/form-data">';
        echo '<label for="Nazwa">Nazwa:</label>';
        echo '<input type="text" id="nazwa" name="nazwa" required><br>';

        echo '<label for="opis">Opis:</label>';
        echo '<textarea id="opis" name="opis" required></textarea><br>';

        echo '<label for="dataWygasniecia">Data Wygaśnięcia:</label>';
        echo '<input type="date" id="dataWygasniecia" name="dataWygasniecia" required><br>';
        
        echo '<label for="cenaNetto">Cena Netto:</label>';
        echo '<input type="text" id="cenaNetto" name="cenaNetto" required><br>';

        //echo '<label for="vat">VAT:</label>';
        //echo '<input type="text" id="vat" name="vat" required><br>';

        echo '<label for="ilosc">Ilość:</label>';
        echo '<input type="text" id="ilosc" name="ilosc" required><br>';

        echo '<label for="dostepny">Dostepny:</label>';
        echo '<input type="text" id="dostepny" name="dostepny" required><br>';

        echo '<label for="kategoria">Kategoria:</label>';
        echo '<input type="text" id="kategoria" name="kategoria" required><br>';

        echo '<label for="gabaryt">Gabaryt:</label>';
        //echo '<input type="text" id="gabaryt" name="gabaryt" required><br>';
        //echo '<form>';
        echo '<select name="gabaryt">';
        echo '<option value="duzy" selected>duży</option>';
        echo '<option value="sredni">średni</option>';
        echo '<option value="maly">mały</option>';
        echo '</select>';
        //echo '</form>';


        echo '<label for="zdjecie">Zdjęcie:</label>';
        echo '<input type="file" id="zdjecie" name="zdjecie" required><br>';

        echo '<input type="submit" name="submit_add" value="Dodaj Produkt">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    } else {
        echo 'Brak produktów.';

        echo '<table>';
        echo '<tr>';
        echo '<td>';
        echo '<form method="post" action="" enctype="multipart/form-data">';
        echo '<label for="Nazwa">Nazwa:</label>';
        echo '<input type="text" id="nazwa" name="nazwa" required><br>';

        echo '<label for="opis">Opis:</label>';
        echo '<textarea id="opis" name="opis" required></textarea><br>';

        echo '<label for="dataWygasniecia">Data Wygaśnięcia:</label>';
        echo '<input type="date" id="dataWygasniecia" name="dataWygasniecia" required><br>';

        echo '<label for="cenaNetto">Cena Netto:</label>';
        echo '<input type="text" id="cenaNetto" name="cenaNetto" required><br>';

        //echo '<label for="vat">VAT:</label>';
        //echo '<input type="text" id="vat" name="vat" required><br>';

        echo '<label for="ilosc">Ilość:</label>';
        echo '<input type="text" id="ilosc" name="ilosc" required><br>';

        echo '<label for="dostepny">Dostepny:</label>';
        echo '<input type="text" id="dostepny" name="dostepny" required><br>';

        echo '<label for="kategoria">Kategoria:</label>';
        echo '<input type="text" id="kategoria" name="kategoria" required><br>';

        echo '<label for="gabaryt">Gabaryt:</label>';
        //echo '<input type="text" id="gabaryt" name="gabaryt" required><br>';
        //echo '<form>';
        echo '<select name="gabaryt">';
        echo '<option value="duzy" selected>duży</option>';
        echo '<option value="sredni">średni</option>';
        echo '<option value="maly">mały</option>';
        echo '</select>';
        //echo '</form>';


        echo '<label for="zdjecie">Zdjęcie:</label>';
        echo '<input type="file" id="zdjecie" name="zdjecie" required><br>';

        echo '<input type="submit" name="submit_add" value="Dodaj Produkt">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
}

// Obsługa formularza usuwania
if (isset($_POST['delete'])) {
    // Formularz usuwania
    echo '<h2>Usuń Produkt:</h2>';
    echo '
    <form method="post" action="">
        <input type="hidden" name="id" value="'.$_POST['id'].'">
        Czy na pewno chcesz usunąć ten produkt?<br>
        <input type="submit" name="submit_delete" value="Tak">
        <input type="submit" name="cancel" value="Anuluj">
    </form>
    ';
}

// Obsługa formularza edycji
function EditForm() {
    $val = $_GET['val'];
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    $query = "SELECT * FROM products WHERE id=$val";
    $result = $link->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    // Formularz edycji
    echo '<h2>Edytuj Produkt:</h2>';
    echo '
    <form method="post" action="">
        <input type="hidden" name="id" value="'.$product['id'].'">

        <label for="nazwa">Nazwa:</label>
        <input type="text" id="nazwa" name="nazwa" value="'.$product['nazwa'].'" required><br>

        <label for="opis">Opis:</label>
        <textarea id="opis" name="opis" required>'.$product['opis'].'</textarea><br>

        <label for="dataWygasniecia">Data Wygaśnięcia:</label>
        <input type="date" id="dataWygasniecia" name="dataWygasniecia" value="'.$product['dataWygasniecia'].'" required><br>

        <label for="cenaNetto">Cena Netto:</label>
        <input type="text" id="cenaNetto" name="cenaNetto" value="'.$product['cenaNetto'].'" required><br>

        <label for="ilosc">Ilość:</label>
        <input type="text" id="ilosc" name="ilosc" value="'.$product['ilosc'].'" required><br>

        <label for="dostepny">Dostepny:</label>
        <input type="text" id="dostepny" name="dostepny" value="'.$product['dostepny'].'" required><br>

        <label for="kategoria">Kategoria:</label>
        <input type="text" id="kategoria" name="kategoria" value="'.$product['kategoria'].'" required><br>

        <label for="gabaryt">Gabaryt:</label>
            <select name="gabaryt">
                <option value="duzy" ' . ($product['gabaryt'] == 'duzy' ? 'selected' : '') . '>duży</option>
                <option value="sredni" ' . ($product['gabaryt'] == 'sredni' ? 'selected' : '') . '>średni</option>
                <option value="maly" ' . ($product['gabaryt'] == 'maly' ? 'selected' : '') . '>mały</option>
            </select><br>

        <label for="zdjecie">Zdjęcie:</label>
        <input type="file" id="zdjecie" name="zdjecie" value="'.$product['zdjecie'].'" required><br>

        <input type="submit" name="submit_edit" value="Zapisz Edycję">
    </form>
    ';
    } else {
        echo "Error: Product not found.";
    }
}

// Obsługa formularza edycji
if (isset($_POST['editprod'])) {
    if (isset($_GET['id'])){
        echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=103&val='.$_POST['id'].'";</script>';
        exit(); // Add this line to stop further execution
    } else {
        echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=103&val='.$_POST['id'].'";</script>';
        exit(); // Add this line to stop further execution
    }
    // Formularz edycji
    echo '<h2>Edytuj Produkt:</h2>';
    echo '
    <form method="post" action="">
        <input type="hidden" name="id" value="'.$_POST['id'].'">

        <label for="nazwa">Nazwa:</label>
        <input type="text" id="nazwa" name="nazwa" value="'.$_POST['nazwa'].'" required><br>

        <label for="opis">Opis:</label>
        <textarea id="opis" name="opis" required>'.$_POST['opis'].'</textarea><br>

        <label for="dataWygasniecia">Data Wygaśnięcia:</label>
        <input type="date" id="dataWygasniecia" name="dataWygasniecia" value="'.$_POST['dataWygasniecia'].'" required><br>

        <label for="cenaNetto">Cena Netto:</label>
        <input type="text" id="cenaNetto" name="cenaNetto" value="'.$_POST['cenaNetto'].'" required><br>

        <label for="ilosc">Ilość:</label>
        <input type="text" id="ilosc" name="ilosc" value="'.$_POST['ilosc'].'" required><br>

        <label for="dostepny">Dostepny:</label>
        <input type="text" id="dostepny" name="dostepny" value="'.$_POST['dostepny'].'" required><br>

        <label for="kategoria">Kategoria:</label>
        <input type="text" id="kategoria" name="kategoria" value="'.$_POST['kategoria'].'" required><br>

        <label for="gabaryt">Gabaryt:</label>
        <input type="text" id="gabaryt" name="gabaryt" value="'.$_POST['gabaryt'].'" required><br>

        <label for="zdjecie">Zdjęcie:</label>
        <input type="file" id="zdjecie" name="zdjecie" value="'.$_POST['zdjecie'].'" required><br>

        <input type="submit" name="submit_edit" value="Zapisz Edycję">
    </form>
    ';
}

// Obsługa formularza usuwania
if (isset($_POST['submit_delete'])) {
    $id = $_POST['id'];
    UsunProdukt($id);
}

// Obsługa formularza edycji
if (isset($_POST['submit_edit'])) {
    $id = $_POST['id'];
    $tytul = $_POST['nazwa'];
    $opis = $_POST['opis'];
    $dataEd = date("Y-m-d");
    $dataWyg = $_POST['dataWygasniecia'];
    $cenaNetto = $_POST['cenaNetto'];
    $vat = round($cenaNetto*0.23, 2);
    $ilosc = $_POST['ilosc'];
    $status = $_POST['dostepny'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    //$zdjecie = $_POST['zdjecie'];
    //$zdjecie = $_FILES['zdjecie']['name'];
    
    if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
        $zdjecie = $_FILES['zdjecie']['name'];
        $targetDir = "obrazki/";
        $targetFile = $targetDir . basename($_FILES['zdjecie']['name']);
        move_uploaded_file($_FILES['zdjecie']['tmp_name'], $targetFile);
    } else {
        $zdjecie = "";
    }

    EdytujProdukt($id, $tytul, $opis, $dataEd, $dataWyg, $cenaNetto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
}

if (isset($_POST['submit_add'])) {
    $tytul = $_POST['nazwa'];
    $opis = $_POST['opis'];
    $dataDod = date("Y-m-d");
    $dataEd = $dataDod;
    $dataWyg = $_POST['dataWygasniecia'];
    $cenaNetto = $_POST['cenaNetto'];
    $vat = round($cenaNetto*0.23, 2);
    $ilosc = $_POST['ilosc'];
    $status = $_POST['dostepny'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    //$zdjecie = $_POST['zdjecie'];
    //$zdjecie = $_FILES['zdjecie']['name'];
    
    if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
        $zdjecie = $_FILES['zdjecie']['name'];
        $targetDir = "obrazki/";
        $targetFile = $targetDir . basename($_FILES['zdjecie']['name']);
        move_uploaded_file($_FILES['zdjecie']['tmp_name'], $targetFile);
    } else {
        $zdjecie = "";
    }

    DodajProdukt($tytul, $opis, $dataDod, $dataEd, $dataWyg, $cenaNetto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
}

//PokazProdukty();

$link->close();

?>