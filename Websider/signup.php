<?php
session_start();
// Connection detaljer til databasen
$DATABASE_HOST = '10.0.0.50';
$DATABASE_USER = 'admin';
$DATABASE_PASS = 'Besnik500Kuben';
$DATABASE_NAME = 'user_data';

// Koden kobler php-filen til datbasen
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Klarte ikke koble til databasen. Viser feilmelding
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Sjekker om data fra formen ble submitted, isset() sjekker om dataen finnes i feltene.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Feltene var ikke fylt ut.
	exit('Fyll ut begge feltene i registreringsskjemaet!');
}

$username = $_POST['username'];
$pass = $_POST['password'];

// Forbereder SQL-injection. Prepare forhinder at dataene blir sendt til databasen hvis det er noe feil
if  ($stmt = $con->prepare('INSERT INTO accounts (username, password) VALUES ('$username', '$pass')')) {
	// Setter "s" i brukernavnet slik at vi vet at den er en string
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();

    // Oppretter session. Virker som cookies, men husker dataene på serveren frem til brukeren logger ut
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        header('Location: home.php');
}
?>
