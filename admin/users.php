<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/MatchRepository.php";

// Ensure only admin can access

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../pages/login.php");
    exit();
}

$matchRepository = new MatchRepository();
$users = $matchRepository->getAllUsers();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>BuyMatch — Admin | Utilisateurs</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">🛡️ BuyMatch Admin</div>
    <ul class="nav-links">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="users.php" class="btn btn-secondary">Utilisateurs</a></li>
      <!-- <li><a href="matches_requests.php">Demandes matchs</a></li> -->
      <li><a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<main class="container" style="margin-top:18px;">

  <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
    <h2 style="margin:0;">👥 Gestion des utilisateurs</h2>

    <!-- quick actions (front only) -->
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <button class="btn btn-secondary" type="button" id="selectAllBtn">Tout sélectionner</button>
      <button class="btn btn-danger" type="button" id="disableSelectedBtn">Désactiver sélection</button>
      <button class="btn btn-primary" type="button" id="enableSelectedBtn">Activer sélection</button>
    </div>
  </div>

  <!-- Filters -->
  <section class="card" style="margin-top:14px; padding:14px; border-radius:14px;">
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
      <div class="form-group">
        <label for="q">Recherche</label>
        <input id="q" class="form-control" type="text" placeholder="Nom, email...">
      </div>

      <div class="form-group">
        <label for="role">Rôle</label>
        <select id="role" class="form-control">
          <option value="all">Tous</option>
          <option value="acheteur">Acheteur</option>
          <option value="organisateur">Organisateur</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div class="form-group">
        <label for="state">État</label>
        <select id="state" class="form-control">
          <option value="all">Tous</option>
          <option value="actif">Actif</option>
          <option value="desactive">Désactivé</option>
        </select>
      </div>
    </div>
  </section>

  <!-- Users table -->
  <section class="card" style="margin-top:14px; padding:14px; border-radius:14px;">
    <div style="overflow:auto;">
      <table style="width:100%; border-collapse:collapse; min-width:900px;">
        <thead>
          <tr style="text-align:left; border-bottom:1px solid #e2e8f0;">
            <th style="padding:10px; width:42px;">#</th>
            <th style="padding:10px;">Utilisateur</th>
            <th style="padding:10px;">Email</th>
            <th style="padding:10px;">Rôle</th>
            <th style="padding:10px;">État</th>
            <th style="padding:10px;">Action</th>
          </tr>
        </thead>
        <tbody id="usersBody">
            <?php foreach ($users as $user): ?>
              <tr class="user-row"
                  data-role="<?= htmlspecialchars($user['role'], ENT_QUOTES) ?>"
                  data-state="<?= htmlspecialchars($user['statut'], ENT_QUOTES) ?>"
                  data-text="<?= htmlspecialchars(strtolower($user['nom'].' '.$user['email'].' '.$user['role']), ENT_QUOTES) ?>"
                  data-id="<?= (int)$user['id'] ?>"
                  data-nom="<?= htmlspecialchars($user['nom'], ENT_QUOTES) ?>"
                  data-email="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>"
                  data-statut="<?= htmlspecialchars($user['statut'], ENT_QUOTES) ?>"
              >
                <td style="padding:10px;">
                  <input type="checkbox" class="rowCheck">
                </td>
            
                <td style="padding:10px;"><b>#<?= (int)$user['id'] ?></b> <?= htmlspecialchars($user['nom']) ?></td>
                <td style="padding:10px;"><?= htmlspecialchars($user['email']) ?></td>
                <td style="padding:10px;"><?= htmlspecialchars($user['role']) ?></td>
            
                <td style="padding:10px;">
                  <span class="stateBadge" style="padding:6px 10px; border-radius:999px; background:#d1fae5;">
                    <?= htmlspecialchars($user['statut']) ?>
                  </span>
                </td>
            
                <td style="padding:10px; display:flex; gap:8px; flex-wrap:wrap;">
                  <button type="button" class="btn btn-secondary btn-view">Voir</button>
            
                  <?php if ($user['role'] === 'admin'): ?>
                    <button type="button" class="btn btn-danger" disabled>Désactiver</button>
                  <?php else: ?>
                    <!-- Use <a> as button (correct HTML) -->
                    <a class="btn btn-danger" href="update.php?id=<?= (int)$user['id'] ?>">
                      Désactiver
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>

      </table>
    </div>

    <p id="emptyState" style="display:none; margin:12px 0 0; opacity:.7;">
      Aucun utilisateur ne correspond aux filtres.
    </p>
  </section>

</main>

<!-- Simple modal (front only) -->
<div id="modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); padding:18px;">
  <div class="card" style="max-width:520px; margin:60px auto; padding:14px; border-radius:14px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px;">
      <h3 style="margin:0;">Détails utilisateur</h3>
      <button id="modalClose" class="btn btn-secondary" type="button">Fermer</button>
    </div>
    <p id="modalBody" style="margin:12px 0 0; opacity:.85;">
    </p>
  </div>
</div>

<footer style="margin-top:24px;">
  <p style="text-align:center; opacity:.7;">&copy; 2026 BuyMatch</p>
</footer>

<script>
  // --- Filters
 // ====== Filters
const q = document.getElementById('q');
const role = document.getElementById('role');
const state = document.getElementById('state');
const emptyState = document.getElementById('emptyState');

function getRows() {
  // if your page updates dynamically later, this always gets latest rows
  return Array.from(document.querySelectorAll('.user-row'));
}

function applyFilters() {
  const qv = (q.value || '').trim().toLowerCase();
  const rv = role.value;
  const sv = state.value;

  let visible = 0;
  getRows().forEach(row => {
    const text = (row.dataset.text || '').toLowerCase();
    const okQ = !qv || text.includes(qv);
    const okRole = (rv === 'all') || (row.dataset.role === rv);
    const okState = (sv === 'all') || (row.dataset.state === sv);

    const show = okQ && okRole && okState;
    row.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  emptyState.style.display = visible === 0 ? 'block' : 'none';
}

[q, role, state].forEach(el => el.addEventListener('input', applyFilters));
role.addEventListener('change', applyFilters);
state.addEventListener('change', applyFilters);
applyFilters();


// ====== Modal (with data-attributes + escape)
const modal = document.getElementById('modal');
const modalClose = document.getElementById('modalClose');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');

modalClose.addEventListener('click', () => modal.style.display = 'none');
modal.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });

function escapeHtml(str) {
  return String(str)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

// Event delegation = works even if rows are generated by PHP
document.addEventListener('click', (e) => {
  const viewBtn = e.target.closest('.btn-view');
  if (!viewBtn) return;

  const nom = viewBtn.dataset.nom || '';
  const email = viewBtn.dataset.email || '';
  const r = viewBtn.dataset.role || '';
  const statut = viewBtn.dataset.statut || '';

  modalTitle.textContent = "Détails utilisateur";
  modalBody.innerHTML = `
    <div style="display:grid; gap:8px;">
      <div><b>Nom:</b> ${escapeHtml(nom)}</div>
      <div><b>Email:</b> ${escapeHtml(email)}</div>
      <div><b>Rôle:</b> ${escapeHtml(r)}</div>
      <div><b>Statut:</b> ${escapeHtml(statut)}</div>
    </div>
  `;

  modal.style.display = 'block';
});


// ====== Toggle (front only)
function setRowState(row, newState) {
  row.dataset.state = newState;

  const badge = row.querySelector('.stateBadge');
  const toggleBtn = row.querySelector('.btn-toggle');

  if (!badge || !toggleBtn) return;

  if (newState === 'actif') {
    badge.textContent = 'actif';
    badge.style.background = '#d1fae5';
    toggleBtn.textContent = 'Désactiver';
    toggleBtn.classList.remove('btn-primary');
    toggleBtn.classList.add('btn-danger');
  } else {
    badge.textContent = 'desactive';
    badge.style.background = '#fee2e2';
    toggleBtn.textContent = 'Activer';
    toggleBtn.classList.remove('btn-danger');
    toggleBtn.classList.add('btn-primary');
  }

  // Update filters result immediately
  applyFilters();
}

// Handle toggle click (front only)
document.addEventListener('click', (e) => {
  const btn = e.target.closest('.btn-toggle');
  if (!btn || btn.disabled) return;

  const row = btn.closest('.user-row');
  if (!row) return;

  const current = row.dataset.state;
  const next = current === 'actif' ? 'desactive' : 'actif';
  setRowState(row, next);

  // Later (real DB): redirect or fetch
  // window.location.href = `update.php?id=${row.dataset.id}&to=${next}`;
});


// ====== Bulk actions (front only)
const selectAllBtn = document.getElementById('selectAllBtn');
const disableSelectedBtn = document.getElementById('disableSelectedBtn');
const enableSelectedBtn = document.getElementById('enableSelectedBtn');

function getSelectedRows() {
  return getRows().filter(r => {
    const cb = r.querySelector('.rowCheck');
    return cb && cb.checked && !cb.disabled && r.style.display !== 'none';
  });
}

selectAllBtn?.addEventListener('click', () => {
  getRows().forEach(r => {
    const cb = r.querySelector('.rowCheck');
    if (cb && !cb.disabled && r.style.display !== 'none') cb.checked = true;
  });
});

disableSelectedBtn?.addEventListener('click', () => {
  getSelectedRows().forEach(r => setRowState(r, 'desactive'));
});

enableSelectedBtn?.addEventListener('click', () => {
  getSelectedRows().forEach(r => setRowState(r, 'actif'));
});


  
</script>

<script src="../assets/js/main.js"></script>
</body>
</html>