<?php
session_start();
session_destroy();
// Sletter session, sender brukeren til innloggingssiden
header('Location: index.html');
?>
