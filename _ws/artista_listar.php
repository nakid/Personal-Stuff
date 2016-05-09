<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>


<b># LISTA DE ARTISTAS #</b> -> <a href="index.php">voltar para a home</a>

<br><br><br>


<?
$acao = $_GET['acao'];
if ($acao !== NULL) {
	$artista = $_GET['artista'];
	echo '<span style="color:#090">' . $artista . ' ' . $acao . ' com sucesso.</span><br><br>';
}

$ord = $_GET['ord'];
if ($ord !== NULL) {
	$_SESSION['ORDEM_ARTISTA'] = $ord;	
}


?>


<a href="artista_cadastro.php">INSERIR NOVO</a>
<span style="margin-left: 100px;">ORDENAR POR: 
<a href="artista_listar.php?ord=alf" style="margin-left:30px; <?=($_SESSION['ORDEM_ARTISTA'] == "alf" ? "color:#ff6400;" : "")?>">ORDEM ALFABÉTICA</a>
<a href="artista_listar.php?ord=cat" style="margin-left:30px; <?=($_SESSION['ORDEM_ARTISTA'] == "cat" ? "color:#ff6400;" : "")?>">CATEGORIA</a></span>
<a href="artista_listar.php?ord=res" style="margin-left:30px; <?=($_SESSION['ORDEM_ARTISTA'] == "res" ? "color:#ff6400;" : "")?>">RESPONSÁVEL</a></span>
<br>

<div>
	
	<?
	
	if ($_SESSION['ORDEM_ARTISTA'] == "res") {
	
		$sql = "
			SELECT
				ART.ID AS ID,
				ART.NOME AS NOME,
				ART.CATEGORIA,
				ART.ATUALIZAR_DIA AS ATUALIZAR_DIA,
				DATE_FORMAT( ART.ULTIMA_ATUALIZACAO, '%d/%m/%Y' ) AS ULTIMA_ATUALIZACAO,
				DATEDIFF( NOW( ) , ART.ULTIMA_ATUALIZACAO ) AS DIAS_SEM_ATUALIZAR,
				USU.ID AS USUID,
				USU.NOME AS USUNOME,
				USU.COR AS USUCOR
			FROM
				ARTISTA AS ART
			LEFT JOIN
				USUARIO AS USU
			ON
				ART.ID_USUARIO = USU.ID
			ORDER BY
				USUNOME DESC,
				ATUALIZAR_DIA ASC,
				DIAS_SEM_ATUALIZAR DESC,
				ART.CATEGORIA DESC,
				ART.NOME ASC
		";
	
		$regs = db_selectRecordsRawSQL($sql);
	
	
	
		if ($regs["dados"]) {
				
			$usuid = NULL;
				
			$dia = 0;
			$diaant = $dia;
				
				
			$diatot = 0;
			$flagHeaderUser = false;
	
			$cor = array(
					0 => "fff",
					1 => "eee"
			);
				
			$j = 0;
				
			foreach ($regs["dados"] as $i) {
	
				$dia = $i["ATUALIZAR_DIA"];
	
				if ($i["USUID"] !== $usuid) {
						
					$flagHeaderUser = true;
					$diaant = $dia;
				}
	
				if ($usuid !== NULL) {
	
					if ($dia !== $diaant) {
						?>
						<span style="float:left; padding:2px; margin-bottom:0px; width:535px; color:#fff; text-align: right; background-color:#ccc">
							 Total dia <?=$diaant?>: <b><?=$diatot?></b> artistas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</span>						
						<?
						$diaant  = $dia;
						
						$diatot = 0;
					} //else {						
						
						//$diaant = $dia;
						
					//}
					$diatot++;
				}	

				if ($flagHeaderUser) {					
					if ($usuid !== 0) {
						?>
						</div>
						<?	
					}
					?>
					<div style="float:left; width:620px; padding-top:40px; background-color:#transparent">
					<span style="float:left; padding:7px; width:525px; color:#fff; background-color:#<?= ( $i['USUCOR'] ? $i['USUCOR']: 'bbb' )?>">
						Responsável <b><?=( $i['USUNOME'] ? $i['USUNOME'] : "ninguém" )?></b>
					</span>
					<?	
					$usuid = $i["USUID"];
					$flagHeaderUser = false;
				}
							
				?>
				<style type="text/css">
					span.cat {						
					    border-radius: 5px 5px 5px 5px;
					    display: block;
					    float: left;
					    font-size: 9px;
					    height: 15px;
					    margin-right: 10px;
					    width: 15px;			    
					}
				</style>
				
				<?
				if ($i['CATEGORIA'] == 1)
					$corcat = 'F0F5F5';
				elseif ($i['CATEGORIA'] == 2)
					$corcat = 'C2D6D6';
				elseif ($i['CATEGORIA'] == 3)
					$corcat = 'FFD1B2';
				elseif ($i['CATEGORIA'] == 4)
					$corcat = 'FFA366';
				elseif ($i['CATEGORIA'] == 5)
					$corcat = 'FF66FF';
					
				if ($i['DIAS_SEM_ATUALIZAR'] === NULL)
					$corat = '888888';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 35)
					$corat = 'BB4444';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 30)
					$corat = 'DB8B00';
				else
					$corat = '44BB44';	
				
				?>
				
				<span style="float:left; padding:7px; background-color:#<?=$cor[($j%2)]?>">
					
					<span class="cat" style="background-color:#<?=$corcat?>;">&nbsp;<?=$i['CATEGORIA']?></span>
					<a style="float:left; width:55px; display:block" href="artista_agenda.php?id_artista=<?=$i['ID']?>">agenda</a>
					<a href="artista_cadastro.php?id=<?=$i['ID']?>" style="color:#000; float:left; margin-left:5px; display:block; width:150px;"><?=$i['NOME']?></a>
					<span style="float:left; width:100px; color:#<?= ( $i['USUCOR'] ? $i['USUCOR']: 'ddd' )?>"><?= ( $i['USUNOME'] ? $i['USUNOME']: "ninguém" )?></span>
					<span style="float:left; width:70px;"><span style="font-size:9px;">todo dia: </span><?=$i['ATUALIZAR_DIA']?></span>
					
					
					
					<span style="float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<!-- ART.AGENDA_ATUALIZADA AS AGENDA_ATUALIZADA-->
				</span>
				<?		
				$j++;					
				
			}
			?>
			<!-- bloco fecha looping -->
			
			</div>
			<!-- fim bloco fecha looping -->
			<?	
								
				
		} else {
			echo '<span style="color:#900"> Nenhum artista cadastrado</span>';
		}			
		
		
	} else {
	
	
	
		//{
		
			
		$sql = "
			SELECT 
				ART.ID AS ID, 
				ART.NOME AS NOME,
				ART.CATEGORIA,
				ART.FOTO AS FOTO,
				ART.TXT_RESUMO,
				ART.TXT, 
				ART.ATUALIZAR_DIA AS ATUALIZAR_DIA,				
				DATE_FORMAT( ART.ULTIMA_ATUALIZACAO, '%d/%m/%Y' ) AS ULTIMA_ATUALIZACAO,
				USU.ID AS USUID, 
				USU.NOME AS USUNOME,
				USU.COR AS USUCOR
			FROM 
				ARTISTA AS ART
			LEFT JOIN 
				USUARIO AS USU 
			ON 
				ART.ID_USUARIO = USU.ID
		";
			
		if ($_SESSION['ORDEM_ARTISTA'] == "alf")
			$sql .= " ORDER BY NOME ASC ";
		elseif ($_SESSION['ORDEM_ARTISTA'] == "cat")	
			$sql .= " ORDER BY CATEGORIA DESC, NOME ASC  ";
			
		
		//$sql .= " Limit 30 ";
		
		
		
		
		

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
				
				if ($i['CATEGORIA'] == 1)
					$corcat = 'F0F5F5';
				elseif ($i['CATEGORIA'] == 2)
					$corcat = 'C2D6D6';
				elseif ($i['CATEGORIA'] == 3)
					$corcat = 'FFD1B2';
				elseif ($i['CATEGORIA'] == 4)
					$corcat = 'FFA366';
				elseif ($i['CATEGORIA'] == 5)
					$corcat = 'FF66FF';
				
				?>
				<span style="float:left; padding:7px; background-color:#<?=$cor[($j%2)]?>">
					<img src="<?=URL_SITE?>imagens/artistas/<?=$i['FOTO']?>.jpg" style="width:52px; height:52px; float:left; margin-right: 10px;" />
					<span class="cat" style="background-color:#<?=$corcat?>;  border-radius: 12px; float:left; margin-top:11px; margin-right:10px; padding:6px;">&nbsp;<?=$i['CATEGORIA']?></span>
					<a style="margin-top:15px; float:left; width:55px; display:block" href="artista_agenda.php?id_artista=<?=$i['ID']?>">agenda</a>
					<a href="artista_cadastro.php?id=<?=$i['ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:150px;"><?=$i['NOME']?></a>
					<span style="margin-top:15px; float:left; width:100px; color:#<?= ( $i['USUCOR'] ? $i['USUCOR']: 'ddd' )?>"><?= ( $i['USUNOME'] ? $i['USUNOME']: "ninguém" )?></span>
					
					<span style="margin-top:15px; float:left; width:90px;"><span style="font-size:9px;">mini texto: </span><span style="<?=($i['TXT_RESUMO'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['TXT_RESUMO']?'SIM':'NÃO')?></b></span></span>
					<span style="margin-top:15px; float:left; width:70px;"><span style="font-size:9px;">texto: </span><span style="<?=($i['TXT'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['TXT']?'SIM':'NÃO')?></b></span></span>
					
					<span style="margin-top:15px; float:left; width:70px;"><span style="font-size:9px;">todo dia: </span><?=$i['ATUALIZAR_DIA']?></span>
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">atualizado: </span><span style="<?=($i['ULTIMA_ATUALIZACAO'] ? '' : 'color:#ddd;' )?>"><?=($i['ULTIMA_ATUALIZACAO'] ? $i['ULTIMA_ATUALIZACAO'] : "nunca" )?></span></span>
					
					<!-- ART.AGENDA_ATUALIZADA AS AGENDA_ATUALIZADA-->
				</span>
				<?		
				$j++;	
			}
			?>
			</div>
			<?					
				
		} else {
			echo '<span style="color:#900"> Nenhum artista cadastrado</span>';
		}	
			
			
			
			
		//}
		
		
	}
		
	?>
</div>
<div style="clear:left"></div><br>


<?
include ("includes/footer.php");
?>