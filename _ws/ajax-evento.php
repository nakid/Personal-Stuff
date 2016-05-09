<? include ("includes/includes.inc.php"); ?>
<?
$cidade = (int)$_GET['id_cidade'];
$evento = (int)$_GET['id_evento'];

if ($cidade) {
	
	$fields = "ID, NOME";
	$table = "EVENTO";
	$where = "ID_CIDADE = " . $cidade . " AND FIM >= CURRENT_DATE";
	$order = "NOME";
	
	$regs = db_selectRecords($fields, $table, $where, $order);    

	if ($regs["total"]) {
		?><div id="select_evento"><select id='id_evento' name='id_evento' style='width:180px;'><option value=''> - selecione - </option><? foreach ($regs["dados"] as $i) { ?><option value='<?=$i['ID']?>'<?=($evento==$i['ID']?' selected ':'')?>><?=$i['NOME']?></option><? } ?></select></div><?
	} else {
		?><span style="color:#999">Esta cidade não possui eventos cadastrados</span><?
	}
}
?>