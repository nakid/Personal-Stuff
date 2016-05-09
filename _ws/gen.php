<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>

<?	
	
	
	if($_POST) {
		
		
		
		
		
		//dev_print($_POST);
		
		
		$id = $_POST['id'];
		$gen = $_POST['genero'];		
		
		$sql = "";
		
		
		
			$sql = "
				UPDATE 
					ARTISTA 
				SET
					ID_GENERO = " . $gen . "
				WHERE
					ID = " . $id . "
			";
		
			
			
			$mysql = new mysql();
			$q = $mysql->query($sql);			
			
			if ($q) {
				dev_echo('<span style="color:#090">UM A MENOS PRA VOCÊ, FELOW!</span>');
			} else {
				dev_echo('<span style="color:#900">DEU PAU! NÃO DESANIME, CHAMA O NAKID! 8211 3004</span>');		
			}
		
		
		
	}
	
	
	$table = "ARTISTA";
	$where = "ID_GENERO IS NULL ";
	
	$total = db_countRecords($table, $where);
	
	
	$sql = "
		SELECT
			*	
		FROM 
			ARTISTA	
		WHERE
			ID_GENERO IS NULL
		ORDER BY
			NOME ASC
		LIMIT 1	
	";
	
	$mysql = new mysql();
	$result = $mysql->select($sql);

	if ($result['total'] == 1)
		$reg = $result['dados'][0];	
	else {
		dev_echo ("Você terminou ou deu pau. Se deu pau, falar com o Nakid 16 8211-3004. Senão, parabéns!");
		exit;
	}
	?>
	
	
	
	
	
	
	<div id="controls" style="floa:left">
		<b>RESTAM <?=$total?> artistas pra você.</b><br>
		
		<BR><BR><BR>
		
		
		
		
		<img src="http://www.showsem.com.br/imagens/artistas/<?=$reg['FOTO']?>.jpg">
		<BR><BR>
		<span>-> <?=$reg['NOME']?></span>
		
		
		<br><br><br>
		<ul>	
		
		
		<? 
		
		if ($reg['WIKIPEDIA']!== NULL) {	?>
			<li><a target="_blank" href="<?=$reg['WIKIPEDIA']?>" class="site sprite">WIKIPEDIA</a></li>
		<?            		            		
		}   
		
		if ($reg['SITE']!== NULL) {	?>
			<li><a target="_blank" href="<?=$reg['SITE']?>" class="site sprite">SITE</a></li>
		<?            		            		
		}
		
		if ($reg['MYSPACE']!== NULL) {	?>
			<li><a target="_blank" href="<?=$reg['MYSPACE']?>" class="site sprite">MYSPACE</a></li>
		<?            		            		
		}
		
		if ($reg['TWITTER']!== NULL) {	?>
			<li><a target="_blank" href="<?=$reg['TWITTER']?>" class="site sprite">TWITTER</a></li>
		<?            		            		
		}
                   
        if ($reg['FACEBOOK_PAGE']!== NULL) {	?>
			<li><a target="_blank" href="<?=$reg['FACEBOOK_PAGE']?>" class="site sprite">FACEBOOK_PAGE</a></li>
		<?            		            		
		}  

		if ($reg['YOUTUBE']!== NULL) {	?>
			<li><a target="_blank" href="https://www.youtube.com/watch?v=<?=$reg['YOUTUBE']?>" class="site sprite">YOUTUBE</a></li>
		<?            		            		
		}
			
                


				
		?>
		
		<br><br><br>

		<?
		$sql = "
			SELECT
				*	
			FROM 
				GENERO				
			ORDER BY
				NOME ASC			
		";
	
		$mysql = new mysql();
		$res_gen = $mysql->select($sql);
		?>
		
		<form id="formC" name="formC" method="post">		
		
			<input id="id" name="id" type="hidden" value="<?=$reg['ID']?>" />
			<?
			if ($res_gen["total"]) {
				?>
				<select id="genero" name="genero" style="width:100;float:left;">
				<option value=""> - selecione - </option>			
					<?
					foreach ($res_gen["dados"] as $i) {
						?>			
						<option value="<?=$i['ID']?>"><?=$i['NOME']?></option>
						<?
					}			
					?>				
				</select>
				<?
			}
			?>
			
			
			<input class="formSubmit"  style="float:left; width:200px; height:30px; background-color:#9C9AD6; color:#fff; font-size:14px" id="postSimples" name="postSimples" type="submit" value="ENVIAR" />
				
		</form>	

		
	</div>
		
	


<?
include ("includes/footer.php");
?>