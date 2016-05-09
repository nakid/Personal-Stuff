<?

class contato {	
	
	public $nome;
	public $email;
	public $txt;
	public $url;	
	
   
	function contato ($v = 0) {
				
		if ($v !== 0) {
			if (is_int($v)) {			
				$reg = db_selectRecord("*", "CONTATO", "ID=".$v);			
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}	
			
		$this->nome					= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
	    $this->email				= ( isset($reg["EMAIL"]) ? ( $reg["EMAIL"] !== "" ? $reg["EMAIL"] : NULL ) : NULL );
		$this->txt					= ( isset($reg["TXT"]) ? ( $reg["TXT"] !== "" ? $reg["TXT"] : NULL ) : NULL );
		$this->url					= ( isset($reg["URL"]) ? ( $reg["URL"] !== "" ? $reg["URL"] : NULL ) : NULL );
		
		
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "
				INSERT INTO CONTATO(
					DATAHORA
					,NOME
					,EMAIL	
					,TXT
					,URL		
					
				)						
				VALUES (
					NOW()			
					,'" . ( $this->nome === NULL ? "" : $this->nome) ."'
					,'" . ( $this->email === NULL ? "" : $this->email) . "'
					,'" . ( $this->txt === NULL ? "" : $this->txt) . "'
					,'" . ( $this->url === NULL ? "" : $this->url) . "'					
				)
			";
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		
	}	

}

?>