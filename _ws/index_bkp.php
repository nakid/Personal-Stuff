<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");


	$marcarComoAtualizado = $_GET['marcarComoAtualizado'];
	if ($marcarComoAtualizado == 'art') {
	
		$artista = new artista((int)$_GET['id']);
		$artista->flag_ultima_atualizacao = true;
		$result = $artista->save();		
		if ($result) {
			$flag_atualizado = true;
			$msg = 'Artista (' . $artista->nome.') foi "Atualizado!"';
			echo '<span style="color:#fff; background-color:#4B4; text-align:center; padding:5px; width:835px; display:block;">' . $msg . '</span><br><br><br>';
		}
	}
	
	if ($marcarComoAtualizado == 'cas') {
	
		$casa = new casa((int)$_GET['id']);
		$casa->flag_ultima_atualizacao = true;
		$result = $casa->save();		
		if ($result) {
			$flag_atualizado = true;
			$msg = 'Casa (' . $casa->nome.') foi "Atualizada!"';
			echo '<span style="color:#fff; background-color:#4B4; text-align:center; padding:5px; width:835px; display:block;">' . $msg . '</span><br><br><br>';
		}
	}
	
	if ($marcarComoAtualizado == 'ing') {
	
		$ingresso = new ingresso((int)$_GET['id']);
		$ingresso->flag_ultima_atualizacao = true;
		$result = $ingresso->save();		
		if ($result) {
			$flag_atualizado = true;
			$msg = 'Site de ingresso (' . $ingresso->nome.') foi "Atualizado!"';
			echo '<span style="color:#fff; background-color:#4B4; text-align:center; padding:5px; width:835px; display:block;">' . $msg . '</span><br><br><br>';
		}
	}
	
	
		//ARTISTAS ATRASADOS!!!!!!!!!!
	
		$sql = "
			SELECT 
				ART.ID AS ID, 
				ART.NOME AS NOME,
				ART.CATEGORIA,
				ART.FOTO AS FOTO,
				ART.SITE AS SITE,
				ART.AGENDA AS AGENDA,
				ART.TXT_RESUMO,
				ART.TXT, 
				ART.ATUALIZAR_DIA AS ATUALIZAR_DIA,
				ART.BOM_INICIO_MES AS BOM_INICIO_MES,				
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
			WHERE 
				USU.ID = " . $_SESSION["ID_DADOS"] . " AND
				DATEDIFF( NOW( ) , ART.ULTIMA_ATUALIZACAO ) > 30				
			ORDER BY
				DIAS_SEM_ATUALIZAR DESC,
				ART.CATEGORIA DESC,
				ART.NOME ASC	
		";	
			
		
		//$sql .= " Limit 30 ";

		unset($regs);
		$regs = db_selectRecordsRawSQL($sql);
		
		
		//dev_print($regs["dados"]);
		
		
		if ($regs["dados"]) {
		
			?>
			<div style="float:left; width: 831px; background-color:#B44; color:#fff; padding: 5px; text-align:center; font-weight:bold; margin-top:20px;">ARTISTAS ATRASADOS (<?=$regs["total"]?>)</div>
			<div style="float:left; font-size:14px; width:1000px; background-color:transparent">
			<?
			
			$j = 0;
			
				
			
			foreach ($regs["dados"] as $i) {
				
				
				if ($i['DIAS_SEM_ATUALIZAR'] > 35) {
					$cor = array(
							0 => "FFC7C7",
							1 => "FFACAC"
					);
				} else {
					$cor = array(
							0 => "FCE0BA",
							1 => "FEF1E0"
					);
				}
				
				
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
					<span class="cat" style="background-color:#<?=$corcat?>; float:left; padding-top:4px; padding-right:2px; height:34px;">&nbsp;<?=$i['CATEGORIA']?></span>
					
					<img src="<?=URL_SITE?>imagens/artistas/<?=$i['FOTO']?>.jpg" style="width:38px; height:38px; float:left; margin-right: 10px;" />
					
					
					<a href="artista_cadastro.php?id=<?=$i['ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:220px;"><?=$i['NOME']?></a>
					
					<a style="margin-top:15px; float:left; width:55px; display:block; color:#000" href="artista_agenda.php?id_artista=<?=$i['ID']?>">agenda</a>
					
					<a style="margin-top:15px; float:left; width:35px; display:block; <?=($i['SITE']==""?"color:#999":"color:#44B")?>" <?=(v==""?"":"target='_blank'")?> href="<?=($i['SITE']==""?"javascript:void(0)":$i['SITE'])?>">site</a>
					
					<a style="margin-top:15px; float:left; width:85px; display:block; <?=($i['AGENDA']==""?"color:#999":"color:#44B")?>" <?=($i['AGENDA']==""?"":"target='_blank'")?> href="<?=($i['AGENDA']==""?"javascript:void(0)":$i['AGENDA'])?>">pg. agenda</a>
					
					
					<img src="images/icons/calendar<?=($i['BOM_INICIO_MES']?"":"_off")?>.png" style="width:20px; height:20px; float:left; margin-right:17px; margin-top:13px;" />
					
					<span style="margin-top:15px; float:left; width:90px;"><span style="font-size:9px;">mini texto: </span><span style="<?=($i['TXT_RESUMO'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['TXT_RESUMO']?'SIM':'NÃO')?></b></span></span>
					<span style="margin-top:15px; float:left; width:70px;"><span style="font-size:9px;">texto: </span><span style="<?=($i['TXT'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['TXT']?'SIM':'NÃO')?></b></span></span>
					
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<!--<span class="cat" style="display:block; background-color:#B44; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:15px; height:15px;"></span>-->
					
					<div style="float:left; width: 50px;">
						<a class="btArtRed" href="javascript:void(0)" style="display:block; background-color:#<?=($i['DIAS_SEM_ATUALIZAR']==='0'?'4B4':'B44')?>; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:20px; height:20px;"></a>
						<span style="display:none">
							<a class="btArtRedSmall" href="javascript:void(0)" style="display:block; background-color:#B44; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
							<a href="index.php?marcarComoAtualizado=art&id=<?=$i['ID']?>" style="display:block; background-color:#4B4; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
						</span>
					</div>
					
				</span>
				<?		
				$j++;	
			}
			?>
			</div>
			<?								
		}
		
		
		
		//CASAS ATRASADAS !!!!!!!!!!
		
		$sql = "
			SELECT
				CAS.ID AS CASA_ID, 	
				CAS.NOME AS CASA, 
				CAS.SITE AS SITE, 
				CAS.BOM_INICIO_MES AS BOM_INICIO_MES,
				DATEDIFF( NOW( ) , CAS.ULTIMA_ATUALIZACAO ) AS DIAS_SEM_ATUALIZAR,
				CID.ID AS CIDADE_ID,
				CID.NOME AS CIDADE
				
			FROM 
				CASA AS CAS
			INNER JOIN 
				CIDADE AS CID 
			ON 
				CAS.ID_CIDADE = CID.ID
			WHERE 
				CID.ID_USUARIO = " . $_SESSION["ID_DADOS"] . " AND
				DATEDIFF( NOW( ) , CAS.ULTIMA_ATUALIZACAO ) > 15 AND
				CAS.ATUALIZAR = TRUE	
			ORDER BY
				DIAS_SEM_ATUALIZAR DESC,
				CAS.NOME			
		";	
			
			 
		
		//$sql .= " Limit 30 ";
		unset($regs);
		$regs = db_selectRecordsRawSQL($sql);
		
		
		//dev_print($regs["dados"]);
		
		
		if ($regs["dados"]) {
			
			?>
			<div style="float:left; width: 831px; background-color:#B44; color:#fff; padding: 5px; text-align:center; font-weight:bold; margin-top:20px;">CASAS ATRASADAS (<?=$regs["total"]?>)</div>
			<div style="float:left; font-size:14px; width:1000px; background-color:transparent">
			<?
			
			
			$j = 0;
			
			foreach ($regs["dados"] as $i) {
				

				if ($i['DIAS_SEM_ATUALIZAR'] > 20) {
					$cor = array(
							0 => "FFC7C7",
							1 => "FFACAC"
					);
				} else {
					$cor = array(
							0 => "FCE0BA",
							1 => "FEF1E0"
					);
				}
				
				if ($i['DIAS_SEM_ATUALIZAR'] === NULL)
					$corat = '888888';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 20)
					$corat = 'BB4444';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 15)
					$corat = 'DB8B00';
				else
					$corat = '44BB44';	
				
				
				?>
				
				<span style="float:left; padding:7px; background-color:#<?=$cor[($j%2)]?>">					
					
					<a href="casa_cadastro.php?id=<?=$i['CASA_ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:280px;"><?=$i['CIDADE']?> - <?=$i['CASA']?></a>
					
					<!--<span style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:220px;"></span>-->
					
					<a style="margin-top:15px; float:left; width:55px; display:block; color:#000" href="cidade_agenda.php?id_cidade=<?=$i['CIDADE_ID']?>">agenda</a>
					
					<a style="margin-top:15px; float:left; width:120px; display:block; <?=($i['SITE']==""?"color:#999":"color:#44B")?>" <?=(v==""?"":"target='_blank'")?> href="<?=($i['SITE']==""?"javascript:void(0)":$i['SITE'])?>">site</a>
					
					<img src="images/icons/calendar<?=($i['BOM_INICIO_MES']?"":"_off")?>.png" style="width:20px; height:20px; float:left; margin-right:178px; margin-top:13px;" />
					
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<div style="float:left; width: 50px;">
						<a class="btCasRed" href="javascript:void(0)" style="display:block; background-color:#<?=($i['DIAS_SEM_ATUALIZAR']==='0'?'4B4':'B44')?>; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:20px; height:20px;"></a>
						<span style="display:none">
							<a class="btCasRedSmall" href="javascript:void(0)" style="display:block; background-color:#B44; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
							<a href="index.php?marcarComoAtualizado=cas&id=<?=$i['CASA_ID']?>" style="display:block; background-color:#4B4; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
						</span>
					</div>
				</span>
				<?		
				$j++;	
			}
			
			?>
			</div>
			<?		
				
		}		
		
		//INGRESSOS ATRASADOS !!!!!!!!!!
		
		$sql = "
			SELECT
				ID,
				NOME,
				URL,				
				DATEDIFF( NOW( ) , ULTIMA_ATUALIZACAO ) AS DIAS_SEM_ATUALIZAR				
			FROM 
				INGRESSO			
			WHERE 
				ID_USUARIO = " . $_SESSION["ID_DADOS"] . " AND
				DATEDIFF( NOW( ) , ULTIMA_ATUALIZACAO ) > 15				
			ORDER BY
				DIAS_SEM_ATUALIZAR DESC,
				NOME			
		";	
			
		
		//$sql .= " Limit 30 ";
		unset($regs);
		$regs = db_selectRecordsRawSQL($sql);
		
		
		//dev_print($regs["dados"]);
		
		
		
		if ($regs["dados"]) {
				
			?>
			<div style="float:left; width: 831px; background-color:#B44; color:#fff; padding: 5px; text-align:center; font-weight:bold; margin-top:20px;">SITES DE INGRESSOS ATRASADOS (<?=$regs["total"]?>)</div>
			<div style="float:left; font-size:14px; width:1000px; background-color:transparent">
			<?	
			
			$j = 0;
			
			
			foreach ($regs["dados"] as $i) {
					

				if ($i['DIAS_SEM_ATUALIZAR'] > 20) {
					$cor = array(
							0 => "FFC7C7",
							1 => "FFACAC"
					);
				} else {
					$cor = array(
							0 => "FCE0BA",
							1 => "FEF1E0"
					);
				}
					
				if ($i['DIAS_SEM_ATUALIZAR'] === NULL)
					$corat = '888888';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 20)
					$corat = 'BB4444';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 15)
					$corat = 'DB8B00';
				else
					$corat = '44BB44';	
				
				
				?>
				
				<span style="float:left; padding:7px; background-color:#<?=$cor[($j%2)]?>">					
					
					<a href="casa_cadastro.php?id=<?=$i['CASA_ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:335px;"><?=$i['NOME']?></a>
					<a style="margin-top:15px; float:left; width:320px; display:block; <?=($i['URL']==""?"color:#999":"color:#44B")?>" <?=(v==""?"":"target='_blank'")?> href="<?=($i['URL']==""?"javascript:void(0)":$i['URL'])?>">site</a>
					
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<div style="float:left; width: 50px;">
						<a class="btIngRed" href="javascript:void(0)" style="display:block; background-color:#<?=($i['DIAS_SEM_ATUALIZAR']==='0'?'4B4':'B44')?>; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:20px; height:20px;"></a>
						<span style="display:none">
							<a class="btIngRedSmall" href="javascript:void(0)" style="display:block; background-color:#B44; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
							<a href="index.php?marcarComoAtualizado=ing&id=<?=$i['ID']?>" style="display:block; background-color:#4B4; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
						</span>
					</div>
					
				</span>
				<?		
				$j++;	
			}
					
			?>
			</div>
			<?
		}
		
	
		//ARTISTA
	
		$sql = "
			SELECT 
				ART.ID AS ID, 
				ART.NOME AS NOME,
				ART.CATEGORIA,
				ART.FOTO AS FOTO,
				ART.SITE AS SITE,
				ART.AGENDA AS AGENDA,
				ART.TXT_RESUMO,
				ART.TXT, 
				ART.ATUALIZAR_DIA AS ATUALIZAR_DIA,
				ART.BOM_INICIO_MES AS BOM_INICIO_MES,				
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
			WHERE 
				USU.ID = " . $_SESSION["ID_DADOS"] . " AND
				ATUALIZAR_DIA = " . $hoje["mday"] . "
			ORDER BY
				ART.CATEGORIA DESC,
				ART.NOME ASC	
		";	
			
		
		//$sql .= " Limit 30 ";
		unset($regs);
		$regs = db_selectRecordsRawSQL($sql);
		
		
		//dev_print($regs["dados"]);
		
		?>
		<div style="float:left; width: 831px; background-color:#069; color:#fff; padding: 5px; text-align:center; font-weight:bold; margin-top:20px;">ARTISTAS (<?=$regs["total"]?>)</div>
		<div style="float:left; font-size:14px; width:1000px; background-color:transparent">
		<?
		if ($regs["dados"]) {
				
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
					<span class="cat" style="background-color:#<?=$corcat?>; float:left; padding-top:4px; padding-right:2px; height:34px;">&nbsp;<?=$i['CATEGORIA']?></span>
					
					<img src="<?=URL_SITE?>imagens/artistas/<?=$i['FOTO']?>.jpg" style="width:38px; height:38px; float:left; margin-right: 10px;" />
					
					
					<a href="artista_cadastro.php?id=<?=$i['ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:220px;"><?=$i['NOME']?></a>
					
					<a style="margin-top:15px; float:left; width:55px; display:block; color:#000" href="artista_agenda.php?id_artista=<?=$i['ID']?>">agenda</a>
					
					<a style="margin-top:15px; float:left; width:35px; display:block; <?=($i['SITE']==""?"color:#999":"color:#44B")?>" <?=(v==""?"":"target='_blank'")?> href="<?=($i['SITE']==""?"javascript:void(0)":$i['SITE'])?>">site</a>
					
					<a style="margin-top:15px; float:left; width:85px; display:block; <?=($i['AGENDA']==""?"color:#999":"color:#44B")?>" <?=($i['AGENDA']==""?"":"target='_blank'")?> href="<?=($i['AGENDA']==""?"javascript:void(0)":$i['AGENDA'])?>">pg. agenda</a>
					
					
					<img src="images/icons/calendar<?=($i['BOM_INICIO_MES']?"":"_off")?>.png" style="width:20px; height:20px; float:left; margin-right:17px; margin-top:13px;" />
					
					<span style="margin-top:15px; float:left; width:90px;"><span style="font-size:9px;">mini texto: </span><span style="<?=($i['TXT_RESUMO'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['TXT_RESUMO']?'SIM':'NÃO')?></b></span></span>
					<span style="margin-top:15px; float:left; width:70px;"><span style="font-size:9px;">texto: </span><span style="<?=($i['TXT'] ? 'color:#4B4;' : 'color:#B44;' )?>"><b><?=($i['TXT']?'SIM':'NÃO')?></b></span></span>
					
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<!--<span class="cat" style="display:block; background-color:#B44; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:15px; height:15px;"></span>-->
					
					<div style="float:left; width: 50px;">
						<a class="btArtRed" href="javascript:void(0)" style="display:block; background-color:#<?=($i['DIAS_SEM_ATUALIZAR']==='0'?'4B4':'B44')?>; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:20px; height:20px;"></a>
						<span style="display:none">
							<a class="btArtRedSmall" href="javascript:void(0)" style="display:block; background-color:#B44; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
							<a href="index.php?marcarComoAtualizado=art&id=<?=$i['ID']?>" style="display:block; background-color:#4B4; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
						</span>
					</div>
					
				</span>
				<?		
				$j++;	
			}
								
				
		} else {
			echo '<span style="float: left; width:750px; color:#900; padding:20px;"> Nenhum artista para este dia?</span>';
		}
		
		?>
		</div>
		<?
		
		//CASAS
		
		$sql = "
			SELECT
				CAS.ID AS CASA_ID, 	
				CAS.NOME AS CASA, 
				CAS.SITE AS SITE, 
				CAS.BOM_INICIO_MES AS BOM_INICIO_MES,
				DATEDIFF( NOW( ) , CAS.ULTIMA_ATUALIZACAO ) AS DIAS_SEM_ATUALIZAR,
				CID.ID AS CIDADE_ID,
				CID.NOME AS CIDADE
				
			FROM 
				CASA AS CAS
			INNER JOIN 
				CIDADE AS CID 
			ON 
				CAS.ID_CIDADE = CID.ID
			WHERE 
				CID.ID_USUARIO = " . $_SESSION["ID_DADOS"] . "
				AND CAS.ATUALIZAR_DIA = " . ( $hoje["mday"] > 15 ? ($hoje["mday"] - 15) : $hoje["mday"] ) . "
				AND CAS.ATUALIZAR = TRUE
			ORDER BY 
				CAS.NOME			
		";	
			
		
		//$sql .= " Limit 30 ";
		unset($regs);
		$regs = db_selectRecordsRawSQL($sql);
		
		
		//dev_print($regs["dados"]);
		
		?>
		<div style="float:left; width: 831px; background-color:#069; color:#fff; padding: 5px; text-align:center; font-weight:bold; margin-top:20px;">CASAS (<?=$regs["total"]?>)</div>
		<div style="float:left; font-size:14px; width:1000px; background-color:transparent">
		<?
		if ($regs["dados"]) {
				
			$cor = array(
					0 => "fff",
					1 => "eee"
			);
			$j = 0;
			foreach ($regs["dados"] as $i) {
								
				if ($i['DIAS_SEM_ATUALIZAR'] === NULL)
					$corat = '888888';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 20)
					$corat = 'BB4444';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 15)
					$corat = 'DB8B00';
				else
					$corat = '44BB44';	
				
				
				?>
				
				<span style="float:left; padding:7px; background-color:#<?=$cor[($j%2)]?>">					
					
					<a href="casa_cadastro.php?id=<?=$i['CASA_ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:280px;"><?=$i['CIDADE']?> - <?=$i['CASA']?></a>
					
					<!--<span style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:220px;"></span>-->
					
					<a style="margin-top:15px; float:left; width:55px; display:block; color:#000" href="cidade_agenda.php?id_cidade=<?=$i['CIDADE_ID']?>">agenda</a>
					
					<a style="margin-top:15px; float:left; width:120px; display:block; <?=($i['SITE']==""?"color:#999":"color:#44B")?>" <?=(v==""?"":"target='_blank'")?> href="<?=($i['SITE']==""?"javascript:void(0)":$i['SITE'])?>">site</a>
					
					<img src="images/icons/calendar<?=($i['BOM_INICIO_MES']?"":"_off")?>.png" style="width:20px; height:20px; float:left; margin-right:178px; margin-top:13px;" />
					
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<div style="float:left; width: 50px;">
						<a class="btCasRed" href="javascript:void(0)" style="display:block; background-color:#<?=($i['DIAS_SEM_ATUALIZAR']==='0'?'4B4':'B44')?>; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:20px; height:20px;"></a>
						<span style="display:none">
							<a class="btCasRedSmall" href="javascript:void(0)" style="display:block; background-color:#B44; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
							<a href="index.php?marcarComoAtualizado=cas&id=<?=$i['CASA_ID']?>" style="display:block; background-color:#4B4; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
						</span>
					</div>
				</span>
				<?		
				$j++;	
			}
								
				
		} else {
			echo '<span style="float: left; width:750px; color:#900; padding:20px;"> Nenhuma casa para este dia.</span>';
		}
		?>
		</div>
		
		<?
		//INGRESSOS
		
		$sql = "
			SELECT
				ID,
				NOME,
				URL,				
				DATEDIFF( NOW( ) , ULTIMA_ATUALIZACAO ) AS DIAS_SEM_ATUALIZAR				
			FROM 
				INGRESSO			
			WHERE 
				ID_USUARIO = " . $_SESSION["ID_DADOS"] . " AND
				ATUALIZAR_DIA = " . ( $hoje["mday"] > 15 ? ($hoje["mday"] - 15) : $hoje["mday"] ) . "
			ORDER BY 
				NOME			
		";	
			
		
		//$sql .= " Limit 30 ";
		unset($regs);
		$regs = db_selectRecordsRawSQL($sql);
		
		
		//dev_print($regs["dados"]);
		
		
		?>
		<div style="float:left; width: 831px; background-color:#069; color:#fff; padding: 5px; text-align:center; font-weight:bold; margin-top:20px;">SITES DE INGRESSOS (<?=$regs["total"]?>)</div>
		<div style="float:left; font-size:14px; width:1000px; background-color:transparent">
		<?
		if ($regs["dados"]) {
				
			$cor = array(
					0 => "fff",
					1 => "eee"
			);
			$j = 0;
			foreach ($regs["dados"] as $i) {
								
				if ($i['DIAS_SEM_ATUALIZAR'] === NULL)
					$corat = '888888';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 20)
					$corat = 'BB4444';
				elseif ($i['DIAS_SEM_ATUALIZAR'] > 15)
					$corat = 'DB8B00';
				else
					$corat = '44BB44';	
				
				
				?>
				
				<span style="float:left; padding:7px; background-color:#<?=$cor[($j%2)]?>">					
					
					<a href="casa_cadastro.php?id=<?=$i['CASA_ID']?>" style="margin-top:15px; color:#000; float:left; margin-left:5px; display:block; width:335px;"><?=$i['NOME']?></a>
					<a style="margin-top:15px; float:left; width:320px; display:block; <?=($i['URL']==""?"color:#999":"color:#44B")?>" <?=(v==""?"":"target='_blank'")?> href="<?=($i['URL']==""?"javascript:void(0)":$i['URL'])?>">site</a>
					
					<span style="margin-top:15px; float:left; width:120px;"><span style="font-size:9px;">dias sem atualizar: </span><span style="color:#<?=$corat?>"><b><?=($i['DIAS_SEM_ATUALIZAR']!==NULL?$i['DIAS_SEM_ATUALIZAR']:'X')?></b></span></span>
					
					<div style="float:left; width: 50px;">
						<a class="btIngRed" href="javascript:void(0)" style="display:block; background-color:#<?=($i['DIAS_SEM_ATUALIZAR']==='0'?'4B4':'B44')?>; border-radius: 10px; float:left; margin-top:11px; margin-right:10px; width:20px; height:20px;"></a>
						<span style="display:none">
							<a class="btIngRedSmall" href="javascript:void(0)" style="display:block; background-color:#B44; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
							<a href="index.php?marcarComoAtualizado=ing&id=<?=$i['ID']?>" style="display:block; background-color:#4B4; border-radius: 6px; float:left; margin-top:16px; margin-right:10px; width:12px; height:12px;"></a>
						</span>
					</div>
					
				</span>
				<?		
				$j++;	
			}
				
		} else {
			echo '<span style="float: left; width:750px; color:#900; padding:20px;"> Nenhum site de ingresso para este dia.</span>';
		}
		?>
		</div>
		<?

		

?>
<script type="text/javascript">

	$(document).ready(function(){
		
		$(".btArtRed").click(function() {
			$(this).hide();
			$(this).parent().children('span').fadeIn();
		});
		
		$(".btArtRedSmall").click(function() {			
			$(this).parent('span').hide();
			$(this).parent('span').parent('div').children('a').fadeIn();
		});
		
		$(".btCasRed").click(function() {
			$(this).hide();
			$(this).parent().children('span').fadeIn();
		});
		
		$(".btCasRedSmall").click(function() {			
			$(this).parent('span').hide();
			$(this).parent('span').parent('div').children('a').fadeIn();
		});
		
		$(".btIngRed").click(function() {
			$(this).hide();
			$(this).parent().children('span').fadeIn();
		});
		
		$(".btIngRedSmall").click(function() {			
			$(this).parent('span').hide();
			$(this).parent('span').parent('div').children('a').fadeIn();
		});
		
	});

</script

<div style="clear:left"></div><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?
include ("includes/footer.php");
?>