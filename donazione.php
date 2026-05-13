<?php
session_start();
if (!isset($_SESSION['ruolo'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile.css">
    <title>Donazione</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <h1>FAI UNA DONAZIONE</h1>
        <div class="box">
            <p>Il tuo contributo aiuta i nostri piccoli amici.</p>
            <form action="donazione_email.php" method="POST">
                <input type="email" name="email" placeholder="La tua email" required>
                <input type="number" name="importo" placeholder="Importo €" required>
                <input type="text" name="metodo" placeholder="Metodo di pagamento">
                <button type="submit" style="background-color: #28a745;">CONFERMA E INVIA EMAIL</button>
            </form>
        </div>
    </div>
</body>
</html>