<?

class artista {
	
	public $id;
	public $id_usuario;
	public $nome;
	public $frurl;
	public $foto;
	public $categoria;
	public $site;
	public $agenda;		
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
	public $atualizar_dia;
	public $flag_ultima_atualizacao;
	public $publicar_perfil;	
   
	function artista($v = 0){
				
		if ($v !== 0) {
			if (is_int($v)) {			
				$reg = db_selectRecord("*", "ARTISTA", "ID=".$v);			
				
			} elseif (is_array($v)) {
				$reg = $v;
			}		
		}
		
		$this->id               = ( isset($reg["ID"]) ? ( $reg["ID"] !== "" ? $reg["ID"] : NULL ) : NULL );
		$this->id_usuario       = ( isset($reg["ID_USUARIO"]) ? ( $reg["ID_USUARIO"] !== "" ? $reg["ID_USUARIO"] : NULL ) : NULL );
		$this->nome      		= ( isset($reg["NOME"]) ? ( $reg["NOME"] !== "" ? $reg["NOME"] : NULL ) : NULL );
		$this->frurl			= ( isset($reg["FRURL"]) ? ( $reg["FRURL"] !== "" ? $reg["FRURL"] : NULL ) : NULL );
		$this->foto             = ( isset($reg["FOTO"]) ? ( $reg["FOTO"] !== "" ? $reg["FOTO"] : "_nophoto" ) : "_nophoto" );			
		$this->categoria        = ( isset($reg["CATEGORIA"]) ? ( $reg["CATEGORIA"] !== "" ? $reg["CATEGORIA"] : 1 ) : 1 );
		$this->site			    = ( isset($reg["SITE"]) ? ( $reg["SITE"] !== "" ? $reg["SITE"] : NULL ) : NULL );
		$this->agenda           = ( isset($reg["AGENDA"]) ? ( $reg["AGENDA"] !== "" ? $reg["AGENDA"] : NULL ) : NULL );					
		$this->wikipedia		= ( isset($reg["WIKIPEDIA"]) ? ( $reg["WIKIPEDIA"] !== "" ? $reg["WIKIPEDIA"] : NULL ) : NULL );
		$this->facebook_page	= ( isset($reg["FACEBOOK_PAGE"]) ? ( $reg["FACEBOOK_PAGE"] !== "" ? $reg["FACEBOOK_PAGE"] : NULL ) : NULL );
		$this->twitter			= ( isset($reg["TWITTER"]) ? ( $reg["TWITTER"] !== "" ? $reg["TWITTER"] : NULL ) : NULL );
		$this->myspace			= ( isset($reg["MYSPACE"]) ? ( $reg["MYSPACE"] !== "" ? $reg["MYSPACE"] : NULL ) : NULL );
		$this->youtube			= ( isset($reg["YOUTUBE"]) ? ( $reg["YOUTUBE"] !== "" ? $reg["YOUTUBE"] : NULL ) : NULL );
		$this->fanzone			= ( isset($reg["FANZONE"]) ? ( $reg["FANZONE"] !== "" ? $reg["FANZONE"] : NULL ) : NULL );
		$this->origem			= ( isset($reg["ORIGEM"]) ? ( $reg["ORIGEM"] !== "" ? $reg["ORIGEM"] : 1 ) : 1 );		
		$this->nacionalidade	= ( isset($reg["NACIONALIDADE"]) ? ( $reg["NACIONALIDADE"] !== "" ? $reg["NACIONALIDADE"] : NULL ) : NULL );
		$this->txt_resumo		= ( isset($reg["TXT_RESUMO"]) ? ( $reg["TXT_RESUMO"] !== "" ? $reg["TXT_RESUMO"] : NULL ) : NULL );
		$this->txt				= ( isset($reg["TXT"]) ? ( $reg["TXT"] !== "" ? $reg["TXT"] : NULL ) : NULL );
		$this->atualizar_dia   	= ( isset($reg["ATUALIZAR_DIA"]) ? ( $reg["ATUALIZAR_DIA"] !== "" ? $reg["ATUALIZAR_DIA"] : NULL ) : NULL );
		$this->publicar_perfil  = ( isset($reg["PUBLICAR_PERFIL"]) ? ( $reg["PUBLICAR_PERFIL"] !== "" ? $reg["PUBLICAR_PERFIL"] : "0" ) : "0" );
		$this->flag_ultima_atualizacao = false;
	}
		
	public function save() {
		
		
		$mysql = new mysql();	
		
		if ($this->id === NULL) {
						
			//INSERT
			
			$sql = "INSERT INTO ARTISTA(
						ID_USUARIO
						,NOME
						,FRURL
						,FOTO	
						,CATEGORIA
						,SITE	
						,AGENDA						
						,WIKIPEDIA
						,FACEBOOK_PAGE
						,TWITTER
						,MYSPACE
						,YOUTUBE
						,FANZONE
						,ORIGEM
						,NACIONALIDADE
						,TXT_RESUMO
						,TXT
						,ATUALIZAR_DIA
						,PUBLICAR_PERFIL
					)						
					VALUES (						
						
						" . ( $this->id_usuario === NULL ? "NULL" : $this->id_usuario) . "
						," . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						," . ( $this->frurl === NULL ? "NULL" : "'".$this->frurl."'") . "
						,'" . $this->foto . "'
						," . $this->categoria . "
						," . ( $this->site === NULL ? "NULL" : "'".$this->site."'") . "
						," . ( $this->agenda === NULL ? "NULL" : "'".$this->agenda."'") . "						
						," . ( $this->wikipedia === NULL ? "NULL" : "'".$this->wikipedia."'") . "
						," . ( $this->facebook_page === NULL ? "NULL" : "'".$this->facebook_page."'") . "
						," . ( $this->twitter === NULL ? "NULL" : "'".$this->twitter."'") . "
						," . ( $this->myspace === NULL ? "NULL" : "'".$this->myspace."'") . "
						," . ( $this->youtube === NULL ? "NULL" : "'".$this->youtube."'") . "
						," . ( $this->fanzone === NULL ? "NULL" : "'".$this->fanzone."'") . "
						," . ( $this->origem === NULL ? "NULL" : "'".$this->origem."'") . "
						," . ( $this->nacionalidade === NULL ? "NULL" : "'".$this->nacionalidade."'") . "
						," . ( $this->txt_resumo === NULL ? "NULL" : "'".$this->txt_resumo."'") . "
						," . ( $this->txt === NULL ? "NULL" : "'".$this->txt."'") . "
						," . ( $this->atualizar_dia === NULL ? "NULL" : $this->atualizar_dia) . "
						,'" . $this->publicar_perfil . "'						
					)";
			
			$q = $mysql->query($sql);			
			
			if ($q) return $q;
			return false;
			
		}
		else {
		
			//UPDATE;
						
			$sql = "UPDATE ARTISTA SET
						ID_USUARIO = " .( $this->id_usuario === NULL ? "NULL" : $this->id_usuario) . "
						,NOME = " . ( $this->nome === NULL ? "NULL" : "'".$this->nome."'") . "
						,FRURL = " . ( $this->frurl === NULL ? "NULL" : "'".$this->frurl."'") . "
						,FOTO = '" . $this->foto  . "'
						,CATEGORIA = " . $this->categoria . "
						,SITE = " . ( $this->site === NULL ? "NULL" : "'".$this->site."'") . "
						,AGENDA = " . ( $this->agenda === NULL ? "NULL" : "'".$this->agenda."'") . "
						,WIKIPEDIA = " . ( $this->wikipedia === NULL ? "NULL" : "'".$this->wikipedia."'") . "
						,FACEBOOK_PAGE = " . ( $this->facebook_page === NULL ? "NULL" : "'".$this->facebook_page."'") . "
						,TWITTER = " . ( $this->twitter === NULL ? "NULL" : "'".$this->twitter."'") . "
						,MYSPACE = " . ( $this->myspace === NULL ? "NULL" : "'".$this->myspace."'") . "
						,YOUTUBE = " . ( $this->youtube === NULL ? "NULL" : "'".$this->youtube."'") . "
						,FANZONE = " . ( $this->fanzone === NULL ? "NULL" : "'".$this->fanzone."'") . "
						,ORIGEM = " . ( $this->origem === NULL ? "NULL" : "'".$this->origem."'") . "
						,NACIONALIDADE = " . ( $this->nacionalidade === NULL ? "NULL" : "'".$this->nacionalidade."'") . "
						,TXT_RESUMO = " . ( $this->txt_resumo === NULL ? "NULL" : "'".$this->txt_resumo."'") . "
						,TXT = " . ( $this->txt === NULL ? "NULL" : "'".$this->txt."'") . "
						,ATUALIZAR_DIA = " . ( $this->atualizar_dia === NULL ? "NULL" : $this->atualizar_dia) . "
						,PUBLICAR_PERFIL = '" . $this->publicar_perfil  . "'
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