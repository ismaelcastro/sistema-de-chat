// JavaScript Document
$(function(){
	var id_de = Number($(".avatar").attr('id'));
	
	$('body').delegate('.msg','keydown',function(e){
			var campo     = $(this);
			var msg       = campo.val();
			var to        = campo.attr('id');
			
			if(e.which == 13){
				
				if(msg != ""){
					
					$.ajax({
						
						url:'sys/chat.php',
						type:'POST',
						data:{menssagem: msg, de:id_de, para: to},				
						success:function(retorno){
							if(retorno == 'ok'){
								campo.val('');
							}else{
								alert(retorno);
							
							}
							
						}
					});
				}
			}
	});
				
			
				

$('.menu').click(function(){
			$(this).children('ul').slideToggle('fast');
		});
		

});