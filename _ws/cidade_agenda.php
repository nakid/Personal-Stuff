<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>


<?

/////lista de registros na direita + controles

$cidade = new cidade((int)$_GET['id_cidade']);


$delete = NULL;
if (isset($_GET['delete']))
	$delete = (int)$_GET['delete'];



if ($delete) {
	$show = new show($delete);
	if ($show->id_cidade == $cidade->id) {		
		$msg = 'Show ' . $show->artista . 'do dia ' . $show->data . ' excluído com sucesso.';
		$flag_excluido = $show->delete();	
		if (!$flag_excluido) $msg = "Erro o excluir o show"; 			
	}
	unset($show);	
}


$id_show = NULL;
if (isset($_GET['id_show']))
	$id_show = (int)$_GET['id_show'];


	
	
$picture = NULL;	
	
	
if ($id_show) {
	
	$show = new show($id_show);

	
} else {

	if($_POST) {	
		
		$result = true;
		
		
		if ($_POST['id_artista'] == "") {
			$msg = "Campo ARTISTA não pode ser vazio";
			$result = false;
		}	
		elseif ($_POST['data'] == "") {
			$msg = "Campo DATA não pode ser vazio";
			$result = false;
		}
		
		
		if ($result) {	
			
			/* IMAGEM */
			$imagem = false;

			if(isset($_FILES['arquivo']['name']) && $_FILES["arquivo"]["error"] == 0)
			{
			
				
				/*echo "Você enviou o arquivo: <strong>" . $_FILES['arquivo']['name'] . "</strong><br />";
				echo "Este arquivo é do tipo: <strong>" . $_FILES['arquivo']['type'] . "</strong><br />";
				echo "Temporáriamente foi salvo em: <strong>" . $_FILES['arquivo']['tmp_name'] . "</strong><br />";
				echo "Seu tamanho é: <strong>" . $_FILES['arquivo']['size'] . "</strong> Bytes<br /><br />";*/
			 
				$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
				$nome = $_FILES['arquivo']['name'];
				 
				// Pega a extensao
				$extensao = strrchr($nome, '.');
			 
				// Converte a extensao para mimusculo
				$extensao = strtolower($extensao);
			 
				// Somente imagens, .jpg;.jpeg;.gif;.png
				// Aqui eu enfilero as extesões permitidas e separo por ';'
				// Isso server apenas para eu poder pesquisar dentro desta String
				if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
				{
					// Cria um nome único para esta imagem
					// Evita que duplique as imagens no servidor.
					$novoNome = md5(microtime()) . $extensao;
					 
					// Concatena a pasta com o nome
					$destino = 'images/shows/' . $novoNome;
					 
					// tenta mover o arquivo para o destino
					
					echo $arquivo_tmp . "  -  " . $destino;
					
					
					if( @move_uploaded_file( $arquivo_tmp, $destino  ))
					{
					
						$picture = "Arquivo salvo com sucesso <img src='" . $destino . "' />"; 
					
						$imagem = $novoNome;



						/*echo "Arquivo salvo com sucesso em : <strong>" . $destino . "</strong><br />";
						echo "<img src="" . $destino . "" />";*/
					}
					else
						$picture = "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.";
						
				}
				else
					$picture = "Você poderá enviar apenas arquivos *.jpg;*.jpeg;*.gif;*.png";
					
			}
			else
			{
				$picture = "Sem fotos enviadas";
			}
						
			/* FIM IMAGEM */
			
			$arrShow = array(
				'ID' => $_POST['id'],
				'ID_USUARIO' => $_SESSION['ID'],
				'ID_ARTISTA' => $_POST['id_artista'],
				'ID_CIDADE' => $cidade->id,
				
				'ID_CASA' => (isset($_POST['id_casa']) ? $_POST['id_casa'] : NULL),
				'ID_EVENTO' => (isset($_POST['id_evento']) ? $_POST['id_evento'] : NULL),
				
				'IMAGEM' => ($imagem ? $imagem : (isset($_POST['txt_img']) ? $_POST['txt_img'] : NULL)),	
				'DATA' => (isset($_POST['data']) ? $_POST['data'] : NULL),
				'HORA' => ( $_POST['hora'] !== "-1" ? $_POST['hora'] . ":" . $_POST['minuto'] : "" ),
				'CLASSIFICACAO' =>  ( $_POST['classificacao'] !== "-1" ? $_POST['classificacao'] : "" ),
				'CLASSIFICACAO_COM_PAIS' => ( $_POST['classificacao'] !== "-1" ? ( $_POST['classificacao_com_pais'] !== "-1" ? $_POST['classificacao_com_pais'] : "" ) : "" ),
				'LOCAL' => (isset($_POST['local']) ? $_POST['local'] : NULL),
				
				'ENDERECO' => (isset($_POST['endereco']) ? $_POST['endereco'] : NULL),
				'EVENTO' => (isset($_POST['evento']) ? $_POST['evento'] : NULL),
				'FONE' => (isset($_POST['fone']) ? $_POST['fone'] : NULL),
				'PRECO_MIN' => (isset($_POST['preco_min']) ? $_POST['preco_min'] : NULL),
				'PRECO_MAX' => (isset($_POST['preco_max']) ? $_POST['preco_max'] : NULL),
				
					
					
				'LINK' => (isset($_POST['link']) ? $_POST['link'] : NULL),
				'DETALHES' => (isset($_POST['detalhes']) ? $_POST['detalhes'] : NULL),
					
				'INGRESSO_LINK1' => (isset($_POST['ingresso_link1']) ? $_POST['ingresso_link1'] : NULL),
				'INGRESSO_LABEL1' => (isset($_POST['ingresso_label1']) ? $_POST['ingresso_label1'] : NULL),
				'INGRESSO_LINK2' => (isset($_POST['ingresso_link2']) ? $_POST['ingresso_link2'] : NULL),
				'INGRESSO_LABEL2' => (isset($_POST['ingresso_label2']) ? $_POST['ingresso_label2'] : NULL),
				'INGRESSO_LINK3' => (isset($_POST['ingresso_link3']) ? $_POST['ingresso_link3'] : NULL),
				'INGRESSO_LABEL3' => (isset($_POST['ingresso_label3']) ? $_POST['ingresso_label3'] : NULL)
					
					
			);	
			
			$show = new show($arrShow);				
			
			//dev_print($_POST);
			//dev_print($arrShow);
			//dev_print($show); exit;
			
			
			$result = $show->save();
				
			
			if (!$result) {
				$msg = 'Falha ao Inserir este show.';		
			}
			else {
				//$artista->flag_ultima_atualizacao = true;
				//$artista->save();		
				$msg = 'Show do dia ' . $show->data . ' ' . ( $arrShow['ID'] ? "alterado" : "inserido") . ' com sucesso.';		
			}
		}			
	}
}


?>


<b>## SHOWS POR CIDADE ##</b>  -> <a href="index.php">voltar para a home</a> -> <a href="show_index.php">voltar para lista de cidades</a>

<br /><br /><b style="font-size:24px;"><?=$cidade->nome?></b><br /><br />

<br><br>

<?

$keepData = false;
if (isset ($result) || isset ($flag_excluido) || isset ($flag_atualizado)) {
	
	echo '<span style="color:#fff; background-color:#'.(isset ($flag_excluido)? (($flag_excluido?"090":"D00")) :($result?"090":"D00")).'; padding:5px;  margin-left:160px">' . $msg . '</span><br><br><br>';
	
	if ($picture!==NULL) 
		echo '<span style="color:#fff; background-color:#090; padding:5px;  margin-left:160px">' . $picture . '</span><br><br><br>';
	else
		echo '<span style="color:#fff; background-color:#090; padding:5px;  margin-left:160px"> No pic issues</span><br><br><br>';
	
	if ($result) {
				
		?>
		
		<a id="reaproveitarScript" href="javascript:void(0)" style="color:#DB4865; margin-left:160px">-- reaproveitar dados anteriores --</a>
		<br>
		
		<script type="text/javascript">

			$("#reaproveitarScript").click(function() { 
				$("#artista").val("<?=$_POST['artista']?>");
				$("#sartista").val("<?=$_POST['artista']?>");
				$("#id_artista").val("<?=$_POST['id_artista']?>");
				
				$("#data").val("<?=$_POST['data']?>");
				$("#hora").val("<?=$_POST['hora']?>");
				$("#minuto").val("<?=$_POST['minuto']?>");
				$("#slider_hor").slider( "option", "value", <?=(int)$_POST['hora']?>);
				$("#slider_min").slider( "option", "value", <?=(int)$_POST['minuto']?>);
				
				$("#local").val("<?=$_POST['local']?>");

				$("#endereco").val("<?=$_POST['endereco']?>");
				$("#evento").val("<?=$_POST['evento']?>");
				$("#fone").val("<?=$_POST['fone']?>");
				$("#preco_min").val("<?=$_POST['preco_min']?>");
				$("#preco_max").val("<?=$_POST['preco_max']?>");
				
				$("#link").val("<?=$_POST['link']?>");
				tinyMCE.activeEditor.setContent($("#hdetalhes").html());
				$("#ingresso_facil").val("<?=$_POST['ingresso_facil']?>");
				
				$("#pcidoff").show();
				$("#pcidon").hide();

				$("#ingresso_link1").val("<?=$_POST['ingresso_link1']?>");
				$("#ingresso_label1").val("<?=$_POST['ingresso_label1']?>");
				$("#ingresso_link2").val("<?=$_POST['ingresso_link2']?>");
				$("#ingresso_label2").val("<?=$_POST['ingresso_label2']?>");

				$("#classificacao").val("<?=$_POST['classificacao']?>");
				$("#classificacao_com_pais").val("<?=$_POST['classificacao_com_pais']?>");
				$("#slider_cla").slider( "option", "value", <?=(int)$_POST['classificacao']?>);
				$("#slider_claPais").slider( "option", "value", <?=(int)$_POST['classificacao_com_pais']?>);

				<?
				if (isset($_POST['id_casa'])) {
					if ($_POST['id_casa'] != "") {
						?>
						$("#id_casa").val("<?=$_POST['id_casa']?>");	
						$("#local_generico").hide();
						<?
					}
				}
				?>

				<?
				if (isset($_POST['id_evento'])) {
					if ($_POST['id_evento'] != "") {
						?>
						$("#id_evento").val("<?=$_POST['id_evento']?>");
						<?
					}
				}
				?>
				
				
				$(this).fadeOut();								
				
			});
			
		</script>
		<br>
		<?
	} else {
		$keepData = true;
	}
}



?>


<div style="background-color:transparent; width:730px; float:left">

	
	<form id="formAgenda" name="formAgenda" method="post" action="<?=URL_COMPLETA?>cidade_agenda.php?id_cidade=<?=$cidade->id?>" enctype="multipart/form-data" >		
		
		<input id="id" name="id" type="hidden" value="<?=( $id_show ? $show->id : "" ) ?>" />	
		<input id="artista" name="artista" type="hidden" value="<?=( $id_show ? $show->artista : ( $keepData ? $_POST['artista'] : "" ) )?>" />
		<input id="id_artista" name="id_artista" type="hidden" size="20" value="<?=( $id_show ? $show->id_artista : ( $keepData ? $_POST['id_artista'] : "" ) )?>" />
			
		<!-- ARTISTA -->
		
		<label class="formLabel">Artista</label>
		<input id="sartista" name="sartista" type="text" maxlength="240" style="width:275px;" value="<?=( $id_show ? $show->artista : ( $keepData ? $_POST['artista'] : "" ) )?>" disabled />
		<div style="clear:left"></div><br>
		<a id="partoff" href="javascript:void(0)" style="margin-left:160px; display:none">clique aqui para pesquisar</a>	
		
		<div id="parton" style="display:block">	
			<label class="formLabel" style="color:#AAA">Pesquisar artista</label>
			<input id="partista" name="cartista" type="text" maxlength="240" style="width:275px;" />
			&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="artista_listar.php">(ver lista)</a>
			&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="artista_cadastro.php">(inserir)</a>	
			<div id="tombo" class="tombo" style="clear:left; display:false"></div>
		</div>	
		<div style="clear:left"></div><br><br>
		
		
		<!-- DATA -->
		<label class="formLabel">Data</label>
		<input id="data" name="data" class="datepicker" type="text" style="width:275px;" value="<?=( $id_show ? $show->data : ( $keepData ? $_POST['data'] : "" ) ) ?>" />
		<div style="clear:left"></div><br><br>
		
		
		<input class="formSubmit"  style="float:left; width:415px; height:60px; background-color:#9C9AD6; color:#fff; font-size:20px" id="postSimples" name="postSimples" type="submit" value="<?=( $id_show ? "ALTERAR" : "INSERIR")?>" />
		<div style="clear:left"></div><br><br>
		
		
		
		<!-- IMAGEM-->
		<br><br>
		<label class="formLabel">Imagem do Show:</label>
		<input name="arquivo" type="file" />
		<input id="txt_img" name="txt_img" type="hidden" maxlength="250" style="width:100px;" value="<?=($id_show ? ($show->imagem!==NULL? $show->imagem:"") : "")?>" />
		
		<?
		if ($id_show) {
			if ($show->imagem!==NULL) {
				?>
			 	<div style="margin-left:162px;">
				 	<br><br><img id="img_fot" src='<?=URL_IMAGEM_SHOWS.$show->imagem?>' /><br><br>
				 	<a id="bt_remover_img" href="javascript:void(0)">Remover Imagem</a>
			 	</div>
			 	<?
		 	}
		 }
		?>

		<script>

		var img = $('#txt_img').val();

		$('#bt_remover_img').click(function() {
			aux_img = $('#txt_img').val();
			if (aux_img!="") {
				$('#txt_img').val("");
				$('#img_fot').slideUp();
				$('#bt_remover_img').html('Voltar Imagem Removida');
			} else {
				$('#txt_img').val(img);
				$('#img_fot').slideDown();
				$('#bt_remover_img').html('Remover Imagem');
			}
			
			
		});






		</script>
		
		


		
		<br><br>
		<!-- CASA -->
		
		<label class="formLabel">Casa</label>
				
		<?
		$fields = "ID, NOME, DATEDIFF( NOW( ) , ULTIMA_ATUALIZACAO_DADOS ) AS DIAS_SEM_ATUALIZAR";
		$table = "CASA";
		$where = "ID_CIDADE = " . $cidade->id;
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, $where, $order);
		
		if ($regs["total"]) {
			?>
			<select id="id_casa" name="id_casa" style="width:275px;">
			<option value=""> - selecione - </option>			
				<?
				foreach ($regs["dados"] as $i) {
					?>			
					<option value="<?=$i['ID']?>" <?=( $id_show ? ($show->id_casa==$i['ID']?' selected ':'') : '')?>>
						<?=($i['DIAS_SEM_ATUALIZAR']>180?"(D) ":"")?>
						<?=$i['NOME']?>
					</option>
					<?
				}			
				?>				
			</select>
			<?
		} else {
			?><span style="color:#999">Esta cidade não possui casas cadastradas</span><?
		}
		?>		
		<div style="clear:left"></div><br><br>
		
		
		<div id="local_generico" <?=( $id_show ? ($show->id_casa !== NULL ? 'style="display:none"' : '' ) : '' )  ?>>
			<!-- LOCAL -->
			
			<label class="formLabel">Local</label>
			<input id="local" name="local" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->local : ( $keepData ? $_POST['local'] : "" ) )?>" />
			<div style="clear:left"></div><br>
			
			<!-- ENDERECO -->
			
			<label class="formLabel">Endereço</label>
			<input id="endereco" name="endereco" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->endereco : ( $keepData ? $_POST['endereco'] : "" ) )?>" />
			<div style="clear:left"></div><br>
			
			<!-- FONE -->
			
			<label class="formLabel">Telefone</label>
			<input id="fone" name="fone" type="text" maxlength="250" style="width:275px;" value="<?=( $id_show ? $show->fone : ( $keepData ? $_POST['fone'] : "" ) )?>" />
			<div style="clear:left"></div><br>
		</div>
		
		<!-- EVENTO -->
		
		<label class="formLabel">Evento</label>
		<?
		$fields = "ID, NOME";
		$table = "EVENTO";
		$where = "ID_CIDADE = " . $cidade->id . " AND FIM >= CURRENT_DATE";
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, $where, $order);
		
		if ($regs["total"]) {
			?>
			<select id="id_evento" name="id_evento" style="width:180px;">
			<option value=""> - selecione - </option>			
				<?
				foreach ($regs["dados"] as $i) {
					?>			
					<option value="<?=$i['ID']?>" <?=( $id_show ? ($show->id_evento==$i['ID']?' selected ':'') : '')?>><?=$i['NOME']?></option>
					<?
				}			
				?>				
			</select>
			<?
		} else {
			?><span style="color:#999">Esta cidade não possui eventos cadastrados</span><?
		}
		?>
		<input id="evento" name="evento" type="text" maxlength="250" style="width:180px;" value="<?=( $id_show ? $show->evento : ( $keepData ? $_POST['evento'] : "" ) )?>" />
		<div style="clear:left"></div><br>
		
		<!-- PREÇO -->
		
		<label class="formLabel">Preço</label>
		$<input id="preco_min" name="preco_min" type="text" maxlength="6" style="width:50px;" value="<?=( $id_show ? $show->preco_min : ( $keepData ? $_POST['preco_min'] : "" ) )?>" />,00
		
		<span style="color:#999">
			&nbsp;&nbsp;&nbsp; até &nbsp;&nbsp;&nbsp;
			$<input id="preco_max" name="preco_max" type="text" maxlength="6" style="width:50px;" value="<?=( $id_show ? $show->preco_max : ( $keepData ? $_POST['preco_max'] : "" ) )?>" />,00
		</span>
		<div style="clear:left"></div><br>
		
		
		<!-- HORARIO -->	
		<label class="formLabel">Horas:</label>		
		<input id="hora" name="hora" type="text" style="width:20px; float:left"" value="<?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 0, 2) : '-1') : '-1' )?>" />
		<div id="slider_hor" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		<div style="clear:left"></div>
		<label class="formLabel">Minutos:</label>
		<input id="minuto" name="minuto" type="text" style="width:20px; float:left"" value="<?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 3, 2) : '0') : '0' )?>" />
		<div id="slider_min" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- CLASSIFICACAO -->
	
		<label class="formLabel">Classificação:</label>		
		<input id="classificacao" name="classificacao" type="text" style="width:20px; float:left"" value="<?=( $id_show ? ( $show->classificacao ? $show->classificacao : "-1" ) : '-1' )?>" />
		<div id="slider_cla" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		<div style="clear:left"></div>
		<label class="formLabel">Classif. com pais/resp:</label>
		<input id="classificacao_com_pais" name="classificacao_com_pais" type="text" style="width:20px; float:left"" value="<?=( $id_show ? ( $show->classificacao_com_pais ? $show->classificacao_com_pais : "-1" ) : '-1' )?>" />
		<div id="slider_claPais" style="width:360px; float:left; margin-left:25px; margin-top:4px;"></div>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- INGRESSO1 -->
		
		<label class="formLabel">Link1 compra ingresso</label>	
		<input id="ingresso_link1" name="ingresso_link1" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->ingresso_link1 : ( $keepData ? $_POST['ingresso_link1'] : "" ) )?>" />
		<div style="clear:left"></div>
		<label class="formLabel">Site1</label>		
		<?
		$fields = "ID, NOME, URL_LAYOUT";
		$table = "INGRESSO";		
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, false, $order);
		
		if ($regs["total"]) {
			?>
			<select id="ingresso_label1" name="ingresso_label1" style="width:100;">
			<option value=""> - selecione - </option>			
				<?
				foreach ($regs["dados"] as $i) {
					?>			
					<option value="<?=$i['URL_LAYOUT']?>" <?=( $id_show ? ($show->ingresso_label1==$i['URL_LAYOUT']?' selected ':'') : '')?>><?=$i['NOME']?></option>
					<?
				}			
				?>				
			</select>
			<?
		}
		?>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- INGRESSO2 -->
		
		<label class="formLabel">Link1 compra ingresso</label>	
		<input id="ingresso_link2" name="ingresso_link2" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->ingresso_link2 : ( $keepData ? $_POST['ingresso_link1'] : "" ) )?>" />
		<div style="clear:left"></div>
		<label class="formLabel">Site2</label>		
		<?
		$fields = "ID, NOME, URL_LAYOUT";
		$table = "INGRESSO";		
		$order = "NOME";
		$regs = db_selectRecords($fields, $table, false, $order);
		
		if ($regs["total"]) {
			?>
			<select id="ingresso_label2" name="ingresso_label2" style="width:100;">
			<option value=""> - selecione - </option>			
				<?
				foreach ($regs["dados"] as $i) {
					?>			
					<option value="<?=$i['URL_LAYOUT']?>" <?=( $id_show ? ($show->ingresso_label2==$i['URL_LAYOUT']?' selected ':'') : '')?>><?=$i['NOME']?></option>
					<?
				}			
				?>				
			</select>
			<?
		}
		?>
		
		<div style="clear:left"></div><br><br>
		
		
		<!-- MAIS DETALHES -->		
		
		<label class="formLabel">Mais detalhes</label>
		<textarea id="detalhes" name="detalhes" style="" class="mceEditor" rows="10" cols="64" ><?=( $id_show ? $show->detalhes : ( $keepData ? $_POST['detalhes'] : "" ) )?></textarea>
		<div id="hdetalhes" style="display:none"><?=$_POST['detalhes']?></div>		
		<div style="clear:left"></div><br><br>			
		
		
		<br><br><br>
		
		<input class="formSubmit"  style="float:left; width:415px; height:60px; background-color:#9C9AD6; color:#fff; font-size:20px" id="postSimples2" name="postSimples2" type="submit" value="<?=( $id_show ? "ALTERAR" : "INSERIR")?>" />
		<div style="clear:left"></div><br><br>	
		
		<div style="display:none">
			<!-- Link hidden-->
			
			<label class="formLabel">Link</label>
			<input id="link" name="link" type="text" maxlength="250" style="width:480px;" value="<?=( $id_show ? $show->link : ( $keepData ? $_POST['link'] : "" ) )?>" />
			<div style="clear:left"></div><br><br>
			
			
		</div>
			
		
	</form>

</div>
		
<div style="background-color:#transparent; width:260px; float:left;">
	
	<b>LISTA DE SHOWS</b>
	<br><br>
	
	<span id="confirmaExclusao" style="float:left; margin-bottom:8px; background-color:#F99; padding:5px; display:none; width:260px;">
		Apagar <span></span>? &nbsp&nbsp&nbsp&nbsp
		<a id="apagar1" href="javascript:void(0)">SIM</a>&nbsp&nbsp&nbsp
		<a id="apagar0" href="javascript:void(0)">NÃO</a></span>
	
	<div id="box_shows">
		<?	
		
		$sql = "
			SELECT
				SHO.ID AS ID,
				ART.NOME AS ARTISTA,
				DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS DATA,
				DATE_FORMAT( SHO.HORA, '%H:%i' ) AS HORA,
				SHO.DATA AS DATARAW			
			FROM
				`SHOW` AS SHO
			LEFT JOIN
				ARTISTA AS ART
			ON
				SHO.ID_ARTISTA = ART.ID
			WHERE
				ID_CIDADE = " . $cidade->id . "
				AND SHO.DATA >= CURRENT_DATE 
			ORDER BY
				DATARAW, HORA
		";
		
		$regs = db_selectRecordsRawSQL($sql);	
		
		$hoje = sys_getToday();
		
		
		$cor = array(
				0 => "fff",
				1 => "eee"
		);
		
		$pcor = array(
				0 => "FFC7C7",
				1 => "FFACAC"			
		);
		
		$j = 0;
		if ($regs["total"]) {
		
			foreach ($regs["dados"] as $i) {			
				$data_show = $i['DATARAW'];
				$cor_fundo = ( strnatcmp ($data_show, $hoje) < 0 ? $pcor[($j%2)] : $cor[($j%2)] );
				
				?>			
				<span style="float:left; width:460px; padding:5px; background-color:#<?=$cor_fundo?>">
					<a rel="<?=$i['ID']?>" class="btExcluir" href="javascript:void(0)">excluir</a>&nbsp;&nbsp;&nbsp;
					<a href="cidade_agenda.php?id_cidade=<?=$cidade->id?>&id_show=<?=$i['ID']?>">editar</a>&nbsp;&nbsp;&nbsp;
					<span class="reg<?=$i['ID']?>"><?=$i['DATA']?> &nbsp; <?=$i['ARTISTA']?></span>
				</span>
				<?	
				$j++;
			}
			
		} else {
			echo '<span style="color:#900">Nenhum show cadastrado</span>';
		}	
		
		
		?>
	</div>	
	<br><br><br><br><br><br><br>
</div>
<div style="clear:left"></div>

<script type="text/javascript">

	$(document).ready(function () {	
		
		$('#data').change(function(){
			//$("#debug").append(" c:" + $(this).val());
			buscaShows($(this).val(), <?=$cidade->id?>)
		});


		function buscaShows(dia, id_cidade) {
			$('#box_shows').html('<img src="images/loader.gif" />');
			$.ajax({
				url: 'ajax-shows_por_dia.php',									
				type: "GET",
				cache: false,
				data: { dia: dia, id_cidade: id_cidade },
				success: function(data) {								
																			
					$("#box_shows").html(data);
					
					//$("#debug").append(" # ");
													
				}
			});
		}
		
		
		//$('option[value*="20"]').html("esse eh o cara");
		//$("#hora").val("8");
		
		var indexMenu = 1;
		
		
		/*$('#pcidade').bind('keyup', function() {				
			alert ("-> " + this.value);
		});*/
		
		
		$("#partista").keydown(function (event) {
			
			tecla = event.keyCode;			
			
			if (tecla == 38) {				
				navigateMenu('up');				
			}
			if (tecla == 40) {		
						
				navigateMenu('down');
			}
			if (tecla == 13) {
				
				artista = $("a.itemTomboSelected").html();
				id_artista = $("a.itemTomboSelected").attr("rel");
				
				$("#artista").val(artista);
				$("#sartista").val(artista);
				$("#id_artista").val(id_artista);
				
				//$("#debug").append(" c:" + id_cidade);
				finalizaEscolha();
				return false; // nao postar form;
			}	
			
		});
		
		
		function finalizaEscolha() {
			indexMenu = 1;
			$("#tombo").html("").hide();
			$('#partista').val("");
			$("#parton").hide();
			$("#partoff").fadeIn();			
		}

		$("#id_casa").change(function() {	
			if($(this).val() == "") {
				$("#local_generico").fadeIn();
			} else {
				$("#local_generico").fadeOut();
			}
		});


		$(function() {
			$( "#slider_cla" ).slider();
			$( "#slider_cla" ).slider({ min: -1 });
			$( "#slider_cla" ).slider({ max: 18 });
			$( "#slider_cla" ).slider({
				slide: function( event, ui ) {
					$("#classificacao").val(ui.value);
				}
			});

			$( "#slider_cla" ).slider( "value", <?=( $id_show ? ($show->classificacao ? $show->classificacao : '-1' ) : '-1' )?>);				
		});

		$(function() {
			$( "#slider_claPais" ).slider();
			$( "#slider_claPais" ).slider({ min: -1 });
			$( "#slider_claPais" ).slider({ max: 18 });
			$( "#slider_claPais" ).slider({
				slide: function( event, ui ) {
					$("#classificacao_com_pais").val(ui.value);
				}
			});

			$( "#slider_claPais" ).slider( "value", <?=( $id_show ? ($show->classificacao_com_pais ? $show->classificacao_com_pais : '-1' ) : '-1' )?>);				
		});

		$(function() {
			$( "#slider_hor" ).slider();
			$( "#slider_hor" ).slider({ min: -1 });
			$( "#slider_hor" ).slider({ max: 23 });
			$( "#slider_hor" ).slider({
				slide: function( event, ui ) {
					$("#hora").val(ui.value);
				}
			});
			$( "#slider_hor" ).slider( "value", <?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 0, 2) : '-1') : '-1' )?>);				
		});

		$(function() {
			$( "#slider_min" ).slider();
			$( "#slider_min" ).slider({ min: 0 });
			$( "#slider_min" ).slider({ max: 55 });
			$( "#slider_min" ).slider({ step: 5 });
			$( "#slider_min" ).slider({
				slide: function( event, ui ) {
					$("#minuto").val(ui.value);
				}
			});
			$( "#slider_min" ).slider( "value", <?=( $id_show ? ($show->hora !== NULL ? substr($show->hora, 3, 2) : '0') : '0' )?>);				
		});
		
		
		function navigateMenu(orientacao){
			
			numResult = parseInt($("#tombo > a").size());
			
			if (orientacao == "down") 
			{				
				if (indexMenu < numResult) {
					$("a.itemTomboSelected").removeClass("itemTomboSelected");
					indexMenu++;				
					$("a.itemTombo").eq(indexMenu-1).addClass("itemTomboSelected");
					//$("#debug").append(" d ");
				}
			}
			if (orientacao == "up") 
			{				
				if (indexMenu > 1) {
					$("a.itemTomboSelected").removeClass("itemTomboSelected");
					indexMenu--;				
					$("a.itemTombo").eq(indexMenu-1).addClass("itemTomboSelected");
					//$("#debug").append(" u ");
				}
			}
			
		}	
				
		
		$('#partista').bind('keyup', function() {	
			var t = this;			
			if (this.value != this.lastValue) {
				if (this.timer) { clearTimeout(this.timer);  }								
				valor = $.trim(t.value);
				if (valor.length >= 1) {
					if($("#tombo").is(":hidden")) $("#tombo").show();
					$('#tombo').html('<img src="images/loader.gif" />');
					this.timer = setTimeout(function () {						
						valor = stringFriendly(valor);	
						$.ajax({
							url: 'ajax-artista.php',									
							type: "GET",
							cache: false,
							data: { frurl: valor },
							success: function(data) {								
																						
								$("#tombo").html(data);
								indexMenu = 1;
								//$("#debug").append(" # ");
																
							}
						});
					}, 200);
					this.lastValue = this.value;
				} else {
					$("#tombo").html("").hide();					
					//$("#debug").append(" xxx ");
				}
			}	
		});	
		
		
		jQuery(function($) {
			$.datepicker.regional['pt-BR'] = {
				closeText: 'Fechar',
				prevText: '&#x3c;Anterior',
				nextText: 'Pr&oacute;ximo&#x3e;',
				currentText: 'Hoje',
				monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
				monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
				dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
				dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
				dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 0,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
		});
		
		
		$(".datepicker").datepicker();
		$(".datepicker").focus(function() {
			$(this).blur();
		});
		
	});

	

	$(".btExcluir").click(function() {
		$("#apagar1").attr("href", "<?=URL_COMPLETA?>cidade_agenda.php?id_cidade=<?=$cidade->id?>&delete=" + $(this).attr("rel"))
		$("#confirmaExclusao").children('span').html($("span.reg"+$(this).attr("rel")).html());
		$("#confirmaExclusao").slideDown();
	});

	$("#apagar0").click(function() {
		$("#confirmaExclusao").slideUp();		
	});

		
	$("#partoff").click(function() {
		$(this).hide();
		$("#parton").fadeIn();
	});

	

	function stringFriendly(str) {
		return str.toLowerCase().trim()
		.replace(/[áàãâä]/g, "a")
		.replace(/[éèẽêë]/g, "e")
		.replace(/[íìĩîï]/g, "i")
		.replace(/[óòõôö]/g, "o")
		.replace(/[úùũûü]/g, "u")
		.replace(/ç/g, "c")
		.replace(/(\ |)+/, "")
		.replace(/(^-+|-+$)/, "")
		.replace(/[^a-z0-9@._]+/g,'-');
	}
	
	
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
		editor_selector : "mceEditor",
		theme: "advanced",                
		plugins: 'advlink',

		// Theme options
		theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,formatselect,|,hr,bullist,numlist,|,link,unlink,|,table,removeformat,code",
		theme_advanced_buttons2: "",
		theme_advanced_buttons3: "",
		theme_advanced_buttons4: "",
		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		theme_advanced_resizing: true,

		// Example content CSS (should be your site CSS)
		content_css: "/js/tinymce/examples/css/content.css",
	   
	});

	$("#hora").focus(function() { $(this).blur(); });
	$("#minuto").focus(function() { $(this).blur(); });
	$("#classificacao").focus(function() { $(this).blur(); });
	$("#classificacao_com_pais").focus(function() { $(this).blur(); });
	

	
</script>



<br><br><br><br>

<?
include ("includes/footer.php");
?>