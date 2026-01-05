<?php
// pages/home.php
session_start();

// (optional) If you want to restrict to acheteur:
// if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'acheteur') {
//     header("Location: login.php");
//     exit;
// }

$userName = $_SESSION['nom'] ?? 'Acheteur';
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

  <section style="margin-top: 18px;">
    <div class="grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px;">
      <div class="card" style="padding:14px; border-radius:14px;">
        <h3 style="margin:0 0 6px;">Tickets achetés</h3>
        <p style="margin:0; opacity:.8;">(exemple) <b>3</b> billets</p>
      </div>
      <div class="card" style="padding:14px; border-radius:14px;">
        <h3 style="margin:0 0 6px;">Prochain match</h3>
        <p style="margin:0; opacity:.8;">(exemple) 2026-02-01 • 18:30</p>
      </div>
      <div class="card" style="padding:14px; border-radius:14px;">
        <h3 style="margin:0 0 6px;">Astuces</h3>
        <p style="margin:0; opacity:.8;">Filtrez par ville et prix dans “Matches”.</p>
      </div>
    </div>
  </section>

  <section style="margin-top: 22px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
      <h2 style="margin:0;">Matches publiés (aperçu)</h2>
      <a href="matches.php" class="btn btn-secondary">Tout voir</a>
    </div>

    <!-- Simple preview cards (static examples) -->
    <div class="grid" style="margin-top:12px; display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px;">
      <article class="card" style="padding:14px; border-radius:14px;">
        <div style="display:flex; align-items:center; gap:10px;">
          <img src="https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg" alt="Team A" style="width:42px; height:42px; object-fit:contain;">
          <div style="flex:1;">
            <h3 style="margin:0;">Real Madrid vs Barcelona</h3>
            <p style="margin:4px 0 0; opacity:.8;">Casablanca • 2026-02-10 • 20:00</p>
          </div>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
          <span class="badge" style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">Dès 80 MAD</span>
          <a class="btn btn-primary" href="match_details.php?id=1">Voir détails</a>
        </div>
      </article>

      <article class="card" style="padding:14px; border-radius:14px;">
        <div style="display:flex; align-items:center; gap:10px;">
          <img src="https://upload.wikimedia.org/wikipedia/en/7/7a/Manchester_United_FC_crest.svg" alt="Team A" style="width:42px; height:42px; object-fit:contain;">
          <div style="flex:1;">
            <h3 style="margin:0;">Man United vs Liverpool</h3>
            <p style="margin:4px 0 0; opacity:.8;">Rabat • 2026-02-05 • 18:30</p>
          </div>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
          <span class="badge" style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">Dès 60 MAD</span>
          <a class="btn btn-primary" href="match_details.php?id=2">Voir détails</a>
        </div>
      </article>

      <article class="card" style="padding:14px; border-radius:14px;">
        <div style="display:flex; align-items:center; gap:10px;">
          <img src="https://upload.wikimedia.org/wikipedia/en/c/cc/Chelsea_FC.svg" alt="Team A" style="width:42px; height:42px; object-fit:contain;">
          <div style="flex:1;">
            <h3 style="margin:0;">Chelsea vs Arsenal</h3>
            <p style="margin:4px 0 0; opacity:.8;">Tanger • 2026-02-12 • 17:00</p>
          </div>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
          <span class="badge" style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">Dès 50 MAD</span>
          <a class="btn btn-primary" href="match_details.php?id=3">Voir détails</a>
        </div>
      </article>
    </div>
  </section>

</main>

<footer style="margin-top: 24px;">
  <p style="text-align:center; opacity:.7;">&copy; 2026 BuyMatch</p>
</footer>

<script src="../assets/js/main.js"></script>
</body>
</html>
