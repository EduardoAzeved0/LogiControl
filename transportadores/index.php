<?php
require '../config/database.php';require '../includes/functions.php';
if(isset($_GET['excluir'])){$s=$pdo->prepare("DELETE FROM transportadores WHERE id=?");$s->execute([(int)$_GET['excluir']]);flash('Transportador excluído.');redirect('index.php');}
$items=$pdo->query("SELECT * FROM transportadores ORDER BY nome")->fetchAll();$pageTitle='Transportadores';require '../includes/header.php';?>
<div class="page-heading"><div><h1>Transportadores</h1><p class="text-secondary mb-0">Cadastro de motoristas e empresas responsáveis pelo transporte.</p></div><a class="btn btn-primary" href="cadastrar.php">+ Cadastrar transportador</a></div>
<div class="card p-3"><div class="table-responsive"><table class="table"><thead><tr><th>Nome</th><th>Documento</th><th>Telefone</th><th>Veículo</th><th>Ações</th></tr></thead><tbody>
<?php foreach($items as $i):?><tr><td><?=e($i['nome'])?></td><td><?=e($i['documento'])?></td><td><?=e($i['telefone'])?></td><td><?=e($i['veiculo'])?></td><td><a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?=$i['id']?>">Editar</a> <a class="btn btn-sm btn-outline-danger" data-confirm="Excluir transportador?" href="?excluir=<?=$i['id']?>">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$items):?><tr><td colspan="5" class="text-center text-secondary">Nenhum transportador cadastrado.</td></tr><?php endif;?></tbody></table></div></div><?php require '../includes/footer.php';?>
