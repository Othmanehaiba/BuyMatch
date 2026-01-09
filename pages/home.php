<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . "/../classes/MatchRepository.php";
$matchRepo = new MatchRepository();
$matches = $matchRepo->getAllValidateMatches();

// (optional) If you want to restrict to acheteur:
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'acheteur') {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION['user_name'];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>BuyMatch — Accueil Acheteur</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">⚽ BuyMatch</div>
    <ul class="nav-links">
      <li><a href="home.php" class="btn btn-secondary">Accueil</a></li>
      <li><a href="matches.php">Matches</a></li>
      <li><a href="buy_tickets.php">Mes billets</a></li>
      <li><a href="profile.php">Profil</a></li>
      <li><a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<main class="container">

  <section class="hero" style="padding: 22px; border-radius: 14px; background: #0f172a; color: #fff; margin-top: 18px;">
    <h1 style="margin: 0 0 10px;">Bienvenue, <?= htmlspecialchars($userName) ?> 👋</h1>
    <p style="margin: 0 0 16px; opacity: .9;">
      Découvrez les prochains matchs publiés et achetez vos billets en quelques clics.
    </p>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
      <a class="btn btn-primary" href="matches.php">Voir les matchs</a>
      <a class="btn btn-secondary" href="buy_tickets.php">Mes billets</a>
    </div>
  </section>

  <section style="margin-top: 22px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
      <h2 style="margin:0;">Matches publiés (aperçu)</h2>
      <a href="matches.php" class="btn btn-secondary">Tout voir</a>
    </div>

    <?php foreach ($matches as $match): ?>
    <div class="grid" style="margin-top:12px; display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px;">
      <article class="card" style="padding:14px; border-radius:14px;">
        <div style="display:flex; align-items:center; gap:10px;">
          <img src="https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg" alt="Team A" style="width:42px; height:42px; object-fit:contain;">
          <div style="flex:1;">
            <h3 style="margin:0;"><?php echo htmlspecialchars($match['team1_name']); ?> VS <?php echo htmlspecialchars($match['team2_name']); ?></h3>
            <p style="margin:4px 0 0; opacity:.8;"><?php echo htmlspecialchars($match['location']); ?> • <?php echo htmlspecialchars($match['date_heure']); ?></p>
          </div>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
          <span class="badge" style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">Dès 80 MAD</span>
          <a class="btn btn-primary" href="match_details.php?id=<?php echo htmlspecialchars($match['id']); ?>">Voir détails</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

</main>

<footer style="margin-top: 24px;">
  <p style="text-align:center; opacity:.7;">&copy; 2026 BuyMatch</p>
</footer>

<script src="../assets/js/main.js"></script>
</body>
</html>
