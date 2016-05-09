<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>


<?


$id = (int)$_GET['id'];

//$evento = new evento($id);



if($_POST) {	
	
	$arrEvento = array(
		
		'ID' => $_POST['id'],
		'ID_CIDADE' => $_POST['id_cidade'], 	
		'NOME' => $_POST['nome'],
		'FRURL' => $_POST['frurl'],
		'IMAGEM_DIR' => $_POST['imagem_dir'],
		'INICIO' => $_POST['inicio'],
		'FIM' => $_POST['fim'],
		'SEO_TITLE' => $_POST['seo_title'],
		'SEO_DESCRIPTION' => $_POST['seo_description'],
		'TXT1' => $_POST['txt1'],
		'TXT2' => $_POST['txt2'],
		'TXT3' => $_POST['txt3'],
		'PUBLICAR' => $_POST['publicar']
			
	);
	
	$evento = new evento($arrEvento);
	
	
	//dev_print($_POST);
	//dev_print($arrCasa);
	//dev_print($evento); exit;
	
	
	$result = $evento->Save();
	
	if (!$result) { 
		$erMsg = 'Falha na operação';
	} 
	else {	
		header( 'Location: ' . URL_COMPLETA . 'evento_listar.php?evento='.$evento->nome.'&acao=' .($evento->id === NULL?"inserido":"alterado"));
	}		
	
} else {
	$evento = new evento($id);
}


?>


<b>## <?=($evento->id ===  NULL?"ADICIONAR EVENTO": "EDITAR EVENTO : ".$evento->nome)?> ##</b>
<br><br>

<a href="evento_listar.php">voltar para a lista de eventos</a>

<br><br><br><br>

<? if (isset ($erMsg)) echo '<span style="color:#900">' . $erMsg . '</span>'; ?>

<form id="formEvento" name="formEvento" method="post">		
	
	<input id="id" name="id" type="hidden" value="<?=$evento->id?>" />	
	<input id="cidade" name="cidade" type="hidden" value="<?=( $evento->id ? $evento->cidade . "/" . $evento->estado : "" )?>" />
	<input id="id_cidade" name="id_cidade" type="hidden" size="20" value="<?=$evento->id_cidade?>" />
		
	<!-- CIDADE -->
	
	<label class="formLabel">Cidade</label>
	<input id="scidade" name="scidade" type="text" maxlength="240" style="width:275px;" value="<?=( $evento->id ? $evento->cidade . "-" . $evento->estado : "" )?>" disabled />
	<div style="clear:left"></div><br>
	<a id="pcidoff" href="javascript:void(0)" style="margin-left:160px; display:none">clique aqui para pesquisar</a>	
	
	<div id="pcidon" style="display:block">	
		<label class="formLabel" style="color:#AAA">Pesquisar cidade</label>
		<input id="pcidade" name="cpidade" type="text" maxlength="240" style="width:275px;" />	
		<div id="tombo" class="tombo" style="clear:left; display:false"></div>
	</div>	
	<div style="clear:left"></div><br><br>
		
	
	<label class="formLabel">Nome</label>
	<input id="nome" name="nome" type="text" size="90" maxlength="240"  style="width:275px;" value="<?=$evento->nome?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Friendly URL</label>
	<input id="frurl" name="frurl" type="text" size="90" maxlength="240"  style="width:275px;" value="<?=$evento->frurl?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Diretorio das Imagens</label>
	<input id="imagem_dir" name="imagem_dir" type="text" size="40" maxlength="240"  style="width:275px;" value="<?=$evento->imagem_dir?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">Data Início</label>
	<input id="inicio" name="inicio" class="datepicker" type="text" style="width:275px;" value="<?=$evento->inicio?>" />
	<div style="clear:left"></div><br><br>
		
	<label class="formLabel">Data Fim</label>
	<input id="fim" name="fim" class="datepicker" type="text" style="width:275px;" value="<?=$evento->fim?>" />
	<div style="clear:left"></div><br><br>
	
	<label class="formLabel">SEO Title (60 max)</label>
	<input id="seo_title" name="seo_title" type="text" size="90" maxlength="60"  style="width:600px;" value="<?=$evento->seo_title?>" />	
	<div style="clear:left"></div><br>
	
	<label class="formLabel">SEO Description (150 max)</label>
	<input id="seo_description" name="seo_description" type="text" size="90" maxlength="150"  style="width:600px;" value="<?=$evento->seo_description?>" />	
	<div style="clear:left"></div><br>
	
	
	<label class="formLabel">Texto1</label>
	<textarea id="txt1" name="txt1" style="" class="mceEditor" rows="10" cols="64" ><?=$evento->txt1?></textarea>
	<div style="clear:left"></div><br><br>
	
	<label class="formLabel">Texto2</label>
	<textarea id="txt2" name="txt2" style="" class="mceEditor" rows="10" cols="64" ><?=$evento->txt2?></textarea>
	<div style="clear:left"></div><br><br>
	
	<label class="formLabel">Texto3</label>
	<textarea id="txt3" name="txt3" style="" class="mceEditor" rows="10" cols="64" ><?=$evento->txt3?></textarea>	
	<div style="clear:left"></div><br><br>
		
	
	<label class="formLabel">Publicar</label>
	<select id="publicar" name="publicar">
		<option value="0">NÃO</option>
		<option value="1" >SIM</option>		
	</select>
	
	<div style="clear:left"></div><br>
	
	<input class="formSubmit" id="postSimples" name="postSimples" type="submit" value="<?=($evento->id ===  NULL?"INSERIR":"ALTERAR")?>" />	
	
</form>


<script type="text/javascript">
	
	<?=( $id_cidade ? '$("#id_cidade").val("'. $id_cidade .'");' : '' )?>
	<?=( $evento->id_cidade ? '$("#id_cidade").val("'. $evento->id_cidade .'");' : '' )?>
	
	<?=( $evento->ativa !== NULL ? '$("#ativa").val("'. $evento->ativa .'");' : '' )?>
	
	
	
	$(document).ready(function () {	
		
		var indexMenu = 1;
		
		$("#pcidade").keydown(function (event) {
			
			tecla = event.keyCode;			
			//$("#debug").append(" - " + tecla + "-  ");
			if (tecla == 38) {				
				navigateMenu('up');				
			}
			if (tecla == 40) {							
				navigateMenu('down');
			}
			if (tecla == 13) {
				
				cidade = $("a.itemTomboSelected").html();
				id_cidade = $("a.itemTomboSelected").attr("rel");
				
				$("#cidade").val(cidade);
				$("#scidade").val(cidade);
				$("#id_cidade").val(id_cidade);			
				
				
				retorna_casas(id_cidade);				
				
				finalizaEscolha();
				return false; // nao postar form;
			}	
			
		});		
		
		function finalizaEscolha() {
			indexMenu = 1;
			$("#tombo").html("").hide();
			$('#pcidade').val("");
			$("#pcidon").hide();
			$("#pcidoff").fadeIn();			
		}
		
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
				
		
		$('#pcidade').bind('keyup', function() {	
			var t = this;			
			if (this.value != this.lastValue) {
				if (this.timer) { clearTimeout(this.timer); }								
				valor = $.trim(t.value);
				if (valor.length >= 1) {
					if($("#tombo").is(":hidden")) $("#tombo").show();
					$('#tombo').html('<img src="images/loader.gif" />');
					this.timer = setTimeout(function () {						
						valor = stringFriendly(valor);	
						$.ajax({
							url: 'ajax-cidade.php',									
							type: "GET",
							cache: false,
							data: { frurl: valor },
							success: function(data) {			
																								
								$("#tombo").html(data);
								indexMenu = 1;
																							
							}
						});
					}, 200);
					this.lastValue = this.value;
				} else {
					$("#tombo").html("").hide();					
					
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

	$("#pcidoff").click(function() {
		$(this).hide();
		$("#pcidon").fadeIn();
	});


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


	<?=( $evento->id ? '$("#publicar").val("'. $evento->publicar .'");' : '' )?>
	
	
</script>



<?
include ("includes/footer.php"); 
?>