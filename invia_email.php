<?php
session_start();
require 'database.php';
use PHPMailer\PHPMailer\PHPMailer;
require __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pwd_hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT); // Punto 5

    try {
        $pdo->beginTransaction(); // PUNTO 6: INIZIO TRANSAZIONE

        $sql = "INSERT INTO utenti (nome, cognome, eta, email, pwd, ruolo) VALUES (?, ?, ?, ?, ?, 'utente')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['nome'], $_POST['cognome'], $_POST['eta'], $_POST['email'], $pwd_hash]);

        // PUNTO 6: INVIO EMAIL
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gaia.mincigrucci@gmail.com'; 
        $mail->Password = 'nsvnjbzscpbpdcse'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('gaia.mincigrucci@gmail.com', 'Associazione Gaia');
        $mail->addAddress($_POST['email']);
        $mail->Subject = 'Benvenuto!';
        $mail->Body = "Ciao " . $_POST['nome'] . ", registrazione avvenuta!";
        $mail->send();

        $pdo->commit(); // PUNTO 6: CONFERMA TRANSAZIONE
        
        $_SESSION['ruolo'] = 'utente';
        $_SESSION['nome'] = $_POST['nome'];
        header("Location: area_utente.php");

    } catch (Exception $e) {
        $pdo->rollBack(); // PUNTO 6: ANNULLA SE ERRORE
        echo "Errore: " . $e->getMessage();
    }
}