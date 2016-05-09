<? include ("includes/includes.inc.php"); ?>
<?
$cidade = (int)$_GET['id_cidade'];
$casa = (int)$_GET['id_casa'];

if ($cidade) {

	$fields = "ID, NOME";
	$table = "CASA";
	$where = "ID_CIDADE = " . $cidade;
	$order = "NOME";
	$regs = db_selectRecords($fields, $table, $where, $order);    

	if ($regs["total"]) {
		?><div id="select_casa"><select id='id_casa' name='id_casa' style='width:275px;'><option value=''> - selecione - </option><? foreach ($regs["dados"] as $i) { ?><option value='<?=$i['ID']?>'<?=($casa==$i['ID']?' selected ':'')?>><?=$i['NOME']?></option><? } ?></select></div><?
	} else {
		?><span style="color:#999">Esta cidade não possui casas cadastradas</span><?
	}
}
?>
<script type="text/javascript">
$("#id_casa").change(function() {	
	if($(this).val() == "") {
		$("#local_generico").fadeIn();
	} else {
		$("#local_generico").fadeOut();
	}
});
</script>