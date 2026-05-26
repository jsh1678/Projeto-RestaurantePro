<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap"></noscript>

<title>@yield('page-title', 'RestaurantePRO')</title>
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
  /* Cores base — INALTERADAS */
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

  /* Tokens de design melhorados */
  --sidebar:    268px;
  --radius:     12px;
  --radius-sm:  8px;
  --radius-lg:  16px;
  --shadow:     0 8px 32px rgba(0,0,0,.55);
  --shadow-lg:  0 24px 60px rgba(0,0,0,.7);
  --transition: all .2s cubic-bezier(.4,0,.2,1);
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
  background-image:
    radial-gradient(ellipse 70% 50% at 0% 0%, rgba(139,69,19,.07) 0%, transparent 60%),
    radial-gradient(ellipse 50% 40% at 100% 100%, rgba(236,45,1,.05) 0%, transparent 55%);
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: rgba(139,69,19,.5); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: var(--brown); }

/* ===== SIDEBAR ===== */
.sidebar {
  width: var(--sidebar);
  background: linear-gradient(180deg, #1A0F06 0%, #160C05 100%);
  border-right: 1px solid var(--border);
  position: fixed; top: 0; left: 0; height: 100vh;
  display: flex; flex-direction: column;
  z-index: 100; overflow-y: auto;
  transition: transform .3s cubic-bezier(.4,0,.2,1);
  box-shadow: 4px 0 28px rgba(0,0,0,.45);
}
/* Linha decorativa no topo da sidebar */
.sidebar::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, transparent 0%, var(--red) 30%, var(--gold) 50%, var(--red) 70%, transparent 100%);
  opacity: .55;
}

.sb-brand {
  padding: 24px 18px 20px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; gap: 14px; flex-shrink: 0;
}
.sb-logo {
  width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--red) 0%, var(--brown) 100%);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px;
  box-shadow: 0 4px 18px rgba(236,45,1,.4), inset 0 1px 0 rgba(255,255,255,.1);
  transition: var(--transition);
}
.sb-logo:hover { transform: scale(1.06); box-shadow: 0 6px 24px rgba(236,45,1,.6); }
.sb-brand-name {
  font-family: var(--font-title);
  font-size: 13.5px; font-weight: 700; letter-spacing: 2px;
  color: var(--cream); text-transform: uppercase; line-height: 1.2;
}
.sb-brand-sub {
  font-family: var(--font-body);
  font-size: 13px; color: var(--gold); font-style: italic; opacity: .8;
}

.sb-user {
  margin: 14px 10px 6px; padding: 13px 14px;
  background: rgba(250,178,105,.04);
  border: 1px solid rgba(250,178,105,.1);
  border-radius: var(--radius);
  display: flex; align-items: center; gap: 12px; flex-shrink: 0;
  position: relative; overflow: hidden;
  transition: var(--transition);
}
.sb-user::before {
  content: '';
  position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
  background: linear-gradient(180deg, var(--red), var(--gold));
  border-radius: 0 2px 2px 0;
}
.sb-user:hover { background: rgba(250,178,105,.07); border-color: rgba(250,178,105,.18); }
.sb-avatar {
  width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--red), var(--brown));
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-title); font-weight: 700; font-size: 17px; color: #fff;
  box-shadow: 0 3px 10px rgba(236,45,1,.3);
}
.sb-uname {
  font-family: var(--font-body); font-size: 15.5px;
  font-weight: 600; color: var(--cream); line-height: 1.2;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-urole {
  font-family: var(--font-title); font-size: 10px;
  color: var(--gold); font-weight: 600; letter-spacing: 1.4px;
  text-transform: uppercase; opacity: .85;
}

/* Separadores de seção com linha decorativa */
.sb-section {
  padding: 16px 18px 6px;
  font-family: var(--font-title); font-size: 9.5px; font-weight: 700;
  color: var(--muted); text-transform: uppercase; letter-spacing: 2.5px;
  display: flex; align-items: center; gap: 8px;
}
.sb-section::after {
  content: ''; flex: 1; height: 1px;
  background: linear-gradient(90deg, var(--border), transparent);
}

/* Nav links */
.sidebar nav { flex: 1; padding: 4px 8px 8px; }
.sidebar nav a {
  display: flex; align-items: center; gap: 11px;
  padding: 10px 12px; color: var(--muted);
  text-decoration: none;
  font-family: var(--font-body); font-size: 15.5px; font-weight: 500;
  border-radius: var(--radius-sm);
  transition: var(--transition); margin-bottom: 2px;
  position: relative;
}
.sidebar nav a::before {
  content: '';
  position: absolute; left: 0; top: 20%; bottom: 20%;
  width: 2px; border-radius: 2px;
  background: var(--red);
  opacity: 0; transform: scaleY(0);
  transition: var(--transition);
}
.sidebar nav a:hover { background: rgba(250,178,105,.07); color: var(--cream); padding-left: 15px; }
.sidebar nav a:hover::before { opacity: .6; transform: scaleY(1); }
.sidebar nav a.active {
  background: linear-gradient(90deg, rgba(236,45,1,.14), rgba(236,45,1,.05));
  color: var(--cream);
  border: 1px solid rgba(236,45,1,.2);
}
.sidebar nav a.active::before { opacity: 1; transform: scaleY(1); }

.nav-ic {
  width: 32px; height: 32px; border-radius: 7px;
  background: rgba(250,178,105,.06);
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; flex-shrink: 0; transition: var(--transition);
}
.sidebar nav a:hover .nav-ic { background: rgba(250,178,105,.1); transform: scale(1.08); }
.sidebar nav a.active .nav-ic { background: rgba(236,45,1,.18); }

.sb-footer { padding: 12px 10px; border-top: 1px solid var(--border); flex-shrink: 0; }
.btn-sair {
  width: 100%;
  background: rgba(236,45,1,.07); border: 1px solid rgba(236,45,1,.18);
  color: rgba(252,165,165,.8); padding: 11px; border-radius: var(--radius-sm);
  font-family: var(--font-title); font-size: 11px; font-weight: 600;
  letter-spacing: 1.4px; text-transform: uppercase; cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: var(--transition);
}
.btn-sair:hover { background: rgba(236,45,1,.2); border-color: rgba(236,45,1,.35); color: #fff; transform: translateY(-1px); }

/* ===== TOPBAR ===== */
.main {
  margin-left: var(--sidebar);
  width: calc(100% - var(--sidebar));
  display: flex; flex-direction: column; min-height: 100vh;
}
.topbar {
  background: rgba(18,13,9,.88);
  backdrop-filter: blur(20px) saturate(1.4);
  -webkit-backdrop-filter: blur(20px) saturate(1.4);
  padding: 0 28px; height: 62px;
  display: flex; align-items: center; justify-content: space-between;
  border-bottom: 1px solid var(--border);
  position: sticky; top: 0; z-index: 50;
  box-shadow: 0 1px 0 rgba(250,178,105,.07), 0 4px 20px rgba(0,0,0,.3);
}
.topbar-left { display: flex; align-items: center; gap: 16px; }
.topbar h1 {
  font-family: var(--font-title);
  font-size: 15px; font-weight: 600; letter-spacing: 1.5px;
  color: var(--cream); text-transform: uppercase; line-height: 1.2;
}
.topbar .bc {
  font-family: var(--font-body);
  font-size: 13px; color: rgba(250,178,105,.6); font-style: italic;
}
.topbar-actions { display: flex; align-items: center; gap: 10px; }

.btn-hamburger {
  display: none; width: 38px; height: 38px; border-radius: var(--radius-sm);
  border: 1px solid var(--border); background: rgba(250,178,105,.05);
  color: var(--text); cursor: pointer;
  align-items: center; justify-content: center; font-size: 18px;
  transition: var(--transition);
}
.btn-hamburger:hover { border-color: var(--gold); color: var(--gold); background: rgba(250,178,105,.08); }

.topbar-divider { width: 1px; height: 24px; background: var(--border); }
.topbar-clock {
  font-family: var(--font-title); font-size: 12px;
  color: var(--muted); letter-spacing: 1px;
}

.btn-topbar-sair {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 8px 18px; border-radius: var(--radius-sm);
  background: rgba(236,45,1,.08); color: rgba(252,165,165,.85);
  font-family: var(--font-title); font-size: 11px; font-weight: 600;
  letter-spacing: 1.2px; text-transform: uppercase;
  cursor: pointer; border: 1px solid rgba(236,45,1,.2);
  transition: var(--transition);
}
.btn-topbar-sair:hover { background: rgba(236,45,1,.2); color: #fff; border-color: rgba(236,45,1,.35); }

.sidebar-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,.7); z-index: 99; backdrop-filter: blur(4px);
}
.sidebar-overlay.open { display: block; }

.content { padding: 28px 30px; flex: 1; min-width: 0; overflow: visible; }

/* ===== ALERTS ===== */
.alert {
  padding: 14px 18px; border-radius: var(--radius); margin-bottom: 20px;
  display: flex; align-items: center; gap: 12px;
  font-family: var(--font-body); font-size: 16px; font-weight: 500;
  animation: alertSlideIn .35s cubic-bezier(.4,0,.2,1);
  position: relative; overflow: hidden;
}
.alert::before {
  content: ''; position: absolute; left: 0; top: 0; bottom: 0;
  width: 3px; border-radius: 0 2px 2px 0;
}
@keyframes alertSlideIn { from { opacity:0; transform:translateY(-8px) scale(.98); } to { opacity:1; transform:none; } }
.alert-success { background:rgba(62,95,60,.12); color:#86efac; border:1px solid rgba(62,95,60,.25); }
.alert-success::before { background:#4ade80; }
.alert-error { background:rgba(236,45,1,.08); color:#fca5a5; border:1px solid rgba(236,45,1,.2); }
.alert-error::before { background:var(--red); }
.alert-warning { background:rgba(250,178,105,.08); color:var(--gold); border:1px solid rgba(250,178,105,.2); }
.alert-warning::before { background:var(--gold); }
.alert .cls {
  margin-left:auto; cursor:pointer; background:none;
  border:none; color:inherit; font-size:20px; opacity:.4; line-height:1;
  transition:opacity .15s; flex-shrink:0;
}
.alert .cls:hover { opacity:.9; }

/* ===== PANELS ===== */
.panel {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 22px; margin-bottom: 22px;
  transition: border-color .2s;
}
.panel:hover { border-color: rgba(250,178,105,.2); }
.panel-header {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 18px; padding-bottom: 15px; border-bottom: 1px solid var(--border);
}
.panel-title {
  font-family: var(--font-title); font-size: 12.5px; font-weight: 700;
  color: var(--cream); letter-spacing: 1.5px; text-transform: uppercase;
  display: flex; align-items: center; gap: 9px;
}

/* ===== STAT CARDS ===== */
.cards-grid {
  display: grid; gap: 16px;
  grid-template-columns: repeat(auto-fit, minmax(195px, 1fr));
  margin-bottom: 26px;
}
.stat-card {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 20px 22px;
  position: relative; overflow: hidden;
  transition: var(--transition);
  text-decoration: none; display: block;
}
.stat-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: var(--cc, var(--red));
}
.stat-card::after {
  content: ''; position: absolute; top: -20px; right: -20px;
  width: 80px; height: 80px; border-radius: 50%;
  background: var(--cc, var(--red));
  opacity: .04; pointer-events: none; transition: var(--transition);
}
.stat-card:hover { transform: translateY(-4px); border-color: rgba(250,178,105,.22); box-shadow: 0 14px 36px rgba(0,0,0,.4); }
.stat-card:hover::after { opacity: .08; transform: scale(1.2); }

.sc-head, .sc-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
.sc-icon {
  width: 40px; height: 40px; border-radius: 10px;
  background: rgba(250,178,105,.07); border: 1px solid rgba(250,178,105,.1);
  display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
}
.sc-badge {
  font-family: var(--font-title); font-size: 10px; font-weight: 700;
  color: var(--muted); text-transform: uppercase; letter-spacing: 1.2px;
  background: rgba(250,178,105,.06); border: 1px solid rgba(250,178,105,.1);
  padding: 3px 10px; border-radius: 20px;
}
.sc-val, .sc-value {
  font-family: var(--font-title); font-size: 30px; font-weight: 700;
  color: var(--cream); letter-spacing: -1px; line-height: 1.1; margin-bottom: 5px;
}
.sc-lbl, .sc-label { font-family: var(--font-body); font-size: 14.5px; color: var(--muted); font-style: italic; }

/* ===== TABLES ===== */
.table-wrap {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); overflow: hidden; margin-bottom: 22px;
  overflow-x: auto; -webkit-overflow-scrolling: touch;
}
.table-header {
  padding: 16px 22px;
  display: flex; justify-content: space-between; align-items: center;
  border-bottom: 1px solid var(--border);
  background: rgba(250,178,105,.02);
}
.table-header h2 {
  font-family: var(--font-title); font-size: 12.5px; font-weight: 700;
  color: var(--cream); letter-spacing: 1.5px; text-transform: uppercase;
}
table { width: 100%; border-collapse: collapse; min-width: 500px; }
thead th {
  background: rgba(250,178,105,.03);
  padding: 11px 18px; text-align: left;
  font-family: var(--font-title); font-size: 10px; color: var(--muted);
  text-transform: uppercase; letter-spacing: 1.4px; font-weight: 700;
  border-bottom: 1px solid var(--border); white-space: nowrap;
}
tbody td { padding: 14px 18px; border-bottom: 1px solid rgba(250,178,105,.05); font-size: 15px; vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr:nth-child(even) { background: rgba(250,178,105,.015); }
tbody tr:hover { background: rgba(250,178,105,.05); }
.td-primary { color: var(--cream); font-weight: 600; font-family: var(--font-body); }
.td-mono { font-family: 'Courier New', monospace; color: var(--gold); font-size: 14.5px; letter-spacing: .5px; }

/* ===== BADGES ===== */
.badge {
  padding: 4px 11px; border-radius: 20px;
  font-family: var(--font-title); font-size: 10px; font-weight: 700;
  display: inline-flex; align-items: center; gap: 4px;
  letter-spacing: .9px; text-transform: uppercase; white-space: nowrap;
}
.badge-success   { background:rgba(62,95,60,.2);    color:#86efac; border:1px solid rgba(62,95,60,.35); }
.badge-warning   { background:rgba(250,178,105,.15); color:var(--gold); border:1px solid rgba(250,178,105,.3); }
.badge-danger    { background:rgba(236,45,1,.14);    color:#fca5a5; border:1px solid rgba(236,45,1,.28); }
.badge-info      { background:rgba(139,69,19,.18);   color:#fdba74; border:1px solid rgba(139,69,19,.3); }
.badge-secondary { background:rgba(244,232,208,.06); color:var(--muted); border:1px solid rgba(244,232,208,.1); }
.badge-primary   { background:rgba(236,45,1,.14);    color:#fca5a5; border:1px solid rgba(236,45,1,.28); }
.badge-purple    { background:rgba(250,178,105,.12);  color:var(--gold); border:1px solid rgba(250,178,105,.22); }

/* ===== BUTTONS ===== */
.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 10px 22px; border-radius: var(--radius-sm);
  font-family: var(--font-title); font-size: 11.5px; font-weight: 700;
  letter-spacing: 1.4px; text-transform: uppercase;
  cursor: pointer; text-decoration: none; border: none;
  transition: var(--transition); white-space: nowrap; position: relative; overflow: hidden;
}
.btn-primary {
  background: var(--red); color: #fff;
  box-shadow: 0 4px 16px rgba(236,45,1,.32), inset 0 1px 0 rgba(255,255,255,.1);
}
.btn-primary:hover { background: var(--red-dark); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(236,45,1,.45); }
.btn-primary:active { transform: translateY(0); }
.btn-primary:disabled { opacity:.5; cursor:not-allowed; transform:none !important; box-shadow:none; }
.btn-secondary { background:rgba(250,178,105,.06); color:var(--cream); border:1px solid var(--border); }
.btn-secondary:hover { background:rgba(250,178,105,.1); border-color:var(--border-hv); }
.btn-success { background:var(--green-soft); color:#86efac; border:1px solid rgba(62,95,60,.32); box-shadow:0 3px 12px rgba(62,95,60,.1); }
.btn-success:hover { background:rgba(62,95,60,.28); transform:translateY(-1px); }
.btn-danger { background:var(--red-soft); color:#fca5a5; border:1px solid rgba(236,45,1,.28); }
.btn-danger:hover { background:rgba(236,45,1,.22); transform:translateY(-1px); }
.btn-warning { background:var(--gold-soft); color:var(--gold); border:1px solid rgba(250,178,105,.28); }
.btn-warning:hover { background:rgba(250,178,105,.22); transform:translateY(-1px); }
.btn-sm { padding:7px 15px; font-size:10.5px; border-radius:6px; }
.btn-icon { width:36px; height:36px; padding:0; justify-content:center; border-radius:7px; }
.btn[data-loading]:disabled { opacity:.7; }

/* ===== FORMS ===== */
.form-group { margin-bottom: 18px; }
.form-group label {
  display: block; margin-bottom: 7px;
  font-family: var(--font-title); font-size: 10px; font-weight: 700;
  color: var(--muted); text-transform: uppercase; letter-spacing: 1.3px;
}
.form-control, .form-select {
  width: 100%; padding: 11px 15px;
  background: rgba(250,178,105,.04); border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  font-family: var(--font-body); font-size: 16px; color: var(--cream);
  transition: var(--transition);
}
.form-control::placeholder { color: rgba(244,232,208,.3); font-style: italic; }
.form-control:focus, .form-select:focus {
  outline: none; border-color: rgba(250,178,105,.5);
  background: rgba(250,178,105,.06); box-shadow: 0 0 0 3px rgba(250,178,105,.08);
}
.form-select option { background: var(--bg2); color: var(--cream); }
.form-row { display: grid; gap: 14px; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
.invalid-feedback { color:#fca5a5; font-size:13.5px; margin-top:5px; font-style:italic; }
.is-invalid { border-color:rgba(236,45,1,.6) !important; background:rgba(236,45,1,.04) !important; }

/* ===== MESAS ===== */
.mesas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
.mesa-card {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 20px 14px;
  text-align: center; cursor: pointer; transition: var(--transition);
  position: relative; overflow: hidden;
  text-decoration: none; display: block;
}
.mesa-card::after {
  content: ''; position: absolute; bottom: 0; left: 0; right: 0;
  height: 3px; background: var(--mc, var(--muted)); transition: height .2s;
}
.mesa-card:hover { transform: translateY(-3px); border-color: var(--border-hv); box-shadow: 0 8px 24px rgba(0,0,0,.3); }
.mesa-card:hover::after { height: 4px; }
.mesa-card.disponivel { --mc: var(--green); }
.mesa-card.ocupada    { --mc: var(--red); }
.mesa-card.reservada  { --mc: var(--gold); }
.mc-num, .mc-number { font-family:var(--font-title); font-size:34px; font-weight:700; color:var(--cream); letter-spacing:-1px; line-height:1.1; }
.mc-seats { font-family:var(--font-body); font-size:13px; color:var(--muted); margin:6px 0 10px; font-style:italic; }

/* ===== KPI ===== */
.kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; margin-bottom: 22px; }
.kpi {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 18px 20px;
  position: relative; overflow: hidden; transition: var(--transition);
}
.kpi::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--kc,var(--red)); }
.kpi:hover { border-color:rgba(250,178,105,.22); transform:translateY(-2px); }
.kpi-val { font-family:var(--font-title); font-size:28px; font-weight:700; color:var(--cream); margin:8px 0 5px; letter-spacing:-1px; }
.kpi-lbl { font-family:var(--font-body); font-size:14.5px; color:var(--muted); font-style:italic; }

/* ===== DASHBOARD GRID ===== */
.dashboard-grid { display:grid; grid-template-columns:1.2fr 1fr; gap:24px; }

/* ===== EMPTY STATE ===== */
.empty-state { text-align:center; padding:56px 24px; color:var(--muted); }
.empty-state .es-icon { font-size:52px; display:block; margin-bottom:16px; opacity:.2; }
.empty-state p { font-family:var(--font-body); font-size:17px; font-style:italic; }

/* ===== MISC ===== */
hr, .divider { border:none; border-top:1px solid var(--border); margin:20px 0; }
.campo-erro { color:#fca5a5; font-size:13.5px; margin-top:5px; display:none; font-style:italic; }

/* ===== MODAL ===== */
.modal-overlay {
  display:none; position:fixed; inset:0; z-index:999;
  background:rgba(0,0,0,.75); backdrop-filter:blur(6px);
  align-items:center; justify-content:center;
}
.modal-overlay.open { display:flex; animation:fadeIn .2s ease; }
@keyframes fadeIn { from{opacity:0;} to{opacity:1;} }
.modal-card {
  background: linear-gradient(160deg,#1E1108,#170D06);
  border: 1px solid rgba(250,178,105,.18);
  border-radius: var(--radius-lg); padding:30px; max-width:390px; width:90%;
  box-shadow: 0 32px 80px rgba(0,0,0,.8), 0 0 0 1px rgba(250,178,105,.05);
  animation: modalIn .25s cubic-bezier(.4,0,.2,1);
}
@keyframes modalIn { from{opacity:0;transform:translateY(16px) scale(.97);} to{opacity:1;transform:none;} }
.modal-card h3 { font-family:var(--font-title); font-size:14px; font-weight:700; color:var(--cream); letter-spacing:1.2px; text-transform:uppercase; margin-bottom:12px; }
.modal-card p { font-family:var(--font-body); font-size:16px; color:var(--muted); margin-bottom:22px; line-height:1.6; }
.modal-actions { display:flex; gap:10px; }

/* ===== TOAST HTTP ===== */
#http-toast {
  position:fixed; bottom:24px; right:24px; z-index:9999;
  background: linear-gradient(160deg,#1E1108,#170D06);
  border:1px solid rgba(236,45,1,.3); border-left:4px solid var(--red);
  border-radius:var(--radius); padding:16px 20px;
  max-width:370px; width:calc(100vw - 48px);
  box-shadow:0 20px 60px rgba(0,0,0,.7);
  display:flex; align-items:flex-start; gap:13px;
  transform:translateY(120%); opacity:0;
  transition:transform .4s cubic-bezier(.4,0,.2,1), opacity .4s;
  pointer-events:none;
}
#http-toast.show { transform:translateY(0); opacity:1; pointer-events:auto; }
#http-toast .toast-icon { font-size:22px; flex-shrink:0; line-height:1.2; }
#http-toast .toast-body { flex:1; }
#http-toast .toast-title { font-family:var(--font-title); font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:#fca5a5; margin-bottom:4px; }
#http-toast .toast-msg { font-family:var(--font-body); font-size:15px; color:var(--muted); }
#http-toast .toast-action { margin-top:12px; display:flex; gap:8px; }
#http-toast .toast-btn { font-family:var(--font-title); font-size:10.5px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; padding:6px 14px; border-radius:6px; border:none; transition:var(--transition); }
#http-toast .toast-btn-primary { background:var(--red); color:#fff; }
#http-toast .toast-btn-primary:hover { background:var(--red-dark); }
#http-toast .toast-btn-secondary { background:transparent; color:var(--muted); border:1px solid var(--border); }
#http-toast .toast-btn-secondary:hover { color:var(--cream); border-color:var(--border-hv); }
#http-toast .toast-close { background:none; border:none; color:var(--muted); cursor:pointer; font-size:18px; line-height:1; flex-shrink:0; opacity:.5; transition:opacity .15s; }
#http-toast .toast-close:hover { opacity:1; }

/* ===== MOBILE ===== */
@media (max-width: 768px) {
  :root { --sidebar: 272px; }
  .sidebar { transform: translateX(-100%); }
  .sidebar.open { transform: translateX(0); box-shadow: 8px 0 40px rgba(0,0,0,.6); }
  .main { margin-left: 0; width: 100%; }
  .btn-hamburger { display: flex; }
  .content { padding: 18px 16px; }
  .topbar { padding: 0 16px; }
  .cards-grid { grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 12px; }
  .form-row { grid-template-columns: 1fr; }
  .btn-topbar-sair span { display: none; }
  .btn-topbar-sair { padding: 8px 12px; }
  .dashboard-grid { grid-template-columns: 1fr; }
  .order-layout { flex-direction: column !important; }
  .resumo-col { width: 100% !important; min-width: 0 !important; position: static !important; }
  [style*="grid-template-columns:360px"] { display: block !important; }
  [style*="grid-template-columns:340px"] { display: block !important; }
  [style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
  [style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
  #http-toast { bottom: 16px; right: 16px; width: calc(100vw - 32px); }
  .topbar-clock, .topbar-divider { display: none; }
}
@media (max-width: 480px) {
  .cards-grid { grid-template-columns: 1fr 1fr; }
  .mesas-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
  .table-header { flex-direction: column; align-items: flex-start; gap: 10px; }
  .topbar h1 { font-size: 14px; }
  .modal-card { padding: 22px 18px; }
}

/* ===== PREMIUM SAAS UI OVERRIDE ===== */
:root {
  --radius: 18px;
  --radius-sm: 14px;
  --radius-lg: 24px;
  --surface: rgba(28,17,8,.82);
  --surface-strong: rgba(36,22,8,.9);
  --surface-soft: rgba(250,178,105,.045);
  --shadow: 0 14px 40px rgba(0,0,0,.32);
  --shadow-lg: 0 24px 70px rgba(0,0,0,.48);
  --transition: all .22s cubic-bezier(.2,.8,.2,1);
  --font-body: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  --font-title: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

body {
  font-size: 15px;
  line-height: 1.55;
  background:
    linear-gradient(180deg, rgba(250,178,105,.035), transparent 260px),
    var(--bg);
}

.sidebar {
  padding: 14px 12px;
  background: rgba(18,13,9,.94);
  border-right: 1px solid rgba(250,178,105,.11);
  box-shadow: 10px 0 38px rgba(0,0,0,.28);
}
.sidebar::before { opacity: .35; }
.sb-brand {
  padding: 14px 10px 18px;
  border-bottom-color: rgba(250,178,105,.09);
}
.sb-logo {
  width: 42px;
  height: 42px;
  border-radius: 16px;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.14), 0 12px 28px rgba(236,45,1,.22);
}
.sb-brand-name {
  font-size: 13px;
  letter-spacing: 1.4px;
}
.sb-brand-sub {
  font-size: 12px;
  font-style: normal;
}
.sb-user {
  order: 1;
  margin: 12px 0 10px;
  padding: 12px;
  border-radius: 18px;
  background: rgba(250,178,105,.055);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.04);
}
.sb-user::before { width: 2px; }
.sb-avatar {
  width: 40px;
  height: 40px;
  border-radius: 14px;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.16);
}
.sb-uname {
  font-size: 14px;
  font-weight: 700;
}
.sb-urole {
  font-size: 9px;
  letter-spacing: 1.2px;
}
.sidebar nav {
  order: 2;
  padding: 8px 0;
}
.sb-section {
  padding: 18px 10px 8px;
  font-size: 10px;
  letter-spacing: 1.7px;
}
.sidebar nav a {
  min-height: 44px;
  margin-bottom: 4px;
  padding: 9px 10px;
  border-radius: 15px;
  font-size: 14px;
  font-weight: 650;
  letter-spacing: .1px;
}
.sidebar nav a:hover {
  padding-left: 12px;
  background: rgba(250,178,105,.075);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.035);
}
.sidebar nav a.active {
  background: rgba(236,45,1,.14);
  border-color: rgba(236,45,1,.24);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.055), 0 12px 30px rgba(0,0,0,.18);
}
.nav-ic {
  width: 34px;
  height: 34px;
  border-radius: 13px;
  font-size: 15px;
}
.sb-footer {
  order: 4;
  padding: 10px 0 0;
  border-top-color: rgba(250,178,105,.1);
}
.btn-sair {
  min-height: 42px;
  border-radius: 15px;
}

.topbar {
  height: 72px;
  padding: 0 32px;
  background: rgba(18,13,9,.78);
  border-bottom-color: rgba(250,178,105,.1);
  box-shadow: 0 10px 30px rgba(0,0,0,.18);
}
.topbar-left {
  gap: 14px;
}
.topbar h1 {
  font-size: 15px;
  letter-spacing: .8px;
  font-weight: 800;
}
.topbar .bc {
  margin-top: 2px;
  font-size: 12px;
  font-style: normal;
}
.topbar-clock {
  padding: 7px 10px;
  border: 1px solid rgba(250,178,105,.1);
  border-radius: 999px;
  background: rgba(250,178,105,.04);
}
.btn-topbar-sair,
.btn-hamburger {
  border-radius: 14px;
}
.content {
  padding: 32px;
}

.alert,
.panel,
.stat-card,
.table-wrap,
.mesa-card,
.kpi,
.modal-card {
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow);
}
.panel,
.table-wrap,
.stat-card,
.mesa-card,
.kpi {
  background: var(--surface);
  border-color: rgba(250,178,105,.115);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.035), var(--shadow);
}
.panel {
  padding: 24px;
}
.panel:hover,
.table-wrap:hover,
.stat-card:hover {
  border-color: rgba(250,178,105,.24);
}
.panel-header,
.table-header {
  min-height: 54px;
  margin-bottom: 20px;
  padding-bottom: 16px;
  gap: 16px;
}
.panel-title,
.table-header h2 {
  font-size: 12px;
  letter-spacing: 1.15px;
  font-weight: 800;
}

.cards-grid {
  gap: 18px;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  margin-bottom: 30px;
}
.stat-card {
  min-height: 150px;
  padding: 22px;
}
.stat-card::before {
  height: 4px;
  background: var(--card-color, var(--cc, var(--red)));
}
.stat-card::after {
  display: none;
}
.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.05), var(--shadow-lg);
}
.sc-head,
.sc-header {
  align-items: center;
  margin-bottom: 18px;
}
.sc-icon {
  width: 42px;
  height: 42px;
  border-radius: 15px;
  background: rgba(250,178,105,.075);
}
.sc-badge {
  border-radius: 999px;
  padding: 5px 11px;
  font-size: 9px;
  letter-spacing: 1px;
}
.sc-val,
.sc-value,
.kpi-val {
  font-size: clamp(24px, 2.8vw, 34px);
  letter-spacing: 0;
}
.sc-lbl,
.sc-label,
.kpi-lbl {
  font-size: 13px;
  font-style: normal;
}

.table-wrap {
  overflow: hidden;
  overflow-x: auto;
}
.table-header {
  padding: 18px 22px;
  margin-bottom: 0;
  background: rgba(250,178,105,.03);
}
table {
  min-width: 560px;
}
thead th {
  padding: 13px 18px;
  font-size: 10px;
  letter-spacing: 1.2px;
  background: rgba(250,178,105,.035);
}
tbody td {
  padding: 15px 18px;
  font-size: 14px;
}
tbody tr {
  transition: background .18s ease;
}
tbody tr:hover {
  background: rgba(250,178,105,.055);
}
.td-mono {
  letter-spacing: .25px;
}

.badge {
  min-height: 25px;
  padding: 5px 10px;
  border-radius: 999px;
  font-size: 9px;
  letter-spacing: .75px;
}
.btn {
  min-height: 42px;
  padding: 10px 18px;
  border-radius: 15px;
  font-size: 10.5px;
  letter-spacing: 1px;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.055);
}
.btn:hover {
  transform: translateY(-1px);
}
.btn-sm {
  min-height: 36px;
  padding: 8px 13px;
  border-radius: 13px;
}
.btn-icon {
  border-radius: 14px;
}
.btn:disabled,
.btn[disabled] {
  opacity: .55;
  cursor: not-allowed;
  transform: none !important;
}

.form-group {
  margin-bottom: 20px;
}
.form-group label {
  margin-bottom: 8px;
  font-size: 10px;
  letter-spacing: 1.1px;
}
.form-control,
.form-select {
  min-height: 44px;
  padding: 11px 14px;
  border-radius: 15px;
  font-size: 14px;
  background: rgba(250,178,105,.045);
}
.form-control:hover,
.form-select:hover {
  border-color: rgba(250,178,105,.22);
}
.form-control:focus,
.form-select:focus {
  border-color: rgba(250,178,105,.52);
  box-shadow: 0 0 0 4px rgba(250,178,105,.09);
}
.form-select:disabled,
.form-control:disabled {
  opacity: .55;
  cursor: not-allowed;
}

.mesas-grid {
  gap: 18px;
}
.mesa-card {
  border-radius: 22px;
  padding: 22px;
  transition: var(--transition);
}
.mesa-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-lg);
}
.mc-number {
  letter-spacing: 0;
}
.empty-state {
  padding: 60px 24px;
}

@media (max-width: 768px) {
  .content {
    padding: 22px 16px;
  }
  .topbar {
    height: 66px;
    padding: 0 16px;
  }
  .cards-grid {
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
  }
  .panel,
  .stat-card,
  .table-wrap {
    border-radius: 20px;
  }
}
@media (max-width: 480px) {
  .cards-grid {
    grid-template-columns: 1fr;
  }
  .btn {
    width: 100%;
    justify-content: center;
  }
}

/* ===== RESPONSIVIDADE MOBILE/TABLET ===== */
html,
body {
  max-width: 100%;
  overflow-x: hidden;
  scroll-behavior: smooth;
}

.main,
.content,
.panel,
.stat-card,
.table-wrap,
.modal-card,
.mesa-card,
.kpi,
.cardapio-col,
.resumo-col,
.caixa-layout > *,
.pay-card,
.pay-panel,
.pay-mesa-card {
  min-width: 0;
}

img,
svg,
canvas,
video,
iframe {
  max-width: 100%;
}

.panel-header,
.table-header,
.topbar-actions,
.modal-actions,
.filtro-bar,
.subtipo-bar,
.status-btns,
[style*="display:flex"],
[style*="display: flex"] {
  flex-wrap: wrap;
}

.table-wrap {
  max-width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  overscroll-behavior-inline: contain;
}

.table-wrap::-webkit-scrollbar {
  height: 6px;
}

table {
  max-width: 100%;
}

th,
td {
  overflow-wrap: anywhere;
}

.form-control,
.form-select,
input,
select,
textarea,
button {
  max-width: 100%;
}

@media (max-width: 1440px) {
  .content {
    padding: 28px 24px;
  }

  .cards-grid,
  .kpi-grid,
  .dashboard-grid,
  .rel-grid {
    gap: 16px;
  }
}

@media (max-width: 1024px) {
  :root {
    --sidebar: min(320px, 86vw);
  }

  .sidebar {
    width: var(--sidebar);
    transform: translateX(-105%);
    box-shadow: 12px 0 42px rgba(0,0,0,.62);
  }

  .sidebar.open {
    transform: translateX(0);
  }

  .sidebar-overlay.open {
    display: block;
  }

  .main {
    width: 100%;
    margin-left: 0;
  }

  .btn-hamburger {
    display: flex;
    width: 44px;
    height: 44px;
    flex-shrink: 0;
  }

  .topbar {
    height: auto;
    min-height: 68px;
    padding: 10px 20px;
    gap: 12px;
  }

  .topbar-left {
    min-width: 0;
    flex: 1;
  }

  .topbar h1,
  .topbar .bc {
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .topbar-actions {
    justify-content: flex-end;
  }

  .sidebar nav a {
    min-height: 50px;
    padding: 11px 12px;
  }

  .nav-ic {
    width: 38px;
    height: 38px;
  }

  .content {
    padding: 22px 18px;
  }

  .cards-grid,
  .kpi-grid,
  .dashboard-grid,
  .rel-grid,
  .pay-mesas-grid,
  .inv-grid,
  .est-forms,
  [style*="grid-template-columns"] {
    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
  }

  .caixa-layout,
  .order-layout,
  .mesa-show-grid,
  [style*="grid-template-columns: 360px"],
  [style*="grid-template-columns:360px"],
  [style*="grid-template-columns: 340px"],
  [style*="grid-template-columns:340px"],
  [style*="grid-template-columns: 320px"],
  [style*="grid-template-columns:320px"] {
    grid-template-columns: 1fr !important;
    flex-direction: column !important;
  }

  .resumo-col,
  [style*="position:sticky"],
  [style*="position: sticky"] {
    width: 100% !important;
    min-width: 0 !important;
    position: static !important;
    top: auto !important;
  }

  .panel,
  .stat-card,
  .table-wrap,
  .mesa-card,
  .kpi {
    padding: 20px;
  }

  .btn,
  .btn-sair,
  .btn-topbar-sair,
  .form-control,
  .form-select,
  input,
  select,
  textarea {
    min-height: 46px;
  }

  .btn-sm {
    min-height: 40px;
  }

  .btn-icon {
    width: 44px;
    min-width: 44px;
    height: 44px;
  }
}

@media (max-width: 768px) {
  body {
    font-size: 16px;
  }

  .topbar {
    align-items: flex-start;
  }

  .topbar-left > div {
    min-width: 0;
  }

  .topbar-actions {
    gap: 8px;
  }

  .topbar-clock,
  .topbar-divider {
    display: none;
  }

  .content {
    padding: 18px 14px 24px;
  }

  .cards-grid,
  .kpi-grid,
  .dashboard-grid,
  .rel-grid,
  .mesas-grid,
  .pay-mesas-grid,
  .item-grid,
  .inv-grid,
  .est-forms,
  [style*="grid-template-columns"] {
    grid-template-columns: 1fr !important;
  }

  .panel-header,
  .table-header {
    align-items: flex-start;
    gap: 12px;
  }

  .panel-header > *,
  .table-header > * {
    min-width: 0;
  }

  .panel,
  .stat-card,
  .table-wrap,
  .mesa-card,
  .kpi,
  .modal-card {
    border-radius: 18px;
  }

  .stat-card,
  .panel,
  .mesa-card,
  .kpi {
    padding: 18px;
  }

  table {
    min-width: 640px;
  }

  thead th,
  tbody td {
    padding: 13px 14px;
  }

  .form-row,
  .modal-actions,
  .status-btns {
    grid-template-columns: 1fr !important;
    flex-direction: column;
    align-items: stretch;
  }

  .form-control,
  .form-select,
  input,
  select,
  textarea {
    font-size: 16px;
  }

  .btn,
  .btn-sair,
  .btn-topbar-sair {
    min-height: 48px;
  }

  .btn:not(.btn-icon),
  .modal-actions .btn,
  form .btn[type="submit"] {
    white-space: normal;
    text-align: center;
  }

  .empty-state {
    padding: 42px 18px;
  }

  #http-toast {
    left: 14px;
    right: 14px;
    bottom: 14px;
    width: auto;
    max-width: none;
  }
}

@media (max-width: 425px) {
  .topbar {
    padding: 10px 12px;
  }

  .topbar h1 {
    font-size: 13px;
    line-height: 1.25;
    white-space: normal;
  }

  .topbar .bc {
    font-size: 12px;
    line-height: 1.25;
  }

  .btn-topbar-sair span {
    display: none;
  }

  .content {
    padding: 14px 10px 22px;
  }

  .panel,
  .stat-card,
  .table-wrap,
  .mesa-card,
  .kpi,
  .modal-card {
    border-radius: 16px;
  }

  .panel,
  .stat-card,
  .mesa-card,
  .kpi {
    padding: 16px;
  }

  .panel-title,
  .table-header h2 {
    font-size: 11px;
    line-height: 1.35;
  }

  .sc-val,
  .sc-value,
  .kpi-val {
    font-size: 24px;
  }

  .btn:not(.btn-icon),
  .filtro-btn,
  .subtipo-btn,
  .btn-enviar {
    width: 100%;
    justify-content: center;
  }

  .filtro-bar,
  .subtipo-bar {
    display: grid;
    grid-template-columns: 1fr;
  }

  table {
    min-width: 600px;
  }

  .modal-overlay {
    padding: 12px;
  }
}

@media (max-width: 375px) {
  .content {
    padding-left: 8px;
    padding-right: 8px;
  }

  .sidebar {
    width: min(300px, 88vw);
  }

  .sb-brand {
    padding: 18px 14px 14px;
  }

  .sb-user {
    margin: 10px 8px 4px;
  }

  .sidebar nav {
    padding-left: 6px;
    padding-right: 6px;
  }

  .btn {
    padding-left: 14px;
    padding-right: 14px;
  }
}

@media (max-width: 320px) {
  .topbar {
    padding-left: 8px;
    padding-right: 8px;
  }

  .btn-hamburger,
  .btn-icon {
    width: 42px;
    min-width: 42px;
    height: 42px;
  }

  .content {
    padding-left: 6px;
    padding-right: 6px;
  }

  .panel,
  .stat-card,
  .mesa-card,
  .kpi {
    padding: 14px;
  }

  .badge {
    max-width: 100%;
    white-space: normal;
    justify-content: center;
    text-align: center;
  }
}

/* ===== SCROLL EM PAINEIS LATERAIS ===== */
@media (min-width: 769px) {
  .panel[style*="position:sticky"],
  .panel[style*="position: sticky"],
  .form-panel,
  .resumo-col,
  [style*="position:sticky"][style*="top:80px"],
  [style*="position: sticky"][style*="top:80px"] {
    max-height: calc(100vh - 104px);
    overflow-y: auto;
    overscroll-behavior: contain;
    scrollbar-gutter: stable;
  }

  .panel[style*="position:sticky"]::-webkit-scrollbar,
  .panel[style*="position: sticky"]::-webkit-scrollbar,
  .form-panel::-webkit-scrollbar,
  .resumo-col::-webkit-scrollbar,
  [style*="position:sticky"][style*="top:80px"]::-webkit-scrollbar,
  [style*="position: sticky"][style*="top:80px"]::-webkit-scrollbar {
    width: 6px;
  }

  .panel[style*="position:sticky"]::-webkit-scrollbar-thumb,
  .panel[style*="position: sticky"]::-webkit-scrollbar-thumb,
  .form-panel::-webkit-scrollbar-thumb,
  .resumo-col::-webkit-scrollbar-thumb,
  [style*="position:sticky"][style*="top:80px"]::-webkit-scrollbar-thumb,
  [style*="position: sticky"][style*="top:80px"]::-webkit-scrollbar-thumb {
    background: rgba(250,178,105,.28);
    border-radius: 999px;
  }
}
</style>
@yield('styles')
</head>
<body>

<div id="http-toast" role="alert" aria-live="assertive">
  <span class="toast-icon" id="toast-icon">⚠️</span>
  <div class="toast-body">
    <div class="toast-title" id="toast-title">Erro</div>
    <div class="toast-msg"   id="toast-msg">Algo deu errado.</div>
    <div class="toast-action" id="toast-action"></div>
  </div>
  <button class="toast-close" onclick="fecharToast()" aria-label="Fechar">×</button>
</div>

<div class="modal-overlay" id="modal-confirm" role="dialog" aria-modal="true" aria-labelledby="modal-title">
  <div class="modal-card">
    <h3 id="modal-title">⚠️ Confirmar Ação</h3>
    <p  id="modal-msg">Confirmar esta ação?</p>
    <div class="modal-actions">
      <button class="btn btn-danger"     onclick="confirmarModal()">Confirmar</button>
      <button class="btn btn-secondary"  onclick="fecharModal()">Cancelar</button>
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
    <div style="min-width:0">
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
    <a href="{{ route('caixa.pagar-mesa') }}" class="{{ request()->routeIs('caixa.dashboard', 'caixa.pagar-mesa', 'caixa.pagamento') ? 'active' : '' }}">
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
    <a href="{{ route('controle.estoque') }}"  class="{{ request()->routeIs('controle.estoque*') ? 'active' : '' }}">
      <div class="nav-ic">🔄</div> Controle
    </a>
    <a href="{{ route('dashboard.estoque') }}" class="{{ request()->routeIs('dashboard.estoque') ? 'active' : '' }}">
      <div class="nav-ic">📦</div> Inventário
    </a>
    <a href="{{ route('compras.index') }}"     class="{{ request()->routeIs('compras.*') ? 'active' : '' }}">
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
    <div class="topbar-left">
      <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()" aria-label="Abrir menu">☰</button>
      <div>
        <h1>@yield('page-title','Dashboard')</h1>
        <div class="bc">@yield('breadcrumb','Sistema de Gestão')</div>
      </div>
    </div>
    <div class="topbar-actions">
      <span class="topbar-clock" id="topbar-clock"></span>
      <div class="topbar-divider"></div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf
        <button type="submit" class="btn-topbar-sair">🚪 <span>Sair</span></button>
      </form>
    </div>
  </div>

  <div class="content">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
      ✅ <span>{{ session('success') }}</span>
      <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error" role="alert">
      ❌ <span>{{ session('error') }}</span>
      <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">×</button>
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning" role="alert">
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
/* === SIDEBAR === */
function toggleSidebar(){
  var sb=document.getElementById('sidebar'), ov=document.getElementById('sidebar-overlay');
  sb.classList.toggle('open'); ov.classList.toggle('open');
  document.body.style.overflow=sb.classList.contains('open')?'hidden':'';
}
document.querySelectorAll('#sidebar-nav a').forEach(function(a){
  a.addEventListener('click',function(){ if(window.innerWidth<=1024){ document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebar-overlay').classList.remove('open'); document.body.style.overflow=''; } });
});
(function(){ var nav=document.getElementById('sidebar'); if(!nav)return; var s=sessionStorage.getItem('sb-scroll'); if(s)nav.scrollTop=parseInt(s); nav.addEventListener('scroll',function(){sessionStorage.setItem('sb-scroll',nav.scrollTop);}); })();

/* === RELÓGIO === */
(function(){
  var el=document.getElementById('topbar-clock'); if(!el)return;
  function t(){ var d=new Date(); el.textContent=String(d.getHours()).padStart(2,'0')+':'+String(d.getMinutes()).padStart(2,'0'); }
  t(); setInterval(t,30000);
})();

/* === AUTO-DISMISS FLASH (6s) === */
setTimeout(function(){
  document.querySelectorAll('.alert').forEach(function(el){
    el.style.transition='opacity .5s, transform .5s';
    el.style.opacity='0'; el.style.transform='translateY(-6px)';
    setTimeout(function(){ if(el.parentNode)el.remove(); },500);
  });
},6000);

/* === MODAL === */
var _mc=null;
function confirmar(msg,cb,titulo){ document.getElementById('modal-msg').textContent=msg||'Confirmar?'; document.getElementById('modal-title').textContent=titulo||'⚠️ Confirmar Ação'; _mc=cb; document.getElementById('modal-confirm').classList.add('open'); }
function confirmarModal(){ var cb=_mc; fecharModal(); if(typeof cb==='function')cb(); }
function fecharModal(){ document.getElementById('modal-confirm').classList.remove('open'); _mc=null; }
document.addEventListener('keydown',function(e){ if(e.key==='Escape')fecharModal(); });

/* === TOAST === */
var _tt=null;
function mostrarToast(o){
  var t=document.getElementById('http-toast');
  document.getElementById('toast-icon').textContent=o.icone||'⚠️';
  document.getElementById('toast-title').textContent=o.titulo||'Erro';
  document.getElementById('toast-msg').textContent=o.msg||'Algo deu errado.';
  var a=document.getElementById('toast-action'); a.innerHTML='';
  if(o.botoes)o.botoes.forEach(function(b){ var btn=document.createElement('button'); btn.className='toast-btn '+(b.primario?'toast-btn-primary':'toast-btn-secondary'); btn.textContent=b.label; btn.onclick=function(){fecharToast();if(typeof b.acao==='function')b.acao();}; a.appendChild(btn); });
  t.classList.add('show'); if(_tt)clearTimeout(_tt); _tt=setTimeout(fecharToast,o.duracao||8000);
}
function fecharToast(){ document.getElementById('http-toast').classList.remove('show'); if(_tt){clearTimeout(_tt);_tt=null;} }
function _ms(s){ return ({419:{icone:'⏱️',titulo:'Sessão Expirada',msg:'Sua sessão expirou por inatividade.'},401:{icone:'🔒',titulo:'Não Autenticado',msg:'Você precisa fazer login.'},403:{icone:'🚫',titulo:'Acesso Negado',msg:'Sem permissão para esta ação.'},500:{icone:'🔥',titulo:'Erro Interno',msg:'Erro no servidor. Tente novamente.'},502:{icone:'🌐',titulo:'Servidor Indisponível',msg:'Fora do ar temporariamente.'},503:{icone:'🛠️',titulo:'Em Manutenção',msg:'Tente mais tarde.'},429:{icone:'⏳',titulo:'Muitas Requisições',msg:'Aguarde antes de tentar novamente.'}})[s]||{icone:'⚠️',titulo:'Erro '+s,msg:'Erro inesperado.'}; }

/* === INTERCEPTOR FETCH === */
(function(){
  var orig=window.fetch;
  window.fetch=function(input,init){
    return orig.apply(this,arguments).then(function(r){
      if(r.status===419){mostrarToast({icone:'⏱️',titulo:'Sessão Expirada',msg:'Recarregue para continuar.',botoes:[{label:'Recarregar',primario:true,acao:function(){location.reload();}},{label:'Fechar',primario:false}]});return r;}
      if(r.status===401){mostrarToast({icone:'🔒',titulo:'Sessão Encerrada',msg:'Redirecionando para login...',botoes:[{label:'Ir para Login',primario:true,acao:function(){location.href='/login';}}],duracao:4000});setTimeout(function(){location.href='/login';},4000);return r;}
      if(r.status>=500){var i=_ms(r.status);mostrarToast({icone:i.icone,titulo:i.titulo,msg:i.msg,botoes:[{label:'Tentar novamente',primario:true,acao:function(){location.reload();}},{label:'Fechar',primario:false}]});return r;}
      if(r.status===429){mostrarToast({icone:'⏳',titulo:'Muitas Requisições',msg:'Aguarde um momento.',botoes:[{label:'Fechar',primario:false}]});return r;}
      return r;
    }).catch(function(err){mostrarToast({icone:'📡',titulo:'Sem Conexão',msg:'Verifique sua internet.',botoes:[{label:'Tentar novamente',primario:true,acao:function(){location.reload();}},{label:'Fechar',primario:false}]});throw err;});
  };
})();

/* === PAGESHOW === */
window.addEventListener('pageshow',function(e){
  if(!e.persisted)return;
  fetch('/dashboard',{method:'HEAD',credentials:'same-origin',cache:'no-store'}).then(function(r){ if(r.status===401||r.url.includes('/login'))location.href='/login'; }).catch(function(){});
});

/* === CSRF REFRESH (15min) — requer Route::get('/csrf-token', ...) === */
setInterval(function(){
  fetch('/csrf-token',{credentials:'same-origin'}).then(function(r){return r.ok?r.json():null;}).then(function(d){
    if(!d||!d.token)return;
    document.querySelectorAll('input[name="_token"]').forEach(function(i){i.value=d.token;});
    var m=document.querySelector('meta[name="csrf-token"]'); if(m)m.setAttribute('content',d.token);
    window._csrfToken=d.token;
  }).catch(function(){});
},15*60*1000);
document.addEventListener('DOMContentLoaded',function(){ var m=document.querySelector('meta[name="csrf-token"]'); if(m)window._csrfToken=m.getAttribute('content'); });

/* === ANTI DOUBLE-SUBMIT === */
document.querySelectorAll('form').forEach(function(form){
  var sub=false;
  form.addEventListener('submit',function(e){
    if(sub){e.preventDefault();return false;} sub=true;
    var btn=form.querySelector('button[type="submit"]');
    if(btn&&!btn.dataset.noLoading){setTimeout(function(){btn.disabled=true;btn.dataset.originalHtml=btn.innerHTML;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin"></i> Salvando...';},10);}
    setTimeout(function(){sub=false;if(btn&&btn.dataset.originalHtml){btn.disabled=false;btn.innerHTML=btn.dataset.originalHtml;delete btn.dataset.originalHtml;}},8000);
  });
});
</script>
@yield('scripts')
</body>
</html>
