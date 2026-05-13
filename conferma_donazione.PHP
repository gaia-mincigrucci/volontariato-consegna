<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donazione Effettuata</title>
  <link rel="stylesheet" href="stile.css"/>
</head>
<body>

<?php include 'menu.php'; ?> <div class="content">
  <h1>DONAZIONE EFFETTUATA</h1>
  <div class="box">
      <p>Grazie per la tua donazione e per il tuo aiuto!<br>
      Ti è stata inviata una mail di conferma con i tuoi dati!</p>
      <button onclick="location.href='area_utente.php'" class="btn-blue">TORNA ALL'AREA PERSONALE</button>  </div>
</div>

</body>
</html>