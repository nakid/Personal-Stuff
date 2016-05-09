<?

class show {
	
	public $id;
	public $id_artista;
	public $id_cidade;
	public $id_casa;
	public $id_evento;
	
	public $imagem;

	public $dataraw;
	public $datalink;
	public $data;	
	public $hora;
	public $local;	
	
	public $endereco;
	public $evento;
	public $fone;
	public $preco_min;
	public $preco_max;
	public $classificacao;
	public $classificacao_com_pais;		
	
	public $link;
	public $detalhes;
	public $ingresso_link1;
	public $ingresso_label1;
	public $ingresso_link2;
	public $ingresso_label2;
	public $ingresso_link3;
	public $ingresso_label3;
	public $cidade;
	public $cidade_frurl;
	public $estado;
	public $estado_completo;
	public $artista;
	public $artista_frurl;
	public $artista_foto;
	public $artista_txt_resumo;	
	public $artista_flag_agenda;
	
	public $casa;
	public $casa_endereco;
	public $casa_numero;
	public $casa_bairro;
	public $casa_referencia;
	public $casa_lat;
	public $casa_lon;
	public $casa_fone1;
	public $casa_fone2;
	public $casa_site;
	public $casa_email;
	public $casa_foto;
	
	public $m_evento;
	public $evento_frurl;
	public $evento_publicar;
	
	
	
	
	
		
   
	function show($vcid = "", $vart = "", $vdia = ""){
				
		if ($vcid !== "" && $vart !== "" && $vdia !== "") {
			
			$sql = "
					SELECT 
						SHO.ID AS ID, 
						SHO.ID_ARTISTA AS ID_ARTISTA, 
						SHO.ID_CIDADE AS ID_CIDADE, 
						SHO.ID_CASA AS ID_CASA,
						SHO.ID_EVENTO AS ID_EVENTO,
						
						SHO.IMAGEM AS IMAGEM,

						SHO.DATA AS DATARAW, 
						DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) AS DATALINK,
						DATE_FORMAT( SHO.DATA, '%e/%c/%Y' ) AS DATA, 						
						DATE_FORMAT( SHO.HORA, '%k:%i' ) AS HORA, 
						
						SHO.CLASSIFICACAO AS CLASSIFICACAO,
						SHO.CLASSIFICACAO_COM_PAIS AS CLASSIFICACAO_COM_PAIS,
						SHO.LOCAL AS LOCAL,						
						SHO.ENDERECO AS ENDERECO,
						SHO.EVENTO AS EVENTO,
						SHO.FONE AS FONE,
						SHO.PRECO_MIN AS PRECO_MIN,
						SHO.PRECO_MAX AS PRECO_MAX,	
						
						SHO.LINK AS LINK, 
						SHO.DETALHES AS DETALHES, 
						SHO.INGRESSO_LINK1 AS INGRESSO_LINK1,
						SHO.INGRESSO_LABEL1 AS INGRESSO_LABEL1,
						SHO.INGRESSO_LINK2 AS INGRESSO_LINK2,
						SHO.INGRESSO_LABEL2 AS INGRESSO_LABEL2,
						SHO.INGRESSO_LINK3 AS INGRESSO_LINK3,
						SHO.INGRESSO_LABEL3 AS INGRESSO_LABEL3, 						
						CID.NOME AS CIDADE, 
						CID.FRURL AS CIDADE_FRURL, 
						CID.UF AS ESTADO,
						CID.UFCOMPLETA AS ESTADO_COMPLETO,  
						ART.NOME AS ARTISTA, 
						ART.FRURL AS ARTISTA_FRURL,
						ART.FOTO AS ARTISTA_FOTO,
						ART.TXT_RESUMO AS ARTISTA_TXT_RESUMO,
						ART.ID_USUARIO AS ARTISTA_FLAG_AGENDA,
						
						CAS.NOME AS CASA,
						CAS.ENDERECO AS CASA_ENDERECO,
						CAS.NUMERO AS CASA_NUMERO,
						CAS.BAIRRO AS CASA_BAIRRO,
						CAS.REFERENCIA AS CASA_REFERENCIA,
						CAS.LAT AS CASA_LAT,
						CAS.LON AS CASA_LON,
						CAS.FONE1 AS CASA_FONE1,
						CAS.FONE2 AS CASA_FONE2,
						CAS.SITE AS CASA_SITE,						
						CAS.EMAIL AS CASA_EMAIL,
						CAS.FOTO AS CASA_FOTO,
						
						EVE.NOME AS M_EVENTO,
						EVE.FRURL AS EVENTO_FRURL,
						EVE.PUBLICAR AS EVENTO_PUBLICAR
						
					FROM 
						`SHOW` AS SHO
					INNER JOIN 
						CIDADE AS CID 
					ON 
						SHO.ID_CIDADE = CID.ID
					INNER JOIN 
						ARTISTA AS ART 
					ON 
						SHO.ID_ARTISTA = ART.ID
					LEFT JOIN
						CASA AS CAS
					ON
						SHO.ID_CASA = CAS.ID
					LEFT JOIN
						EVENTO AS EVE
					ON
						SHO.ID_EVENTO = EVE.ID				
					WHERE 
						ART.FRURL = '".$vart."'
						AND CID.frurl = '".$vcid."'
						AND DATE_FORMAT( SHO.DATA, '%d-%m-%Y' ) = '".$vdia."'
					
				";
				
				$reg = db_selectRecordRawSQL($sql);	
		}
		
			
					
		$this->id               	= ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );
		$this->id_artista			= ( isset($reg["ID_ARTISTA"]) ? $reg["ID_ARTISTA"] : NULL );
		$this->id_cidade            = ( isset($reg["ID_CIDADE"]) ? $reg["ID_CIDADE"] : NULL );			
		$this->id_casa            	= ( isset($reg["ID_CASA"]) ? $reg["ID_CASA"] : NULL );
		$this->id_evento            = ( isset($reg["ID_EVENTO"]) ? $reg["ID_EVENTO"] : NULL );		
		
		$this->imagem			    = ( isset($reg["IMAGEM"]) ? ( $reg["IMAGEM"] !== "" ? $reg["IMAGEM"] : NULL ) : NULL );

		$this->dataraw			    = ( isset($reg["DATARAW"]) ? $reg["DATARAW"] : NULL );
		$this->datalink			   	= ( isset($reg["DATALINK"]) ? $reg["DATALINK"] : NULL );
		$this->data			    	= ( isset($reg["DATA"]) ? $reg["DATA"] : NULL );
		$this->hora			    	= ( isset($reg["HORA"]) ? ( $reg["HORA"] !== "" ? $reg["HORA"] : NULL ) : NULL );
		$this->classificacao		= ( isset($reg["CLASSIFICACAO"]) ? ( $reg["CLASSIFICACAO"] !== "" ? $reg["CLASSIFICACAO"] : NULL ) : NULL );
		$this->classificacao_com_pais = ( isset($reg["CLASSIFICACAO_COM_PAIS"]) ? ( $reg["CLASSIFICACAO_COM_PAIS"] !== "" ? $reg["CLASSIFICACAO_COM_PAIS"] : NULL ) : NULL );
		$this->local           		= ( isset($reg["LOCAL"]) ? ( $reg["LOCAL"] !== "" ? $reg["LOCAL"] : NULL ) : NULL );
		
		$this->endereco				= ( isset($reg["ENDERECO"]) ? ( $reg["ENDERECO"] !== "" ? $reg["ENDERECO"] : NULL ) : NULL );
		$this->evento				= ( isset($reg["EVENTO"]) ? ( $reg["EVENTO"] !== "" ? $reg["EVENTO"] : NULL ) : NULL );
		$this->fone					= ( isset($reg["FONE"]) ? ( $reg["FONE"] !== "" ? $reg["FONE"] : NULL ) : NULL );
		$this->preco_min			= ( isset($reg["PRECO_MIN"]) ? ( $reg["PRECO_MIN"] !== "" ? $reg["PRECO_MIN"] : NULL ) : NULL );
		$this->preco_max			= ( isset($reg["PRECO_MAX"]) ? ( $reg["PRECO_MAX"] !== "" ? $reg["PRECO_MAX"] : NULL ) : NULL );
		$this->link           		= ( isset($reg["LINK"]) ? ( $reg["LINK"] !== "" ? $reg["LINK"] : NULL ) : NULL );
		$this->detalhes           	= ( isset($reg["DETALHES"]) ? ( $reg["DETALHES"] !== "" ? $reg["DETALHES"] : NULL ) : NULL );
		     
		
		$this->ingresso_link1 		= ( isset($reg["INGRESSO_LINK1"]) ? ( $reg["INGRESSO_LINK1"] !== "" ? $reg["INGRESSO_LINK1"] : NULL ) : NULL );
		$this->ingresso_label1		= ( isset($reg["INGRESSO_LABEL1"]) ? ( $reg["INGRESSO_LABEL1"] !== "" ? $reg["INGRESSO_LABEL1"] : NULL ) : NULL );
		$this->ingresso_link2		= ( isset($reg["INGRESSO_LINK2"]) ? ( $reg["INGRESSO_LINK2"] !== "" ? $reg["INGRESSO_LINK2"] : NULL ) : NULL );
		$this->ingresso_label2		= ( isset($reg["INGRESSO_LABEL2"]) ? ( $reg["INGRESSO_LABEL2"] !== "" ? $reg["INGRESSO_LABEL2"] : NULL ) : NULL );
		$this->ingresso_link3		= ( isset($reg["INGRESSO_LINK3"]) ? ( $reg["INGRESSO_LINK2"] !== "" ? $reg["INGRESSO_LINK2"] : NULL ) : NULL );
		$this->ingresso_label3		= ( isset($reg["INGRESSO_LABEL2"]) ? ( $reg["INGRESSO_LABEL2"] !== "" ? $reg["INGRESSO_LABEL2"] : NULL ) : NULL );
		
		
		$this->cidade			    = ( isset($reg["CIDADE"]) ? ( $reg["CIDADE"] !== "" ? $reg["CIDADE"] : NULL ) : NULL );
		$this->cidade_frurl			= ( isset($reg["CIDADE_FRURL"]) ? ( $reg["CIDADE_FRURL"] !== "" ? $reg["CIDADE_FRURL"] : NULL ) : NULL );
		$this->estado			    = ( isset($reg["ESTADO"]) ? ( $reg["ESTADO"] !== "" ? $reg["ESTADO"] : NULL ) : NULL );
		$this->estado_completo	    = ( isset($reg["ESTADO_COMPLETO"]) ? ( $reg["ESTADO_COMPLETO"] !== "" ? $reg["ESTADO_COMPLETO"] : NULL ) : NULL );
		$this->artista			    = ( isset($reg["ARTISTA"]) ? ( $reg["ARTISTA"] !== "" ? $reg["ARTISTA"] : NULL ) : NULL );
		$this->artista_frurl		= ( isset($reg["ARTISTA_FRURL"]) ? ( $reg["ARTISTA_FRURL"] !== "" ? $reg["ARTISTA_FRURL"] : NULL ) : NULL );
		$this->artista_foto			= ( isset($reg["ARTISTA_FOTO"]) ? ( $reg["ARTISTA_FOTO"] !== "" ? $reg["ARTISTA_FOTO"] : NULL ) : NULL );
		$this->artista_txt_resumo	= ( isset($reg["ARTISTA_TXT_RESUMO"]) ? ( $reg["ARTISTA_TXT_RESUMO"] !== "" ? $reg["ARTISTA_TXT_RESUMO"] : NULL ) : NULL );
		$this->artista_flag_agenda	= ( isset($reg["ARTISTA_FLAG_AGENDA"]) ? ( $reg["ARTISTA_FLAG_AGENDA"] !== "" ? $reg["ARTISTA_FLAG_AGENDA"] : NULL ) : NULL );
		
		
		$this->casa					= ( isset($reg["CASA"]) ? ( $reg["CASA"] !== "" ? $reg["CASA"] : NULL ) : NULL );
		$this->casa_endereco		= ( isset($reg["CASA_ENDERECO"]) ? ( $reg["CASA_ENDERECO"] !== "" ? $reg["CASA_ENDERECO"] : NULL ) : NULL );
		$this->casa_numero			= ( isset($reg["CASA_NUMERO"]) ? ( $reg["CASA_NUMERO"] !== "" ? $reg["CASA_NUMERO"] : NULL ) : NULL );
		$this->casa_bairro			= ( isset($reg["CASA_BAIRRO"]) ? ( $reg["CASA_BAIRRO"] !== "" ? $reg["CASA_BAIRRO"] : NULL ) : NULL );
		$this->casa_referencia		= ( isset($reg["CASA_REFERENCIA"]) ? ( $reg["CASA_REFERENCIA"] !== "" ? $reg["CASA_REFERENCIA"] : NULL ) : NULL );
		$this->casa_lat				= ( isset($reg["CASA_LAT"]) ? ( $reg["CASA_LAT"] !== "" ? $reg["CASA_LAT"] : NULL ) : NULL );
		$this->casa_lon				= ( isset($reg["CASA_LON"]) ? ( $reg["CASA_LON"] !== "" ? $reg["CASA_LON"] : NULL ) : NULL );
		$this->casa_fone1			= ( isset($reg["CASA_FONE1"]) ? ( $reg["CASA_FONE1"] !== "" ? $reg["CASA_FONE1"] : NULL ) : NULL );
		$this->casa_fone2			= ( isset($reg["CASA_FONE2"]) ? ( $reg["CASA_FONE2"] !== "" ? $reg["CASA_FONE2"] : NULL ) : NULL );
		$this->casa_site			= ( isset($reg["CASA_SITE"]) ? ( $reg["CASA_SITE"] !== "" ? $reg["CASA_SITE"] : NULL ) : NULL );
		$this->casa_email			= ( isset($reg["CASA_EMAIL"]) ? ( $reg["CASA_EMAIL"] !== "" ? $reg["CASA_EMAIL"] : NULL ) : NULL );
		$this->casa_foto			= ( isset($reg["CASA_FOTO"]) ? ( $reg["CASA_FOTO"] !== "" ? $reg["CASA_FOTO"] : NULL ) : NULL );
		
		$this->m_evento				= ( isset($reg["M_EVENTO"]) ? ( $reg["M_EVENTO"] !== "" ? $reg["M_EVENTO"] : NULL ) : NULL );
		$this->evento_frurl			= ( isset($reg["EVENTO_FRURL"]) ? ( $reg["EVENTO_FRURL"] !== "" ? $reg["EVENTO_FRURL"] : NULL ) : NULL );
		$this->evento_publicar		= ( isset($reg["EVENTO_PUBLICAR"]) ? ( $reg["EVENTO_PUBLICAR"] !== "" ? $reg["EVENTO_PUBLICAR"] : "0" ) : "0" );
	}
		
	/*public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "
				INSERT INTO `SHOW`(
					CADASTRO
					,ID_ARTISTA
					,ID_CIDADE	
					,DATA	
					,HORA
					,LOCAL
					,LINK
					,DETALHES
					,INGRESSO_FACIL
					,BILHETERIA_DIGITAL		
				)						
				VALUES (
					NOW()						
					,".$this->id_artista."
					,".$this->id_cidade."
					,STR_TO_DATE('".$this->data."','%d/%m/%Y')
					," . ( $this->hora === NULL ? "NULL" : "'".$this->hora."'") . "
					," . ( $this->local === NULL ? "NULL" : "'".$this->local."'") . "
					," . ( $this->link === NULL ? "NULL" : "'".$this->link."'") . "
					," . ( $this->detalhes === NULL ? "NULL" : "'".$this->detalhes."'") . "
					," . ( $this->ingresso_facil === NULL ? "NULL" : "'".$this->ingresso_facil."'") . "
					," . ( $this->bilheteria_digital === NULL ? "NULL" : "'".$this->bilheteria_digital."'") . "										
				)
			";
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		else {
		
			//UPDATE;
			
			$sql = "
				UPDATE `SHOW` SET
					ID_CIDADE = ".$this->id_cidade."	
					,DATA = STR_TO_DATE('".$this->data."','%d/%m/%Y')	
					,HORA = " . ( $this->hora === NULL ? "NULL" : "'".$this->hora."'") . "
					,LOCAL = " . ( $this->local === NULL ? "NULL" : "'".$this->local."'") . "
					,LINK = " . ( $this->link === NULL ? "NULL" : "'".$this->link."'") . "
					,DETALHES = " . ( $this->detalhes === NULL ? "NULL" : "'".$this->detalhes."'") . "
					,INGRESSO_FACIL = " . ( $this->ingresso_facil === NULL ? "NULL" : "'".$this->ingresso_facil."'") . "
					,BILHETERIA_DIGITAL	= " . ( $this->bilheteria_digital === NULL ? "NULL" : "'".$this->bilheteria_digital."'") . "	
				WHERE
					ID = ".$this->id . "
			";								
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;			
			return false;
			
		}		
		return false;	
		
	}
	
	public function delete() {
		
		$mysql = new mysql();
			
		$sql = "DELETE FROM `SHOW` WHERE ID = ".$this->id;
				
		$q = $mysql->query($sql);
				
		return $q;		
	}*/
	

}

?>