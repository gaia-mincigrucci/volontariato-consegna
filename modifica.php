<?php
session_start();
require 'database.php';
$id = $_GET['id'];
$u = $pdo->prepare("SELECT * FROM utenti WHERE id = ?");
$u->execute([$id]);
$utente = $u->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE utenti SET nome=?, cognome=?, email=? WHERE id=?";
    $pdo->prepare($sql)->execute([$_POST['nome'], $_POST['cognome'], $_POST['email'], $id]);
    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Modifica Utente</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="content">
        <h1>MODIFICA UTENTE</h1>
        <div class="form-container">
            <form method="post">
                <label>Nome</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($utente['nome']) ?>" required>
                <label>Cognome</label>
                <input type="text" name="cognome" value="<?= htmlspecialchars($utente['cognome']) ?>" required>
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($utente['email']) ?>" required>
                <button type="submit" class="btn-blue">SALVA</button>
            </form>
        </div>
    </div>
</body>
</html>