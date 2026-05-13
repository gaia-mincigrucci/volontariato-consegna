<?php
session_start();
if (!isset($_SESSION['ruolo'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile.css">
    <title>Prenotazione</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <h1>PRENOTA UNA VISITA</h1>
        <div class="box">
            <p>Benvenuto nell'area prenotazioni. Scegli una data per venire a trovarci.</p>
            <form action="conferma_prenotazione.php" method="POST">
                <input type="date" name="data_visita" required>
                <button type="submit">INVIA PRENOTAZIONE</button>
            </form>
        </div>
    </div>
</body>
</html>