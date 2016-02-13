// JavaScript Document
$(function(){
$("input[type='submit']").click(function(e){
	e.preventDefault();
	var erro=0;
	
	$(".campos:visible").each(function(){
		//$(this).val().length <= 0 ? erro++ : "";//
		if($(this).val().length <=0){
			erro++;
			
			$("#msg").css("display","block");
			} 
		
	
	});
				
	if(erro > 0){
		
	}else{
	
	
		$(this).parent("form").submit();
	
	
	
	}



});
});
