<?php
$mysqli_server = "localhost";
$mysqli_admin = "admin";
$mysqli_pass = "admin";
$mysqli_db = "technologie_internetowe";
$connection = mysqli_connect($mysqli_server, $mysqli_admin, $mysqli_pass)
    or die('Brak połączenia z serwerem MySQL.<br />Błąd: ' . mysqli_error($connection));
//echo "Udało się połączyć z serwerem!<br />";
mysqli_select_db($connection, $mysqli_db)
    or die('Nie mogę połączyć się z bazą danych<br />Błąd: ' . mysqli_error($connection));
//echo "Udało się połączyć z bazą danych!";
