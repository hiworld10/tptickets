<?php

namespace app;

use core\Controller;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{

    // Preparación inicial del mail
    public static function prepare($to, $subject)
    {
        $mail = new PHPMailer(true);

        try {
            // $mail->SMTPDebug = 4;

            // Configuración necesaria para utilizar un servidor SMTP local.
            // Esto NO debe estar al usar un SMTP real.
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];
            
            // Configuración de servidor
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            // $mail->SMTPAuth   = true;
            // $mail->Username   = SMTP_USER;
            // $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;

            // Remitente y destinatario
            $mail->setFrom(LOCAL_MAIL_DOMAIN, 'Monito Inc.');
            $mail->addAddress($to);

            // Conteido
            $mail->isHTML(true);
            $mail->Subject = $subject;

            return $mail;

        } catch (Exception $e) {
            throw new Exception('Error al preparar mail.');
        }

    }

    public static function send($to, $subject, $html, $text, $attachments = [])
    {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = 4;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            //Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            // $mail->SMTPAuth   = true;
            // $mail->Username   = SMTP_USER;
            // $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;

            //Recipients
            $mail->setFrom(LOCAL_MAIL_DOMAIN, 'Monito Inc.');
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

    public static function sendWelcomeMessage($to, $data)
    {
        return static::send(
            $to,
            'Bienvenido a TPTickets',
            Controller::getRenderedTemplate('mail/welcome_message_html', $data),
            Controller::getRenderedTemplate('mail/welcome_message_plain', $data)
        );
    }

    public static function purchaseDetails($to, $data)
    {
        return static::send(
            $to,
            'Compra efectuada',
            Controller::getRenderedTemplate('mail/purchase_details_html', $data),
            Controller::getRenderedTemplate('mail/purchase_details_plain', $data)
        );
    }
}
