<?php
// Simple SMTP test page to verify PHPMailer + SMTP configuration (Mailtrap friendly)
require_once __DIR__ . '/../config/mail.php';

$to = $_GET['to'] ?? MAIL_FROM; // send to MAIL_FROM by default (Mailtrap will capture)
$subject = 'Test email from BuyMatch';
$body = "This is a test email to verify SMTP settings (Mailtrap).";

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = MAIL_SMTP_AUTH;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->Port = MAIL_PORT;
        if (defined('MAIL_SMTP_DEBUG')) $mail->SMTPDebug = MAIL_SMTP_DEBUG;

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        if ($mail->send()) {
            echo "SMTP test email sent to: " . htmlspecialchars($to) . ".\nCheck your Mailtrap inbox (if using Mailtrap).";
        } else {
            echo "PHPMailer reports failure sending message.";
        }
    } catch (Exception $e) {
        echo 'PHPMailer error: ' . htmlspecialchars($e->getMessage());
    }
} else {
    // Composer/PHPMailer not installed
    echo "PHPMailer not found. To install run (on the server):\n";
    echo "\n  sudo apt update && sudo apt install composer\n  composer require phpmailer/phpmailer\n";
    echo "\nAfter that you can test again using: /pages/test_smtp.php?to=you@example.com";
}
