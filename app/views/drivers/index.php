<div class="page-head">
  <h1>Motoristas</h1>
  <button class="btn primary" onclick="document.getElementById('newDriver').showModal()"><i data-lucide="plus"></i> Novo motorista</button>
</div>
<div class="card">
<table class="tbl">
  <thead><tr><th>Nome</th><th>CNH</th><th>Categoria</th><th>Validade</th><th>Contato</th><th>Disponível</th><th>Veículo</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($drivers as $d): ?>
    <tr>
      <td><b><?= htmlspecialchars($d['name']) ?></b></td>
      <td><?= htmlspecialchars($d['cnh']) ?></td>
      <td><?= htmlspecialchars($d['category']) ?></td>
      <td><?= $d['cnh_valid_until'] ? date('d/m/Y', strtotime($d['cnh_valid_until'])) : '—' ?></td>
      <td><?= htmlspecialchars($d['contact'] ?? '—') ?></td>
      <td><?= $d['available'] ? '<span class="badge concluida">sim</span>' : '<span class="badge cancelada">não</span>' ?></td>
      <td><?= htmlspecialchars($d['plate'] ?? '—') ?></td>
      <td class="row-actions">
        <form method="post" action="<?= APP_URL ?>/drivers/delete" onsubmit="return confirm('Excluir motorista?')">
          <?= Csrf::field() ?><input type="hidden" name="id" value="<?= $d['id'] ?>">
          <button class="icon-btn danger"><i data-lucide="trash-2"></i></button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$drivers): ?><tr><td colspan="8" class="empty">Nenhum motorista cadastrado.</td></tr><?php endif; ?>
  </tbody>
</table>
</div>

<dialog id="newDriver">
  <form method="post" action="<?= APP_URL ?>/drivers/store" class="dialog-form">
    <?= Csrf::field() ?>
    <h3>Novo motorista</h3>
    <label>Nome<input name="name" required></label>
    <label>CNH<input name="cnh" required></label>
    <label>Categoria<select name="category"><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></label>
    <label>Validade CNH<input type="date" name="cnh_valid_until"></label>
    <label>Contato<input name="contact"></label>
    <label>Veículo<select name="vehicle_id"><option value="">—</option>
      <?php foreach ($vehicles as $v): ?><option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['plate']) ?></option><?php endforeach; ?>
    </select></label>
    <label class="check"><input type="checkbox" name="available" checked> Disponível</label>
    <div class="actions">
      <button type="button" class="btn" onclick="this.closest('dialog').close()">Cancelar</button>
      <button class="btn primary">Salvar</button>
    </div>
  </form>
</dialog>