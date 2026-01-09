<?php
// Server-side PDF ticket generator using a lightweight bundled FPDF drop-in
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/MatchRepository.php";
require_once __DIR__ . "/../classes/Ticket.php";

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(403);
    exit('Vous devez être connecté pour télécharger un billet.');
}

$match_id = isset($_POST['match_id']) ? (int)$_POST['match_id'] : 0;
$category = isset($_POST['category']) ? trim($_POST['category']) : '';
$seats = isset($_POST['seats']) ? trim($_POST['seats']) : '';

if (!$match_id || !$category || !$seats) {
    http_response_code(400);
    exit('Paramètres manquants.');
}

$matchRepo = new MatchRepository();
$match = $matchRepo->getMatchById($match_id);
if (!$match) {
    http_response_code(404);
    exit('Match introuvable.');
}
// $matchRepo->getMatchById returns array of rows (categories repeated), take first row
$first = $match[0];

// Try to find category price
$pricePerSeat = null;
foreach ($match as $row) {
    if (strtolower($row['nom']) === strtolower($category)) {
        $pricePerSeat = (float)$row['prix'];
        break;
    }
}
if ($pricePerSeat === null) {
    http_response_code(400);
    exit('Catégorie invalide.');
}

$seatsArr = array_filter(array_map('trim', explode(',', $seats)));
$seatCount = count($seatsArr);
if ($seatCount === 0) {
    http_response_code(400);
    exit('Aucune place sélectionnée.');
}

$total = $seatCount * $pricePerSeat;

// fetch user info (best effort)
$pdo = Database::getConnection();
$stmt = $pdo->prepare('SELECT nom, email FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['nom' => 'Utilisateur', 'email' => ''];

// Use bundled FPDF drop-in for PDF generation
require_once __DIR__ . "/../lib/fpdf.php"; // small library bundled in repo

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10, "BuyMatch - Billet", 0, 1, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8, "Match: " . $first['team1_name'] . " vs " . $first['team2_name'], 0, 1);
$pdf->Cell(0,8, "Lieu: " . $first['stade_name'] . " - " . $first['stade_ville'], 0, 1);
$pdf->Cell(0,8, "Date: " . $first['date_heure'], 0, 1);
$pdf->Cell(0,8, "Catégorie: " . $category, 0, 1);
$pdf->Cell(0,8, "Places: " . implode(', ', $seatsArr), 0, 1);
$pdf->Cell(0,8, "Nombre: " . $seatCount, 0, 1);
$pdf->Cell(0,8, "Total: " . number_format($total,2) . " MAD", 0, 1);
$pdf->Ln(4);
$pdf->Cell(0,8, "Nom: " . ($user['nom'] ?? ''), 0, 1);
$pdf->Cell(0,8, "Email: " . ($user['email'] ?? ''), 0, 1);

$filename = sprintf('ticket_match_%d_%d.pdf', $match_id, time());

// Get PDF as string
$pdfStr = $pdf->Output('S', $filename);

$ticket = Ticket::sendEmail($user['email'], $user['nom'] ?? '', $filename);

// Load mail config
require_once __DIR__ . '/../config/mail.php';

$subject = "Votre billet BuyMatch - {$first['team1_name']} vs {$first['team2_name']}";
$message = "Bonjour " . ($user['nom'] ?? '') . ",\n\nMerci pour votre achat. Vous trouverez votre billet en pièce jointe.\n\nCordialement,\nBuyMatch";

$sent = false;

// Try PHPMailer via Composer if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        // SMTP config from config/mail.php
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = MAIL_SMTP_AUTH;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->Port = MAIL_PORT;
        if (defined('MAIL_SMTP_AUTO_TLS') && MAIL_SMTP_AUTO_TLS === false) {
            $mail->SMTPAutoTLS = false;
        }
        if (defined('MAIL_SMTP_DEBUG')) {
            $mail->SMTPDebug = MAIL_SMTP_DEBUG;
        }

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($user['email'], $user['nom'] ?? '');
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;
        $mail->addStringAttachment($pdfStr, $filename, 'base64', 'application/pdf');

        $mail->send();
        $sent = true;
    } catch (Exception $e) {
        error_log('PHPMailer error: ' . $e->getMessage());
        $sent = false;
    }
} else {
    // Fallback: use basic mail with MIME attachment
    function sendEmailWithAttachment($to, $subject, $message, $attachmentString, $attachmentName, $fromEmail = MAIL_FROM) {
        $separator = md5(time());
        $eol = "\r\n";

        $headers = "From: BuyMatch <{$fromEmail}>" . $eol;
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$separator}\"" . $eol . $eol;

        $body = "--{$separator}" . $eol;
        $body .= "Content-Type: text/plain; charset=\"utf-8\"" . $eol;
        $body .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;
        $body .= $message . $eol . $eol;

        $body .= "--{$separator}" . $eol;
        $body .= "Content-Type: application/pdf; name=\"{$attachmentName}\"" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol;
        $body .= "Content-Disposition: attachment; filename=\"{$attachmentName}\"" . $eol . $eol;
        $body .= chunk_split(base64_encode($attachmentString)) . $eol . $eol;
        $body .= "--{$separator}--" . $eol;

        return mail($to, $subject, $body, $headers);
    }

    if (!empty($user['email'])) {
        $sent = sendEmailWithAttachment($user['email'], $subject, $message, $pdfStr, $filename);
        if (!$sent) error_log('Ticket email failed to send to: ' . ($user['email'] ?? 'unknown'));
    } else {
        error_log('Ticket email not sent: user has no email on file');
    }
}

// Finally output PDF to browser for immediate download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
echo $pdfStr;
exit();
