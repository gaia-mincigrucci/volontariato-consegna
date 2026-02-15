<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $metodo = $_POST['metodo'];
    $numero_carta = $_POST['numero_carta'];
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

        // --- SOLUZIONE ERRORE SSL XAMPP ---
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('gaia.mincigrucci@gmail.com', 'Associazione Animali');

        $mail->addAddress($email);

        $mail->Subject = 'Grazie per la tua donazione!';
        $mail->Body    = "Grazie per il tuo supporto!\n\nDettagli della transazione:\nMetodo: $metodo\nEmail: $email\n\nL'Associazione Animali ti ringrazia.";

        $mail->send();

        header("Location: conferma_donazione.html");
        exit;

    } catch (Exception $e) {
        header("Location: errore_donazione.html");
        exit;
    }
} else {
    echo "Accesso non valido.";
}
?>