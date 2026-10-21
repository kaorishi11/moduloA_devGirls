<form method="post" action="<?= APP_URL ?>/login" class="auth-card">
  <h2>Entrar</h2>
  <p class="muted">Acesse sua conta SENN AI-X.</p>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?= Csrf::field() ?>
  <label>E-mail<input type="email" name="email" required placeholder="voce@empresa.com"></label>
  <label>Senha<input type="password" name="password" required placeholder="••••••••"></label>
  <button class="btn primary">Entrar</button>
  <p class="muted small">Não tem conta? <a href="<?= APP_URL ?>/register">Cadastre-se</a></p>
</form>