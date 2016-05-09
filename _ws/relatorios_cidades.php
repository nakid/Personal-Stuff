<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");
?>




<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div style="clear:left"></div>
<div style="float:left">
	
	<?
	
	
	
	
	/*
	$sql = "
		SELECT 
			COUNT( ID ) AS TOTAL
		FROM 
			`SHOW`
		WHERE 
			DATA >= CURRENT_DATE
	";
	
	$reg = db_selectRecordRawSQL($sql);			
		
	?>
	<div style="clear:left"></div>
	<span style="float:left; font-size:22px; width:340px; padding:5px;">
		TOTAL DE SHOWS ATIVOS: <b style="color:#DB8B00; font-size:22px;"><?=$reg['TOTAL']?></b>
	</span>
	
	<div style="clear:left"></div>
	
	<br><br><br>
	
	*/
	
	
	
	// CIDADES LIDERES EM SHOWS ATIVOS
	
	unset ($regs);
	unset ($data_chart);
	
	$sql = "
		SELECT 
			CID.ID AS CIDADE_ID,
			CID.NOME AS CIDADE, 
			CID.UF AS UF,
			COUNT( SHO.ID ) AS TOTAL
		FROM 
			`SHOW` AS SHO
		INNER JOIN 
			CIDADE AS CID 
		ON 
			SHO.ID_CIDADE = CID.ID
		WHERE 
			DATA >= CURRENT_DATE
		GROUP BY 
			CID.ID
		ORDER BY 
			TOTAL DESC
		LIMIT 20 
	";
		
	$regs = db_selectRecordsRawSQL($sql);			

	$flag_ini_ids_top20_cid = true;	
	$array_top20_cid = array();
	$ids_top20_cid = "( ";
	$data_num_shows_por_cidade = "";
	
	foreach ($regs["dados"] as $i) {
		if ($flag_ini_ids_top20_cid) $flag_ini_ids_top20_cid = false; else $ids_top20_cid .= ",";
		$ids_top20_cid .= $i['CIDADE_ID']." ";
		$data_chart .= ",['".$i['CIDADE']."/".$i['UF']."',  ".$i['TOTAL']."]";		
		$array_top20_cid[$i['CIDADE_ID']] = $i['CIDADE'];
	}
	$ids_top20_cid .= ") ";
	?>
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Cidade', 'Shows']<?=$data_chart?>		  
        ]);

        var options = {
          title: 'Cidades líderes em shows ativos'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_cidLiderShowMomento'));
        chart.draw(data, options);
      }
    </script> 
    <div id="chart_cidLiderShowMomento" style="width: 1200px; height: 500px;"></div>
 
	<?
	
	//SHOW ATIVOS POR DIA POR CIDADE
	
	
	//ARRAY TOP 20
	/*$array_top20_cid = array();
	$array_top20_cid[5270] = 'São Paulo';
	$array_top20_cid[3658] = 'Rio de Janeiro';
	$array_top20_cid[882] = 'Brasília';
	$array_top20_cid[756] = 'Fortaleza';
	$array_top20_cid[1630] = 'Belo Horizonte';*/
	$chart_table_header = "";
	
	// GERANDO VARIAVEL COM IDS 20 PARA SQL
	$flag_ini_top20_SQL = true;	
	$top20_SQL = "(";		
	foreach ($array_top20_cid as $key => $value) {
		if ($flag_ini_top20_SQL) $flag_ini_top20_SQL = false; else $top20_SQL .= ",";
		$top20_SQL .= $key;
		$chart_table_header .= ", '".$value."'";		
	}
	$top20_SQL .= ") ";	
	
	
	//CONSULTANDO SHOWS POR DIA DAS TOP 20
	
	unset ($regs);
	unset ($data_chart);
	
	//CID.ID	IN " . $ids_top20_cid . "
	$sql = "
		SELECT 
			CID.ID AS CIDADE_ID,
			CID.NOME AS CIDADE,				
			CID.UF AS UF, 
			DATE_FORMAT( SHO.DATA,  '%d-%m-%Y' ) AS DATA, 
			COUNT( SHO.ID ) AS TOTAL
		FROM  
			`SHOW` AS SHO
		LEFT JOIN 
			CIDADE AS CID 
		ON 
			SHO.ID_CIDADE = CID.ID
		WHERE
			SHO.DATA >= CURRENT_DATE AND 	
			CID.ID	IN " . $top20_SQL . "
		GROUP BY 
			SHO.DATA, 
			CID.ID
		ORDER BY 
			SHO.DATA ASC
	";
		
	$regs = db_selectRecordsRawSQL($sql);	
	//dev_print($regs ); exit;
	
	//FORMATANDO RESULTADO BUSCA COM ARRAY POR DIA
	
	$array_gelal_por_dia = array();	
	foreach ($regs["dados"] as $i) {		
		$array_gelal_por_dia[$i['DATA']][$i['CIDADE_ID']]['NOME'] = $i['CIDADE'];
		$array_gelal_por_dia[$i['DATA']][$i['CIDADE_ID']]['TOTAL'] = $i['TOTAL'];
	}	
	//dev_print($array_gelal_por_dia); exit;
	
	//CRIANDO VARIAVAL TIPO TABELA PARA O SCRIPT DO CHART
	
	/*
	['Dia', 'Ribeirao', 'Brasilia', 'Sao Paulo'],
          ['2004',  1000,      400, 620 ],
          ['2005',  1170,      460, 225],
          ['2006',  660,       1120, 221],
          ['2007',  1030,      540, 558]
	*/

	$chart_table = "['Dia'" . $chart_table_header ."]";
		
	foreach ($array_gelal_por_dia as $dia => $cidadeEtotal) {				
		$chart_table .= ",['" . $dia . "'";			
		//dev_print($cidadeEtotal);
		foreach ($array_top20_cid as $cidade_id => $cidade) {
		
			if (array_key_exists($cidade_id, $cidadeEtotal)) {
				$chart_table .= ', '.$cidadeEtotal[$cidade_id]['TOTAL'];
			} else {
				$chart_table .= ', 0';
			}
			
		}		
		$chart_table .= "]";
	}
	//dev_echo ($chart_table);
	
	?>
	
	
	
	
	
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?=$chart_table?>
        ]);

		
		
		
        var options = {
          title: 'Company Performance'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_showsAtivosPorDiaPorCidadeo'));
        chart.draw(data, options);
      }
    </script>  
    <div id="chart_showsAtivosPorDiaPorCidadeo" style="width: 1600px; height: 900px;"></div>
	
	
	<br><br><br><br><br><br>
	
	
	<?
	
	
	
	// CIDADES LIDERES EM SHOWS ALL TIME
	
	unset ($regs);
	unset ($data_chart);
	
	
	$sql = "
		SELECT 
			CID.NOME AS CIDADE, 
			CID.UF AS UF,
			COUNT( SHO.ID ) AS TOTAL
		FROM 
			`SHOW` AS SHO
		INNER JOIN 
			CIDADE AS CID 
		ON 
			SHO.ID_CIDADE = CID.ID		
		GROUP BY 
			CID.ID
		ORDER BY 
			TOTAL DESC
		LIMIT 20 
	";
	
	$regs = db_selectRecordsRawSQL($sql);			

	
	
	$data_num_shows_por_cidade = "";
	foreach ($regs["dados"] as $i) {
		$data_chart .= ",['".$i['CIDADE']."/".$i['UF']."',  ".$i['TOTAL']."]";		
	}
	?>
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Cidade', 'Shows']<?=$data_chart?>		  
        ]);

        var options = {
          title: 'Cidades líderes em shows ativos all time'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_cidLiderShowAllTime'));
        chart.draw(data, options);
      }
    </script> 
    <div id="chart_cidLiderShowAllTime" style="width: 1200px; height: 500px;"></div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</div>
<div style="clear:left"></div><br>


<?
include ("includes/footer.php");
?>