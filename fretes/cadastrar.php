<?php
require '../config/database.php';require '../includes/functions.php';verify_csrf();
$produtos=$pdo->query("SELECT id,nome,sku FROM produtos ORDER BY nome")->fetchAll();
$enderecos=$pdo->query("SELECT id,identificacao,cidade,estado FROM enderecos ORDER BY identificacao")->fetchAll();
$transportadores=$pdo->query("SELECT id,nome FROM transportadores ORDER BY nome")->fetchAll();
$erro='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $transportador=(int)($_POST['transportador_id']??0);$origem=(int)($_POST['origem_id']??0);$destino=(int)($_POST['destino_id']??0);
 $data=$_POST['data_frete']??date('Y-m-d');$status=$_POST['status']??'Pendente';$ids=$_POST['produto_id']??[];$qtds=$_POST['quantidade']??[];
 if(!$transportador||!$origem||!$destino||$origem===$destino||!$ids)$erro='Selecione transportador, origem, destino diferentes e pelo menos um produto.';
 else{
  try{$pdo->beginTransaction();
   $s=$pdo->prepare("INSERT INTO fretes(data_frete,transportador_id,origem_id,destino_id,status,observacoes) VALUES(?,?,?,?,?,?)");
   $s->execute([$data,$transportador,$origem,$destino,$status,trim($_POST['observacoes']??'')]);$freteId=(int)$pdo->lastInsertId();
   $ins=$pdo->prepare("INSERT INTO frete_produtos(frete_id,produto_id,quantidade) VALUES(?,?,?)");
   foreach($ids as $index=>$produtoId){$qtd=(int)($qtds[$index]??0);if((int)$produtoId>0&&$qtd>0)$ins->execute([$freteId,(int)$produtoId,$qtd]);}
   $pdo->commit();flash('Frete gerado com sucesso.');redirect('index.php');
  }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$erro='Não foi possível gerar o frete. Confira os dados e tente novamente.';}
 }
}
$pageTitle='Gerar frete';require '../includes/header.php';?>
<div class="page-heading"><div><h1>Gerar frete</h1><p class="text-secondary mb-0">Relacione transportador, endereços e um ou mais produtos.</p></div><a class="btn btn-outline-secondary" href="index.php">Voltar</a></div>
<div class="card p-4"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><?php if($erro):?><div class="alert alert-danger"><?=e($erro)?></div><?php endif;?>
<div class="row g-3"><div class="col-md-6"><label class="form-label required">Transportador</label><select name="transportador_id" class="form-select" required><option value="">Selecione</option><?php foreach($transportadores as $t):?><option value="<?=$t['id']?>"><?=e($t['nome'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label required">Data do frete</label><input type="date" name="data_frete" class="form-control" value="<?=date('Y-m-d')?>" required></div>
<div class="col-md-6"><label class="form-label required">Origem</label><select name="origem_id" class="form-select" required><option value="">Selecione</option><?php foreach($enderecos as $a):?><option value="<?=$a['id']?>"><?=e($a['identificacao'].' - '.$a['cidade'].'/'.$a['estado'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label required">Destino</label><select name="destino_id" class="form-select" required><option value="">Selecione</option><?php foreach($enderecos as $a):?><option value="<?=$a['id']?>"><?=e($a['identificacao'].' - '.$a['cidade'].'/'.$a['estado'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option>Pendente</option><option>Em trânsito</option><option>Concluído</option><option>Cancelado</option></select></div>
<div class="col-12"><hr><div class="d-flex justify-content-between align-items-center mb-2"><h2 class="h5 mb-0">Produtos do frete</h2><button type="button" id="add-product" class="btn btn-sm btn-outline-primary">+ Adicionar produto</button></div>
<div id="product-list"><div class="product-row row g-2 align-items-end mb-2"><div class="col-md-8"><label class="form-label">Produto</label><select name="produto_id[]" class="form-select" required><option value="">Selecione</option><?php foreach($produtos as $p):?><option value="<?=$p['id']?>"><?=e($p['nome'].($p['sku']?' - '.$p['sku']:''))?></option><?php endforeach;?></select></div><div class="col-md-2"><label class="form-label">Quantidade</label><input type="number" name="quantidade[]" class="form-control" min="1" value="1" required></div><div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100 remove-product">Remover</button></div></div></div></div>
<div class="col-12"><label class="form-label">Observações</label><textarea name="observacoes" class="form-control" rows="2"></textarea></div></div>
<button class="btn btn-primary mt-4">Salvar frete</button></form></div><?php require '../includes/footer.php';?>
