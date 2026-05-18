  <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- [FIX #7] Font Awesome: apenas solid + brands (~40% menor que all.min.css) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">

  {{-- [FIX #6] Fontes com preload para não bloquear renderização --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap"></noscript>

  {{-- [FIX #2] Tailwind CDN REMOVIDO — projeto usa CSS puro com variáveis --}}
  {{-- [FIX #1] @vite REMOVIDO — arquivo app.jsx não existe --}}

  <title>@yield('page-title', 'RestaurantePRO')</title>
  <style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --red:        #EC2D01;
    --red-dark:   #C42500;
    --red-soft:   rgba(236,45,1,.12);
    --brown:      #8B4513;
    --gold:       #FAB269;
    --gold-soft:  rgba(250,178,105,.12);
    --green:      #3E5F3C;
    --green-soft: rgba(62,95,60,.15);
    --dark:       #1C1C1C;
    --cream:      #F4E8D0;

    --bg:         #120D09;
    --bg2:        #1C1108;
    --bg3:        #241608;
    --border:     rgba(250,178,105,.13);
    --border-hv:  rgba(250,178,105,.3);
    --text:       #F4E8D0;
    --muted:      rgba(244,232,208,.42);
    --sidebar:    260px;
    --radius:     10px;
    --shadow:     0 8px 32px rgba(0,0,0,.55);

    --font-body:  'Cormorant Garamond', Georgia, serif;
    --font-title: 'Cinzel', serif;
  }

  html, body { height: 100%; }
  body {
    font-family: var(--font-body);
    background: var(--bg);
    color: var(--text);
    display: flex;
    min-height: 100vh;
    font-size: 17px;
    line-height: 1.65;
  }

  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: var(--bg); }
  ::-webkit-scrollbar-thumb { background: var(--brown); border-radius: 4px; }

  /* ===== SIDEBAR ===== */
  .sidebar {
    width: var(--sidebar);
    background: var(--bg2);
    border-right: 1px solid var(--border);
    position: fixed; top: 0; left: 0; height: 100vh;
    display: flex; flex-direction: column;
    z-index: 100; overflow-y: auto;
    transition: transform .3s cubic-bezier(.4,0,.2,1);
  }

  .sb-brand {
    padding: 22px 18px 18px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 14px; flex-shrink: 0;
  }
  .sb-logo {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--red), var(--brown));
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; box-shadow: 0 4px 14px rgba(236,45,1,.35);
  }
  .sb-brand-name {
    font-family: var(--font-title);
    font-size: 14px; font-weight: 700; letter-spacing: 1.8px;
    color: var(--cream); text-transform: uppercase;
  }
  .sb-brand-sub {
    font-family: var(--font-body);
    font-size: 13px; color: var(--gold); font-style: italic; letter-spacing: .3px;
  }

  .sb-user {
    margin: 12px 10px; padding: 12px 14px;
    background: var(--bg3); border: 1px solid var(--border);
    border-radius: var(--radius);
    display: flex; align-items: center; gap: 12px; flex-shrink: 0;
  }
  .sb-avatar {
    width: 38px; height: 38px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--red), var(--brown));
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-title); font-weight: 700; font-size: 17px; color: #fff;
    box-shadow: 0 3px 10px rgba(236,45,1,.25);
  }
  .sb-uname {
    font-family: var(--font-body); font-size: 16px;
    font-weight: 600; color: var(--cream);
  }
  .sb-urole {
    font-family: var(--font-title); font-size: 11px;
    color: var(--gold); font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase;
  }

  .sb-section {
    padding: 14px 16px 5px;
    font-family: var(--font-title); font-size: 11px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 2.2px;
  }

  .sidebar nav { flex: 1; padding: 6px 8px; }
  .sidebar nav a {
    display: flex; align-items: center; gap: 11px;
    padding: 11px 12px; color: var(--muted);
    text-decoration: none;
    font-family: var(--font-body); font-size: 16px; font-weight: 500;
    border-radius: 8px; transition: all .18s; margin-bottom: 2px;
  }
  .sidebar nav a:hover { background: rgba(250,178,105,.07); color: var(--cream); }
  .sidebar nav a.active {
    background: rgba(236,45,1,.12); color: var(--cream);
    border: 1px solid rgba(236,45,1,.22);
  }
  .nav-ic {
    width: 32px; height: 32px; border-radius: 7px;
    background: rgba(250,178,105,.06);
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
  }
  .sidebar nav a.active .nav-ic { background: rgba(236,45,1,.16); }

  .sb-footer { padding: 10px; border-top: 1px solid var(--border); flex-shrink: 0; }
  .btn-sair {
    width: 100%;
    background: rgba(236,45,1,.08); border: 1px solid rgba(236,45,1,.2); color: #fca5a5;
    padding: 11px; border-radius: 8px;
    font-family: var(--font-title); font-size: 12px; font-weight: 600;
    letter-spacing: 1.2px; text-transform: uppercase;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: .18s;
  }
  .btn-sair:hover { background: rgba(236,45,1,.18); color: #fff; }

  /* ===== TOPBAR ===== */
  .main {
    margin-left: var(--sidebar);
    width: calc(100% - var(--sidebar));
    display: flex; flex-direction: column; min-height: 100vh;
  }
  .topbar {
    background: rgba(18,13,9,.92);
    backdrop-filter: blur(12px);
    padding: 14px 28px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
    position: sticky; top: 0; z-index: 50;
  }
  .topbar h1 {
    font-family: var(--font-title);
    font-size: 16px; font-weight: 600; letter-spacing: 1.2px;
    color: var(--cream); text-transform: uppercase;
  }
  .topbar .bc {
    font-family: var(--font-body);
    font-size: 14px; color: var(--gold); margin-top: 2px; font-style: italic;
  }
  .topbar-actions { display: flex; align-items: center; gap: 10px; }

  .btn-hamburger {
    display: none; width: 38px; height: 38px; border-radius: 8px;
    border: 1px solid var(--border); background: var(--bg3);
    color: var(--text); cursor: pointer;
    align-items: center; justify-content: center; font-size: 18px; transition: all .18s;
  }
  .btn-hamburger:hover { border-color: var(--gold); color: var(--gold); }

  .btn-topbar-sair {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px; border-radius: 8px;
    background: rgba(236,45,1,.1); color: #fca5a5;
    font-family: var(--font-title); font-size: 12px; font-weight: 600;
    letter-spacing: 1.2px; text-transform: uppercase;
    cursor: pointer; border: 1px solid rgba(236,45,1,.22); transition: all .18s;
  }
  .btn-topbar-sair:hover { background: rgba(236,45,1,.22); color: #fff; }

  .sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.65); z-index: 99; backdrop-filter: blur(3px);
  }
  .sidebar-overlay.open { display: block; }

  .content { padding: 26px 28px; flex: 1; min-width: 0; overflow: visible; }

  /* ===== ALERTS ===== */
  .alert {
    padding: 14px 20px; border-radius: var(--radius); margin-bottom: 20px;
    display: flex; align-items: center; gap: 11px;
    font-family: var(--font-body); font-size: 16px; font-weight: 500;
    animation: fadeIn .3s ease;
  }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: none; } }
  .alert-success { background: var(--green-soft); color: #86efac; border: 1px solid rgba(62,95,60,.3); }
  .alert-error   { background: var(--red-soft);   color: #fca5a5; border: 1px solid rgba(236,45,1,.25); }
  .alert-warning { background: var(--gold-soft);  color: var(--gold); border: 1px solid rgba(250,178,105,.25); }
  .alert .cls {
    margin-left: auto; cursor: pointer; background: none;
    border: none; color: inherit; font-size: 20px; opacity: .5; line-height: 1;
  }

  /* ===== PANELS ===== */
  .panel {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 22px; margin-bottom: 22px;
  }
  .panel-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid var(--border);
  }
  .panel-title {
    font-family: var(--font-title); font-size: 14px; font-weight: 600;
    color: var(--cream); letter-spacing: 1.3px; text-transform: uppercase;
    display: flex; align-items: center; gap: 9px;
  }

  /* ===== STAT CARDS ===== */
  .cards-grid {
    display: grid; gap: 16px;
    grid-template-columns: repeat(auto-fit, minmax(195px, 1fr));
    margin-bottom: 24px;
  }
  .stat-card {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 20px;
    position: relative; overflow: hidden;
    transition: transform .18s, border-color .18s;
    text-decoration: none; display: block;
  }
  .stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: var(--cc, var(--red));
  }
  .stat-card:hover { transform: translateY(-3px); border-color: var(--border-hv); }
  .sc-head, .sc-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
  .sc-icon {
    width: 40px; height: 40px; border-radius: 9px;
    background: rgba(250,178,105,.08);
    display: flex; align-items: center; justify-content: center; font-size: 18px;
  }
  .sc-badge {
    font-family: var(--font-title); font-size: 11px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 1px;
    background: rgba(250,178,105,.06); padding: 3px 9px; border-radius: 20px;
  }
  .sc-val, .sc-value {
    font-family: var(--font-title); font-size: 30px; font-weight: 700;
    color: var(--cream); letter-spacing: -1px; line-height: 1.1; margin-bottom: 5px;
  }
  .sc-lbl, .sc-label {
    font-family: var(--font-body); font-size: 15px; color: var(--muted); font-style: italic;
  }

  /* ===== TABLES ===== */
  .table-wrap {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: var(--radius); overflow: hidden; margin-bottom: 22px;
    /* [FIX #10] scroll horizontal em mobile */
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  .table-header {
    padding: 16px 20px;
    display: flex; justify-content: space-between; align-items: center;
    border-bottom: 1px solid var(--border);
  }
  .table-header h2 {
    font-family: var(--font-title); font-size: 14px; font-weight: 600;
    color: var(--cream); letter-spacing: 1.2px; text-transform: uppercase;
  }
  table { width: 100%; border-collapse: collapse; min-width: 500px; }
  thead th {
    background: rgba(250,178,105,.04);
    padding: 12px 16px; text-align: left;
    font-family: var(--font-title); font-size: 11px; color: var(--muted);
    text-transform: uppercase; letter-spacing: 1.2px; font-weight: 600;
    border-bottom: 1px solid var(--border);
  }
  tbody td { padding: 14px 16px; border-bottom: 1px solid rgba(250,178,105,.06); font-size: 15px; }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: rgba(250,178,105,.03); }
  .td-primary { color: var(--cream); font-weight: 600; font-family: var(--font-body); }
  .td-mono { font-family: monospace; color: var(--gold); font-size: 15px; }

  /* ===== BADGES ===== */
  .badge {
    padding: 4px 12px; border-radius: 20px;
    font-family: var(--font-title); font-size: 11px; font-weight: 600;
    display: inline-block; letter-spacing: .8px; text-transform: uppercase;
  }
  .badge-success   { background: rgba(62,95,60,.18);   color: #86efac; border: 1px solid rgba(62,95,60,.32); }
  .badge-warning   { background: rgba(250,178,105,.13); color: var(--gold); border: 1px solid rgba(250,178,105,.28); }
  .badge-danger    { background: rgba(236,45,1,.12);    color: #fca5a5; border: 1px solid rgba(236,45,1,.24); }
  .badge-info      { background: rgba(139,69,19,.15);   color: #fdba74; border: 1px solid rgba(139,69,19,.28); }
  .badge-secondary { background: rgba(244,232,208,.06); color: var(--muted); border: 1px solid rgba(244,232,208,.1); }
  .badge-primary   { background: rgba(236,45,1,.12);    color: #fca5a5; border: 1px solid rgba(236,45,1,.24); }
  .badge-purple    { background: rgba(250,178,105,.12);  color: var(--gold); border: 1px solid rgba(250,178,105,.2); }

  /* ===== BUTTONS ===== */
  .btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px; border-radius: 8px;
    font-family: var(--font-title); font-size: 12px; font-weight: 600;
    letter-spacing: 1.3px; text-transform: uppercase;
    cursor: pointer; text-decoration: none; border: none;
    transition: all .18s; white-space: nowrap;
  }
  .btn-primary {
    background: var(--red); color: #fff;
    box-shadow: 0 4px 16px rgba(236,45,1,.3);
  }
  .btn-primary:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(236,45,1,.42); }
  .btn-primary:disabled { opacity: .5; cursor: not-allowed; transform: none !important; }
  .btn-secondary { background: var(--bg3); color: var(--cream); border: 1px solid var(--border); }
  .btn-secondary:hover { background: rgba(250,178,105,.08); border-color: var(--border-hv); }
  .btn-success { background: var(--green-soft); color: #86efac; border: 1px solid rgba(62,95,60,.3); }
  .btn-success:hover { background: rgba(62,95,60,.25); }
  .btn-danger { background: var(--red-soft); color: #fca5a5; border: 1px solid rgba(236,45,1,.25); }
  .btn-danger:hover { background: rgba(236,45,1,.22); }
  .btn-warning { background: var(--gold-soft); color: var(--gold); border: 1px solid rgba(250,178,105,.25); }
  .btn-warning:hover { background: rgba(250,178,105,.22); }
  .btn-sm { padding: 7px 15px; font-size: 11px; border-radius: 6px; }
  .btn-icon { width: 36px; height: 36px; padding: 0; justify-content: center; border-radius: 7px; }

  /* [FIX #12] Estado de loading em botões de submit */
  .btn[data-loading]:disabled {
    opacity: .7;
  }

  /* ===== FORMS ===== */
  .form-group { margin-bottom: 17px; }
  /* [FIX #15] Labels associados corretamente via CSS (for/id nas views) */
  .form-group label {
    display: block; margin-bottom: 6px;
    font-family: var(--font-title); font-size: 11px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 1.1px;
  }
  .form-control, .form-select {
    width: 100%; padding: 11px 14px;
    background: rgba(250,178,105,.05);
    border: 1px solid var(--border); border-radius: var(--radius);
    font-family: var(--font-body); font-size: 16px; color: var(--cream); transition: .18s;
  }
  .form-control::placeholder { color: var(--muted); }
  .form-control:focus, .form-select:focus {
    outline: none; border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(250,178,105,.1);
  }
  .form-select option { background: var(--bg2); color: var(--cream); }
  .form-row { display: grid; gap: 14px; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
  .invalid-feedback { color: #fca5a5; font-size: 14px; margin-top: 4px; }
  .is-invalid { border-color: var(--red) !important; }

  /* ===== MESAS ===== */
  .mesas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
  .mesa-card {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 20px 14px;
    text-align: center; cursor: pointer; transition: all .18s;
    position: relative; overflow: hidden;
    text-decoration: none; display: block;
  }
  .mesa-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; background: var(--mc, var(--muted));
  }
  .mesa-card:hover { transform: translateY(-2px); border-color: var(--border-hv); }
  .mesa-card.disponivel { --mc: var(--green); }
  .mesa-card.ocupada    { --mc: var(--red); }
  .mesa-card.reservada  { --mc: var(--gold); }
  .mc-num, .mc-number {
    font-family: var(--font-title); font-size: 34px; font-weight: 700;
    color: var(--cream); letter-spacing: -1px;
  }
  .mc-seats {
    font-family: var(--font-body); font-size: 14px;
    color: var(--muted); margin: 5px 0 10px; font-style: italic;
  }

  /* ===== KPI ===== */
  .kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; margin-bottom: 22px; }
  .kpi {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: 12px; padding: 18px; position: relative; overflow: hidden;
  }
  .kpi::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0;
    height: 3px; background: var(--kc, var(--red));
  }
  .kpi-val {
    font-family: var(--font-title); font-size: 28px; font-weight: 700;
    color: var(--cream); margin: 8px 0 5px; letter-spacing: -1px;
  }
  .kpi-lbl { font-family: var(--font-body); font-size: 15px; color: var(--muted); font-style: italic; }

  /* ===== [FIX #9] DASHBOARD GRID — responsivo ===== */
  .dashboard-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 24px;
  }

  /* ===== MISC ===== */
  .empty-state { text-align: center; padding: 52px 24px; color: var(--muted); }
  .empty-state .es-icon { font-size: 48px; display: block; margin-bottom: 14px; opacity: .25; }
  .empty-state p { font-family: var(--font-body); font-size: 17px; font-style: italic; }
  hr, .divider { border: none; border-top: 1px solid var(--border); margin: 18px 0; }
  .campo-erro { color: #fca5a5; font-size: 14px; margin-top: 5px; display: none; }

  /* [FIX #13] Modal de confirmação reutilizável */
  .modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 999;
    background: rgba(0,0,0,.7); backdrop-filter: blur(4px);
    align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }
  .modal-card {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 28px 28px 22px; max-width: 380px; width: 90%;
    box-shadow: var(--shadow);
  }
  .modal-card h3 {
    font-family: var(--font-title); font-size: 15px; font-weight: 700;
    color: var(--cream); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 12px;
  }
  .modal-card p { font-family: var(--font-body); font-size: 16px; color: var(--muted); margin-bottom: 20px; }
  .modal-actions { display: flex; gap: 10px; }

  /* ===== MOBILE ===== */
  @media (max-width: 768px) {
    :root { --sidebar: 270px; }
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; width: 100%; }
    .btn-hamburger { display: flex; }
    .content { padding: 18px 16px; }
    .topbar { padding: 12px 16px; }
    .cards-grid { grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 12px; }
    .form-row { grid-template-columns: 1fr; }
    .btn-topbar-sair span { display: none; }
    .btn-topbar-sair { padding: 8px 12px; }

    /* [FIX #9] Dashboard grid → 1 coluna em mobile */
    .dashboard-grid { grid-template-columns: 1fr; }

    /* [FIX #11] Layout de pedido → coluna única em mobile */
    .order-layout { flex-direction: column !important; }
    .resumo-col { width: 100% !important; min-width: 0 !important; position: static !important; }

    /* Inline grids com colunas fixas → forçar 1 coluna */
    [style*="grid-template-columns:360px"] { display: block !important; }
    [style*="grid-template-columns:340px"] { display: block !important; }
    [style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
    [style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
  }
  @media (max-width: 480px) {
    .cards-grid { grid-template-columns: 1fr 1fr; }
    .mesas-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
    .table-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .topbar h1 { font-size: 15px; }
  }
  </style>
  @yield('styles')
  </head>
  <body>
    {{-- [FIX #13] Modal de confirmação reutilizável --}}
    <div class="modal-overlay" id="modal-confirm" role="dialog" aria-modal="true" aria-labelledby="modal-title">
      <div class="modal-card">
        <h3 id="modal-title">⚠️ Confirmar Ação</h3>
        <p id="modal-msg">Confirmar esta ação?</p>
        <div class="modal-actions">
          <button id="modal-ok" class="btn btn-danger" onclick="confirmarModal()">Confirmar</button>
          <button class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
        </div>
      </div>
    </div>

  <div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

  <aside class="sidebar" id="sidebar">
    <div class="sb-brand">
      <div class="sb-logo">🍳</div>
      <div>
        <div class="sb-brand-name">RestaurantePRO</div>
        <div class="sb-brand-sub">Sistema de Gestão</div>
      </div>
    </div>

    <div class="sb-user">
      <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
      <div>
        <div class="sb-uname">{{ Auth::user()->name }}</div>
        <div class="sb-urole">
          @php $rl=['gerente'=>'Gerente','garcom'=>'Garçom','chef'=>'Chef','caixa'=>'Caixa'] @endphp
          {{ $rl[Auth::user()->role] ?? Auth::user()->role }}
        </div>
      </div>
    </div>

    <nav id="sidebar-nav">
      <div class="sb-section">Principal</div>
      <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="nav-ic">🏠</div> Início
      </a>
      <a href="{{ route('dashboard.pedidos') }}" class="{{ request()->routeIs('dashboard.pedidos','orders.show') ? 'active' : '' }}">
        <div class="nav-ic">🧾</div> Pedidos
      </a>

      @if(in_array(Auth::user()->role,['gerente','garcom']))
      <div class="sb-section">Salão</div>
      <a href="{{ route('mesas.index') }}" class="{{ request()->routeIs('mesas.*') ? 'active' : '' }}">
        <div class="nav-ic">🪑</div> Mesas
      </a>
      @endif

      @if(Auth::user()->role === 'garcom')
      <a href="{{ route('orders.create') }}" class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
        <div class="nav-ic">➕</div> Novo Pedido
      </a>
      @endif

      @if(Auth::user()->role === 'chef')
      <div class="sb-section">Cozinha</div>
      <a href="{{ route('chef.preparo') }}" class="{{ request()->routeIs('chef.preparo') ? 'active' : '' }}">
        <div class="nav-ic">🔥</div> Preparo
      </a>
      <a href="{{ route('chef.estoque') }}" class="{{ request()->routeIs('chef.estoque') ? 'active' : '' }}">
        <div class="nav-ic">📦</div> Estoque
      </a>
      @endif

      @if(in_array(Auth::user()->role,['caixa','gerente']))
      <div class="sb-section">Financeiro</div>
      <a href="{{ route('caixa.pagar-mesa') }}" class="{{ request()->routeIs('caixa.*') ? 'active' : '' }}">
        <div class="nav-ic">💰</div> Caixa
      </a>
      <a href="{{ route('caixa.diaria') }}" class="{{ request()->routeIs('caixa.diaria') ? 'active' : '' }}">
        <div class="nav-ic">📋</div> Diária
      </a>
      @endif

      @if(Auth::user()->role === 'gerente')
      <div class="sb-section">Cadastros</div>
      <a href="{{ route('gerenciar.mesas') }}"        class="{{ request()->routeIs('gerenciar.mesas') ? 'active' : '' }}">
        <div class="nav-ic">🪑</div> Mesas
      </a>
      <a href="{{ route('gerenciar.cardapio') }}"     class="{{ request()->routeIs('gerenciar.cardapio*') ? 'active' : '' }}">
        <div class="nav-ic">🍽️</div> Cardápio
      </a>
      <a href="{{ route('gerenciar.funcionarios') }}" class="{{ request()->routeIs('gerenciar.funcionarios') ? 'active' : '' }}">
        <div class="nav-ic">👥</div> Funcionários
      </a>
      <a href="{{ route('gerenciar.produtos') }}"     class="{{ request()->routeIs('gerenciar.produtos*') ? 'active' : '' }}">
        <div class="nav-ic">📦</div> Produtos
      </a>

      <div class="sb-section">Relatórios</div>
      <a href="{{ route('gestao.relatorios') }}"      class="{{ request()->routeIs('gestao.relatorios') ? 'active' : '' }}">
        <div class="nav-ic">📊</div> Gestão
      </a>
      <a href="{{ route('dashboard.relatorios') }}"   class="{{ request()->routeIs('dashboard.relatorios') ? 'active' : '' }}">
        <div class="nav-ic">📄</div> Período
      </a>
      <a href="{{ route('dashboard.vendas') }}"       class="{{ request()->routeIs('dashboard.vendas') ? 'active' : '' }}">
        <div class="nav-ic">📈</div> Vendas
      </a>

      <div class="sb-section">Estoque</div>
      <a href="{{ route('controle.estoque') }}"       class="{{ request()->routeIs('controle.estoque*') ? 'active' : '' }}">
        <div class="nav-ic">🔄</div> Controle
      </a>
      <a href="{{ route('dashboard.estoque') }}"      class="{{ request()->routeIs('dashboard.estoque') ? 'active' : '' }}">
        <div class="nav-ic">📦</div> Inventário
      </a>
      <a href="{{ route('compras.index') }}"          class="{{ request()->routeIs('compras.*') ? 'active' : '' }}">
        <div class="nav-ic">🛒</div> Compras
      </a>
      @endif
    </nav>

    <div class="sb-footer">
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button type="submit" class="btn-sair">🚪 Sair do Sistema</button>
      </form>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div style="display:flex;align-items:center;gap:14px">
        <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()" aria-label="Abrir menu">☰</button>
        <div>
          <h1>@yield('page-title','Dashboard')</h1>
          <div class="bc">@yield('breadcrumb','Sistema de Gestão')</div>
        </div>
      </div>
      <div class="topbar-actions">
        <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf
          <button type="submit" class="btn-topbar-sair">🚪 <span>Sair</span></button>
        </form>
      </div>
    </div>

    <div class="content">
      {{-- [FIX #14] Flash com auto-dismiss via CSS animation + JS --}}
      @if(session('success'))
      <div class="alert alert-success" id="flash-success" role="alert">
        ✅ <span>{{ session('success') }}</span>
        <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">×</button>
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-error" id="flash-error" role="alert">
        ❌ <span>{{ session('error') }}</span>
        <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">×</button>
      </div>
      @endif
      @if(session('warning'))
      <div class="alert alert-warning" id="flash-warning" role="alert">
        ⚠️ <span>{{ session('warning') }}</span>
        <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">×</button>
      </div>
      @endif
      @if($errors->any())
      <div class="alert alert-error" role="alert">
        ❌ <span>{{ $errors->first() }}</span>
        <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">×</button>
      </div>
      @endif

      @yield('content')
    </div>
  </div>

  <script>
  /* ===== SIDEBAR ===== */
  function toggleSidebar(){
    const sb = document.getElementById('sidebar');
    const ov = document.getElementById('sidebar-overlay');
    sb.classList.toggle('open');
    ov.classList.toggle('open');
    document.body.style.overflow = sb.classList.contains('open') ? 'hidden' : '';
  }

  document.querySelectorAll('#sidebar-nav a').forEach(function(a){
    a.addEventListener('click', function(){
      if(window.innerWidth <= 768){
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  });

  (function(){
    const nav = document.getElementById('sidebar');
    if(!nav) return;
    const saved = sessionStorage.getItem('sb-scroll');
    if(saved) nav.scrollTop = parseInt(saved);
    nav.addEventListener('scroll', function(){ sessionStorage.setItem('sb-scroll', nav.scrollTop); });
  })();

  /* ===== Auto-dismiss flash após 5s ===== */
  setTimeout(function(){
    document.querySelectorAll('.alert').forEach(function(el){
      el.style.transition='opacity .5s'; el.style.opacity='0';
      setTimeout(function(){el.remove();},500);
    });
  },5000);

  /* ===== Modal de confirmação reutilizável ===== */
  var _modalCallback = null;

  function confirmar(msg, callback, titulo) {
    document.getElementById('modal-msg').textContent = msg;
    if (titulo) document.getElementById('modal-title').textContent = titulo;
    _modalCallback = callback;
    document.getElementById('modal-confirm').classList.add('open');
  }

  function confirmarModal() {
    fecharModal();
    if (typeof _modalCallback === 'function') _modalCallback();
  }

  function fecharModal() {
    document.getElementById('modal-confirm').classList.remove('open');
    _modalCallback = null;
  }

  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') fecharModal();
  });

  /* ===== Loading em botões submit ===== */
  document.querySelectorAll('form').forEach(function(form) {
    let submitted = false;
    form.addEventListener('submit', function(e) {
      if (submitted) {
        e.preventDefault();
        return false;
      }
      submitted = true;
      var btn = form.querySelector('button[type="submit"]');
      if (btn && !btn.dataset.noLoading) {
        setTimeout(function() {
          btn.disabled = true;
          var original = btn.innerHTML;
          btn.dataset.originalHtml = original;
          btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Salvando...';
        }, 10);
      }
      setTimeout(() => { submitted = false; }, 5000);
    });
  });

  /* ===== MELHORADO: Proteção contra sessão expirada (419 e 401) ===== */
  window.addEventListener('pageshow', function(e) {
      if (e.persisted) {
          fetch('/dashboard', { method: 'HEAD', credentials: 'same-origin', cache: 'no-store' })
              .then(r => {
                  if (r.status === 401 || r.url.includes('/login')) {
                      window.location.href = '/login';
                  }
                  if (r.status === 419) {
                      alert('⏱️ Sessão expirada. A página será recarregada.');
                      window.location.reload();
                  }
              })
              .catch(() => {
                  // Sem internet — silencioso
                  console.log('Sem conexão com o servidor');
              });
      }
  });

  // Força reload se página vier do cache (resolve 419 no mobile)
  window.addEventListener('pageshow', function(e) {
      if (e.persisted) {
          window.location.reload();
      }
  });

  // Captura CSRF token para requisições AJAX futuras
  document.addEventListener('DOMContentLoaded', function () {
      const meta = document.querySelector('meta[name="csrf-token"]');
      if (meta) {
          window._csrfToken = meta.getAttribute('content');
      }
  });

  // Recarregar token CSRF a cada 15 minutos
  setInterval(function() {
      fetch('/csrf-token')
          .then(response => response.json())
          .then(data => {
              document.querySelectorAll('input[name="_token"]').forEach(input => {
                  input.value = data.token;
              });
              const metaToken = document.querySelector('meta[name="csrf-token"]');
              if (metaToken) metaToken.setAttribute('content', data.token);
              window._csrfToken = data.token;
          })
          .catch(() => console.log('Token refresh falhou'));
  }, 15 * 60 * 1000);

  // Intercepta respostas 419 em requisições fetch
  const originalFetch = window.fetch;
  window.fetch = function() {
      return originalFetch.apply(this, arguments)
          .then(response => {
              if (response.status === 419) {
                  alert('⏱️ Sessão expirada. A página será recarregada.');
                  window.location.reload();
              }
              return response;
          });
  };
  </script>
  @yield('scripts')
  </body>
  </html>