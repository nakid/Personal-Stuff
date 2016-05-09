<?

//SESP
function sho_retornarPorData ($dia_base, $generos) {
	
	//echo "--> " . $dia_base . " - " . $num_dias; return;
	/*if ($num_dias == "todos") $num_dias = 365;
	
	
	$dia_limite_full = new DateTime($dia_base);
	$dia_limite_full->modify('+'.$num_dias.' day');
	$dia_limite = $dia_limite_full->format('Y-m-d');*/
	

	//echo "--> " . $dia_base . " - " . $dia_limite; return;
	
	
	$sql = "
		SELECT
			ART.ID AS ART_ID,
			ART.NOME AS ART_NOME,
			ART.FRURL AS ART_FRURL,
			ART.FOTO AS ART_FOTO,
			ART.TXT_RESUMO AS ART_RESUMO,
			GEN.NOME AS GEN_NOME,
			SHO.DATA AS SHO_DATARAW,
			SHO.LOCAL AS SHO_LOCAL,
			SHO.DETALHES AS SHO_DETALHES,
			SHO.IMAGEM AS SHO_IMAGEM,
			DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
			DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
			DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA		
		FROM
			CIDADE AS CID			
		INNER JOIN
			`SHOW` AS SHO
		ON
			CID.ID = SHO.ID_CIDADE
		INNER JOIN
			ARTISTA AS ART
		ON
			SHO.ID_ARTISTA = ART.ID	
		INNER JOIN
			GENERO AS GEN
		ON
			ART.ID_GENERO = GEN.ID			
		WHERE
			CID.ID = 5270	
			AND SHO.DATA = '" . $dia_base . "'
			" . ($generos == 'all' ? '' : 'AND ART.ID_GENERO IN (' . $generos . ')') . " 
		ORDER BY
			SHO_DATARAW,
			ART.CATEGORIA DESC
	";
	
	//echo $sql; 
	
	$regs = db_selectRecordsRawSQL($sql);
	
	return $regs;
	
	//return false;
}

function sho_retornarPorIntervaloDeData ($dia_base, $num_dias, $generos) {
	
	//echo "--> " . $dia_base . " - " . $num_dias; return;
	if ($num_dias == "todos") $num_dias = 365;
	
	
	$dia_limite_full = new DateTime($dia_base);
	$dia_limite_full->modify('+'.$num_dias.' day');
	$dia_limite = $dia_limite_full->format('Y-m-d');
	

	//echo "--> " . $dia_base . " - " . $dia_limite; return;
	
	
	$sql = "
		SELECT
			ART.ID AS ART_ID,
			ART.NOME AS ART_NOME,
			ART.FRURL AS ART_FRURL,
			ART.FOTO AS ART_FOTO,
			ART.TXT_RESUMO AS ART_RESUMO,
			GEN.NOME AS GEN_NOME,
			SHO.DATA AS SHO_DATARAW,
			SHO.LOCAL AS SHO_LOCAL,
			SHO.DETALHES AS SHO_DETALHES,
			SHO.IMAGEM AS SHO_IMAGEM,
			DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
			DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
			DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA		
		FROM
			CIDADE AS CID			
		INNER JOIN
			`SHOW` AS SHO
		ON
			CID.ID = SHO.ID_CIDADE
		INNER JOIN
			ARTISTA AS ART
		ON
			SHO.ID_ARTISTA = ART.ID	
		INNER JOIN
			GENERO AS GEN
		ON
			ART.ID_GENERO = GEN.ID			
		WHERE
			CID.ID = 5270	
			AND SHO.DATA >= '" . $dia_base . "'
			AND SHO.DATA <= '" . $dia_limite . "'
			" . ($generos == 'all' ? '' : 'AND ART.ID_GENERO IN (' . $generos . ')') . " 
		ORDER BY
			SHO_DATARAW,
			ART.CATEGORIA DESC
	";
	
	//echo $sql; 
	
	$regs = db_selectRecordsRawSQL($sql);
	
	return $regs;
	
	//return false;
}

// FIM SESP

function sho_retornarPorCidade ($frcid) {
	
	$sql = "
		SELECT
			ART.NOME AS ART_NOME,
			ART.FRURL AS ART_FRURL,
			ART.FOTO AS ART_FOTO,
			ART.TXT_RESUMO AS ART_RESUMO,
			SHO.DATA AS SHO_DATARAW,
			SHO.LOCAL AS SHO_LOCAL,
			DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
			DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
			DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA		
		FROM
			CIDADE AS CID			
		INNER JOIN
			`SHOW` AS SHO
		ON
			CID.ID = SHO.ID_CIDADE
		INNER JOIN
			ARTISTA AS ART
		ON
			SHO.ID_ARTISTA = ART.ID			
		WHERE
			CID.FRURL = '".$frcid."'	
			AND SHO.DATA >= CURRENT_DATE 		
		ORDER BY
			SHO_DATARAW,
			ART.CATEGORIA DESC
	";
	
	$regs = db_selectRecordsRawSQL($sql);
	
	return $regs;	
}

function sho_retornarPorCidadeAdvanced ($id_cidade, $dia_base = false, $amanha = false, $fixar_dia = false, $limit = false) {
	
	//APENAS NAO FUNCIONA COM *FIXAR DIA e *AMANHA
	
	if(!$dia_base || $dia_base == "hoje") $data = "CURRENT_DATE"; else $data = "'".$dia_base."'";
	
	$sql = "
		SELECT
			ART.ID AS ART_ID,
			ART.NOME AS ART_NOME,
			ART.FRURL AS ART_FRURL,
			ART.FOTO AS ART_FOTO,
			ART.TXT_RESUMO AS ART_RESUMO,
			SHO.DATA AS SHO_DATARAW,
			SHO.LOCAL AS SHO_LOCAL,
			DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
			DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
			DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA		
		FROM
			CIDADE AS CID			
		INNER JOIN
			`SHOW` AS SHO
		ON
			CID.ID = SHO.ID_CIDADE
		INNER JOIN
			ARTISTA AS ART
		ON
			SHO.ID_ARTISTA = ART.ID			
		WHERE
			CID.ID = '".$id_cidade."'	
			AND SHO.DATA " .($fixar_dia?"=":">".($amanha?'':'=') ) . " " . $data . " 		
		ORDER BY
			SHO_DATARAW,
			ART.CATEGORIA DESC
		" . ( $limit ? "LIMIT " . $limit : "" ) . "	
	";
	
	$regs = db_selectRecordsRawSQL($sql);
	
	return $regs;	
}

function sho_retornarPorArtista ($id_artista) {

	$sql = "
	SELECT			
		SHO.DATA AS SHO_DATARAW,
		DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
		DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
		DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
		DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA,
		CID.NOME AS CID_NOME,
		CID.FRURL AS CID_FRURL,
		CID.UF AS EST_NOME,
		CID.UFCOMPLETA AS EST_NOMECOMPLETO
	FROM
		ARTISTA AS ART		
	LEFT JOIN
		`SHOW` AS SHO
	ON
		ART.ID = SHO.ID_ARTISTA	
	LEFT JOIN
		CIDADE AS CID
	ON
		SHO.ID_CIDADE = CID.ID 	
	WHERE
		ART.ID = '".$id_artista."'	
		AND SHO.DATA >= CURRENT_DATE 		
	ORDER BY
		SHO_DATARAW
	";

	$regs = db_selectRecordsRawSQL($sql);

	return $regs;
}


function sho_retornarPorEvento ($id_evento) {

	$sql = "
		SELECT
			ART.NOME AS ART_NOME,
			ART.FRURL AS ART_FRURL,
			ART.FOTO AS ART_FOTO,
			SHO.DATA AS SHO_DATARAW,
			SHO.LOCAL AS SHO_LOCAL,
			DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
			DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
			DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA		
		FROM
			CIDADE AS CID			
		INNER JOIN
			`SHOW` AS SHO
		ON
			CID.ID = SHO.ID_CIDADE
		INNER JOIN
			ARTISTA AS ART
		ON
			SHO.ID_ARTISTA = ART.ID	
		INNER JOIN
			EVENTO AS EVE
		ON
			SHO.ID_EVENTO = EVE.ID						
		WHERE
			EVE.ID = ".$id_evento."	
			AND SHO.DATA >= CURRENT_DATE 		
		ORDER BY
			SHO_DATARAW,
			ART.CATEGORIA DESC
	";

	$regs = db_selectRecordsRawSQL($sql);

	return $regs;
}

function sho_retornarInternacionais() {

	$sql = "
		SELECT
			ART.NOME AS ART_NOME,
			ART.FRURL AS ART_FRURL,
			PAI.NOME AS ART_NACIONALIDADE,
			CID.NOME AS CID_NOME,
			CID.UF AS CID_UF,
			CID.FRURL AS CID_FRURL,			
			ART.FOTO AS ART_FOTO,
			PAI.NOME AS ART_NACIONALIDADE,
			SHO.DATA AS SHO_DATARAW,
			SHO.LOCAL AS SHO_LOCAL,
			DATE_FORMAT( SHO.HORA, '%k:%i' ) AS SHO_HORA,
			DATE_FORMAT( SHO.DATA, '%e/%c' ) AS SHO_DATA,
			DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS SHO_DATA_LINK,
			DATE_FORMAT( SHO.DATA, '%w' ) AS SHO_DIA_SEMANA		
		FROM
			`SHOW` AS SHO
		INNER JOIN
			CIDADE AS CID			

		ON
			CID.ID = SHO.ID_CIDADE
		INNER JOIN
			ARTISTA AS ART
		ON
			SHO.ID_ARTISTA = ART.ID
		LEFT JOIN
			PAIS AS PAI
		ON
			ART.NACIONALIDADE = PAI.ID
		WHERE
			ART.ORIGEM <> 1	
			AND SHO.DATA >= CURRENT_DATE 		
		ORDER BY
			SHO_DATARAW,
			ART.CATEGORIA DESC
	";

	$regs = db_selectRecordsRawSQL($sql);

	return $regs;
}



?>