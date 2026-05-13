<?php
session_start();
require 'database.php';
if (!isset($_SESSION['ruolo'])) {
    header('Location: login.php');
    exit;
}

$errore = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $attivita = $_POST['attivita'] ?? 'Prenotazione visita';
    $data = $_POST['data'] ?? $_POST['data_visita'] ?? null;
    $orario = $_POST['orario'] ?? '00:00';

    if (!$data) {
        $errore = 'La data della prenotazione è obbligatoria.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO prenotazioni (utente_email, attivita, data_prenotazione, orario) VALUES (?, ?, ?, ?)');
            $stmt->execute([$email, $attivita, $data, $orario]);
        } catch (PDOException $e) {
            $errore = 'Impossibile salvare la prenotazione: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Prenotazione Confermata</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <h1>PRENOTAZIONE EFFETTUATA!</h1>
        <?php if ($errore): ?>
            <div class="alert"><?= htmlspecialchars($errore) ?></div>
        <?php endif; ?>
        <div class="box">
            <p>Grazie <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong>!</p>
            <p>La tua richiesta è stata registrata con successo nel nostro sistema.</p>
            <p>Ti abbiamo inviato un'email di riepilogo a: <br><em><?= htmlspecialchars($_SESSION['email']) ?></em></p>
            <br>
            <button onclick="location.href='area_utente.php'" class="btn-blue">TORNA ALL'AREA PERSONALE</button>
        </div>
    </div>
</body>
</html>