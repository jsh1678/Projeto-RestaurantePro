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
<<<<<<< HEAD
.btn-view,
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
.btn-del,
.btn-toggle {
    display: inline-flex;
    align-items: center;
<<<<<<< HEAD
    justify-content: center;
    gap: 6px;
    min-height: 36px;
    padding: 7px 10px;
=======
    gap: 6px;
    padding: 6px 12px;
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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

<<<<<<< HEAD
.btn-view {
    background: rgba(250, 178, 105, 0.12);
    color: var(--gold);
}

.btn-view:hover {
    background: rgba(250, 178, 105, 0.22);
    transform: translateY(-1px);
}

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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

<<<<<<< HEAD
.btn-toggle.locked {
    background: rgba(244, 232, 208, 0.06);
    color: var(--text-muted);
    cursor: not-allowed;
}

.btn-toggle.locked:hover {
    background: rgba(244, 232, 208, 0.06);
    transform: none;
}

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
/* Cards de funcionários */
.funcionario-card {
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px;
<<<<<<< HEAD
    display: grid;
    grid-template-columns: 44px minmax(0, 1fr);
    align-items: center;
    gap: 14px;
    transition: all 0.2s;
    cursor: pointer;
=======
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.2s;
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(96px, 1fr));
    gap: 6px;
    width: 100%;
    justify-content: stretch;
}

.acoes form {
    min-width: 0;
}

.acoes button,
.acoes a {
    width: 100%;
    min-width: 0;
}

/* Grid de funcionários */
.user-details-overlay {
    position: fixed;
    inset: 0;
    z-index: 130;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 18px;
    background: rgba(0, 0, 0, 0.72);
    backdrop-filter: blur(5px);
}

.user-details-overlay.open {
    display: flex;
}

.user-details-card {
    width: min(460px, 100%);
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.user-details-head {
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.user-details-title {
    font-family: var(--font-title);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--cream);
}

.user-details-close {
    width: 38px;
    height: 38px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: rgba(250, 178, 105, 0.05);
    color: var(--cream);
    cursor: pointer;
}

.user-details-body {
    padding: 20px;
}

.user-details-main {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
}

.user-details-avatar {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 20px;
}

.user-details-name {
    font-size: 18px;
    font-weight: 800;
    color: var(--cream);
    line-height: 1.2;
}

.user-details-email {
    color: var(--text-muted);
    font-size: 14px;
    overflow-wrap: anywhere;
}

.detail-grid {
    display: grid;
    gap: 10px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: rgba(250, 178, 105, 0.035);
}

.detail-label {
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.detail-value {
    color: var(--cream);
    font-weight: 700;
    text-align: right;
    overflow-wrap: anywhere;
}

=======
    display: flex;
    gap: 6px;
    flex-shrink: 0;
    flex-wrap: wrap;
    justify-content: flex-end;
}

/* Grid de funcionários */
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
    
<<<<<<< HEAD
    .acoes {
        grid-template-columns: 1fr;
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD
                        <div class="funcionario-card"
                             onclick="abrirDetalhesUsuario(this, event)"
                             data-name="{{ e($u->name) }}"
                             data-email="{{ e($u->email) }}"
                             data-role="{{ e($g['label']) }}"
                             data-status="{{ $u->ativo ? 'Ativo' : 'Inativo' }}"
                             data-created="{{ optional($u->created_at)->format('d/m/Y H:i') ?? '-' }}"
                             data-updated="{{ optional($u->updated_at)->format('d/m/Y H:i') ?? '-' }}"
                             data-initial="{{ strtoupper(substr($u->name, 0, 1)) }}"
                             data-color="{{ $g['cor'] }}">
=======
                        <div class="funcionario-card">
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD
                                <button type="button" class="btn-view" onclick="abrirDetalhesUsuario(this.closest('.funcionario-card'), event, true)">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <a href="{{ route('usuarios.edit', $u) }}" class="btn-edit">
                                    <i class="fas fa-pencil-alt"></i> Editar
                                </a>
                                @if($u->role === 'gerente')
                                    <button type="button" class="btn-toggle locked" title="Gerentes nao podem ser desativados">
                                        <i class="fas fa-lock"></i> Protegido
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('usuarios.toggle', $u) }}" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-toggle {{ $u->ativo ? 'ativo' : '' }}">
                                            <i class="fas {{ $u->ativo ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                            {{ $u->ativo ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
                                @endif
=======
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
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD

<div class="user-details-overlay" id="user-details-modal" onclick="fecharDetalhesUsuario(event)">
    <div class="user-details-card" onclick="event.stopPropagation()">
        <div class="user-details-head">
            <div class="user-details-title">Dados do funcionario</div>
            <button type="button" class="user-details-close" onclick="fecharDetalhesUsuario()" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="user-details-body">
            <div class="user-details-main">
                <div class="user-details-avatar" id="detail-avatar">?</div>
                <div style="min-width:0">
                    <div class="user-details-name" id="detail-name">-</div>
                    <div class="user-details-email" id="detail-email">-</div>
                </div>
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <span class="detail-label">Cargo</span>
                    <span class="detail-value" id="detail-role">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value" id="detail-status">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Criado em</span>
                    <span class="detail-value" id="detail-created">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Atualizado em</span>
                    <span class="detail-value" id="detail-updated">-</span>
                </div>
            </div>
        </div>
    </div>
</div>
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
@endsection

@section('scripts')
<script>
<<<<<<< HEAD
function abrirDetalhesUsuario(card, event, force) {
    if (!card) return;
    if (event && !force && event.target.closest('a, button, form, input, select, textarea')) {
        return;
    }

    const modal = document.getElementById('user-details-modal');
    const avatar = document.getElementById('detail-avatar');

    document.getElementById('detail-name').textContent = card.dataset.name || '-';
    document.getElementById('detail-email').textContent = card.dataset.email || '-';
    document.getElementById('detail-role').textContent = card.dataset.role || '-';
    document.getElementById('detail-status').textContent = card.dataset.status || '-';
    document.getElementById('detail-created').textContent = card.dataset.created || '-';
    document.getElementById('detail-updated').textContent = card.dataset.updated || '-';

    avatar.textContent = card.dataset.initial || '?';
    avatar.style.background = (card.dataset.color || '#FAB269') + '20';
    avatar.style.color = card.dataset.color || '#FAB269';

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function fecharDetalhesUsuario(event) {
    if (event && event.target !== event.currentTarget) return;

    const modal = document.getElementById('user-details-modal');
    modal.classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        fecharDetalhesUsuario();
    }
});

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
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
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
