<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<title>Login — RestaurantePRO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
  --red:    #EC2D01;
  --brown:  #8B4513;
  --gold:   #FAB269;
  --green:  #3E5F3C;
  --dark:   #1C1C1C;
  --cream:  #F4E8D0;

  --bg:      #120D09;
  --card-bg: #1C1108;
  --border:  rgba(250,178,105,.14);
  --border-hv: rgba(250,178,105,.32);
  --muted:   rgba(244,232,208,.42);
  --shadow:  0 28px 60px rgba(0,0,0,.65);

  --input-bg:     rgba(250,178,105,.05);
  --input-border: rgba(250,178,105,.14);

  --font-body:  'Cormorant Garamond', Georgia, serif;
  --font-title: 'Cinzel', serif;
}

body {
  font-family: var(--font-body);
  background: var(--bg);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  position: relative;
  overflow-x: hidden;
}

/* Background texture */
body::before {
  content: '';
  position: fixed; inset: 0;
  background:
    radial-gradient(ellipse 80% 60% at 15% 20%, rgba(139,69,19,.18) 0%, transparent 60%),
    radial-gradient(ellipse 60% 50% at 85% 80%, rgba(236,45,1,.1) 0%, transparent 55%),
    radial-gradient(circle at 50% 50%, rgba(250,178,105,.04) 0%, transparent 70%);
  pointer-events: none;
}

body::after {
  content: '';
  position: fixed; inset: 0;
  background-image:
    radial-gradient(circle, rgba(250,178,105,.06) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  opacity: .5;
}

.login-wrapper {
  width: 100%;
  max-width: 440px;
  position: relative; z-index: 1;
}

.login-card {
  background: var(--card-bg);
  border-radius: 16px;
  padding: 2.6rem 2rem;
  box-shadow: var(--shadow);
  border: 1px solid var(--border);
}

/* Header */
.card-header { text-align: center; margin-bottom: 2.2rem; }

.logo-wrap {
  display: inline-flex;
  align-items: center; justify-content: center;
  width: 62px; height: 62px;
  background: linear-gradient(135deg, var(--red), var(--brown));
  border-radius: 14px;
  font-size: 28px;
  margin-bottom: 1.2rem;
  box-shadow: 0 6px 20px rgba(236,45,1,.35);
}

.logo-badge {
  display: inline-block;
  font-family: var(--font-title);
  font-size: 9px; font-weight: 600; letter-spacing: 2.5px;
  color: var(--gold); text-transform: uppercase;
  border: 1px solid rgba(250,178,105,.25);
  padding: 4px 14px; border-radius: 20px;
  margin-bottom: 1rem;
  background: rgba(250,178,105,.06);
}

.card-header h1 {
  font-family: var(--font-title);
  font-size: 1.6rem; font-weight: 700;
  color: var(--cream); letter-spacing: .5px;
  margin-bottom: .4rem;
}

.card-header p {
  font-family: var(--font-body);
  color: var(--muted); font-size: 14px; font-style: italic;
}

/* Divider ornament */
.ornament {
  display: flex; align-items: center; gap: 10px;
  color: var(--gold); margin: 1.4rem 0 1.2rem; opacity: .5;
}
.ornament::before, .ornament::after {
  content: ''; flex: 1; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(250,178,105,.35), transparent);
}
.ornament span { font-size: 12px; }

/* Alert */
.alert-error {
  background: rgba(236,45,1,.1);
  border-left: 3px solid var(--red);
  padding: .8rem 1.1rem; border-radius: 8px;
  margin-bottom: 1.5rem;
  font-family: var(--font-body); font-size: 14px; color: #fca5a5;
  display: flex; gap: 8px; align-items: center;
}

/* Role step */
.section-label {
  font-family: var(--font-title);
  font-size: 9px; font-weight: 600; text-transform: uppercase;
  letter-spacing: 2px; color: var(--muted); margin-bottom: 1rem; display: block;
}

.role-grid {
  display: grid; grid-template-columns: repeat(2, 1fr);
  gap: 10px; margin-bottom: .5rem;
}

.role-card {
  background: var(--input-bg);
  border: 1.5px solid var(--input-border);
  border-radius: 12px; padding: 1rem .5rem;
  text-align: center; cursor: pointer;
  transition: all .2s ease;
  display: flex; flex-direction: column; align-items: center; gap: 7px;
}
.role-card:hover {
  border-color: var(--gold);
  background: rgba(250,178,105,.08);
  transform: translateY(-2px);
}
.role-card.selected {
  border-color: var(--red);
  background: rgba(236,45,1,.1);
  box-shadow: 0 4px 16px rgba(236,45,1,.18);
}

.role-emoji { font-size: 2rem; }
.role-name {
  font-family: var(--font-title); font-size: 10px; font-weight: 600;
  color: var(--muted); letter-spacing: 1px; text-transform: uppercase;
}
.role-card.selected .role-name { color: var(--cream); }

/* Selected chip */
.selected-chip {
  display: flex; align-items: center; gap: 13px;
  background: rgba(236,45,1,.1); border-radius: 50px;
  padding: .65rem 1.3rem; margin-bottom: 1.6rem;
  border: 1px solid rgba(236,45,1,.25);
  cursor: pointer; transition: .18s;
}
.selected-chip:hover { background: rgba(236,45,1,.18); }
.chip-emoji { font-size: 1.6rem; }
.chip-role {
  font-family: var(--font-title); font-weight: 600; font-size: .85rem;
  color: var(--cream); text-transform: uppercase; letter-spacing: .5px;
}
.chip-action {
  font-family: var(--font-body); font-size: 11px; color: var(--gold); font-style: italic;
}

/* Input groups */
.input-group { margin-bottom: 1.3rem; }
.input-group label {
  display: block;
  font-family: var(--font-title); font-size: 9px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 1.5px; color: var(--muted);
  margin-bottom: .5rem;
}
.input-group input,
.input-group select {
  width: 100%; padding: .9rem 1.1rem;
  background: var(--input-bg); border: 1px solid var(--input-border);
  border-radius: 10px;
  font-family: var(--font-body); font-size: 15px; color: var(--cream);
  transition: all .2s;
}
.input-group input::placeholder { color: var(--muted); font-style: italic; }
.input-group input:focus,
.input-group select:focus {
  outline: none; border-color: var(--gold);
  box-shadow: 0 0 0 3px rgba(250,178,105,.12);
}
.input-group input.invalid { border-color: var(--red); }
.input-group select option { background: var(--card-bg); color: var(--cream); }

.error-msg {
  color: #fca5a5; font-size: 12px; margin-top: 5px;
  font-family: var(--font-body); font-style: italic;
  display: flex; align-items: center; gap: 4px;
}

/* Login button */
.btn-login {
  background: linear-gradient(135deg, var(--red) 0%, var(--brown) 100%);
  border: none; width: 100%;
  padding: .95rem;
  border-radius: 10px;
  font-family: var(--font-title); font-weight: 700; font-size: .9rem;
  letter-spacing: 2px; text-transform: uppercase;
  color: #fff;
  display: flex; align-items: center; justify-content: center; gap: 10px;
  cursor: pointer; transition: all .2s ease; margin-top: .5rem;
  box-shadow: 0 6px 20px rgba(236,45,1,.32);
}
.btn-login:hover {
  filter: brightness(1.08);
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(236,45,1,.42);
}

/* Footer note */
.login-footer {
  text-align: center; margin-top: 1.6rem;
  font-family: var(--font-body); font-size: 12px;
  color: var(--muted); font-style: italic;
}
.login-footer strong {
  font-family: var(--font-title); font-size: 10px;
  color: var(--gold); letter-spacing: 1px; font-style: normal;
}

/* Responsive */
@media (max-width: 500px) {
  body { padding: 1rem; }
  .login-card { padding: 2rem 1.4rem; border-radius: 14px; }
  .role-emoji { font-size: 1.7rem; }
  .card-header h1 { font-size: 1.4rem; }
}
</style>
</head>
<body>

<div class="login-wrapper">
  <div class="login-card">

    <div class="card-header">
      <div class="logo-wrap">🍳</div>
      <div class="logo-badge">✦ RestaurantePRO ✦</div>
      <h1>Bem-vindo</h1>
      <p>Acesse sua conta para continuar</p>
    </div>

    @if($errors->any())
    <div class="alert-error">
      <span>⚠️</span> {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" id="loginForm" novalidate>
      @csrf
      <input type="hidden" name="role"    id="roleHidden"   value="{{ old('role') }}">
      <input type="hidden" name="user_id" id="userIdHidden" value="{{ old('user_id') }}">

      <!-- PASSO 1: Selecionar cargo -->
      <div id="stepRole" style="display: {{ old('role') ? 'none' : 'block' }};">
        <span class="section-label">Selecione seu perfil</span>
        <div class="role-grid">
          <div class="role-card {{ old('role')==='gerente' ? 'selected' : '' }}" data-role="gerente" data-icon="👔" data-name="Gerente">
            <div class="role-emoji">👔</div>
            <div class="role-name">Gerente</div>
          </div>
          <div class="role-card {{ old('role')==='garcom' ? 'selected' : '' }}" data-role="garcom" data-icon="🍽️" data-name="Garçom">
            <div class="role-emoji">🍽️</div>
            <div class="role-name">Garçom</div>
          </div>
          <div class="role-card {{ old('role')==='chef' ? 'selected' : '' }}" data-role="chef" data-icon="👨‍🍳" data-name="Chef">
            <div class="role-emoji">👨‍🍳</div>
            <div class="role-name">Chef</div>
          </div>
          <div class="role-card {{ old('role')==='caixa' ? 'selected' : '' }}" data-role="caixa" data-icon="💰" data-name="Caixa">
            <div class="role-emoji">💰</div>
            <div class="role-name">Caixa</div>
          </div>
        </div>
      </div>

      <!-- PASSO 2: Credenciais -->
      <div id="stepCredentials" style="display: {{ old('role') ? 'block' : 'none' }};">

        <div id="selectedChip" class="selected-chip" onclick="resetRoleSelection()" style="display: {{ old('role') ? 'flex' : 'none' }};">
          <div class="chip-emoji" id="chipEmoji">{{ old('role') === 'gerente' ? '👔' : (old('role') === 'garcom' ? '🍽️' : (old('role') === 'chef' ? '👨‍🍳' : '💰')) }}</div>
          <div style="flex:1">
            <div class="chip-role" id="chipRoleName">{{ old('role') === 'gerente' ? 'Gerente' : (old('role') === 'garcom' ? 'Garçom' : (old('role') === 'chef' ? 'Chef' : 'Caixa')) }}</div>
            <div class="chip-action">↺ Trocar perfil</div>
          </div>
        </div>

        <div class="input-group">
          <label>E-mail</label>
          <input type="email" name="email" id="emailField" value="{{ old('email') }}"
            placeholder="seu@email.com" autocomplete="email" oninput="validateEmail(this)">
          <div class="error-msg" id="emailError" style="display:none;">Informe um e-mail válido</div>
          @error('email')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="input-group" id="userGroup" style="display:none;">
          <label>Colaborador</label>
          <select id="userSelect" onchange="syncUser()">
            <option value="">— Selecione seu nome —</option>
          </select>
        </div>

        <div class="input-group">
          <label>Senha</label>
          <input type="password" name="password" id="passwordField"
            placeholder="••••••••" autocomplete="current-password">
          @error('password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-login" onclick="return validateForm()">
          Entrar →
        </button>
      </div>
    </form>

    <div class="login-footer">
      <strong>RestaurantePRO</strong> · Sistema de Gestão
    </div>

  </div>
</div>

<script>
  let currentRoleVal     = "{{ old('role') }}";
  let currentRoleIcon    = "{{ old('role') === 'gerente' ? '👔' : (old('role') === 'garcom' ? '🍽️' : (old('role') === 'chef' ? '👨‍🍳' : '💰')) }}";
  let currentRoleDisplay = "{{ old('role') === 'gerente' ? 'Gerente' : (old('role') === 'garcom' ? 'Garçom' : (old('role') === 'chef' ? 'Chef' : 'Caixa')) }}";

  @if(old('role'))
    document.addEventListener('DOMContentLoaded', () => loadUsers("{{ old('role') }}"));
  @endif

  document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('click', async function() {
      const role = this.getAttribute('data-role');
      const icon = this.getAttribute('data-icon');
      const name = this.getAttribute('data-name');

      document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');

      currentRoleVal     = role;
      currentRoleIcon    = icon;
      currentRoleDisplay = name;

      document.getElementById('roleHidden').value   = role;
      document.getElementById('userIdHidden').value = '';

      document.getElementById('chipEmoji').textContent    = icon;
      document.getElementById('chipRoleName').textContent = name;
      document.getElementById('selectedChip').style.display = 'flex';

      document.getElementById('stepRole').style.display        = 'none';
      document.getElementById('stepCredentials').style.display = 'block';

      await loadUsers(role);
      document.getElementById('emailField').focus();
    });
  });

  async function loadUsers(role) {
    try {
      const res  = await fetch(`/login/usuarios?role=${role}`);
      const data = await res.json();
      const userGroupDiv = document.getElementById('userGroup');
      const selectEl     = document.getElementById('userSelect');

      if (data && data.length > 1) {
        selectEl.innerHTML = '<option value="">— Selecione seu nome —</option>';
        data.forEach(user => {
          const opt   = document.createElement('option');
          opt.value   = user.id;
          opt.textContent = user.name;
          @if(old('user_id')) if (user.id == {{ old('user_id',0) }}) opt.selected = true; @endif
          selectEl.appendChild(opt);
        });
        userGroupDiv.style.display = 'block';
        if (selectEl.value) document.getElementById('userIdHidden').value = selectEl.value;
      } else if (data && data.length === 1) {
        userGroupDiv.style.display = 'none';
        document.getElementById('userIdHidden').value = data[0].id;
      } else {
        userGroupDiv.style.display = 'none';
        document.getElementById('userIdHidden').value = '';
      }
    } catch(err) { console.warn("Erro ao carregar usuários:", err); }
  }

  function syncUser() {
    const select = document.getElementById('userSelect');
    document.getElementById('userIdHidden').value = select ? select.value : '';
  }

  function validateEmail(input) {
    const regex     = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
    const errorSpan = document.getElementById('emailError');
    if (!input.value.trim()) { input.classList.remove('invalid'); errorSpan.style.display = 'none'; return false; }
    if (regex.test(input.value.trim())) { input.classList.remove('invalid'); errorSpan.style.display = 'none'; return true; }
    else { input.classList.add('invalid'); errorSpan.style.display = 'flex'; return false; }
  }

  function validateForm() {
    const emailInput    = document.getElementById('emailField');
    const passwordInput = document.getElementById('passwordField');
    let isValid = true;
    if (!emailInput.value.trim()) {
      emailInput.classList.add('invalid');
      const errSpan = document.getElementById('emailError');
      errSpan.innerHTML = 'O e-mail é obrigatório';
      errSpan.style.display = 'flex';
      isValid = false;
    } else if (!validateEmail(emailInput)) { isValid = false; }
    if (!passwordInput.value.trim()) { passwordInput.classList.add('invalid'); isValid = false; }
    else passwordInput.classList.remove('invalid');
    if (!currentRoleVal) { alert("Por favor, selecione um cargo antes de continuar."); isValid = false; }
    return isValid;
  }

  function resetRoleSelection() {
    document.getElementById('stepRole').style.display        = 'block';
    document.getElementById('stepCredentials').style.display = 'none';
    document.getElementById('selectedChip').style.display    = 'none';
    document.getElementById('userGroup').style.display       = 'none';
    document.getElementById('roleHidden').value   = '';
    document.getElementById('userIdHidden').value = '';
    currentRoleVal = '';
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
  }
</script>
</body>
</html>
