<?php
	if(isset($_POST['menssagem'])){
		include_once "../confg.php";
		require_once("../class/BD.class.php");	
		$con= BD::conn();
	
		$mensagem = utf8_decode(strip_tags(trim(filter_input(INPUT_POST,'menssagem',FILTER_SANITIZE_STRING))));
		$de   = (int)$_POST['de'];
		$para = (int)$_POST['para'];
		
		if($mensagem != ''){
			$insertMsg = $con->prepare("INSERT INTO msg (id_de, id_para, menssagem, data,tempo, lido) VALUES (?,?,?,NOW(),?,0)");
			if( $insertMsg->execute(array($de,$para,$mensagem,time())) ){
				echo "ok";
			}else{
				echo "no";
			}
		
		}
			
	}
?>