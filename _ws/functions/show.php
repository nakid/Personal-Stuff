<?


/*
function sho_retornarTodosPorArtista ($id_artista) {
	
	$sql = "
	SELECT
	CID.NOME AS CIDADE,
	DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS DATA
	DATE_FORMAT( SHO.HORA, '%H:%i' ) AS HORA
	LOCAL
		
		
	FROM
	`SHOW` AS SHO
	LEFT JOIN
	CIDADE AS CID
	ON
	SHO.ID_CIDADE = CID.ID
	WHERE
	ID_ARTISTA = ".$id_artista."
	ORDER BY
	DATA, HORA
	";
	
	$ret = db_selectRecordsRawSQL($sql);
	
	return $ret;	
}
/*
function atl_verificaExisteEmail ($email) {
	
	$select = "*";
	$from = "ATLETA";
	$where = "EMAIL = '" . trim($email) . "'";	
	
	$tot = db_countRecords($from, $where);
	
	return $tot;	
}

function art_retornaIdPorEmail ($email) {
	
	$select = "ID";
	$from = "ATLETA";
	$where = "EMAIL = '" . trim($email) . "'";	
	
	$reg = db_selectRecord($select, $from, $where);	
	
	if ($reg)
		return (int)$reg['ID'];	
	
	return false;	
}

*/

?>