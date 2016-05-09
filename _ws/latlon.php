<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>

<?	
	
	
	if($_POST) {
		
		//dev_print($_POST);
		$id = $_POST['id'];
		$lat = trim($_POST['lat']);
		$lon = trim($_POST['lon']);
		
		$sql = "";
		
		if ($_POST['naomapeado']) {
		
			$sql = "
				UPDATE 
					CIDADE 
				SET
					NAO_MAPEADO = 0
				WHERE
					ID = " . $id . "
			";
		} else {
		
			if ($lat != "" && $lon != "") {
			
				$sql = "
						UPDATE 
							CIDADE 
						SET
							LAT = '" . $lat . "',
							LON = '" . $lon . "'
						WHERE
							ID = " . $id . "
				";
			
			}
		}
		
		if ($sql != "") {
		
			//echo $sql;
			
			$mysql = new mysql();
			$q = $mysql->query($sql);			
			
			if ($q) {
				dev_echo('<span style="color:#090">UM A MENOS PRA VOCÊ, FELOW!</span>');
			} else {
				dev_echo('<span style="color:#900">DEU PAU! NÃO DESANIME, CHAMA O NAKID! 8211 3004</span>');		
			}
		} else {
			dev_echo('<span style="color:#900">PREENCHA OS DADOS CORRETAMENTE!</span>');
		}
	}

	
	
	$table = "CIDADE";
	$where = "LAT IS NULL AND LON IS NULL AND NAO_MAPEADO IS NULL ";
	
	if ($_SESSION['ID_DADOS'] == 1) {
	
		$whereid = " AND 1";	
	
	} elseif ($_SESSION['ID_DADOS'] == 2) { 
	
		$whereid = " AND 0";	
	
	} elseif ($_SESSION['ID_DADOS'] == 3) { 
		$whereid = " AND 0";
	}
	
	$where .= $whereid;
	
	$total = db_countRecords($table, $where);

?>

<style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 200px; margin-top:150px;}
	  #controls { height: 100px; font-size: 12px;}
</style>


<?

	$sql = "
		SELECT
			ID,
			NOME,
			UF,
			UFCOMPLETA
		FROM 
			CIDADE	
		WHERE
			LAT IS NULL AND LON IS NULL AND NAO_MAPEADO IS NULL 
			".$whereid."
		ORDER BY
			ID
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
	
	
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.1&sensor=false&language=pt-BR">
    </script>
    <script type="text/javascript">
      
	  $(document).ready(function() {
		
		cidade = $('#cid').val();
		
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({ 'address': cidade }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {

				lt = results[0].geometry.location.lat();
				ln = results[0].geometry.location.lng();

				$("#lat").val(lt);
				$("#lon").val(ln);
				
				initialize(lt, ln);

			} else {
				$("#lon").val("ERRO!!!");
			}
		});
		
		
		
		//$('#lat').val();
		
	  });
	  
	  function initialize(lt, ln) {
        var mapOptions = {
          center: new google.maps.LatLng(lt,ln),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas2"), mapOptions);
		
		var myLatlng = new google.maps.LatLng(lt,ln);
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title:"Hello World!"
		});
		
      }
    
	</script>
	
	
	
	<div id="controls" style="floa:left">
		<b>RESTAM <?=$total?> cidades para você.</b><br>
				
		<form id="formC" name="formC" method="post">		
		
			<input id="id" name="id" type="hidden" value="<?=$reg['ID']?>" />
			Cidade&nbsp&nbsp&nbsp&nbsp   : <input id="cid" name="cid" type="text" style="width:200px" value="<?=$reg['NOME']?>, <?=$reg['UFCOMPLETA']?>"><br>
			
			
			Latitude&nbsp&nbsp : <input id="lat" name="lat" type="text" style="width:200px"><br>
			Longitude: <input id="lon" name="lon" type="text" style="width:200px"><br>			
			
			<input type="checkbox" id="naomapeado" name="naomapeado"> Não Mapeado <a href="https://maps.google.com.br/" target="_blank">Ir para p Google Maps!</a><br>
			<input class="formSubmit"  style="float:left; width:200px; height:30px; background-color:#9C9AD6; color:#fff; font-size:14px" id="postSimples" name="postSimples" type="submit" value="ENVIAR" />
				
		</form>	

		
	</div>
	
	<div id="map_canvas2" style="width:100%; height:550px; float:left;"></div>
	
	
		
			
		
		
		
		
	


<?
include ("includes/footer.php");
?>