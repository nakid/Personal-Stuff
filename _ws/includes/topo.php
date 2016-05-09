<?

if (isset($_GET['navegar_como']))
	$_SESSION['ID_DADOS'] = $_GET['navegar_como'];

	
$sql = "
	SELECT 
		COUNT( ID ) AS TOTAL
	FROM 
		`SHOW`
	WHERE 
		DATA >= CURRENT_DATE
";

$reg = db_selectRecordRawSQL($sql);			

$hoje = getdate(); 
	
?>


<div style="position:fixed; background-color:#F5EBEC; padding:10px; width:1000px; z-index:9999;">
	<div style="float:left; background-color:#transparent; padding-bottom:21px; width:1000px;">
		<span style="float:left"><b>SHOWSEM ADM - <span style="color:#f64"><?=$hoje["mday"]?>/<?=$hoje["mon"]?>/<?=$hoje["year"]?></span> | </b></span>
		
		<span style="float:left; margin-left:30px;">Logado como: <span style="background-color:#069; color:#fff; padding:2px;"><?=strtoupper($_SESSION["NOME"])?></span></span>
				
		<span style="float:left; margin-left:30px;">
			
			Navegar como: 
		
			<?
			$fields = "ID, NOME";
			$table = "USUARIO";
			$where = false;
			$order = "NOME";
			$regs = db_selectRecords($fields, $table, $where, $order);
			
			foreach ($regs["dados"] as $i) {
				
				if ($i['ID'] == $_SESSION['ID_DADOS'])
					$styleUsuNav = "background-color:#" . ($_SESSION['ID'] == $_SESSION['ID_DADOS'] ? "069" : "f64" ) . "; color:#fff; padding:2px;";
				else	
					$styleUsuNav = "color:#000; padding:2px;";
				?>
				<?//=URL_BASE.$_SERVER['REQUEST_URI']?>
				<a style="<?=$styleUsuNav?>" href="index.php?navegar_como=<?=$i['ID']?>"><?=strtoupper($i['NOME'])?></a>		
				<?
			}
			?>	
			
			
			<!--$_SESSION['ID'] = $login["ID"];
			$_SESSION['ID_DADOS'] = $login["ID"];
			$_SESSION['NOME'] = $login["NOME"];
			$_SESSION['COR'] = $login["COR"];						
			$_SESSION['ORDEM_ARTISTA'] = "cat";
			-->
			
		</span>
		<span style="float:left; margin-left:60px">
			Shows ativos: <b style="color:#f64;"><?=$reg['TOTAL']?></b>
		</span>
		<span style="float:left; font-size:10px; width:200px; padding-left:5px;">
			: Objetivo Jun/13: manter 2000/dia
		</span>
	
	</div>
	<span style="float:left"></span>
	<div style="float:left; background-color:transparent;width:1000px;">
		
		<div style="float:left;">
			<a href="index.php" style="color:#09A">DASHBOARD</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="artista_listar.php" style="color:#09A">ARTISTAS</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="show_index.php" style="color:#09A">CIDADES</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="casa_index.php" style="color:#09A">CASAS</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="ingresso_listar.php" style="color:#09A">INGRESSOS</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="evento_listar.php" style="color:#09A">EVENTOS</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="relatorios.php" style="color:#09A">RELATORIOS</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="contato_listar.php" style="color:#09A">CONTATO</a>			
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="sair.php" style="color:#09A">SAIR</a>
		</div>			
	</div>		
</div>

<div style="position:fixed; background-color:#f9fafa; height:25px; width:1020px; top:71px; z-index:9999;"></div><!-- apenas para margen do topo em relação ao conteúdo -->
<div style="float:left; padding:10px; width:1000px; height:76px;"></div><!-- apenas para a tela nao ficar atrás do topo -->


<div style="position:fixed; left:719px; top:46px; background-color:transparent; z-index:99999">
	<span style="float:left">artista: <input id="partista_topo" type="text" maxlength="240" style="width:275px;" /></span><div style="clear:left"></div>
	<div id="tombo_topo" class="tombo_topo" style="float:left; width:280px; padding:5px; margin-left:40px; background-color:#F5EBEC; display:none;"></div> 
</div>

<script type="text/javascript">
	
	
	
	$('#partista_topo').bind('keyup', function() {	
		
		var t = this;			
		if (this.value != this.lastValue) {
			if (this.timer) { clearTimeout(this.timer);  }								
			valor = $.trim(t.value);
			if (valor.length >= 1) {
				if($("#tombo_topo").is(":hidden")) $("#tombo_topo").show();
				$('#tombo_topo').html('<img src="images/loader.gif" />');
				this.timer = setTimeout(function () {						
					valor = stringFriendly(valor);	
					$.ajax({
						url: 'ajax-artista-topo.php',									
						type: "GET",
						cache: false,
						data: { frurl: valor },
						success: function(data) {								
																					
							$("#tombo_topo").html(data);
							indexMenu = 1;
							//$("#debug").append(" # ");
															
						}
					});
				}, 200);
				this.lastValue = this.value;
			} else {
				$("#tombo_topo").html("").hide();					
				//$("#debug").append(" xxx ");
			}
		}	
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
	
	/*$("#partista_topo").keydown(function (event) {
			
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
	}*/
</script>




