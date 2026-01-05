<?php
// pages/matches.php
session_start();

$matches = [
  [
    'id' => 1,
    'team_a' => 'Real Madrid',
    'team_b' => 'Barcelona',
    'logo_a' => 'https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg',
    'logo_b' => 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg',
    'city' => 'Casablanca',
    'stadium' => 'Stade Mohammed V',
    'date' => '2026-02-10',
    'time' => '20:00',
    'price_from' => 80,
    'status' => 'publie'
  ],
  [
    'id' => 2,
    'team_a' => 'Man United',
    'team_b' => 'Liverpool',
    'logo_a' => 'https://upload.wikimedia.org/wikipedia/en/7/7a/Manchester_United_FC_crest.svg',
    'logo_b' => 'https://upload.wikimedia.org/wikipedia/en/0/0c/Liverpool_FC.svg',
    'city' => 'Rabat',
    'stadium' => 'Complexe Moulay Abdellah',
    'date' => '2026-02-05',
    'time' => '18:30',
    'price_from' => 60,
    'status' => 'publie'
  ],
  [
    'id' => 3,
    'team_a' => 'Chelsea',
    'team_b' => 'Arsenal',
    'logo_a' => 'https://upload.wikimedia.org/wikipedia/en/c/cc/Chelsea_FC.svg',
    'logo_b' => 'https://upload.wikimedia.org/wikipedia/en/5/53/Arsenal_FC.svg',
    'city' => 'Tanger',
    'stadium' => 'Stade Ibn Batouta',
    'date' => '2026-02-12',
    'time' => '17:00',
    'price_from' => 50,
    'status' => 'publie'
  ],
];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>BuyMatch — Matches</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">⚽ BuyMatch</div>
    <ul class="nav-links">
      <li><a href="home.php">Accueil</a></li>
      <li><a href="matches.php" class="btn btn-secondary">Matches</a></li>
      <li><a href="buy_tickets.php">Mes billets</a></li>
      <li><a href="profile.php">Profil</a></li>
      <li><a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<main class="container" style="margin-top:18px;">

  <h2 style="margin:0 0 12px;">Matches publiés</h2>

  <!-- Filters -->
  <section class="card" style="padding:14px; border-radius:14px;">
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
      <div class="form-group">
        <label for="q">Recherche (équipe / ville)</label>
        <input id="q" class="form-control" type="text" placeholder="ex: Barcelona, Casablanca...">
      </div>

      <div class="form-group">
        <label for="city">Ville</label>
        <select id="city" class="form-control">
          <option value="">Toutes</option>
          <option value="Casablanca">Casablanca</option>
          <option value="Rabat">Rabat</option>
          <option value="Tanger">Tanger</option>
        </select>
      </div>

      <div class="form-group">
        <label for="date">Date</label>
        <input id="date" class="form-control" type="date">
      </div>

      <div class="form-group">
        <label for="maxPrice">Prix max (MAD)</label>
        <input id="maxPrice" class="form-control" type="number" min="0" placeholder="ex: 80">
      </div>
    </div>

    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
      <button id="resetFilters" type="button" class="btn btn-secondary">Réinitialiser</button>
    </div>
  </section>

  <!-- Matches list -->
  <section style="margin-top:14px;">
    <div id="matchesGrid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">

      <?php foreach ($matches as $m): ?>
        <article
          class="card match-card"
          style="padding:14px; border-radius:14px;"
          data-team="<?= htmlspecialchars(strtolower($m['team_a'].' '.$m['team_b'])) ?>"
          data-city="<?= htmlspecialchars(strtolower($m['city'])) ?>"
          data-date="<?= htmlspecialchars($m['date']) ?>"
          data-price="<?= (int)$m['price_from'] ?>"
        >
          <div style="display:flex; align-items:center; gap:10px;">
            <img src="<?= htmlspecialchars($m['logo_a']) ?>" alt="Logo A" style="width:42px; height:42px; object-fit:contain;">
            <div style="flex:1;">
              <h3 style="margin:0; font-size:18px;">
                <?= htmlspecialchars($m['team_a']) ?> vs <?= htmlspecialchars($m['team_b']) ?>
              </h3>
              <p style="margin:4px 0 0; opacity:.8;">
                <?= htmlspecialchars($m['city']) ?> • <?= htmlspecialchars($m['stadium']) ?>
              </p>
              <p style="margin:4px 0 0; opacity:.8;">
                <?= htmlspecialchars($m['date']) ?> • <?= htmlspecialchars($m['time']) ?>
              </p>
            </div>
          </div>

          <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
            <span class="badge" style="padding:6px 10px; border-radius:999px; background:#e2e8f0;">
              Dès <?= (int)$m['price_from'] ?> MAD
            </span>
            <a class="btn btn-primary" href="match_details.php?id=<?= (int)$m['id'] ?>">Voir détails</a>
          </div>
        </article>
      <?php endforeach; ?>

    </div>

    <p id="emptyState" style="display:none; margin-top:12px; opacity:.7;">
      Aucun match ne correspond à vos filtres.
    </p>
  </section>

</main>

<footer style="margin-top: 24px;">
  <p style="text-align:center; opacity:.7;">&copy; 2026 BuyMatch</p>
</footer>

<script>
  // Simple vanilla filter (front-only)
  const q = document.getElementById('q');
  const city = document.getElementById('city');
  const date = document.getElementById('date');
  const maxPrice = document.getElementById('maxPrice');
  const resetBtn = document.getElementById('resetFilters');
  const cards = Array.from(document.querySelectorAll('.match-card'));
  const emptyState = document.getElementById('emptyState');

  function applyFilters() {
    const qv = (q.value || '').trim().toLowerCase();
    const cv = (city.value || '').trim().toLowerCase();
    const dv = (date.value || '').trim(); // yyyy-mm-dd
    const pv = maxPrice.value ? Number(maxPrice.value) : null;

    let visibleCount = 0;

    cards.forEach(card => {
      const teamText = card.dataset.team || '';
      const cityText = card.dataset.city || '';
      const cardDate = card.dataset.date || '';
      const price = Number(card.dataset.price || 0);

      const okQ = !qv || teamText.includes(qv) || cityText.includes(qv);
      const okCity = !cv || cityText === cv;
      const okDate = !dv || cardDate === dv;
      const okPrice = pv === null || price <= pv;

      const show = okQ && okCity && okDate && okPrice;
      card.style.display = show ? '' : 'none';
      if (show) visibleCount++;
    });

    emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
  }

  [q, city, date, maxPrice].forEach(el => el.addEventListener('input', applyFilters));
  city.addEventListener('change', applyFilters);

  resetBtn.addEventListener('click', () => {
    q.value = '';
    city.value = '';
    date.value = '';
    maxPrice.value = '';
    applyFilters();
  });

  applyFilters();
</script>

<script src="../assets/js/main.js"></script>
</body>
</html>
