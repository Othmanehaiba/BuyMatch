<?php
// Mail configuration for PHPMailer SMTP
// Edit these values to match your SMTP provider credentials.
// The default below is a Mailtrap sandbox example — replace with your sandbox credentials.

// SMTP server (Mailtrap sandbox example)
if (!defined('MAIL_HOST')) define('MAIL_HOST', 'sandbox.smtp.mailtrap.io');
if (!defined('MAIL_PORT')) define('MAIL_PORT', 2525); // Mailtrap supports 25, 465, 587 or 2525
if (!defined('MAIL_USERNAME')) define('MAIL_USERNAME', '462fc3325bbf7b'); // <- replace with your Mailtrap username
if (!defined('MAIL_PASSWORD')) define('MAIL_PASSWORD', 'your_mailtrap_password'); // <- replace with your Mailtrap password
if (!defined('MAIL_SMTP_SECURE')) define('MAIL_SMTP_SECURE', 'tls'); // 'tls' or 'ssl' or ''
if (!defined('MAIL_SMTP_AUTH')) define('MAIL_SMTP_AUTH', true);
if (!defined('MAIL_SMTP_AUTO_TLS')) define('MAIL_SMTP_AUTO_TLS', true);

// From address
if (!defined('MAIL_FROM')) define('MAIL_FROM', 'no-reply@buymatch.local');
if (!defined('MAIL_FROM_NAME')) define('MAIL_FROM_NAME', 'BuyMatch');

// Optional: set to non-zero to enable PHPMailer debug output (0,1,2)
if (!defined('MAIL_SMTP_DEBUG')) define('MAIL_SMTP_DEBUG', 0);

return true;
