<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__.'/_lib/vendor/autoload.php';

class Mail
{
    static public function sendMail($recipients, $from, $subject, $htmlBody, $textBody = '', $attachment)
    {
        if(empty($recipients)) return "Mail could not be sent. Recipients is empty.";

        $mail = new PHPMailer(true);
        try
        {
            //Server settings
            $mail->CharSet = 'UTF-8';
            # SMTP config
//            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com;smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'dacornagency@gmail.com';                 // SMTP username
            $mail->Password = 'freOkejKendyig7';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to


            //Recipients
            $mail->setFrom($from['email'], $from['company']);
//            $mail->addAddress('example@mail.com', 'John Doe');     // Add a recipient
            foreach($recipients as $rec)
            {
                $mail->addAddress($rec['adress']); // Name is optional
            }
            $mail->addReplyTo($from['email'], $from['company']);
//

            //Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody = $textBody;

            // Attachment
            if(!empty($attachment)) {
                foreach ($attachment as $filepath) {
                    $mail->addAttachment($filepath);
                }
            }


            $mail->send();
            return 'Mail has been sent';
        }
        catch (Exception $err)
        {
            return "Mail could not be sent. Mailer Error:\n" . $mail->ErrorInfo;
        }
    }
}
