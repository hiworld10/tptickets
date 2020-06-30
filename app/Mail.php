<?php

namespace app;

use PHPMailer\PHPMailer\PHPMailer;
use app\utils\StringUtils;
use core\Controller;

class Mail
{
    private $mail;

    // Preparación inicial del mail
    private function prepare($to, $subject)
    {
        $this->mail = new PHPMailer(true);

        $this->mail->SMTPDebug = 1;

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
        $this->mail->addAddress($to); //Nombre opcional

        // Conteido
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;

    }

    private function addBody($html, $text)
    {
        $this->mail->Body    = $html;
        $this->mail->AltBody = $text;
    }

    private function addAttachment($attachment)
    {
        $this->mail->addAttachment($attachment); //new file name is optional
    }

    private function addStringEmbeddedImage($embedded_image, $cid, $alt_name)
    {
        $this->mail->addStringEmbeddedImage($embedded_image, $cid, $alt_name);
    }

    private function send()
    {
        try {
            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        }
    }

    public function sendWelcomeMessage($to, $data)
    {
        $this->prepare($to, 'Bienvenido a TPTickets');
        $this->addBody(
            Controller::getRenderedTemplate('mail/welcome_message_html', $data),
            Controller::getRenderedTemplate('mail/welcome_message_plain', $data)
        );
        $this->send();
    }

    public function purchaseDetails($to, $data)
    {
        $this->prepare($to, 'Detalles de compra');

        $i = 1;

        // Almacenamiento en string de códigos qr, posteriormente agregados al mail
        foreach ($data['items'] as $value) {
            $qr_string = file_get_contents($value['qr']->writeDataUri());
            $cid       = 'qr_' . $i;

            $data['qr_cid'][] = $cid;

            $this->addStringEmbeddedImage($qr_string, $cid, 'qrcode.png');
            
            $qr_file_path = 
                PROJECT_ROOT . 
                '/files/qr/' . 
                $i . 
                '_' .
                StringUtils::lowercaseAndUnderscores(
                    $value['event_name'] . '_'  . $value['seat_type']
                ) .
                '.png'
            ;

            $value['qr']->writeFile($qr_file_path);

            $this->addAttachment($qr_file_path);

            $i++;
        }

        $this->addBody(
            Controller::getRenderedTemplate('mail/purchase_details_html', $data),
            Controller::getRenderedTemplate('mail/purchase_details_plain', $data)
        );

        $this->send();
    }
}
