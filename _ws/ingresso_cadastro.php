<?
include ("includes/includes.inc.php");


$id = (int)$_GET['id'];

if($_POST) {	
	
	$arrIngresso = array(
		
		'ID' => $_POST['id'],
		'ID_USUARIO' => $_POST['id_usuario'], 
		'NOME' => $_POST['nome'],		
		'URL_LAYOUT' => $_POST['url_layout'],
		'URL' => $_POST['url'],
		'ATUALIZAR_DIA' => $_POST['atualizar_dia']
	);
	
	$ingresso = new ingresso($arrIngresso);
	
	
	//dev_print($_POST);
	//dev_print($arrCasa);
	//dev_print($casa); exit;
	
	
	$result = $ingresso->Save();
	
	if (!$result) { 
		$erMsg = 'Falha na operação';
	} 
	else {	
		header( 'Location: ' . URL_COMPLETA . 'ingresso_listar.php?&acao=' .($ingresso->id === NULL?"inserido":"alterado"));
	}		
	
} else {
	$ingresso = new ingresso($id);
}

include ("includes/header.php");
include ("includes/topo.php");
?>





<b>## <?=($ingresso->id ===  NULL?"ADICIONAR SITE": "EDITAR SITE : ".$ingresso->nome)?> ##</b>
<br><br>

<a href="ingresso_listar.php">voltar para a lista de sites de ingresso</a>

<br><br>

<? if (isset ($erMsg)) echo '<span style="color:#900">' . $erMsg . '</span>'; ?>

<form id="formIngresso" name="formIngresso" method="post">		
	
	<input id="id" name="id" type="hidden" value="<?=$ingresso->id?>" />
	
	<br><br><br>	
	
	<label class="formLabel">Nome</label>
	<input id="nome" name="nome" type="text" size="90" maxlength="240" value="<?=$ingresso->nome?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">URL Layout</label>
	<input id="url_layout" name="url_layout" type="text" size="90" maxlength="240" value="<?=$ingresso->url_layout?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">URL</label>
	<input id="url" name="url" type="text" size="40" maxlength="240" value="<?=$ingresso->url?>" />	
	<div style="clear:left"></div><br>
	
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
	
	<label class="formLabel">Atualizar dias:</label>		
	<input id="atualizar_dia" name="atualizar_dia" type="text" style="width:20px; float:left"" value="<?=( $ingresso->atualizar_dia ? $ingresso->atualizar_dia : "1" )?>" />
	<span style="float:left">&nbsp;&nbsp;/&nbsp;&nbsp;</span>
	<input id="atualizar_dia2" name="atualizar_dia2" type="text" style="width:20px; float:left"" value="<?=( $ingresso->atualizar_dia ? $ingresso->atualizar_dia+15 : "16" )?>" />
	<div id="slider_dia" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>	
	<div style="clear:left"></div><br><br>
	
	
	<input class="formSubmit" id="postSimples" name="postSimples" type="submit" value="<?=($ingresso->id ===  NULL?"INSERIR":"ALTERAR")?>" />	
	
</form>

<script type="text/javascript">
	
	$(function() {
		$( "#slider_dia" ).slider();
		$( "#slider_dia" ).slider({ min: 1 });
		$( "#slider_dia" ).slider({ max: 15 });
		$( "#slider_dia" ).slider({
			slide: function( event, ui ) {
				$("#atualizar_dia").val(ui.value);
				$("#atualizar_dia2").val(ui.value+15);
			}
		});
		<?=( $casa->atualizar_dia ? '$( "#slider_dia" ).slider( "value", ' . $casa->atualizar_dia . ' );' : '' )?>		
	});
	
	$("#atualizar_dia").focus(function() {
		$(this).blur();
	});
	
	<?=( $ingresso->id_usuario ? '$("#id_usuario").val("'. $ingresso->id_usuario .'");' : '' )?>
		
</script>

<?
include ("includes/footer.php");
?>