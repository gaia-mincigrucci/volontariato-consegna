<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $nome=$_POST['nome'];
    $cognome=$_POST['cognome'];
    $eta=$_POST['eta'];
    $email=$_POST['email'];
    $pwd=$_POST['pwd'];


    $emailCorretta = "gaia.mincigrucci@gmail.com";
    if($email != $emailCorretta){
        header("Location: errore_unisciti.html");
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
        $mail->Subject='Nuova registrazione volontario';
        $mail->Body="Nuovo volontario:\nNome:$nome\nCognome:$cognome\nEtà:$eta\nEmail:$email\nPassword:$pwd";

        $mail->send();
        header("Location: conferma_unisciti.html");
        exit;

    } catch(Exception $e){
        header("Location: errore_unisciti.html");
        exit;
    }

}else{
    echo "Accesso non valido.";
}
?>
