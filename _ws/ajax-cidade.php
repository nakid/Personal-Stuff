<? include ("includes/includes.inc.php"); ?>
<?
$frurl = $_GET['frurl'];   
$sql = "SELECT ID, UF, NOME FROM CIDADE WHERE FRURL LIKE '" . $frurl  . "%' ORDER BY PRIORIDADE, NOME LIMIT 12";
$regs = db_selectRecordsRawSQL($sql);        
$total = 0;  
foreach ($regs["dados"] as $i) {
	?>
	<a class="itemTombo <?=($total==0?"":"itemTomboSelected")?>itemTomboSelected" rel="<?=$i['ID']?>" href="javascript:void(0)"><?=$i['NOME']?> - <?=$i['UF']?></a>
	<?
	$total++;	
}
//if ($total==0) {
//	Nenhuma cidade encontrada
//}
?>
<script type="text/javascript">
$(".itemTombo").click(function() {
	$("#cidade").val($(this).html());
	$("#scidade").val($(this).html())
	$("#scidade").val($(this).html());
	$("#id_cidade").val($(this).attr("rel"));

	retorna_casas($(this).attr("rel"));
	retorna_eventos($(this).attr("rel"));
	
	finalizaEscolha();
	//$("#pcidon").hide();
	//$("#pcidoff").fadeIn();
});
function finalizaEscolha() {
	indexMenu = 1;
	$("#tombo").html("").hide();
	$('#pcidade').val("");
	$("#pcidon").hide();
	$("#pcidoff").fadeIn();			
}
function retorna_casas(id_cidade) {
	
	$.ajax({
		url: 'ajax-casa.php',									
		type: "GET",
		cache: false,
		data: { id_cidade: id_cidade },
		success: function(data) {																		
			$("#tombo_casa").html(data);				
		},
		error: function() {
			$("#tombo_casa").html("erro");	
		}
	});						
}
function retorna_eventos(id_cidade) {
	
	$.ajax({
		url: 'ajax-evento.php',									
		type: "GET",
		cache: false,
		data: { id_cidade: id_cidade },
		success: function(data) {																		
			$("#tombo_evento").html(data);				
		},
		error: function() {
			$("#tombo_evento").html("erro");	
		}
	});						
}
</script>