<?

class artista {
	
	public $id;	
	public $nome;
	public $frurl;
	public $foto;
	public $categoria;
	public $site;	
	
	public $wikipedia;
	public $facebook_page;
	public $twitter;
	public $myspace;
	public $youtube;
	public $fanzone;
	public $origem;
	public $nacionalidade;
	public $txt_resumo;
	public $txt;
	
	public $flag_ultima_atualizacao;
   
	function artista($v = ""){
				
		if ($v !== "") {					
			
			//$reg = db_selectRecord("*", "ARTISTA", "FRURL='".$v."'");

			$sql = "
					SELECT 
						ART.ID AS ID,
						ART.NOME AS NOME,						
						ART.FRURL AS FRURL,
						ART.FOTO AS FOTO,
						ART.CATEGORIA AS CATEGORIA,
						ART.SITE AS SITE,
						ART.WIKIPEDIA AS WIKIPEDIA,
						ART.FACEBOOK_PAGE AS FACEBOOK_PAGE,
						ART.TWITTER AS TWITTER,
						ART.MYSPACE AS MYSPACE,
						ART.YOUTUBE AS YOUTUBE,
						ART.FANZONE AS FANZONE,
						ART.ORIGEM AS ORIGEM,
						PAI.NOME AS NACIONALIDADE,
						ART.TXT_RESUMO AS TXT_RESUMO,
						ART.TXT AS TXT
						
					FROM 
						ARTISTA AS ART 					
					LEFT JOIN
						PAIS AS PAI
					ON
						ART.NACIONALIDADE = PAI.ID		
					WHERE 
						ART.FRURL = '".$v."'
				";
				
				$reg = db_selectRecordRawSQL($sql);	
		}		
		
		$this->id               = ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );		
		$this->nome      		= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->frurl			= ( isset($reg["FRURL"]) ? ( $reg["FRURL"] !== "" ? $reg["FRURL"] : NULL ) : NULL );
		$this->foto             = ( isset($reg["FOTO"]) ? ( $reg["FOTO"] !== "" ? $reg["FOTO"] : NULL ) : NULL );			
		$this->categoria        = ( isset($reg["CATEGORIA"]) ? ( $reg["CATEGORIA"] !== "" ? $reg["CATEGORIA"] : 1 ) : 1 );
		$this->site			    = ( isset($reg["SITE"]) ? ( $reg["SITE"] !== "" ? $reg["SITE"] : NULL ) : NULL );

		$this->wikipedia		= ( isset($reg["WIKIPEDIA"]) ? ( $reg["WIKIPEDIA"] !== "" ? $reg["WIKIPEDIA"] : NULL ) : NULL );
		$this->facebook_page	= ( isset($reg["FACEBOOK_PAGE"]) ? ( $reg["FACEBOOK_PAGE"] !== "" ? $reg["FACEBOOK_PAGE"] : NULL ) : NULL );
		$this->twitter			= ( isset($reg["TWITTER"]) ? ( $reg["TWITTER"] !== "" ? $reg["TWITTER"] : NULL ) : NULL );
		$this->myspace			= ( isset($reg["MYSPACE"]) ? ( $reg["MYSPACE"] !== "" ? $reg["MYSPACE"] : NULL ) : NULL );
		$this->youtube			= ( isset($reg["YOUTUBE"]) ? ( $reg["YOUTUBE"] !== "" ? $reg["YOUTUBE"] : NULL ) : NULL );
		$this->fanzone			= ( isset($reg["FANZONE"]) ? ( $reg["FANZONE"] !== "" ? $reg["FANZONE"] : NULL ) : NULL );
		$this->origem 			= ( isset($reg["ORIGEM"]) ? ( $reg["ORIGEM"] !== "" ? $reg["ORIGEM"] : NULL ) : NULL );
		$this->nacionalidade 	= ( isset($reg["NACIONALIDADE"]) ? ( $reg["NACIONALIDADE"] !== "" ? $reg["NACIONALIDADE"] : NULL ) : NULL );
		$this->txt_resumo		= ( isset($reg["TXT_RESUMO"]) ? ( $reg["TXT_RESUMO"] !== "" ? $reg["TXT_RESUMO"] : NULL ) : NULL );
		$this->txt				= ( isset($reg["TXT"]) ? ( $reg["TXT"] !== "" ? $reg["TXT"] : NULL ) : NULL );
			
		
		$this->flag_ultima_atualizacao = false;
	}

}

?>