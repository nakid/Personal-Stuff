<?

/*
 * 
 * 
 * 
 * 
 * 
 *


INSERT INTO `SHOW` ( CADASTRO, ID_ARTISTA, ID_CIDADE, DATA, HORA, LOCAL , LINK, DETALHES, INGRESSO_FACIL, BILHETERIA_DIGITAL ) VALUES (
NOW( ) , 1, 4970, STR_TO_DATE('29/09/2013','%d/%m/%Y'), '23:30', 'Prainha', 'linkShow', 'Detalhes', 'if', 'bd'
)


 * */



class atleta {
	
	public $id;
	public $id_cidade;
	public $id_atleta; // quando o usuário foi cadastrado por um terceiro;
	public $status;
	public $data_cadastro;
	public $nome; 
	public $nick;
	public $frurl;
	public $email;
	public $senha;
	public $cod_recuperar_senha;	
   
	function atleta($v = 0){
				
		//$reg = array();		
		
		if (is_int($v)) {			
			$reg = db_selectRecord("*", "ATLETA", "ID=".$v);			
			
		} elseif (is_array($v)) {
			$reg = $v;
		}		
				
		$this->id               = ( isset($reg["ID"]) ? $reg["ID"] : NULL );
		$this->id_cidade		= ( isset($reg["ID_CIDADE"]) ? $reg["ID_CIDADE"] : NULL );
		$this->id_atleta		= ( isset($reg["ID_ATLETA"]) ? $reg["ID_ATLETA"] : NULL );
		$this->status           = ( isset($reg["STATUS"]) ? $reg["STATUS"] : ATLETA_STATUS_DEFAULT );			
		$this->data_cadastro    = ( isset($reg["DATA_CADASTRO"]) ? $reg["DATA_CADASTRO"] : NULL );	
		$this->nome             = ( isset($reg["NOME"]) ? $reg["NOME"] : NULL );
		$this->nick             = ( isset($reg["NICK"]) ? $reg["NICK"] : NULL );
		$this->frurl            = ( isset($reg["FRURL"]) ? $reg["FRURL"] : NULL );
		$this->email            = ( isset($reg["EMAIL"]) ? $reg["EMAIL"] : NULL );
		$this->senha            = ( isset($reg["SENHA"]) ? $reg["SENHA"] : NULL );	
		$this->cod_recuperar_senha = ( isset($reg["COD_RECUPERAR_SENHA"]) ? $reg["COD_RECUPERAR_SENHA"] : NULL );
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
			
			//INSERT
			
			$sql = "INSERT INTO ATLETA(
						ID_CIDADE
						,ID_ATLETA
						,STATUS	
						,DATA_CADASTRO	
						,NOME
						,NICK	
						,FRURL	
						,EMAIL	
						,SENHA
						,COD_RECUPERAR_SENHA		
					)						
					VALUES (						
						".$this->id_cidade."
						,".($this->id_atleta === NULL ? "NULL" : $this->id_atleta) ."
						,".$this->status."
						,NOW()
						,".($this->nome === NULL ? "NULL" : "'".$this->nome."'") ."
						,'".$this->nick."'
						,'".$this->frurl."'
						,'".$this->email."'						
						,'".md5($this->senha)."'
						,NULL
					)";
					
			$q = $mysql->query($sql, true);			
			
			if ($q) return $q;
			return false;	
			
		}
		else {
			
			//UPDATE;
			
			$sql = "UPDATE ATLETA SET
						ID_CIDADE = ".$this->id_cidade."
						,ID_ATLETA = ".($this->id_atleta === NULL ? "NULL" : $this->id_atleta) ."
						,STATUS	= ".$this->status."
						,DATA_CADASTRO = '".$this->data_cadastro."'
						,NOME = ".($this->nome === NULL ? "NULL" : "'".$this->nome."'") ."
						,NICK = '".$this->nick."'	
						,FRURL = '".$this->frurl."'
						,EMAIL = '".$this->email."'	
						,SENHA = '".$this->senha."'
						,COD_RECUPERAR_SENHA = 	".($this->cod_recuperar_senha === NULL ? "NULL" : "'".$this->cod_recuperar_senha."'") ."	
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