<?php
// Sjekker om brukeren er innlogget, ellers blokkerer tilgang
session_start();
// Sender brukeren til innloggingssiden (index.html)
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
// Kobler til databasen
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'brukere';
// Koden kobler php-filen til datbasen med detaljene ovenfor
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Passordet og email er ikke lagret i sessions pga sikkerhet, vi henter dem ut av databasen gjennom SQL
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// ID refererer til brukernavnet vi skal hente ut.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Villebok - Profil</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1 onclick="location.href='home.php'">Villebok</h1>
				<a href="profil.php"><i class="fas fa-user-circle"></i>Profil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logg ut</a>
			</div>
		</nav>
		<div class="content">
			<h2>Din profil</h2>
			<div>
				<p>Dine brukerdetaljer er listet nedenfor:</p>
				<table>
					<tr>
						<td>Brukernavn:</td>
						<!--Henter ut brukernavn lagret i session-->
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Passord:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>E-postadresse:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
