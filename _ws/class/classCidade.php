<?

class cidade {
	
	public $id;
	public $nome; 
	public $frurl;
	  
	function cidade($v = 0){
				
		$reg = array();		
		
		if (is_int($v)) {			
			$reg = db_selectRecord("*", "CIDADE", "ID=".$v);						
		} elseif (is_array($v)) {
			$reg = $v;
		}
			
		$this->id               = ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );		
		$this->nome      		= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->frurl			= ( isset($reg["FRURL"]) ? ( $reg["FRURL"] !== "" ? $reg["FRURL"] : NULL ) : NULL );			
		
	}
		
	public function save() {
		
		/*
		$mysql = new mysql();	
		
		if ($this->id == 0) {
			
			$sql = "INSERT INTO ESTUDANTE(
						NOME
						,EMAIL
						,SENHA
						,DATACADASTRO
						,TIPO						
					)						
					VALUES (
						'".$this->nome."'
						,'".$this->email."'
						,'".md5($this->senha)."'
						,NOW()
						,'".$this->tipo."'						
					)";
					
					
			$mysql->query($sql);						
			
		}
		else {
			//DO UPDATE;
		}
		
		return;
		*/
	}

}

?>