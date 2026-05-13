<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrazione</title>
  <link rel="stylesheet" href="stile.css"/>
</head>
<body>
<div class="content">
  <h1>REGISTRATI</h1>
  <div class="form-container">
    <form action="invia_email.php" method="post">
      <input type="text" name="nome" placeholder="Nome" required><br>
      <input type="text" name="cognome" placeholder="Cognome" required><br>
      <input type="number" name="eta" placeholder="Età" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="pwd" placeholder="Crea Password" required><br>
      <button type="submit">CREA ACCOUNT</button>
    </form>
    <br>
    <a href="login.php">Torna al Login</a>
  </div>
</div>
</body>
</html>