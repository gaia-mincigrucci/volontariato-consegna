<?php
session_start();
if (!isset($_SESSION['ruolo'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <link rel="stylesheet" href="stile.css">
    <title>Donazione</title>
</head>
<body>
    <div class="content">
        <h1>SOSTIENI L'ASSOCIAZIONE</h1>
        <div class="form-container">
            <p>Utente: <strong><?= $_SESSION['email'] ?></strong></p>
            <form action="donazione_email.php" method="post">
                <input type="text" name="metodo" placeholder="Metodo di Pagamento" required><br>
                <input type="text" name="numero" placeholder="Numero Carta" required><br>
                <button type="submit" class="btn-blue">CONFERMA E DONA</button>
            </form>
            <br>
            <a href="area_utente.php">Torna all'area utente</a>
        </div>
    </div>
</body>
</html>