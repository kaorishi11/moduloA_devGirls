<div class="page-head">
  <h1>Usuários e permissões</h1>
  <button class="btn primary" onclick="document.getElementById('newUser').showModal()"><i data-lucide="plus"></i> Novo usuário</button>
</div>
<div class="card">
<table class="tbl">
  <thead><tr><th>#</th><th>Nome</th><th>E-mail</th><th>Perfil</th><th>Ativo</th></tr></thead>
  <tbody>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><b><?= htmlspecialchars($u['name']) ?></b></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><span class="badge"><?= htmlspecialchars($u['profile']) ?></span></td>
      <td><?= $u['active'] ? '<span class="badge concluida">sim</span>' : '<span class="badge cancelada">não</span>' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>

<dialog id="newUser">
  <form method="post" action="<?= APP_URL ?>/users/store" class="dialog-form">
    <?= Csrf::field() ?>
    <h3>Novo usuário</h3>
    <label>Nome<input name="name" required></label>
    <label>E-mail<input type="email" name="email" required></label>
    <label>Senha<input type="password" name="password" minlength="6" required></label>
    <label>Perfil<select name="profile_id">
      <?php foreach ($profiles as $p): ?><option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option><?php endforeach; ?>
    </select></label>
    <div class="actions">
      <button type="button" class="btn" onclick="this.closest('dialog').close()">Cancelar</button>
      <button class="btn primary">Salvar</button>
    </div>
  </form>
</dialog>