<?php
session_start();
require 'db.php';
if(!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

// Gestione Eliminazione
if(isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM utenti WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$stmt = $pdo->query("SELECT * FROM utenti");
$utenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile.css">
    <title>Dashboard Admin</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 12px; }
        th { background-color: #001F4D; color: white; }
    </style>
</head>
<body>
    <div class="content">
        <h1>PANNELLO DI CONTROLLO</h1>
        <table>
            <tr>
                <th>Nome</th><th>Cognome</th><th>Email</th><th>Azioni</th>
            </tr>
            <?php foreach($utenti as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['nome']) ?></td>
                <td><?= htmlspecialchars($u['cognome']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <a href="modifica.php?id=<?= $u['id'] ?>">📝</a>
                    <a href="admin.php?delete=<?= $u['id'] ?>" onclick="return confirm('Eliminare?')">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button onclick="window.location='login.php'">LOGOUT</button>
    </div>
</body>
</html>