<div class="page-head"><h1>Inteligência Artificial</h1><p class="muted">Assistente logístico baseado nos dados da operação</p></div>

<div class="grid-2">
  <div class="card chat">
    <h3><i data-lucide="sparkles"></i> Assistente SENN AI-X</h3>
    <div id="chatBox" class="chat-box">
      <div class="msg bot">Olá! Posso sugerir rotas, apontar riscos de atraso e analisar desempenho. O que deseja?</div>
    </div>
    <form id="chatForm" class="chat-form">
      <?= Csrf::field() ?>
      <input id="chatInput" placeholder="Ex.: quais entregas têm risco de atraso hoje?" autocomplete="off">
      <button class="btn primary"><i data-lucide="send"></i></button>
    </form>
  </div>

  <div class="card">
    <h3>Entregas com risco de atraso</h3>
    <ul class="list">
      <?php foreach ($risky as $r): ?>
        <li><b><?= htmlspecialchars($r['code']) ?></b> — <?= htmlspecialchars($r['recipient']) ?><small>Prazo: <?= date('d/m H:i', strtotime($r['deadline'])) ?></small></li>
      <?php endforeach; ?>
      <?php if (!$risky): ?><li class="empty">Nenhuma entrega crítica no momento.</li><?php endif; ?>
    </ul>
    <h3>Previsão de demanda (7 dias)</h3>
    <p class="muted">Baseada na média móvel dos últimos 30 dias.</p>
  </div>
</div>