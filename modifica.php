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
<html>
<head>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <div class="content">
        <form method="post" class="form-container">
            <input type="text" name="nome" value="<?= $utente['nome'] ?>">
            <input type="text" name="cognome" value="<?= $utente['cognome'] ?>">
            <input type="email" name="email" value="<?= $utente['email'] ?>">
            <button type="submit">SALVA</button>
        </form>
    </div>
</body>
</html>