<?php
require '../config/database.php';require '../includes/functions.php';verify_csrf();
$id=0;$item=['nome'=>'','documento'=>'','telefone'=>'','email'=>'','veiculo'=>'','placa'=>''];
if($id){$s=$pdo->prepare("SELECT * FROM transportadores WHERE id=?");$s->execute([$id]);$item=$s->fetch()?:redirect('index.php');}
$erro='';
if($_SERVER['REQUEST_METHOD']==='POST'){foreach($item as $k=>$v)$item[$k]=trim($_POST[$k]??'');
if($item['nome']==='')$erro='Informe o nome do transportador.';else{$v=array_values($item);if($id){$s=$pdo->prepare("UPDATE transportadores SET nome=?,documento=?,telefone=?,email=?,veiculo=?,placa=? WHERE id=?");$s->execute([...$v,$id]);}else{$s=$pdo->prepare("INSERT INTO transportadores(nome,documento,telefone,email,veiculo,placa) VALUES(?,?,?,?,?,?)");$s->execute($v);}flash('Transportador salvo com sucesso.');redirect('index.php');}}
$pageTitle=$id?'Editar transportador':'Cadastrar transportador';require '../includes/header.php';?>
<div class="page-heading"><div><h1><?=$id?'Editar':'Cadastrar'?> transportador</h1><p class="text-secondary mb-0">Dados para identificação e contato.</p></div><a class="btn btn-outline-secondary" href="index.php">Voltar</a></div>
<div class="card p-4"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><?php if($erro):?><div class="alert alert-danger"><?=e($erro)?></div><?php endif;?>
<div class="row g-3"><?php $fields=['nome'=>'Nome / Razão social','documento'=>'CPF / CNPJ','telefone'=>'Telefone','email'=>'E-mail','veiculo'=>'Tipo de veículo','placa'=>'Placa'];foreach($fields as $key=>$label):?><div class="col-md-6"><label class="form-label <?=$key==='nome'?'required':''?>"><?=e($label)?></label><input class="form-control" name="<?=e($key)?>" value="<?=e($item[$key])?>" <?=$key==='nome'?'required':''?>></div><?php endforeach;?></div><button class="btn btn-primary mt-4">Salvar</button></form></div><?php require '../includes/footer.php';?>
