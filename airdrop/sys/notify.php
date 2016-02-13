<?php
if(isset($_GET['user'])){
	include_once "../confg.php";
	require_once("../class/BD.class.php");	
	$con= BD::conn();
	
	$user     = (int)$_GET['user'];
	$ultimoId = (int)$_GET['ultimoid'];
		
	if($ultimoId > 0){
		$pegaIdDe = $con->prepare("SELECT DISTINCT id_de FROM msg WHERE id > ? AND id_para= ? AND lido = 0");
		$pegaIdDe->execute(array($ultimoId,$user));
	}else{
		$pegaIdDe = $con->prepare("SELECT DISTINCT id_de FROM msg WHERE id_para= ? AND lido = 0");
		$pegaIdDe->execute(array($user));
	
	};
	
	if($pegaIdDe->rowCount() > 0){
	
		while($row = $pegaIdDe->fetchObject()){
		$id_de[] = $row->id_de;
	
		}
	}
		$tempoGastro = 0;
		$resultados  = $pegaIdDe->rowCount();
		
		while($resultados == 0){
			
			if($tempoGastro >= 28){
				$dados[] = array( 
				'of'=> 0,
				'quant'	=> 0,
				
				);
				$resposta = 'vazio';
				die(json_encode(array('dadosmsg'=>$dados,'resposta'=>$resposta)));
				exit;
			}
			sleep(1);
			if($ultimoId > 0){
				$pegaIdDe = $con->prepare("SELECT DISTINCT id_de FROM msg WHERE id > ? AND id_para= ? AND lido = 0");
				$pegaIdDe->execute(array($ultimoId,$user));
			}else{
				$pegaIdDe = $con->prepare("SELECT DISTINCT id_de FROM msg WHERE id_para= ? AND lido = 0");
				$pegaIdDe->execute(array($user));
			};
			
			$resultados  = $pegaIdDe->rowCount();
			$tempoGastro+=1;
		}
		
	
	
		while($row = $pegaIdDe->fetchObject()){
			$id_de[] = $row->id_de;
		}
		$resposta = 'dados';
		
		
		foreach($id_de as $indice => $id){
			$qant =$con->prepare("SELECT * FROM msg WHERE id_de = ? AND id_para = ? AND lido = 0")or die (mysql_error());
			$qant->execute(array($id,$user));
			$notify = $qant->rowCount();
			while($row = $qant->fetchObject()){
				$id_of [] = $row->id;
				$lestid = end($id_of);
			}
			if($lestid == NULL || $lestid == 0){
				$ultimoId = 0;
				
			}
			
			$dados[$indice] = array( 
			'of'=> $id,
			'quant'	=> $notify,
			'lastid' => $lestid);
			
			
		};
		
		
		
		die(json_encode(array('dadosmsg'=>$dados,'resposta'=>$resposta)));
	

	
}
?>