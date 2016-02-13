<?php
	session_start();
	if(isset($_SESSION['id_user']) && !empty($_SESSION['id_user']) ){
	
	}else{header("Location: index.php");
	}
	include_once("confg.php");
	require_once("class/BD.class.php");
	$con = BD::conn();
?>
<!DOCTYPE html>
<html lang="pt-br"><head>
<meta charset="utf-8" />
<script src="js/jquery.js"></script>
<script src="js/chat.js"></script>
<script src="js/play.js"></script>
<script src="js/function.js"></script>
<script src="js/upload.js"></script>
<script src="js/download.js"></script>

<link href="css/estilochat.css" rel="stylesheet" type="text/css">
<link href="fonte/stylesheet.css" rel="stylesheet" type="text/css">
<title>Conversas</title>
</head>
<body>
<?php
					$pegarUsuario = $con->prepare('SELECT * FROM usuarios WHERE id = ?');
					$pegarUsuario->execute(array($_SESSION['id_user']));
					if($pegarUsuario->rowCount() == 0){
					}else{
						$usuario  = $pegarUsuario->fetchObject();
						$nomeUser = $usuario->nome;
						$vatar    = $usuario->avatar;
						$id		  = $usuario->id;
					}
?>
	<header id="cabecalho">
    	<div id="head">
    		<h1 title="logo" id="logo"></h1>
        </div>       	
       
    </header>
    <div id="base">
        <div id="window">
        	 
   				
   		</div>
      	<section id="barraL">
        <header class="header themeAzul" id="infoUser">
                <span class="avatar" id="<?php echo $id ;?>">
                   	<img id="fotoUser" src="<?php echo $vatar ;?>">
               	</span>
                
                <span class="menu">
                	<ul>
                    	<li>
                        	<span>Personalise</span>
                            <div>
                            	
                            </div>
                        </li>
                		<li>
                        	<a href="">Perfil e Status</a>
                        </li>
                        <li>
                        	<a id="sair" href="logout.php">Sair</a>
                        </li>
                        
               		</ul>
                </span>
               
        
        </header>
       
        	<form>
            	<input type="search" placeholder="Procurar contatos"><img>
            </form>
			<div id="contatos" class="contatos">
    			
        		<ul>
       		 	<?php
					$Select_usuarios = $con->prepare('SELECT * FROM usuarios WHERE id != ?');
					$Select_usuarios->execute(array($_SESSION['id_user']));
			
					if($Select_usuarios->rowCount() == 0){
					
					}else{
						while($usuario = $Select_usuarios->fetchObject()){
						$id = $usuario->id;
						$id =ltrim($id," ");
				?>
					<li><a href="javascript:void(0);" nome="<?php echo $usuario->nome; ?>" id="<?php echo $id; ?>" class="comecar"><span class="naolido"></span> <span class="avatar"><img src="<?php echo $usuario->avatar; ?>"></span><?php echo $usuario->nome; ?> </a>  </li>
                   
			<?php }} ?>   
      	</ul>
		
    	</div>
	</section>    
   		
  
    </div>  
</body>
</html>

