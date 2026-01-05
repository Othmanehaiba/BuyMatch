<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>BuyMatch — Statistiques Organisateur</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">⚽ BuyMatch</div>
    <ul class="nav-links">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="create_match.php">Créer un match</a></li>
      <li><a href="stats.php" class="btn btn-secondary">Statistiques</a></li>
      <li><a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<main class="container" style="margin-top:18px;">

  <h2 style="margin:0 0 12px;">📊 Statistiques</h2>

  <!-- Cards -->
  <section style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
    <div class="card" style="padding:14px; border-radius:14px;">
      <h3 style="margin:0 0 6px;">Matches créés</h3>
      <p style="margin:0; font-size:22px;"><b>12</b></p>
      <p style="margin:6px 0 0; opacity:.7;">Total des matchs que vous avez créés</p>
    </div>

    <div class="card" style="padding:14px; border-radius:14px;">
      <h3 style="margin:0 0 6px;">Billets vendus</h3>
      <p style="margin:0; font-size:22px;"><b>234</b></p>
      <p style="margin:6px 0 0; opacity:.7;">Total des billets vendus</p>
    </div>

    <div class="card" style="padding:14px; border-radius:14px;">
      <h3 style="margin:0 0 6px;">Chiffre d’affaires</h3>
      <p style="margin:0; font-size:22px;"><b>18 540.00 MAD</b></p>
      <p style="margin:6px 0 0; opacity:.7;">Revenu total estimé</p>
    </div>
  </section>

  <!-- Status -->
  <section class="card" style="margin-top:14px; padding:14px; border-radius:14px;">
    <h3 style="margin:0 0 10px;">Matches par statut</h3>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:12px;">
      <div style="padding:12px; border-radius:12px; background:#f1f5f9;">
        <div style="font-weight:600;">En attente</div>
        <div style="font-size:20px; font-weight:700;">4</div>
      </div>

      <div style="padding:12px; border-radius:12px; background:#f1f5f9;">
        <div style="font-weight:600;">Publié</div>
        <div style="font-size:20px; font-weight:700;">6</div>
      </div>

      <div style="padding:12px; border-radius:12px; background:#f1f5f9;">
        <div style="font-weight:600;">Refusé</div>
        <div style="font-size:20px; font-weight:700;">1</div>
      </div>

      <div style="padding:12px; border-radius:12px; background:#f1f5f9;">
        <div style="font-weight:600;">Validé</div>
        <div style="font-size:20px; font-weight:700;">1</div>
      </div>
    </div>
  </section>

  <!-- Top matches table -->
  <section class="card" style="margin-top:14px; padding:14px; border-radius:14px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
      <h3 style="margin:0;">Top matches (billets vendus)</h3>

      <!-- Simple filter UI (front only) -->
      <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <select class="form-control" style="min-width:180px;">
          <option value="">Tous les statuts</option>
          <option>En attente</option>
          <option>Publié</option>
          <option>Refusé</option>
          <option>Validé</option>
        </select>
        <input class="form-control" type="text" placeholder="Rechercher (ID, équipe...)" style="min-width:220px;">
      </div>
    </div>

    <div style="overflow:auto; margin-top:12px;">
      <table style="width:100%; border-collapse:collapse; min-width:700px;">
        <thead>
          <tr style="text-align:left; border-bottom:1px solid #e2e8f0;">
            <th style="padding:10px;">Match</th>
            <th style="padding:10px;">Date & heure</th>
            <th style="padding:10px;">Ville / Stade</th>
            <th style="padding:10px;">Statut</th>
            <th style="padding:10px;">Billets vendus</th>
            <th style="padding:10px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr style="border-bottom:1px solid #f1f5f9;">
            <td style="padding:10px;">#12 — Barca vs Real</td>
            <td style="padding:10px;">2026-02-10 20:00</td>
            <td style="padding:10px;">Casablanca — Mohammed V</td>
            <td style="padding:10px;">
              <span style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">Publié</span>
            </td>
            <td style="padding:10px;"><b>120</b></td>
            <td style="padding:10px;">
              <a class="btn btn-primary" href="#">Voir</a>
              <a class="btn btn-secondary" href="#">Détails</a>
            </td>
          </tr>

          <tr style="border-bottom:1px solid #f1f5f9;">
            <td style="padding:10px;">#8 — Arsenal vs Chelsea</td>
            <td style="padding:10px;">2026-02-12 17:00</td>
            <td style="padding:10px;">Tanger — Ibn Batouta</td>
            <td style="padding:10px;">
              <span style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">En attente</span>
            </td>
            <td style="padding:10px;"><b>54</b></td>
            <td style="padding:10px;">
              <a class="btn btn-primary" href="#">Voir</a>
              <a class="btn btn-secondary" href="#">Détails</a>
            </td>
          </tr>

          <tr style="border-bottom:1px solid #f1f5f9;">
            <td style="padding:10px;">#3 — MU vs Liverpool</td>
            <td style="padding:10px;">2026-02-05 18:30</td>
            <td style="padding:10px;">Rabat — Moulay Abdellah</td>
            <td style="padding:10px;">
              <span style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">Refusé</span>
            </td>
            <td style="padding:10px;"><b>0</b></td>
            <td style="padding:10px;">
              <a class="btn btn-primary" href="#">Voir</a>
              <a class="btn btn-secondary" href="#">Détails</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination (front only) -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px; gap:10px; flex-wrap:wrap;">
      <p style="margin:0; opacity:.7;">Affichage: 1–3 sur 12</p>
      <div style="display:flex; gap:8px;">
        <button class="btn btn-secondary" type="button">Précédent</button>
        <button class="btn btn-secondary" type="button">Suivant</button>
      </div>
    </div>
  </section>

</main>

<footer style="margin-top:24px;">
  <p style="text-align:center; opacity:.7;">&copy; 2026 BuyMatch</p>
</footer>

<script src="../assets/js/main.js"></script>
</body>
</html>
