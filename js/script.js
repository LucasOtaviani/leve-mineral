jQuery(document).ready(function($) { 
		$(".scroll").click(function(event){        
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top}, 800);
	});
});

function buscar(nome, email, mensagem){
	$.ajax({
		type:'POST',
		url: 'src/Mailer.php',
		data: {fnome: nome, femail: email, fmensagem: mensagem,}, 
		success: function(msg) {
                if (msg == "Mensagem enviada com sucesso!") {
                    $(".toast-body").css("background-color", "#28a746");
			}

			else {
				$(".toast-body").css("background-color", "#dc3546");
			}

			$(".toast-body").html(msg);
			$(".toast").toast({delay:5000});
            $('.toast').toast('show');
		}
	});
}

jQuery(document).ready(function() { 
	$('#enviar').click(function(){
	buscar($("#idnome").val(), $("#idemail").val(), $("#idmensagem").val());
	});
});