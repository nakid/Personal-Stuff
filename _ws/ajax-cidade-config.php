<? include ("includes/includes.inc.php"); ?>
<?
$frurl = $_GET['frurl'];   
$sql = "SELECT ID, UF, NOME, FRURL FROM CIDADE WHERE FRURL LIKE '" . $frurl  . "%' ORDER BY PRIORIDADE, NOME LIMIT 12";
$regs = db_selectRecordsRawSQL($sql);        
$total = 0;  
foreach ($regs["dados"] as $i) {
	?>
	<a class="itemTombo <?=($total==0?"itemTomboSelected":"")?>" rel="<?=$i['ID']?>" href="javascript:void(0)"><?=$i['NOME']?> : <?=$i['UF']?></a>	
	<?
	$total++;	
}
?>

<script type="text/javascript">
$(".itemTombo").click(function () {	

	cid_id = $(this).attr("rel");
	$("#id_cidade_escolhida").val(cid_id);

	cid_nome = $(this).html();					
	$("#cidade_escolhida").html(cid_nome);
	$("#cidade_escolhida_show").html(cid_nome);
	
	$("#box_escolher_cidade").hide();
	$("#box_cidade_escolhida").fadeIn();
	
	$(".next").removeClass("next-off");
	$(".next").addClass("next-on");
	$(".next").attr("href","perfil/configuracoes-passo-2");		
	
		
});	

</script>