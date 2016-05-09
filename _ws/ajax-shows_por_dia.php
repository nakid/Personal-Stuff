<? include ("includes/includes.inc.php"); ?>

<style type="text/css">

.cityDetailsTopic {
	float: left; 
	margin-right: 10px; 
	text-align: right;	
	width: 160px;
		
}

.cityDetailsTopicData {
	float: left; 	
	text-align: left;	
	width: 250px;
}

</style>
<?

$cidade = (int)$_GET['id_cidade'];
$artista = (int)$_GET['id_artista'];
$dia = $_GET['dia'];
$pag = "";

//dev_echo (' -> ' . $dia . ' -> ' . $cidade);

if ($dia && $cidade) {
	$pag = "cidade";
	
	$fields = "ID";
	$table = "`SHOW`";
	$where = "ID_CIDADE = " . $cidade . " AND DATA = STR_TO_DATE('".$dia."','%d/%m/%Y')";
	
	$regs = db_selectRecords($fields, $table, $where);    
} else {

	if ($dia && $artista) {
		$pag = "artista";
		
		$fields = "ID";
		$table = "`SHOW`";
		$where = "ID_ARTISTA = " . $artista . " AND DATA = STR_TO_DATE('".$dia."','%d/%m/%Y')";
		
		$regs = db_selectRecords($fields, $table, $where);   
	}
}
if ($regs["total"]) {
	
	foreach ($regs["dados"] as $i) {
	
		$show = new show((int)$i['ID']);		
		?>
		<span style="float:left; width:460px; padding:5px; background-color:#<?=$cor_fundo?>">
			<a rel="<?=$show->id?>" class="btVer" href="javascript:void(0)">ver</a>&nbsp;&nbsp;&nbsp;
			<a href="<?=$pag?>_agenda.php?id_<?=$pag?>=<?=($pag=="cidade"?$show->id_cidade:$show->id_artista)?>&id_show=<?=$show->id?>">editar</a>&nbsp;&nbsp;&nbsp;
			<span class="reg<?=$show->id?>"><?=$show->data?> &nbsp; <?=$show->artista?></span>
		</span>
		<div id="cityDetails<?=$show->id?>" style="float:left; width:460px; padding:5px; background-color:#FFFBCC; display:none">
			<span class="cityDetailsTopic">Casa: </span>
			<span class="cityDetailsTopicData"><?=($show->casa==NULL?"-":$show->casa)?></span>
			
			<span class="cityDetailsTopic" style="background-color:#FFF9AA;">Local: </span>
			<span  class="cityDetailsTopicData" style="background-color:#FFF9AA;"><?=($show->local==NULL?"-":$show->local)?></span>
			
			<span class="cityDetailsTopic" style="background-color:#FFF9AA;">Endereço: </span>
			<span  class="cityDetailsTopicData" style="background-color:#FFF9AA;"><?=($show->endereco==NULL?"-":$show->endereco)?></span>
			
			<span class="cityDetailsTopic" style="background-color:#FFF9AA;">Telefone: </span>
			<span  class="cityDetailsTopicData" style="background-color:#FFF9AA;"><?=($show->fone==NULL?"-":$show->fone)?></span>
			
			<span class="cityDetailsTopic">Main Evento: </span>
			<span  class="cityDetailsTopicData"><?=($show->m_evento==NULL?"-":$show->m_evento)?></span>
			
			<span class="cityDetailsTopic">Evento: </span>
			<span  class="cityDetailsTopicData"><?=($show->evento==NULL?"-":$show->evento)?></span>
			
			<span class="cityDetailsTopic">Preço (min): </span>
			<span  class="cityDetailsTopicData"><?=($show->preco_min==NULL?"-":$show->preco_min)?></span>
			
			<span class="cityDetailsTopic">Proço (max): </span>
			<span  class="cityDetailsTopicData"><?=($show->preco_max==NULL?"-":$show->preco_max)?></span>
			
			<span class="cityDetailsTopic">Hora: </span>
			<span class="cityDetailsTopicData"><?=($show->hora==NULL?"-":$show->hora)?></span>
			
			<span class="cityDetailsTopic">Classificação: </span>
			<span class="cityDetailsTopicData""><?=($show->classificacao==NULL?"-":$show->classificacao)?></span>
			
			<span class="cityDetailsTopic">Ingresso1: </span>
			<span class="cityDetailsTopicData""><?=($show->ingresso_label1==NULL?"-":$show->ingresso_label1)?></span>
			
			<span class="cityDetailsTopic">Ingresso2: </span>
			<span class="cityDetailsTopicData""><?=($show->ingresso_label2==NULL?"-":$show->ingresso_label2)?></span>
			
			<span class="cityDetailsTopic">Ingresso3: </span>
			<span class="cityDetailsTopicData""><?=($show->ingresso_label3==NULL?"-":$show->ingresso_label3)?></span>
			
			<span class="cityDetailsTopic">+ Detalhes: </span>
			<span class="cityDetailsTopicData""><?=($show->detalhes==NULL?"-":"Tem conteudo")?></span>
			
		</div>		

		
		<?
		unset($show);
	}
} else {
	?><span style="color:#999">Nenhum show cadastrado neste dia</span><?
}

?>
<script type="text/javascript">
$(".btVer").click(function() {	
	$("#cityDetails"+$(this).attr("rel")).slideDown();
});
</script>