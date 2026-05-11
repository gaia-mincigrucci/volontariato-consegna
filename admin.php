<?php
session_start();
if ($_SESSION['ruolo'] !== 'admin') { header("Location: login.php"); exit; }
require 'database.php';

if (isset($_GET['del'])) {
    $pdo->prepare("DELETE FROM utenti WHERE id = ?")->execute([$_GET['del']]);
}

$utenti = $pdo->query("SELECT * FROM utenti")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stile.css">
    <title>Admin</title>
</head>
<body>
    <div class="content">
        <h1>GESTIONE UTENTI</h1>
        <table border="1" style="width:100%; background:white;">
            <tr><th>Nome</th><th>Email</th><th>Azioni</th></tr>
            <?php foreach($utenti as $u): ?>
            <tr>
                <td><?= $u['nome'] ?></td>
                <td><?= $u['email'] ?></td>
                <td>
                    <a href="modifica.php?id=<?= $u['id'] ?>">📝</a>
                    <a href="admin.php?del=<?= $u['id'] ?>">❌</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="login.php">Logout</a>
    </div>
</body>
</html>