<div class="page-head">
  <div>
    <h1>Olá, <?= htmlspecialchars(explode(' ',$u['name'])[0]) ?> 👋</h1>
    <p class="muted"><?= date('d/m/Y') ?> — Visão geral da operação</p>
  </div>
  <button class="btn primary" onclick="location.href='<?= APP_URL ?>/deliveries'"><i data-lucide="plus"></i> Nova entrega</button>
</div>

<section class="cards">
  <div class="card stat"><small>Entregas do dia</small><strong><?= $stats['total'] ?></strong><i data-lucide="package"></i></div>
  <div class="card stat green"><small>Concluídas</small><strong><?= $stats['done'] ?></strong><i data-lucide="check-circle"></i></div>
  <div class="card stat lilac"><small>Em andamento</small><strong><?= $stats['progress'] ?></strong><i data-lucide="truck"></i></div>
  <div class="card stat red"><small>Atrasadas</small><strong><?= $stats['late'] ?></strong><i data-lucide="alert-triangle"></i></div>
  <div class="card stat"><small>Veículos disponíveis</small><strong><?= $stats['vehicles'] ?></strong><i data-lucide="car"></i></div>
  <div class="card stat green"><small>No prazo</small><strong><?= $stats['ontime'] ?>%</strong><i data-lucide="target"></i></div>
</section>

<section class="grid-2">
  <div class="card">
    <h3>Entregas por dia</h3>
    <canvas id="chartDay" height="180"></canvas>
  </div>
  <div class="card">
    <h3>Distribuição dos status</h3>
    <canvas id="chartStatus" height="180"></canvas>
  </div>
</section>

<section class="grid-2">
  <div class="card">
    <h3>Entregas recentes</h3>
    <table class="tbl">
      <thead><tr><th>Código</th><th>Destinatário</th><th>Status</th><th>Motorista</th></tr></thead>
      <tbody>
      <?php foreach ($recent as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['code']) ?></td>
          <td><?= htmlspecialchars($r['recipient']) ?></td>
          <td><span class="badge <?= $r['status'] ?>"><?= str_replace('_',' ',$r['status']) ?></span></td>
          <td><?= htmlspecialchars($r['driver_name'] ?? '—') ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$recent): ?><tr><td colspan="4" class="empty">Nenhuma entrega cadastrada ainda.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
  <div class="card">
    <h3>Alertas prioritários</h3>
    <ul class="alerts">
    <?php foreach ($alerts as $a): ?>
      <li class="<?= $a['severity'] ?>"><i data-lucide="bell"></i><div><?= htmlspecialchars($a['message']) ?><small><?= $a['created_at'] ?></small></div></li>
    <?php endforeach; ?>
    <?php if (!$alerts): ?><li class="empty">Nenhum alerta ativo.</li><?php endif; ?>
    </ul>
    <div class="ai-hint"><i data-lucide="sparkles"></i> Recomendação IA: priorize entregas com prazo inferior a 4h na região central.</div>
  </div>
</section>

<script>
window.__DATA__ = {
  byDay: <?= json_encode($byDay) ?>,
  byStatus: <?= json_encode($byStatus) ?>
};
</script>