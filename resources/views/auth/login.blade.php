<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<title>Login - RestaurantePRO</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --red: #EC2D01;
  --red-dark: #B82507;
  --gold: #FAB269;
  --cream: #F4E8D0;
  --green: #3E5F3C;
  --ink: #0A0D10;
  --panel: rgba(16, 18, 20, .74);
  --panel-strong: rgba(22, 24, 27, .9);
  --line: rgba(250, 178, 105, .18);
  --line-strong: rgba(250, 178, 105, .38);
  --text: #FFF7EA;
  --muted: rgba(244, 232, 208, .66);
  --soft: rgba(244, 232, 208, .42);
  --danger: #FF8B7A;
  --shadow: 0 34px 100px rgba(0, 0, 0, .56);
  --font: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

html { min-height: 100%; background: var(--ink); }

body {
  min-height: 100vh;
  display: grid;
  place-items: center;
  padding: 24px;
  color: var(--text);
  font-family: var(--font);
  background:
    radial-gradient(circle at 18% 18%, rgba(236, 45, 1, .2), transparent 28rem),
    radial-gradient(circle at 82% 12%, rgba(62, 95, 60, .2), transparent 24rem),
    linear-gradient(135deg, #080A0D 0%, #11100E 44%, #160B08 100%);
  overflow-x: hidden;
}

body::before {
  content: "";
  position: fixed;
  inset: 0;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(250, 178, 105, .035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(250, 178, 105, .035) 1px, transparent 1px);
  background-size: 54px 54px;
  mask-image: radial-gradient(circle at 50% 30%, #000 0%, transparent 72%);
}

.login-shell {
  width: min(1180px, 100%);
  min-height: min(720px, calc(100vh - 48px));
  display: grid;
  grid-template-columns: minmax(0, 1fr) minmax(390px, 1fr);
  gap: 22px;
  position: relative;
  z-index: 1;
  animation: pageIn .6s ease both;
}

.visual-panel,
.login-panel {
  border: 1px solid var(--line);
  border-radius: 30px;
  box-shadow: var(--shadow);
  overflow: hidden;
}

.visual-panel {
  min-height: 620px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 30px;
  position: relative;
  background:
    linear-gradient(120deg, rgba(8, 10, 13, .96) 0%, rgba(8, 10, 13, .68) 42%, rgba(8, 10, 13, .28) 100%),
    url('/assets/login/restaurant-operations-hero.png') center/cover no-repeat;
  isolation: isolate;
}

.visual-panel::before,
.visual-panel::after {
  content: "";
  position: absolute;
  pointer-events: none;
  z-index: -1;
}

.visual-panel::before {
  inset: 0;
  background:
    radial-gradient(circle at 22% 20%, rgba(250, 178, 105, .18), transparent 24rem),
    linear-gradient(180deg, transparent 0%, rgba(8, 10, 13, .66) 100%);
}

.visual-panel::after {
  right: -120px;
  bottom: -140px;
  width: 420px;
  height: 420px;
  border-radius: 50%;
  border: 1px solid rgba(250, 178, 105, .2);
  background: radial-gradient(circle, rgba(236, 45, 1, .26), transparent 68%);
  filter: blur(2px);
}

.panel-top,
.brand-chip,
.rotator,
.info-card,
.login-panel,
.input-shell,
.access-note {
  backdrop-filter: blur(20px) saturate(1.18);
  -webkit-backdrop-filter: blur(20px) saturate(1.18);
}

.panel-top {
  width: fit-content;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  border: 1px solid rgba(250, 178, 105, .22);
  border-radius: 999px;
  background: rgba(12, 14, 16, .48);
  color: var(--cream);
  font-size: 12px;
  font-weight: 800;
  letter-spacing: .6px;
}

.panel-top i,
.brand-chip i,
.input-shell i,
.forgot-link,
.metric-icon,
.login-logo i {
  color: var(--gold);
}

.banner-copy {
  max-width: 590px;
  padding: 30px 0;
}

.brand-chip {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 13px;
  border: 1px solid rgba(250, 178, 105, .24);
  border-radius: 999px;
  background: rgba(250, 178, 105, .08);
  color: var(--gold);
  font-size: 11px;
  font-weight: 900;
  letter-spacing: 1.3px;
  text-transform: uppercase;
}

.banner-copy h1 {
  max-width: 620px;
  margin-top: 18px;
  font-size: clamp(38px, 5vw, 64px);
  line-height: 1;
  letter-spacing: 0;
}

.banner-copy p {
  max-width: 535px;
  margin-top: 18px;
  color: var(--muted);
  font-size: 16px;
  line-height: 1.68;
}

.rotator {
  width: min(330px, 100%);
  height: 48px;
  margin-top: 24px;
  border: 1px solid rgba(250, 178, 105, .18);
  border-radius: 16px;
  background: rgba(12, 14, 16, .5);
  overflow: hidden;
}

.rotator-track {
  animation: rotateInfo 12s infinite;
}

.rotator-item {
  height: 48px;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 16px;
  color: var(--cream);
  font-weight: 800;
  font-size: 13px;
}

.rotator-item i { color: #9CCB8C; }

.metrics-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 12px;
  position: relative;
  z-index: 1;
}

.info-card {
  min-height: 112px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 15px;
  border: 1px solid rgba(250, 178, 105, .16);
  border-radius: 18px;
  background: linear-gradient(145deg, rgba(255, 255, 255, .1), rgba(255, 255, 255, .03));
  transition: transform .22s ease, border-color .22s ease, background .22s ease;
}

.info-card:hover {
  transform: translateY(-3px);
  border-color: var(--line-strong);
  background: linear-gradient(145deg, rgba(250, 178, 105, .14), rgba(255, 255, 255, .04));
}

.metric-icon {
  width: 34px;
  height: 34px;
  display: grid;
  place-items: center;
  border-radius: 12px;
  border: 1px solid rgba(250, 178, 105, .18);
  background: rgba(10, 13, 16, .44);
}

.info-card strong {
  display: block;
  margin-top: 14px;
  color: var(--text);
  font-size: 13px;
  line-height: 1.25;
}

.info-card span {
  display: block;
  margin-top: 4px;
  color: var(--soft);
  font-size: 11px;
}

.login-panel {
  min-height: 620px;
  display: grid;
  align-items: center;
  padding: clamp(28px, 5vw, 58px);
  background:
    linear-gradient(150deg, rgba(255, 255, 255, .08), transparent 36%),
    var(--panel);
}

.login-content {
  width: min(430px, 100%);
  margin: 0 auto;
}

.login-header {
  text-align: center;
  margin-bottom: 30px;
}

.login-logo {
  width: 70px;
  height: 70px;
  display: grid;
  place-items: center;
  margin: 0 auto 16px;
  border: 1px solid rgba(250, 178, 105, .28);
  border-radius: 22px;
  background:
    linear-gradient(145deg, rgba(236, 45, 1, .3), rgba(250, 178, 105, .12)),
    rgba(10, 13, 16, .64);
  box-shadow: 0 20px 56px rgba(236, 45, 1, .26), inset 0 1px 0 rgba(255, 255, 255, .16);
}

.login-logo i { font-size: 28px; }

.login-header h2 {
  color: var(--text);
  font-size: clamp(28px, 4vw, 34px);
  line-height: 1.1;
  letter-spacing: 0;
}

.login-header p {
  max-width: 340px;
  margin: 10px auto 0;
  color: var(--muted);
  font-size: 14px;
  line-height: 1.6;
}

.alert-error {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 18px;
  padding: 13px 14px;
  border: 1px solid rgba(255, 139, 122, .32);
  border-radius: 16px;
  background: rgba(236, 45, 1, .12);
  color: #FFD0C8;
  font-size: 13px;
  line-height: 1.35;
}

.form-row { margin-bottom: 17px; }

.form-row label {
  display: block;
  margin-bottom: 8px;
  color: var(--cream);
  font-size: 12px;
  font-weight: 800;
}

.input-shell {
  position: relative;
  border: 1px solid rgba(250, 178, 105, .16);
  border-radius: 18px;
  background: rgba(8, 10, 13, .46);
  transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease, background .22s ease;
}

.input-shell:focus-within,
.input-shell:hover {
  border-color: rgba(250, 178, 105, .46);
  background: rgba(8, 10, 13, .62);
  box-shadow: 0 0 0 4px rgba(250, 178, 105, .08), 0 18px 42px rgba(0, 0, 0, .18);
}

.input-shell:focus-within { transform: translateY(-1px); }

.input-shell i {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 14px;
}

.input-shell input {
  width: 100%;
  min-height: 54px;
  padding: 14px 15px 14px 45px;
  border: 0;
  border-radius: 18px;
  outline: none;
  background: transparent;
  color: var(--text);
  font: 600 15px var(--font);
}

.input-shell input::placeholder { color: rgba(244, 232, 208, .36); }

.input-shell input.invalid {
  box-shadow: inset 0 0 0 1px rgba(255, 139, 122, .58);
}

.error-msg {
  margin-top: 7px;
  color: #FFD0C8;
  font-size: 12px;
}

.form-options {
  display: flex;
  justify-content: flex-end;
  margin: 4px 0 20px;
}

.forgot-link {
  border: 0;
  background: none;
  font: 800 12px var(--font);
  text-decoration: none;
  cursor: pointer;
  transition: color .2s ease, opacity .2s ease;
}

.forgot-link:hover {
  color: #FFD5A0;
  opacity: .92;
}

.btn-login {
  width: 100%;
  min-height: 56px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  position: relative;
  border: 1px solid rgba(250, 178, 105, .24);
  border-radius: 18px;
  background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 48%, var(--gold) 135%);
  color: #fff;
  cursor: pointer;
  font: 900 13px var(--font);
  letter-spacing: .5px;
  box-shadow: 0 20px 52px rgba(236, 45, 1, .32), inset 0 1px 0 rgba(255, 255, 255, .2);
  transition: transform .22s ease, box-shadow .22s ease, filter .22s ease;
}

.btn-login:hover {
  transform: translateY(-2px);
  box-shadow: 0 26px 64px rgba(236, 45, 1, .42), 0 0 34px rgba(250, 178, 105, .2);
  filter: saturate(1.08);
}

.btn-login:active { transform: translateY(0); }

.btn-login .spinner {
  width: 16px;
  height: 16px;
  display: none;
  border: 2px solid rgba(255, 255, 255, .42);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin .75s linear infinite;
}

.btn-login.loading { pointer-events: none; opacity: .9; }
.btn-login.loading .spinner { display: inline-block; }
.btn-login.loading i { display: none; }

.access-note {
  margin-top: 22px;
  padding: 13px 14px;
  border: 1px solid rgba(62, 95, 60, .36);
  border-radius: 16px;
  background: rgba(62, 95, 60, .12);
  color: rgba(244, 232, 208, .72);
  font-size: 12px;
  line-height: 1.5;
  text-align: center;
}

.access-note strong { color: #BDE0B0; }

@keyframes pageIn {
  from { opacity: 0; transform: translateY(14px) scale(.99); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes spin { to { transform: rotate(360deg); } }

@keyframes rotateInfo {
  0%, 16% { transform: translateY(0); }
  20%, 36% { transform: translateY(-48px); }
  40%, 56% { transform: translateY(-96px); }
  60%, 76% { transform: translateY(-144px); }
  80%, 96% { transform: translateY(-192px); }
  100% { transform: translateY(0); }
}

@media (max-width: 1020px) {
  .login-shell {
    grid-template-columns: minmax(0, .72fr) minmax(370px, 1fr);
  }

  .metrics-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .banner-copy h1 {
    font-size: clamp(34px, 5vw, 48px);
  }
}

@media (max-width: 760px) {
  body {
    min-height: 100svh;
    padding: 16px;
    place-items: stretch;
  }

  .login-shell {
    min-height: calc(100svh - 32px);
    display: block;
  }

  .visual-panel {
    display: none;
  }

  .login-panel {
    min-height: calc(100svh - 32px);
    padding: 26px 20px;
    border-radius: 24px;
  }

  .login-content {
    align-self: center;
  }

  .access-note {
    display: none;
  }

  .login-logo {
    width: 64px;
    height: 64px;
    border-radius: 20px;
  }

  .input-shell input,
  .btn-login {
    min-height: 56px;
  }
}
</style>
</head>
<body>

<main class="login-shell">
  <section class="visual-panel" aria-label="Gestão inteligente para restaurante">
    <div class="panel-top">
      <i class="fa-solid fa-users-gear"></i>
      Equipe Conectada
    </div>

    <div class="banner-copy">
      <div class="brand-chip">
        <i class="fa-solid fa-utensils"></i>
        RestaurantePRO
      </div>
      <h1>Gestão Inteligente de Restaurante</h1>
      <p>Acesse o sistema e gerencie pedidos, mesas, cozinha e atendimento em tempo real.</p>

      <div class="rotator" aria-label="Recursos do sistema">
        <div class="rotator-track">
          <div class="rotator-item"><i class="fa-solid fa-chair"></i> Controle de Mesas</div>
          <div class="rotator-item"><i class="fa-solid fa-clipboard-list"></i> Gestão de Pedidos</div>
          <div class="rotator-item"><i class="fa-solid fa-kitchen-set"></i> Painel da Cozinha</div>
          <div class="rotator-item"><i class="fa-solid fa-cash-register"></i> Controle Financeiro</div>
          <div class="rotator-item"><i class="fa-solid fa-bell-concierge"></i> Atendimento em Tempo Real</div>
        </div>
      </div>
    </div>

    <div class="metrics-grid" aria-label="Indicadores demonstrativos">
      <div class="info-card">
        <div class="metric-icon"><i class="fa-solid fa-clipboard-list"></i></div>
        <div>
          <strong>Pedidos Ativos</strong>
          <span>32 em fluxo</span>
        </div>
      </div>
      <div class="info-card">
        <div class="metric-icon"><i class="fa-solid fa-utensils"></i></div>
        <div>
          <strong>Mesas em Atendimento</strong>
          <span>18 ocupadas</span>
        </div>
      </div>
      <div class="info-card">
        <div class="metric-icon"><i class="fa-solid fa-kitchen-set"></i></div>
        <div>
          <strong>Cozinha Operando</strong>
          <span>Tempo médio 12 min</span>
        </div>
      </div>
      <div class="info-card">
        <div class="metric-icon"><i class="fa-solid fa-cash-register"></i></div>
        <div>
          <strong>Caixa Online</strong>
          <span>Turno aberto</span>
        </div>
      </div>
    </div>
  </section>

  <section class="login-panel" aria-label="Acesso ao sistema">
    <div class="login-content">
      <header class="login-header">
        <div class="login-logo" aria-label="Logo do restaurante">
          <i class="fa-solid fa-fingerprint"></i>
        </div>
        <h2>Bem-vindo de volta!</h2>
        <p>Entre com seu email e senha para acessar o sistema.</p>
      </header>

      @if($errors->any())
      <div class="alert-error" role="alert">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}" id="loginForm" novalidate>
        @csrf

        <div class="form-row">
          <label for="emailField">Email ou Usuário</label>
          <div class="input-shell">
            <i class="fa-solid fa-envelope"></i>
            <input type="text" name="email" id="emailField" value="{{ old('email') }}"
              placeholder="email@restaurante.com" autocomplete="username"
              class="{{ $errors->has('email') ? 'invalid' : '' }}">
          </div>
          @error('email')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-row">
          <label for="passwordField">Senha</label>
          <div class="input-shell">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" id="passwordField"
              placeholder="Digite sua senha" autocomplete="current-password"
              class="{{ $errors->has('password') ? 'invalid' : '' }}">
          </div>
          @error('password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-login" id="loginButton">
          <span class="spinner" aria-hidden="true"></span>
          <span class="btn-text">Acessar Sistema</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </form>

      <div class="access-note">
        <strong>Acesso automático por permissões.</strong> O cargo do funcionário é identificado após a autenticação.
      </div>
    </div>
  </section>
</main>

<script>
function validateForm() {
  const email = document.getElementById('emailField');
  const password = document.getElementById('passwordField');
  const button = document.getElementById('loginButton');
  const buttonText = button.querySelector('.btn-text');
  let valid = true;

  if (!email.value.trim()) {
    email.classList.add('invalid');
    valid = false;
  } else {
    email.classList.remove('invalid');
  }

  if (!password.value.trim()) {
    password.classList.add('invalid');
    valid = false;
  } else {
    password.classList.remove('invalid');
  }

  if (valid) {
    button.classList.add('loading');
    buttonText.textContent = 'Autenticando...';
  }

  return valid;
}

document.getElementById('loginForm').addEventListener('submit', function(event) {
  if (!validateForm()) {
    event.preventDefault();
  }
});

['emailField', 'passwordField'].forEach(function(id) {
  const field = document.getElementById(id);
  field.addEventListener('input', function() {
    field.classList.remove('invalid');
  });
});
</script>
</body>
</html>
