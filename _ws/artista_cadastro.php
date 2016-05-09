<?
include ("includes/includes.inc.php");

if($_POST) {	
	
	$arrArtista = array(
		'ID' => $_POST['id'],
		'ID_USUARIO' => $_POST['id_usuario'], 
		'ID_GENERO' => $_POST['id_genero'], 		
		'NOME' => $_POST['nome'],		
		'FRURL' => $_POST['frurl'],
		'FOTO' => $_POST['foto'],
		'CATEGORIA' => $_POST['categoria'],
		'SITE' => $_POST['site'],
		'AGENDA' => $_POST['agenda'],
		'WIKIPEDIA' => $_POST['wikipedia'],
		'FACEBOOK_PAGE' => $_POST['facebook_page'],
		'TWITTER' => $_POST['twitter'],
		'MYSPACE' => $_POST['myspace'],
		'YOUTUBE' => $_POST['youtube'],
		'FANZONE' => $_POST['fanzone'],
		'ORIGEM' => $_POST['origem'],
		'NACIONALIDADE' => $_POST['nacionalidade'],
		'TXT_RESUMO' => $_POST['txt_resumo'],
		'TXT' => $_POST['txt'],
		'ATUALIZAR_DIA' => $_POST['atualizar_dia'],
		'BOM_INICIO_MES' => $_POST['bom_inicio_mes'],
		'PUBLICAR_PERFIL' => $_POST['publicar_perfil'],
	);
	
	
	$artista = new artista($arrArtista);
	
	$result = $artista -> Save();
	
	if (!$result) { 
		$erMsg = 'Falha na operação';
	} 
	else {	
		header( 'Location: ' . URL_COMPLETA . 'artista_listar.php?artista='.$artista->nome.'&acao=' .($artista->id === NULL?"inserido":"alterado"));
	}		
	
} else {
	$artista = new artista((int)$_GET['id']);
}
include ("includes/header.php");
include ("includes/topo.php");

?>


<b>## <?=($artista->id ===  NULL?"ADICIONAR ARTISTA": "EDITAR ARTISTA: ".$artista->nome)?> ##</b>
<br><br>

<a href="artista_listar.php">voltar para a lista de artistas</a>

<br><br>

<? if (isset ($erMsg)) echo '<span style="color:#900">' . $erMsg . '</span>'; ?>

<form id="formArtista" name="formArtista" method="post">		
	
	<input id="id" name="id" type="hidden" value="<?=$artista->id?>" />
	
	<br><br><br>
	
	<label class="formLabel">Nome</label>
	<input id="nome" name="nome" type="text" size="70" maxlength="240" value="<?=$artista->nome?>" />		
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Friendly URL</label>
	<input id="frurl" name="frurl" type="text" size="70" maxlength="240" value="<?=$artista->frurl?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Foto</label>
	<input id="foto" name="foto" type="text" size="70" maxlength="240" value="<?=$artista->foto?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Gênero</label>
	<select id="id_genero" name="id_genero">
		<option value="">&nbsp;&nbsp;--&nbsp;&nbsp;</option>
		<?
		$fields = "ID, NOME";
		$table = "GENERO";
		$where = false;
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, $where, $order);
		
		foreach ($regs["dados"] as $i) {
			?>			
			<option value="<?=$i['ID']?>"><?=$i['NOME']?></option>
			<?
		}
		?>	
					
	</select>
	
	
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Site oficial</label>
	<input id="site" name="site" type="text" size="140" maxlength="250" value="<?=$artista->site?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Página da agenda</label>
	<input id="agenda" name="agenda" type="text" size="140" maxlength="250" value="<?=$artista->agenda?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Wikipedia</label>
	<input id="wikipedia" name="wikipedia" type="text" size="140" maxlength="250" value="<?=$artista->wikipedia?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Facebook Page</label>
	<input id="facebook_page" name="facebook_page" type="text" size="140" maxlength="250" value="<?=$artista->facebook_page?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Twitter</label>
	<input id="twitter" name="twitter" type="text" size="140" maxlength="250" value="<?=$artista->twitter?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">MySpace</label>
	<input id="myspace" name="myspace" type="text" size="140" maxlength="250" value="<?=$artista->myspace?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Youtube</label>
	<input id="youtube" name="youtube" type="text" size="140" maxlength="250" value="<?=$artista->youtube?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Fan Zone</label>
	<input id="fanzone" name="fanzone" type="text" size="140" maxlength="250" value="<?=$artista->fanzone?>" />
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Origem</label>
	<select id="origem" name="origem">
		<option value="1">Brasil</option>
		<option value="2">Internacional</option>
		<option value="3">Mistura mundial</option>				
	</select>
	
	<div style="clear:left"></div><br>
	
	<div id="nacionalidade_box" style="display:none">
	<label class="formLabel">País</label>	
		<select id="nacionalidade" name="nacionalidade">
			<option value="">- selecione -</option>
			<?
			$sql = "
				SELECT
					ID,
					NOME				
				FROM
					PAIS			
				ORDER BY
					NOME ASC
			";
		
			$regs = db_selectRecordsRawSQL($sql);	
		
			foreach ($regs["dados"] as $i) {	
				?><option value="<?=$i['ID']?>"><?=ucfirst($i['NOME'])?></option><?
			}
			?>
		</select>
	</div>
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Texto</label>
	<textarea id="txt" name="txt" style="" class="mceEditor" rows="10" cols="120" ><?=$artista->txt?></textarea>
	<div id="hdetalhes" style="display:none"><?=$_POST['txt']?></div>		
	
	<div style="clear:left"></div><br><br>
	
	<label class="formLabel">Resumo: restando</label>
	<textarea id="txt_resumo" name="txt_resumo" style="" rows="2" cols="120" ><?=$artista->txt_resumo?></textarea>
	<div style="font-size:10px; color:#999; margin-left: 160px;"><span id="resumo_counter">120</span> caracteres restantes</div>
	
	<div style="clear:left"></div><br><br>
	
	<label class="formLabel">Atualizado por:</label>
	<select id="id_usuario" name="id_usuario">
		<option value="">&nbsp;&nbsp;--&nbsp;&nbsp;</option>
		<?
		$fields = "ID, NOME";
		$table = "USUARIO";
		$where = false;
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, $where, $order);
		
		foreach ($regs["dados"] as $i) {
			?>			
			<option value="<?=$i['ID']?>"><?=$i['NOME']?></option>
			<?
		}
		?>	
					
	</select>
	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Atualizar todo dia:</label>
	<input id="atualizar_dia" name="atualizar_dia" type="text" style="width:20px; float:left"" value="<?=( $artista->atualizar_dia ? $artista->atualizar_dia : "1" )?>" />
	<div id="slider" style="width:400px; float:left; margin-left:25px; margin-top:4px;"></div>
	<div style="clear:left"></div><br><br>
	
	<label class="formLabel">Bom para início de Mês?</label>
	<select id="bom_inicio_mes" name="bom_inicio_mes">
		<option value="0">NÃO</option>
		<option value="1" >SIM</option>						
	</select>		
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Categoria:</label>
	<input id="categoria" name="categoria" type="text" style="width:20px; float:left"" value="<?=( $artista->categoria ? $artista->categoria : "1" )?>" />
	<div id="slider_cat" style="width:200px; float:left; margin-left:25px; margin-top:4px;"></div>
	
	<div style="clear:left"></div><br>	

	<label class="formLabel">Perfil</label>
	<select id="publicar_perfil" name="publicar_perfil">
		<option value="0" >Não Publicar</option>
		<option value="1">Publicar</option>
	</select>	
	
	<div style="clear:left"></div><br>
	
	<input class="formSubmit" id="postSimples" name="postSimples" type="submit" value="<?=($artista->id ===  NULL?"INSERIR":"ALTERAR")?>" />	
	
</form>


<script type="text/javascript">

	$(document).ready(function(){
		$('#txt_resumo').limit('120','#resumo_counter');
	});


	$(function() {
		$( "#slider" ).slider();
		$( "#slider" ).slider({ min: 1 });
		$( "#slider" ).slider({ max: 30 });
		$( "#slider" ).slider({
			slide: function( event, ui ) {
				$("#atualizar_dia").val(ui.value);
			}
		});
		<?=( $artista->atualizar_dia ? '$( "#slider" ).slider( "value", ' . $artista->atualizar_dia . ' );' : '' )?>		
	});


	$(function() {
		$( "#slider_cat" ).slider();
		$( "#slider_cat" ).slider({ min: 1 });
		$( "#slider_cat" ).slider({ max: 5 });
		$( "#slider_cat" ).slider({
			slide: function( event, ui ) {
				$("#categoria").val(ui.value);
			}
		});
		<?=( $artista->categoria ? '$( "#slider_cat" ).slider( "value", ' . $artista->categoria . ' );' : '' )?>		
	});
	

	$("#atualizar_dia").focus(function() {
		$(this).blur();
	});
	
	<?=( $artista->id_usuario ? '$("#id_usuario").val("'. $artista->id_usuario .'");' : '' )?>
	<?=( $artista->id_genero ? '$("#id_genero").val("'. $artista->id_genero .'");' : '' )?>	
	<?=( $artista->origem ? '$("#origem").val("'. $artista->origem .'");' : '' )?>
	<?=( $artista->bom_inicio_mes !== NULL ? '$("#bom_inicio_mes").val("'. $artista->bom_inicio_mes .'");' : '' )?>
	
	origem = <?=$artista->origem?>;	
	
	if (origem == '2') {
		
		<?=( $artista->nacionalidade ? '$("#nacionalidade").val("'. $artista->nacionalidade .'");' : '' )?>
		$('#nacionalidade_box').show();
	}
	
	<?=( $artista->publicar_perfil ? '$("#publicar_perfil").val("'. $artista->publicar_perfil .'");' : '' )?>
	
	
	$("#origem").change(function(){
		if ($(this).val() == '2') {
			$("#nacionalidade_box").fadeIn();	
		} else {
			$("#nacionalidade").val("");
			$("#nacionalidade_box").fadeOut();
		}		
		
	});
	
	
	
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
	
	
		
</script>



<?
include ("includes/footer.php");
?>