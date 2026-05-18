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
/* TODO O SEU CSS AQUI (manter igual) */
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
  <!-- TODO O SEU SIDEBAR AQUI (manter igual) -->
</aside>

<div class="main">
  <div class="topbar">
    <!-- TODO O SEU TOPBAR AQUI (manter igual) -->
  </div>

  <div class="content">
    {{-- Flash messages --}}
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

/* ===== 🔥 CORREÇÃO DO ERRO 419 NO CELULAR 🔥 ===== */
// Força reload se página vier do cache (resolve 419 no mobile)
window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
        // Recarrega a página para obter um novo token CSRF
        window.location.reload();
    }
});

// Proteção adicional: recarregar token CSRF a cada 15 minutos
setInterval(function() {
    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('input[name="_token"]').forEach(input => {
                input.value = data.token;
            });
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            if (metaToken) metaToken.setAttribute('content', data.token);
        })
        .catch(() => console.log('Token refresh falhou'));
}, 15 * 60 * 1000);

// Proteção para sessão expirada
window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
        fetch('/dashboard', { method: 'HEAD', credentials: 'same-origin', cache: 'no-store' })
            .then(r => { 
                if (r.status === 401 || r.url.includes('/login')) {
                    window.location.href = '/login';
                }
            })
            .catch(() => {});
    }
});
</script>
@yield('scripts')
</body>
</html>