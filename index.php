<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$totalProdutos = (int)$pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$totalTransportadores = (int)$pdo->query("SELECT COUNT(*) FROM transportadores")->fetchColumn();
$totalFretes = (int)$pdo->query("SELECT COUNT(*) FROM fretes")->fetchColumn();
$recentes = $pdo->query("SELECT f.id, f.data_frete, f.status, t.nome AS transportador
    FROM fretes f JOIN transportadores t ON t.id=f.transportador_id
    ORDER BY f.id DESC LIMIT 5")->fetchAll();
$pageTitle = 'Painel'; $current = 'dashboard'; require __DIR__ . '/includes/header.php';
?>
<div class="page-heading"><div><h1>Painel de controle</h1><p class="text-secondary mb-0">Visão geral das operações logísticas.</p></div>
<a class="btn btn-primary" href="/LogiControl/fretes/cadastrar.php">+ Novo frete</a></div>
<div class="row g-3 mb-4">
<?php foreach ([['Produtos cadastrados',$totalProdutos],['Transportadores',$totalTransportadores],['Fretes registrados',$totalFretes]] as $stat): ?>
<div class="col-md-4"><div class="card stat-card p-4"><div class="text-secondary"><?= e($stat[0]) ?></div><div class="stat-number"><?= e($stat[1]) ?></div></div></div>
<?php endforeach; ?>
</div>
<div class="card p-3 p-lg-4"><div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h5 mb-0">Fretes recentes</h2><a href="/LogiControl/fretes/index.php">Ver todos</a></div>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Código</th><th>Data</th><th>Transportador</th><th>Status</th></tr></thead><tbody>
<?php if (!$recentes): ?><tr><td colspan="4" class="text-center text-secondary py-4">Nenhum frete cadastrado até o momento.</td></tr><?php endif; ?>
<?php foreach ($recentes as $f): ?><tr><td>#<?= e($f['id']) ?></td><td><?= date('d/m/Y', strtotime($f['data_frete'])) ?></td><td><?= e($f['transportador']) ?></td><td><span class="badge text-bg-light"><?= e($f['status']) ?></span></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
