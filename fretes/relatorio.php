<?php
require '../config/database.php';require '../includes/functions.php';
$data=$_GET['data']??date('Y-m-d');$items=[];
if($data){$s=$pdo->prepare("SELECT f.id,f.data_frete,f.status,t.nome transportador,o.identificacao origem,d.identificacao destino,
GROUP_CONCAT(CONCAT(p.nome,' (',fp.quantidade,')') SEPARATOR ', ') produtos
FROM fretes f JOIN transportadores t ON t.id=f.transportador_id JOIN enderecos o ON o.id=f.origem_id
JOIN enderecos d ON d.id=f.destino_id LEFT JOIN frete_produtos fp ON fp.frete_id=f.id LEFT JOIN produtos p ON p.id=fp.produto_id
WHERE f.data_frete=? GROUP BY f.id ORDER BY f.id");$s->execute([$data]);$items=$s->fetchAll();}
$pageTitle='Relatório';require '../includes/header.php';?>
<div class="page-heading"><div><h1>Relatório de fretes</h1><p class="text-secondary mb-0">Consulte as operações realizadas em uma data específica.</p></div></div>
<div class="card p-4 mb-3"><form class="row g-2 align-items-end" method="get"><div class="col-md-4"><label class="form-label">Data dos fretes</label><input type="date" class="form-control" name="data" value="<?=e($data)?>" required></div><div class="col-auto"><button class="btn btn-primary">Consultar</button></div><div class="col-auto"><button type="button" onclick="window.print()" class="btn btn-outline-secondary">Imprimir / Salvar PDF</button></div></form></div>
<div class="card p-3" id="report"><h2 class="h5 mb-3">Fretes de <?=date('d/m/Y',strtotime($data))?></h2><div class="table-responsive"><table class="table"><thead><tr><th>Código</th><th>Transportador</th><th>Origem</th><th>Destino</th><th>Produtos e quantidades</th><th>Status</th></tr></thead><tbody>
<?php foreach($items as $f):?><tr><td>#<?=e($f['id'])?></td><td><?=e($f['transportador'])?></td><td><?=e($f['origem'])?></td><td><?=e($f['destino'])?></td><td><?=e($f['produtos'])?></td><td><?=e($f['status'])?></td></tr><?php endforeach;?>
<?php if(!$items):?><tr><td colspan="6" class="text-center text-secondary">Não foram encontrados fretes para esta data.</td></tr><?php endif;?></tbody></table></div><div class="text-secondary small">Total de fretes: <?=count($items)?></div></div>
<style>@media print{.topbar,.footer,.page-heading,.card form{display:none!important}body{background:#fff}.card{box-shadow:none!important}}</style>
<?php require '../includes/footer.php';?>
