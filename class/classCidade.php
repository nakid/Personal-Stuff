<?

class cidade {
	
	public $id;
	public $nome;	
	public $frurl;
	public $uf;
	public $ufcompleta;
	
	  
	function cidade($v = "") {

		if ($v !== "") {
			$reg = db_selectRecord("*", "CIDADE", "FRURL='".$v."'");			
		}	
		
		$this->id               = ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );
		$this->nome      		= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->frurl			= ( isset($reg["FRURL"]) ? ( $reg["FRURL"] !== "" ? $reg["FRURL"] : NULL ) : NULL );
		$this->uf				= ( isset($reg["UF"]) ? ( $reg["UF"] !== "" ? $reg["UF"] : NULL ) : NULL );
		$this->ufcompleta		= ( isset($reg["UFCOMPLETA"]) ? ( $reg["UFCOMPLETA"] !== "" ? $reg["UFCOMPLETA"] : NULL ) : NULL );
		
	}
}

?>