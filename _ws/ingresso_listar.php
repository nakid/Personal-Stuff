<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>



<b># INGRESSOS #</b> -> <a href="index.php">voltar para a home</a>

<br><br><br>


<?

$acao = $_GET['acao'];
if ($acao !== NULL) {
	$casa = $_GET['casa'];
	echo '<span style="color:#090">' . $casa . ' ' . $acao . ' com sucesso.</span><br><br>';
}
?>


<a href="ingresso_cadastro.php">INSERIR NOVO SITE</a>
					
<div>
	
	<?
	
		
		$sql = "
			SELECT 
				*
			FROM 
				INGRESSO
			ORDER BY 
				NOME ASC
		";
		

		$regs = db_selectRecordsRawSQL($sql);
		
		
		
		if ($regs["dados"]) {
			?>
			<div style="float:left; font-size:14px; width:700px; padding-top:40px; background-color:transparent">
			<?	
			$cor = array(
					0 => "fff",
					1 => "eee"
			);
			$j = 0;
			foreach ($regs["dados"] as $i) {
				
				?>
				<span style="float:left; width:600px; padding:7px; background-color:#<?=$cor[($j%2)]?>">
					<a href="ingresso_cadastro.php?id=<?=$i['ID']?>" style="margin-top:15px; color:#000; float:left; display:block; width:150px;"><?=$i['NOME']?></a>					
				</span>
				<?		
				$j++;	
			}
			?>
			</div>
			<?					
				
		} else {
			echo '<span style="color:#900"> Nenhum site cadastrado</span>';
		}	
			
		
	?>
</div>
<div style="clear:left"></div><br>


<?
include ("includes/footer.php");
?>