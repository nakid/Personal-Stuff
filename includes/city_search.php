	

	
	<script type="text/javascript">

					
		$(document).ready(function() {
					
			var indexMenu = 1;		
			
			$("#pcidade").keydown(function (event) {
				
				tecla = event.keyCode;			
				
				if (tecla == 38) {				
					navigateMenu('up');
				}
				if (tecla == 40) {				
					navigateMenu('down');
				}
				if (tecla == 27) {				
					$("#tombo").html("").hide();
				}
				if (tecla == 13) {				
					redirectTo = $("a.itemTomboSelected").attr("href");
					if (typeof redirectTo != "undefined")					               
						location.href = redirectTo;				
				}	
				
			});		
					
			
			function navigateMenu(orientacao){
				
				numResult = parseInt($("#tombo > a").size());
				
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
	
			$('#pcidade').focus(function() {
	            valor = $.trim($('#pcidade').val());
				if (valor == defaultVal)
					$('#pcidade').val("");				
			});	
	
			$('#pcidade').blur(function() {
	            valor = $.trim($('#pcidade').val());
				if (valor == "")
					$('#pcidade').val(defaultVal);				
			});
			
			$('#pcidade').bind('keyup', function() {	
				var t = this;			
				if (this.value != this.lastValue) {
					if (this.timer) clearTimeout(this.timer);								
					valor = $.trim(t.value);
					if (valor.length >= 1) {
						if($("#tombo").is(":hidden")) $("#tombo").show();
						$('#tombo').html('<img src="imagens/loader.gif" />');
						this.timer = setTimeout(function () {						
							valor = stringFriendly(valor);	
							$.ajax({
								url: 'ajax-cidade.php',									
								type: "GET",
								cache: false,
								data: { frurl: valor },
								success: function(data) {																							
									$("#tombo").html(data);
									indexMenu = 1;															
								}
							});
						}, 400);
						this.lastValue = this.value;
					} else {
						$("#tombo").html("").hide();
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
		
			
	</script>
	
	<input type="text" value="Digite aqui sua cidade_" name="pcidade" id="pcidade" class="inputCidade sprite">
	<div id="tombo" class="tombo" style="clear: left; display: block;"></div>  	
    
    