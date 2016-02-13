<?php
	session_start();
	include_once("confg.php");
	require_once("class/BD.class.php");
	$con = BD::conn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8" />
<script src="js/jquery.js">
</script>
<script src="js/indexjs.js"></script>
<title>AirDrop Office menssager - Solução em comunicação para sua empresa</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css">
<link href="fonte/stylesheet.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
	if(isset($_POST['acao']) && $_POST['acao']=='logar'):
	
		$email=strip_tags(filter_input(INPUT_POST,"email",FILTER_SANITIZE_STRING));
		$senha = $_POST['senha'];
		if($email=="")
		{
		
		
		}else
		
		{	
			
			$obter_usuario = $con->prepare('SELECT id FROM usuarios WHERE email = ? AND senha = ?');
			$obter_usuario->execute(array($email,md5($senha)));
			
			if($obter_usuario->rowCount()== 0){
				
				echo '<script>alert("Usuario não encontrado")</script>';
			}
			else
			{
				$fecth = $obter_usuario->fetchObject();
				$_SESSION['id_user']= $fecth->id;
				$sql = $con->prepare("UPDATE usuarios SET status=1 WHERE id= ?");
				$sql->execute(array($_SESSION['id_user']));
				echo '<script>location.href="chat.php"</script>';
				
			}
		}
		
		
	endif;
?>
	<header>
    	<div id="head">
    		<h1 title="logo" id="logo"></h1>
        </div>       	
       
    </header>
    <div id="base">
		<div id="formulario">
    		<ul>
            	
        		
            	<li>
            		<h1>Cadastro</h1>
        			<form >
        				<span>CPF:</span><br>
            			<input type="text" class="campo" id="cpf" name="cpf"><br>
            			<span>Email:</span><br>
            			<input type="email" class="campo" id="email" name="email"><br>
            			<span>Nome do Usuário:</span><br>
            			<input type="text" class="campo" id="nome" name="nome"><br>
            			<input type="submit" class="butao" id="butao" value="Prosseguir">
        			</form>
            	</li>
                <li>
            		<h1>Login</h1>
        			
    				<form name="" enctype="multipart/form-data" method="post">
        				<span>Email:</span><br>
            			<input class="campo" name="email" id="email" type="Email"><br>
                       
            			<span>Senha:</span><br>
            			<input class="campo" name="senha" id="senha" type="password">
                        <br>
            			<input type="hidden" name="acao" value="logar">
            			<input type="submit" value="Logar">
            		
            
            		</form>
            	</li>
                
    		</ul>
            
            
     	</div>
        <section class="sobre">
            	<h1 title="logo" id="logo">
                	
                </h1>
                <p>AirDrop Office é um aplicativo web desenvolvido para permitir a comunicação rápida e segura entre escritórios e filiais de empresas sem
                que esta tenha a necessidade de instalar nenhuma infra-estrutura  extra. Com o AirDrop Office você pode trocar mensagens instantâneas,
                enviar arquivos de diversos tipos. Bastando apenas estar conectado a internet.</p>
                
                <ul>
                	<li>
                    	<img width="70" height="70" src="img/img01.png">
                        <span>Troca de mensagens</span>
                        <p>
                       
                        Troque mensagem entre departamento de
                        sua empresa de forma particular e segura.
                        </p>
                    </li>
                    <li>
                    	<img src="img/img02.png" height="70" width="70">
                        
                        <span>Mobilidade</span>
                        <p>
                        Acesse de onde estiver, a qualquer hora.
                        </p>
                    </li>
                    <li>
                    	<img src="img/img3.png" width="70" height="70">
                        <span>Privacidade e Segurança</span>
                        <p>
                        Os usuarios so podem conversar com usuarios 
                        cadastrados e vinculados a sua empresa.
                        </p>
                    </li>
                    <li>
                    	<img src="img/img4.png" height="70" width="70">
                        <span>Infraestrutura</span>
                        <p>
                        Facil instalação não requer investimento em 
                        infra estrutura, basta conecxão com a internet
                        </p>
                    </li>
                </ul>
        </section>
	</div>
</body>
</html>
