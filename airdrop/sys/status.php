<?php
	include_once("../confg.php");
	require_once("../class/BD.class.php");
	$con = BD::conn();
	$userConversa = $_POST['janela'];
	

	$sql = $con->prepare("SELECT * FROM usuarios WHERE id= ?");
	$sql->execute(array($userConversa));
	
	if($sql->rowCount() > 0){
		$row = $sql->fetchObject();
		
		$colStatus = $row->status;
		if($colStatus == 1){
			$status = "Online";
		}else{
			$tempo = explode(' ',$row->logoff);
			$data = explode("-",$tempo[0]);
			list($ano,$mes,$dia) = $data;
			$calendar = $dia."/".$mes."/".$ano;
			if($calendar == date("d/m/Y")){
				$status = "Última vez Online hoje às ".$tempo[1];
					
			}else{
				$status = "Última vez Online às ".$tempo[1]." em ".$calendar;
			}
		}
			
		
	}
	die(json_encode($status));
?>