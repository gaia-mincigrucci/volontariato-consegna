<?php
session_start();
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'utente') { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <link rel="stylesheet" href="stile.css">
    <title>Area Riservata</title>
</head>
<body>
    <ul id="menu">
        <li><a href="home.php">HOME</a></li>
        <li><a href="facciamo.php">COSA FACCIAMO</a></li>
        <li><a href="contatto.php">CONTATTI</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>

    <div class="content">
        <h1>CIAO <?= strtoupper($_SESSION['nome']) ?>!</h1>
        <div class="box-container" style="flex-direction: column; padding: 40px;">
            <h2>Cosa vuoi fare oggi?</h2>
            <div style="display: flex; gap: 20px; margin-top: 20px;">
                <button onclick="location.href='donazione.php'" class="btn-blue">FAI UNA DONAZIONE</button>
                <button onclick="location.href='attivita.php'" class="btn-blue">VEDI ATTIVITÀ</button>
            </div>
        </div>
    </div>
</body>
</html>