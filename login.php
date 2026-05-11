<?php
session_start();
require 'database.php'; // CORRETTO: punta a database.php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    // 1. ACCESSO ADMIN (Email esatta che hai nel tuo codice)
    if($email == "gaia.mincigrucci@gmail.com" && $pwd == "admin123") {
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
    <link rel="stylesheet" href="stile.css">
    <title>Login</title>
</head>
<body>
    <ul id="menu">
        <li><a href="home.php">HOME</a></li>
        <li><a href="facciamo.html">COSA FACCIAMO</a></li>
        <li><a href="contatto.html">CONTATTI</a></li>
        <?php if(!isset($_SESSION['ruolo'])): ?>
            <li><a class="active" href="login.php">LOGIN</a></li>
        <?php else: ?>
            <li><a href="area_utente.php">AREA RISERVATA</a></li>
            <li><a href="login.php">LOGOUT</a></li>
        <?php endif; ?>
    </ul>

    <div class="content">
        <h1>ACCESSO</h1>
        <div class="form-container">
            <form method="post">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="pwd" placeholder="Password" required><br>
                <button type="submit">ACCEDI</button>
            </form>
            <p>Non hai un account? <a href="unisciti.html">Registrati qui</a></p>
        </div>
    </div>
</body>
</html>