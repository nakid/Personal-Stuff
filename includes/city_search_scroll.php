	

	
	<script type="text/javascript">

					
		$(document).ready(function() {
					
			var indexMenu = 1;		
			
			$("#pcidade_scroll").keydown(function (event) {
				
				tecla = event.keyCode;			
				
				if (tecla == 38) {				
					navigateMenu('up');
				}
				if (tecla == 40) {				
					navigateMenu('down');
				}
				if (tecla == 27) {				
					$("#tombo_scroll").html("").hide();
				}
				if (tecla == 13) {				
					redirectTo = $("a.itemTomboSelected").attr("href");
					if (typeof redirectTo != "undefined")					               
						location.href = redirectTo;				
				}	
				
			});		
					
			
			function navigateMenu(orientacao){
				
				numResult = parseInt($("#tombo_scroll > a").size());
				
				if (orientacao == "down") 
				{				
					if (indexMenu < numResult) {
						$("a.itemTomboSelected").removeClass("itemTomboSelected");
						indexMenu++;				
						$("a.itemTombo").eq(indexMenu-1).addClass("itemTomboSelected");					
					}
				}
				if (orientacao == "up") 
				{				
					if (indexMenu > 1) {
						$("a.itemTomboSelected").removeClass("itemTomboSelected");
						indexMenu--;				
						$("a.itemTombo").eq(indexMenu-1).addClass("itemTomboSelected");					
					}
				}
				
			}	
	
			var defaultVal = "Digite aqui sua cidade_";
	
			$('#pcidade_scroll').focus(function() {
	            valor = $.trim($('#pcidade_scroll').val());
				if (valor == defaultVal)
					$('#pcidade_scroll').val("");				
			});	
	
			$('#pcidade_scroll').blur(function() {
	            valor = $.trim($('#pcidade_scroll').val());
				if (valor == "")
					$('#pcidade_scroll').val(defaultVal);				
			});
			
			$('#pcidade_scroll').bind('keyup', function() {	
				var t = this;			
				if (this.value != this.lastValue) {
					if (this.timer) clearTimeout(this.timer);								
					valor = $.trim(t.value);
					if (valor.length >= 1) {
						if($("#tombo_scroll").is(":hidden")) $("#tombo_scroll").show();
						$('#tombo_scroll').html('<img src="imagens/loader.gif" />');
						this.timer = setTimeout(function () {						
							valor = stringFriendly(valor);	
							$.ajax({
								url: 'ajax-cidade.php',									
								type: "GET",
								cache: false,
								data: { frurl: valor },
								success: function(data) {																							
									$("#tombo_scroll").html(data);
									indexMenu = 1;															
								}
							});
						}, 400);
						this.lastValue = this.value;
					} else {
						$("#tombo_scroll").html("").hide();
					}
				}	
			});			
			
		});		
		
	
		function stringFriendly(str) {
			return str.toLowerCase().trim()
			.replace(/[áàãâä]/g, "a")
			.replace(/[éèẽêë]/g, "e")
			.replace(/[íìĩîï]/g, "i")
			.replace(/[óòõôö]/g, "o")
			.replace(/[úùũûü]/g, "u")
			.replace(/ç/g, "c")
			.replace(/(\ |)+/, "")
			.replace(/(^-+|-+$)/, "")
			.replace(/[^a-z0-9@._]+/g,'-');
		}


		$(window).scroll(function () {

			var $window = $(window);

			var top = $window.scrollTop(); //position of the scrollbar

			
			if (top > 50) {
				if ($('.topScroll').is(":hidden"))
					$('.topScroll').show();
			} else {
				if ($('.topScroll').is(":visible"))
					$('.topScroll').hide();
			}
		
		});
		
		$(".btVoltarTopo").click(function() {	
			$('html,body').animate({
				scrollTop: 0
			}, 600);
		});
		
			
	</script>
	
	<input type="text" value="Digite aqui sua cidade_" name="pcidade_scroll" id="pcidade_scroll" class="inputCidade sprite">
	<div id="tombo_scroll" class="tombo tombo_scroll" style="clear: left; display: block;"></div>  	
    
    