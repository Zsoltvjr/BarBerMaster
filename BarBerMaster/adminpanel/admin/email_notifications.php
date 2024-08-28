<?php
// email_notifications.php
require_once "../../phpmailer/PHPMailerAutoload.php";

function sendNotificationEmail($email, $action, $username) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'vtsfrizer@gmail.com';
        $mail->Password = 'uyuy ltjk rzfe mwvl';

        //Recipients
        $mail->setFrom('vtsfrizer@gmail.com', 'VTSFRIZER');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Fiokertesites';

        switch ($action) {
            case 'ban':
                $mail->Body = "Tisztelt $username,<br><br>A fiókját letiltottuk. Ha úgy gondolja, hogy ez tévedés, kérjük, lépjen kapcsolatba az ügyfélszolgálattal.";
                break;
            case 'unban':
                $mail->Body = "Tisztelt $username,<br><br>A fiókodat feloldottuk. Most már újra bejelentkezhetsz.";
                break;
        }

        $mail->send();
    } catch (Exception $e) {
        // Handle mail sending error, if needed
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
