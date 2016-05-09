<?

session_start();
if (!isset($_SESSION["ID"])) Header("Location: login.php");

$id = 5270;

if ($_SESSION['GENEROS'] === NULL) $_SESSION['GENEROS'] = 'all';

include ("includes/includes.inc.php");


//echo "gen -> " . $_SESSION['GENEROS'];


if($_POST) {
    	
	$_SESSION['GENEROS'] = $_POST['id_generos_escolhidos']; 
	//$regs = sho_retornarPorPessoa($_SESSION['LAT'], $_SESSION['LON'], $_SESSION['KM'], $_SESSION['GENEROS'], $_SESSION['ID_CIDADE']);		
	echo '<script>window.location="'.URL_COMPLETA.'";</script>';
}


?>


<!DOCTYPE html>
<html>
    
    <head>
	
        <?
		include ("includes/header.php");
		?>
		
		<!-- SEO -->
		<title><?=SITE_NOME?>! <?=SITE_SLOGAN?></title>
		<meta name="description" content="Acompanhe os pŕoximos shows em São Paulo, Rio de Janeiro, Curitiba, BH, Floripa ou em qualquer outra cidade do Brasil! <?=SITE_SLOGAN?>" />
		
    </head>
    
	<style>
	
		.btGenero {
		
			background-color: #449D44;
			border-color: #4cae4c;
			color: #FFF;
			opacity: 0.4;
			filter: alpha(opacity=40);
		} 
		
		.btGenero.pressed {
			opacity: 1.0!important;
			filter: alpha(opacity=100)!important;
			color: #FFF!important;
			background-color:#468D46;
		}
		
		
		
		
	</style>
	
	
    <body  style="background-color:#333!important; background-image: url('img/texture-gray.jpg');">
        <!--div class="section hidden-sm hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <a href="#"><img src="img/logo.png" class="img-responsive center-block" style="margin-top:10px;"></a>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <br class="hidden-lg">
                        <a href="#"><img src="img/an_728-90.png" class="center-block"></a>
                    </div>
                </div>
            </div>
        </div-->
        <div class="section">
            <div class="container">
                <div class="row">
                    
					
					<?
					$sql = "
						SELECT
							*	
						FROM 
							GENERO				
						ORDER BY
							NOME ASC			
					";
					
					$mysql = new mysql();
					$res_gen = $mysql->select($sql);
					

					$genArr = explode(", ",$_SESSION['GENEROS']);
					//dev_print($genArr);
					?>
					
					
					<div class="col-xs-12">
                        <i class="-o fa fa-4x fa-fw fa-music text-inverse" style="float:left;"></i>
                        <h1 style="float:left;  margin: 5px 15px 0 5px; color:#fff ">
							<span id="totGenLabel"><?=($_SESSION['GENEROS'] == "all"?"Todos":count($genArr))?></span> de <?=$res_gen["total"]?> Gêneros
						</h1>
                    </div>
                    <!--div class="hidden-md hidden-lg" style="width:100%; float:left; height:15px;">&nbsp;</div>
                    <div class="col-md-6 col-xs-12">
                        <a class="btn btn-block btn-lg btn-warning">Salvar e voltar aos shows</a>
                    </div-->
                </div>
				
				<div class="row" style="padding: 8px 0;">
					<div class="col-md-6 col-xs-12">
                        <a id="bt-all" class="btn btn-block btn-lg btn-warning">Selecionar todos</a>
                    </div>
                    <div class="hidden-md hidden-lg" style="width:100%; float:left; height:15px;">&nbsp;</div>
                    <div class="col-md-6 col-xs-12">
                        <a id="bt-none" class="btn btn-block btn-lg btn-warning">Eliminar todos</a>
                    </div>
				</div>
				
				
                <div class="row" id="box-gen">
                    
					<?
					if ($res_gen["total"]) {
						foreach ($res_gen["dados"] as $i) {
							
							if ($_SESSION['GENEROS'] == "all")
								$classActive = "pressed";
							else
								$classActive = (in_array($i['ID'], $genArr) ? "pressed" : "" );
							?>			
							<div class="col-lg-3 col-md-4 col-sm-6 bt-gen" style="padding-top: 8px; padding-bottom: 5px;">
								<a rel="<?=$i['ID']?>" class="btGenero btn btn-block btn-lg <?=$classActive?>"><?=$i['NOME']?></a>
								                
							</div>
							<?
						}			
						
					}
					?>
					
                    
                </div>
				
				
				 			
				<form id="formgen" name="formgen" action="<?=URL_COMPLETA.'generos'?>" method="post">
				
					<div class="row" style="padding-top: 8px;">
						<div class="col-xs-12">
							<input type="hidden" id="id_generos_escolhidos" name="id_generos_escolhidos" value="<?=$_SESSION['GENEROS']?>">
							<input type="submit" class="btn btn-block btn-lg btn-default" value="Salvar e voltar para os shows">
							
						</div>
					</div>
					
				</form>	
				
            </div>
        </div>
		
		<br><br>
		
		
		
		<script type="text/javascript">

					$(document).ready(function() {
						
						numGeneros = parseInt($("#box-gen > div.bt-gen").size());
						
						$(".btGenero").click(function () {
							$(this).toggleClass('pressed');
							//$('#debug').append(" ok ");
							geraListaGeneros($(this).attr("rel"));
						});	
						
						
						
						function geraListaGeneros(btrel) {
							
							count_generos_escolhidos = 0;	

							aux_tot_gen = "";
							
							for (i = 0; i < numGeneros; i++) {
                                
								
							 	aux_gen = $("#box-gen").find("div.bt-gen:eq(" + i + ") a.btGenero");
                               
								//if (aux_gen.attr("rel")!=btrel) {
									if (aux_gen.hasClass("pressed")) {
										aux_tot_gen += aux_gen.attr("rel")+", ";
										count_generos_escolhidos++;	
									}
									//gambi toogle bootstrap	
								//} else {
								//	if (!aux_gen.hasClass("pressed")) {
								//		aux_tot_gen += aux_gen.attr("rel")+", ";
								//		count_generos_escolhidos++;	
								//	}
								//}
								
                            }
							
							//$('#debug').append(" >> " + count_generos_escolhidos + " - " + numGeneros + " |");
							
							if (count_generos_escolhidos == numGeneros) {
								$("#totGenLabel").html("Todos");
							}	
							else {
								if (count_generos_escolhidos == 0)
									$("#totGenLabel").html("Nenhum");
								else
									$("#totGenLabel").html(count_generos_escolhidos);
							}
							
							//$('#debug').append(" --- " + aux_tot_gen + "---");
							

                            if (count_generos_escolhidos == numGeneros) {
								//$('#debug').append(" -A-");
                            	$("#id_generos_escolhidos").val("all");
                            } else {
								//$('#debug').append(" -B-");
								result = $.trim(aux_tot_gen); 
	                            result = result.substr(0, (parseInt(result.length) - 1))
	                            $("#id_generos_escolhidos").val(result);
								/*if (aux_tot_gen=="")
									botao_prosseguir("off");
								else
									botao_prosseguir("on"); */
							}
						}
						
						$("#bt-all").click(function () {
							$(".btGenero").addClass("pressed");
							$("#id_generos_escolhidos").val("all");
							$("#totGenLabel").html("Todos");
							//botao_prosseguir("on");
							//geraListaGeneros();
						});	

						$("#bt-none").click(function () {
							$("#totGenLabel").html("Nenhum");
							$(".btGenero").removeClass("pressed");
							$("#id_generos_escolhidos").val("all");
							//botao_prosseguir("off");
						});	
						
						
						
						
						
						
/*
						$(".genero_config").click(function () {

							$(this).toggleClass("genero_config_active");
							geraListaGeneros();
						});		

						

						$(".next").click(function () {	
						
							if ($(this).hasClass("next-on")) {
								//alert ('on');
								$( "#formgen" ).submit();
							}
						});

						
						
						
						function botao_prosseguir(chave) {
						if (chave == "on") {
							$(".next").removeClass("next-off");
							$(".next").addClass("next-on");
							//$(".next").attr("href","perfil/configuracoes-passo-3");							
						} else {
							$(".next").removeClass("next-on");
							$(".next").addClass("next-off");
							$(".next").attr("href","javascript:void(0)");
						}
					}
						
						
						*/


							
					});		
				</script>
		
		
		
    </body>

</html>