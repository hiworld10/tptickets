<?php

namespace app;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public static function send($to, $subject, $html, $text, $attachments = [])
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom(MAIL_DOMAIN, 'Monito Inc.');
            $mail->addAddress($to); // Name is optional

            // Attachments
            if (!empty($attachments)) {
                foreach ($attachments as $value) {
                    // Add attachments, new file name optional
                    $mail->addAttachment($value['path']);
                }
            }

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = $text;

            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendWelcomeMessage($to)
    {
        $text =
            '¡Gracias por haberte registrado! Esperamos que puedas disfrutar de todos los eventos que tenemos disponibles para vos.
            Visitá nuestra página utilizando el siguiente link:
            http://localhost/tptickets';

        $html =
            '<p>&iexcl;Gracias por haberte registrado! Esperamos que puedas disfrutar de todos los eventos que tenemos disponibles para vos.</p>
            <br>
            <p>Visit&aacute; nuestra p&aacute;gina
                <a href="' . FRONT_ROOT . '">aqu&iacute;</a>.
            </p>';

        return static::send(
            $to,
            'Bienvenido a TPTickets',
            $html,
            $text
        );
    }
}
