<?php
if(isset($_POST['acao']) && !empty($_POST['acao'])){
	include_once "../confg.php";
	require_once("../class/BD.class.php");	
	$con= BD::conn();
	
	$id_de   = (int)$_POST['remetente'];
	$id_para = (int)$_POST['usuario_logado'];
	
	$ler = $con->prepare("UPDATE msg SET lido = 1 WHERE id_de = ? AND id_para = ?");
	$ler->execute(array($id_de, $id_para));
	
}

?>