<?php
// Ved å bruke session forhindrer man tilgang til denne siden hvis man ikke er logget inn
session_start();
// Sender brukeren til innloggingssiden (index.html)
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Villebok</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logg ut</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home</h2>
			<p>Godt å se deg, <b><?=$_SESSION['name']?></b>!</p>
		</div>
		<div class="content">
			<p>Her kommer ny chatfunksjon! Nettsiden er fortsatt under oppbygging. Forvent noe bra fremover!</p>
		</div>

	</body>
</html>
