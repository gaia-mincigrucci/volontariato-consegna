<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require __DIR__ . '/vendor/autoload.php';
require 'database.php';

if (!isset($_SESSION['ruolo'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $metodo = $_POST['metodo'] ?? '';
    $email = $_POST['email'] ?? $_SESSION['email'] ?? '';
    $importo = $_POST['importo'] ?? 0;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: errore_donazione.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO donazioni (email, importo, metodo, data_donazione) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$email, $importo, $metodo]);
    } catch (PDOException $e) {
        header('Location: errore_donazione.php');
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gaia.mincigrucci@gmail.com';
        $mail->Password = 'etyo lqeo miux bxvy';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

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
        $mail->Body    = "Grazie per il tuo supporto!\n\nDettagli della transazione:\nMetodo: $metodo\nImporto: €$importo\nEmail: $email\n\nL'Associazione Animali ti ringrazia.";

        $mail->send();
        header('Location: conferma_donazione.php');
        exit;
    } catch (Exception $e) {
        header('Location: errore_donazione.php');
        exit;
    }
} else {
    echo "Accesso non valido.";
}
?>