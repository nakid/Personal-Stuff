<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>


<b>## ESCOLHA A CIDADE ##</b>  -> <a href="index.php">voltar para a home</a>
<br><br><br>


	<?	
		
	$sql = "
		SELECT 
			CID.ID AS ID, 
			CID.NOME AS NOME, 
			USU.COR AS COR
		FROM 
			CIDADE AS CID
		INNER JOIN 
			USUARIO AS USU 
		ON 
			CID.ID_USUARIO = USU.ID
		WHERE 
			CID.ID_USUARIO <>  'NULL'
		ORDER BY
			NOME ASC
	";


	$regs = db_selectRecordsRawSQL($sql);	

	$hoje = sys_getToday();

	if ($regs["total"]) {

		foreach ($regs["dados"] as $i) {						
			?><a href="casa_listar.php?id_cidade=<?=$i['ID']?>" style="color:#<?=$i['COR']?>"><?=$i['NOME']?></a><br><br><?				
		}		
	} else {
		echo '<span style="color:#900">Nenhuma cidade associada a usuario</span>';
	}	


	?>


<?
include ("includes/footer.php");
?>