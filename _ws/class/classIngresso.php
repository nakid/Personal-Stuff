<?

class ingresso {
	
	public $id;	
	public $id_usuario;
	public $nome;
	public $url_layout;
	public $url;
	public $atualizar_dia;	
	public $flag_ultima_atualizacao;
	
   
	function ingresso($v = 0){
		
		if ($v !== 0) {
			if (is_int($v)) {			
				$reg = db_selectRecord("*", "INGRESSO", "ID=".$v);			
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}
		
		$this->id               = ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );	
		$this->id_usuario       = ( isset($reg["ID_USUARIO"]) ? ( $reg["ID_USUARIO"] !== "" ? $reg["ID_USUARIO"] : NULL ) : NULL );		
		$this->nome      		= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->url_layout		= ( isset($reg["URL_LAYOUT"]) ? ( $reg["URL_LAYOUT"] !== "" ? $reg["URL_LAYOUT"] : NULL ) : NULL );
		$this->url				= ( isset($reg["URL"]) ? ( $reg["URL"] !== "" ? $reg["URL"] : NULL ) : NULL );
		$this->atualizar_dia	= ( isset($reg["ATUALIZAR_DIA"]) ? ( $reg["ATUALIZAR_DIA"] !== "" ? $reg["ATUALIZAR_DIA"] : NULL ) : NULL );
		
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "INSERT INTO INGRESSO(						
						ID_USUARIO
						,NOME
						,URL_LAYOUT
						,URL
						,ATUALIZAR_DIA
						,ULTIMA_ATUALIZACAO						
					)						
					VALUES (
						" . ( $this->id_usuario === NULL ? "NULL" : $this->id_usuario) . "
						," . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						," . ( $this->url_layout === NULL ? "NULL" : "'".$this->url_layout."'") . "
						," . ( $this->url === NULL ? "NULL" : "'".$this->url."'") . "
						," . ( $this->atualizar_dia === NULL ? "NULL" : $this->atualizar_dia) . "
						,NOW()
					)";
			
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		else {
		
			//UPDATE;
						
			$sql = "UPDATE INGRESSO SET						
						ID_USUARIO = " .( $this->id_usuario === NULL ? "NULL" : $this->id_usuario) . "
						,NOME = " . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						,URL_LAYOUT = " . ( $this->url_layout === NULL ? "NULL" : "'".$this->url_layout."'") . "
						,URL = " . ( $this->url === NULL ? "NULL" : "'".$this->url."'") . "
						,ATUALIZAR_DIA = " . ( $this->atualizar_dia === NULL ? "NULL" : $this->atualizar_dia) . "
						" . ($this->flag_ultima_atualizacao === true ? ",ULTIMA_ATUALIZACAO = NOW() " : "") . "
					WHERE
						ID = ".$this->id ;					
			
			
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;			
			return false;			
			
		}		
		return false;	
		
	}
	

}

?>