<?php
session_start();
require 'database.php';

// Protezione: solo utenti loggati
if (!isset($_SESSION['ruolo'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $attivita = $_POST['attivita'];
    $data = $_POST['data'];
    $orario = $_POST['orario'];

    try {
        // Inseriamo la prenotazione nel database
        $stmt = $pdo->prepare("INSERT INTO prenotazioni (utente_email, attivita, data_prenotazione, orario) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $attivita, $data, $orario]);
        
        // Se l'inserimento riesce, andiamo alla pagina di conferma
        header("Location: conferma_prenotazione.php");
        exit;
    } catch (PDOException $e) {
        $errore = "Ops! Qualcosa è andato storto: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Prenota Visita</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <h1>PRENOTA UNA VISITA</h1>
        <div class="box">
            <?php if(isset($errore)) echo "<div class='alert'>" . htmlspecialchars($errore) . "</div>"; ?>
            <p>Scegli quando venire a trovarci in associazione.</p>
            
            <form method="POST">
                <label>Cosa vuoi fare?</label>
                <select name="attivita" required>
                    <option value="Visita Rifugio">Visita al Rifugio</option>
                    <option value="Volontariato">Giornata da Volontario</option>
                    <option value="Tempo insieme agli animali">Tempo con gli animali</option>
                </select>

                <label>Scegli il giorno:</label>
                <input type="date" name="data" required>

                <label>Scegli l'orario:</label>
                <input type="time" name="orario" required>

                <button type="submit" class="btn-blue">CONFERMA PRENOTAZIONE</button>
            </form>
        </div>
    </div>
</body>
</html>