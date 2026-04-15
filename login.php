<?php
session_start();
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    if($email == "gaia.mincigrucci@gmail.com") {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE email = :email AND pwd = :pwd");
    $stmt->execute([':email' => $email, ':pwd' => $pwd]);
    
    if($stmt->fetch()) {
        echo "<script>alert('Benvenuto!');</script>";
    } else {
        echo "<script>alert('Utente non trovato!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
<ul id="menu">
    <li><a href="index.html">HOME</a></li>
    <li><a class="active" href="login.php">LOGIN</a></li>
    <li><a href="contatto.html">CONTATTI</a></li>
    <li><a href="facciamo.html">COSA FACCIAMO</a></li>
    <li><a href="donazione.html">DONAZIONE</a></li>
</ul>
<div class="content">
    <h1>LOGIN</h1>
    <div class="form-container">
        <form method="post">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="pwd" placeholder="Password" required><br>
            <button type="submit">ACCEDI</button>
            <p>Non sei registrato?</p>
            <button type="button" onclick="window.location='unisciti.html'">UNISCITI A NOI</button>
        </form>
    </div>
</div>
</body>
</html>