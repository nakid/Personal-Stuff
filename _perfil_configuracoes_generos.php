<?
include ("includes/includes.inc.php");
?>

<?

if($_SESSION['LOGIN'] === true) {
	$pessoa = new pessoa("", $_SESSION['ID']);
    if($_POST) {

    	
		$pessoa->generos = $_POST['id_generos_escolhidos'];		
		$flag_save = $pessoa->save();        	
        if ($flag_save) {
        	$_SESSION['GENEROS'] = $pessoa->generos;         	
			$regs = sho_retornarPorPessoa($_SESSION['LAT'], $_SESSION['LON'], $_SESSION['KM'], $_SESSION['GENEROS'], $_SESSION['ID_CIDADE']);
            $_SESSION['TOTAL_SHOWS'] = $regs['total'];
        }

    
    }
}
//dev_print($pessoa);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?
	include ("includes/header.php");
	?>
	
	<!-- SEO -->
	<title>Shows <?=($cidade->frurl == "rio-de-janeiro" ? "no" : "em")?> <?=$cidade->nome.SITE_NOME_SEPARATOR.SITE_NOME?></title>
	<meta name="description" content="Acompanhe aqui os próximos shows <?=($cidade->frurl == "rio-de-janeiro" ? "no" : "em")?> <?=$cidade->nome?> (<?=$cidade->uf?>)! <?=SITE_NOME?>! <?=SITE_SLOGAN?>!" />

	<!-- PARTICULAR INCLUDES -->
	
</head>

<body class="login">
        
        <? include_once("includes/analyticstracking.php"); ?>
        <? include ("includes/topo_logado.php"); ?>	
        
        
		

		<div style="text-align: center; width: 100%; padding-top:100px;">
			<a href="<?=URL_COMPLETA?>perfil/configuracoes/pessoais">Minhas informações</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?=URL_COMPLETA?>perfil/configuracoes/localizacao">Localização/Abrangência</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="javascript:void(0)"><b>Gêneros Musicais</b></a>		
		</div>
		<div style="text-align: center; width: 100%; padding-top:50px;">
			
			<? 
			if ($flag_save) {
				?>
				<p style="color:#393">Seus dados foram salvos</p>
				<?
			} 
			?>
<!--##############################################################-->


	
			


			<h2>Mostrar shows dos gêneros:</h2>
			
			<div style="clear:left"></div>

			<br><br>
			<a id="generos_todos_config" href="javascript:void(0)">Selecionar todos</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a id="generos_nenhum_config" href="javascript:void(0)">Desmarcar todos</a>
			<br><br>

			<div id="box_generos" style="position:relative; margin: 0 auto; width: 700px;">
				
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



				if ($res_gen["total"]) {

					foreach ($res_gen["dados"] as $i) {
						if ($_SESSION['GENEROS'] == "all")
							$classActive = "genero_config_active";
						else
							$classActive = (in_array($i['ID'], $genArr) ? "genero_config_active" : "" );
						?>			

						<a class="genero_config <?=$classActive?>" rel="<?=$i['ID']?>" href="javascript:void(0)"><?=$i['NOME']?></a>
						<?
					}			
					
				}
				?>
				
				<script type="text/javascript">

					$(document).ready(function() {
						
						numGeneros = parseInt($("#box_generos > a").size());

						$(".genero_config").click(function () {

							$(this).toggleClass("genero_config_active");
							geraListaGeneros();
						});		

						$("#generos_todos_config").click(function () {
							$(".genero_config").addClass("genero_config_active");
							$("#id_generos_escolhidos").val("all");
							botao_prosseguir("on");
							//geraListaGeneros();
						});	

						$("#generos_nenhum_config").click(function () {
							$(".genero_config").removeClass("genero_config_active");
							$("#id_generos_escolhidos").val("");
							botao_prosseguir("off");
						});	

						$(".next").click(function () {	
						
							if ($(this).hasClass("next-on")) {
								//alert ('on');
								$( "#formgen" ).submit();
							}
						});

						function geraListaGeneros() {
							
							count_generos_escolhidos = 0;	

							aux_tot_gen = "";
							
							for (i = 0; i < numGeneros; i++) {
                                
							 	aux_gen = $("#box_generos").find("a:eq(" + i + ")");
                                if(aux_gen.hasClass("genero_config_active")) {
                                	aux_tot_gen += aux_gen.attr("rel")+", ";
                                	count_generos_escolhidos++;	
                                }
                            }

                            if (count_generos_escolhidos == numGeneros) {
                            	$("#id_generos_escolhidos").val("all");
                            } else {

								result = $.trim(aux_tot_gen); 
	                            result = result.substr(0, (parseInt(result.length) - 1))
	                            $("#id_generos_escolhidos").val(result);
								if (aux_tot_gen=="")
									botao_prosseguir("off");
								else
									botao_prosseguir("on");
							}
						}
						
						
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
						
						
						


							
					});		
				</script>

				
				
				
			</div>
			<div style="clear:left"></div>










			<br><br><br><br>
			
				
			
			<!--<a href="javascript:void(0)" class="next next-off">Prosseguir</a>-->
			<form id="formgen" name="formgen" action="perfil/configuracoes/generos-musicais" method="post">
				<input type="hidden" id="id_generos_escolhidos" name="id_generos_escolhidos" value="<?=$_SESSION['GENEROS']?>">	
				<input type="submit" value="Salvar"> 			
			</form>


<!--################################################################################-->
			
		</div>
        
		
		
		<div class="content">
            <? include ("includes/footer.php"); ?> 
        </div>    

</body>
</html>