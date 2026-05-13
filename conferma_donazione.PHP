<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Donazione Effettuata</title>
  <link rel="stylesheet" href="stile.css"/>
</head>
<body>

<?php include 'menu.php'; ?> <div class="content">
  <h1>DONAZIONE EFFETTUATA</h1>
  <div class="box">
      <p>Grazie per la tua donazione e per il tuo aiuto!<br>
      Ti è stata inviata una mail di conferma con i tuoi dati!</p>
      <button onclick="location.href='logout.php'">TORNA ALLA HOME</button>
  </div>
</div>

</body>
</html>