<?
include ("includes/includes.inc.php");


$id = (int)$_GET['id'];
$id_cidade = (int)$_GET['id_cidade'];

if($_POST) {	
	
	$arrCasa = array(
		
		'ID' => $_POST['id'],
		'ID_CIDADE' => $_POST['id_cidade'], 	
		'NOME' => $_POST['nome'],		
		'ENDERECO' => $_POST['endereco'],
		'NUMERO' => $_POST['numero'],
		'BAIRRO' => $_POST['bairro'],
		'REFERENCIA' => $_POST['referencia'],
		'LAT' => $_POST['lat'],
		'LON' => $_POST['lon'],
		'FONE1' => $_POST['fone1'],
		'FONE2' => $_POST['fone2'],
		'SITE' => $_POST['site'],		
		'EMAIL' => $_POST['email'],		
		'FOTO' => $_POST['foto'],
		'ATUALIZAR' => $_POST['atualizar'],	
		'ATUALIZAR_DIA' => $_POST['atualizar_dia'],
		'BOM_INICIO_MES' => $_POST['bom_inicio_mes'],	
		'ATIVA' => $_POST['ativa']
		
		
	);
	
	$casa = new casa($arrCasa);
	
	
	//dev_print($_POST);
	//dev_print($arrCasa);
	//dev_print($casa); exit;
	
	
	$result = $casa->Save();
	
	if (!$result) { 
		$erMsg = 'Falha na operação';
	} 
	else {	
		header( 'Location: ' . URL_COMPLETA . 'casa_listar.php?id_cidade='.$casa->id_cidade.'&casa='.$casa->nome.'&acao=' .($casa->id === NULL?"inserido":"alterado"));
	}		
	
} else {
	$casa = new casa($id);
}



include ("includes/header.php");
include ("includes/topo.php");
?>


<b>## <?=($casa->id ===  NULL?"ADICIONAR CASA": "EDITAR CASA : ".$casa->nome)?> ##</b>
<br><br>

<a href="casa_listar.php?id_cidade=<?=($id_cidade?$id_cidade:$casa->id_cidade)?>">voltar para a lista de casas da cidade</a>

<br><br>

<? if (isset ($erMsg)) echo '<span style="color:#900">' . $erMsg . '</span>'; ?>

<form id="formArtista" name="formCasa" method="post">		
	
	<input id="id" name="id" type="hidden" value="<?=$casa->id?>" />
	
	<br><br><br>	
	
	<label class="formLabel">Cidade:</label>
	<select id="id_cidade" name="id_cidade">
		<option value=""> - selecione - </option>
		
		<?
		$fields = "ID, NOME";
		$table = "CIDADE";
		$where = "PRIORIDADE < 10";
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, $where, $order);
		
		foreach ($regs["dados"] as $i) {
			?>			
			<option value="<?=$i['ID']?>"><?=$i['NOME']?></option>
			<?
		}
		
		?>	
		
	</select>
	
	<br><br><br>
	
	<label class="formLabel">Nome</label>
	<input id="nome" name="nome" type="text" size="90" maxlength="240" value="<?=$casa->nome?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Endereço</label>
	<input id="endereco" name="endereco" type="text" size="90" maxlength="240" value="<?=$casa->endereco?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Numero</label>
	<input id="numero" name="numero" type="text" size="40" maxlength="240" value="<?=$casa->numero?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Bairro</label>
	<input id="bairro" name="bairro" type="text" size="90" maxlength="240" value="<?=$casa->bairro?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Referência</label>
	<input id="referencia" name="referencia" type="text" size="90" maxlength="240" value="<?=$casa->referencia?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Latitude / Longitude</label>
	<input id="lat" name="lat" type="text" size="20" maxlength="240" value="<?=$casa->lat?>" /> /		
	<input id="lon" name="lon" type="text" size="20" maxlength="240" value="<?=$casa->lon?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Fone1: </label>	
	<input id="fone1" name="fone1" type="text" size="40" maxlength="240" value="<?=$casa->fone1?>" /><br>
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Fone2: </label>	
	<input id="fone2" name="fone2" type="text" size="40" maxlength="240" value="<?=$casa->fone2?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Site</label>
	<input id="site" name="site" type="text" size="90" maxlength="240" value="<?=$casa->site?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">e-mail</label>
	<input id="email" name="email" type="text" size="90" maxlength="240" value="<?=$casa->email?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Foto</label>
	<input id="foto" name="foto" type="text" size="90" maxlength="240" value="<?=$casa->foto?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Atualizar</label>
	<select id="atualizar" name="atualizar">
		<option value="1">SIM</option>
		<option value="0">NÃO</option>				
	</select>
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Atualizar dias:</label>		
	<input id="atualizar_dia" name="atualizar_dia" type="text" style="width:20px; float:left"" value="<?=( $casa->atualizar_dia ? $casa->atualizar_dia : "1" )?>" />
	<span style="float:left">&nbsp;&nbsp;/&nbsp;&nbsp;</span>
	<input id="atualizar_dia2" name="atualizar_dia2" type="text" style="width:20px; float:left"" value="<?=( $casa->atualizar_dia ? $casa->atualizar_dia+15 : "16" )?>" />
	<div id="slider_dia" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>	
	<div style="clear:left"></div><br><br>	
	
	<label class="formLabel">Bom para início de Mês?</label>
	<select id="bom_inicio_mes" name="bom_inicio_mes">
		<option value="0">NÃO</option>
		<option value="1" >SIM</option>						
	</select>		
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Ativa</label>
	<select id="ativa" name="ativa">
		<option value="1" >SIM</option>
		<option value="0">NÃO</option>
	</select>
	
	<div style="clear:left"></div><br>
	
	<input class="formSubmit" id="postSimples" name="postSimples" type="submit" value="<?=($casa->id ===  NULL?"INSERIR":"ALTERAR")?>" />	
	
</form>


<script type="text/javascript">
	
	<?=( $id_cidade ? '$("#id_cidade").val("'. $id_cidade .'");' : '' )?>
	<?=( $casa->id_cidade ? '$("#id_cidade").val("'. $casa->id_cidade .'");' : '' )?>
	
	
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
	
	
	<?=( $casa->atualizar !== NULL ? '$("#atualizar").val("'. $casa->atualizar .'");' : '' )?>
	<?=( $casa->bom_inicio_mes !== NULL ? '$("#bom_inicio_mes").val("'. $casa->bom_inicio_mes .'");' : '' )?>
	<?=( $casa->ativa !== NULL ? '$("#ativa").val("'. $casa->ativa .'");' : '' )?>
	
	
	
	
	
</script>



<?
include ("includes/footer.php");
?>