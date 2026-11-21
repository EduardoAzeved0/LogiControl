<?php
require '../config/database.php'; require '../includes/functions.php';
if (isset($_GET['excluir'])) { $stmt=$pdo->prepare("DELETE FROM produtos WHERE id=?"); $stmt->execute([(int)$_GET['excluir']]); flash('Produto excluído.'); redirect('index.php'); }
$items=$pdo->query("SELECT * FROM produtos ORDER BY nome")->fetchAll();
$pageTitle='Produtos'; require '../includes/header.php';
?>
<div class="page-heading"><div><h1>Produtos</h1><p class="text-secondary mb-0">Cadastro dos itens transportados.</p></div><a class="btn btn-primary" href="cadastrar.php">+ Cadastrar produto</a></div>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Produto</th><th>SKU</th><th>Peso (kg)</th><th>Quantidade</th><th>Ações</th></tr></thead><tbody>
<?php foreach($items as $i): ?><tr><td><?=e($i['nome'])?></td><td><?=e($i['sku'])?></td><td><?=e($i['peso'])?></td><td><?=e($i['quantidade'])?></td><td><a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?=$i['id']?>">Editar</a> <a data-confirm="Deseja excluir este produto?" class="btn btn-sm btn-outline-danger" href="?excluir=<?=$i['id']?>">Excluir</a></td></tr><?php endforeach; ?>
<?php if(!$items): ?><tr><td colspan="5" class="text-center text-secondary">Nenhum produto cadastrado.</td></tr><?php endif; ?>
</tbody></table></div></div><?php require '../includes/footer.php'; ?>
