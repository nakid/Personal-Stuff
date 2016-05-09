		
		<div class="footer">
            <a href="#" class="logoFooter sprite">Showsem.com.br</a>
            <p>© Copyright - showsem.com. Todos os direitos reservados.<span> Dúvidas, sugestões, novas ideias?! Entre em contato por email, <a id="btContato" href="javascript:void(0)">clique aqui</a><br />
            Todas as imagens são de divulgação e de propriedade de suas respectivas marcas. As datas e horários dos eventos podem sofrer alterações sem aviso prévio.</span></p>
            <form action="" method="post" class="formContato" name="formContato" id="formContato" style="display:none;">
                <h4>Entre em contato</h4>
                <span class="formErr"></span>
                <input type="text" value="" name="ctt_nome" id="ctt_nome">
                <input type="text" value="" name="ctt_email" id="ctt_email">
                <textarea value="" name="ctt_txt" id="ctt_txt">Diga o que quiser, somos só ouvidos...</textarea>
                <!-- <input type="submit" value="Enviar"/>  -->
                <div style="clear:left;"></div>
                <a href="javascript:void(0)" id="postContato" class="sprite">Enviar</a>
                <div style="clear:left;"></div>
                <a href="javascript:void(0)" class="btFecharForm sprite">Fechar</a>
            </form>
            <span id="formSendStatus" class="formSucces" style="display:none"></span>
        </div>	
        
        <script type="text/javascript">

			$(document).ready(function () {			

				/* ABRE/FECHA FORMULARIO */
				$("#btContato").click(function() {
					offset = $(this).offset();
					point = offset.top + 60;
					$("form.formContato").show(function(){
						$('html,body').animate({
		                    scrollTop: point
		                }, 200);
					});
				});

				$(".btFecharForm").click(function() {
					$("#formContato").slideUp();
				});	


				/* INPUT LABELS */
				
				defaulValNome = "Seu nome";
				$("#ctt_nome").val(defaulValNome);
				$('#ctt_nome').focus(function() {
			        valor = $.trim($('#ctt_nome').val());
					if (valor == defaulValNome)
						$('#ctt_nome').val("");				
				});				
				$('#ctt_nome').blur(function() {
			        valor = $.trim($('#ctt_nome').val());
					if (valor == "")
						$('#ctt_nome').val(defaulValNome);				
				});


				defaulValEmail = "Seu e-mail";
				$("#ctt_email").val(defaulValEmail);
				$('#ctt_email').focus(function() {
			        valor = $.trim($('#ctt_email').val());
					if (valor == defaulValEmail)
						$('#ctt_email').val("");				
				});				
				$('#ctt_email').blur(function() {
			        valor = $.trim($('#ctt_email').val());
					if (valor == "")
						$('#ctt_email').val(defaulValEmail);				
				});

				defaulValTxt = "Diga o que quiser, somos só ouvidos...";
				$("#ctt_txt").html(defaulValTxt);
				$('#ctt_txt').focus(function() {
			        valor = $.trim($('#ctt_txt').html());
					if (valor == defaulValTxt)
						$('#ctt_txt').html("");				
				});				
				$('#ctt_txt').blur(function() {
			        valor = $.trim($('#ctt_txt').html());
					if (valor == "")
						$('#ctt_txt').html(defaulValTxt);				
				});

				/* FORM VALIDATION AND POST */

				$("#postContato").click(function() {				
					
					var slideVel = 200;	
					var err = "";
					var nome = $.trim($("#ctt_nome").val());
					var email = $.trim($("#ctt_email").val());
					var txt = $.trim($("#ctt_txt").val());
					
					if (nome == "" || nome == defaulValNome)		
						err = "Por favor, informe seu nome.";
					else if (email == "" || email == defaulValEmail)		
						err = "Por favor, informe seu e-mail.";
					else if (txt == "" || txt == defaulValTxt)		
						err = "Não seja tímido, diga-nos alguma coisa...";

					if (err != "" ) {

						$(".formErr").html(err);
						if ($(".formErr").is(":visible")) { 
							$(".formErr").slideUp(slideVel, function() {
								$(".formErr").slideDown(slideVel);
							});
						} else {
							$(".formErr").slideDown(slideVel);
						}
					} else {

						
						
						if ($(".formErr").is(":visible")) $(".formErr").slideUp(slideVel);

						$("#formSendStatus").html('Enviando <img src="imagens/loader.gif" /> ');
						$("#formContato").slideUp();
						$("#formSendStatus").slideDown();

						

						
						$.ajax({
							url: 'ajax-contato.php',
							type: "POST",
							cache: false,
							data: {
								ctt_nome: nome, ctt_email: email, ctt_txt: txt, ctt_url: '<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>' 
							},
							success: function(data) {
								if (data == "done") {
									$("#formSendStatus").html('Seu contato foi enviado! Responderemos em breve. Muito obrigado! ');
									var intervalo = window.setTimeout(function(){ $("#formSendStatus").slideUp(500); }, 3000);
								} else {
									$("span.formSucces").css("background-color","#F99");
									$("#formSendStatus").html('Ocorreu um erro ao enviar. Pedimos desculpas por isso. Tente novamente mais tarde ou entre em contato com contato@showsem.com.br. Obrigado!');									
								}
							},
							error:  function(data) {								
								$("#formSendStatus").html('Ocorreu um erro ao enviar. Pedimos desculpas por isso. Tente novamente mais tarde ou entre em contato com contato@showsem.com.br. Obrigado!');
							}
						});
						
					}
					
				});
												
			});				 
				
		</script>
        
        
        

