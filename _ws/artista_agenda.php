<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>


<?

/////lista de registros na direita + controles

$artista = new artista((int)$_GET['id_artista']);
$marcarComoAtualizado = (int)$_GET['marcarComoAtualizado'];
$delete = (int)$_GET['delete'];

if ($marcarComoAtualizado) {
	$artista->flag_ultima_atualizacao = true;
	$result = $artista->save();		
	if ($result) {
		$flag_atualizado = true;
		$msg = 'Este artista foi marcado como "Atualizado"';
	}
}

if ($delete) {
	$show = new show($delete);
	if ($show->id_artista == $artista->id) {		
		$msg = 'Show do dia ' . $show->data . ' excluído com sucesso.';
		$flag_excluido = $show->delete();	
		if (!$flag_excluido) $msg = "Erro o excluir o show"; 			
	}
	unset($show);	
}


$id_show = (int)$_GET['id_show'];
if ($id_show) {
	
	$show = new show($id_show);
	
} else {

	if($_POST) {	
		
		//dev_print($_POST);
		
		$result = true;
		
		if ($_POST['id_cidade'] == "") {
			$msg = "Campo CIDADE não pode ser vazio";
			$result = false;
		}	
		elseif ($_POST['data'] == "") {
			$msg = "Campo DATA não pode ser vazio";
			$result = false;
		}
		
		if ($result) {	
		
			$arrShow = array(
				'ID' => $_POST['id'],
				'ID_USUARIO' => $_SESSION['ID'],
				'ID_ARTISTA' => $artista->id,		
				'ID_CIDADE' => $_POST['id_cidade'],
				'ID_CASA' => $_POST['id_casa'],
				'ID_EVENTO' => $_POST['id_evento'],
				'DATA' => $_POST['data'],
				'HORA' => ( $_POST['hora'] !== "-1" ? $_POST['hora'] . ":" . $_POST['minuto'] : "" ),
				'CLASSIFICACAO' =>  ( $_POST['classificacao'] !== "-1" ? $_POST['classificacao'] : "" ),					
				'CLASSIFICACAO_COM_PAIS' => ( $_POST['classificacao'] !== "-1" ? ( $_POST['classificacao_com_pais'] !== "-1" ? $_POST['classificacao_com_pais'] : "" ) : "" ),
				'LOCAL' => $_POST['local'],
				
				'ENDERECO' => $_POST['endereco'],
				'EVENTO' => $_POST['evento'],
				'FONE' => $_POST['fone'],
				'PRECO_MIN' => $_POST['preco_min'],
				'PRECO_MAX' => $_POST['preco_max'],
					
				'LINK' => $_POST['link'],
				'DETALHES' => $_POST['detalhes'],
				'INGRESSO_LINK1' => $_POST['ingresso_link1'],
				'INGRESSO_LABEL1' => $_POST['ingresso_label1'],
				'INGRESSO_LINK2' => $_POST['ingresso_link2'],
				'INGRESSO_LABEL2' => $_POST['ingresso_label2'],
				'INGRESSO_LINK3' => $_POST['ingresso_link3'],
				'INGRESSO_LABEL3' => $_POST['ingresso_label3']
				
			);	
			
					
			$show = new show($arrShow);	

			//dev_print($_POST);
			//dev_print($arrShow);			
			//dev_print($show); 
			
			
			$result = $show->save();
				
			
			if (!$result) {
				$msg = 'Falha ao Inserir este show.';		
			}
			else {
				//$artista->flag_ultima_atualizacao = true;
				$artista->save();		
				$msg = 'Show do dia ' . $show->data . ' ' . ( $arrShow['ID'] ? "alterado" : "inserido") . ' com sucesso.';		
			}
		}			
	}
}


?>



<b>## <?=$artista->nome?>: AGENDA ##</b> &nbsp;&nbsp;&nbsp; <a href="artista_listar.php">voltar para a lista de artistas</a><br /><br />

<img src="<?=URL_SITE?>imagens/artistas/<?=$artista->foto?>.jpg" style="width:52px; height:52px; float:left; margin-right: 10px;" />



<br><br><br>

<script type="text/javascript">

	function retorna_casas(id_cidade, id_casa = false) {
			
		$.ajax({
			url: 'ajax-casa.php',									
			type: "GET",
			cache: false,
			data: { id_cidade: id_cidade, id_casa: id_casa},
			success: function(data) {						
																		
				$("#tombo_casa").html(data);
				//$("#casa_safe").html(data);
					
			},
			error: function() {
				$("#tombo_casa").html("erro");	
			}
		});	
						
	}

	<?=( $id_show ? '  retorna_casas('. $show->id_cidade .', '. ($show->id_casa !== NULL ? $show->id_casa : 0 ) .'); ' : '' )  ?>


	function retorna_eventos(id_cidade, id_evento = false) {
		//alert (id_cidade + " - " + id_evento);
		$.ajax({
			url: 'ajax-evento.php',									
			type: "GET",
			cache: false,
			data: { id_cidade: id_cidade, id_evento: id_evento},
			success: function(data) {						
																		
				$("#tombo_evento").html(data);
				//$("#casa_safe").html(data);
					
			},
			error: function() {
				$("#tombo_evento").html("erro");	
			}
		});	
						
	}

	<?=( $id_show ? '  retorna_eventos('. $show->id_cidade .', '. ($show->id_evento !== NULL ? $show->id_evento : 0 ) .'); ' : '' )  ?>


	
	
</script>



<?
if (isset ($result) || isset ($flag_excluido) || isset ($flag_atualizado)) {
	
	echo '<span style="color:#fff; background-color:#'.(isset ($flag_excluido)? (($flag_excluido?"090":"D00")) :($result?"090":"D00")).'; padding:5px;  margin-left:160px">' . $msg . '</span><br><br><br>';
	if ($result) {
				
		?>
		
		<a id="reaproveitarScript" href="javascript:void(0)" style="color:#DB4865; margin-left:160px">-- reaproveitar dados anteriores --</a>
		<br>
		
		<script type="text/javascript">

			$("#reaproveitarScript").click(function() { 

				$("#cidade").val("<?=$_POST['cidade']?>");
				$("#scidade").val("<?=$_POST['cidade']?>");
				$("#id_cidade").val("<?=$_POST['id_cidade']?>");
				
				$("#data").val("<?=$_POST['data']?>");
				$("#hora").val("<?=$_POST['hora']?>");
				$("#minuto").val("<?=$_POST['minuto']?>");
				$("#slider_hor").slider( "option", "value", <?=(int)$_POST['hora']?>);
				$("#slider_min").slider( "option", "value", <?=(int)$_POST['minuto']?>);
				
				$("#local").val("<?=$_POST['local']?>");

				$("#endereco").val("<?=$_POST['endereco']?>");
				$("#evento").val("<?=$_POST['evento']?>");
				$("#fone").val("<?=$_POST['fone']?>");
				$("#preco_min").val("<?=$_POST['preco_min']?>");
				$("#preco_max").val("<?=$_POST['preco_max']?>");
				
				$("#link").val("<?=$_POST['link']?>");
				tinyMCE.activeEditor.setContent($("#hdetalhes").html());
				$("#ingresso_facil").val("<?=$_POST['ingresso_facil']?>");
						

				$("#pcidoff").show();
				$("#pcidon").hide();

				$("#ingresso_link1").val("<?=$_POST['ingresso_link1']?>");
				$("#ingresso_label1").val("<?=$_POST['ingresso_label1']?>");
				$("#ingresso_link2").val("<?=$_POST['ingresso_link2']?>");
				$("#ingresso_label2").val("<?=$_POST['ingresso_label2']?>");
				

				$("#classificacao").val("<?=$_POST['classificacao']?>");
				$("#classificacao_com_pais").val("<?=$_POST['classificacao_com_pais']?>");
				$("#slider_cla").slider( "option", "value", <?=(int)$_POST['classificacao']?>);
				$("#slider_claPais").slider( "option", "value", <?=(int)$_POST['classificacao_com_pais']?>);

				<?=( $_POST['id_cidade']!="" ? '  retorna_casas('. $_POST['id_cidade'] .', '. ($_POST['id_casa']!="" ? $_POST['id_casa'] : 0 ) .'); ' : '' )  ?>		
				<?=( $_POST['id_casa']!="" ? '  $("#local_generico").hide();' : '' )?>		
				
				<?=( $_POST['id_cidade']!="" ? '  retorna_eventos('. $_POST['id_cidade'] .', '. ($_POST['id_evento']!="" ? $_POST['id_evento'] : 0 ) .'); ' : '' )  ?>

				
				$(this).fadeOut();								
				
			});
			
		</script>
		<br>
		<?
	} else {
		$keepData = true;
	}
}



?>

<div style="background-color:transparent; width:690px; float:left">


	

	<form id="formAgenda" name="formAgenda" method="post" action="<?=URL_COMPLETA?>artista_agenda.php?id_artista=<?=$artista->id?>">		
		
		<input id="id" name="id" type="hidden" value="<?=( $id_show ? $show->id : "" ) ?>" />	
		<input id="cidade" name="cidade" type="hidden" value="<?=( $id_show ? $show->cidade . "/" . $show->estado : ( $keepData ? $_POST['cidade'] : "" ) )?>" />
		<input id="id_cidade" name="id_cidade" type="hidden" size="20" value="<?=( $id_show ? $show->id_cidade : ( $keepData ? $_POST['id_cidade'] : "" ) )?>" />
			
		<!-- CIDADE -->
		
		<label class="formLabel">Cidade</label>
		<input id="scidade" name="scidade" type="text" maxlength="240" style="width:275px;" value="<?=( $id_show ? $show->cidade . " - " . $show->estado : ( $keepData ? $_POST['cidade'] : "" ) )?>" disabled />
		<div style="clear:left"></div><br>
		<a id="pcidoff" href="javascript:void(0)" style="margin-left:160px; display:none">clique aqui para pesquisar</a>	
		
		<div id="pcidon" style="display:block">	
			<label class="formLabel" style="color:#AAA">Pesquisar cidade</label>
			<input id="pcidade" name="cpidade" type="text" maxlength="240" style="width:275px;" />	
			<div id="tombo" class="tombo" style="clear:left; display:false"></div>
		</div>	
		<div style="clear:left"></div><br><br>
		
		
		<!-- DATA -->
		<label class="formLabel">Data</label>
		<input id="data" name="data" class="datepicker" type="text" style="width:275px;" value="<?=( $id_show ? $show->data : ( $keepData ? $_POST['data'] : "" ) ) ?>" />
		<div style="clear:left"></div><br><br>
		
		
		<input class="formSubmit"  style="float:left; width:415px; height:60px; background-color:#9C9AD6; color:#fff; font-size:20px" id="postSimples" name="postSimples" type="submit" value="<?=( $id_show ? "ALTERAR" : "INSERIR")?>" />
		<div style="clear:left"></div><br><br>
			
		<!-- CASA -->		
		<label class="formLabel">Casa</label>	
		<div id="tombo_casa">-selecione uma cidade-</div>					
		<div style="clear:left"></div><br><br>
		
		
		<div id="local_generico" <?=( $id_show ? ($show->id_casa !== NULL ? 'style="display:none"' : '' ) : '' )  ?>>
			<!-- LOCAL -->
			
			<label class="formLabel">Local</label>
			<input id="local" name="local" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->local : ( $keepData ? $_POST['local'] : "" ) )?>" />
			<div style="clear:left"></div><br>
			
			<!-- ENDERECO -->
			
			<label class="formLabel">Endereço</label>
			<input id="endereco" name="endereco" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->endereco : ( $keepData ? $_POST['endereco'] : "" ) )?>" />
			<div style="clear:left"></div><br>
			
			<!-- FONE -->
			
			<label class="formLabel">Telefone</label>
			<input id="fone" name="fone" type="text" maxlength="250" style="width:275px;" value="<?=( $id_show ? $show->fone : ( $keepData ? $_POST['fone'] : "" ) )?>" />
			<div style="clear:left"></div><br>
		</div>
		
		<!-- EVENTO -->
		
		<label class="formLabel">Evento</label>
		<div id="tombo_evento" style="float:left; width:190px;">-selecione uma cidade-</div><input id="evento" name="evento" type="text" maxlength="250" style="width:180px;" value="<?=( $id_show ? $show->evento : ( $keepData ? $_POST['evento'] : "" ) )?>" />
		<div style="clear:left"></div><br>
		
		<!-- PREÇO -->
		
		<label class="formLabel">Preço</label>
		$<input id="preco_min" name="preco_min" type="text" maxlength="6" style="width:50px;" value="<?=( $id_show ? $show->preco_min : ( $keepData ? $_POST['preco_min'] : "" ) )?>" />,00
		
		<span style="color:#999">
			&nbsp;&nbsp;&nbsp; até &nbsp;&nbsp;&nbsp;
			$<input id="preco_max" name="preco_max" type="text" maxlength="6" style="width:50px;" value="<?=( $id_show ? $show->preco_max : ( $keepData ? $_POST['preco_max'] : "" ) )?>" />,00
		</span>
		<div style="clear:left"></div><br>
		
		
		<!-- HORARIO -->	
		<label class="formLabel">Horas:</label>		
		<input id="hora" name="hora" type="text" style="width:20px; float:left"" value="<?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 0, 2) : '-1') : '-1' )?>" />
		<div id="slider_hor" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		<div style="clear:left"></div>
		<label class="formLabel">Minutos:</label>
		<input id="minuto" name="minuto" type="text" style="width:20px; float:left"" value="<?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 3, 2) : '0') : '0' )?>" />
		<div id="slider_min" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- CLASSIFICACAO -->
	
		<label class="formLabel">Classificação:</label>		
		<input id="classificacao" name="classificacao" type="text" style="width:20px; float:left"" value="<?=( $show->classificacao ? $show->classificacao : "-1" )?>" />
		<div id="slider_cla" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		<div style="clear:left"></div>
		<label class="formLabel">Classif. com pais/resp:</label>
		<input id="classificacao_com_pais" name="classificacao_com_pais" type="text" style="width:20px; float:left"" value="<?=( $show->classificacao_com_pais ? $show->classificacao_com_pais : "-1" )?>" />
		<div id="slider_claPais" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- INGRESSO1 -->
		
		<label class="formLabel">Link1 compra ingresso</label>	
		<input id="ingresso_link1" name="ingresso_link1" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->ingresso_link1 : ( $keepData ? $_POST['ingresso_link1'] : "" ) )?>" />
		<div style="clear:left"></div>
		<label class="formLabel">Site1</label>		
		<?
		$fields = "ID, NOME, URL_LAYOUT";
		$table = "INGRESSO";		
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, false, $order);
		
		if ($regs["total"]) {
			?>
			<select id="ingresso_label1" name="ingresso_label1" style="width:100;">
			<option value=""> - selecione - </option>			
				<?
				foreach ($regs["dados"] as $i) {
					?>			
					<option value="<?=$i['URL_LAYOUT']?>" <?=( $id_show ? ($show->ingresso_label1==$i['URL_LAYOUT']?' selected ':'') : '')?>><?=$i['NOME']?></option>
					<?
				}			
				?>				
			</select>
			<?
		}
		?>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- INGRESSO2 -->
		
		<label class="formLabel">Link1 compra ingresso</label>	
		<input id="ingresso_link2" name="ingresso_link2" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->ingresso_link2 : ( $keepData ? $_POST['ingresso_link1'] : "" ) )?>" />
		<div style="clear:left"></div>
		<label class="formLabel">Site2</label>		
		<?
		$fields = "ID, NOME, URL_LAYOUT";
		$table = "INGRESSO";		
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, false, $order);
		
		if ($regs["total"]) {
			?>
			<select id="ingresso_label2" name="ingresso_label2" style="width:100;">
			<option value=""> - selecione - </option>			
				<?
				foreach ($regs["dados"] as $i) {
					?>			
					<option value="<?=$i['URL_LAYOUT']?>" <?=( $id_show ? ($show->ingresso_label2==$i['URL_LAYOUT']?' selected ':'') : '')?>><?=$i['NOME']?></option>
					<?
				}			
				?>				
			</select>
			<?
		}
		?>
		
		<div style="clear:left"></div><br><br>
		
		<!-- MAIS DETALHES -->		
		
		<label class="formLabel">Mais detalhes</label>
		<textarea id="detalhes" name="detalhes" style="" class="mceEditor" rows="10" cols="64" ><?=( $id_show ? $show->detalhes : ( $keepData ? $_POST['detalhes'] : "" ) )?></textarea>
		<div id="hdetalhes" style="display:none"><?=$_POST['detalhes']?></div>		
		<div style="clear:left"></div><br><br>		
		
		<input class="formSubmit"  style="float:left; width:415px; height:60px; background-color:#9C9AD6; color:#fff; font-size:20px" id="postSimples2" name="postSimples2" type="submit" value="<?=( $id_show ? "ALTERAR" : "INSERIR")?>" />
		<div style="clear:left"></div><br><br>	
		
		
		<br><br><br>
		
		<div style="display:none">
			<!-- Link hidden-->
			
			<label class="formLabel">Link</label>
			<input id="link" name="link" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->link : ( $keepData ? $_POST['link'] : "" ) )?>" />
			<div style="clear:left"></div><br><br>
			
		</div>
			
		
	</form>

</div>

<div style="background-color:#transparent; width:260px; float:left;">
	
	<b>LISTA DE SHOWS</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="artista_agenda.php?id_artista=<?=$artista->id?>&marcarComoAtualizado=1">marcar como atualizado</a>
	<br><br>
	
	<span id="confirmaExclusao" style="float:left; margin-bottom:8px; background-color:#F99; padding:5px; display:none; width:460px;">
		Apagar <span></span>? &nbsp&nbsp&nbsp&nbsp
		<a id="apagar1" href="javascript:void(0)">SIM</a>&nbsp&nbsp&nbsp
		<a id="apagar0" href="javascript:void(0)">NÃO</a></span>
	
	
	<div id="box_shows">
	<?	
	
	$sql = "
		SELECT
			SHO.ID AS ID,
			CID.NOME AS CIDADE,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS DATA,
			DATE_FORMAT( SHO.HORA, '%H:%i' ) AS HORA,
			SHO.DATA AS DATARAW			
		FROM
			`SHOW` AS SHO
		LEFT JOIN
			CIDADE AS CID
		ON
			SHO.ID_CIDADE = CID.ID
		WHERE
			ID_ARTISTA = " . $artista->id . "
			AND SHO.DATA >= CURRENT_DATE 
		ORDER BY
			DATARAW, HORA
	";
	
	
	$regs = db_selectRecordsRawSQL($sql);	
	
	$hoje = sys_getToday();
	
	
	$cor = array(
			0 => "fff",
			1 => "eee"
	);
	
	$pcor = array(
			0 => "FFC7C7",
			1 => "FFACAC"			
	);
	
	$j = 0;
	if ($regs["total"]) {
	
		foreach ($regs["dados"] as $i) {			
			$data_show = $i['DATARAW'];
			$cor_fundo = ( strnatcmp ($data_show, $hoje) < 0 ? $pcor[($j%2)] : $cor[($j%2)] );
			
			?>			
			<span style="float:left; width:460px; padding:5px; background-color:#<?=$cor_fundo?>">
				<a rel="<?=$i['ID']?>" class="btExcluir" href="javascript:void(0)">excluir</a>&nbsp;&nbsp;&nbsp;
				<a href="artista_agenda.php?id_artista=<?=$artista->id?>&id_show=<?=$i['ID']?>">editar</a>&nbsp;&nbsp;&nbsp;
				<span class="reg<?=$i['ID']?>"><?=$i['DATA']?> &nbsp; <?=$i['CIDADE']?></span>
			</span>
			<?	
			$j++;
		}
		
	} else {
		echo '<span style="color:#900">Nenhum show cadastrado</span>';
	}	
	
	
	?>
	</div>	
	<br><br><br><br><br><br><br>
</div>
<div style="clear:left"></div>

<script type="text/javascript">
	
	$(document).ready(function () {	
		
		
		$('#data').change(function(){			
			buscaShows($(this).val(), <?=$artista->id?>)
		});


		function buscaShows(dia, id_artista) {
			
			$('#box_shows').html('<img src="images/loader.gif" />');
			
			$.ajax({
				url: 'ajax-shows_por_dia.php',									
				type: "GET",
				cache: false,
				data: { dia: dia, id_artista: id_artista },
				success: function(data) {								
																			
					$("#box_shows").html(data);
					
					//$("#debug").append(" # ");
													
				}
			});
			
		}
		
		
		
		//$('option[value*="20"]').html("esse eh o cara");
		//$("#hora").val("8");
		
		var indexMenu = 1;
		
		
		/*$('#pcidade').bind('keyup', function() {				
			alert ("-> " + this.value);
		});*/
		
		
		$("#pcidade").keydown(function (event) {
			
			tecla = event.keyCode;			
			//$("#debug").append(" - " + tecla + "-  ");
			if (tecla == 38) {				
				navigateMenu('up');				
			}
			if (tecla == 40) {							
				navigateMenu('down');
			}
			if (tecla == 13) {
				
				cidade = $("a.itemTomboSelected").html();
				id_cidade = $("a.itemTomboSelected").attr("rel");
				
				$("#cidade").val(cidade);
				$("#scidade").val(cidade);
				$("#id_cidade").val(id_cidade);			
				
				
				retorna_casas(id_cidade);
				retorna_eventos(id_cidade);				
				
				finalizaEscolha();
				return false; // nao postar form;
			}	
			
		});		
		
		function finalizaEscolha() {
			indexMenu = 1;
			$("#tombo").html("").hide();
			$('#pcidade').val("");
			$("#pcidon").hide();
			$("#pcidoff").fadeIn();			
		}

		
		$(function() {
			$( "#slider_cla" ).slider();
			$( "#slider_cla" ).slider({ min: -1 });
			$( "#slider_cla" ).slider({ max: 18 });
			$( "#slider_cla" ).slider({
				slide: function( event, ui ) {
					$("#classificacao").val(ui.value);
				}
			});

			$( "#slider_cla" ).slider( "value", <?=( $id_show ? ($show->classificacao ? $show->classificacao : '-1' ) : '-1' )?>);				
		});

		$(function() {
			$( "#slider_claPais" ).slider();
			$( "#slider_claPais" ).slider({ min: -1 });
			$( "#slider_claPais" ).slider({ max: 18 });
			$( "#slider_claPais" ).slider({
				slide: function( event, ui ) {
					$("#classificacao_com_pais").val(ui.value);
				}
			});

			$( "#slider_claPais" ).slider( "value", <?=( $id_show ? ($show->classificacao_com_pais ? $show->classificacao_com_pais : '-1' ) : '-1' )?>);				
		});

		$(function() {
			$( "#slider_hor" ).slider();
			$( "#slider_hor" ).slider({ min: -1 });
			$( "#slider_hor" ).slider({ max: 23 });
			$( "#slider_hor" ).slider({
				slide: function( event, ui ) {
					$("#hora").val(ui.value);
				}
			});
			$( "#slider_hor" ).slider( "value", <?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 0, 2) : '-1') : '-1' )?>);				
		});

		$(function() {
			$( "#slider_min" ).slider();
			$( "#slider_min" ).slider({ min: 0 });
			$( "#slider_min" ).slider({ max: 55 });
			$( "#slider_min" ).slider({ step: 5 });
			$( "#slider_min" ).slider({
				slide: function( event, ui ) {
					$("#minuto").val(ui.value);
				}
			});
			$( "#slider_min" ).slider( "value", <?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 3, 2) : '0') : '0' )?>);				
		});
				
				
		function navigateMenu(orientacao){
			
			numResult = parseInt($("#tombo > a").size());
			
			if (orientacao == "down") 
			{				
				if (indexMenu < numResult) {
					$("a.itemTomboSelected").removeClass("itemTomboSelected");
					indexMenu++;				
					$("a.itemTombo").eq(indexMenu-1).addClass("itemTomboSelected");
					//$("#debug").append(" d ");
				}
			}
			if (orientacao == "up") 
			{				
				if (indexMenu > 1) {
					$("a.itemTomboSelected").removeClass("itemTomboSelected");
					indexMenu--;				
					$("a.itemTombo").eq(indexMenu-1).addClass("itemTomboSelected");
					//$("#debug").append(" u ");
				}
			}
			
		}	
				
		
		$('#pcidade').bind('keyup', function() {	
			var t = this;			
			if (this.value != this.lastValue) {
				if (this.timer) { clearTimeout(this.timer); }								
				valor = $.trim(t.value);
				if (valor.length >= 1) {
					if($("#tombo").is(":hidden")) $("#tombo").show();
					$('#tombo').html('<img src="images/loader.gif" />');
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
					}, 200);
					this.lastValue = this.value;
				} else {
					$("#tombo").html("").hide();					
					
				}
			}	
		});	
		
		
		jQuery(function($) {
			$.datepicker.regional['pt-BR'] = {
				closeText: 'Fechar',
				prevText: '&#x3c;Anterior',
				nextText: 'Pr&oacute;ximo&#x3e;',
				currentText: 'Hoje',
				monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
				monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
				dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
				dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
				dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 0,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
		});
		
		
		$(".datepicker").datepicker();
		$(".datepicker").focus(function() {
			$(this).blur();
		});
		
	});

	
	$(".btExcluir").click(function() {
		$("#apagar1").attr("href", "<?=URL_COMPLETA?>artista_agenda.php?id_artista=<?=$artista->id?>&delete=" + $(this).attr("rel"))
		$("#confirmaExclusao").children('span').html($("span.reg"+$(this).attr("rel")).html());
		$("#confirmaExclusao").slideDown();
	});

	$("#apagar0").click(function() {
		$("#confirmaExclusao").slideUp();		
	});

		
	$("#pcidoff").click(function() {
		$(this).hide();
		$("#pcidon").fadeIn();
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
	
	
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
		editor_selector : "mceEditor",
		theme: "advanced",                
		plugins: 'advlink',

		// Theme options
		theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,formatselect,|,hr,bullist,numlist,|,link,unlink,|,table,removeformat,code",
		theme_advanced_buttons2: "",
		theme_advanced_buttons3: "",
		theme_advanced_buttons4: "",
		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		theme_advanced_resizing: true,

		// Example content CSS (should be your site CSS)
		content_css: "/js/tinymce/examples/css/content.css",
	   
	});

	$("#hora").focus(function() { $(this).blur(); });
	$("#minuto").focus(function() { $(this).blur(); });
	$("#classificacao").focus(function() { $(this).blur(); });
	$("#classificacao_com_pais").focus(function() { $(this).blur(); });
		

	
</script>



<br><br>

<?
include ("includes/footer.php");
?>