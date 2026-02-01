<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $metodo = $_POST['metodo'];
    $numero_carta = $_POST['numero_carta'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $emailCorretta = "gaia.mincigrucci@gmail.com";
    if($email != $emailCorretta){
        header("Location: errore_donazione.html");
        exit;
    }

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username=$emailCorretta;
        $mail->Password='nsvnjbzscpbpdcse';
        $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port=587;

        $mail->setFrom($emailCorretta,'Associazione Animali');
        $mail->addAddress($emailCorretta);
        $mail->Subject='Nuova donazione ricevuta';
        $mail->Body="Metodo pagamento:$metodo\nNumero carta:$numero_carta\nEmail:$email\nPassword:$pwd";

        $mail->send();
        header("Location: conferma_donazione.html");
        exit;

    } catch(Exception $e){
        header("Location: errore_donazione.html");
        exit;
    }

}else{
    echo "Accesso non valido.";
}
?>
