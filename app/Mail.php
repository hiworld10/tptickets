<?php

namespace app;

use core\Controller;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private $mail;

    // Preparación inicial del mail
    public function prepare($to, $subject)
    {
        $this->mail = new PHPMailer(true);

        try {
            // $this->mail->SMTPDebug = 4;

            // Configuración necesaria para utilizar un servidor SMTP local.
            // Esto NO debe estar al usar un SMTP real.
            $this->mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];
            
            // Configuración de servidor
            $this->mail->isSMTP();
            $this->mail->Host = SMTP_HOST;
            // $this->mail->SMTPAuth   = true;
            // $this->mail->Username   = SMTP_USER;
            // $this->mail->Password   = SMTP_PASS;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = SMTP_PORT;

            // Remitente y destinatario
            $this->mail->setFrom(LOCAL_MAIL_DOMAIN, 'Monito Inc.');
            $this->mail->addAddress($to);

            // Conteido
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;

            return $this->mail;

        } catch (Exception $e) {
            throw new Exception('Error al preparar mail.');
        }

    }

    public function send($to, $subject, $html, $text, $attachments = [])
    {
        $this->mail = new PHPMailer(true);

        try {
            //$this->mail->SMTPDebug = 4;

            $this->mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            //Server settings
            $this->mail->isSMTP();
            $this->mail->Host = SMTP_HOST;
            // $this->mail->SMTPAuth   = true;
            // $this->mail->Username   = SMTP_USER;
            // $this->mail->Password   = SMTP_PASS;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = SMTP_PORT;

            //Recipients
            $this->mail->setFrom(LOCAL_MAIL_DOMAIN, 'Monito Inc.');
            $this->mail->addAddress($to); // Name is optional

            // Attachments
            if (!empty($attachments)) {
                foreach ($attachments as $value) {
                    // Add attachments, new file name optional
                    $this->mail->addAttachment($value['path']);
                }
            }

            // Content
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $html;
            $this->mail->AltBody = $text;

            $this->mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendWelcomeMessage($to, $data)
    {
        $this->send(
            $to,
            'Bienvenido a TPTickets',
            Controller::getRenderedTemplate('mail/welcome_message_html', $data),
            Controller::getRenderedTemplate('mail/welcome_message_plain', $data)
        );
    }

    public function purchaseDetails($to, $data)
    {
        $qr_data_for_embed = [];
        $i                 = 1;

        foreach ($data['items'] as $value) {
            $qr_data_for_embed[] = [
                'code' => file_get_contents($value['qr']->writeDataUri()),
                'cid'  => 'qr_' . $i,
            ];
            $i++;
        }

        echo '<pre>';
        print_r($qr_data_for_embed);
        echo '</pre>';

        // return::send(
        //     $to,
        //     'Detalles de tu compra',
        //     Controller::getRenderedTemplate('mail/purchase_details_html', $data),
        //     Controller::getRenderedTemplate('mail/purchase_details_plain', $data)
        // );
    }
}
