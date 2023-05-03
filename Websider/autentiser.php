<?php

// Credits for deler av koden til https://codeshack.io/secure-login-system-php-mysql/

session_start();
// Definerer connection detaljer
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'brukere';

// Koden kobler php-filen til datbasen med detaljene ovenfor
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Feilmelding hvis tilkobling mislyktes.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Sjekker om data fra formen ble submitted, isset() sjekker om dataen finnes i feltene.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

// Forbereder SQL-injection. Prepare forhindrer at koden kjører hvis noe skulle gå feil
// Henter data fra databasen basert på brukernavnet skrevet i innloggingskjemaet
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Setter "s" i brukernavnet slik at den blir regnet som en string
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Lagrer resultatet for å kryssjekke at brukeren finnes senere.
	$stmt->store_result();

    // Sjekker om brukeren finnes
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        // Brukeren finnes gjenstår å verifisere passordet
        // Verifiserer passordet. Sjekker om passordet som ble submittet er det samme som i databasen
        if ($_POST['password'] === $password) {
            // Passord er verifisert. Brukeren har logget inn

        // Oppretter session. Alternativet til cookies, men husker dataene på serveren frem til brukeren logger ut
        // $_SESSION er en global variabel som har tilagng til alle php-filene i mappa
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            // Sender til Hjemmesiden
            header('Location: home.php');

            // Brukernavn og/eller passord matcher ikke det som står i databasen
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
