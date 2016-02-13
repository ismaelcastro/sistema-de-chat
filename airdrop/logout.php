<?php
	session_start();
	
if(isset($_POST['acao']) && $_POST['acao'] == 'sair'){
	include_once("confg.php");
	require_once("class/BD.class.php");
	$con = BD::conn();
	$sql= $con->prepare("UPDATE usuarios SET status = 0,logoff = NOW() WHERE id = ?");
	$sql->execute(array($_SESSION['id_user']));
	unset($_SESSION['id_user']);
	session_destroy();
		
}
header("Location: index.php");
?>