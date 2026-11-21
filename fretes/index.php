<?php
require '../config/database.php';require '../includes/functions.php';
$items=$pdo->query("SELECT f.*,t.nome transportador,o.identificacao origem,d.identificacao destino,
(SELECT COUNT(*) FROM frete_produtos fp WHERE fp.frete_id=f.id) total_produtos
FROM fretes f JOIN transportadores t ON t.id=f.transportador_id
JOIN enderecos o ON o.id=f.origem_id JOIN enderecos d ON d.id=f.destino_id ORDER BY f.data_frete DESC,f.id DESC")->fetchAll();
$pageTitle='Fretes';require '../includes/header.php';?>
<div class="page-heading"><div><h1>Fretes</h1><p class="text-secondary mb-0">Operações com produtos, endereços e transportadores relacionados.</p></div><a class="btn btn-primary" href="cadastrar.php">+ Gerar frete</a></div>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Código</th><th>Data</th><th>Transportador</th><th>Origem</th><th>Destino</th><th>Produtos</th><th>Status</th></tr></thead><tbody>
<?php foreach($items as $f):?><tr><td>#<?=e($f['id'])?></td><td><?=date('d/m/Y',strtotime($f['data_frete']))?></td><td><?=e($f['transportador'])?></td><td><?=e($f['origem'])?></td><td><?=e($f['destino'])?></td><td><?=e($f['total_produtos'])?></td><td><span class="badge text-bg-light"><?=e($f['status'])?></span></td></tr><?php endforeach;?>
<?php if(!$items):?><tr><td colspan="7" class="text-center text-secondary py-4">Nenhum frete gerado. Cadastre produtos, endereços e transportadores antes de começar.</td></tr><?php endif;?></tbody></table></div></div><?php require '../includes/footer.php';?>
