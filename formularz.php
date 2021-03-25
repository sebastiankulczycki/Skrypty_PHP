<html lang="pl">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Formularz</title>

</head>

<body>

	<?php
	include("polaczenie.php");

	?>

	<form action="" method="post" enctype="multipart/form-data">

		Imię* :<br />

		<input name="imie" /><br />

		Nazwisko* :<br />

		<input name="nazwisko" /><br />

		Nazwa firmy* :<br />

		<input name="firma" /><br />

		Adres e-mail* :<br />
		<input name="email" /><br />

		Wrzuć swoje zdjęcie profilowe:</br>
		<input type="file" name="file"></br></br>
		Przekaż dodatkowe informacje:</br>
		<textarea name="wiadomosc" rows="5" cols="40"></textarea> </br>
		<input type="checkbox" name="mailing" value="checked" />Chcę otrzymywać informacje handlowe<br /><br />
		<input type="radio" id="male" name="plec" value="Mężczyzna">
		<label for="male">Mężczyna</label></br>
		<input type="radio" id="female" name="plec" value="Kobieta">
		<label for="female">Kobieta</label></br></br>
		<input type="submit" value="Wyślij" name="submit" />
		<input type="submit" value="Usuń" name="delete" />
	</form>

	<?php
	session_start();
	$login = $_SESSION['f_login'];
	$imie = "";
	$nazwisko = "";
	$firma = "";
	$email = "";
	$wiadomosc = "";
	$mailing = false;
	$plec = "";



	$statusMsg = "";
	$insert = "";



	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$targetDir = "uploads/";
		$fileName = basename($_FILES["file"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
		$allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

		if (isset($_POST["submit"])) {

			if (isset($_POST['imie'])) {
				echo ('</br> <b>Imię: </b>' . htmlentities($imie = $_POST['imie']));
				$_SESSION['f_imie'] = $imie;
			}

			if (isset($_POST['nazwisko'])) {
				echo ('</br> <b>Nazwisko: </b>' . htmlentities($nazwisko = $_POST['nazwisko']));
				$_SESSION['f_nazwisko'] = $nazwisko;
			}

			if (isset($_POST['firma'])) {
				echo ('</br> <b>Nazwa firmy: </b>' . htmlentities($firma = $_POST['firma']));
				$_SESSION['f_firma'] = $firma;
			}

			if (isset($_POST['email'])) {
				echo ('</br> <b>Email: </b>' . htmlentities($email = $_POST['email']));
				$_SESSION['f_email'] = $email;
			}

			if (isset($_POST['wiadomosc'])) {
				echo ('</br> <b>Wiadomosć: </b>' . htmlentities($wiadomosc = $_POST['wiadomosc']));
				$_SESSION['f_wiadomosc'] = $wiadomosc;
			}
			if (isset($_POST['plec'])) {
				echo ('</br> <b>Płeć: </b>' . htmlentities($plec = $_POST['plec']));
			}

			if (isset($_POST['mailing'])) {
				$mailing = true;
				echo ("</br> <p style=\"color:green\">Będziesz otrzymywać od nas informacje handlowe </p>");
			}

			if (empty($_POST["imie"]) || empty($_POST["nazwisko"]) || empty($_POST["firma"]) || empty($_POST["email"])) {
				echo "<p style=\"color:red\">Musisz wypełnić wszystkie pola!</p>";
			} else {
				if (in_array($fileType, $allowTypes)) {

					$insert = mysqli_query($connection, "INSERT into klienci (imie, nazwisko, nazwa_firmy, email, zdjecie, plec, wiadomosc, mailing) VALUES ('$imie','$nazwisko','$firma','$email','$fileName','$plec','$wiadomosc','$mailing')") or die("</br>Błąd: " . mysqli_error($connection));

					$insert2 = mysqli_query($connection, "INSERT INTO wpisy(id_uzytkownika, id_klienta) SELECT uzytkownicy.id, klienci.id FROM uzytkownicy,klienci WHERE login = '$login' AND klienci.imie = '$imie' AND klienci.nazwisko ='$nazwisko' AND klienci.nazwa_firmy ='$firma'");


					$count = mysqli_num_rows(mysqli_query($connection, "SELECT * from klienci"));
					if ($count) {
						$incrementSet = mysqli_query($connection, "ALTER TABLE `klienci` AUTO_INCREMENT='$count' ") or die("</br>Błąd: " . mysqli_error($connection));
						mysqli_free_result($count);
					}
					if ($insert) {
					$statusMsg = "<p>Dziękujemy za wypełnienie formularza.</br>Zdjęcie " . $fileName . " oraz Twoje dane zostały dodane.</p>";
					} else {
						$statusMsg = "Wystąpił problem, spróbuj ponownie.";
					}
				} else {
					$statusMsg = '</br>Przepraszamy wystąpił problem z dodawaniem Twojego zdjęcia. Dopuszczone pliki to JPG, JPEG, PNG, GIF, PDF.';
					$insert = mysqli_query($connection, "INSERT into klienci (imie, nazwisko,nazwa_firmy, email, zdjecie,plec, wiadomosc, mailing) VALUES ('$imie','$nazwisko','$firma','$email',NULL,'$plec','$wiadomosc','$mailing')") or die("</br>Błąd: " . mysqli_error($connection));

					$insert2 = mysqli_query($connection, "INSERT INTO wpisy(id_uzytkownika, id_klienta) SELECT uzytkownicy.id, klienci.id FROM uzytkownicy,klienci WHERE login = '$login' AND klienci.imie = '$imie' AND klienci.nazwisko ='$nazwisko' AND klienci.nazwa_firmy ='$firma' ");

					$count = mysqli_num_rows(mysqli_query($connection, "SELECT * from klienci"));
					if ($count) {
						$incrementSet = mysqli_query($connection, "ALTER TABLE `klienci` AUTO_INCREMENT='$count' ");
						mysqli_free_result($incrementSet);
					}
					if ($insert) {
						$statusMsg = "<p>Dziękujemy za wypełnienie formularza.</br>Twoje dane zostały dodane (brak zdjęcia) </p>";
					} else {
						$statusMsg = "Wystąpił problem, spróbuj ponownie.";
					}
				}
			}
		}
		if (isset($_POST['delete'])) {
		}
	}

	echo $statusMsg;

	?>
</body>

</html>