<div class="page-head">
  <h1>Relatórios e gráficos</h1>
  <div class="actions">
    <a class="btn" href="<?= APP_URL ?>/reports/export?format=csv"><i data-lucide="file-spreadsheet"></i> Excel/CSV</a>
    <a class="btn primary" href="<?= APP_URL ?>/reports/export?format=pdf" target="_blank"><i data-lucide="file-text"></i> PDF</a>
  </div>
</div>

<section class="cards">
  <div class="card stat green"><small>Entregas no prazo</small><strong><?= number_format($ontime,1) ?>%</strong></div>
  <div class="card stat"><small>Custo estimado</small><strong>R$ <?= number_format($cost,2,',','.') ?></strong></div>
  <div class="card stat lilac"><small>KM frota</small><strong><?= number_format($km,0,',','.') ?></strong></div>
</section>

<section class="grid-2">
  <div class="card"><h3>Entregas por status</h3><canvas id="rStatus" height="200"></canvas></div>
  <div class="card"><h3>Desempenho por região</h3><canvas id="rRegion" height="200"></canvas></div>
</section>

<script>
window.__REPORT__ = {
  status: <?= json_encode($byStatus) ?>,
  region: <?= json_encode($byRegion) ?>
};
</script>