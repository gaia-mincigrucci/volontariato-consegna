<?php
session_start();
require 'database.php';

// Protezione: solo utenti loggati
if(!isset($_SESSION['ruolo'])) {
    header("Location: login.php");
    exit();
}

$messaggio = "";

// Salvataggio nel Database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attivita = $_POST['attivita'];
    $data = $_POST['data'];
    $orario = $_POST['orario'];
    $email = $_SESSION['email']; // Prendiamo l'email dalla sessione

    $sql = "INSERT INTO prenotazioni (utente_email, attivita, data_prenotazione, orario) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$email, $attivita, $data, $orario])) {
        $messaggio = "Prenotazione salvata con successo!";
    } else {
        $messaggio = "Errore durante il salvataggio.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile.css">
    <title>Prenota Volontariato</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="content">
        <h1>PRENOTA IL TUO TURNO</h1>
        
        <div class="box">
            <?php if($messaggio) echo "<p style='color:green'>$messaggio</p>"; ?>
            
            <form method="POST" action="prenotazione.php">
                <label>Scegli l'attività:</label>
                <select name="attivita" required>
                    <option value="">-- Seleziona --</option>
                    <option value="Canile">Canile (Passeggiate e pulizia)</option>
                    <option value="Gattile">Gattile (Cura e pappa)</option>
                    <option value="Soccorso">Soccorso Animali</option>
                    <option value="Evento">Banchetto Informativo</option>
                </select>
                <br>
                <br>
                <br>
                <label>Data:</label>
                <input type="date" name="data" required>
                <br>
                <br>
                <br>
                <label>Orario:</label>
                <select name="orario" required>
                    <option value="09:00">Mattina (09:00 - 12:00)</option>
                    <option value="15:00">Pomeriggio (15:00 - 18:00)</option>
                    <option value="20:00">Sera (20:00 - 22:00)</option>
                </select>

                <button type="submit" style="margin-top: 20px;">CONFERMA PRENOTAZIONE</button>
            </form>
        </div>
    </div>
</body>
</html>