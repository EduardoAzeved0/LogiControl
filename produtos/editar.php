<?php
require '../config/database.php'; require '../includes/functions.php';
verify_csrf();
$id=(int)($_GET['id'] ?? 0); $item=['nome'=>'','sku'=>'','descricao'=>'','peso'=>'','quantidade'=>''];
if($id){$s=$pdo->prepare("SELECT * FROM produtos WHERE id=?");$s->execute([$id]);$item=$s->fetch() ?: redirect('index.php');}
$erro='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $item=['nome'=>trim($_POST['nome']??''),'sku'=>trim($_POST['sku']??''),'descricao'=>trim($_POST['descricao']??''),'peso'=>$_POST['peso']??'','quantidade'=>$_POST['quantidade']??''];
    if($item['nome']==='' || !is_numeric($item['peso']) || (float)$item['peso']<0 || filter_var($item['quantidade'],FILTER_VALIDATE_INT)===false || (int)$item['quantidade']<0) $erro='Preencha o nome, peso e quantidade com valores válidos.';
    else {
        if($id){$s=$pdo->prepare("UPDATE produtos SET nome=?,sku=?,descricao=?,peso=?,quantidade=? WHERE id=?");$s->execute([$item['nome'],$item['sku'],$item['descricao'],$item['peso'],$item['quantidade'],$id]);}
        else {$s=$pdo->prepare("INSERT INTO produtos(nome,sku,descricao,peso,quantidade) VALUES(?,?,?,?,?)");$s->execute([$item['nome'],$item['sku'],$item['descricao'],$item['peso'],$item['quantidade']]);}
        flash('Produto salvo com sucesso.'); redirect('index.php');
    }
}
$pageTitle=$id?'Editar produto':'Cadastrar produto'; require '../includes/header.php';
?>
<div class="page-heading"><div><h1><?=$id?'Editar':'Cadastrar'?> produto</h1><p class="text-secondary mb-0">Informe os dados do item.</p></div><a class="btn btn-outline-secondary" href="index.php">Voltar</a></div>
<div class="card p-4"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<?php if($erro): ?><div class="alert alert-danger"><?=e($erro)?></div><?php endif; ?>
<div class="row g-3"><div class="col-md-6"><label class="form-label required">Nome</label><input class="form-control" name="nome" required value="<?=e($item['nome'])?>"></div>
<div class="col-md-6"><label class="form-label">SKU / Código</label><input class="form-control" name="sku" value="<?=e($item['sku'])?>"></div>
<div class="col-md-6"><label class="form-label required">Peso (kg)</label><input type="number" min="0" step="0.01" class="form-control" name="peso" required value="<?=e($item['peso'])?>"></div>
<div class="col-md-6"><label class="form-label required">Quantidade disponível</label><input type="number" min="0" step="1" class="form-control" name="quantidade" required value="<?=e($item['quantidade'])?>"></div>
<div class="col-12"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao" rows="3"><?=e($item['descricao'])?></textarea></div></div>
<button class="btn btn-primary mt-4">Salvar</button></form></div><?php require '../includes/footer.php'; ?>
