<?

class evento {
	
	public $id;
	public $nome;	
	public $frurl;
	public $imagem_dir;
	public $inicioraw;
	public $inicio;
	public $fimraw;
	public $fim;
	public $seo_title;
	public $seo_description;
	public $txt1;
	public $txt2;
	public $txt3;
	public $cidade;
	public $cidade_uf;
	public $cidade_frurl;
		  
	function evento($v = "") {

		if ($v !== "") {
			
			$sql = "
				SELECT 
					EVE.ID AS ID,					
					EVE.NOME AS NOME,
					EVE.FRURL AS FRURL,
					EVE.IMAGEM_DIR AS IMAGEM_DIR,
					EVE.INICIO AS INICIORAW,
					DATE_FORMAT( EVE.INICIO, '%d/%m/%Y' ) AS INICIO,
					EVE.FIM AS FIMRAW,
					DATE_FORMAT( EVE.FIM, '%d/%m/%Y' ) AS FIM,
					EVE.SEO_TITLE AS SEO_TITLE,
					EVE.SEO_DESCRIPTION AS SEO_DESCRIPTION,
					EVE.TXT1 AS TXT1,
					EVE.TXT2 AS TXT2,
					EVE.TXT3 AS TXT3,
					CID.NOME AS CIDADE,
					CID.UF AS CIDADE_UF,
					CID.FRURL AS CIDADE_FRURL
				FROM 
					EVENTO AS EVE
				INNER JOIN 
					CIDADE AS CID 
				ON 
					EVE.ID_CIDADE = CID.ID
				WHERE 
					EVE.FRURL = '".$v."'
					AND EVE.PUBLICAR = 1
			";
			
			$reg = db_selectRecordRawSQL($sql);			
		}	
		
		$this->id              		= ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );
		$this->nome              	= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->frurl              	= ( isset($reg["FRURL"]) ? ( $reg["FRURL"] !== "" ? $reg["FRURL"] : NULL ) : NULL );
		$this->imagem_dir           = ( isset($reg["IMAGEM_DIR"]) ? ( $reg["IMAGEM_DIR"] !== "" ? $reg["IMAGEM_DIR"] : NULL ) : NULL );
		$this->inicioraw           	= ( isset($reg["INICIORAW"]) ? ( $reg["INICIORAW"] !== "" ? $reg["INICIORAW"] : NULL ) : NULL );
		$this->inicio           	= ( isset($reg["INICIO"]) ? ( $reg["INICIO"] !== "" ? $reg["INICIO"] : NULL ) : NULL );
		$this->fimraw              	= ( isset($reg["FIMRAW"]) ? ( $reg["FIMRAW"] !== "" ? $reg["FIMRAW"] : NULL ) : NULL );
		$this->fim              	= ( isset($reg["FIM"]) ? ( $reg["FIM"] !== "" ? $reg["FIM"] : NULL ) : NULL );
		$this->seo_title            = ( isset($reg["SEO_TITLE"]) ? ( $reg["SEO_TITLE"] !== "" ? $reg["SEO_TITLE"] : NULL ) : NULL );
		$this->seo_description		= ( isset($reg["SEO_DESCRIPTION"]) ? ( $reg["SEO_DESCRIPTION"] !== "" ? $reg["SEO_DESCRIPTION"] : NULL ) : NULL );
		$this->txt1              	= ( isset($reg["TXT1"]) ? ( $reg["TXT1"] !== "" ? $reg["TXT1"] : NULL ) : NULL );
		$this->txt2              	= ( isset($reg["TXT2"]) ? ( $reg["TXT2"] !== "" ? $reg["TXT2"] : NULL ) : NULL );
		$this->txt3              	= ( isset($reg["TXT3"]) ? ( $reg["TXT3"] !== "" ? $reg["TXT3"] : NULL ) : NULL );
		$this->cidade              	= ( isset($reg["CIDADE"]) ? ( $reg["CIDADE"] !== "" ? $reg["CIDADE"] : NULL ) : NULL );
		$this->cidade_uf            = ( isset($reg["CIDADE_UF"]) ? ( $reg["CIDADE_UF"] !== "" ? $reg["CIDADE_UF"] : NULL ) : NULL );
		$this->cidade_frurl         = ( isset($reg["CIDADE_FRURL"]) ? ( $reg["CIDADE_FRURL"] !== "" ? $reg["CIDADE_FRURL"] : NULL ) : NULL );
		
	}
}

?>