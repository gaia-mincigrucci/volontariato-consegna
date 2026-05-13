<?php
session_start();
require 'database.php';

// Controllo Sicurezza: Solo Gaia (Admin) può stare qui
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$messaggio = "";

// --- OPERAZIONE: DELETE (Elimina Utente) ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM utenti WHERE id = ?");
    if ($stmt->execute([$id])) {
        $messaggio = "Utente eliminato con successo!";
    }
}

// --- OPERAZIONE: UPDATE (Modifica Utente) ---
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $ruolo = $_POST['ruolo'];

    $stmt = $pdo->prepare("UPDATE utenti SET nome = ?, cognome = ?, email = ?, ruolo = ? WHERE id = ?");
    if ($stmt->execute([$nome, $cognome, $email, $ruolo, $id])) {
        $messaggio = "Dati aggiornati correttamente!";
    }
}

// --- OPERAZIONE: READ (Leggi tutti gli utenti) ---
$stmt = $pdo->query("SELECT * FROM utenti WHERE ruolo != 'admin' ORDER BY id DESC");
$utenti = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se è stata richiesta la modifica di un utente specifico, carichiamo i suoi dati nel form
$utente_da_modificare = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $utente_da_modificare = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile.css">
    <title>Dashboard Admin - Associazione</title>
    <style>
        /* Stili specifici per la tabella admin */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; color: #333; }
        th { background-color: #001F4D; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .btn-edit { color: #0047AB; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-delete { color: #d9534f; text-decoration: none; font-weight: bold; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px; width: 100%; text-align: center; }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="content">
        <h1>GESTIONE VOLONTARI E UTENTI</h1>

        <?php if ($messaggio): ?>
            <div class="alert"><?= $messaggio ?></div>
        <?php endif; ?>

        <?php if ($utente_da_modificare): ?>
        <div class="box" style="margin-bottom: 40px; border: 2px solid #0047AB;">
            <h3>MODIFICA UTENTE: <?= $utente_da_modificare['nome'] ?></h3>
            <form method="POST" action="admin.php">
                <input type="hidden" name="id" value="<?= $utente_da_modificare['id'] ?>">
                <input type="text" name="nome" value="<?= $utente_da_modificare['nome'] ?>" required>
                <input type="text" name="cognome" value="<?= $utente_da_modificare['cognome'] ?>" required>
                <input type="email" name="email" value="<?= $utente_da_modificare['email'] ?>" required>
                <select name="ruolo" style="width: 100%; padding: 10px; margin: 10px 0;">
                    <option value="utente" <?= $utente_da_modificare['ruolo'] == 'utente' ? 'selected' : '' ?>>Utente</option>
                    <option value="volontario" <?= $utente_da_modificare['ruolo'] == 'volontario' ? 'selected' : '' ?>>Volontario</option>
                </select>
                <button type="submit" name="update">SALVA MODIFICHE</button>
                <a href="admin.php" style="display: block; margin-top: 10px; color: gray;">Annulla</a>
            </form>
        </div>
        <?php endif; ?>

        <div class="box" style="width: 95%; max-width: 1100px;">
            <h3>ELENCO ISCRITTI</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Ruolo</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utenti as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= $u['nome'] ?></td>
                        <td><?= $u['cognome'] ?></td>
                        <td><?= $u['email'] ?></td>
                        <td><strong><?= strtoupper($u['ruolo']) ?></strong></td>
                        <td>
                            <a href="admin.php?edit=<?= $u['id'] ?>" class="btn-edit">📝 Modifica</a>
                            <a href="admin.php?delete=<?= $u['id'] ?>" class="btn-delete" onclick="return confirm('Sei sicura di voler eliminare questo utente?')">❌ Elimina</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>