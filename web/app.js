$( document ).ready(function() {
   
	$("#btn_validate_user").on("click",function(){		
		
		$.ajax({
			url:"/CheckUser",
			type:"POST",
			dataType:"json",
			data:{
				user:$("#user").val(),
				pin:$("#pin").val(),
			},
			success:function(r){			
				var obj = JSON.parse(r.status);
						
				if(obj == true){
					$("#alerts").addClass("bg-success");
					$("#alerts").html("Usuario valido");
					$("#step1").fadeOut(1000,function(){
						$("#step2").fadeIn(500);
					});
				}else{
					$("#alerts").addClass("bg-warning");
					$("#alerts").html("Usuario invalido");
				}
			
			}
		});
		
	});
	
	$("#btn_get_money").on("click",function(){
		
		$.ajax({
			url:"/GetMoney",
			type:"POST",
			dataType:"json",
			data:{
				amount:$("#amount").val(),
			},
			success:function(r){
				
				var amounts = "";
				$("#alerts").removeClass();
				if(r.error == false || r.error == null){
					$("#alerts").addClass("bg-success");
					
					$.each(r.amounts,function(key,val){
						amounts += val+"<br>";
					});
					
					$("#alerts").html("<h4>Transacci&#243;n exitosa:</h4>"+amounts);
				}else{
					$("#alerts").addClass("bg-warning");
					$("#alerts").html("<h4>Transacci&#243;n fallida:</h4>"+r.error);
				}
			
			}
		});
		
	});
	
});


