<?php
require __DIR__ . '/config.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'nova_entrega') {
        $destinatario = trim($_POST['destinatario'] ?? '');
        $endereco = trim($_POST['endereco'] ?? '');
        $regiao = trim($_POST['regiao'] ?? '');
        $peso = filter_var($_POST['peso_kg'] ?? '0', FILTER_VALIDATE_FLOAT);
        $volume = filter_var($_POST['volume_m3'] ?? '0', FILTER_VALIDATE_FLOAT);
        $prioridade = $_POST['prioridade'] ?? 'Normal';
        $prioridades = ['Baixa','Normal','Alta','Urgente'];

        if ($destinatario === '' || $endereco === '' || $regiao === '') {
            $erro = 'Preencha destinatário, endereço e região.';
        } elseif ($peso === false || $peso < 0 || $volume === false || $volume < 0) {
            $erro = 'Peso e volume devem ser números iguais ou maiores que zero.';
        } elseif (!in_array($prioridade, $prioridades, true)) {
            $erro = 'Prioridade inválida.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO entregas (destinatario,endereco,regiao,peso_kg,volume_m3,prioridade) VALUES (?,?,?,?,?,?)');
            $stmt->execute([$destinatario,$endereco,$regiao,$peso,$volume,$prioridade]);
            header('Location: index.php?sucesso=1');
            exit;
        }
    } elseif ($acao === 'atualizar_status') {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $status = $_POST['status'] ?? '';
        if ($id && in_array($status, ['Pendente','A caminho','Entregue','Falha'], true)) {
            $stmt = $pdo->prepare('UPDATE entregas SET status = ? WHERE id = ?');
            $stmt->execute([$status, $id]);
            header('Location: index.php?atualizado=1');
            exit;
        }
        $erro = 'Não foi possível atualizar o status.';
    }
}

if (isset($_GET['sucesso'])) $mensagem = 'Entrega cadastrada com sucesso.';
if (isset($_GET['atualizado'])) $mensagem = 'Status atualizado com sucesso.';

$total = (int)$pdo->query('SELECT COUNT(*) FROM entregas')->fetchColumn();
$pendentes = (int)$pdo->query("SELECT COUNT(*) FROM entregas WHERE status='Pendente'")->fetchColumn();
$emRota = (int)$pdo->query("SELECT COUNT(*) FROM entregas WHERE status='A caminho'")->fetchColumn();
$concluidas = (int)$pdo->query("SELECT COUNT(*) FROM entregas WHERE status='Entregue'")->fetchColumn();
$veiculos = (int)$pdo->query('SELECT COUNT(*) FROM veiculos')->fetchColumn();
$entregas = $pdo->query('SELECT * FROM entregas ORDER BY criado_em DESC LIMIT 100')->fetchAll();
$marcadores = array_values(array_filter($entregas, fn($x) => $x['latitude'] !== null && $x['longitude'] !== null));
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SENN AI-X | Gestão Logística</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<aside class="sidebar">
  <div class="brand"><span class="brand-mark">S</span><div><strong>SENN AI-X</strong><small>LOGISTICS PLATFORM</small></div></div>
  <div class="nav-label">MENU PRINCIPAL</div>
  <a class="nav active" href="#painel">▦ <span>Dashboard</span></a>
  <a class="nav" href="#entregas">↗ <span>Entregas</span></a>
  <a class="nav" href="#mapa">⌖ <span>Rastreamento no mapa</span></a>
  <a class="nav" href="#nova-entrega">＋ <span>Novo pedido</span></a>
  <div class="sidebar-note"><strong>Central logística</strong><p>Acompanhe os pedidos e organize sua operação em um só lugar.</p></div>
</aside>
<main class="main" id="painel">
<header class="topbar"><div><span class="eyebrow">OPERAÇÕES / VISÃO GERAL</span><h1>Dashboard logístico</h1><p class="muted">Acompanhe o desempenho das suas entregas.</p></div><span class="today"><?= date('d/m/Y') ?></span></header>
<?php if ($mensagem): ?><div class="notice success"><?= e($mensagem) ?></div><?php endif; ?>
<?php if ($erro): ?><div class="notice error"><?= e($erro) ?></div><?php endif; ?>
<section class="metrics">
  <article class="metric"><span class="metric-label">Total de entregas</span><strong><?= $total ?></strong><span class="metric-foot">Pedidos cadastrados</span></article>
  <article class="metric"><span class="metric-label">Pendentes</span><strong><?= $pendentes ?></strong><span class="metric-foot">Aguardando saída</span></article>
  <article class="metric"><span class="metric-label">Em rota</span><strong><?= $emRota ?></strong><span class="metric-foot">Em andamento</span></article>
  <article class="metric"><span class="metric-label">Concluídas</span><strong><?= $concluidas ?></strong><span class="metric-foot">Entregas finalizadas</span></article>
</section>
<section class="content-grid">
  <article class="panel map-panel" id="mapa"><div class="panel-heading"><div><h2>Mapa de entregas</h2><p>Localizações que possuem coordenadas cadastradas.</p></div><span class="tag">OpenStreetMap</span></div><div id="map"></div><p class="hint">O mapa mostra pontos de exemplo. Geocodificação automática de endereços ainda precisa ser integrada.</p></article>
  <article class="panel form-panel" id="nova-entrega"><div class="panel-heading"><div><h2>Novo pedido</h2><p>Cadastre uma entrega rapidamente.</p></div></div>
  <form method="post">
    <input type="hidden" name="acao" value="nova_entrega">
    <label>Nome do destinatário<input name="destinatario" maxlength="120" required placeholder="Ex.: Maria Silva"></label>
    <label>Endereço de entrega<input name="endereco" maxlength="255" required placeholder="Rua, número, cidade"></label>
    <label>Região<input name="regiao" maxlength="100" required placeholder="Ex.: Centro"></label>
    <div class="two-cols"><label>Peso (kg)<input type="number" name="peso_kg" min="0" step="0.01" value="0" required></label><label>Volume (m³)<input type="number" name="volume_m3" min="0" step="0.01" value="0" required></label></div>
    <label>Prioridade<select name="prioridade"><option>Normal</option><option>Baixa</option><option>Alta</option><option>Urgente</option></select></label>
    <button class="primary" type="submit">Cadastrar entrega <span>→</span></button>
  </form></article>
</section>
<section class="panel deliveries" id="entregas"><div class="panel-heading"><div><h2>Entregas recentes</h2><p>Atualize o status conforme o andamento da operação.</p></div><span class="tag"><?= count($entregas) ?> registros exibidos</span></div>
<div class="table-wrap"><table><thead><tr><th>Pedido</th><th>Destinatário</th><th>Região</th><th>Prioridade</th><th>Status</th><th>Atualizar</th></tr></thead><tbody>
<?php foreach ($entregas as $entrega): ?>
<tr><td>#<?= (int)$entrega['id'] ?></td><td><strong><?= e($entrega['destinatario']) ?></strong><small class="cell-sub"><?= e($entrega['endereco']) ?></small></td><td><?= e($entrega['regiao']) ?></td><td><span class="priority"><?= e($entrega['prioridade']) ?></span></td><td><span class="status"><?= e($entrega['status']) ?></span></td><td><form class="inline-form" method="post"><input type="hidden" name="acao" value="atualizar_status"><input type="hidden" name="id" value="<?= (int)$entrega['id'] ?>"><select name="status" aria-label="Status da entrega #<?= (int)$entrega['id'] ?>"><?php foreach (['Pendente','A caminho','Entregue','Falha'] as $s): ?><option <?= $entrega['status']===$s?'selected':'' ?>><?= e($s) ?></option><?php endforeach; ?></select><button class="small-btn" type="submit">Salvar</button></form></td></tr>
<?php endforeach; ?>
<?php if (!$entregas): ?><tr><td colspan="6" class="empty">Nenhuma entrega cadastrada.</td></tr><?php endif; ?>
</tbody></table></div></section>
<footer> S E N N  A I - X <span>Plataforma de gestão logística · Projeto acadêmico</span></footer>
</main>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const points = <?= json_encode(array_map(fn($x) => ['nome'=>$x['destinatario'],'endereco'=>$x['endereco'],'lat'=>(float)$x['latitude'],'lng'=>(float)$x['longitude'],'status'=>$x['status']], $marcadores), JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>;
const map = L.map('map').setView([-23.1791, -45.8872], 11);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom:19, attribution:'&copy; OpenStreetMap'}).addTo(map);
points.forEach(p => L.marker([p.lat,p.lng]).addTo(map).bindPopup('<strong>'+escapeHtml(p.nome)+'</strong><br>'+escapeHtml(p.endereco)+'<br>Status: '+escapeHtml(p.status)));
if (points.length > 1) map.fitBounds(L.featureGroup(points.map(p => L.marker([p.lat,p.lng]))).getBounds().pad(0.15));
function escapeHtml(value) { return String(value).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c])); }
</script>
</body>
</html>
