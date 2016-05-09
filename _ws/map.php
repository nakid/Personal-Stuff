<?
include ("includes/includes.inc.php");
//include ("includes/header.php");
//include ("includes/topo.php");

$map = $_GET['map'];


	$url = 'http://www.showsem.com.br/';
	$j = 0;
	
	echo '&lt;?xml version="1.0" encoding="UTF-8"?&gt;<br>';
	echo '&lt;urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"&gt;<br>';
	
	if ($map == 'art') {	
		
		$sql = "
			SELECT 
				ART.FRURL AS FRURL, 
				COUNT( SHO.ID ) AS TOTAL
			FROM 
				ARTISTA AS ART
			LEFT JOIN  `SHOW` AS SHO ON ART.ID = SHO.ID_ARTISTA
				
			GROUP BY ART.ID
				ORDER BY TOTAL DESC	";
		
		$regs = db_selectRecordsRawSQL($sql);			
		
		
		
		foreach ($regs["dados"] as $i) {
			$j++;	
			echo '&lt;url&gt;'."<br>";
			echo '&lt;loc&gt;'.$url.'artista/'.$i['FRURL'].'&lt;/loc&gt;'."<br>";		
			echo '&lt;priority&gt;0.5&lt;/priority&gt;'."<br>";
			echo '&lt;/url&gt;'."<br>";		
		}
		
	
	}
	
	
	if ($map == 'cid') {
		//CID: 0 1 5 7 10		
		
		/*$sql = "
		SELECT 
			CID.FRURL AS FRURL, 			
			COUNT( SHO.ID ) AS TOTAL,
			CID.PRIORIDADE AS PRIORIDADE
		FROM
			CIDADE AS CID 		
		LEFT JOIN 
			`SHOW` AS SHO
		ON 
			CID.ID = SHO.ID_CIDADE		
		GROUP BY 
			CID.ID
		ORDER BY 
			TOTAL DESC
		";*/
		
		$sql = "
			SELECT 
				FRURL, 						
				PRIORIDADE
			FROM
				CIDADE		
			ORDER BY 
				PRIORIDADE ASC
		";
		
		$regs = db_selectRecordsRawSQL($sql);			
		
		
		
		
		foreach ($regs["dados"] as $i) {		
			$j++;
			
			if ($i['PRIORIDADE'] == '0')
				$prioridade = '1.0';
			elseif ($i['PRIORIDADE'] == '1')
				$prioridade = '0.9';
			elseif ($i['PRIORIDADE'] == '5')
				$prioridade = '0.7';
			elseif ($i['PRIORIDADE'] == '7')
				$prioridade = '0.5';
			else
				$prioridade = '0.3';
			
			echo '&lt;url&gt;'."<br>";
			echo '&lt;loc&gt;'.$url.'shows-'.($i['FRURL']=='rio-de-janeiro'?'no':'em').'-'.$i['FRURL'].'&lt;/loc&gt;'."<br>";		
			echo '&lt;priority&gt;'.$prioridade.'&lt;/priority&gt;'."<br>";
			echo '&lt;/url&gt;'."<br>";		
		}
		
	
	}
	
	
	if ($map == 'sho') {
		
		//CID: 0, 1, 5, 7, 10
		
		//	  11, 10, 6, 3, 1  
		//ART: 5, 4, 3, 2, 1
		
		
			
		$sql = "
		SELECT 
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS DATALINK,			
			ART.FRURL AS ARTISTA,
			ART.CATEGORIA AS CATEGORIA,
			CID.FRURL AS CIDADE,
			CID.PRIORIDADE AS PRIORIDADE
		FROM 
			`SHOW` AS SHO
		INNER JOIN 
			CIDADE AS CID 
		ON 
			SHO.ID_CIDADE = CID.ID
		INNER JOIN 
			ARTISTA AS ART 
		ON 
			SHO.ID_ARTISTA = ART.ID
		WHERE
			SHO.DATA >= CURRENT_DATE
		ORDER BY
			PRIORIDADE
		
		
		";
		
		$regs = db_selectRecordsRawSQL($sql);					
		
		foreach ($regs["dados"] as $i) {		
			
			$j++;
			
			$pri_aux = 11 - (int)$i['PRIORIDADE'];
			$cat_aux = (int)$i['CATEGORIA'];
			
			$pontuacao = $pri_aux * $cat_aux;
			
			if ($pontuacao >= 24)
				$prioridade = '1.0';
			elseif ($i['PRIORIDADE'] >= 9)
				$prioridade = '0.9';		
			else
				$prioridade = '0.7';
			
			
			echo '&lt;url&gt;'."<br>";
			echo '&lt;loc&gt;'.$url.'show-'.($i['CIDADE']=='rio-de-janeiro'?'no':'em').'-'.$i['CIDADE'].'/'.$i['ARTISTA'].'/'.$i['DATALINK'].'&lt;/loc&gt;'."<br>";		
			echo '&lt;priority&gt;'.$prioridade.'&lt;/priority&gt;'."<br>";
			echo '&lt;/url&gt;'."<br>";		
		}
		
	
	}
	echo '&lt;/urlset&gt;';