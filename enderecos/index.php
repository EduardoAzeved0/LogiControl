<?php
require '../config/database.php'; require '../includes/functions.php';
if(isset($_GET['excluir'])){$s=$pdo->prepare("DELETE FROM enderecos WHERE id=?");$s->execute([(int)$_GET['excluir']]);flash('Endereço excluído.');redirect('index.php');}
$items=$pdo->query("SELECT * FROM enderecos ORDER BY cidade, estado")->fetchAll();
$pageTitle='Endereços';require '../includes/header.php';?>
<div class="page-heading"><div><h1>Endereços</h1><p class="text-secondary mb-0">Locais de origem e destino das entregas.</p></div><a class="btn btn-primary" href="cadastrar.php">+ Cadastrar endereço</a></div>
<div class="card p-3"><div class="table-responsive"><table class="table"><thead><tr><th>Identificação</th><th>Logradouro</th><th>Cidade/UF</th><th>CEP</th><th>Ações</th></tr></thead><tbody>
<?php foreach($items as $i):?><tr><td><?=e($i['identificacao'])?></td><td><?=e($i['logradouro'])?>, <?=e($i['numero'])?></td><td><?=e($i['cidade'])?> / <?=e($i['estado'])?></td><td><?=e($i['cep'])?></td><td><a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?=$i['id']?>">Editar</a> <a class="btn btn-sm btn-outline-danger" data-confirm="Excluir endereço?" href="?excluir=<?=$i['id']?>">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$items):?><tr><td colspan="5" class="text-center text-secondary">Nenhum endereço cadastrado.</td></tr><?php endif;?></tbody></table></div></div><?php require '../includes/footer.php';?>
