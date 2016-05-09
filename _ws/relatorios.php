<?
include ("includes/includes.inc.php");
include ("includes/header.php");
include ("includes/topo.php");



/*

SELECT 	
	USU.NOME,
	DATE_FORMAT(SHO.CADASTRO, '%d-%m-%Y' ) AS DIA_CADASTRO,
    COUNT(SHO.ID)
FROM 
	`SHOW` AS SHO
INNER JOIN
	USUARIO AS USU
ON
	SHO.ID_USUARIO = USU.ID
GROUP BY
	USU.ID,
	DIA_CADASTRO	

*/


?>




<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div style="clear:left"></div>
<div style="float:left">
	
	
	<!-- CIDADES LIDERES EM SHOWS ATIVOS -->
	
	<?
	unset ($regs);
	unset ($data_chart);
	unset ($array_gelal_por_dia);
	
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
	
	<!-- FIM CIDADES LIDERES EM SHOWS ATIVOS -->
	
	
	
	
	
	
		<!-- NÚMERO DE CASAS ATUALIZADAS POR CIDADE -->
	
	<?
	unset ($regs);
	unset ($data_chart);
	
	
	$sql = "
		SELECT 
			  CID.NOME,
			  COUNT(CAS.ID) AS TOTAL
		FROM 
			 CASA AS CAS
		INNER JOIN
			 CIDADE AS CID
		ON
			 CAS.ID_CIDADE = CID.ID
		WHERE
			CID.ID_USUARIO <> 'NULL' AND
			CAS.ATUALIZAR = 1
		GROUP BY
			CID.ID
		ORDER BY
			TOTAL DESC
	";
		
	$regs = db_selectRecordsRawSQL($sql);			
	
	$data_header = "";
	$data_number = "";
	
	foreach ($regs["dados"] as $i) {
		
		$data_header .= ", '".$i['NOME']."'";
		$data_number .= ", ".$i['TOTAL'];
		
	}
	
	
	?>
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  
		var data = google.visualization.arrayToDataTable([
          ['Casas'<?=$data_header?>, 'Fix0'],
          ['Total'<?=$data_number?>, 0]
        ]);

        var options = {		  	
          title: 'Número de casas atualizadas por cidade'		  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_casasAtualizadasPorCidade'));
        chart.draw(data, options);
      }
    </script> 
    <div id="chart_casasAtualizadasPorCidade" style="width: 1200px; height: 500px;"></div>
	
	<!-- ////////// -->
	
	
	
	
	
	
	
	
	
	<!-- SHOW CADASTRADOS POR DIA USUARIO POR DIA-->
	
	<?
	unset ($regs);
	unset ($data_chart);
	unset ($array_gelal_por_dia);
	unset ($chart_table);
	
	$sql = "
		SELECT 	
			USU.ID AS USU_ID,
			USU.NOME AS NOME,
			DATE_FORMAT(SHO.CADASTRO, '%d-%m-%Y' ) AS DIA_CADASTRO,
			COUNT(SHO.ID) AS TOTAL
		FROM 
			`SHOW` AS SHO
		INNER JOIN
			USUARIO AS USU
		ON
			SHO.ID_USUARIO = USU.ID
		GROUP BY
			USU.ID,
			DIA_CADASTRO
		ORDER BY 
			SHO.CADASTRO ASC,
			USU_ID ASC	
	";
	//dev_echo ($sql);	
	$regs = db_selectRecordsRawSQL($sql);	
	
	//dev_print($regs["dados"]); 
	
	
	//FORMATANDO RESULTADO BUSCA COM ARRAY POR DIA
	
	$array_gelal_por_dia = array();	
	foreach ($regs["dados"] as $i) {		
		$array_gelal_por_dia[$i['DIA_CADASTRO']][$i['USU_ID']]['NOME'] = $i['NOME'];
		$array_gelal_por_dia[$i['DIA_CADASTRO']][$i['USU_ID']]['TOTAL'] = $i['TOTAL'];
	}	
	
	
	//dev_print($array_gelal_por_dia); 
	//dev_print($array_gelal_por_dia); 
	
	
	$sql = "
		SELECT 	
			ID,
			NOME
		FROM 
			USUARIO
		ORDER BY 			
			ID ASC			
	";	
	//dev_echo ($sql);	
	$regsUsu = db_selectRecordsRawSQL($sql);
	$idsUsu = $regsUsu['dados'];	
	
	$chart_header = "['Dia'"; 
	foreach ($idsUsu as $i) {
		$chart_header .= ", '" . $i['NOME'] . "'";
	}
	$chart_header .= "]";
	//dev_print($idsUsu); 
	
	
	foreach ($array_gelal_por_dia as $dia => $usuarioEtotal) {				
		
		$chart_table .= ",['" . $dia . "'";			
		//dev_print($cidadeEtotal);
		foreach ($idsUsu as $i) {
			
			if (array_key_exists($i['ID'], $usuarioEtotal)) {
				$chart_table .= ', '.$usuarioEtotal[$i['ID']]['TOTAL'];
			} else {
				$chart_table .= ', 0';
			}
			
		}		
		$chart_table .= "]";
	}
	
	
	//dev_echo ($chart_header);
	//dev_echo ($chart_table);
	
	
	//CRIANDO VARIAVEL TIPO TABELA PARA O SCRIPT DO CHART
	
	/*
	['Dia', 'Ribeirao', 'Brasilia', 'Sao Paulo'],
          ['2004',  1000,      400, 620 ],
          ['2005',  1170,      460, 225],
          ['2006',  660,       1120, 221],
          ['2007',  1030,      540, 558]
	*/

	
	
	?>
	
	
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          
			<?=$chart_header?>
			<?=$chart_table?>
		  
        ]);

		
		
		
        var options = {
          title: 'Número de shows cadastrados por usuário por dia'
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_showsPorUsuarioPorDia'));
        chart.draw(data, options);
      }
    </script>  
    <div id="chart_showsPorUsuarioPorDia" style="width: 1600px; height: 900px;"></div>
	
	
	<br><br><br><br><br><br>
	
	<!-- /////////////// -->
	
	
	<!-- MEDIA SHOWS DIA DE SHOWS CADASTRADOS POR USUARIO AGOSTO -->
	
	<?
	unset ($regs);
	unset ($data_chart);
	
	
	$sql = "
		SELECT USU.NOME AS NOME, COUNT( SHO.ID ) AS TOTAL
		FROM  `SHOW` AS SHO
		INNER JOIN USUARIO AS USU ON SHO.ID_USUARIO = USU.ID
		WHERE DATE_FORMAT( SHO.CADASTRO,  '%m-%Y' ) =  '08-2013'
		GROUP BY USU.ID 
	";
		
	$regs = db_selectRecordsRawSQL($sql);			
	
	$data_header = "";
	$data_number = "";
	$dia_hoje = date("j");
	foreach ($regs["dados"] as $i) {
		
		$data_header .= ", '".$i['NOME']."'";
		$data_number .= ", ".  round($i['TOTAL']/$dia_hoje, 1);
		
	}
	
	
	?>
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  
		var data = google.visualization.arrayToDataTable([
          ['Usuário'<?=$data_header?>, 'Fix0'],
          ['Shows'<?=$data_number?>, 0]
        ]);

        var options = {		  	
          title: 'Média de shows cadastrados por usuário dia em Agosto/13'		  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_usuMediaShowsMes'));
        chart.draw(data, options);
      }
    </script> 
    <div id="chart_usuMediaShowsMes" style="width: 1200px; height: 500px;"></div>
	
	<!-- ////////// -->
	
	
	
	<!-- NÚMERO DE SHOWS CADASTRADOS POR USUARIO AGOSTO -->
	
	<?
	unset ($regs);
	unset ($data_chart);
	
	
	$sql = "
		SELECT USU.NOME AS NOME, COUNT( SHO.ID ) AS TOTAL
		FROM  `SHOW` AS SHO
		INNER JOIN USUARIO AS USU ON SHO.ID_USUARIO = USU.ID
		WHERE DATE_FORMAT( SHO.CADASTRO,  '%m-%Y' ) =  '08-2013'
		GROUP BY USU.ID 
	";
		
	$regs = db_selectRecordsRawSQL($sql);			
	
	$data_header = "";
	$data_number = "";
	
	foreach ($regs["dados"] as $i) {
		
		$data_header .= ", '".$i['NOME']."'";
		$data_number .= ", ".$i['TOTAL'];
		
	}
	
	
	?>
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  
		var data = google.visualization.arrayToDataTable([
          ['Usuário'<?=$data_header?>, 'Fix0'],
          ['Shows'<?=$data_number?>, 0]
        ]);

        var options = {		  	
          title: 'Número de shows cadastrados por usuárioa Agosto/13'		  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_usuNumShowsMes'));
        chart.draw(data, options);
      }
    </script> 
    <div id="chart_usuNumShowsMes" style="width: 1200px; height: 500px;"></div>
	
	<!-- ////////// -->
	
	
	
	
	
	<!-- NÚMERO DE SHOWS CADASTRADOS POR USUARIO ALL TIME -->
	
	<?
	unset ($regs);
	unset ($data_chart);
	
	
	$sql = "
		SELECT 	
			USU.NOME AS NOME,	
			COUNT(SHO.ID) AS TOTAL
		FROM 
			`SHOW` AS SHO
		INNER JOIN
			USUARIO AS USU
		ON
			SHO.ID_USUARIO = USU.ID
		GROUP BY
			USU.ID 
	";
		
	$regs = db_selectRecordsRawSQL($sql);			
	
	$data_header = "";
	$data_number = "";
	
	foreach ($regs["dados"] as $i) {
		
		$data_header .= ", '".$i['NOME']."'";
		$data_number .= ", ".$i['TOTAL'];
		
	}
	
	
	?>
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	  
		var data = google.visualization.arrayToDataTable([
          ['Usuário'<?=$data_header?>, 'Fix0'],
          ['Shows'<?=$data_number?>, 0]
        ]);

        var options = {		  	
          title: 'Número de shows cadastrados por usuárioa all time'		  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_usuNumShowsAllTime'));
        chart.draw(data, options);
      }
    </script> 
    <div id="chart_usuNumShowsAllTime" style="width: 1200px; height: 500px;"></div>
	
	<!-- ////////// -->
	
	
	
	
	
	<!-- SHOW ATIVOS POR DIA -->
	
	<?
	
	
	
	//CONSULTANDO SHOWS POR DIA DAS TOP 20
	
	unset ($regs);
	unset ($data_chart);
	unset($array_gelal_por_dia);
	
	//CID.ID	IN " . $ids_top20_cid . "
	$sql = "
		SELECT
			DATE_FORMAT( SHO.DATA,  '%d-%m-%Y' ) AS DATA, 
			COUNT( SHO.ID ) AS TOTAL
		FROM  
			`SHOW` AS SHO		
		WHERE
			SHO.DATA >= CURRENT_DATE			
		GROUP BY 
			SHO.DATA
		ORDER BY 
			SHO.DATA ASC
	";
	//dev_echo ($sql);	
	$regs = db_selectRecordsRawSQL($sql);	
	
	/*
	['Dia', 'Ribeirao', 'Brasilia', 'Sao Paulo'],
          ['2004',  1000,      400, 620 ],
          ['2005',  1170,      460, 225],
          ['2006',  660,       1120, 221],
          ['2007',  1030,      540, 558]
	*/
	//dev_print($regs);
	$chart_table = "['Dia', 'Shows']";
	
	
	foreach ($regs["dados"] as $i) {				
		
		//dev_echo (",['" . $i['DATA'] . "', '" . $i['TOTAL'] . "']"); 
		$chart_table .= ",['" . $i['DATA'] . "', " . $i['TOTAL'] . "]";					
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
          title: 'Número de shows ativos por dia nas 4 cidades com mais shows'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_showsAtivosPorDia'));
        chart.draw(data, options);
      }
    </script>  
    <div id="chart_showsAtivosPorDia" style="width: 1600px; height: 900px;"></div>
	
	
	<br><br><br><br><br><br>
	
	<!-- /////////////// -->
	 
	
	
	
	<!-- SHOW ATIVOS POR DIA POR CIDADE -->
	
	<?
	
	//ARRAY TOP 20
	/*$array_top20_cid = array();
	$array_top20_cid[5270] = 'São Paulo';
	$array_top20_cid[3658] = 'Rio de Janeiro';
	$array_top20_cid[882] = 'Brasília';
	$array_top20_cid[756] = 'Fortaleza';
	$array_top20_cid[1630] = 'Belo Horizonte';*/
	$chart_table_header = "";
	
	
	
	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	
	//dev_print($array_top20_cid );
	
	$array_top20_cid = array_slice($array_top20_cid, 0, 4, true); 
	
	//dev_print($array_top20_cid );
	
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
	unset($array_gelal_por_dia);
	
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
	//dev_echo ($sql);	
	$regs = db_selectRecordsRawSQL($sql);	
	
	//dev_print($regs["dados"]); 
	
	//FORMATANDO RESULTADO BUSCA COM ARRAY POR DIA
	
	$array_gelal_por_dia = array();	
	foreach ($regs["dados"] as $i) {		
		$array_gelal_por_dia[$i['DATA']][$i['CIDADE_ID']]['NOME'] = $i['CIDADE'];
		$array_gelal_por_dia[$i['DATA']][$i['CIDADE_ID']]['TOTAL'] = $i['TOTAL'];
	}	
	//dev_print($array_gelal_por_dia); exit;
	
	//CRIANDO VARIAVEL TIPO TABELA PARA O SCRIPT DO CHART
	
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
          title: 'Número de shows ativos por dia'
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_showsAtivosPorDiaPorCidadeo'));
        chart.draw(data, options);
      }
    </script>  
    <div id="chart_showsAtivosPorDiaPorCidadeo" style="width: 1600px; height: 900px;"></div>
	
	
	<br><br><br><br><br><br>
	
	<!-- /////////////// -->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<!-- CIDADES LIDERES EM SHOWS ALL TIME -->
	
	<?
	
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
	
	<!-- FIM CIDADES LIDERES EM SHOWS ALL TIME -->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</div>
<div style="clear:left"></div><br>


<?
include ("includes/footer.php");
?>