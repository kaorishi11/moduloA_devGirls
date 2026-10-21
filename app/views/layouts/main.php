<?php $u = Auth::user(); $current = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'SENN AI-X') ?> — SENN AI-X</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="logo"><span class="dot"></span> SENN <b>AI-X</b></div>
    <nav>
      <?php
      $items = [
        ['/dashboard','LayoutDashboard','Dashboard'],
        ['/deliveries','Package','Entregas'],
        ['/vehicles','Truck','Veículos'],
        ['/drivers','UserRound','Motoristas'],
        ['/map','MapPin','Rastreamento'],
        ['/ai','Sparkles','Inteligência Artificial'],
        ['/users','Users','Usuários'],
        ['/reports','BarChart3','Relatórios'],
        ['/alerts','Bell','Alertas'],
        ['/proofs','FileCheck','Comprovantes'],
        ['/import','Upload','Importar CSV'],
      ];
      foreach ($items as [$href,$icon,$label]):
        $active = str_starts_with($current, $href) ? 'active' : '';
      ?>
        <a href="<?= APP_URL . $href ?>" class="<?= $active ?>">
          <i data-lucide="<?= $icon ?>"></i><span><?= $label ?></span>
        </a>
      <?php endforeach; ?>
    </nav>
  </aside>

  <div class="main">
    <header class="topbar">
      <div class="search"><i data-lucide="search"></i><input placeholder="Pesquisar..."></div>
      <div class="actions">
        <a href="<?= APP_URL ?>/alerts" class="icon-btn"><i data-lucide="bell"></i></a>
        <div class="user"><span class="avatar"><?= strtoupper(substr($u['name'],0,1)) ?></span>
          <div><strong><?= htmlspecialchars($u['name']) ?></strong><small><?= htmlspecialchars($u['profile']) ?></small></div>
        </div>
        <a href="<?= APP_URL ?>/logout" class="icon-btn"><i data-lucide="log-out"></i></a>
      </div>
    </header>
    <main class="content">
      <?php require $viewFile; ?>
    </main>
  </div>
</div>
<script>lucide.createIcons();</script>
<script src="<?= APP_URL ?>/assets/js/app.js"></script>
</body>
</html>