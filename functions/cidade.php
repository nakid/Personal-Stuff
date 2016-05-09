<?

/*function cid_verificaExiste ($frurl) {
	
	
	$table = "CIDADE";
	$where = "FRURL = '".$frurl."'";
	
	$tot = db_countRecords($table, $where = false);
	
	if ($tot) return true;
	return false;
}


function cid_retornar ($frurl) {


	$fields = "CID.NOME AS CID_NOME, CID.UFCOMPLETA AS EST_NOME";
	$table = "CIDADE";	
	$where = "FRURL = '".$frurl."'";

	$ret = db_selectRecord($fields, $table, $where);
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