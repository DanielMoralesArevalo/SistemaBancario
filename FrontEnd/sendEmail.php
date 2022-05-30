<?php ob_start();?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '..\vendor\phpmailer\phpmailer\src\Exception.php';
/* Clase principal de PHPMailer */
require '..\vendor\phpmailer\phpmailer\src\PHPMailer.php';
/* Clase SMTP, necesaria si quieres usar SMTP */
require '..\vendor\phpmailer\phpmailer\src\SMTP.php';

require '..\vendor\autoload.php';
//Create an instance; passing `true` enables exceptions


function sendEmail($mpdf,$email){
    $mail = new PHPMailer(TRUE);
    try {
        //Recibir todos los parámetros del formulario
        $emailAttachment = $mpdf->Output('','S');
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';      //Set the SMTP server to send through
        // smtp.office365.com
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'danielsuarez8910@outlook.com';                     //SMTP username
        $mail->Password   = base64_decode('OTgwNzIw');                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('danielsuarez8910@outlook.com', 'Daniel');
        //Content
        $mail->AddAddress($email); 
        $mail->Subject = 'Extracto Bancario';
        $mail->Body    = 'Buenas Tardes Usuario, Adjunto Encontraras un PDF con tu Extracto Bancario';
        $mail->AddStringAttachment($emailAttachment, 'file.pdf', 'base64', 'application/pdf');
        $mail->send();
        echo'<script type="text/javascript">
                alert("Enviado Correctamente");
            </script>';
        
    } catch (Exception $e) {
        echo $e;
    }
}
?>
<?php ob_end_flush(); ?>

