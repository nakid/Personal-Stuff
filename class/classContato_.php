<?

class contato {
	
	public $id;
	public $datahora;
	public $nome;
	public $email;
	public $txt;	
	public $respondido;
	public $respondido_por;		
   
	function contato ($v = 0) {
				
		if ($v !== 0) {
			if (is_int($v)) {			
				$reg = db_selectRecord("*", "CONTATO", "ID=".$v);			
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}	
							
		$this->id               	= ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );
		$this->datahora				= ( isset($reg["DATAHORA"]) ? ( $reg["DATAHORA"] !== "" ? $reg["DATAHORA"] : NULL ) : NULL );
		$this->nome					= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
	    $this->email				= ( isset($reg["EMAIL"]) ? ( $reg["EMAIL"] !== "" ? $reg["EMAIL"] : NULL ) : NULL );
		$this->txt					= ( isset($reg["TXT"]) ? ( $reg["TXT"] !== "" ? $reg["TXT"] : NULL ) : NULL );
		$this->respondido			= ( isset($reg["RESPONDIDO"]) ? ( $reg["RESPONDIDO"] !== "" ? $reg["RESPONDIDO"] : NULL ) : NULL );
		$this->respondido_por		= ( isset($reg["RESPONDIDO_POR"]) ? ( $reg["RESPONDIDO_POR"] !== "" ? $reg["RESPONDIDO_POR"] : NULL ) : NULL );
		
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
					,RESPONDIDO
					,RESPONDIDO_POR					
				)						
				VALUES (
					NOW()			
					,'" . ( $this->nome === NULL ? "" : $this->nome) ."'
					,'" . ( $this->email === NULL ? "" : $this->email) . "'
					,'" . ( $this->txt === NULL ? "" : $this->txt) . "'
					, 0
					, 'NULL'								
				)
			";
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		
	}	

}

?>