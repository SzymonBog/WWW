<?php
//session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'moja_strona';

$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Sprawdź połączenie z bazą danych
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// show all products(user view)
function PokazProduktyUzytkownik() {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'moja_strona';

    $link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    $query = "SELECT * FROM products";
    $result = $link->query($query);

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nazwa</th><th>Opis</th><th>Data Utworzenia</th><th>Data Modyfikacji</th><th>Data Wygaśnięcia</th><th>Cena Netto</th><th>VAT</th><th>Ilość</th><th>Status</th><th>Kategoria</th><th>Gabaryt</th><th>Zdjęcie</th><th>Akcje</th></tr>';

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
            echo '<input type="submit" name="add" value="Dodaj do koszyka">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
    }
}

// Funkcja dodawania produktu do koszyka
function addToCart($productId, $quantity) {
    global $link;

    // Pobierz dane produktu z bazy danych
    $query = "SELECT * FROM products WHERE id = '$productId'";
    $result = $link->query($query);

    if ($result->num_rows > 0) {
        $productData = $result->fetch_assoc();

        // Sprawdź, czy koszyk istnieje w sesji
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Sprawdź, czy produkt już istnieje w koszyku
        if (isset($_SESSION['cart'][$productId])) {
            // Jeśli istnieje, zwiększ ilość
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            // Jeśli nie istnieje, dodaj nowy produkt do koszyka
            $_SESSION['cart'][$productId] = array(
                'quantity' => $quantity,
                'name' => isset($productData['nazwa']) ? $productData['nazwa'] : 'Brak nazwy', // Sprawdź, czy klucz istnieje
                'price' => isset($productData['cenaNetto']) ? $productData['cenaNetto'] : 0 // Sprawdź, czy klucz istnieje
            );
        }
    }
}

// Funkcja usuwania produktu z koszyka
function removeFromCart($productId) {
    // Sprawdź, czy koszyk istnieje w sesji
    if (isset($_SESSION['cart'][$productId])) {
        // Usuń produkt z koszyka
        unset($_SESSION['cart'][$productId]);
    }
}

// handle addToCart
if (isset($_POST['add'])){
    addToCart($_POST['id'], 1);
}

// handle removeFromCart
if (isset($_POST['remove'])){
    removeFromCart($_POST['id']);
}


// Funkcja wyświetlająca zawartość koszyka
function showCart() {
    global $link;

    // Sprawdź, czy koszyk istnieje w sesji
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        $totalPrice = 0;
        echo '<table border="1">';
        echo '<tr><th>Produkt ID</th><th>Nazwa</th><th>Ilość w koszyku</th><th>Cena</th></tr>';
        foreach ($_SESSION['cart'] as $productId => $product) {
            echo '<tr>';
            echo '<td>' . $productId . '</td>';
            echo '<td>' . (isset($product['name']) ? $product['name'] : 'Brak nazwy') . '</td>';
            echo '<td>' . $product['quantity'] . '</td>';
            $productPrice = isset($product['price']) ? $product['price'] * $product['quantity'] : 0;
            echo '<td>' . $productPrice . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$productId.'">';
            echo '<input type="submit" name="remove" value="Usuń z koszyka">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';

            $totalPrice += $productPrice;
        }
        echo '<tr>';
        echo '<th>Całkowita cena</th><td>' . $totalPrice . '</td>';
        echo '</tr>';
        echo '</table>';
    } else {
        echo 'Koszyk jest pusty.';
    }
}

PokazProduktyUzytkownik();
showCart();
//unset($_SESSION['cart']);
?>