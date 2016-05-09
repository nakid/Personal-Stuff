<?

class casa {
	
	public $id;
	public $id_cidade;
	public $nome;
	public $endereco;
	public $numero;
	public $bairro;
	public $referencia;
	public $lat;		
	public $lon;
	public $fone1;
	public $fone2;
	public $site;
	public $email;
	public $foto;
	public $atualizar;
	public $atualizar_dia;
	public $bom_inicio_mes;	
	public $flag_ultima_atualizacao;
	public $flag_ultima_atualizacao_dados;	
	public $ativa;	
   
	function casa($v = 0){
				
		if ($v !== 0) {
			if (is_int($v)) {			
				$reg = db_selectRecord("*", "CASA", "ID=".$v);			
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}
		
		$this->id					= ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );		
		$this->id_cidade            = ( isset($reg["ID_CIDADE"]) ? ( $reg["ID_CIDADE"] !== "" ? $reg["ID_CIDADE"] : NULL ) : NULL );
		$this->nome					= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->endereco             = ( isset($reg["ENDERECO"]) ? ( $reg["ENDERECO"] !== "" ? $reg["ENDERECO"] : NULL ) : NULL );
		$this->numero               = ( isset($reg["NUMERO"]) ? ( $reg["NUMERO"] !== "" ? $reg["NUMERO"] : NULL ) : NULL );
		$this->bairro               = ( isset($reg["BAIRRO"]) ? ( $reg["BAIRRO"] !== "" ? $reg["BAIRRO"] : NULL ) : NULL );
		$this->referencia           = ( isset($reg["REFERENCIA"]) ? ( $reg["REFERENCIA"] !== "" ? $reg["REFERENCIA"] : NULL ) : NULL );
		$this->lat               	= ( isset($reg["LAT"]) ? ( $reg["LAT"] !== "" ? $reg["LAT"] : NULL ) : NULL );
		$this->lon               	= ( isset($reg["LON"]) ? ( $reg["LON"] !== "" ? $reg["LON"] : NULL ) : NULL );
		$this->fone1              	= ( isset($reg["FONE1"]) ? ( $reg["FONE1"] !== "" ? $reg["FONE1"] : NULL ) : NULL );
		$this->fone2                = ( isset($reg["FONE2"]) ? ( $reg["FONE2"] !== "" ? $reg["FONE2"] : NULL ) : NULL );
		$this->site               	= ( isset($reg["SITE"]) ? ( $reg["SITE"] !== "" ? $reg["SITE"] : NULL ) : NULL );
		$this->email                = ( isset($reg["EMAIL"]) ? ( $reg["EMAIL"] !== "" ? $reg["EMAIL"] : NULL ) : NULL );
		$this->foto               	= ( isset($reg["FOTO"]) ? ( $reg["FOTO"] !== "" ? $reg["FOTO"] : "_nophoto" ) : "_nophoto" );		
		$this->atualizar			= ( isset($reg["ATUALIZAR"]) ? ( $reg["ATUALIZAR"] !== "" ? $reg["ATUALIZAR"] : "1" ) : "1" );
		$this->atualizar_dia		= ( isset($reg["ATUALIZAR_DIA"]) ? ( $reg["ATUALIZAR_DIA"] !== "" ? $reg["ATUALIZAR_DIA"] : NULL ) : NULL );
		$this->bom_inicio_mes		= ( isset($reg["BOM_INICIO_MES"]) ? ( $reg["BOM_INICIO_MES"] !== "" ? $reg["BOM_INICIO_MES"] : "0" ) : "0" );
		$this->ativa  				= ( isset($reg["ATIVA"]) ? ( $reg["ATIVA"] !== "" ? $reg["ATIVA"] : "1" ) : "1" );	
		$this->flag_ultima_atualizacao = false;
		$this->flag_ultima_atualizacao_dados = false;
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "INSERT INTO CASA(
						
						ID_CIDADE
						,NOME
						,ENDERECO
						,NUMERO
						,BAIRRO
						,REFERENCIA
						,LAT
						,LON
						,FONE1
						,FONE2
						,SITE
						,EMAIL
						,FOTO
						,ATUALIZAR
						,ATUALIZAR_DIA
						,BOM_INICIO_MES
						,ATIVA
						,ULTIMA_ATUALIZACAO
						,ULTIMA_ATUALIZACAO_DADOS
					)						
					VALUES (						
						
						" . ( $this->id_cidade === NULL ? "NULL" : $this->id_cidade) . "
						," . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						," . ( $this->endereco === NULL ? "NULL" : "'".$this->endereco."'") . "
						," . ( $this->numero === NULL ? "NULL" : "'".$this->numero."'") . "
						," . ( $this->bairro === NULL ? "NULL" : "'".$this->bairro."'") . "						
						," . ( $this->referencia === NULL ? "NULL" : "'".$this->referencia."'") . "
						," . ( $this->lat === NULL ? "NULL" : "'".$this->lat."'") . "
						," . ( $this->lon === NULL ? "NULL" : "'".$this->lon."'") . "
						," . ( $this->fone1 === NULL ? "NULL" : "'".$this->fone1."'") . "
						," . ( $this->fone2 === NULL ? "NULL" : "'".$this->fone2."'") . "
						," . ( $this->site === NULL ? "NULL" : "'".$this->site."'") . "
						," . ( $this->email === NULL ? "NULL" : "'".$this->email."'") . "
						,'" . $this->foto . "'
						,'" . $this->atualizar . "'
						," . ( $this->atualizar_dia === NULL ? "NULL" : $this->atualizar_dia) . "
						,'" . $this->bom_inicio_mes . "'
						,'" . $this->ativa . "'
						,NOW()
						,NOW()
					)";
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		else {
		
			//UPDATE;
						
			$sql = "UPDATE CASA SET											
						ID_CIDADE  = " . ( $this->id_cidade === NULL ? "NULL" : "'".$this->id_cidade."'") . "
						,NOME = " . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						,ENDERECO = " . ( $this->endereco === NULL ? "NULL" : "'".$this->endereco."'") . "
						,NUMERO = " . ( $this->numero === NULL ? "NULL" : "'".$this->numero."'") . "
						,BAIRRO = " . ( $this->bairro === NULL ? "NULL" : "'".$this->bairro."'") . "
						,REFERENCIA = " . ( $this->referencia === NULL ? "NULL" : "'".$this->referencia."'") . "
						,LAT = " . ( $this->lat === NULL ? "NULL" : "'".$this->lat."'") . "
						,LON = " . ( $this->lon === NULL ? "NULL" : "'".$this->lon."'") . "
						,FONE1 = " . ( $this->fone1 === NULL ? "NULL" : "'".$this->fone1."'") . "
						,FONE2 = " . ( $this->fone2 === NULL ? "NULL" : "'".$this->fone2."'") . "
						,SITE = " . ( $this->site === NULL ? "NULL" : "'".$this->site."'") . "
						,EMAIL = " . ( $this->email === NULL ? "NULL" : "'".$this->email."'") . "
						,FOTO = '" . $this->foto  . "'
						,ATUALIZAR = '" . $this->atualizar . "'
						,ATUALIZAR_DIA = " . ( $this->atualizar_dia === NULL ? "NULL" : $this->atualizar_dia) . "
						,BOM_INICIO_MES = '" . $this->bom_inicio_mes . "'
						,ATIVA = '" . $this->ativa  . "'
						" . ($this->flag_ultima_atualizacao === true ? ",ULTIMA_ATUALIZACAO = NOW() " : "") . "
						" . ($this->flag_ultima_atualizacao_dados === true ? ",ULTIMA_ATUALIZACAO_DADOS = NOW() " : "") . "						
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