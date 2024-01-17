<?php
include('php/categories.php');
include("php/products.php");

session_start();

// handle singning in and out
if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    $enteredLogin = $_POST['login_email'];
    $enteredPass = $_POST['login_pass'];

    require_once 'php/cfg.php';

    if ($enteredLogin === $login && $enteredPass === $pass) {
        $_SESSION['logged_in'] = true;
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=96";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=96";</script>';
        }
    } else {
        $error_message = "Błąd logowania. Spróbuj ponownie.";
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    if (isset($_GET['id'])){
        echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=1";</script>';
    } else {
        echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=0";</script>';
    }
    exit();
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    echo "Witaj, administrator! Opcje administracyjne:";
    echo '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
            <input type="submit" name="logout" value="Wyloguj">
          </form>';

    if($_GET['idp']!='99'){
    ListaPodstron();
    //EdytujPodstrone();
    //DodajNowaPodstrone();
	//UsunPodstrone();
    PokazKategorie();
    PokazProdukty();
    }
} else {
    echo isset($error_message) ? "<p style='color: red;'>$error_message</p>" : "";
    echo FormularzLogowania();
}

// sign in
function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
        <h1 class="heading">Formularz Logowania:</h1>
            <div class="logowanie">
            <form method="post" name"LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                <table class="logowanie">
                    <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                    <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                    <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';
    return $wynik;
}

// list all pages
function ListaPodstron()
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';

    $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['usun'])) {
        UsunPodstrone($_POST['id']);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dodaj'])) {
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=101";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=101";</script>';
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edytuj'])) {
        if (isset($_GET['id'])){
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=102&val='.$_POST['id'].'";</script>';
        } else {
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?idp=102&val='.$_POST['id'].'";</script>';
        }
    }

    $query = "SELECT * FROM page_list LIMIT 100";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo '<h2>Lista Podstron:</h2>';
        echo '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Tytuł Podstrony</th>
                    <th>Akcje</th>
                </tr>';

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['page_title'] . '</td>
                    <td>
                        <form method="post" action="">
                        <input type="hidden" name="id" value="'.$row['id'].'">
                        <input type="submit" name="edytuj" value="Edytuj">
                        </form>
                        <form method="post" action="">
                        <input type="hidden" name="id" value="'.$row['id'].'">
                        <input type="submit" name="usun" value="Usuń">
                        </form>
                    </td>
                  </tr>';
        }
        echo '<tr>
                <td>
                <form method="post" action="">
                <input type="submit" name="dodaj" value="Dodaj">
                </td>
                </tr>';

        echo '</table>';
    } else {
        echo "Błąd zapytania SQL: " . mysqli_error($link);
    }

    mysqli_close($link);
}

// edit page
function EdytujPodstrone($id)
{
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
        $tytul = $_POST['tytul'];
        $content = $_POST['content'];
        $status = $_POST['statuss'];

        // Call the function to update data in the database
        $query = "UPDATE page_list SET page_title=?, page_content=?, status=? WHERE id=?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("ssii", $tytul, $content, $status, $id);

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
    $query = "SELECT * FROM page_list WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $page = $result->fetch_assoc();

        // Pre-fill the form fields with fetched category values
        $id = $page['id'];
        $tytul = $page['page_title'];
        $content = $page['page_content'];
        $status = $page['statuss'];

        // Generate the form with pre-filled values
        $form = '
        <div class="edytuj">
            <h1 class="heading">Edytuj Podstrone:</h1>
            <div class="edytuj">
                <form method="post" name="EditForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
                    <input type="hidden" name="id" value="'.$id.'">
                    <table class="edytuj">
                        <tr><td class="log4_t">Tytul:</td><td><input type="tytul" name="tytul" value="'.$tytul.'" /></td></tr>
                        <tr><td class="log4_t">Zawartosc:</td><td><textarea id="content" name="content">'.$content.'</textarea></td></tr>
                        <tr><td class="log4_t">Status:</td><td><input type="checkbox" name="statuss" value="'.$status.'" /></td></tr>

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

// add page
function DodajPodstrone()
{
    echo '
    <h2>Dodaj Nową Podstronę:</h2>
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <table>
        <tr>
        <td><label for="id">ID:</label></td>
        <td><input type="text" id="id" name="id" required><br></td>
        </tr>

        <tr>
        <td><label for="tytul">Tytuł:</label></td>
        <td><input type="text" id="tytul" name="tytul" required><br></td>
        </tr>

        <tr>
        <td><label for="tresc">Treść:</label></td>
        <td><textarea id="tresc" name="tresc" required></textarea><br></td>
        </tr>
        <tr>
        <td><input type="submit" name="dodaj_nowa_podstrone" value="Dodaj"></td>
        </tr>
        </table>
    </form>
    ';

    if (isset($_POST['dodaj_nowa_podstrone'])) {
        if (isset($_POST['tytul'], $_POST['tresc'], $_POST['id'])) {
            $tytul = $_POST['tytul'];
            $tresc = $_POST['tresc'];
            $id = $_POST['id'];

            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $db = 'moja_strona';

            $link = new mysqli($dbhost, $dbuser, $dbpass, $db);

            if ($link->connect_error) {
                die("Błąd połączenia z bazą danych: " . $link->connect_error);
            }

            $query = "INSERT INTO page_list (id, page_title, page_content) VALUES ('$id', '$tytul', '$tresc')";

            if ($link->query($query) === TRUE) {
                echo "Dodano nową podstronę pomyślnie.";
            } else {
                echo "Błąd zapytania SQL: " . $link->error;
            }

            $link->close();
            echo '<script>window.location.href = "http://localhost/164345/164345_1/index.php?id=96";</script>';
            //header("Location: http://localhost/164345/164345_1/index.php?id=96");
        } else {
            echo "Błąd: Wymagane pola tytuł i treść są puste.";
        }
    }
}

// remove page
function UsunPodstrone($id)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = 'moja_strona';

    $link = new mysqli($dbhost,$dbuser,$dbpass,$db);
    $query="DELETE FROM page_list WHERE id='$id'";
    mysqli_query($link, $query);
}

?>