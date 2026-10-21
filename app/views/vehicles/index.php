<div class="page-head">
  <h1>Veículos</h1>
  <button class="btn primary" onclick="document.getElementById('newVehicle').showModal()"><i data-lucide="plus"></i> Novo veículo</button>
</div>
<div class="card">
<table class="tbl">
  <thead><tr><th>Placa</th><th>Modelo</th><th>Capacidade (kg)</th><th>Volume (m³)</th><th>Autonomia (km)</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($vehicles as $v): ?>
    <tr>
      <td><b><?= htmlspecialchars($v['plate']) ?></b></td>
      <td><?= htmlspecialchars($v['model']) ?></td>
      <td><?= number_format($v['capacity_kg'],0,',','.') ?></td>
      <td><?= $v['volume_m3'] ?></td>
      <td><?= $v['autonomy_km'] ?></td>
      <td><span class="badge <?= $v['status'] ?>"><?= $v['status'] ?></span></td>
      <td class="row-actions">
        <form method="post" action="<?= APP_URL ?>/vehicles/delete" onsubmit="return confirm('Excluir veículo?')">
          <?= Csrf::field() ?><input type="hidden" name="id" value="<?= $v['id'] ?>">
          <button class="icon-btn danger"><i data-lucide="trash-2"></i></button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$vehicles): ?><tr><td colspan="7" class="empty">Nenhum veículo cadastrado.</td></tr><?php endif; ?>
  </tbody>
</table>
</div>

<dialog id="newVehicle">
  <form method="post" action="<?= APP_URL ?>/vehicles/store" class="dialog-form">
    <?= Csrf::field() ?>
    <h3>Novo veículo</h3>
    <label>Placa<input name="plate" required></label>
    <label>Modelo<input name="model"></label>
    <label>Capacidade (kg)<input type="number" name="capacity_kg" step="0.01"></label>
    <label>Volume (m³)<input type="number" name="volume_m3" step="0.01"></label>
    <label>Autonomia (km)<input type="number" name="autonomy_km"></label>
    <label>Status<select name="status"><option value="disponivel">Disponível</option><option value="em_uso">Em uso</option><option value="manutencao">Manutenção</option></select></label>
    <div class="actions">
      <button type="button" class="btn" onclick="this.closest('dialog').close()">Cancelar</button>
      <button class="btn primary">Salvar</button>
    </div>
  </form>
</dialog>