<?php
if(isset($_GET)){
	include_once "../confg.php";
	require_once("../class/BD.class.php");	
	$con= BD::conn();
	
	$user_logado = (int)$_GET['user'];
	$timestamp	 = ($_GET['timestamp'] == 0)? time(): strip_tags(trim($_GET['timestamp']));
	$lastid		 = (isset($_GET['lastid']) && !empty($_GET['lastid']))? $_GET['lastid'] : 0;

	if(empty($timestamp)){
		die( json_encode(array('status' => 'erro')) );
	};
	
	$lastidQuery = "";
	$tempoGasto = 0;

	
	if(!empty($lestid)){
		$lastidQuery = ' AND id > '.$lestid;
	};
	
	if($_GET['timestamp'] == 0){
		$verifica = $con->prepare("SELECT * FROM msg WHERE lido = 0 ORDER BY id DESC");
	}else{
		$verifica = $con->prepare("SELECT * FROM msg WHERE tempo >= $timestamp".$lastidQuery." AND lido = 0 ORDER BY id DESC");
	}
	$verifica->execute();
	$resultados = $verifica->rowCount();

	if($resultados <= 0 ){
		while($resultados <= 0 ){
			if($tempoGasto >= 28){
				die(json_encode(array('status'=> 'vazio', 'timestamp' => time(), 'lastid' => 0)));
				
			}
			sleep(1);			
			if($_GET['timestamp'] == 0){
				$verifica = $con->prepare("SELECT * FROM msg WHERE lido = 0 ORDER BY id DESC");
			}else{
				$verifica = $con->prepare("SELECT * FROM msg WHERE tempo >= $timestamp".$lastidQuery." AND lido = 0 ORDER BY id DESC");
			}
			$verifica->execute();
			$resultados = $verifica->rowCount();
			$tempoGasto +=1;
			
		}
	}
	
	$novasMensagens = array ();
	if($resultados >= 1){
		while($row = $verifica->fetchObject()){
			if($user_logado == $row->id_de){
				$janela_de = $row->id_para; 
			}elseif($user_logado == $row->id_para){
				$janela_de = $row->id_de;
			}
		
			$novasMensagens[]= array(
			'id'       => $row->id,
			'mensagem' => utf8_encode($row->menssagem),
			'id_de'    => $row->id_de,
			'id_para'  => $row->id_para,
			'janela_de'=> $janela_de,
			'caminho' => utf8_encode($row->caminhoAnexo),
			'tipo'     => $row->tipo,
			'nome'		=>utf8_encode($row->nome)
			);
		}
	}
	$ultimaMsg = end($novasMensagens);
	$ultimaid = $ultimaMsg['id'];
	
	die(json_encode(array('status'=> 'resultados', 'timestamp' => time(), 'lastid' => $ultimaid, 'dados' => $novasMensagens)));


}
?>