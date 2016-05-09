<?

function art_retornarTodos($atualizado_por_alguém = true) {

	if ($atualizado_por_alguém)
		$where = "ID_USUARIO IS NOT NULL";
	else 
		$where = false;
	
	$regs = db_selectRecords("*", "ARTISTA", $where, "FRURL");
	return $regs;	
}


function art_retornarTotalPorLetra() {
	
	$sql = "
		SELECT 
			UPPER( SUBSTRING( FRURL, 1, 1 ) ) AS LETRA, 
			COUNT( ID ) AS TOTAL
		FROM ARTISTA
			GROUP BY LETRA
		";
	

	$regs = array();
	$regs_aux = db_selectRecordsRawSQL ($sql);	
	
	foreach ($regs_aux["dados"] as $i) $regs[$i['LETRA']] = $i['TOTAL'];
				
	return $regs;
	
	
}





?>