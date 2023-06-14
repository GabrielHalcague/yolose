<?php
require_once('third-party/PHPMailer/src/Exception.php');
require_once('third-party/PHPMailer/src/PHPMailer.php');
require_once('third-party/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer extends PHPMailer
{
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);
        $this->config();
    }

    private function config()
    {
        $this->isSMTP();
        $this->SMTPAuth = true;
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->Host = 'smtp.gmail.com';
        $this->Port = 465;
        $this->Username = 'sandwich.ganic@gmail.com'; //Reutilizemos el mail de GANIC xD
        $this->Password = 'udefccdybehhhdht';
        $this->isHTML();
    }

    public function sendEmail($to, $subject = '', $body = '')
    {
        try {
            $this->addAddress($to);
            $this->Subject = $subject;
            $this->Body = $body;
            $this->send();
        } catch (Exception $e) {
            echo "Error: {$this->ErrorInfo}";
        }
    }
}
?>