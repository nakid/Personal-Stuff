<? include ("includes/includes.inc.php"); ?>
<?
$frurl = $_GET['frurl'];   
$sql = "

	SELECT 
		ID, 
		NOME,
		DATEDIFF( NOW( ) , ULTIMA_ATUALIZACAO_DADOS ) AS DIAS_SEM_ATUALIZAR
	FROM 
		ARTISTA 
	WHERE 
		FRURL LIKE '%" . $frurl  . "%' 
	ORDER BY 
		NOME 
	LIMIT 
		12";



$regs = db_selectRecordsRawSQL($sql);        
$total = 0;  
foreach ($regs["dados"] as $i) {
	?>
	<a class="itemTombo <?=($total==0?"":"itemTomboSelected")?>itemTomboSelected" rel="<?=$i['ID']?>" href="javascript:void(0)">
		<?=($i['DIAS_SEM_ATUALIZAR']>180?"(D) ":"")?><?=$i['NOME']?>
	</a>
	<?
	$total++;	
}
//if ($total==0) {
//	Nenhuma cidade encontrada
//}
?>
<script type="text/javascript">
$(".itemTombo").click(function() {
	$("#artista").val($(this).html());
	$("#sartista").val($(this).html())
	$("#sartista").val($(this).html());
	$("#id_artista").val($(this).attr("rel"));
	finalizaEscolha();
	//$("#pcidon").hide();
	//$("#pcidoff").fadeIn();
});
function finalizaEscolha() {
	indexMenu = 1;
	$("#tombo").html("").hide();
	$('#partista').val("");
	$("#parton").hide();
	$("#partoff").fadeIn();			
}
</script>