<?php
require_once __DIR__ . '/../app/config/database.php';

echo "Inicializando dados de demonstração...\n";
$pdo = Database::pdo();

$users = [
  ['Administrador', 'admin@senn.local', 'admin123', 1],
  ['Gestor Frota', 'gestor@senn.local', 'gestor123', 2],
  ['Despachante', 'despachante@senn.local', 'desp123', 3],
  ['Motorista Demo', 'motorista@senn.local', 'moto123', 4],
];
$stmt = $pdo->prepare("INSERT IGNORE INTO users (name,email,password_hash,profile_id) VALUES (?,?,?,?)");
foreach ($users as [$n,$e,$p,$r]) $stmt->execute([$n,$e,password_hash($p,PASSWORD_DEFAULT),$r]);

$vehicles = [
  ['ABC-1234','Volvo FH',12000,60,800,'disponivel'],
  ['XYZ-5678','Mercedes Atego',8000,45,600,'em_uso'],
  ['DEF-9012','Fiat Fiorino',1500,5,400,'disponivel'],
];
$v = $pdo->prepare("INSERT IGNORE INTO vehicles (plate,model,capacity_kg,volume_m3,autonomy_km,status) VALUES (?,?,?,?,?,?)");
foreach ($vehicles as $r) $v->execute($r);

$drivers = [
  ['João Silva','12345678900','C','2026-12-31','(11)99999-1111',1,1],
  ['Maria Souza','98765432100','B','2025-06-30','(11)98888-2222',1,2],
];
$d = $pdo->prepare("INSERT IGNORE INTO drivers (name,cnh,category,cnh_valid_until,contact,available,vehicle_id) VALUES (?,?,?,?,?,?,?)");
foreach ($drivers as $r) $d->execute($r);

$deliveries = [
  ['DEL-001','Supermercado Extra','Av. Paulista, 1000 - SP','2025-01-15 18:00:00','alta','pendente',1,1],
  ['DEL-002','Farmácia São Paulo','Rua Augusta, 200 - SP','2025-01-15 12:00:00','media','em_andamento',1,2],
  ['DEL-003','Padaria Central','Rua das Flores, 50 - SP','2025-01-14 10:00:00','baixa','concluida',2,1],
];
$del = $pdo->prepare("INSERT IGNORE INTO deliveries (code,recipient,address,deadline,priority,status,driver_id,vehicle_id) VALUES (?,?,?,?,?,?,?,?)");
foreach ($deliveries as $r) $del->execute($r);

$alerts = [
  ['atraso','Entrega DEL-001 com risco de atraso','warning'],
  ['manutencao','Veículo ABC-1234 com revisão em 3 dias','info'],
  ['cnh','CNH de Maria Souza vence em 30 dias','warning'],
];
$a = $pdo->prepare("INSERT INTO alerts (type,message,severity) VALUES (?,?,?)");
foreach ($alerts as $r) $a->execute($r);

echo "✅ Dados criados. Use:\n admin@senn.local / admin123\n";