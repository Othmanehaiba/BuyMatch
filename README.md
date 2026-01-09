# BuyMatch - Frontend Template

Simple and clean frontend template for the BuyMatch sports ticket booking platform. This template is designed to help you focus on PHP OOP and database implementation.

## 📁 Project Structure

```
buymatch/
├── assets/
│   ├── css/
│   │   └── style.css          # Main stylesheet with all styles
│   └── js/
│       └── main.js            # Vanilla JavaScript utilities
├── auth/
│   ├── login.html             # Login page template
│   ├── register.html          # Registration page template
│   └── logout.php             # (You create this)
├── pages/
│   ├── home.html              # Homepage
│   ├── matches.html           # (Similar to home.html - list of matches)
│   ├── match_details.html     # Match details and ticket buying
│   ├── profile.html           # User profile and ticket history
│   └── buy_ticket.php         # (You create this)
├── organizer/
│   ├── dashboard.html         # Organizer dashboard
│   ├── create_match.html      # Create match form
│   └── stats.php              # (You create this)
├── admin/
│   ├── dashboard.html         # Admin dashboard
│   └── validate_match.php     # (You create this)
├── uploads/                   # For uploaded logos
├── 404.html                   # Custom 404 page
├── .htaccess                  # Apache configuration
└── index.html                 # Homepage (entry point)
```

## 🎨 Features

### CSS Features
- Clean, modern design
- Responsive layout (mobile-friendly)
- Pre-built components:
  - Navigation bar
  - Cards for matches
  - Forms with validation styles
  - Tables for data display
  - Modals for popups
  - Badges and alerts
  - Stats cards
  - Seat selection grid

### JavaScript Features
- Modal functionality (open/close)
- Form validation
- Alert system
- Seat selection (max 4 seats)
- Loading spinner
- Utility functions (date/price formatting)
- Confirm dialogs

## 🚀 Getting Started

### 1. Convert HTML to PHP
Simply rename `.html` files to `.php`:
```bash
mv index.html index.php
mv auth/login.html auth/login.php
# etc...
```

### 2. Add PHP Backend Logic

Example for login.php:
```php
<?php
// At the top of login.php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Your OOP login logic here
    // $user = new User();
    // $user->login($email, $password);
}
?>

<!-- Then the HTML from login.html -->
```

### 3. Dynamic Content

Replace static content with PHP:
```php
<!-- Instead of static match cards: -->
<?php
$matches = Match::getAll(); // Your OOP method
foreach ($matches as $match) {
    ?>
    <div class="card">
        <div class="card-body">
            <h3><?= htmlspecialchars($match->getTitle()) ?></h3>
            <p><?= htmlspecialchars($match->getLocation()) ?></p>
            <!-- etc... -->
        </div>
    </div>
    <?php
}
?>
```

### 4. Form Actions

Update form actions to point to your PHP handlers:
```html
<form action="login.php" method="POST">
    <!-- Keep the existing form fields -->
</form>
```

## 🎯 Key Classes & IDs to Use

### For JavaScript Functionality

- `data-modal-target="modal-id"` - Opens modal
- `data-modal-close` - Closes modal
- `data-validate` - Enables form validation
- `.seat` - Seat selection elements
- `data-seat-id="A1"` - Seat identifier

### CSS Classes

- `.btn .btn-primary` - Primary button
- `.btn .btn-secondary` - Secondary button
- `.btn .btn-danger` - Danger/delete button
- `.card` - Card container
- `.badge .badge-success` - Success badge
- `.alert .alert-success` - Success alert
- `.form-control` - Form input styling

## 📝 Integration Tips

### 1. Session Management
Add at the top of protected pages:
```php
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}
?>
```

### 2. Display Messages
```php
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
```

### 3. Navigation Based on Role
```php
<?php if ($_SESSION['role'] === 'organisateur'): ?>
    <li><a href="/organizer/dashboard.php">Dashboard</a></li>
<?php elseif ($_SESSION['role'] === 'admin'): ?>
    <li><a href="/admin/dashboard.php">Admin</a></li>
<?php endif; ?>
```

## 🔧 Customization

### Colors
Edit CSS variables in `assets/css/style.css`:
```css
:root {
    --primary-color: #2563eb;  /* Change to your brand color */
    --secondary-color: #10b981;
    /* etc... */
}
```

### JavaScript Functions
Use the `BuyMatch` global object:
```javascript
BuyMatch.showAlert('Message', 'success');
BuyMatch.openModal('modal-id');
BuyMatch.showLoading();
```

## 📦 Required PHP Libraries

For complete functionality, you'll need:
- PHPMailer (for sending ticket emails)
- FPDF or TCPDF (for generating PDF tickets)

Install via Composer (recommended):
```bash
# Install Composer if you don't have it
sudo apt update && sudo apt install composer

# Install PHPMailer for SMTP email sending
composer require phpmailer/phpmailer

# Optionally install a full PDF library (optional)
composer require tecnickcom/tcpdf
```

Then update `config/mail.php` with your SMTP credentials and sender address. `pages/generate_ticket.php` will use PHPMailer automatically if `vendor/autoload.php` exists.

## ✅ Checklist

- [ ] Rename HTML files to PHP
- [ ] Create database connection (`config/database.php`)
- [ ] Implement OOP classes (User, Match, Ticket, etc.)
- [ ] Add session management
- [ ] Implement authentication logic
- [ ] Add form processing
- [ ] Generate PDF tickets
- [ ] Configure email sending
- [ ] Test all user flows
- [ ] Add SQL views and stored procedures

## 🎓 Focus Areas for OOP

This simple frontend lets you focus on:
- Class design and inheritance
- Database interactions with PDO
- Session and authentication
- File uploads (logos)
- PDF generation
- Email integration
- Form validation
- SQL optimization

