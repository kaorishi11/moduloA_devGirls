<div class="page-head">
  <h1>Entregas</h1>
  <button class="btn primary" onclick="document.getElementById('newDelivery').showModal()"><i data-lucide="plus"></i> Nova entrega</button>
</div>

<form class="filters" method="get">
  <input type="text" name="q" placeholder="Buscar por código ou destinatário" value="<?= htmlspecialchars($search) ?>">
  <select name="status">
    <option value="">Todos os status</option>
    <?php foreach (['pendente','em_andamento','concluida','atrasada','cancelada'] as $s): ?>
      <option value="<?= $s ?>" <?= $filterStatus===$s?'selected':'' ?>><?= str_replace('_',' ',$s) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn">Filtrar</button>
</form>

<div class="card">
<table class="tbl">
  <thead><tr><th>Código</th><th>Destinatário</th><th>Endereço</th><th>Motorista</th><th>Veículo</th><th>Prazo</th><th>Prioridade</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($deliveries as $d): ?>
    <tr>
      <td><b><?= htmlspecialchars($d['code']) ?></b></td>
      <td><?= htmlspecialchars($d['recipient']) ?></td>
      <td class="trunc"><?= htmlspecialchars($d['address']) ?></td>
      <td><?= htmlspecialchars($d['driver_name'] ?? '—') ?></td>
      <td><?= htmlspecialchars($d['plate'] ?? '—') ?></td>
      <td><?= $d['deadline'] ? date('d/m H:i', strtotime($d['deadline'])) : '—' ?></td>
      <td><span class="prio <?= $d['priority'] ?>"><?= $d['priority'] ?></span></td>
      <td><span class="badge <?= $d['status'] ?>"><?= str_replace('_',' ',$d['status']) ?></span></td>
      <td class="row-actions">
        <form method="post" action="<?= APP_URL ?>/deliveries/update" style="display:inline">
          <?= Csrf::field() ?>
          <input type="hidden" name="id" value="<?= $d['id'] ?>">
          <select name="status" onchange="this.form.submit()">
            <?php foreach (['pendente','em_andamento','concluida','atrasada','cancelada'] as $s): ?>
              <option value="<?= $s ?>" <?= $d['status']===$s?'selected':'' ?>><?= str_replace('_',' ',$s) ?></option>
            <?php endforeach; ?>
          </select>
        </form>
        <form method="post" action="<?= APP_URL ?>/deliveries/delete" onsubmit="return confirm('Excluir entrega?')" style="display:inline">
          <?= Csrf::field() ?><input type="hidden" name="id" value="<?= $d['id'] ?>">
          <button class="icon-btn danger"><i data-lucide="trash-2"></i></button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$deliveries): ?><tr><td colspan="9" class="empty">Nenhuma entrega encontrada. Cadastre a primeira.</td></tr><?php endif; ?>
  </tbody>
</table>
</div>

<dialog id="newDelivery">
  <form method="post" action="<?= APP_URL ?>/deliveries/store" class="dialog-form">
    <?= Csrf::field() ?>
    <h3>Nova entrega</h3>
    <label>Destinatário<input name="recipient" required></label>
    <label>Endereço<input name="address" required></label>
    <label>Prazo<input type="datetime-local" name="deadline"></label>
    <label>Prioridade
      <select name="priority"><option value="baixa">Baixa</option><option value="media" selected>Média</option><option value="alta">Alta</option></select>
    </label>
    <label>Motorista
      <select name="driver_id"><option value="">—</option>
        <?php foreach ($drivers as $dr): ?><option value="<?= $dr['id'] ?>"><?= htmlspecialchars($dr['name']) ?></option><?php endforeach; ?>
      </select>
    </label>
    <label>Veículo
      <select name="vehicle_id"><option value="">—</option>
        <?php foreach ($vehicles as $v): ?><option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['plate']) ?> — <?= htmlspecialchars($v['model']) ?></option><?php endforeach; ?>
      </select>
    </label>
    <div class="actions">
      <button type="button" class="btn" onclick="this.closest('dialog').close()">Cancelar</button>
      <button class="btn primary">Salvar</button>
    </div>
  </form>
</dialog>