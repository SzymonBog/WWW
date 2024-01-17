<?php
// handle update categories
function mysqlUpdateCat($id, $matka, $nazwa)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';

    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    // Check for connection errors
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare the statement with placeholders
    $query = "UPDATE categories SET matka=?, nazwa=? WHERE id=?";
    $stmt = $link->prepare($query);

    // Bind parameters and execute the statement
    $stmt->bind_param("ssi", $matka, $nazwa, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $link->close();
}
// handle add categories
function mysqlInsertCat($id, $matka, $nazwa)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    //czyscimy $id, aby przez GET ktoś nie próbował wykonać ataku SQL INJECTION
    //$id_clear = htmlspecialchars($id);
    $link = new mysqli($dbhost,$dbuser,$dbpass,$db);

    ////$query="SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    //$query = "INSERT INTO categories (id, matka, nazwa) VALUES ($id, $matka, $nazwa)";
    //mysqli_query($link, $query);

    // Check for connection errors
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    // Prepare the statement with placeholders
    $query = "INSERT INTO categories (id, matka, nazwa) VALUES (?, ?, ?)";
    $stmt = $link->prepare($query);

    // Bind parameters and execute the statement
    $stmt->bind_param("iss", $id, $matka, $nazwa);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $link->error;
    }

    $stmt->close();
    $link->close();
}

// add category
function DodajKategorie(){
    // handle add
    if(isset($_POST['x1_submit']) and isset($_POST['id']) and isset($_POST['nazwa'])) {
        $id = $_POST['id'];
        $matka = $_POST['matka'];
        $nazwa = $_POST['nazwa'];

        // Call the function to insert data into the database
        //echo $id, $matka, $nazwa;

        // use insert
        mysqlInsertCat($id, $matka, $nazwa);
        unset($_POST['x1_submit']);
        $_POST['x1_submit'] = null;
        unset($id);
        unset($matka);
        unset($nazwa);
    }

    // go back
    if(isset($_POST['x2_submit'])){
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=96";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=96";</script>';
        }
    }

    unset($_POST['x1_submit']);

    $wynik = '
    <div class="dodaj">
        <h1 class="heading">Dodaj Kategorie:</h1>
            <div class="dodaj">
            <form method="post" name"AddForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                <table class="dodaj">
                    <tr><td class="log4_t">[id]</td><td><input type="text" name="id" class="edycja" /></td></tr>
                    <tr><td class="log4_t">[matka]</td><td><input type="text" name="matka">
                    <tr><td class="log4_t">[nazwa]</td><td><input type="text" name="nazwa">

                    <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="edycja" value="Zatwierdź" /></td></tr>
                    <tr><td>&nbsp;</td><td><input type="submit" name="x2_submit" class="edycja" value="Odrzuć" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';

    return $wynik;
}

// remove category from db
function UsunKategorie($id){
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    //czyscimy $id, aby przez GET ktoś nie próbował wykonać ataku SQL INJECTION
    //$id_clear = htmlspecialchars($id);
    $link = new mysqli($dbhost,$dbuser,$dbpass,$db);
    $query="DELETE FROM categories WHERE id='$id'";
    mysqli_query($link, $query);
}

// edit category
function EdytujKategorie($id) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';

    // Create a database connection
    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    // Check for connection errors
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
        $matka = $_POST['matka'];
        $nazwa = $_POST['nazwa'];

        // Call the function to update data in the database
        $query = "UPDATE categories SET matka=?, nazwa=? WHERE id=?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("ssi", $matka, $nazwa, $id);

        if($stmt->execute()) {
            echo "Zmodyfikowano";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        
        $stmt->close();

        //$currentURL = $_SERVER['REQUEST_URI'];
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=96";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=96";</script>';
        }
    }

    if (isset($_POST['reject'])){
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=96";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=96";</script>';
        }
    }

    // Fetch category details based on the provided ID
    $query = "SELECT * FROM categories WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();

        // Pre-fill the form fields with fetched category values
        $id = $category['id'];
        $matka = $category['matka'];
        $nazwa = $category['nazwa'];

        // Generate the form with pre-filled values
        $form = '
        <div class="edytuj">
            <h1 class="heading">Edytuj Kategorie:</h1>
            <div class="edytuj">
                <form method="post" name="EditForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                    <input type="hidden" name="id" value="'.$id.'">
                    <table class="edytuj">
                        <tr><td class="log4_t">Matka:</td><td><input type="text" name="matka" value="'.$matka.'" /></td></tr>
                        <tr><td class="log4_t">Nazwa:</td><td><input type="text" name="nazwa" value="'.$nazwa.'" /></td></tr>

                        <tr><td>&nbsp;</td><td><input type="submit" name="submit" class="edycja" value="Zatwierdź" /></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="reject" class="edycja" value="Odrzuć" /></td></tr>
                    </table>
                </form>
            </div>
        </div>
        ';

        return $form;
    } else {
        return 'Category not found.';
    }

    $stmt->close();
    $link->close();
}

// show categories
function PokazKategorie(){
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';
    //czyscimy $id, aby przez GET ktoś nie próbował wykonać ataku SQL INJECTION
    //$id_clear = htmlspecialchars($id);
    
    $link = new mysqli($dbhost,$dbuser,$dbpass,$db);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        UsunKategorie($_POST['id']); // Call your delete function
        // Redirect or perform other actions after deletion
    }

    // Handling edit action
    //if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    if(isset($_POST['edit'])){
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=99&val='.$_POST['id'].'";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=99&val='.$_POST['id'].'";</script>';
        };
        //echo EdytujKategorie($_POST['id']); // Call your edit function
        // Redirect or perform other actions after editing
        return ['ind' => 2, 'val' => $_POST['id']];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=98&val='.$_POST['id'].'";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=98&val='.$_POST['id'].'";</script>';
        }
        //echo DodajKategorie();
        return ['ind' => 1, 'val' => 0];
    }

    // Fetching categories
    $query = "SELECT * FROM categories";
    $resp = mysqli_query($link, $query);

    if ($resp->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Matka</th><th>Nazwa</th><th>Akcje</th></tr>';
        
        while ($row = mysqli_fetch_assoc($resp)) {
            echo '<tr>';
            echo '<td>'.$row['id'].'</td>';
            echo '<td>'.$row['matka'].'</td>';
            echo '<td>'.$row['nazwa'].'</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<input type="submit" name="delete" value="Usun">';
            echo '</form>';
            
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<input type="hidden" name="matka" value="'.$row['matka'].'">';
            echo '<input type="hidden" name="nazwa" value="'.$row['nazwa'].'">';
            echo '<input type="submit" name="edit" value="Edytuj">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '<tr>';
        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="submit" name="add" value="Dodaj">';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    } else {
        echo 'No categories found.';
    }

    return ['ind' => 0, 'val' => 0];
}

?>