<?

class show {
	
	public $id;
	public $id_usuario;
	public $id_artista;
	public $id_cidade;
	public $id_casa;
	public $id_evento;
	public $imagem;
	public $dataraw;
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
	public $bilheteria_digital;
	public $artista;
	public $cidade;
	public $estado;
	public $casa;
	public $m_evento;
	
   
	function show($v = 0){
				
		if ($v !== 0) {
			
			if (is_int($v)) {			
				
				//$reg = db_selectRecord("*", "`SHOW`", "ID=".$v);

				$sql = "
					SELECT
						SHO.ID AS ID,
						SHO.ID_USUARIO AS ID_USUARIO,
						SHO.ID_ARTISTA AS ID_ARTISTA,
						SHO.ID_CIDADE AS ID_CIDADE,
						SHO.ID_CASA AS ID_CASA,
						SHO.ID_EVENTO AS ID_EVENTO,
						SHO.IMAGEM AS IMAGEM,
						DATE_FORMAT( SHO.DATA, '%d/%m/%Y' ) AS DATA,
						DATE_FORMAT( SHO.HORA, '%H:%i' ) AS HORA,
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
						ART.NOME AS ARTISTA,
						CID.NOME AS CIDADE,
						CID.UF AS ESTADO,
						CAS.NOME AS CASA,
						EVE.NOME AS M_EVENTO					
					FROM
						`SHOW` AS SHO
					LEFT JOIN
						CIDADE AS CID
					ON
						SHO.ID_CIDADE = CID.ID
					LEFT JOIN
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
						SHO.ID = ".$v."
				";
				
				$reg = db_selectRecordRawSQL($sql);				
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}		
					
		$this->id               	= ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );
		$this->id_usuario       	= ( isset($reg["ID_USUARIO"]) ? ( $reg["ID_USUARIO"] !== "" ? $reg["ID_USUARIO"] : 0 ) : 0 );
		$this->id_artista			= ( isset($reg["ID_ARTISTA"]) ? $reg["ID_ARTISTA"] : NULL );
		$this->id_cidade            = ( isset($reg["ID_CIDADE"]) ? $reg["ID_CIDADE"] : NULL );
		$this->id_casa          	= ( isset($reg["ID_CASA"]) ? ( $reg["ID_CASA"] !== "" ? $reg["ID_CASA"] : NULL ) : NULL );
		$this->id_evento          	= ( isset($reg["ID_EVENTO"]) ? ( $reg["ID_EVENTO"] !== "" ? $reg["ID_EVENTO"] : NULL ) : NULL );
		
		$this->imagem				= ( isset($reg["IMAGEM"]) ? ( $reg["IMAGEM"] !== "" ? $reg["IMAGEM"] : NULL ) : NULL );
		$this->dataraw			    = ( isset($reg["DATARAW"]) ? $reg["DATARAW"] : NULL );
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
		$this->ingresso_link1       = ( isset($reg["INGRESSO_LINK1"]) ? ( $reg["INGRESSO_LINK1"] !== "" ? $reg["INGRESSO_LINK1"] : NULL ) : NULL );
		$this->ingresso_label1      = ( isset($reg["INGRESSO_LABEL1"]) ? ( $reg["INGRESSO_LABEL1"] !== "" ? $reg["INGRESSO_LABEL1"] : NULL ) : NULL );
		$this->ingresso_link2       = ( isset($reg["INGRESSO_LINK2"]) ? ( $reg["INGRESSO_LINK2"] !== "" ? $reg["INGRESSO_LINK2"] : NULL ) : NULL );
		$this->ingresso_label2      = ( isset($reg["INGRESSO_LABEL2"]) ? ( $reg["INGRESSO_LABEL2"] !== "" ? $reg["INGRESSO_LABEL2"] : NULL ) : NULL );
		$this->ingresso_link3       = ( isset($reg["INGRESSO_LINK3"]) ? ( $reg["INGRESSO_LINK3"] !== "" ? $reg["INGRESSO_LINK3"] : NULL ) : NULL );
		$this->ingresso_label3      = ( isset($reg["INGRESSO_LABEL3"]) ? ( $reg["INGRESSO_LABEL3"] !== "" ? $reg["INGRESSO_LABEL3"] : NULL ) : NULL );
		$this->artista			    = ( isset($reg["ARTISTA"]) ? ( $reg["ARTISTA"] !== "" ? $reg["ARTISTA"] : NULL ) : NULL );
		$this->cidade			    = ( isset($reg["CIDADE"]) ? ( $reg["CIDADE"] !== "" ? $reg["CIDADE"] : NULL ) : NULL );
		$this->estado			    = ( isset($reg["ESTADO"]) ? ( $reg["ESTADO"] !== "" ? $reg["ESTADO"] : NULL ) : NULL );
		$this->casa			    	= ( isset($reg["CASA"]) ? ( $reg["CASA"] !== "" ? $reg["CASA"] : NULL ) : NULL );
		$this->m_evento			    = ( isset($reg["M_EVENTO"]) ? ( $reg["M_EVENTO"] !== "" ? $reg["M_EVENTO"] : NULL ) : NULL );
		
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "
				INSERT INTO `SHOW`(
					ID_USUARIO
					,CADASTRO
					,ID_ARTISTA
					,ID_CIDADE
					,ID_CASA
					,ID_EVENTO
					,IMAGEM	
					,DATA	
					,HORA
					,CLASSIFICACAO
					,CLASSIFICACAO_COM_PAIS
					,LOCAL
					,ENDERECO
					,EVENTO
					,FONE
					,PRECO_MIN
					,PRECO_MAX
					,LINK
					,DETALHES
					,INGRESSO_LINK1
					,INGRESSO_LABEL1
					,INGRESSO_LINK2
					,INGRESSO_LABEL2
					,INGRESSO_LINK3
					,INGRESSO_LABEL3					
				)						
				VALUES (					
					".$this->id_usuario."
					,NOW()						
					,".$this->id_artista."
					,".$this->id_cidade."
					," . ( $this->id_casa === NULL ? "NULL" : $this->id_casa) . "
					," . ( $this->id_evento === NULL ? "NULL" : $this->id_evento) . "
					," . ( $this->imagem === NULL ? "NULL" : "'".$this->imagem."'") . "
					,STR_TO_DATE('".$this->data."','%d/%m/%Y')
					," . ( $this->hora === NULL ? "NULL" : "'".$this->hora."'") . "
					," . ( $this->classificacao === NULL ? "NULL" : $this->classificacao) . "
					," . ( $this->classificacao_com_pais === NULL ? "NULL" : $this->classificacao_com_pais) . "
					," . ( $this->local === NULL ? "NULL" : "'".$this->local."'") . "					
					," . ( $this->endereco === NULL ? "NULL" : "'".$this->endereco."'") . "
					," . ( $this->evento === NULL ? "NULL" : "'".$this->evento."'") . "
					," . ( $this->fone === NULL ? "NULL" : "'".$this->fone."'") . "
					," . ( $this->preco_min === NULL ? "NULL" : $this->preco_min ) . "
					," . ( $this->preco_max === NULL ? "NULL" : $this->preco_max ) . "					
					," . ( $this->link === NULL ? "NULL" : "'".$this->link."'") . "
					," . ( $this->detalhes === NULL ? "NULL" : "'".$this->detalhes."'") . "
					," . ( $this->ingresso_link1 === NULL ? "NULL" : "'".$this->ingresso_link1."'") . "
					," . ( $this->ingresso_label1 === NULL ? "NULL" : "'".$this->ingresso_label1."'") . "
					," . ( $this->ingresso_link2 === NULL ? "NULL" : "'".$this->ingresso_link2."'") . "
					," . ( $this->ingresso_label2 === NULL ? "NULL" : "'".$this->ingresso_label2."'") . "
					," . ( $this->ingresso_link3 === NULL ? "NULL" : "'".$this->ingresso_link3."'") . "
					," . ( $this->ingresso_label3 === NULL ? "NULL" : "'".$this->ingresso_label3."'") . "					
				)
			";
			//dev_echo($sql); exit;
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		else {
		
			//UPDATE;
			
			$sql = "
				UPDATE `SHOW` SET
					ID_CIDADE = ".$this->id_cidade."
					,ID_CASA = 	" . ( $this->id_casa === NULL ? "NULL" : $this->id_casa) . "
					,ID_EVENTO = 	" . ( $this->id_evento === NULL ? "NULL" : $this->id_evento) . "
					,IMAGEM = " . ( $this->imagem === NULL ? "NULL" : "'".$this->imagem."'") . "
					,DATA = STR_TO_DATE('".$this->data."','%d/%m/%Y')	
					,HORA = " . ( $this->hora === NULL ? "NULL" : "'".$this->hora."'") . "
					,CLASSIFICACAO = " . ( $this->classificacao === NULL ? "NULL" : $this->classificacao) . "
					,CLASSIFICACAO_COM_PAIS = " . ( $this->classificacao_com_pais === NULL ? "NULL" : $this->classificacao_com_pais) . "
					,HORA = " . ( $this->hora === NULL ? "NULL" : "'".$this->hora."'") . "
					,LOCAL = " . ( $this->local === NULL ? "NULL" : "'".$this->local."'") . "					
					,ENDERECO = " . ( $this->endereco === NULL ? "NULL" : "'".$this->endereco."'") . "
					,EVENTO = " . ( $this->evento === NULL ? "NULL" : "'".$this->evento."'") . "
					,FONE = " . ( $this->fone === NULL ? "NULL" : "'".$this->fone."'") . "
					,PRECO_MIN = " . ( $this->preco_min === NULL ? "NULL" : $this->preco_min ) . "
					,PRECO_MAX = " . ( $this->preco_max === NULL ? "NULL" : $this->preco_max ) . "					
					,LINK = " . ( $this->link === NULL ? "NULL" : "'".$this->link."'") . "
					,DETALHES = " . ( $this->detalhes === NULL ? "NULL" : "'".$this->detalhes."'") . "
					,INGRESSO_LINK1 = " . ( $this->ingresso_link1 === NULL ? "NULL" : "'".$this->ingresso_link1."'") . "
					,INGRESSO_LABEL1	= " . ( $this->ingresso_label1 === NULL ? "NULL" : "'".$this->ingresso_label1."'") . "
					,INGRESSO_LINK2 = " . ( $this->ingresso_link2 === NULL ? "NULL" : "'".$this->ingresso_link2."'") . "
					,INGRESSO_LABEL2	= " . ( $this->ingresso_label2 === NULL ? "NULL" : "'".$this->ingresso_label2."'") . "
					,INGRESSO_LINK3 = " . ( $this->ingresso_link3 === NULL ? "NULL" : "'".$this->ingresso_link3."'") . "
					,INGRESSO_LABEL3	= " . ( $this->ingresso_label3 === NULL ? "NULL" : "'".$this->ingresso_label3."'") . "					
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
	}
	

}

?>