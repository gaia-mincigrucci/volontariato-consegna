<?php
session_start();
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'utente') {
    header("Location: login.php"); exit; 
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Area Personale</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="content">
        <h1>CIAO <?= strtoupper($_SESSION['nome']) ?>!</h1>
        <div class="box box-container">
            <h2>Cosa vuoi fare oggi?</h2>
            <div class="actions-row">
                <button onclick="location.href='donazione.php'" class="btn-blue">FAI UNA DONAZIONE</button>
                <button onclick="location.href='attivita.php'" class="btn-blue">VEDI ATTIVITÀ</button>
            </div>
        </div>
    </div>
</body>
</html>