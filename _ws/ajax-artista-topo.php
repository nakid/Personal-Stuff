<? include ("includes/includes.inc.php"); ?>
<?
$frurl = $_GET['frurl'];   
$sql = "SELECT ID, NOME, TXT_RESUMO FROM ARTISTA WHERE FRURL LIKE '%" . $frurl  . "%' ORDER BY NOME LIMIT 12";
$regs = db_selectRecordsRawSQL($sql);        
$total = 0;  
foreach ($regs["dados"] as $i) {
	?><div style="float:left; width:280px; padding-top:5px;"><span style="float:left; width:27px; padding-left:3px; <?=($i['TXT_RESUMO'] ? 'color:#4B4;' : 'color:#B44;' )?>"><?=($i['TXT_RESUMO']?'sim':'não')?></span><a style="float:left; color:#000; width:50px;" href="artista_agenda.php?id_artista=<?=$i['ID']?>">agenda</a><a style="float:left; color:#000; width:196px;" href="artista_cadastro.php?id=<?=$i['ID']?>"><?=$i['NOME']?></a></div><?
	$total++;	
}
?>