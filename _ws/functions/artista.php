<?



/*function atl_login ($email, $senha) {
	
	$select = "*";
	$from = "ATLETA";
	$where = "EMAIL = '" . trim($email) . "' && SENHA = '" . md5($senha) . "'";
	$whereCount = "EMAIL = '" . trim($email) . "'";
	
	$tot = db_countRecords($from, $whereCount);
	
	if (!$tot) {
		
		return 'fail-mail';
	}
	$reg = db_selectRecord($select, $from, $where);	
	
	if (!$reg)
		return 'fail-pass';
	
	
	return $reg;	
}

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