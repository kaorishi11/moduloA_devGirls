<div class="page-head">
  <h1>Comprovantes de entrega</h1>
  <button class="btn primary" onclick="document.getElementById('newProof').showModal()"><i data-lucide="camera"></i> Registrar comprovante</button>
</div>
<div class="card">
<table class="tbl">
  <thead><tr><th>Entrega</th><th>Destinatário</th><th>Data/Hora</th><th>Local</th><th>Evidência</th></tr></thead>
  <tbody>
  <?php foreach ($proofs as $p): ?>
    <tr>
      <td><b><?= htmlspecialchars($p['code']) ?></b></td>
      <td><?= htmlspecialchars($p['recipient']) ?></td>
      <td><?= date('d/m/Y H:i', strtotime($p['delivered_at'])) ?></td>
      <td><?= $p['lat'] && $p['lng'] ? $p['lat'].','.$p['lng'] : '—' ?></td>
      <td><?= $p['evidence_path'] ? '<a href="'.APP_URL.'/'.$p['evidence_path'].'" target="_blank">ver foto</a>' : '—' ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$proofs): ?><tr><td colspan="5" class="empty">Nenhum comprovante registrado.</td></tr><?php endif; ?>
  </tbody>
</table>
</div>

<dialog id="newProof">
  <form method="post" action="<?= APP_URL ?>/proofs/store" enctype="multipart/form-data" class="dialog-form">
    <?= Csrf::field() ?>
    <h3>Registrar comprovante</h3>
    <label>Entrega<select name="delivery_id" required>
      <?php foreach ($deliveries as $d): ?><option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['code'].' — '.$d['recipient']) ?></option><?php endforeach; ?>
    </select></label>
    <label>Data/hora<input type="datetime-local" name="delivered_at" value="<?= date('Y-m-d\TH:i') ?>"></label>
    <label>Latitude<input name="lat" step="0.0000001"></label>
    <label>Longitude<input name="lng" step="0.0000001"></label>
    <label>Foto<input type="file" name="evidence" accept="image/*"></label>
    <label>Observações<textarea name="notes" rows="2"></textarea></label>
    <div class="actions">
      <button type="button" class="btn" onclick="this.closest('dialog').close()">Cancelar</button>
      <button class="btn primary">Salvar</button>
    </div>
  </form>
</dialog>