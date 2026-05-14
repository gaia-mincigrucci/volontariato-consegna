<?php
session_start();
require 'database.php';

// Controllo Sicurezza: Solo l'Admin può accedere
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$messaggio = "";
//elimina utente
if (isset($_GET['delete_u'])) {
    $stmt = $pdo->prepare("DELETE FROM utenti WHERE id = ?");
    if ($stmt->execute([$_GET['delete_u']])) $messaggio = "Utente eliminato!";
}
//elimina prenotazione
if (isset($_GET['delete_p'])) {
    $stmt = $pdo->prepare("DELETE FROM prenotazioni WHERE id = ?");
    if ($stmt->execute([$_GET['delete_p']])) $messaggio = "Prenotazione eliminata!";
}
//elimina donazione
if (isset($_GET['delete_d'])) {
    $stmt = $pdo->prepare("DELETE FROM donazioni WHERE id = ?");
    if ($stmt->execute([$_GET['delete_d']])) $messaggio = "Record donazione eliminato!";
}
// modifica utente
if (isset($_POST['update_utente'])) {
    $stmt = $pdo->prepare("UPDATE utenti SET nome=?, cognome=?, email=?, ruolo=? WHERE id=?");
    if ($stmt->execute([$_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['ruolo'], $_POST['id']])) $messaggio = "Utente aggiornato!";
}
// modifica prenotazione
if (isset($_POST['update_prenotazione'])) {
    $stmt = $pdo->prepare("UPDATE prenotazioni SET attivita=?, data_prenotazione=?, orario=? WHERE id=?");
    if ($stmt->execute([$_POST['attivita'], $_POST['data'], $_POST['orario'], $_POST['id']])) $messaggio = "Prenotazione modificata!";
}
// modifica donazione
if (isset($_POST['update_donazione'])) {
    $stmt = $pdo->prepare("UPDATE donazioni SET importo=?, metodo=? WHERE id=?");
    if ($stmt->execute([$_POST['importo'], $_POST['metodo'], $_POST['id']])) $messaggio = "Donazione aggiornata!";
}

$utenti = $pdo->query("SELECT * FROM utenti WHERE ruolo != 'admin' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
try {
    $prenotazioni = $pdo->query("SELECT * FROM prenotazioni ORDER BY data_prenotazione DESC")->fetchAll(PDO::FETCH_ASSOC); 
} catch (Exception $e) {
    $prenotazioni = []; 
}
try {
    $donazioni = $pdo->query("SELECT * FROM donazioni ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC); 
} catch (Exception $e) { 
    $donazioni = []; 
}

//recupero dati per la modifica
$u_mod = isset($_GET['edit_u']) ? ($pdo->prepare("SELECT * FROM utenti WHERE id=?") ?: null) : null;
if($u_mod) {
    $u_mod->execute([$_GET['edit_u']]); 
    $u_mod = $u_mod->fetch();
}

$p_mod = isset($_GET['edit_p']) ? ($pdo->prepare("SELECT * FROM prenotazioni WHERE id=?") ?: null) : null;
if($p_mod) {
    $p_mod->execute([$_GET['edit_p']]); $p_mod = $p_mod->fetch();
}

$d_mod = isset($_GET['edit_d']) ? ($pdo->prepare("SELECT * FROM donazioni WHERE id=?") ?: null) : null;
if($d_mod) {
    $d_mod->execute([$_GET['edit_d']]); $d_mod = $d_mod->fetch(); 
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Admin Dashboard - Gaia</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #001F4D; color: white; }
        .box { width: 95%; max-width: 1100px; margin-bottom: 60px; padding: 25px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .alert { padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 25px; width: 95%; text-align: center; font-weight: bold; }
        h2 { color: #001F4D; border-bottom: 2px solid #001F4D; padding-bottom: 10px; margin-top: 0; }
        .edit-form { background: #eef4ff; border: 2px solid #0047AB; padding: 25px; border-radius: 10px; margin-bottom: 40px; width: 95%; max-width: 1100px; }
        .btn-del { color: #d9534f; text-decoration: none; font-weight: bold; margin-left: 10px; }
        .btn-edit { color: #0047AB; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
//tabelle utenti e tabelle per le modifiche
    <div class="content">
        <h1>PANNELLO AMMINISTRATORE</h1>

        <?php if ($messaggio): ?>
            <div class="alert"><?= $messaggio ?></div>
        <?php endif; ?>

        <?php if ($u_mod): ?>
        <div class="edit-form">
            <h3>MODIFICA UTENTE: <?= htmlspecialchars($u_mod['nome']) ?></h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $u_mod['id'] ?>">
                <input type="text" name="nome" value="<?= htmlspecialchars($u_mod['nome']) ?>" required>
                <input type="text" name="cognome" value="<?= htmlspecialchars($u_mod['cognome']) ?>" required>
                <input type="email" name="email" value="<?= htmlspecialchars($u_mod['email']) ?>" required>
                <select name="ruolo">
                    <option value="utente" <?= $u_mod['ruolo']=='utente'?'selected':'' ?>>Utente</option>
                    <option value="volontario" <?= $u_mod['ruolo']=='volontario'?'selected':'' ?>>Volontario</option>
                </select>
                <button type="submit" name="update_utente" class="btn-blue">SALVA MODIFICHE</button>
                <a href="admin.php" class="cancel-link">Annulla</a>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($p_mod): ?>
        <div class="edit-form">
            <h3>MODIFICA PRENOTAZIONE #<?= $p_mod['id'] ?></h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $p_mod['id'] ?>">
                <input type="text" name="attivita" value="<?= htmlspecialchars($p_mod['attivita']) ?>" required>
                <input type="date" name="data" value="<?= $p_mod['data_prenotazione'] ?>" required>
                <input type="time" name="orario" value="<?= $p_mod['orario'] ?>" required>
                <button type="submit" name="update_prenotazione" class="btn-blue">SALVA PRENOTAZIONE</button>
                <a href="admin.php" class="cancel-link">Annulla</a>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($d_mod): ?>
        <div class="edit-form">
            <h3>MODIFICA DONAZIONE #<?= $d_mod['id'] ?></h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $d_mod['id'] ?>">
                <input type="number" name="importo" value="<?= $d_mod['importo'] ?>" required>
                <input type="text" name="metodo" value="<?= htmlspecialchars($d_mod['metodo']) ?>" required>
                <button type="submit" name="update_donazione" class="btn-blue">SALVA DONAZIONE</button>
                <a href="admin.php" class="cancel-link">Annulla</a>
            </form>
        </div>
        <?php endif; ?>

        <div class="box">
            <h2>ELENCO UTENTI</h2>
            <table>
                <tr><th>Nome</th><th>Cognome</th><th>Email</th><th>Ruolo</th><th>Azioni</th></tr>
                <?php foreach ($utenti as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nome']) ?></td>
                    <td><?= htmlspecialchars($u['cognome']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><strong><?= strtoupper($u['ruolo']) ?></strong></td>
                    <td>
                        <a href="admin.php?edit_u=<?= $u['id'] ?>" class="btn-edit">📝 Modifica</a>
                        <a href="admin.php?delete_u=<?= $u['id'] ?>" class="btn-del" onclick="return confirm('Eliminare questo utente?')">❌ Elimina</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="box">
            <h2>PRENOTAZIONI</h2>
            <table>
                <tr><th>Utente</th><th>Attività</th><th>Data</th><th>Orario</th><th>Azioni</th></tr>
                <?php foreach ($prenotazioni as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['utente_email']) ?></td>
                    <td><?= htmlspecialchars($p['attivita']) ?></td>
                    <td><?= $p['data_prenotazione'] ?></td>
                    <td><?= $p['orario'] ?></td>
                    <td>
                        <a href="admin.php?edit_p=<?= $p['id'] ?>" class="btn-edit">📝 Modifica</a>
                        <a href="admin.php?delete_p=<?= $p['id'] ?>" class="btn-del" onclick="return confirm('Eliminare questa prenotazione?')">❌ Elimina</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="box">
            <h2>DONAZIONI RICEVUTE</h2>
            <table>
                <tr><th>Email</th><th>Importo</th><th>Metodo</th><th>Data</th><th>Azioni</th></tr>
                <?php foreach ($donazioni as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['email']) ?></td>
                    <td><?= $d['importo'] ?> €</td>
                    <td><?= htmlspecialchars($d['metodo']) ?></td>
                    <td><?= $d['data_donazione'] ?></td>
                    <td>
                        <a href="admin.php?edit_d=<?= $d['id'] ?>" class="btn-edit">📝 Modifica</a>
                        <a href="admin.php?delete_d=<?= $d['id'] ?>" class="btn-del" onclick="return confirm('Eliminare questo record?')">❌ Elimina</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>