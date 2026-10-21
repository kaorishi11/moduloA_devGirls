<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($title ?? 'SENN AI-X') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
<script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="auth-body">
<main class="auth-wrap">
  <div class="auth-brand">
    <div class="logo big"><span class="dot"></span> SENN <b>AI-X</b></div>
    <p>Logística inteligente de última milha.</p>
    <ul>
      <li><i data-lucide="route"></i> Otimização de rotas com IA</li>
      <li><i data-lucide="truck"></i> Monitoramento em tempo real</li>
      <li><i data-lucide="bar-chart-3"></i> Análise de desempenho</li>
    </ul>
  </div>
  <?php require $viewFile; ?>
</main>
<script>lucide.createIcons();</script>
</body>
</html>