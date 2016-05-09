<?

class evento {
	
	public $id;
	public $id_cidade;
	public $nome;
	public $frurl;
	public $imagem_dir;
	public $inicio;
	public $fim;
	public $seo_title;
	public $seo_description;
	public $txt1;		
	public $txt2;
	public $txt3;
	public $cidade;
	public $estado;
	public $publicar;
   
	function evento($v = 0){
				
		if ($v !== 0) {
			if (is_int($v)) {			
				
				$sql = "
					SELECT
						EVE.ID AS ID,
						EVE.ID_CIDADE AS ID_CIDADE,
						EVE.NOME AS NOME,
						EVE.FRURL AS FRURL,
						EVE.IMAGEM_DIR AS IMAGEM_DIR,
						DATE_FORMAT( EVE.INICIO, '%d/%m/%Y' ) AS INICIO,
						DATE_FORMAT( EVE.FIM, '%d/%m/%Y' ) AS FIM,
						EVE.SEO_TITLE AS SEO_TITLE,
						EVE.SEO_DESCRIPTION AS SEO_DESCRIPTION,
						EVE.TXT1 AS TXT1,
						EVE.TXT2 AS TXT2,
						EVE.TXT3 AS TXT3,
						EVE.PUBLICAR AS PUBLICAR,
						CID.NOME AS CIDADE,
						CID.UF AS ESTADO				
					FROM
						EVENTO AS EVE
					INNER JOIN
						CIDADE AS CID
					ON
						EVE.ID_CIDADE = CID.ID				
					WHERE
						EVE.ID = ".$v."
				";
				
				$reg = db_selectRecordRawSQL($sql);
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}
		
		$this->id					= ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );		
		$this->id_cidade            = ( isset($reg["ID_CIDADE"]) ? ( $reg["ID_CIDADE"] !== "" ? $reg["ID_CIDADE"] : NULL ) : NULL );
		$this->nome					= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->frurl				= ( isset($reg["FRURL"]) ? ( $reg["FRURL"] !== "" ? $reg["FRURL"] : NULL ) : NULL );
		$this->imagem_dir			= ( isset($reg["IMAGEM_DIR"]) ? ( $reg["IMAGEM_DIR"] !== "" ? $reg["IMAGEM_DIR"] : NULL ) : NULL );
		$this->inicio				= ( isset($reg["INICIO"]) ? ( $reg["INICIO"] !== "" ? $reg["INICIO"] : NULL ) : NULL );
		$this->fim					= ( isset($reg["FIM"]) ? ( $reg["FIM"] !== "" ? $reg["FIM"] : NULL ) : NULL );		
		$this->seo_title			= ( isset($reg["SEO_TITLE"]) ? ( $reg["SEO_TITLE"] !== "" ? $reg["SEO_TITLE"] : NULL ) : NULL );
		$this->seo_description		= ( isset($reg["SEO_DESCRIPTION"]) ? ( $reg["SEO_DESCRIPTION"] !== "" ? $reg["SEO_DESCRIPTION"] : NULL ) : NULL );
		$this->txt1					= ( isset($reg["TXT1"]) ? ( $reg["TXT1"] !== "" ? $reg["TXT1"] : NULL ) : NULL );
		$this->txt2					= ( isset($reg["TXT2"]) ? ( $reg["TXT2"] !== "" ? $reg["TXT2"] : NULL ) : NULL );
		$this->txt3					= ( isset($reg["TXT3"]) ? ( $reg["TXT3"] !== "" ? $reg["TXT3"] : NULL ) : NULL );
		$this->cidade				= ( isset($reg["CIDADE"]) ? ( $reg["CIDADE"] !== "" ? $reg["CIDADE"] : NULL ) : NULL );
		$this->estado				= ( isset($reg["ESTADO"]) ? ( $reg["ESTADO"] !== "" ? $reg["ESTADO"] : NULL ) : NULL );
		$this->publicar  			= ( isset($reg["PUBLICAR"]) ? ( $reg["PUBLICAR"] !== "" ? $reg["PUBLICAR"] : "1" ) : "1" );	
		
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "INSERT INTO EVENTO(
						CADASTRO
						,ID_CIDADE
						,NOME
						,FRURL
						,IMAGEM_DIR
						,INICIO
						,FIM
						,SEO_TITLE
						,SEO_DESCRIPTION
						,TXT1
						,TXT2
						,TXT3
						,PUBLICAR
					)						
					VALUES (
						NOW()	
						," . ( $this->id_cidade === NULL ? "NULL" : $this->id_cidade) . "
						," . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						," . ( $this->frurl === NULL ? "NULL" : "'".$this->frurl."'") . "
						," . ( $this->imagem_dir === NULL ? "NULL" : "'".$this->imagem_dir."'") . "
						,STR_TO_DATE('".$this->inicio."','%d/%m/%Y')					
						,STR_TO_DATE('".$this->fim."','%d/%m/%Y')
						," . ( $this->seo_title === NULL ? "NULL" : "'".$this->seo_title."'") . "
						," . ( $this->seo_description === NULL ? "NULL" : "'".$this->seo_description."'") . "
						," . ( $this->txt1 === NULL ? "NULL" : "'".$this->txt1."'") . "
						," . ( $this->txt2 === NULL ? "NULL" : "'".$this->txt2."'") . "
						," . ( $this->txt3 === NULL ? "NULL" : "'".$this->txt3."'") . "						
						,'" . $this->publicar . "'
					)";
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		else {
		
			//UPDATE;
						
			$sql = "UPDATE EVENTO SET											
						ID_CIDADE  = " . ( $this->id_cidade === NULL ? "NULL" : "'".$this->id_cidade."'") . "
						,NOME = " . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						,FRURL = " . ( $this->frurl === NULL ? "NULL" : "'".$this->frurl."'") . "
						,IMAGEM_DIR = " . ( $this->imagem_dir === NULL ? "NULL" : "'".$this->imagem_dir."'") . "
						,INICIO = STR_TO_DATE('".$this->inicio."','%d/%m/%Y')
						,FIM = STR_TO_DATE('".$this->fim."','%d/%m/%Y')
						,SEO_TITLE = " . ( $this->seo_title === NULL ? "NULL" : "'".$this->seo_title."'") . "
						,SEO_DESCRIPTION = " . ( $this->seo_description === NULL ? "NULL" : "'".$this->seo_description."'") . "
						,TXT1 = " . ( $this->txt1 === NULL ? "NULL" : "'".$this->txt1."'") . "
						,TXT2 = " . ( $this->txt2 === NULL ? "NULL" : "'".$this->txt2."'") . "
						,TXT3 = " . ( $this->txt3 === NULL ? "NULL" : "'".$this->txt3."'") . "						
						,PUBLICAR = '" . $this->publicar  . "'
												
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