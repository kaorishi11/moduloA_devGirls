<div class="page-head"><h1>Importar pedidos (CSV)</h1></div>

<?php if (!empty($_SESSION['import_flash'])): ?>
  <div class="alert success"><?= htmlspecialchars($_SESSION['import_flash']) ?></div>
  <?php unset($_SESSION['import_flash']); ?>
<?php endif; ?>

<div class="card">
  <h3>1. Upload do arquivo</h3>
  <p class="muted">Formato: <code>codigo;destinatario;endereco;prazo;prioridade</code> (separador <code>;</code>)</p>
  <form method="post" action="<?= APP_URL ?>/import/validate" enctype="multipart/form-data" class="row">
    <?= Csrf::field() ?>
    <input type="file" name="csv" accept=".csv" required>
    <button class="btn primary">Validar</button>
  </form>
</div>

<?php if (isset($rows)): ?>
  <?php if (!empty($errors)): ?>
    <div class="card">
      <h3>⚠ Erros encontrados (<?= count($errors) ?>)</h3>
      <ul class="errors"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>

  <?php if (!empty($rows)): ?>
    <div class="card">
      <h3>2. Pré-visualização (<?= count($rows) ?> linhas válidas)</h3>
      <table class="tbl">
        <thead><tr><th>Código</th><th>Destinatário</th><th>Endereço</th><th>Prazo</th><th>Prioridade</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['code'] ?: '(auto)') ?></td>
            <td><?= htmlspecialchars($r['recipient']) ?></td>
            <td><?= htmlspecialchars($r['address']) ?></td>
            <td><?= htmlspecialchars($r['deadline']) ?></td>
            <td><?= htmlspecialchars($r['priority']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <form method="post" action="<?= APP_URL ?>/import/confirm">
        <?= Csrf::field() ?>
        <button class="btn primary">Confirmar importação</button>
      </form>
    </div>
  <?php endif; ?>
<?php endif; ?>