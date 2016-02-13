<?php
if(isset($_POST['conversaJanela'])){
	include_once "../confg.php";
	require_once("../class/BD.class.php");	
	$con= BD::conn();
	
	$mensagens = array();
	$id_conversa = (int)$_POST['conversaJanela'];
	$user_logado = (int)$_POST['de'];
	
	$pegarMsgs = $con->prepare("SELECT * FROM msg WHERE (id_de = ? AND id_para = ?) OR (id_de = ? AND id_para = ?) ORDER BY id DESC LIMIT 10");
	$pegarMsgs->execute(array($user_logado,$id_conversa,$id_conversa,$user_logado));
	while($row =$pegarMsgs->fetchObject()){
		if($user_logado == $row->id_de){
			$janela_de = $row->id_para; 
		}elseif($user_logado == $row->id_para){
			$janela_de = $row->id_de;
		}
		
		$mensagens[]= array(
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
	
	

	die(json_encode($mensagens));
}
?>