<?php
if(isset($_POST['conversaJanela'])){
	include_once "../confg.php";
	require_once("../class/BD.class.php");	
	$con= BD::conn();
	
	
	$id_conversa = (int)$_POST['conversaJanela'];
	$user_logado = (int)$_POST['de'];
	$anexos = array();
	$pegarMsgs = $con->prepare("SELECT * FROM anexos WHERE (id_de = ? AND id_para = ?) OR (id_de = ? AND id_para = ?) ORDER BY id DESC LIMIT 4");
	$pegarMsgs->execute(array($user_logado,$id_conversa,$id_conversa,$user_logado));
	while($row =$pegarMsgs->fetchObject()){
		if($user_logado == $row->id_de){
			$janela_de = $row->id_para; 
		}elseif($user_logado == $row->id_para){
			$janela_de = $row->id_de;
		}
		
		$anexos[]= array(
			'id'       => $row->id,
			'nome'		=> utf8_decode($row->nome),
			'caminho' => $row->caminho,
			'id_de'    => $row->id_de,
			'id_para'  => $row->id_para,
			'tipo'     => $row->tipo,
			'janela_de'=> $janela_de
		);
	}
	
	die(json_encode($anexos));
}
?>