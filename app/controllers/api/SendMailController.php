<?php

namespace App\Controllers\Api;

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../../vendor/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../vendor/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/ApiBaseController.php';

class SendMailController extends ApiBaseController
{
    private $config;

    public function __construct()
    {
        $file         = __DIR__ . '/../../../app/config/mail.php';
        $this->config = require $file;
    }

    public function sendEmail()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        $email    = $postData['email'] ?? null;

        if ($email === null) {
            http_response_code(400);
            echo 'Error: Email address not provided!';
            exit;
        }

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host       = $this->config['host'];
        $mail->Port       = $this->config['port'];
        $mail->SMTPSecure = $this->config['SMTPSecure'];
        $mail->SMTPAuth   = $this->config['SMTPAuth'];
        $mail->Username   = $this->config['username'];
        $mail->Password   = $this->config['password'];

        // Set the From and Reply-To addresses
        $mail->setFrom($this->config['from_email'], $this->config['from_name']);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Thank You for Subscribing!';
        $mail->Body    = '
            <p>Thank you for subscribing to our newsletter!</p>
            <p>By subscribing, you will receive regular updates on our latest events, exhibitions, and exclusive offers. Stay tuned for exciting news and valuable insights delivered straight to your inbox.</p>
            <p>If you ever have any questions or feedback, feel free to reach out to us. We are here to make your experience with us exceptional.</p>
            <p>Once again, thank you for subscribing! We look forward to keeping in touch.</p>
        ';

        if (!$mail->send()) {
            return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
        return 'Message has been sent';
    }
}
