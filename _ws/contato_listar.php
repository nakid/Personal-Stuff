<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>



<b>CONTATOS</b>

<br>

<?

$res = $_GET['res'];
$ign = $_GET['ign'];
$id = $_GET['id'];

if ($res !== NULL || $ign !== NULL) {
	
	$sql = "
		UPDATE 
			CONTATO 
		SET
			".($res !== NULL ? "RESPONDIDO" : "IGNORADO")." = 1
			,POR = ".$_SESSION['ID']."			
		WHERE
			ID = ".$id."
	";
	$mysql = new mysql();
	$q = $mysql->query($sql);			
	if ($q)
		echo '<br><br><span style="color:#090">Contato alterado com sucesso!</span><br><br>';
	else
		echo '<br><br><span style="color:#900">Erro ao alterar o contato.</span><br><br>';
	
	
}
?>

					
<div>
	
	<?
	
		
		$sql = "
			SELECT 
				ID,
				NOME,
				EMAIL,
				TXT,				
				URL,
				DATE_FORMAT( DATAHORA, '%d-%m-%Y %H:%i' ) AS DATA
			FROM 
				CONTATO			
			WHERE
				RESPONDIDO  IS NULL
				AND IGNORADO IS NULL
			ORDER BY 
				DATAHORA
				
				
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
				<span style="float:left; width:900px; padding:7px; background-color:#<?=$cor[($j%2)]?>">
					<a class="tog" href="javascript:void(0)" rel="<?=$i['ID']?>" style="margin-top:15px; color:#09A; float:left; display:block; width:140px;"><?=$i['DATA']?></a>
					<a class="tog" href="javascript:void(0)" rel="<?=$i['ID']?>" style="margin-top:15px; color:#F64; float:left; display:block; width:250px;"><?=$i['NOME']?></a>
					<a class="tog" href="javascript:void(0)" rel="<?=$i['ID']?>" style="margin-top:15px; color:#666; float:left; display:block; width:350px;"><?=$i['EMAIL']?></a>
					
					<div class="tgr<?=$i['ID']?>" style="float:left; width: 160px;">					
						<a class='respondido' href="javascript:void(0)" rel="<?=$i['ID']?>" style="margin-top:15px; color:#666; float:left; display:block; width:80px;">respondido</a>
						<a class='ignorado' href="javascript:void(0)" rel="<?=$i['ID']?>" style="margin-top:15px; color:#666; float:left; display:block; width:80px;">ignorado</a>
					</div>	
					
					<div class="act<?=$i['ID']?>" style="float:left; width: 160px; display:none">					
						<span class="ask<?=$i['ID']?>" style="margin-top:18px; font-size:12px; color:#666; float:left; display:block; width:85px;"></span>
						<a id="okask<?=$i['ID']?>" class="okask" rel="<?=$i['ID']?>" style="margin-top:15px; font-size:16px; color:#090; float:left; display:block; width:40px;">sim</a>
						<a class="noask" rel="<?=$i['ID']?>" style="margin-top:15px; font-size:16px; color:#900; float:left; display:block; width:20px;" href="javascript:void(0)">não</a>
					</div>
				
				</span>
				<span id="<?=$i['ID']?>" style="float:left; display:none; width:900px; padding:7px; background-color:#FFFDE3; color:#666;">
					<br>
					URL: <?=($i['URL']?"http://".$i['URL']:"Não consta.")?>
					<br><br>
					<?=$i['TXT']?>
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

<script type="text/javascript">
	
	$(".tog").click(function() {
		$("#" + $(this).attr("rel")).slideToggle();
	});
	
	$(".respondido").click(function(){
		id = $(this).attr("rel");
		$(".ask"+id).html("Respondido? ");
		$("#okask"+id).attr("href","contato_listar.php?id="+id+"&res=1");
		$(".tgr"+id).hide();
		$(".act"+id).fadeIn();
	});
	
	$(".ignorado").click(function(){
		id = $(this).attr("rel");
		$(".ask"+id).html("Ignorado? ");
		$("#okask"+id).attr("href","contato_listar.php?id="+id+"&ign=1");
		$(".tgr"+id).hide();
		$(".act"+id).fadeIn();
	});
	
	$(".noask").click(function(){
		id = $(this).attr("rel");		
		$(".act"+id).hide();
		$(".tgr"+id).fadeIn();		
	});
	
	
	
	

</script>



<?
include ("includes/footer.php");
?>