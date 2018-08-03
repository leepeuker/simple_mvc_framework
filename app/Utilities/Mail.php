<?php

namespace Utilities;

use \Core\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Provides email services
 *
 * PHP version 7.0
 */
class Mail
{
    /**
     * Send a email
     *
     * @param string $recipient
     * @param string $subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     * @return boolean True if email could be sent, false otherwise
     */
    public static function send($recipient, $subject, $text, $html)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = Config::get('SMTP_DEBUG');
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->Host = Config::get('SMTP_HOST');
            $mail->Port = Config::get('SMTP_PORT');
            $mail->SMTPAuth = Config::get('SMTP_AUTH');
            $mail->Username = Config::get('SMTP_USERNAME');
            $mail->Password = Config::get('SMTP_PASSWORD');
            $mail->SMTPSecure =Config::get('SMTP_SECURE');
        
            //Recipients
            $mail->setFrom(Config::get('EMAIL_WEBMASTER'));
            $mail->addAddress($recipient);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = $text;
        
            $mail->send();

            return true;

        } catch (Exception $e) {
            
            return false;
        }
    }
}
