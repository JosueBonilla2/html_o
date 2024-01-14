<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once "conexion.php";

    function mandar_correo($archivo){

        require 'C:/xampp/htdocs/postmortem/phpmailer/src/PHPMailer.php';
        require 'C:/xampp/htdocs/postmortem/phpmailer/src/SMTP.php';
        require 'C:/xampp/htdocs/postmortem/phpmailer/src/Exception.php';

        if(!isset($_SESSION['userA'])){
            header('Location: logIn.html');
        }
        else{
            $user = $_SESSION['userA'];
        }

        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 0;                   
            $mail->isSMTP();                                          
            $mail->Host       = 'smtp.gmail.com';                   
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'josuebc2720@gmail.com';                     
            $mail->Password   = 'oame wfiw soea sxeg';                              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;             
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


            $mail->setFrom('josuebc2720@gmail.com', 'POSTMORTEM');    
            $mail->addAddress($user);    


            $mail->isHTML(true);                                  
            $mail->Subject = 'PRUEBA';
            $cuerpo = '<h4>Este es el correo mandado</<h4>';
            $mail->Body    = utf8_decode($cuerpo);

            $pdfFilePath = 'Recibo.pdf'; // Ruta al archivo PDF que deseas adjuntar
            $mail->addAttachment($pdfFilePath);
            
            $mail->setLanguage('es','C:/xampp/htdocs/postmortem/phpmailer.lang-es.php');

            $mail->send();

        } catch (Exception $e) {
                echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
                exit;   
            }
    }
?>