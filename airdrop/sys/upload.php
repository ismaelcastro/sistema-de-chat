<?php
	session_start();
	include_once("../confg.php");
	require_once("../class/BD.class.php");
	$con = BD::conn();
	$para = $_POST['para'];
	$de   = $_SESSION['id_user'];
	$dir =date("smy");
	mkdir("../uploads/".$dir);
	foreach($_FILES['arquivo']['error'] as $key =>$error){
		
		if($error == UPLOAD_ERR_OK){
			$nome = utf8_decode($_FILES['arquivo']['name'][$key]);
			$tipo = $_FILES['arquivo']['type'][$key];
			move_uploaded_file($_FILES['arquivo']['tmp_name'][$key],'../uploads/'.$dir.'/'.$nome);
			$insert = $con->prepare("INSERT INTO msg (id_de, id_para, caminhoAnexo,nome,tempo, lido, data, tipo) VALUES(?,?,?,?,?,0,NOW(),?)");
			$insert->execute(array($de,$para,'uploads/'.$dir.'/'.$nome,$nome,time(),$tipo));
		}else{
			echo json_encode($_FILES['arquivo']['error'][$key]);
		}
	}
	
	
?>