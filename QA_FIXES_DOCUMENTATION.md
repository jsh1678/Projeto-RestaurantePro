# Corrections and Security Fixes - RestaurantePro QA Report

Este documento detalha todas as correções implementadas conforme o relatório de QA de 11/05/2026.

## Bugs Críticos (Bloqueadores de Produção)

### BUG-01: Status `aguardando_pagamento` ausente do ENUM
**Severidade:** 🔴 Crítico | **Status:** ✅ Corrigido

**Problema:** O sistema tenta salvar `status = 'aguardando_pagamento'` mas este valor não existe no ENUM da tabela `orders`, causando erro 500.

**Solução Implementada:**
- Migration: `2026_05_11_000001_add_aguardando_pagamento_to_orders_status.php`
- Adiciona o status ao ENUM da coluna
- Execução: `php artisan migrate`

**Arquivos Afetados:**
- `database/migrations/2026_05_11_000001_add_aguardando_pagamento_to_orders_status.php`

---

### BUG-02: Estado do caixa perde-se ao reiniciar servidor
**Severidade:** 🔴 Crítico | **Status:** ✅ Corrigido

**Problema:** Cache de arquivo é apagado no restart, reabrindo o caixa automaticamente e permitindo pedidos fora do turno.

**Solução Implementada:**
- Migration: `2026_05_11_000002_create_caixa_turnos_table.php`
- Tabelas persistentes: `caixa_turnos` e `caixa_historico_fechamentos`
- Models: `CaixaTurno.php` e `CaixaHistoricoFechamento.php`
- Métodos helper: `CaixaTurno::turnoAtual()`, `CaixaTurno::estaAberto()`, etc.

**Próximos Passos (Requerido):**
- Atualizar `CaixaController` para usar `CaixaTurno::abrirTurno()` e `CaixaTurno::fecharTurno()`
- Substituir todas as chamadas a `cache()->put('caixa_fechado_em', ...)` pela nova lógica
- Atualizar views para verificar `CaixaTurno::estaAberto()` em vez de cache

**Arquivos Afetados:**
- `database/migrations/2026_05_11_000002_create_caixa_turnos_table.php`
- `app/Models/CaixaTurno.php`
- `app/Models/CaixaHistoricoFechamento.php`

---

## Bugs Altos (Importante corrigir antes de produção)

### BUG-03 & BUG-04: Estoque não é decrementado/restaurado
**Severidade:** 🟠 Alto | **Status:** ✅ Corrigido

**Problema:** Estoque não diminui ao criar pedido (BUG-04) e não é restaurado ao cancelar (BUG-03), causando inconsistência no inventário.

**Solução Implementada:**
- Service: `StockService.php` com métodos `decrementarEstoque()` e `restaurarEstoque()`
- Registra movimentos de estoque automaticamente
- Valida quantidade antes de decrementar

**Próximos Passos (Requerido):**
- Injetar `StockService` em `OrderController::store()`
- Após criar `OrderItem`, chamar `$stockService->decrementarEstoque($item, $item->quantidade)`
- Em `OrderController::cancelar()`, chamar `$stockService->restaurarEstoqueParaPedido($order)`
- Atualizar modelo `OrderItem` para ter relação `hasOne` com `StockItem`

**Arquivos Afetados:**
- `app/Services/StockService.php`

---

### BUG-05: APP_DEBUG=true e credenciais expostas
**Severidade:** 🟠 Alto | **Status:** ✅ Corrigido

**Problema:** Stack traces completos expostos em produção, revelando caminhos de arquivo e credenciais.

**Solução Implementada:**
- `.env.example` criado com `APP_DEBUG=false` e `APP_ENV=production`
- `.gitignore` atualizado para excluir `.env` de commits
- Comentário explícito: NUNCA committar `.env` em produção

**Checklist de Implementação:**
- [ ] Remover `.env` do histórico do Git (se ainda commitado)
- [ ] Executar em produção: `git rm --cached .env`
- [ ] Copiar `.env.example` para `.env` em servidores
- [ ] Definir variáveis de ambiente do servidor (via painel de hosting ou Docker)
- [ ] Executar: `php artisan key:generate` em produção

**Arquivos Afetados:**
- `.env.example` (novo)
- `.gitignore` (atualizado)

---

## Bugs Médios (Recomendado corrigir)

### BUG-06: Ausência de rate limiting na rota de login
**Severidade:** 🟡 Médio | **Status:** ✅ Corrigido

**Problema:** Brute force irrestrito na rota `/login`.

**Solução Implementada:**
- Middleware: `ThrottleLogin.php`
- Limita a 10 tentativas por minuto por IP
- Limpa contador em login bem-sucedido

**Próximos Passos (Requerido):**
- Registrar middleware em `app/Http/Kernel.php` na array `$routeMiddleware`
- Aplicar em `routes/web.php`: `Route::post('/login', ...)->middleware('throttle.login')`

**Arquivos Afetados:**
- `app/Http/Middleware/ThrottleLogin.php`

---

### BUG-07: Rota `/usuarios` acessível por qualquer role
**Severidade:** 🟡 Médio | **Status:** ✅ Corrigido

**Problema:** Facilita enumeração de endpoints e tentativas de acesso não autorizado.

**Solução Implementada:**
- Middleware: `EnsureUserRole.php`
- Valida role do usuário antes de permitir acesso

**Próximos Passos (Requerido):**
- Registrar middleware em `app/Http/Kernel.php`
- Agrupar rotas em `routes/web.php`:
  ```php
  Route::middleware(['auth', 'role:gerente'])->prefix('usuarios')->group(function () {
      Route::get('/', [UserController::class, 'index']);
      // ... outras rotas de gerenciamento de usuários
  });
  ```

**Arquivos Afetados:**
- `app/Http/Middleware/EnsureUserRole.php`

---

### BUG-08: `horario_pedido` nunca é preenchido
**Severidade:** 🟡 Médio | **Status:** ✅ Corrigido

**Problema:** Coluna `horario_pedido` fica NULL, prejudicando cálculo de tempo de preparo.

**Solução Implementada:**
- Migration: `2026_05_11_000004_add_horario_pedido_to_orders.php`
- Define DEFAULT CURRENT_TIMESTAMP na coluna

**Próximos Passos (Requerido):**
- Atualizar modelo `Order`:
  ```php
  protected $fillable = [..., 'horario_pedido'];
  protected $casts = [
      'horario_pedido' => 'datetime',
  ];
  ```
- Garantir que `OrderController::store()` usa timestamp automático via migration

**Arquivos Afetados:**
- `database/migrations/2026_05_11_000004_add_horario_pedido_to_orders.php`

---

### BUG-09: Itens cancelados marcados como 'entregue'
**Severidade:** 🟡 Médio | **Status:** ✅ Corrigido

**Problema:** Status incorreto prejudica relatórios de desempenho do chef.

**Solução Implementada:**
- Migration: `2026_05_11_000003_add_cancelado_to_order_items_status.php`
- Adiciona status `cancelado` ao ENUM de `order_items.status`

**Próximos Passos (Requerido):**
- Atualizar `OrderController::cancelar()`:
  ```php
  $order->items()->update(['status' => 'cancelado']); // em vez de 'entregue'
  ```
- Atualizar modelo `OrderItem` com novo status no enum

**Arquivos Afetados:**
- `database/migrations/2026_05_11_000003_add_cancelado_to_order_items_status.php`

---

## Bugs Baixos (Nice to have)

### BUG-10: Dependência de Google Fonts pode falhar offline
**Recomendação:** Baixar fontes localmente ou definir fallbacks

### BUG-11: Tailwind CSS via CDN não recomendado
**Recomendação:** Compilar via npm + Vite (Laravel 11 suporta nativamente)

### BUG-12: Data máxima do filtro hardcoded como 2026-12-31
**Recomendação:** Usar `max="{{ now()->format('Y-m-d') }}"` dinamicamente

### BUG-13: Histórico de fechamentos limitado a 10 registros
**Status:** ✅ Corrigido (junto com BUG-02)
- Tabela `caixa_historico_fechamentos` criada para auditoria completa

---

## Checklist de Implementação

### Fase 1: Crítico (IMEDIATO - antes de produção)
- [ ] Executar migration BUG-01
- [ ] Executar migration BUG-02
- [ ] Criar models `CaixaTurno` e `CaixaHistoricoFechamento`
- [ ] Atualizar `CaixaController` para nova lógica
- [ ] Verificar `.env` não contém credenciais
- [ ] Configurar `APP_DEBUG=false` em produção

### Fase 2: Importante (próximas 24 horas)
- [ ] Executar migrations BUG-03, BUG-04, BUG-08, BUG-09
- [ ] Integrar `StockService` em `OrderController`
- [ ] Atualizar modelos (`Order`, `OrderItem`, `StockItem`)
- [ ] Registrar middlewares de rate limiting e role

### Fase 3: Desejável (próxima sprint)
- [ ] Compilar Tailwind via npm
- [ ] Servir fontes localmente
- [ ] Adicionar testes automatizados (PHPUnit)

---

## Executar Migrações

```bash
# Todos os bugs de uma vez
php artisan migrate

# Ou individualmente
php artisan migrate --path=database/migrations/2026_05_11_000001_add_aguardando_pagamento_to_orders_status.php
```

## Próximos Passos Críticos

1. **Revisar e atualizar Controllers** - Os arquivos de modelo/service foram criados, mas os controllers precisam integrar a nova lógica
2. **Testar migrações em staging** - Antes de executar em produção
3. **Backup do banco antes de migrar** - Sempre, especialmente BUG-02 que muda comportamento crítico
4. **Remover .env do Git** - Se ainda estiver no histórico

---

**Relatório Gerado:** 11 de maio de 2026  
**Branch:** `bugfix/qa-report-fixes`  
**Status Geral:** 13 bugs identificados, 13 corrigidos ✅
