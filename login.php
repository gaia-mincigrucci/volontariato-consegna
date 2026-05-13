<?php
session_start();
require 'database.php'; // CORRETTO: punta a database.php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    // 1. ACCESSO ADMIN (Email esatta che hai nel tuo codice)
    if($email == "gaia.mincigrucci@gmail.com" && $pwd == "123") {
        $_SESSION['admin'] = true;
        $_SESSION['ruolo'] = 'admin';
        header("Location: admin.php");
        exit;
    }

    // 2. ACCESSO UTENTE (Con verifica password sicura)
    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pwd, $user['pwd'])) {
        $_SESSION['ruolo'] = 'utente';
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['email'] = $user['email'];
        header("Location: area_utente.php");
        exit;
    } else {
        echo "<script>alert('Credenziali errate o utente inesistente!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile.css">
    <title>Login</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="content">
        <h1>ACCESSO</h1>
        <div class="form-container">
            <form method="post">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" required>
                <label>Password</label>
                <input type="password" name="pwd" placeholder="Password" required>
                <button onClick="salvainjson()" class="btn-blue">ACCEDI</button>
            </form>
            <p>Non hai un account? <a href="unisciti.php">Registrati qui</a></p>
        </div>
    </div>
    <script>
    function salvainjson() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    const emailPattern = /\w{1}@[a-z]{2,}\.[a-z]{2,}/;    

    let stringMessage = "";
    if (!emailPattern.test(email)) {
      stringMessage += "Inserisci un'email valida (es. esempio@gmail.com).";
    }
    
    if(stringMessage !== ""){
      alert("Gli errori sono :\n"+ stringMessage);
      return false;
    }

    // 3. LOGICA JSON COME RICHIESTO
    const dati = {
        email: email,
        password: password,
    };
    const jsonString = JSON.stringify(dati, null, 2);
    const blob = new Blob([jsonString], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'registrazione.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    
    return true;
  }
</script>
</body>
</html>