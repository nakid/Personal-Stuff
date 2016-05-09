<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>


<?

$id_cidade = (int)$_GET['id_cidade'];
$cidade = new cidade($id_cidade);

?>


<b># LISTA DE CASAS (<?=$cidade->nome?>)#</b> -> <a href="index.php">voltar para a home</a>

<br><br><br>


<?

$acao = $_GET['acao'];
if ($acao !== NULL) {
	$casa = $_GET['casa'];
	echo '<span style="color:#090">' . $casa . ' ' . $acao . ' com sucesso.</span><br><br>';
}
?>


<a href="casa_cadastro.php?id_cidade=<?=$id_cidade?>">INSERIR NOVA</a>
					<?               /*
					<span style="margin-left: 100px;">ORDENAR POR: <a href="artista_listar.php?ord=alf" style="margin-left:30px; <?=($_SESSION['ORDEM_ARTISTA'] == "alf" ? "color:#ff6400;" : "")?>">ORDEM ALFABÉTICA</a><a href="artista_listar.php?ord=res" style="margin-left:30px; <?=($_SESSION['ORDEM_ARTISTA'] == "res" ? "color:#ff6400;" : "")?>">RESPONSÁVEL</a></span>
					<br>
										*/

					?>
<div>
	
	<?
	//if ($_SESSION['ORDEM_ARTISTA'] == "alf") {
	
		
		$sql = "
			SELECT 
				*,
				DATEDIFF( NOW( ) , ULTIMA_ATUALIZACAO ) AS DIAS_SEM_ATUALIZAR
			FROM 
				CASA
			WHERE
				ID_CIDADE = " . $cidade->id . "
			ORDER BY 
				ATUALIZAR DESC,
				NOME ASC
		";
		

		$regs = db_selectRecordsRawSQL($sql);
		
		
		
		if ($regs["dados"]) {
			?>
			<div style="float:left; font-size:14px; width:1000px; padding-top:40px; background-color:transparent">
			<?	
			$cor = array(
					0 => "fff",
					1 => "eee"
			);
			$j = 0;
			foreach ($regs["dados"] as $i) {
				
				?>
				<span style="float:left; width:900px; padding:7px; background-color:#<?=$cor[($j%2)]?>">
					
					<!--<img src="< ?=URL_SITE?>imagens/artistas/< ?=$i['FOTO']?>.jpg" style="width:52px; height:52px; float:left; margin-right: 10px;" /> -->
					<!--<a style="margin-top:15px; float:left; width:55px; display:block" href="artista_agenda.php?id_artista=< ?=$i['ID']?>">agenda</a>-->
					
					<a href="casa_cadastro.php?id=<?=$i['ID']?>" style="margin-top:15px; color:#000; float:left; display:block; width:150px;"><?=$i['NOME']?></a>					
					
					
					<span style="margin-top:15px; float:left; width:90px;"><span style="font-size:9px;">atualizar: </span><span style="<?=($i['ATUALIZAR'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['ATUALIZAR']?'SIM':'NÃO')?></b></span></span>
					
					
					<? if ($i['ATUALIZAR']) { ?>
					
						<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">bom inicio mês: </span><span style="color:#666;"><b><?=($i['BOM_INICIO_MES']?"SIM":"NÃO")?></b></span></span>
					
						<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">atualizar dias: </span><span style="color:#666;"><b><?=$i['ATUALIZAR_DIA']?> / <?=($i['ATUALIZAR_DIA']+15)?></b></span></span>
												
						<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
						
						<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">ativa: </span><span style="color:#666;"><b><?=($i['ATIVA']?"SIM":"NÃO")?></b></span></span>
					
					<? } ?>
					
				</span>
				<?		
				$j++;	
			}
			?>
			</div>
			<?					
				
		} else {
			echo '<span style="color:#900"> Nenhuma casa cadastrada</span>';
		}	
			
		
	?>
</div>
<div style="clear:left"></div><br>


<?
include ("includes/footer.php");
?>