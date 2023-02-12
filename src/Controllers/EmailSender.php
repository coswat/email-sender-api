<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Controllers\HttpResponse;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class EmailSender
{
    use HttpResponse;
    protected function sendEmail(string $email, string $subject = null)
    {
        $body = file_get_contents('../src/EmailBody/emailbody.html');

        if ($subject === null) {
            $subject = 'Here is the subject';
        }
        try {
            $dotenv = Dotenv::createImmutable('../.');
            $dotenv->load();
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $_ENV['MAIL_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['MAIL_USERNAME'];
                $mail->Password   = $_ENV['MAIL_PASSWORD'];
                $mail->Port       = $_ENV['MAIL_PORT'];

                //Recipients
                $mail->setFrom($_ENV['MAIL_FROM'], 'Mailer');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                http_response_code(200);
                return $this->success([
                  'email' => $email,
                  'time' => strtotime("now")
                  ], 'Email Send Successfully');
            } catch (Exception $e) {
              http_response_code(400);
                return $this->error([], $mail->ErrorInfo);
            }
        } catch (\Throwable $e) {
          http_response_code(500);
            return $this->internalError($e->getMessage());
        }
    }
}
