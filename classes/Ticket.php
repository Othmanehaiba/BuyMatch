<?php

class Ticket {
    public static function sendEmail(string $toEmail, string $toName, string $pdfFile): bool {
        // Prefer Composer autoload if available
        if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once __DIR__ . '/../vendor/autoload.php';
        } else {
            // Try common local folders (case-sensitive on Linux)
            $candidates = [__DIR__ . '/../phpmailer/src/PHPMailer.php', __DIR__ . '/../phpMAILER/src/PHPMailer.php', __DIR__ . '/../phpMailer/src/PHPMailer.php'];
            $found = false;
            foreach ($candidates as $c) {
                if (file_exists($c)) {
                    require_once $c;
                    require_once dirname($c) . '/SMTP.php';
                    require_once dirname($c) . '/Exception.php';
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                error_log('PHPMailer not found. Install via Composer: composer require phpmailer/phpmailer');
                return false;
            }
        }

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            // SMTP settings (Mailtrap example)
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = '462fc3325bbf7b';
            $mail->Password   = '405ce9e8715f4a';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            $mail->setFrom('marigotbi@gmail.com', 'BuyMatch');
            $mail->addAddress($toEmail, $toName);

            // Attachment: if $pdfFile is a path to an existing file attach it, otherwise treat as raw string
            if (file_exists($pdfFile)) {
                $mail->addAttachment($pdfFile);
            } else {
                // assume $pdfFile contains PDF binary string
                $mail->addStringAttachment($pdfFile, 'ticket.pdf', 'base64', 'application/pdf');
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Votre ticket pour le match';
            $mail->Body    = "<p>Bonjour " . htmlspecialchars($toName) . ",</p><p>Merci pour votre réservation. Veuillez trouver votre ticket en pièce jointe.</p>";
            $mail->AltBody = "Bonjour " . $toName . ", Merci pour votre réservation. Veuillez trouver votre ticket en pièce jointe.";

            $mail->send();

            // If we attached a temporary file by path, remove it
            if (file_exists($pdfFile)) {
                @unlink($pdfFile);
            }

            return true;
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log('Ticket::sendEmail PHPMailer error: ' . $e->getMessage());
            return false;
        }
    }
}