<?php
require 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $eta = $_POST['eta'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

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

    $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gaia.mincigrucci@gmail.com';
        $mail->Password = 'nsvnjbzscpbpdcse';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        /*$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );*/

        $mail->setFrom('gaia.mincigrucci@gmail.com', 'Associazione Animali');
        $mail->addAddress($email);
        $mail->addCC('gaia.mincigrucci@gmail.com');

        $mail->Subject = 'Conferma Registrazione Volontario';
        $mail->Body = "Ciao $nome $cognome,\nGrazie per esserti unito a noi!\n\nDati registrati:\nNome: $nome\nCognome: $cognome\nEmail: $email\nEtà: $eta";

        $mail->send();
        header("Location: conferma_unisciti.html");
        exit;

}
?>