<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<<<<<<< HEAD

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap"></noscript>

=======
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  corePlugins: { preflight: false },
  theme: {
    extend: {
      colors: {
        'red-tomato':   '#EC2D01',
        'saddle-brown': '#8B4513',
        'nugget-gold':  '#FAB269',
        'verde-folha':  '#3E5F3C',
        'preto-suave':  '#1C1C1C',
        'creme-claro':  '#F4E8D0',
      }
    }
  }
}
</script>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
<title>@yield('page-title', 'RestaurantePRO')</title>
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
<<<<<<< HEAD
  /* Cores base - inalteradas */
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD
=======

>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
  --bg:         #120D09;
  --bg2:        #1C1108;
  --bg3:        #241608;
  --border:     rgba(250,178,105,.13);
  --border-hv:  rgba(250,178,105,.3);
  --text:       #F4E8D0;
  --muted:      rgba(244,232,208,.42);
<<<<<<< HEAD

  /* Tokens de design melhorados */
  --sidebar:    268px;
  --radius:     12px;
  --radius-sm:  8px;
  --radius-lg:  16px;
  --shadow:     0 8px 32px rgba(0,0,0,.55);
  --shadow-lg:  0 24px 60px rgba(0,0,0,.7);
  --transition: all .2s cubic-bezier(.4,0,.2,1);
=======
  --sidebar:    260px;
  --radius:     10px;
  --shadow:     0 8px 32px rgba(0,0,0,.55);

>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD
  background-image:
    radial-gradient(ellipse 70% 50% at 0% 0%, rgba(139,69,19,.07) 0%, transparent 60%),
    radial-gradient(ellipse 50% 40% at 100% 100%, rgba(236,45,1,.05) 0%, transparent 55%);
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: rgba(139,69,19,.5); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: var(--brown); }
=======
}

::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--brown); border-radius: 4px; }
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== SIDEBAR ===== */
.sidebar {
  width: var(--sidebar);
<<<<<<< HEAD
  background: linear-gradient(180deg, #1A0F06 0%, #160C05 100%);
=======
  background: var(--bg2);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
  border-right: 1px solid var(--border);
  position: fixed; top: 0; left: 0; height: 100vh;
  display: flex; flex-direction: column;
  z-index: 100; overflow-y: auto;
  transition: transform .3s cubic-bezier(.4,0,.2,1);
<<<<<<< HEAD
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
=======
}

.sb-brand {
  padding: 22px 18px 18px;
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; gap: 14px; flex-shrink: 0;
}
.sb-logo {
<<<<<<< HEAD
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

/* Separadores de secao com linha decorativa */
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

=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
.nav-ic {
  width: 32px; height: 32px; border-radius: 7px;
  background: rgba(250,178,105,.06);
  display: flex; align-items: center; justify-content: center;
<<<<<<< HEAD
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
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== TOPBAR ===== */
.main {
  margin-left: var(--sidebar);
  width: calc(100% - var(--sidebar));
  display: flex; flex-direction: column; min-height: 100vh;
}
.topbar {
<<<<<<< HEAD
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
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
}
.topbar-actions { display: flex; align-items: center; gap: 10px; }

.btn-hamburger {
<<<<<<< HEAD
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
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== PANELS ===== */
.panel {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 22px; margin-bottom: 22px;
<<<<<<< HEAD
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
=======
}
.panel-header {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid var(--border);
}
.panel-title {
  font-family: var(--font-title); font-size: 14px; font-weight: 600;
  color: var(--cream); letter-spacing: 1.3px; text-transform: uppercase;
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
  display: flex; align-items: center; gap: 9px;
}

/* ===== STAT CARDS ===== */
.cards-grid {
  display: grid; gap: 16px;
  grid-template-columns: repeat(auto-fit, minmax(195px, 1fr));
<<<<<<< HEAD
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
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
}
.sc-val, .sc-value {
  font-family: var(--font-title); font-size: 30px; font-weight: 700;
  color: var(--cream); letter-spacing: -1px; line-height: 1.1; margin-bottom: 5px;
}
<<<<<<< HEAD
.sc-lbl, .sc-label { font-family: var(--font-body); font-size: 14.5px; color: var(--muted); font-style: italic; }
=======
.sc-lbl, .sc-label {
  font-family: var(--font-body); font-size: 15px; color: var(--muted); font-style: italic;
}
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== TABLES ===== */
.table-wrap {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); overflow: hidden; margin-bottom: 22px;
<<<<<<< HEAD
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
=======
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
table { width: 100%; border-collapse: collapse; }
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== BUTTONS ===== */
.btn {
  display: inline-flex; align-items: center; gap: 7px;
<<<<<<< HEAD
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
=======
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

/* ===== FORMS ===== */
.form-group { margin-bottom: 17px; }
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== MESAS ===== */
.mesas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
.mesa-card {
  background: var(--bg2); border: 1px solid var(--border);
  border-radius: var(--radius); padding: 20px 14px;
<<<<<<< HEAD
  text-align: center; cursor: pointer; transition: var(--transition);
=======
  text-align: center; cursor: pointer; transition: all .18s;
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
  position: relative; overflow: hidden;
  text-decoration: none; display: block;
}
.mesa-card::after {
  content: ''; position: absolute; bottom: 0; left: 0; right: 0;
<<<<<<< HEAD
  height: 3px; background: var(--mc, var(--muted)); transition: height .2s;
}
.mesa-card:hover { transform: translateY(-3px); border-color: var(--border-hv); box-shadow: 0 8px 24px rgba(0,0,0,.3); }
.mesa-card:hover::after { height: 4px; }
.mesa-card.disponivel { --mc: var(--green); }
.mesa-card.ocupada    { --mc: var(--red); }
.mesa-card.reservada  { --mc: var(--gold); }
.mc-num, .mc-number { font-family:var(--font-title); font-size:34px; font-weight:700; color:var(--cream); letter-spacing:-1px; line-height:1.1; }
.mc-seats { font-family:var(--font-body); font-size:13px; color:var(--muted); margin:6px 0 10px; font-style:italic; }
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

/* ===== KPI ===== */
.kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; margin-bottom: 22px; }
.kpi {
  background: var(--bg2); border: 1px solid var(--border);
<<<<<<< HEAD
  border-radius: var(--radius); padding: 18px 20px;
  position: relative; overflow: hidden; transition: var(--transition);
}
.kpi::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--kc,var(--red)); }
.kpi:hover { border-color:rgba(250,178,105,.22); transform:translateY(-2px); }
.kpi-val { font-family:var(--font-title); font-size:28px; font-weight:700; color:var(--cream); margin:8px 0 5px; letter-spacing:-1px; }
.kpi-lbl { font-family:var(--font-body); font-size:14.5px; color:var(--muted); font-style:italic; }

/* ===== DASHBOARD GRID ===== */
.dashboard-grid { display:grid; grid-template-columns:1.2fr 1fr; gap:24px; }
.dashboard-grid-main { grid-template-columns:minmax(0,1.2fr) minmax(320px,1fr); }
.dashboard-grid-even { grid-template-columns:repeat(2,minmax(0,1fr)); }

.stat-card-success { --card-color: var(--green); }
.stat-card-warning { --card-color: var(--gold); }
.stat-card-info { --card-color: var(--brown); }
.stat-card-danger { --card-color: var(--red); }

.sc-icon i,
.panel-title i,
.table-header h2 i,
.empty-state i {
  color: var(--card-color, var(--gold));
}

.sc-value-muted {
  font-size: 16px;
  font-weight: 500;
  color: var(--muted);
}

.sc-value-money {
  font-size: 22px;
}

.td-muted {
  color: var(--muted);
}

.td-small {
  font-size: 12px;
}

.td-danger {
  color: #fca5a5;
  font-weight: 700;
}

.clickable-row {
  cursor: pointer;
}

.unstyled-link,
.ready-order-link,
.action-card {
  color: inherit;
  text-decoration: none;
}

.dashboard-actions {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 16px;
  margin-top: 8px;
}

.action-card {
  --card-color: var(--red);
  display: flex;
  align-items: center;
  gap: 14px;
  min-height: 84px;
  padding: 18px 22px;
  background: var(--bg2);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  position: relative;
  overflow: hidden;
  transition: var(--transition);
}

.action-card::before {
  content: '';
  position: absolute;
  inset: 0 auto 0 0;
  width: 4px;
  background: var(--card-color);
}

.action-card:hover {
  transform: translateY(-3px);
  border-color: rgba(250,178,105,.24);
  box-shadow: var(--shadow-lg);
}

.action-card-success { --card-color: var(--green); }
.action-card-warning { --card-color: var(--gold); }
.action-card-info { --card-color: var(--brown); }

.action-card-body {
  flex: 1;
  min-width: 0;
}

.action-card-title {
  color: var(--cream);
  font-family: var(--font-title);
  font-size: 12px;
  font-weight: 800;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.action-card-arrow {
  color: var(--gold);
  opacity: .75;
}

.panel-accent-success {
  background: linear-gradient(180deg, rgba(62,95,60,.12), rgba(28,17,8,.82));
  border-color: rgba(62,95,60,.36);
}

.panel-accent-success .panel-title {
  color: var(--cream);
}

.panel-note {
  color: var(--muted);
  font-size: 12px;
}

.ready-orders-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 12px;
}

.ready-order-card {
  display: block;
  background: rgba(62,95,60,.12);
  border: 1px solid rgba(62,95,60,.28);
  border-radius: var(--radius);
  padding: 16px;
  transition: var(--transition);
}

.ready-order-link {
  display: block;
}

.ready-order-card:hover {
  background: rgba(62,95,60,.18);
  border-color: rgba(62,95,60,.42);
  transform: translateY(-2px);
}

.ready-order-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  margin-bottom: 8px;
}

.ready-order-code {
  color: var(--gold);
  font-family: 'Courier New', monospace;
  font-weight: 700;
}

.ready-order-table {
  color: var(--muted);
  font-size: 12px;
}

.ready-order-meta {
  color: rgba(244,232,208,.62);
  font-size: 13px;
  margin-bottom: 8px;
}

.ready-order-total {
  color: var(--cream);
  font-family: var(--font-title);
  font-weight: 800;
}

.ready-order-form {
  margin-top: 10px;
}

.ready-order-button {
  width: 100%;
  min-height: 34px;
  border: 1px solid rgba(62,95,60,.34);
  border-radius: var(--radius-sm);
  background: rgba(62,95,60,.24);
  color: var(--cream);
  cursor: pointer;
  font-family: var(--font-title);
  font-size: 10px;
  font-weight: 800;
  letter-spacing: .8px;
  text-transform: uppercase;
  transition: var(--transition);
}

.ready-order-button:hover {
  background: rgba(62,95,60,.34);
  border-color: rgba(250,178,105,.24);
}

.mesa-orders {
  color: var(--gold);
  font-family: var(--font-title);
  font-size: 10px;
  font-weight: 800;
  letter-spacing: .8px;
  margin-top: 2px;
  text-transform: uppercase;
}

.mesa-orders.is-closed {
  color: var(--red);
}

/* ===== EMPTY STATE ===== */
.empty-state { text-align:center; padding:56px 24px; color:var(--muted); }
.empty-state .es-icon { font-size:52px; display:block; margin-bottom:16px; opacity:.2; }
.empty-state i { display:block; font-size:42px; margin-bottom:14px; opacity:.32; }
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
=======
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

/* ===== MISC ===== */
.empty-state { text-align: center; padding: 52px 24px; color: var(--muted); }
.empty-state .es-icon { font-size: 48px; display: block; margin-bottom: 14px; opacity: .25; }
.empty-state p { font-family: var(--font-body); font-size: 17px; font-style: italic; }
hr, .divider { border: none; border-top: 1px solid var(--border); margin: 18px 0; }
.campo-erro { color: #fca5a5; font-size: 14px; margin-top: 5px; display: none; }

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
  .table-wrap { overflow-x: auto; }
  table { min-width: 600px; }
  .form-row { grid-template-columns: 1fr; }
  [style*="grid-template-columns:360px"] { display: block !important; }
  [style*="grid-template-columns:340px"] { display: block !important; }
  [style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
  .btn-topbar-sair span { display: none; }
  .btn-topbar-sair { padding: 8px 12px; }
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
}
@media (max-width: 480px) {
  .cards-grid { grid-template-columns: 1fr 1fr; }
  .mesas-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
  .table-header { flex-direction: column; align-items: flex-start; gap: 10px; }
<<<<<<< HEAD
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
  .dashboard-actions,
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

/* ===== FUTURISTIC RESTAURANTPRO THEME ===== */
:root {
  --bg: #0f0906;
  --bg2: rgba(28,17,8,.72);
  --bg3: rgba(42,24,10,.82);
  --text: #F4E8D0;
  --muted: rgba(244,232,208,.58);
  --border: rgba(250,178,105,.16);
  --border-hv: rgba(250,178,105,.38);
  --surface: rgba(28,17,8,.62);
  --surface-strong: rgba(38,22,9,.82);
  --surface-soft: rgba(250,178,105,.07);
  --glass: rgba(28,17,8,.54);
  --glass-strong: rgba(28,17,8,.78);
  --accent: var(--gold);
  --glow-red: 0 0 30px rgba(236,45,1,.28);
  --glow-gold: 0 0 34px rgba(250,178,105,.22);
  --shadow: 0 18px 46px rgba(0,0,0,.38);
  --shadow-lg: 0 28px 82px rgba(0,0,0,.56);
}

body {
  background:
    radial-gradient(circle at 18% -8%, rgba(236,45,1,.24), transparent 34rem),
    radial-gradient(circle at 86% 2%, rgba(250,178,105,.14), transparent 28rem),
    radial-gradient(circle at 76% 92%, rgba(139,69,19,.18), transparent 32rem),
    linear-gradient(135deg, #0d0705 0%, #140b07 42%, #1a0d06 100%);
}

body::before {
  content: '';
  position: fixed;
  inset: 0;
  z-index: -2;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(250,178,105,.035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(250,178,105,.035) 1px, transparent 1px);
  background-size: 42px 42px;
  mask-image: radial-gradient(circle at 50% 20%, #000 0%, transparent 72%);
}

body::after {
  content: '';
  position: fixed;
  inset: 0;
  z-index: -1;
  pointer-events: none;
  background: linear-gradient(180deg, rgba(255,255,255,.045), transparent 18%, rgba(0,0,0,.2));
}

.sidebar,
.topbar,
.panel,
.table-wrap,
.stat-card,
.mesa-card,
.kpi,
.modal-card,
.action-card,
.payment-card,
.ready-order-card,
.pay-card,
.pay-panel,
.pay-mesa-card,
[class*="card"],
[style*="background:rgba"],
[style*="background: rgba"] {
  backdrop-filter: blur(18px) saturate(1.25);
  -webkit-backdrop-filter: blur(18px) saturate(1.25);
}

.sidebar {
  background:
    linear-gradient(180deg, rgba(28,17,8,.82), rgba(13,7,5,.92)),
    rgba(18,13,9,.82);
  border-right-color: rgba(250,178,105,.18);
}

.sidebar::before {
  height: 1px;
  opacity: 1;
  background: linear-gradient(90deg, transparent, var(--red), var(--gold), transparent);
  box-shadow: var(--glow-gold);
}

.sb-logo,
.sb-avatar,
.nav-ic,
.sc-icon {
  background:
    linear-gradient(135deg, rgba(236,45,1,.28), rgba(250,178,105,.12)),
    rgba(250,178,105,.08);
  border: 1px solid rgba(250,178,105,.18);
  color: var(--gold);
}

.sb-logo {
  position: relative;
}

.sb-logo::after,
.stat-card::after,
.action-card::after {
  content: '';
  position: absolute;
  inset: 1px;
  border-radius: inherit;
  pointer-events: none;
  background: linear-gradient(135deg, rgba(255,255,255,.14), transparent 38%);
  opacity: .55;
}

.sidebar nav a {
  border: 1px solid transparent;
}

.sidebar nav a:hover,
.sidebar nav a.active {
  background:
    linear-gradient(90deg, rgba(236,45,1,.18), rgba(250,178,105,.07)),
    rgba(250,178,105,.045);
  border-color: rgba(250,178,105,.18);
}

.sidebar nav a.active {
  box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 12px 34px rgba(236,45,1,.16);
}

.topbar {
  background: linear-gradient(180deg, rgba(18,13,9,.82), rgba(18,13,9,.62));
  box-shadow: 0 12px 36px rgba(0,0,0,.22);
}

.topbar h1,
.panel-title,
.table-header h2,
.action-card-title {
  letter-spacing: .7px;
}

.content {
  position: relative;
}

.content::before {
  content: '';
  position: absolute;
  top: 0;
  left: 32px;
  right: 32px;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(250,178,105,.28), transparent);
  pointer-events: none;
}

.panel,
.table-wrap,
.stat-card,
.mesa-card,
.kpi,
.action-card {
  background:
    linear-gradient(145deg, rgba(255,255,255,.055), transparent 34%),
    var(--glass);
  border: 1px solid rgba(250,178,105,.16);
}

.panel:hover,
.table-wrap:hover,
.stat-card:hover,
.mesa-card:hover,
.kpi:hover,
.action-card:hover {
  border-color: rgba(250,178,105,.34);
  box-shadow: var(--shadow-lg), var(--glow-gold);
}

.stat-card {
  isolation: isolate;
}

.stat-card::before {
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--card-color, var(--gold)), transparent);
  box-shadow: 0 0 22px var(--card-color, var(--gold));
}

.sc-value,
.kpi-val {
  text-shadow: 0 0 24px rgba(250,178,105,.1);
}

.sc-badge,
.badge {
  background: rgba(250,178,105,.08);
  border-color: rgba(250,178,105,.18);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
}

.badge-success { background: rgba(62,95,60,.24); color: #a7f3d0; }
.badge-warning { background: rgba(250,178,105,.16); color: var(--gold); }
.badge-danger,
.badge-primary { background: rgba(236,45,1,.16); color: #fecaca; }
.badge-info,
.badge-purple { background: rgba(139,69,19,.22); color: #fed7aa; }

.btn,
.btn-sair,
.btn-topbar-sair,
.ready-order-button {
  border: 1px solid rgba(250,178,105,.18);
  background:
    linear-gradient(135deg, rgba(255,255,255,.08), transparent 42%),
    rgba(250,178,105,.075);
}

.btn-primary {
  background: linear-gradient(135deg, var(--red), var(--brown) 64%, var(--gold));
  box-shadow: 0 12px 32px rgba(236,45,1,.28), inset 0 1px 0 rgba(255,255,255,.18);
}

.btn-success {
  background: linear-gradient(135deg, rgba(62,95,60,.9), rgba(250,178,105,.18));
}

.btn-danger {
  background: linear-gradient(135deg, rgba(236,45,1,.72), rgba(139,69,19,.38));
}

.btn:hover,
.btn-sair:hover,
.btn-topbar-sair:hover,
.ready-order-button:hover {
  box-shadow: 0 14px 34px rgba(0,0,0,.26), var(--glow-gold);
}

.form-control,
.form-select,
input,
select,
textarea {
  border-color: rgba(250,178,105,.16);
  background: rgba(7,4,3,.28);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.045);
}

.form-control:focus,
.form-select:focus,
input:focus,
select:focus,
textarea:focus {
  border-color: rgba(250,178,105,.58);
  box-shadow: 0 0 0 4px rgba(250,178,105,.1), var(--glow-gold);
}

.table-header {
  background: linear-gradient(90deg, rgba(250,178,105,.07), transparent);
}

thead th {
  background: rgba(250,178,105,.055);
}

tbody tr {
  border-radius: var(--radius-sm);
}

tbody tr:hover {
  background: rgba(250,178,105,.075);
}

.modal-overlay {
  background: rgba(5,3,2,.72);
  backdrop-filter: blur(14px);
}

.modal-card,
#http-toast {
  background:
    linear-gradient(145deg, rgba(255,255,255,.065), transparent 34%),
    rgba(18,13,9,.86);
  border-color: rgba(250,178,105,.22);
}

.empty-state {
  background: radial-gradient(circle at center, rgba(250,178,105,.06), transparent 62%);
}

.empty-state i,
.empty-state .es-icon {
  filter: drop-shadow(0 0 18px rgba(250,178,105,.18));
}

.mesa-card::after {
  height: 2px;
  box-shadow: 0 0 18px var(--mc, var(--gold));
}

.payment-card,
.ready-order-card {
  background:
    linear-gradient(145deg, rgba(255,255,255,.055), transparent 42%),
    rgba(28,17,8,.56);
}

@media (prefers-reduced-motion: no-preference) {
  .panel,
  .table-wrap,
  .stat-card,
  .mesa-card,
  .kpi,
  .action-card,
  .payment-card,
  .ready-order-card {
    animation: uiFadeIn .35s ease both;
  }

  @keyframes uiFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: none; }
  }
}

@media (max-width: 768px) {
  .content::before {
    left: 16px;
    right: 16px;
  }

  .sidebar {
    background: rgba(18,13,9,.94);
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

/* ===== CLEAN PROFESSIONAL THEME OVERRIDE ===== */
:root {
  --bg: #12100e;
  --bg2: #1b1714;
  --bg3: #231d18;
  --text: #F4E8D0;
  --muted: rgba(244,232,208,.62);
  --border: rgba(244,232,208,.11);
  --border-hv: rgba(244,232,208,.2);
  --surface: #1b1714;
  --surface-strong: #211b17;
  --surface-soft: rgba(250,178,105,.06);
  --glass: #1b1714;
  --glass-strong: #211b17;
  --accent: #E9924A;
  --glow-red: none;
  --glow-gold: none;
  --radius: 10px;
  --radius-sm: 8px;
  --radius-lg: 14px;
  --shadow: 0 8px 22px rgba(0,0,0,.22);
  --shadow-lg: 0 14px 34px rgba(0,0,0,.28);
  --transition: background-color .16s ease, border-color .16s ease, color .16s ease, transform .16s ease;
  --font-body: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  --font-title: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

body {
  background: #12100e !important;
  background-image: none !important;
  font-size: 15px;
  line-height: 1.55;
}

body::before,
body::after,
.content::before,
.sidebar::before,
.sb-logo::after,
.stat-card::after,
.action-card::after {
  display: none !important;
  content: none !important;
}

.sidebar,
.topbar,
.panel,
.table-wrap,
.stat-card,
.mesa-card,
.kpi,
.modal-card,
.action-card,
.payment-card,
.ready-order-card,
.pay-card,
.pay-panel,
.pay-mesa-card,
[class*="card"],
[style*="background:rgba"],
[style*="background: rgba"] {
  backdrop-filter: none !important;
  -webkit-backdrop-filter: none !important;
}

.sidebar {
  background: #17130f !important;
  border-right: 1px solid var(--border);
  box-shadow: none;
}

body.sidebar-collapsed {
  --sidebar: 84px;
}

.sb-brand {
  padding: 18px 16px;
}

.sidebar-collapse-btn {
  width: 32px;
  height: 32px;
  display: inline-grid;
  place-items: center;
  margin-left: auto;
  border: 1px solid var(--border);
  border-radius: 8px;
  background: rgba(244,232,208,.04);
  color: var(--muted);
  cursor: pointer;
}

.sidebar-collapse-btn:hover {
  color: var(--text);
  border-color: var(--border-hv);
}

body.sidebar-collapsed .sb-brand > div:not(.sb-logo),
body.sidebar-collapsed .sb-user > div:not(.sb-avatar),
body.sidebar-collapsed .sb-section,
body.sidebar-collapsed .sidebar nav a:not(.active) > span,
body.sidebar-collapsed .sidebar nav a.active > span,
body.sidebar-collapsed .btn-sair span {
  display: none;
}

body.sidebar-collapsed .sb-brand,
body.sidebar-collapsed .sb-user,
body.sidebar-collapsed .sidebar nav a {
  justify-content: center;
}

body.sidebar-collapsed .sidebar-collapse-btn {
  position: absolute;
  right: 8px;
  top: 18px;
}

body.sidebar-collapsed .sidebar nav a {
  padding: 10px;
  font-size: 0;
}

body.sidebar-collapsed .sidebar nav a:hover {
  padding-left: 10px;
}

body.sidebar-collapsed .nav-ic,
body.sidebar-collapsed .btn-sair i {
  font-size: 16px;
}

body.sidebar-collapsed .btn-sair {
  font-size: 0;
  padding: 10px;
}

.sb-logo,
.sb-avatar,
.nav-ic,
.sc-icon {
  background: rgba(250,178,105,.08) !important;
  border: 1px solid var(--border);
  box-shadow: none !important;
  color: var(--accent);
}

.sb-logo:hover,
.sidebar nav a:hover .nav-ic {
  transform: none;
  box-shadow: none;
}

.sb-brand-name,
.panel-title,
.table-header h2,
.topbar h1,
.action-card-title {
  letter-spacing: .2px;
  text-transform: none;
}

.sb-brand-sub {
  color: var(--muted);
  font-style: normal;
}

.sb-user {
  background: #1b1714;
  border-color: var(--border);
  overflow: visible;
}

.sb-user::before {
  background: var(--accent);
}

.sb-section {
  letter-spacing: .8px;
}

.sb-section::after {
  background: var(--border);
}

.sidebar nav a {
  border: 1px solid transparent;
  color: var(--muted);
}

.sidebar nav a::before {
  display: none;
}

.sidebar nav a:hover {
  background: rgba(244,232,208,.05);
  color: var(--text);
  padding-left: 12px;
}

.sidebar nav a.active {
  background: rgba(250,178,105,.10) !important;
  border-color: rgba(250,178,105,.22);
  box-shadow: none !important;
  color: var(--text);
}

.topbar {
  background: #17130f !important;
  backdrop-filter: none !important;
  -webkit-backdrop-filter: none !important;
  box-shadow: none;
}

.topbar-actions {
  gap: 12px;
}

.quick-search {
  width: min(280px, 28vw);
  height: 38px;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 0 11px;
  border: 1px solid var(--border);
  border-radius: 8px;
  background: #151210;
  color: var(--muted);
}

.quick-search input {
  width: 100%;
  min-width: 0;
  height: 100%;
  border: 0 !important;
  padding: 0 !important;
  background: transparent !important;
  color: var(--text);
  font: 500 13px var(--font-body);
  box-shadow: none !important;
}

.quick-search input:focus {
  box-shadow: none !important;
}

.topbar-notification {
  width: 38px;
  height: 38px;
  display: inline-grid;
  place-items: center;
  border: 1px solid var(--border);
  border-radius: 8px;
  background: rgba(244,232,208,.04);
  color: var(--muted);
  cursor: pointer;
}

.topbar-notification:hover {
  border-color: var(--border-hv);
  color: var(--text);
}

.quick-menu {
  position: relative;
}

.quick-menu-btn {
  height: 38px;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 0 12px;
  background: rgba(244,232,208,.04);
  color: var(--muted);
  cursor: pointer;
  font: 700 12px var(--font-body);
}

.quick-menu-panel {
  position: absolute;
  top: calc(100% + 8px);
  right: 0;
  width: 220px;
  display: none;
  z-index: 80;
  padding: 8px;
  border: 1px solid var(--border);
  border-radius: 10px;
  background: #1b1714;
  box-shadow: var(--shadow-lg);
}

.quick-menu.open .quick-menu-panel {
  display: grid;
  gap: 4px;
}

.quick-menu-panel a {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 9px 10px;
  border-radius: 8px;
  color: var(--muted);
  text-decoration: none;
  font-size: 13px;
  font-weight: 700;
}

.quick-menu-panel a:hover {
  background: rgba(244,232,208,.06);
  color: var(--text);
}

.topbar-user {
  min-width: 120px;
  text-align: right;
}

.topbar-user-name {
  max-width: 180px;
  overflow: hidden;
  color: var(--text);
  font-size: 13px;
  font-weight: 700;
  line-height: 1.1;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.topbar-user-role {
  margin-top: 2px;
  color: var(--muted);
  font-size: 11px;
  line-height: 1.1;
}

.topbar .bc {
  color: var(--muted);
  font-style: normal;
}

.content {
  padding: 24px;
}

.panel,
.table-wrap,
.stat-card,
.mesa-card,
.kpi,
.action-card,
.payment-card,
.ready-order-card,
.pay-card,
.pay-panel,
.pay-mesa-card {
  background: var(--bg2) !important;
  border: 1px solid var(--border) !important;
  box-shadow: none !important;
}

.panel:hover,
.table-wrap:hover,
.stat-card:hover,
.mesa-card:hover,
.kpi:hover,
.action-card:hover,
.payment-card:hover,
.ready-order-card:hover,
.pay-card:hover,
.pay-panel:hover,
.pay-mesa-card:hover {
  transform: none !important;
  border-color: var(--border-hv) !important;
  box-shadow: none !important;
}

.panel {
  padding: 18px;
}

.panel-header,
.table-header {
  background: transparent !important;
  padding-bottom: 12px;
}

.cards-grid {
  gap: 12px;
  margin-bottom: 20px;
}

.stat-card {
  padding: 16px;
}

.stat-card::before {
  height: 3px;
  background: var(--card-color, var(--accent)) !important;
  box-shadow: none !important;
}

.sc-value,
.kpi-val {
  text-shadow: none !important;
  font-size: 26px;
}

.sc-label,
.sc-lbl {
  font-style: normal;
}

.sc-badge,
.badge {
  box-shadow: none !important;
  border-radius: 999px;
}

.btn,
.btn-sair,
.btn-topbar-sair,
.ready-order-button {
  background: rgba(244,232,208,.06) !important;
  border: 1px solid var(--border) !important;
  box-shadow: none !important;
  border-radius: 8px;
  letter-spacing: .2px;
  text-transform: none;
}

.btn:hover,
.btn-sair:hover,
.btn-topbar-sair:hover,
.ready-order-button:hover {
  transform: none !important;
  box-shadow: none !important;
  background: rgba(244,232,208,.1) !important;
}

.btn-primary,
.toast-btn-primary {
  background: var(--red) !important;
  border-color: var(--red) !important;
  color: #fff !important;
}

.btn-primary:hover,
.toast-btn-primary:hover {
  background: var(--red-dark) !important;
  border-color: var(--red-dark) !important;
}

.btn-success {
  background: rgba(62,95,60,.22) !important;
  border-color: rgba(62,95,60,.35) !important;
  color: #a7f3d0;
}

.btn-danger,
.btn-sair,
.btn-topbar-sair {
  background: rgba(236,45,1,.10) !important;
  border-color: rgba(236,45,1,.24) !important;
  color: #fecaca;
}

.btn-warning {
  background: rgba(250,178,105,.12) !important;
  border-color: rgba(250,178,105,.26) !important;
  color: var(--gold);
}

.form-control,
.form-select,
input,
select,
textarea {
  background: #151210 !important;
  border: 1px solid var(--border) !important;
  box-shadow: none !important;
  border-radius: 8px !important;
}

.form-control:focus,
.form-select:focus,
input:focus,
select:focus,
textarea:focus {
  border-color: rgba(250,178,105,.45) !important;
  box-shadow: 0 0 0 3px rgba(250,178,105,.08) !important;
}

thead th {
  background: #181410 !important;
  color: rgba(244,232,208,.72);
  letter-spacing: .3px;
  position: sticky;
  top: 0;
  z-index: 2;
}

tbody td {
  border-bottom-color: rgba(244,232,208,.07);
}

tbody tr:nth-child(even) {
  background: rgba(244,232,208,.018);
}

tbody tr:hover {
  background: rgba(244,232,208,.045) !important;
}

.modal-overlay {
  background: rgba(0,0,0,.55) !important;
  backdrop-filter: none !important;
}

.modal-card,
#http-toast {
  background: #1b1714 !important;
  border: 1px solid var(--border) !important;
  box-shadow: var(--shadow-lg) !important;
}

.command-palette {
  position: fixed;
  inset: 0;
  z-index: 10000;
  display: none;
  align-items: flex-start;
  justify-content: center;
  padding: 9vh 18px 18px;
  background: rgba(0,0,0,.55);
}

.command-palette.open {
  display: flex;
}

.command-box {
  width: min(640px, 100%);
  overflow: hidden;
  border: 1px solid var(--border);
  border-radius: 14px;
  background: #1b1714;
  box-shadow: var(--shadow-lg);
}

.command-search {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 16px;
  border-bottom: 1px solid var(--border);
}

.command-search input {
  width: 100%;
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  color: var(--text);
  font: 700 15px var(--font-body);
  padding: 0 !important;
}

.command-results {
  max-height: 360px;
  overflow-y: auto;
  padding: 8px;
}

.command-item {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  padding: 11px 12px;
  border: 0;
  border-radius: 9px;
  background: transparent;
  color: var(--text);
  cursor: pointer;
  text-align: left;
}

.command-item:hover,
.command-item.active {
  background: rgba(250,178,105,.10);
}

.command-item i {
  width: 30px;
  height: 30px;
  display: grid;
  place-items: center;
  border: 1px solid var(--border);
  border-radius: 8px;
  color: var(--accent);
}

.command-item span {
  display: block;
  color: var(--muted);
  font-size: 11px;
  margin-top: 2px;
}

.flash-toast-source {
  display: none !important;
}

.mobile-bottom-nav {
  display: none;
}

.empty-state {
  background: var(--bg2) !important;
}

.empty-state i,
.empty-state .es-icon {
  filter: none !important;
}

.mesa-card::after {
  box-shadow: none !important;
}

@media (prefers-reduced-motion: no-preference) {
  .panel,
  .table-wrap,
  .stat-card,
  .mesa-card,
  .kpi,
  .action-card,
  .payment-card,
  .ready-order-card {
    animation: none !important;
  }
}

@media (max-width: 980px) {
  .quick-search,
  .topbar-user,
  .topbar-notification,
  .quick-menu {
    display: none;
  }

  body.sidebar-collapsed {
    --sidebar: 268px;
  }
}

@media (max-width: 768px) {
  body {
    display: block;
    padding-bottom: calc(78px + env(safe-area-inset-bottom));
    background-image: none;
  }

  .sidebar {
    display: none;
  }

  .sidebar-overlay {
    display: none !important;
  }

  .main {
    margin-left: 0 !important;
    width: 100% !important;
  }

  .topbar {
    height: auto;
    min-height: 58px;
    padding: 10px 14px;
    align-items: center;
  }

  .btn-hamburger,
  .topbar-divider {
    display: none !important;
  }

  .btn-topbar-sair {
    width: 44px;
    min-width: 44px;
    height: 44px;
    min-height: 44px;
    display: inline-flex !important;
    justify-content: center;
    padding: 0 !important;
    border-radius: 12px;
  }

  .btn-topbar-sair span {
    display: none !important;
  }

  .topbar h1 {
    max-width: 64vw;
    overflow: hidden;
    font-size: 13px;
    letter-spacing: .5px;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .topbar .bc {
    max-width: 64vw;
    overflow: hidden;
    font-size: 12px;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .topbar-clock {
    display: inline-flex;
    min-width: 50px;
    justify-content: flex-end;
    font-size: 12px;
  }

  .content {
    padding: 14px 12px 18px !important;
  }

  .panel {
    padding: 14px !important;
    margin-bottom: 14px;
    border-radius: 12px;
  }

  .panel-header,
  .table-header {
    align-items: flex-start;
    gap: 10px;
    padding: 0 0 12px !important;
    flex-direction: column;
  }

  .cards-grid,
  .kpi-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    gap: 10px;
    margin-bottom: 14px;
  }

  .stat-card,
  .kpi {
    padding: 13px !important;
    border-radius: 12px;
  }

  .sc-value,
  .sc-val,
  .kpi-val {
    font-size: 23px !important;
  }

  .btn,
  .form-control,
  .form-select,
  input,
  select,
  textarea {
    min-height: 48px;
    font-size: 16px !important;
  }

  .btn {
    justify-content: center;
    padding: 12px 14px;
  }

  .btn-sm,
  .btn-icon {
    min-height: 44px;
  }

  .table-wrap {
    border: 0;
    background: transparent;
    overflow: visible;
  }

  .table-wrap table {
    min-width: 0;
  }

  .table-wrap thead {
    display: none;
  }

  .table-wrap tbody,
  .table-wrap tr,
  .table-wrap td {
    display: block;
    width: 100%;
  }

  .table-wrap tr {
    margin-bottom: 10px;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: var(--bg2);
  }

  .table-wrap td {
    padding: 6px 0;
    border: 0;
  }

  .modal-card {
    width: 100%;
    max-height: calc(100vh - 24px);
    overflow-y: auto;
    border-radius: 14px;
  }

  #http-toast {
    left: 12px;
    right: 12px;
    top: auto;
    bottom: calc(86px + env(safe-area-inset-bottom));
    width: auto;
  }

  .command-palette {
    padding: 12px;
    align-items: flex-start;
  }

  .command-box {
    margin-top: 48px;
  }

  .mobile-bottom-nav {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 90;
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 2px;
    padding: 7px 8px calc(7px + env(safe-area-inset-bottom));
    border-top: 1px solid var(--border);
    background: #17110d;
    box-shadow: 0 -8px 24px rgba(0,0,0,.36);
  }

  .mobile-bottom-nav a,
  .mobile-bottom-nav button {
    min-width: 0;
    min-height: 56px;
    display: grid;
    place-items: center;
    gap: 3px;
    border: 0;
    border-radius: 10px;
    background: transparent;
    color: rgba(244,232,208,.66);
    text-decoration: none;
    font: 800 11px var(--font-body);
    cursor: pointer;
  }

  .mobile-bottom-nav i {
    font-size: 18px;
  }

  .mobile-bottom-nav .active {
    background: rgba(236,45,1,.14);
    color: #fff;
  }
}

@media (max-width: 430px) {
  .cards-grid,
  .kpi-grid {
    grid-template-columns: 1fr 1fr !important;
  }

  .sc-label,
  .sc-lbl {
    font-size: 12px;
  }
}

* {
  scroll-behavior: auto !important;
}

.currency-input-shell {
  display: grid;
  grid-template-columns: auto minmax(0, 1fr);
  align-items: stretch;
  width: 100%;
  background: var(--input-bg, #120d09);
  border: 1px solid var(--border, rgba(255,255,255,.12));
  border-radius: 10px;
  overflow: hidden;
  transition: border-color .18s ease, box-shadow .18s ease;
}

.currency-input-shell:focus-within {
  border-color: var(--accent, #ff7a1a);
  box-shadow: 0 0 0 3px rgba(255, 122, 26, .10);
}

.currency-input-prefix {
  min-width: 48px;
  display: grid;
  place-items: center;
  border-right: 1px solid var(--border, rgba(255,255,255,.12));
  color: var(--text, #fff);
  font-weight: 800;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
}

.currency-input-shell > input {
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  min-width: 0;
}

.guest-layout .main {
  margin-left: 0;
  width: 100%;
}

.guest-layout .topbar {
  display: none;
}
</style>
@yield('styles')
</head>
<body class="{{ Auth::check() ? 'auth-layout' : 'guest-layout' }}">

@php
  $authUser = Auth::user();
  $authRole = $authUser?->role;
  $authName = $authUser?->name ?? '';
  $rl = ['gerente'=>'Gerente','garcom'=>'Garcom','chef'=>'Chef','caixa'=>'Caixa'];
@endphp

<div id="http-toast" role="alert" aria-live="assertive">
  <span class="toast-icon" id="toast-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
  <div class="toast-body">
    <div class="toast-title" id="toast-title">Erro</div>
    <div class="toast-msg" id="toast-msg">Algo deu errado.</div>
    <div class="toast-action" id="toast-action"></div>
  </div>
  <button class="toast-close" onclick="fecharToast()" aria-label="Fechar">&times;</button>
</div>

<div class="command-palette" id="command-palette" aria-hidden="true">
  <div class="command-box" role="dialog" aria-modal="true" aria-labelledby="command-title">
    <div class="command-search">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="search" id="command-input" placeholder="Buscar mesas, pedidos, caixa, estoque, relatorios..." autocomplete="off">
    </div>
    <div class="command-results" id="command-results" aria-label="Resultados da busca"></div>
  </div>
</div>

<div class="modal-overlay" id="modal-confirm" role="dialog" aria-modal="true" aria-labelledby="modal-title">
  <div class="modal-card">
    <h3 id="modal-title"><i class="fa-solid fa-triangle-exclamation"></i> Confirmar Acao</h3>
    <p id="modal-msg">Confirmar esta acao?</p>
    <div class="modal-actions">
      <button class="btn btn-danger" onclick="confirmarModal()">Confirmar</button>
      <button class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
    </div>
  </div>
</div>

@auth
=======
  .topbar h1 { font-size: 15px; }
}
</style>
@yield('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
    // MELHORIA 5: Proteção contra 404 em recarregamento
    // Se vier erro de sessão expirada, redirecionar para login
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) {
            // Página veio do cache (back-forward cache) - verificar sessão
            fetch('/dashboard', { method: 'HEAD', credentials: 'same-origin' })
                .then(r => { if (r.status === 401 || r.url.includes('/login')) window.location.href = '/login'; })
                .catch(() => {});
        }
    });
    </script>
</head>
<body>

>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sb-brand">
<<<<<<< HEAD
    <div class="sb-logo"><i class="fa-solid fa-utensils"></i></div>
    <div>
      <div class="sb-brand-name">RestaurantePRO</div>
      <div class="sb-brand-sub">Sistema de Gestao</div>
    </div>
    <button type="button" class="sidebar-collapse-btn" id="sidebar-collapse-btn" aria-label="Recolher menu">
      <i class="fa-solid fa-angles-left"></i>
    </button>
  </div>

  <div class="sb-user">
    <div class="sb-avatar">{{ strtoupper(substr($authName,0,1)) }}</div>
    <div style="min-width:0">
      <div class="sb-uname">{{ $authName }}</div>
      <div class="sb-urole">
        {{ $rl[$authRole] ?? $authRole }}
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
      </div>
    </div>
  </div>

  <nav id="sidebar-nav">
    <div class="sb-section">Principal</div>
    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
<<<<<<< HEAD
      <div class="nav-ic"><i class="fa-solid fa-house"></i></div> Inicio
    </a>
    <a href="{{ route('dashboard.pedidos') }}" class="{{ request()->routeIs('dashboard.pedidos','orders.show') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-receipt"></i></div> Pedidos
    </a>

    @if(in_array($authRole,['gerente','garcom']))
    <div class="sb-section">Salao</div>
    <a href="{{ route('mesas.index') }}" class="{{ request()->routeIs('mesas.*') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-chair"></i></div> Mesas
    </a>
    @endif

    @if($authRole === 'garcom')
    <a href="{{ route('orders.create') }}" class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-plus"></i></div> Novo Pedido
    </a>
    @endif

    @if(in_array($authRole, ['chef','gerente']))
    <div class="sb-section">Cozinha</div>
    <a href="{{ route('chef.preparo') }}" class="{{ request()->routeIs('chef.preparo') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-fire-burner"></i></div> Preparo
    </a>
    <a href="{{ route('chef.estoque') }}" class="{{ request()->routeIs('chef.estoque') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-boxes-stacked"></i></div> Estoque
    </a>
    @endif

    @if(in_array($authRole,['caixa','gerente']))
    <div class="sb-section">Financeiro</div>
    <a href="{{ route('caixa.pagar-mesa') }}" class="{{ request()->routeIs('caixa.*') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-cash-register"></i></div> Caixa
    </a>
    <a href="{{ route('caixa.diaria') }}" class="{{ request()->routeIs('caixa.diaria') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-clipboard-list"></i></div> Diaria
    </a>
    @endif

    @if($authRole === 'gerente')
    <div class="sb-section">Cadastros</div>
    <a href="{{ route('gerenciar.mesas') }}" class="{{ request()->routeIs('gerenciar.mesas') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-chair"></i></div> Mesas
    </a>
    <a href="{{ route('gerenciar.cardapio') }}" class="{{ request()->routeIs('gerenciar.cardapio*') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-utensils"></i></div> Cardapio
    </a>
    <a href="{{ route('gerenciar.funcionarios') }}" class="{{ request()->routeIs('gerenciar.funcionarios') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-users"></i></div> Funcionarios
    </a>
    <a href="{{ route('gerenciar.produtos') }}" class="{{ request()->routeIs('gerenciar.produtos*') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-box"></i></div> Produtos
    </a>

    <div class="sb-section">Relatorios</div>
    <a href="{{ route('gestao.relatorios') }}" class="{{ request()->routeIs('gestao.relatorios') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-chart-pie"></i></div> Gestao
    </a>
    <a href="{{ route('dashboard.relatorios') }}" class="{{ request()->routeIs('dashboard.relatorios') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-file-lines"></i></div> Periodo
    </a>
    <a href="{{ route('dashboard.vendas') }}" class="{{ request()->routeIs('dashboard.vendas') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-chart-line"></i></div> Vendas
    </a>

    <div class="sb-section">Estoque</div>
    <a href="{{ route('controle.estoque') }}" class="{{ request()->routeIs('controle.estoque*') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-arrows-rotate"></i></div> Controle
    </a>
    <a href="{{ route('dashboard.estoque') }}" class="{{ request()->routeIs('dashboard.estoque') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-warehouse"></i></div> Inventario
    </a>
    <a href="{{ route('compras.index') }}" class="{{ request()->routeIs('compras.*') ? 'active' : '' }}">
      <div class="nav-ic"><i class="fa-solid fa-cart-shopping"></i></div> Compras
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    </a>
    @endif
  </nav>

  <div class="sb-footer">
    <form method="POST" action="{{ route('logout') }}">@csrf
<<<<<<< HEAD
      <button type="submit" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair do Sistema</button>
=======
      <button type="submit" class="btn-sair">🚪 Sair do Sistema</button>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    </form>
  </div>
</aside>

<<<<<<< HEAD
@php
  $mobileEntregasCount = in_array($authRole, ['garcom','gerente'])
    ? \App\Models\Order::where('status', 'pronto_entrega')->count()
    : 0;
@endphp
<nav class="mobile-bottom-nav" aria-label="Navegacao principal mobile">
  @if(in_array($authRole, ['garcom','gerente']))
    <a href="{{ route('mesas.index') }}" class="{{ request()->routeIs('mesas.*') ? 'active' : '' }}">
      <i class="fa-solid fa-chair"></i><span>Mesas</span>
    </a>
    <a href="{{ route('orders.create') }}" class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
      <i class="fa-solid fa-plus"></i><span>Pedido</span>
    </a>
    <a href="{{ route('dashboard.pedidos') }}" class="{{ request()->routeIs('dashboard.pedidos','orders.show') ? 'active' : '' }}">
      <i class="fa-solid fa-bell-concierge"></i><span>Entregas ({{ $mobileEntregasCount }})</span>
    </a>
    <a href="{{ route('mesas.index') }}" class="{{ request()->routeIs('mesas.conta') ? 'active' : '' }}">
      <i class="fa-solid fa-receipt"></i><span>Conta</span>
    </a>
    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
      <i class="fa-solid fa-user"></i><span>Perfil</span>
    </a>
  @else
    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i><span>Inicio</span>
    </a>
    <a href="{{ route('dashboard.pedidos') }}" class="{{ request()->routeIs('dashboard.pedidos','orders.*') ? 'active' : '' }}">
      <i class="fa-solid fa-receipt"></i><span>Pedidos</span>
    </a>
    @if(in_array($authRole, ['chef','gerente']))
    <a href="{{ route('chef.preparo') }}" class="{{ request()->routeIs('chef.preparo') ? 'active' : '' }}">
      <i class="fa-solid fa-fire-burner"></i><span>Cozinha</span>
    </a>
    @endif
    @if(in_array($authRole, ['caixa','gerente']))
    <a href="{{ route('caixa.pagar-mesa') }}" class="{{ request()->routeIs('caixa.*') ? 'active' : '' }}">
      <i class="fa-solid fa-cash-register"></i><span>Caixa</span>
    </a>
    @endif
    <button type="button" onclick="abrirCommandPalette()" aria-label="Abrir busca">
      <i class="fa-solid fa-magnifying-glass"></i><span>Buscar</span>
    </button>
  @endif
</nav>
@endauth

<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()" aria-label="Abrir menu"><i class="fa-solid fa-bars"></i></button>
      <div>
        <h1>@yield('page-title','Dashboard')</h1>
        <div class="bc">@yield('breadcrumb','Sistema de Gestao')</div>
      </div>
    </div>
    @auth
    <div class="topbar-actions">
      <div class="quick-search" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" id="quick-search-input" placeholder="Pesquisar modulo (Ctrl+K)">
      </div>
      <button type="button" class="topbar-notification" aria-label="Notificacoes">
        <i class="fa-solid fa-bell"></i>
      </button>
      <div class="quick-menu" id="quick-menu">
        <button type="button" class="quick-menu-btn" onclick="toggleQuickMenu(event)">
          <i class="fa-solid fa-bolt"></i> Acoes
        </button>
        <div class="quick-menu-panel">
          @if(in_array($authRole,['gerente','garcom']))
          <a href="{{ route('mesas.index') }}"><i class="fa-solid fa-chair"></i> Abrir mesa</a>
          <a href="{{ route('orders.create') }}"><i class="fa-solid fa-plus"></i> Novo pedido</a>
          @endif
          @if(in_array($authRole,['caixa','gerente']))
          <a href="{{ route('caixa.pagar-mesa') }}"><i class="fa-solid fa-cash-register"></i> Fechar conta</a>
          @endif
          @if(in_array($authRole,['chef','gerente']))
          <a href="{{ route('chef.estoque') }}"><i class="fa-solid fa-boxes-stacked"></i> Consultar estoque</a>
          @endif
        </div>
      </div>
      <div class="topbar-user">
        <div class="topbar-user-name">{{ $authName }}</div>
        <div class="topbar-user-role">{{ $rl[$authRole] ?? $authRole }}</div>
      </div>
      <span class="topbar-clock" id="topbar-clock"></span>
      <div class="topbar-divider"></div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf
        <button type="submit" class="btn-topbar-sair"><i class="fa-solid fa-right-from-bracket"></i> <span>Sair</span></button>
      </form>
    </div>
    @endauth
=======
<div class="main">
  <div class="topbar">
    <div style="display:flex;align-items:center;gap:14px">
      <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()">☰</button>
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
  </div>

  <div class="content">
    @if(session('success'))
<<<<<<< HEAD
    <div class="alert alert-success flash-toast-source" role="alert" data-toast-type="success">
      <i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span>
      <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error flash-toast-source" role="alert" data-toast-type="error">
      <i class="fa-solid fa-circle-xmark"></i> <span>{{ session('error') }}</span>
      <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">&times;</button>
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning flash-toast-source" role="alert" data-toast-type="warning">
      <i class="fa-solid fa-triangle-exclamation"></i> <span>{{ session('warning') }}</span>
      <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">&times;</button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-error flash-toast-source" role="alert" data-toast-type="error">
      <i class="fa-solid fa-circle-xmark"></i> <span>{{ $errors->first() }}</span>
      <button class="cls" onclick="this.parentElement.remove()" aria-label="Fechar">&times;</button>
=======
    <div class="alert alert-success">
      ✅ <span>{{ session('success') }}</span>
      <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
      ❌ <span>{{ session('error') }}</span>
      <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">
      ❌ <span>{{ $errors->first() }}</span>
      <button class="cls" onclick="this.parentElement.remove()">×</button>
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    </div>
    @endif

    @yield('content')
  </div>
</div>

<script>
<<<<<<< HEAD
/* === SIDEBAR === */
function toggleSidebar(){
  var sb=document.getElementById('sidebar'), ov=document.getElementById('sidebar-overlay');
  sb.classList.toggle('open'); ov.classList.toggle('open');
  document.body.style.overflow=sb.classList.contains('open')?'hidden':'';
}

function toggleSidebarCollapse(){
  if(window.innerWidth<=1024){toggleSidebar();return;}
  document.body.classList.toggle('sidebar-collapsed');
  var collapsed=document.body.classList.contains('sidebar-collapsed');
  localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
  var icon=document.querySelector('#sidebar-collapse-btn i');
  if(icon) icon.className=collapsed ? 'fa-solid fa-angles-right' : 'fa-solid fa-angles-left';
}

function toggleQuickMenu(event){
  if(event) event.stopPropagation();
  document.getElementById('quick-menu')?.classList.toggle('open');
}

document.addEventListener('click',function(e){
  var menu=document.getElementById('quick-menu');
  if(menu && !menu.contains(e.target)) menu.classList.remove('open');
});

document.getElementById('sidebar-collapse-btn')?.addEventListener('click', toggleSidebarCollapse);

if(localStorage.getItem('sidebar-collapsed')==='1' && window.innerWidth>1024){
  document.body.classList.add('sidebar-collapsed');
  var collapseIcon=document.querySelector('#sidebar-collapse-btn i');
  if(collapseIcon) collapseIcon.className='fa-solid fa-angles-right';
}

document.querySelectorAll('#sidebar-nav a').forEach(function(a){
  a.addEventListener('click',function(){ if(window.innerWidth<=1024){ document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebar-overlay').classList.remove('open'); document.body.style.overflow=''; } });
});
(function(){ var nav=document.getElementById('sidebar'); if(!nav)return; var s=sessionStorage.getItem('sb-scroll'); if(s)nav.scrollTop=parseInt(s); nav.addEventListener('scroll',function(){sessionStorage.setItem('sb-scroll',nav.scrollTop);}); })();

/* === RELOGIO === */
(function(){
  var el=document.getElementById('topbar-clock'); if(!el)return;
  function t(){ var d=new Date(); el.textContent=String(d.getHours()).padStart(2,'0')+':'+String(d.getMinutes()).padStart(2,'0'); }
  t(); setInterval(t,30000);
})();

/* === AUTO-DISMISS FLASH (6s) === */
setTimeout(function(){
  document.querySelectorAll('.alert:not(.flash-toast-source)').forEach(function(el){
    el.style.transition='opacity .5s, transform .5s';
    el.style.opacity='0'; el.style.transform='translateY(-6px)';
    setTimeout(function(){ if(el.parentNode)el.remove(); },500);
  });
},6000);

/* === MODAL === */
var _mc=null;
function confirmar(msg,cb,titulo){ document.getElementById('modal-msg').textContent=msg||'Confirmar?'; document.getElementById('modal-title').textContent=titulo||'Confirmar Acao'; _mc=cb; document.getElementById('modal-confirm').classList.add('open'); }
function confirmarModal(){ var cb=_mc; fecharModal(); if(typeof cb==='function')cb(); }
function fecharModal(){ document.getElementById('modal-confirm').classList.remove('open'); _mc=null; }
document.addEventListener('keydown',function(e){ if(e.key==='Escape')fecharModal(); });

/* === TOAST === */
var _tt=null;
function mostrarToast(o){
  var t=document.getElementById('http-toast');
  document.getElementById('toast-icon').innerHTML=o.icone||'<i class="fa-solid fa-triangle-exclamation"></i>';
  document.getElementById('toast-title').textContent=o.titulo||'Erro';
  document.getElementById('toast-msg').textContent=o.msg||'Algo deu errado.';
  var a=document.getElementById('toast-action'); a.innerHTML='';
  if(o.botoes)o.botoes.forEach(function(b){ var btn=document.createElement('button'); btn.className='toast-btn '+(b.primario?'toast-btn-primary':'toast-btn-secondary'); btn.textContent=b.label; btn.onclick=function(){fecharToast();if(typeof b.acao==='function')b.acao();}; a.appendChild(btn); });
  t.classList.add('show'); if(_tt)clearTimeout(_tt); _tt=setTimeout(fecharToast,o.duracao||8000);
}
function fecharToast(){ document.getElementById('http-toast').classList.remove('show'); if(_tt){clearTimeout(_tt);_tt=null;} }
function _ms(s){ return ({419:{icone:'<i class="fa-solid fa-clock"></i>',titulo:'Sessao Expirada',msg:'Sua sessao expirou por inatividade.'},401:{icone:'<i class="fa-solid fa-lock"></i>',titulo:'Nao Autenticado',msg:'Voce precisa fazer login.'},403:{icone:'<i class="fa-solid fa-ban"></i>',titulo:'Acesso Negado',msg:'Sem permissao para esta acao.'},500:{icone:'<i class="fa-solid fa-server"></i>',titulo:'Erro Interno',msg:'Erro no servidor. Tente novamente.'},502:{icone:'<i class="fa-solid fa-globe"></i>',titulo:'Servidor Indisponivel',msg:'Fora do ar temporariamente.'},503:{icone:'<i class="fa-solid fa-screwdriver-wrench"></i>',titulo:'Em Manutencao',msg:'Tente mais tarde.'},429:{icone:'<i class="fa-solid fa-hourglass-half"></i>',titulo:'Muitas Requisicoes',msg:'Aguarde antes de tentar novamente.'}})[s]||{icone:'<i class="fa-solid fa-triangle-exclamation"></i>',titulo:'Erro '+s,msg:'Erro inesperado.'}; }

document.querySelectorAll('.flash-toast-source').forEach(function(el){
  var msg=(el.querySelector('span')||el).textContent.trim();
  var type=el.dataset.toastType || 'success';
  var isError=type==='error';
  var isWarning=type==='warning';
  mostrarToast({
    icone: isError ? '<i class="fa-solid fa-circle-xmark"></i>' : (isWarning ? '<i class="fa-solid fa-triangle-exclamation"></i>' : '<i class="fa-solid fa-circle-check"></i>'),
    titulo: isError ? 'Atencao' : (isWarning ? 'Aviso' : 'Sucesso'),
    msg: msg,
    duracao: isError ? 7000 : 4500
  });
  el.remove();
});

document.querySelector('.topbar-notification')?.addEventListener('click', function(){
  mostrarToast({
    icone: '<i class="fa-solid fa-bell"></i>',
    titulo: 'Notificacoes',
    msg: 'Nenhuma notificacao nova no momento.',
    duracao: 3500
  });
});

/* === INTERCEPTOR FETCH === */
(function(){
  var orig=window.fetch;
  window.fetch=function(input,init){
    init=init||{};
    var method=String(init.method || (input && input.method) || 'GET').toUpperCase();
    if(!['GET','HEAD','OPTIONS'].includes(method)){
      var token=window._csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      init.headers=new Headers(init.headers || (input && input.headers) || {});
      if(token && !init.headers.has('X-CSRF-TOKEN')) init.headers.set('X-CSRF-TOKEN', token);
      init.credentials=init.credentials || 'same-origin';
    }
    return orig.call(this,input,init).then(function(r){
      if(r.status===419){mostrarToast({icone:'<i class="fa-solid fa-clock"></i>',titulo:'Sessao Expirada',msg:'Recarregue para continuar.',botoes:[{label:'Recarregar',primario:true,acao:function(){location.reload();}},{label:'Fechar',primario:false}]});return r;}
      if(r.status===401){mostrarToast({icone:'<i class="fa-solid fa-lock"></i>',titulo:'Sessao Encerrada',msg:'Redirecionando para login...',botoes:[{label:'Ir para Login',primario:true,acao:function(){location.href='/login';}}],duracao:4000});setTimeout(function(){location.href='/login';},4000);return r;}
      if(r.status>=500){var i=_ms(r.status);mostrarToast({icone:i.icone,titulo:i.titulo,msg:i.msg,botoes:[{label:'Tentar novamente',primario:true,acao:function(){location.reload();}},{label:'Fechar',primario:false}]});return r;}
      if(r.status===429){mostrarToast({icone:'<i class="fa-solid fa-hourglass-half"></i>',titulo:'Muitas Requisicoes',msg:'Aguarde um momento.',botoes:[{label:'Fechar',primario:false}]});return r;}
      return r;
    }).catch(function(err){mostrarToast({icone:'<i class="fa-solid fa-wifi"></i>',titulo:'Sem Conexao',msg:'Verifique sua internet.',botoes:[{label:'Tentar novamente',primario:true,acao:function(){location.reload();}},{label:'Fechar',primario:false}]});throw err;});
  };
})();
/* === PAGESHOW === */
window.addEventListener('pageshow',function(e){
  if(!e.persisted)return;
  fetch('/dashboard',{method:'HEAD',credentials:'same-origin',cache:'no-store'}).then(function(r){ if(r.status===401||r.url.includes('/login'))location.href='/login'; }).catch(function(){});
});

/* === CSRF REFRESH (15min) === */
setInterval(function(){
  fetch(@json(route('csrf-token', [], false)),{credentials:'same-origin',cache:'no-store'}).then(function(r){return r.ok?r.json():null;}).then(function(d){
    if(!d||!d.token)return;
    document.querySelectorAll('input[name="_token"]').forEach(function(i){i.value=d.token;});
    var m=document.querySelector('meta[name="csrf-token"]'); if(m)m.setAttribute('content',d.token);
    window._csrfToken=d.token;
  }).catch(function(){});
},15*60*1000);
document.addEventListener('DOMContentLoaded',function(){ var m=document.querySelector('meta[name="csrf-token"]'); if(m)window._csrfToken=m.getAttribute('content'); });

/* === PESQUISA RAPIDA DE MODULOS === */
(function(){
  var input=document.getElementById('quick-search-input');
  if(!input)return;
  input.addEventListener('focus', abrirCommandPalette);
  input.addEventListener('keydown',function(e){ if(e.key==='Enter') abrirCommandPalette(); });
})();

/* === BUSCA GLOBAL / CTRL+K === */
var commandLinks=[];
function collectCommandLinks(){
  commandLinks=[].slice.call(document.querySelectorAll('#sidebar-nav a')).map(function(a){
    return {
      label:a.textContent.trim().replace(/\s+/g,' '),
      href:a.href,
      section:(a.previousElementSibling && a.previousElementSibling.classList.contains('sb-section')) ? a.previousElementSibling.textContent.trim() : 'Modulo',
      icon:(a.querySelector('i')||{}).className || 'fa-solid fa-circle'
    };
  });
}
function renderCommandResults(query){
  var box=document.getElementById('command-results');
  if(!box)return;
  var q=(query||'').toLowerCase();
  var results=commandLinks.filter(function(item){return !q || item.label.toLowerCase().includes(q) || item.section.toLowerCase().includes(q);}).slice(0,9);
  if(!results.length){
    box.innerHTML='<div style="padding:18px;color:var(--muted);text-align:center">Nenhum resultado encontrado</div>';
    return;
  }
  box.innerHTML=results.map(function(item,idx){
    return '<button type="button" class="command-item '+(idx===0?'active':'')+'" data-href="'+item.href+'"><i class="'+item.icon+'"></i><div><strong>'+item.label+'</strong><span>'+item.section+'</span></div></button>';
  }).join('');
}
function abrirCommandPalette(){
  collectCommandLinks();
  var palette=document.getElementById('command-palette');
  var input=document.getElementById('command-input');
  palette.classList.add('open');
  palette.setAttribute('aria-hidden','false');
  renderCommandResults('');
  setTimeout(function(){input.focus();input.select();},20);
}
function fecharCommandPalette(){
  var palette=document.getElementById('command-palette');
  palette.classList.remove('open');
  palette.setAttribute('aria-hidden','true');
}
document.getElementById('command-input')?.addEventListener('input',function(){renderCommandResults(this.value);});
document.getElementById('command-results')?.addEventListener('click',function(e){
  var item=e.target.closest('.command-item');
  if(item) window.location.href=item.dataset.href;
});
document.getElementById('command-palette')?.addEventListener('click',function(e){if(e.target.id==='command-palette')fecharCommandPalette();});
document.addEventListener('keydown',function(e){
  if((e.ctrlKey||e.metaKey) && e.key.toLowerCase()==='k'){e.preventDefault();abrirCommandPalette();}
  if(e.key==='Escape')fecharCommandPalette();
  if(e.key==='Enter' && document.activeElement && document.activeElement.id==='command-input'){
    var active=document.querySelector('.command-item.active');
    if(active) window.location.href=active.dataset.href;
  }
});

/* === MASCARA MONETARIA GLOBAL === */
(function(){
  var moneyNamePattern=/(^|_|\[)(valor|preco|preco_unitario|custo|total|subtotal|taxa|desconto|troco|recebido|pago)(\]|_|$)/i;
  var moneyIdPattern=/(valor|preco|custo|total|subtotal|taxa|desconto|troco|recebido|pago)/i;
  var allowedKeys=['Backspace','Delete','Tab','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Home','End','Enter'];

  function isMoneyInput(input){
    if(!input || input.dataset.currencyMasked==='1')return false;
    if(input.classList.contains('js-money-input'))return false;
    if(input.closest('.pagamento-form'))return false;
    if(input.type==='hidden' || input.disabled || input.readOnly)return false;
    if(input.tagName!=='INPUT')return false;
    var type=(input.getAttribute('type') || 'text').toLowerCase();
    if(['text','number','tel','search'].indexOf(type)===-1)return false;
    if(input.dataset.currency==='1' || input.classList.contains('currency-mask'))return true;
    return moneyNamePattern.test(input.name || '') || moneyIdPattern.test(input.id || '');
  }

  function parseMoney(value){
    var raw=String(value || '').trim();
    if(raw.indexOf(',')===-1 && /^\d+(\.\d{1,2})?$/.test(raw))return Number(raw);
    var normalized=raw.replace(/[^\d,.-]/g,'').replace(/\./g,'').replace(',','.');
    return Number(normalized || 0);
  }

  function formatMoney(value){
    return Number(value || 0).toLocaleString('pt-BR',{minimumFractionDigits:2,maximumFractionDigits:2});
  }

  function formatFromDigits(value){
    var cents=Number(String(value || '').replace(/\D/g,'') || 0);
    return formatMoney(cents / 100);
  }

  function wrapInput(input){
    if(input.closest('.currency-input-shell'))return;
    var shell=document.createElement('div');
    shell.className='currency-input-shell';
    var prefix=document.createElement('span');
    prefix.className='currency-input-prefix';
    prefix.textContent='R$';
    input.parentNode.insertBefore(shell,input);
    shell.appendChild(prefix);
    shell.appendChild(input);
  }

  function moveCaretToEnd(input){
    requestAnimationFrame(function(){
      try{input.setSelectionRange(input.value.length,input.value.length);}catch(e){}
    });
  }

  function applyMoneyMask(input){
    input.dataset.currencyMasked='1';
    if((input.getAttribute('type') || '').toLowerCase()==='number')input.setAttribute('type','text');
    input.setAttribute('inputmode','numeric');
    input.setAttribute('autocomplete','off');
    wrapInput(input);
    input.value=formatMoney(parseMoney(input.value));

    input.addEventListener('keydown',function(e){
      if(e.ctrlKey || e.metaKey || e.altKey)return;
      if(allowedKeys.indexOf(e.key)!==-1)return;
      if(/^\d$/.test(e.key))return;
      e.preventDefault();
    });

    input.addEventListener('paste',function(e){
      e.preventDefault();
      var text=(e.clipboardData || window.clipboardData).getData('text') || '';
      input.value=formatFromDigits(text);
      moveCaretToEnd(input);
      input.dispatchEvent(new Event('input',{bubbles:true}));
    });

    input.addEventListener('input',function(){
      input.value=formatFromDigits(input.value);
      moveCaretToEnd(input);
    });

    input.addEventListener('focus',function(){
      if(!input.value.trim())input.value='0,00';
      moveCaretToEnd(input);
    });
  }

  document.addEventListener('DOMContentLoaded',function(){
    document.querySelectorAll('input').forEach(function(input){
      if(isMoneyInput(input))applyMoneyMask(input);
    });

    document.querySelectorAll('form').forEach(function(form){
      form.addEventListener('submit',function(){
        form.querySelectorAll('input[data-currency-masked="1"]').forEach(function(input){
          input.value=parseMoney(input.value).toFixed(2);
        });
      });
    });
  });
})();

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
=======
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
setTimeout(function(){
  document.querySelectorAll('.alert').forEach(function(el){
    el.style.transition='opacity .5s'; el.style.opacity='0';
    setTimeout(function(){el.remove();},500);
  });
},6000);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
</script>
@yield('scripts')
</body>
</html>
