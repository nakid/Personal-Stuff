<?

function db_selectRecord($fields, $table, $where) {		
	
	$sql = "SELECT ".$fields." FROM ".$table." WHERE ".$where;	
	
	$mysql = new mysql();	
	$result = $mysql->select($sql);	
	
	if ($result['total'] == 1)
		return $result['dados'][0];
		
	return false;
}

function db_selectRecordRawSQL($sql) {

	$mysql = new mysql();
	$result = $mysql->select($sql);

	if ($result['total'] == 1)
		return $result['dados'][0];

	return false;
}

function db_selectRecords($fields, $table, $where = false, $order = false) {		
	
	$sql = "SELECT ".$fields." FROM ".$table;
	if ($where) $sql .= " WHERE ".$where;
	if ($order) $sql .= " Order by ".$order;
	
	
	$mysql = new mysql();	
	$result = $mysql->select($sql);	
	
	return $result;
}

function db_selectRecordsRawSQL($sql) {

	$mysql = new mysql();
	$result = $mysql->select($sql);

	return $result;
}

function db_countRecords($table, $where = false) {		
	$ret = false;
	$mysql = new mysql();
	$sql = "SELECT COUNT(ID) AS TOTAL FROM ".$table;	
	
	if ($where) $sql .= " WHERE ".$where;
	
	$result = $mysql->query($sql);
	if ($result) {
		$total = mysql_num_rows($result);
		if ($total == 1) {
			$reg = mysql_fetch_assoc($result);
			$ret = $reg['TOTAL'];
		}
		mysql_free_result($result);
	}	
	return $ret;
}


?>