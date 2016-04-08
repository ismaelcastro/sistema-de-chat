// JavaScript Document
$(document).ready(function(){
			
	de = $("#barraL #infoUser .avatar").attr('id');
	function add_janelas(id, nome, avatar){
		
		var html_add =
		'<header class="header themeAzul" id="contato"> <span class="avatar"><img id="fotoUser" src="'+avatar+'"></span><div class="conteiner"><h1 class="nomeUser">'+nome+'<p class="status"></p></h1></div> <button id="mytrigger" class="butaoEviarAnexo"><span class="botaoAnexar"></span></button><form id="formupload" method="post" enctype="multipart/form-data" action="sys/upload.php"><input  type="file" id="'+id+'" name="arquivo" class="uploadFile" multiple></form></span></header><div id="jan_'+id+'" class="mensagens"><ul class="listar"></ul></div><div id="entrada"><span class="enviarmsg"><span class="figura_btn_enviar"> </span></span><input type="text" placeholder="Digite aqui sua mensagem e pressione enter para enviar" class="msg" id="'+id+'"></div>'
		;
		
		
		if($('#window').html()==""){
			$('#window').append(html_add);
		}else{
			$('#window').html('');
			$('#window').append(html_add);
		}
		
		
	};
	
	function retorna_historico(id_janela){
		$.ajax({
			type:'POST',
			url:"sys/historico.php",
			data:{conversaJanela:id_janela, de: de},
			dataType:'json',
			success: function(retorno){
				$.each(retorno,function(i, msg){
					if( $('#jan_'+msg.janela_de).length > 0 ){
						if(msg.mensagem == ""){
							var tipo = msg.tipo;
							if(msg.tipo == 'image'){
								elementos =	'<a class="downloadanex" href="'+msg.nome+'"><img width="320" heigth ="240" src="'+msg.caminho+'"></a>';	
							}else{
							switch(tipo){				
												
								case 'video':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconvideo';
								break;
								
								
								case 'audio':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconaudio';
															
									break;
								case 'pdf':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconpdf';											
									break;
								case 'doc':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconword';
									break;
								case 'docx':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconword';		

									break;
								case 'xlsx':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconexcel';
								
									break;
								case 'pptx':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconpp';
								
									break;
									
								case 'text':
									var nomeArquivo = msg.nome;
									var classe		= 'mini icontxt';
								
								break;
								
								default:
								break;
							};
					var elementos='<a class="downloadanex" href="'+nomeArquivo+'"><div class="'+classe+'"></div>'+nomeArquivo+'</a>';}
						
							if(de == msg.id_de){
								$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" class="right"><div class="boxmsg"> <span>'+elementos+'</span> </div></li>');
							}else{
								$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" ><div class="boxmsg"> <span>		'+elementos+'</span> </div></li>');
							};
							
						
						}else{
							if(de == msg.id_de){
								$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" class="right"><div class="boxmsg"><span>'+msg.mensagem+'</span></div></li>');
							}else{
								$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" ><div class="boxmsg"><span>'+msg.mensagem+'</span></div></li>');
							}
						}
					}
				});
				[].reverse.call($('#jan_'+id_janela+' li')).appendTo($('#jan_'+id_janela+' ul.listar'));
				var altura = $('#jan_'+id_janela).height();
				$('#jan_'+id_janela).animate({scrollTop:altura},{duration:1000},{easing:'easeOutQuad'});
			}
			
		});
	
	}
	
	
	
	function lermsg(usuariologado, remetente){
		$.ajax({
			url:"sys/ler.php",
			type:'POST',
			data:{usuario_logado:usuariologado,remetente:remetente, acao:"ler"},	
		
		});
	}
	
	
	function buscar_msg(timestamp, lastid, user){
			var t;
			$.ajax({
				url:'sys/live.php',
				type:'GET',
				data:'timestamp='+timestamp+'&lastid='+lastid+'&user='+user,
				dataType:'json',
				success: function(retorno){
					clearInterval(t);
					if(retorno.status == 'resultados' || retorno.status == 'vazio'){
						t = setTimeout(function(){
							buscar_msg(retorno.timestamp,retorno.lastid,de);
						},1000);
						if(retorno.status == 'resultados'){
							$.each(retorno.dados, function(i, msg){
								if( $('#jan_'+msg.janela_de).length > 0 && $('.mensagens .listar #'+msg.id).length == 0 ){
									if(msg.mensagem == ""){
										var tipo = msg.tipo;
							if(msg.tipo == 'image'){
								elementos =	'<a class="downloadanex" href="'+msg.nome+'"><img width="320" heigth ="240" src="'+msg.caminho+'"></a>';	
							}else{
							switch(tipo){				
												
								case 'video':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconvideo';
								break;
								
								
								case 'audio':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconaudio';
															
									break;
								case 'pdf':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconpdf';											
									break;
								case 'doc':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconword';
									break;
								case 'docx':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconword';		

									break;
								case 'xlsx':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconexcel';
								
									break;
								case 'pptx':
									var nomeArquivo = msg.nome;
									var classe		= 'mini iconpp';
								
									break;
									
								case 'text':
									var nomeArquivo = msg.nome;
									var classe		= 'mini icontxt';
								
								break;
								
								default:
								break;
							};
								var elementos='<a class="downloadanex" href="'+nomeArquivo+'"><div class="'+classe+'"></div>'+nomeArquivo+'</a>';}
										
											if(de == msg.id_de)
											{
												$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" class="right"><div class="boxmsg"><div><span>'+elementos+'</span></div></li>');
											}
											else
											
											{
												$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" ><div class="boxmsg"><span>'+elementos+'</span></div></li>');
													
											};
							
							
								}else
								{
									if(de == msg.id_de)
									{
										$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" class="right"><div class="boxmsg"><span>'+msg.mensagem+'</span></div></li>');
									}
									else
									{
										$("#jan_"+msg.janela_de+' ul.listar').append('<li id="'+msg.id+'" ><div class="boxmsg"><span>'+msg.mensagem+'</span></div></li>');
									}
								}
								var altura = $('.mensagens').height();
								$('.mensagens').animate({scrollTop:altura},{duration:1000},{easing:'easeOutQuad'});
								}
							});
						}
					}
				},
				error:function (){
				}
			});
	};
	
	buscar_msg(0,0,de);
	
	function buscar_notificacoes(user, ultimoid){
		var t;
		$.ajax({
			url:"sys/notify.php",
			type:'GET',
			data: 'user='+user +'&ultimoid='+ultimoid,
			dataType:'json',
			success: function(res){
				switch(res.resposta){
					case 'dados':
					$.each(res.dadosmsg,function(i,res){
						
						var id_de = res.of;
						var notificacoes = res.quant;
							ultimoid = res.lastid;
						if($("#jan_"+id_de).length == 0){
							$.playSound('sys/notify');
							$(".contatos ul li a#"+id_de+" .naolido").html(notificacoes).css({'display':'block'});
							$("title").append(" ("+notificacoes+")");
						}

							clearInterval(t);
							t = setTimeout(function(){
							buscar_notificacoes(de,ultimoid)
							},1000);
			
						
					});
										
						
					
					
					break;
					case 'vazio':
						clearInterval(t);
						t = setTimeout(function(){
						buscar_notificacoes(de,ultimoid)
						},1000);
					break;
				}
				
			},
			error:function(){
				clearInterval(t);
				t =setTimeout(function(){buscar_notificacoes(de,0)},15000);
				
			}
				
		});	
	
	}
	
	
	buscar_notificacoes(de,0);
	
	function status(userConversa){
		var t;
		$.ajax({
			url:'sys/status.php',
			type:'POST',
			dataType:'json',
			data:{'acao':'status','janela':userConversa},
			success: function(res){
				$(".nomeUser p.status").html(res);
				clearInterval(t);
				t = setTimeout(function(){
					status(userConversa);
				},200000);
			}
		});
	}
	
	
	$(".comecar").on('click',function(){
		
		var id = $(this).attr('id');
		var nome = $(this).attr('nome');
		var avatar = $(this).children(".avatar").children('img').attr('src');
		add_janelas(id, nome, avatar);
		retorna_historico(id);
		status(id);
		lermsg(de,id);
		if($(this).children(".naolido").length >0){
			$(this).children('.naolido').html("").css({'display':'none'});
		}
		return false;
				
			
		
	});
	
	$('body').delegate('.msg','focus',function(e){
			var campo     = $(this);
			var to        = campo.attr('id');
			
			lermsg(de,to);
	});
	
	 $("body").delegate('.butaoEviarAnexo','click',function(){
			$('.uploadFile').click();			
		});
	

	
	
});