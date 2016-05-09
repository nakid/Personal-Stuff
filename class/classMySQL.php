<?

class mysql {

	private $host; 
	private $user; 
	private $pass; 
	private $db; 
	private $sql;    

	function setConfig(){
		$this->host = DB_HOST;
		$this->user = DB_USER;
		$this->pass = DB_PASS;
		$this->db   = DB_NAME;
	}

	function connect(&$con){      
		$this->setConfig();	  
		$con = mysql_connect($this->host,$this->user,$this->pass) or die("DB - Erro de conexao - : ".$this->erro(mysql_error()));
		mysql_query("SET NAMES 'utf8'");
		mysql_query('SET character_set_connection=utf8');
		mysql_query('SET character_set_client=utf8');
		mysql_query('SET character_set_results=utf8');
		if ($this->selectDB($con))      
			return $con;
		else
			return false;		
	}

	function selectDB($con){      
		$sel = mysql_select_db($this->db, $con) or die($this->erro("DB - Erro de selecao - : ".mysql_error())); 	  
		if($sel){
			return true;
		}else{
			return false;
		}
	}

	function close(&$con){      
		mysql_close($con);
	}   


	function query($qst, $retId = false){
		$con = "";
		$this->connect($con);      
		try {
			$result = mysql_query($qst) or die ("DB - Erro de execucao - : ".$this->erro(mysql_error()));
			if ($retId) { 
				$id = mysql_insert_id();  
				$result = $id; 
			}
		} catch (Exception $e) {
			echo "excecao: ",  $e->getMessage(), "\n";
			$result = false;
		}   	   
		$this->close($con); 
		return $result;
	}	

	function select($qst, $assoc = true) {		
		
		$con = "";
		$this->connect($con);      
		try {
			$result = mysql_query($qst) or die ("DB - Erro de execucao - : ".$this->erro(mysql_error()));			
		} catch (Exception $e) {
			echo "excecao: ",  $e->getMessage(), "\n";
			$result = false;			
		}
		$this->close($con); 
		if ($result) {			
			
			$dataArray = array();
			if ($assoc) {
				while ($row = mysql_fetch_assoc($result)) {
					array_push($dataArray, $row);
				}	
			} else {
				while ($row = mysql_fetch_array($result)) {
					array_push($dataArray, $row);
				}				
			}		
			
			$resultArray = array(
				"dados" => $dataArray, 
				"total" => mysql_num_rows($result)
			);		
			mysql_free_result($result);	
			return $resultArray;
				
		}		
		return $result;		
	}

	function set($prop,$value){      
		$this->$prop = $value;
	}

	function get($prop){      
		return $this->$prop;
	}

	function erro($erro){      
		echo $erro;
	}
}

?>