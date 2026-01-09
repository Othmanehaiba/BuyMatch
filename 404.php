<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>404 — Page introuvable | BuyMatch</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg1:#0b1020;
      --bg2:#0a1b2f;
      --card:rgba(255,255,255,.06);
      --stroke:rgba(255,255,255,.12);
      --text:#eef2ff;
      --muted:rgba(238,242,255,.72);
      --primary:#22c55e;
      --primary2:#60a5fa;
      --danger:#ef4444;
      --shadow: 0 30px 80px rgba(0,0,0,.45);
      --radius: 22px;
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      font-family:"Plus Jakarta Sans",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
      color:var(--text);
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      background:
        radial-gradient(900px 500px at 15% 20%, rgba(96,165,250,.18), transparent 60%),
        radial-gradient(800px 550px at 85% 65%, rgba(34,197,94,.18), transparent 60%),
        linear-gradient(160deg, var(--bg1), var(--bg2));
      overflow:hidden;
      padding:18px;
    }

    /* background soccer particles */
    .bg-balls span{
      position:absolute;
      width:14px;height:14px;
      border-radius:50%;
      background:rgba(255,255,255,.08);
      border:1px solid rgba(255,255,255,.10);
      filter: blur(.2px);
      animation: float 10s ease-in-out infinite;
    }
    .bg-balls span:nth-child(1){left:8%; top:18%; width:10px; height:10px; animation-duration: 9s}
    .bg-balls span:nth-child(2){left:15%; top:72%; width:16px; height:16px; animation-duration: 12s}
    .bg-balls span:nth-child(3){left:48%; top:10%; width:12px; height:12px; animation-duration: 11s}
    .bg-balls span:nth-child(4){left:68%; top:80%; width:18px; height:18px; animation-duration: 13s}
    .bg-balls span:nth-child(5){left:84%; top:25%; width:11px; height:11px; animation-duration: 10s}
    .bg-balls span:nth-child(6){left:92%; top:60%; width:14px; height:14px; animation-duration: 14s}

    @keyframes float{
      0%,100%{ transform: translateY(0px) }
      50%{ transform: translateY(-16px) }
    }

    .wrap{
      width:min(1000px, 100%);
      display:grid;
      grid-template-columns: 1.1fr .9fr;
      gap:18px;
      align-items:stretch;
    }

    .card{
      background: var(--card);
      border:1px solid var(--stroke);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
      overflow:hidden;
      position:relative;
    }

    .left{
      padding:26px 26px 20px;
    }

    .brand{
      display:flex;
      align-items:center;
      gap:10px;
      opacity:.95;
      margin-bottom:16px;
    }
    .brand .logo{
      width:44px;height:44px;
      border-radius:14px;
      display:grid;
      place-items:center;
      background:rgba(255,255,255,.08);
      border:1px solid rgba(255,255,255,.12);
    }
    .brand b{ font-size:15px; letter-spacing:.3px; }
    .brand span{ color:var(--muted); font-size:13px; display:block; margin-top:2px; }

    .code{
      font-size:64px;
      line-height:1;
      font-weight:800;
      letter-spacing:-2px;
      margin: 8px 0 10px;
      background: linear-gradient(90deg, #fff, rgba(255,255,255,.45));
      -webkit-background-clip:text;
      background-clip:text;
      color:transparent;
    }
    h1{
      margin:0 0 8px;
      font-size:24px;
      letter-spacing:-.2px;
    }
    p{
      margin:0;
      color:var(--muted);
      line-height:1.55;
      font-size:15px;
      max-width: 55ch;
    }

    .actions{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top:18px;
    }
    .btn{
      border:1px solid rgba(255,255,255,.12);
      background: rgba(255,255,255,.08);
      color: var(--text);
      padding:10px 14px;
      border-radius: 14px;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      gap:10px;
      font-weight:700;
      font-size:14px;
      transition: transform .12s ease, background .12s ease, border-color .12s ease;
      cursor:pointer;
      user-select:none;
    }
    .btn:hover{ transform: translateY(-1px); background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.18); }
    .btn.primary{
      background: linear-gradient(90deg, rgba(34,197,94,.95), rgba(96,165,250,.85));
      border-color: transparent;
      color:#081018;
    }
    .btn.primary:hover{ transform: translateY(-1px) scale(1.01); }

    .hint{
      margin-top:16px;
      display:flex;
      align-items:center;
      gap:10px;
      padding:12px 14px;
      border-radius: 16px;
      background: rgba(255,255,255,.06);
      border:1px dashed rgba(255,255,255,.18);
      color:var(--muted);
      font-size:13px;
    }
    .kbd{
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
      font-size:12px;
      padding:5px 9px;
      border-radius:10px;
      color:rgba(255,255,255,.85);
      background: rgba(0,0,0,.25);
      border:1px solid rgba(255,255,255,.12);
    }

    .right{
      display:grid;
      place-items:center;
      padding:16px;
    }

    /* Soccer illustration */
    .pitch{
      width:100%;
      height:100%;
      min-height: 320px;
      border-radius: var(--radius);
      border:1px solid rgba(255,255,255,.12);
      background:
        linear-gradient(180deg, rgba(34,197,94,.12), rgba(34,197,94,.06)),
        repeating-linear-gradient(90deg, rgba(255,255,255,.08) 0 1px, transparent 1px 28px);
      position:relative;
      overflow:hidden;
    }
    .line{
      position:absolute; inset:18px;
      border:2px solid rgba(255,255,255,.18);
      border-radius: 18px;
    }
    .mid{
      position:absolute; left:50%; top:18px; bottom:18px;
      width:2px; transform: translateX(-1px);
      background: rgba(255,255,255,.18);
    }
    .circle{
      position:absolute; left:50%; top:50%;
      width:140px; height:140px;
      transform: translate(-50%,-50%);
      border:2px solid rgba(255,255,255,.18);
      border-radius: 999px;
    }
    .ball{
      position:absolute;
      left:50%; top:50%;
      width:54px; height:54px;
      transform: translate(-50%,-50%);
      border-radius: 999px;
      background:
        radial-gradient(circle at 35% 30%, rgba(255,255,255,.95), rgba(255,255,255,.45)),
        radial-gradient(circle at 60% 70%, rgba(0,0,0,.25), transparent 45%);
      border:1px solid rgba(255,255,255,.22);
      box-shadow: 0 18px 40px rgba(0,0,0,.35);
      animation: bounce 2.2s ease-in-out infinite;
    }
    .ball::after{
      content:"";
      position:absolute; inset:10px;
      border-radius: 999px;
      border:2px dashed rgba(0,0,0,.25);
      opacity:.65;
    }
    @keyframes bounce{
      0%,100%{ transform: translate(-50%,-50%) translateY(0) }
      50%{ transform: translate(-50%,-50%) translateY(-18px) }
    }

    .tag{
      position:absolute;
      right:14px; top:14px;
      padding:8px 10px;
      border-radius: 999px;
      font-size:12px;
      color:rgba(255,255,255,.9);
      background: rgba(0,0,0,.22);
      border:1px solid rgba(255,255,255,.12);
    }

    .search{
      margin-top:14px;
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      align-items:center;
    }
    .input{
      flex:1;
      min-width: 220px;
      padding:11px 12px;
      border-radius: 14px;
      border:1px solid rgba(255,255,255,.14);
      background: rgba(255,255,255,.06);
      color: var(--text);
      outline:none;
    }
    .input::placeholder{ color: rgba(238,242,255,.5); }

    .mini{
      margin-top:10px;
      font-size:12px;
      color:rgba(238,242,255,.55);
    }

    @media (max-width: 860px){
      .wrap{ grid-template-columns: 1fr; }
      .code{ font-size: 56px; }
      .pitch{ min-height: 280px; }
    }
  </style>
</head>
<body>

  <div class="bg-balls" aria-hidden="true">
    <span></span><span></span><span></span><span></span><span></span><span></span>
  </div>

  <section class="wrap">
    <!-- Left -->
    <div class="card left">
      <div class="brand">
        <div class="logo">⚽</div>
        <div>
          <b>BuyMatch</b>
          <span>Oops… page introuvable</span>
        </div>
      </div>

      <div class="code">404</div>
      <h1>Cette page a été sortie du terrain.</h1>
      <p>
        Le lien que vous avez suivi est incorrect, la page a été supprimée,
        ou vous n’avez pas l’autorisation d’y accéder.
      </p>

      <div class="search">
        <input class="input" id="quickSearch" type="text" placeholder="Rechercher un match, une ville, un stade..." />
        <a class="btn primary" href="/BuyMatch/public/index.php">🏠 Retour à l’accueil</a>
        <button class="btn" type="button" id="goBackBtn">↩️ Page précédente</button>
      </div>

      <div class="actions">
        <a class="btn" href="/BuyMatch/public/pages/matches.php">📅 Voir les matchs</a>
        <a class="btn" href="/BuyMatch/public/auth/login.php">🔐 Se connecter</a>
        <a class="btn" href="/BuyMatch/public/auth/signup.php">✨ Créer un compte</a>
      </div>

      <div class="hint">
        <span class="kbd">Astuce</span>
        <span>Appuyez sur <span class="kbd">Alt</span> + <span class="kbd">←</span> pour revenir en arrière.</span>
      </div>

      <div class="mini" id="urlInfo"></div>
    </div>

    <!-- Right -->
    <div class="card right">
      <div class="pitch">
        <div class="tag">Erreur 404</div>
        <div class="line"></div>
        <div class="mid"></div>
        <div class="circle"></div>
        <div class="ball" title="But… raté 😅"></div>
      </div>
    </div>
  </section>

  <script>
    // show current path (useful for debug)
    document.getElementById('urlInfo').textContent =
      "URL demandée : " + window.location.pathname;

    // go back button
    document.getElementById('goBackBtn').addEventListener('click', () => history.back());

    // "fake search" (front only)
    document.getElementById('quickSearch').addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        const q = e.target.value.trim();
        if (!q) return;
        // Change this to your real search page later
        window.location.href = "/BuyMatch/public/pages/matches.php?q=" + encodeURIComponent(q);
      }
    });
  </script>
</body>
</html>
