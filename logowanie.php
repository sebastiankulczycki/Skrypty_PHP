<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="login">Login: </label>
        <input type="text" name="login" /><br /><br />
        <label for="login">Hasło: </label>
        <input type="password" name="haslo" /><br /><br />
        <input type="submit" name="submit" value="Zaloguj się" />
    </form>
    <?php
    session_start();
    include("polaczenie.php");

    if (isset($_POST['submit'])) {
        if (isset($_POST['login']) and isset($_POST['haslo'])) {

            $login = $_POST['login'];
            $haslo = $_POST['haslo'];
            $_SESSION['f_login'] = $login;

            $select = "SELECT * FROM `uzytkownicy` WHERE login = '$login' AND haslo ='$haslo'";
            $query = mysqli_query($connection, $select) or die(mysqli_error($connection));
            $count  = mysqli_num_rows($query);
            if ($count == 1) {
                header('Location: formularz.php');
            } else {
                echo ("<p style='color: red'>Nie ma takiego użytkownika w bazie</p>");
            }
        }
    }
    ?>
</body>

</html>