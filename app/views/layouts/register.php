<form method="post" action="<?= APP_URL ?>/register" class="auth-card">
  <h2>Criar conta</h2>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?= Csrf::field() ?>
  <label>Nome<input type="text" name="name" required></label>
  <label>E-mail<input type="email" name="email" required></label>
  <label>Senha<input type="password" name="password" minlength="6" required></label>
  <button class="btn primary">Cadastrar</button>
  <p class="muted small">Já tem conta? <a href="<?= APP_URL ?>/login">Entrar</a></p>
</form>