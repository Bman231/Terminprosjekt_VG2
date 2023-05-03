<?php
// Sjekker om brukeren er innlogget, ellers blokkerer tilgang
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
// Sletter session, logger ut og sender brukeren til innloggingssiden
session_destroy();
header('Location: index.html');
?>
