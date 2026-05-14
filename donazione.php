<?php
session_start();
if (!isset($_SESSION['ruolo'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Donazione</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <h1>FAI UNA DONAZIONE</h1>
        <div class="box">
            //form per donare
            <p>Il tuo contributo aiuta i nostri piccoli amici.</p>
            <form action="donazione_email.php" method="POST">
                <input type="email" name="email" placeholder="La tua email" required>
                <input type="number" name="importo" placeholder="Importo €" required>
                <input type="text" name="metodo" placeholder="Metodo di pagamento">
                <button type="submit" class="btn-blue">CONFERMA E INVIA EMAIL</button>
            </form>
        </div>
    </div>
</body>
</html>