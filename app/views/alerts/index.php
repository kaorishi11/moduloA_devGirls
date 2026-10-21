<div class="page-head"><h1>Alertas e notificações</h1></div>
<div class="card">
<ul class="alerts">
<?php foreach ($alerts as $a): ?>
  <li class="<?= $a['severity'] ?> <?= $a['read_flag'] ? 'read':'' ?>">
    <i data-lucide="bell"></i>
    <div>
      <strong><?= htmlspecialchars($a['type']) ?></strong>
      <p><?= htmlspecialchars($a['message']) ?></p>
      <small><?= $a['created_at'] ?></small>
    </div>
    <?php if (!$a['read_flag']): ?>
    <form method="post" action="<?= APP_URL ?>/alerts/mark">
      <?= Csrf::field() ?><input type="hidden" name="id" value="<?= $a['id'] ?>">
      <button class="btn small">Marcar como lido</button>
    </form>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
<?php if (!$alerts): ?><li class="empty">Nenhum alerta.</li><?php endif; ?>
</ul>
</div>