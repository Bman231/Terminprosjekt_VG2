<?php

// Deler av koden er hentet fra https://codeshack.io/secure-login-system-php-mysql/

session_start();
// Connection detaljer
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'brukere';
// Kobler til databasen med detaljene ovenfor
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Sjekker om data fra formen ble submitted, isset() sjekker om dataen finnes i feltene.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

// Forbereder SQL-injection. Prepare forhinder at dataene blir sendt til databasen hvis det er noe feil
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Setter "s" bak brukernavnet for at den skal regnes som "string"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Lagrer resultatet for å kryssjekke at brukeren finnes.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Brukeren finnes, gjenstår å verifisere passordet
        // Passordet hashes ikke, det lagres i tekst
        if ($_POST['password'] === $password) {
            // Passord er verifisert. Brukeren har logget inn

        // Oppretter session. Virker som cookies, men husker dataene på serveren frem til brukeren logger ut
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: home.php');
        } else {
            // Feil passord
            echo 'Feil brukernavn og/eller passord! Trykk tilbake for å prøve igjen';
        }
    } else {
        // Feil brukernavn
        echo 'Feil brukernavn og/eller passord! Trykk tilbake for å prøve igjen';
    }
}
?>
