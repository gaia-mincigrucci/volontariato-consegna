<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $eta = $_POST['eta'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gaia.mincigrucci@gmail.com';
        $mail->Password = 'nsvnjbzscpbpdcse';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Opzioni per far funzionare XAMPP/Windows
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('gaia.mincigrucci@gmail.com', 'Associazione Animali');
        $mail->addAddress($email);

        $mail->Subject = 'Conferma Registrazione Volontario';
        $mail->Body = "Ciao $nome, grazie per esserti unito a noi!\nI tuoi dati:\nNome: $nome\nCognome: $cognome\nEmail: $email";

        $mail->send();
        header("Location: conferma_unisciti.html");
        exit;

    } catch (Exception $e) {
        header("Location: errore_unisciti.html");
        exit;
    }
}
?>