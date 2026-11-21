<?php
require '../config/database.php'; require '../includes/functions.php'; verify_csrf();
$id=(int)($_GET['id']??0);$item=['identificacao'=>'','logradouro'=>'','numero'=>'','complemento'=>'','bairro'=>'','cidade'=>'','estado'=>'','cep'=>''];
if($id){$s=$pdo->prepare("SELECT * FROM enderecos WHERE id=?");$s->execute([$id]);$item=$s->fetch()?:redirect('index.php');}
$erro='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 foreach($item as $k=>$v)$item[$k]=trim($_POST[$k]??'');
 if($item['identificacao']===''||$item['logradouro']===''||$item['cidade']===''||$item['estado']==='')$erro='Preencha identificação, logradouro, cidade e estado.';
 else{
 $values=array_values($item);
 if($id){$s=$pdo->prepare("UPDATE enderecos SET identificacao=?,logradouro=?,numero=?,complemento=?,bairro=?,cidade=?,estado=?,cep=? WHERE id=?");$s->execute([...$values,$id]);}
 else{$s=$pdo->prepare("INSERT INTO enderecos(identificacao,logradouro,numero,complemento,bairro,cidade,estado,cep) VALUES(?,?,?,?,?,?,?,?)");$s->execute($values);}
 flash('Endereço salvo com sucesso.');redirect('index.php');
 }}
$pageTitle=$id?'Editar endereço':'Cadastrar endereço';require '../includes/header.php';?>
<div class="page-heading"><div><h1><?=$id?'Editar':'Cadastrar'?> endereço</h1><p class="text-secondary mb-0">Cadastre locais que poderão ser usados como origem ou destino.</p></div><a class="btn btn-outline-secondary" href="index.php">Voltar</a></div>
<div class="card p-4"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><?php if($erro):?><div class="alert alert-danger"><?=e($erro)?></div><?php endif;?>
<div class="row g-3"><?php $fields=['identificacao'=>'Identificação (ex.: Depósito)','logradouro'=>'Logradouro','numero'=>'Número','complemento'=>'Complemento','bairro'=>'Bairro','cidade'=>'Cidade','estado'=>'Estado (UF)','cep'=>'CEP'];foreach($fields as $key=>$label):?><div class="col-md-6"><label class="form-label <?=$key==='identificacao'||$key==='logradouro'||$key==='cidade'||$key==='estado'?'required':''?>"><?=e($label)?></label><input class="form-control" name="<?=e($key)?>" value="<?=e($item[$key])?>" <?=$key==='identificacao'||$key==='logradouro'||$key==='cidade'||$key==='estado'?'required':''?>></div><?php endforeach;?></div><button class="btn btn-primary mt-4">Salvar</button></form></div><?php require '../includes/footer.php';?>
