<?php
require 'database.php'; // CORRETTO: punta a database.php
// ... mantieni gli use di PHPMailer ...

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $eta = $_POST['eta'];
    $email = $_POST['email'];
    
    // CRITTOGRAFA LA PASSWORD (Obbligatorio per la sicurezza)
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO utenti (nome, cognome, eta, email, pwd) VALUES (:nome, :cognome, :eta, :email, :pwd)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':cognome' => $cognome,
            ':eta' => $eta,
            ':email' => $email,
            ':pwd' => $pwd
        ]);
        
        // ... qui segue il tuo codice PHPMailer per inviare l'email ...
        
        header("Location: area_utente.php"); // Dopo la registrazione lo mandiamo all'area utente
    } catch (PDOException $e) { echo "Errore: " . $e->getMessage(); }
}