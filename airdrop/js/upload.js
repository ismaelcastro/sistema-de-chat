// JavaScript Document
$(document).ready(function() {
	$('body').delegate('.uploadFile','change',function(){
		var file  = this.files;
		var leng  = file.length;
		var to    = $(this).attr("id");
	
		var formdata = new FormData();
		var i = 0;
		
		for(;i<leng ;i++){
			files = file[i];
			if(!!files.type.match(/image.*/)){
				var tipoArquivo = "imagem";
			}if(!!files.type.match(/video.*/)){
				var tipoArquivo = "video";
			}if(!!files.type.match(/pdf.*/)){
				var tipoArquivo = "pdf";
			}if(!!files.type.match(/word.*/)){
				var tipoArquivo = "word";
			}if(!!files.type.match(/audio*/)){
				var tipoArquivo = "audio";
			}if(!!files.type.match(/spreadsheetml*/)){
				var tipoArquivo = "excel";
			}if(!!files.type.match(/presentationml*/)){
				var tipoArquivo = "pp";
			}if(!!files.type.match(/text*/)){
				var tipoArquivo = "texto";
			}
			
			
			formdata.append('arquivo[]',files);
			if(tipoArquivo == "imagem"){
				if(window.FileReader){
						reader = new FileReader();
						reader.onloadend = function(e){
						mostarUploadItem(tipoArquivo,e.target.result, files.filename);
						}
				reader.readAsDataURL(files);
				}
			}else{
				mostarUploadItem(tipoArquivo, files.name);
			}

		};
		
			
		
		
		function mostarUploadItem(tipo,source){
			switch(tipo){
				case 'imagem':
				var html = '<li class="right"> <div class="boxmsg"><img class="mini" width="320" heigth ="240" src="'+source+'"><div class="progress"><div class="load"></div></div> </li>';
					break;
				case 'video':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini iconvideo"></div>'+source+'</span><div class="progress"><div class="load"></div></div></div> </li>';
				break;
				case 'audio':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini iconaudio"></div>'+source+'</span><div class="progress"><div class="load"></div></div></div> </li>';
				break;
				case 'word':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini iconword"></div>'+source+'</span><div class="progress"><div class="load"></div></div></div> </li>';
				break;
				case 'excel':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini iconexcel"></div>'+source+'</span><div class="progress"><div class="load"></div></div> </div></li>';
				break;
				case 'pp':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini iconpp"></div>'+source+'</span><div class="progress"><div class="load"></div></div></div> </li>';
				break;
				case 'pdf':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini iconpdf"></div>'+source+'</span><div class="progress"><div class="load"></div></div></div> </li>';
				break
				case 'texto':
					var html = '<li class="right"> <div class="boxmsg"><span><div class="mini icontext"></div>'+source+'</span><div class="progress"><div class="load"></div></div></div> </li>';
				break;
			
			}
			$('#jan_'+to+' .listar').append(html);
			
			
		};
		
		formdata.append('para',to);
		
		$.ajax({
			url:"sys/upload.php",
			type:'POST',
			data:formdata,
			processData:false,
			contentType:false,
			xhr: function(){
				var xhr = new window.XMLHttpRequest();
				xhr.addEventListener('progress', function(evt){
					if(evt.lengthComputable){
						var percentComplete = evt.loaded / evt.total;
						var largura = Math.round(percentComplete * 100);
						$('.load').css({'width':largura + '%'});
						
					}
				},false);
				return xhr;
				
				
			},
			beforeSend: function(){
				var altura = $('.mensagens').height();
				$('.mensagens').animate({scrollTop:altura},{duration:1000},{easing:'easeOutQuad'});
			},
			complete: function(){
				
			},
			success: function(res){
				if(res !=""){
					switch(res){
						case '1' :
						alert("Arquivo muito grande. Tamanho máximo permitido 60mb!");
					}
				};
				$('.progress').parent().parent().fadeOut('fast').remove();
			}
			
		});
	});
	

		
});
