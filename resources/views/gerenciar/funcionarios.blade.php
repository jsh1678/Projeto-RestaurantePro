@extends('layouts.app')
@section('page-title', 'Gerenciar Funcionários')
@section('breadcrumb', 'Equipe do restaurante')

@section('styles')
<style>
/* ============================================
   ESTILOS CORRIGIDOS E OTIMIZADOS
   ============================================ */

/* Tabs de navegação */
.ger-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 28px;
    flex-wrap: wrap;
    border-bottom: 1px solid var(--border);
    padding-bottom: 4px;
}

.ger-tab {
    padding: 10px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
    background: var(--bg2);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.ger-tab.active,
.ger-tab:hover {
    background: rgba(249, 115, 22, 0.12);
    color: var(--accent);
    border-color: rgba(249, 115, 22, 0.3);
    transform: translateY(-1px);
}

/* Layout principal */
.ger-layout {
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 24px;
    align-items: start;
}

/* Painel de formulário */
.form-panel {
    position: sticky;
    top: 90px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
}

.panel-header {
    padding: 18px 20px;
    background: rgba(249, 115, 22, 0.08);
    border-bottom: 1px solid var(--border);
}

.panel-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 10px;
}

.panel-title i {
    color: var(--accent);
    font-size: 18px;
}

.form-content {
    padding: 20px;
}

/* Formulário */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 6px;
}

.form-group label i {
    margin-right: 5px;
    font-size: 11px;
}

.form-control,
.form-select {
    width: 100%;
    padding: 10px 14px;
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    border-radius: 12px;
    font-size: 14px;
    color: var(--text-primary);
    transition: all 0.2s;
}

.form-control:focus,
.form-select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    color: #f87171;
    font-size: 11px;
    margin-top: 5px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

#email-hint {
    font-size: 11px;
    margin-top: 5px;
    transition: all 0.2s;
}

/* Botões de ação nos cards */
.btn-edit,
.btn-del,
.btn-toggle {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    text-decoration: none;
    border: none;
}

.btn-edit {
    background: rgba(59, 130, 246, 0.12);
    color: #60a5fa;
}

.btn-edit:hover {
    background: rgba(59, 130, 246, 0.25);
    transform: translateY(-1px);
}

.btn-del {
    background: rgba(239, 68, 68, 0.12);
    color: #f87171;
}

.btn-del:hover {
    background: rgba(239, 68, 68, 0.25);
    transform: translateY(-1px);
}

.btn-toggle {
    background: rgba(234, 179, 8, 0.12);
    color: #facc15;
}

.btn-toggle:hover {
    background: rgba(234, 179, 8, 0.25);
    transform: translateY(-1px);
}

.btn-toggle.ativo {
    background: rgba(239, 68, 68, 0.12);
    color: #f87171;
}

.btn-toggle.ativo:hover {
    background: rgba(239, 68, 68, 0.25);
}

/* Cards de funcionários */
.funcionario-card {
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.2s;
}

.funcionario-card:hover {
    transform: translateY(-2px);
    border-color: var(--accent-glow);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}

.avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
    flex-shrink: 0;
}

.info {
    flex: 1;
    min-width: 0;
    /* Isso evita overflow de texto */
    overflow: hidden;
}

.info-nome {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.info-email {
    font-size: 11px;
    color: var(--text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge-status {
    display: inline-block;
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 20px;
    margin-top: 4px;
}

.badge-status.inativo {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
}

.acoes {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
    flex-wrap: wrap;
    justify-content: flex-end;
}

/* Grid de funcionários */
.funcionarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 12px;
}

.panel-grupo {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 20px;
    margin-bottom: 24px;
    overflow: hidden;
}

.panel-grupo .panel-header {
    padding: 14px 18px;
}

/* Botão primário */
.btn-primary {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f97316, #fb923c);
    border: none;
    color: white;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    filter: brightness(1.05);
}

/* Responsividade */
@media (max-width: 900px) {
    .ger-layout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-panel {
        position: static;
    }
    
    .funcionarios-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .funcionario-card {
        flex-wrap: wrap;
    }
    
    .acoes {
        width: 100%;
        justify-content: flex-start;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid var(--border);
    }
    
    .btn-edit,
    .btn-del,
    .btn-toggle {
        flex: 1;
        justify-content: center;
    }
    
    .ger-tab {
        padding: 8px 16px;
        font-size: 12px;
    }
}

/* Scroll suave */
html {
    scroll-behavior: smooth;
}
</style>
@endsection

@section('content')

<div class="ger-layout">
    <!-- Painel de cadastro -->
    <div class="form-panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-user-plus"></i> Novo Funcionário
            </div>
        </div>
        <div class="form-content">
            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nome completo</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" 
                           value="{{ old('name') }}" placeholder="Ex: João Silva" required 
                           oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> E-mail</label>
                    <input type="email" name="email" id="email-input" 
                           class="form-control {{ $errors->has('email')?'is-invalid':'' }}" 
                           value="{{ old('email') }}" required
                           pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                           title="E-mail inválido. Ex: nome@empresa.com"
                           oninput="validarEmail(this)">
                    <div id="email-hint" style="font-size:11px;margin-top:5px;display:none"></div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-briefcase"></i> Cargo</label>
                    <select name="role" class="form-select" required>
                        <option value="">— Selecione um cargo —</option>
                        <option value="garcom"  {{ old('role')=='garcom' ?'selected':'' }}>🍽️ Garçom</option>
                        <option value="chef"    {{ old('role')=='chef'   ?'selected':'' }}>👨‍🍳 Chef</option>
                        <option value="caixa"   {{ old('role')=='caixa'  ?'selected':'' }}>💰 Caixa</option>
                        <option value="gerente" {{ old('role')=='gerente'?'selected':'' }}>👑 Gerente</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Senha</label>
                        <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-check-circle"></i> Confirmar</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Cadastrar Funcionário
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de funcionários agrupados -->
    <div>
        @php
            $grupos = [
                'gerente' => ['label' => 'Gerentes', 'icon' => '👑', 'cor' => '#a855f7'],
                'garcom' => ['label' => 'Garçons', 'icon' => '🍽️', 'cor' => '#3b82f6'],
                'chef' => ['label' => 'Chefs', 'icon' => '👨‍🍳', 'cor' => '#f97316'],
                'caixa' => ['label' => 'Caixas', 'icon' => '💰', 'cor' => '#22c55e']
            ];
        @endphp

        @foreach($grupos as $role => $g)
            @php $grupo = $usuarios->where('role', $role); @endphp
            @if($grupo->isNotEmpty())
            <div class="panel-grupo">
                <div class="panel-header">
                    <div class="panel-title">
                        {{ $g['icon'] }} {{ $g['label'] }}
                        <span style="color:var(--text-muted);font-weight:400;margin-left:8px;font-size:13px">
                            ({{ $grupo->count() }})
                        </span>
                    </div>
                </div>
                <div style="padding: 16px;">
                    <div class="funcionarios-grid">
                        @foreach($grupo as $u)
                        <div class="funcionario-card">
                            <div class="avatar" style="background:{{ $g['cor'] }}20; color:{{ $g['cor'] }};">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div class="info">
                                <div class="info-nome">{{ $u->name }}</div>
                                <div class="info-email">{{ $u->email }}</div>
                                @if(!$u->ativo)
                                    <span class="badge-status inativo">⚠️ Inativo</span>
                                @endif
                            </div>
                            <div class="acoes">
                                <a href="{{ route('usuarios.edit', $u) }}" class="btn-edit">
                                    <i class="fas fa-pencil-alt"></i> Editar
                                </a>
                                <form method="POST" action="{{ route('usuarios.toggle', $u) }}" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-toggle {{ $u->ativo ? 'ativo' : '' }}">
                                        <i class="fas {{ $u->ativo ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                        {{ $u->ativo ? 'Desativar' : 'Ativar' }}
                                    </button>
                                </form>
                                @if($u->id !== Auth::id())
                                <form method="POST" action="{{ route('usuarios.destroy', $u) }}" 
                                      onsubmit="return confirm('⚠️ Tem certeza que deseja excluir {{ $u->name }}? Esta ação não pode ser desfeita.')" 
                                      style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">
                                        <i class="fas fa-trash-alt"></i> Excluir
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
function validarEmail(input) {
    const hint = document.getElementById('email-hint');
    if (!hint) return;
    
    const val = input.value.trim();
    const re = /^[a-zA-Z0-9][a-zA-Z0-9._%+\-]{0,}@[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\-]+)*\.(com|net|org|edu|gov|br|io|co|info|biz|me|tv|app|dev|tech|online|store|site|email|mail)(\.br)?$/i;
    
    if (val.length === 0) {
        hint.style.display = 'none';
        input.style.borderColor = '';
        return;
    }
    
    if (re.test(val)) {
        hint.innerHTML = '<i class="fas fa-check-circle"></i> E-mail válido';
        hint.style.color = '#4ade80';
        hint.style.display = 'block';
        input.style.borderColor = '#4ade80';
        input.classList.remove('is-invalid');
    } else {
        hint.innerHTML = '<i class="fas fa-exclamation-triangle"></i> E-mail inválido. Ex: nome@empresa.com';
        hint.style.color = '#f87171';
        hint.style.display = 'block';
        input.style.borderColor = '#f87171';
        input.classList.add('is-invalid');
    }
}
</script>
@endsection