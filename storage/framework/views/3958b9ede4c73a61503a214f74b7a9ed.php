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
  background-image: radial-gradient(circle, rgba(250,178,105,.06) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  opacity: .5;
}

.login-wrapper {
  width: 100%;
  max-width: 420px;
  position: relative; z-index: 1;
}

.login-card {
  background: var(--card-bg);
  border-radius: 16px;
  padding: 2.6rem 2rem;
  box-shadow: var(--shadow);
  border: 1px solid var(--border);
}

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

.alert-error {
  background: rgba(236,45,1,.1);
  border-left: 3px solid var(--red);
  padding: .8rem 1.1rem; border-radius: 8px;
  margin-bottom: 1.5rem;
  font-family: var(--font-body); font-size: 14px; color: #fca5a5;
  display: flex; gap: 8px; align-items: center;
}

.input-group { margin-bottom: 1.3rem; }
.input-group label {
  display: block;
  font-family: var(--font-title); font-size: 9px; font-weight: 600;
  text-transform: uppercase; letter-spacing: 1.5px; color: var(--muted);
  margin-bottom: .5rem;
}
.input-group input {
  width: 100%; padding: .9rem 1.1rem;
  background: var(--input-bg); border: 1px solid var(--input-border);
  border-radius: 10px;
  font-family: var(--font-body); font-size: 15px; color: var(--cream);
  transition: all .2s;
}
.input-group input::placeholder { color: var(--muted); font-style: italic; }
.input-group input:focus {
  outline: none; border-color: var(--gold);
  box-shadow: 0 0 0 3px rgba(250,178,105,.12);
}
.input-group input.invalid { border-color: var(--red); }

.error-msg {
  color: #fca5a5; font-size: 12px; margin-top: 5px;
  font-family: var(--font-body); font-style: italic;
  display: flex; align-items: center; gap: 4px;
}

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

.login-footer {
  text-align: center; margin-top: 1.6rem;
  font-family: var(--font-body); font-size: 12px;
  color: var(--muted); font-style: italic;
}
.login-footer strong {
  font-family: var(--font-title); font-size: 10px;
  color: var(--gold); letter-spacing: 1px; font-style: normal;
}

@media (max-width: 500px) {
  body { padding: 1rem; }
  .login-card { padding: 2rem 1.4rem; border-radius: 14px; }
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

    <?php if($errors->any()): ?>
    <div class="alert-error">
      <span>⚠️</span> <?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.post')); ?>" id="loginForm" novalidate>
      <?php echo csrf_field(); ?>

      <div class="input-group">
        <label>E-mail</label>
        <input type="email" name="email" id="emailField" value="<?php echo e(old('email')); ?>"
          placeholder="seu@email.com" autocomplete="email"
          class="<?php echo e($errors->has('email') ? 'invalid' : ''); ?>">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="input-group">
        <label>Senha</label>
        <input type="password" name="password" id="passwordField"
          placeholder="••••••••" autocomplete="current-password"
          class="<?php echo e($errors->has('password') ? 'invalid' : ''); ?>">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <button type="submit" class="btn-login" onclick="return validateForm()">
        Entrar →
      </button>
    </form>

    <div class="login-footer">
      <strong>RestaurantePRO</strong> · Sistema de Gestão
    </div>

  </div>
</div>

<script>
function validateForm() {
  const email = document.getElementById('emailField');
  const password = document.getElementById('passwordField');
  let valid = true;
  if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    email.classList.add('invalid'); valid = false;
  } else { email.classList.remove('invalid'); }
  if (!password.value.trim()) {
    password.classList.add('invalid'); valid = false;
  } else { password.classList.remove('invalid'); }
  return valid;
}
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Projeto-RestaurantePro-master\resources\views/auth/login.blade.php ENDPATH**/ ?>