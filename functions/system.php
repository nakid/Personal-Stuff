<?

function sys_getToday() {
	$hojearr = getdate();
	$hoje= $hojearr["year"] . "-" . ( $hojearr["mon"] <= 9 ? "0" : "") . $hojearr["mon"] . "-". ( $hojearr["mday"] <= 9 ? "0" : "") . $hojearr["mday"];
	return $hoje;
}

function sys_retornaDiaSemanaEscrito($dia, $completo = false) {

	$ret = "";

	switch ($dia) {
		case 0:
			$ret = "Domingo";
			break;
		case 1:
			$ret = "Segunda";
			break;
		case 2:
			$ret = "Terça";
			break;
		case 3:
			$ret = "Quarta";
			break;
		case 4:
			$ret = "Quinta";
			break;
		case 5:
			$ret = "Sexta";
			break;
		case 6:
			$ret = "Sábado";
			break;
	}
	
	return $ret;

}

function sys_retornaMesEscrito($mes, $completo = false) {

	$ret = "";

	switch ($mes) {
		
		case 1:
			$ret = "jan";
			break;
		case 2:
			$ret = "fev";
			break;
		case 3:
			$ret = "mar";
			break;
		case 4:
			$ret = "abr";
			break;
		case 5:
			$ret = "mai";
			break;
		case 6:
			$ret = "jun";
			break;
		case 7:
			$ret = "jul";
			break;
		case 8:
			$ret = "ago";
			break;
		case 9:
			$ret = "set";
			break;
		case 10:
			$ret = "out";
			break;
		case 11:
			$ret = "nov";
			break;
		case 12:
			$ret = "dez";
			break;
			
	}
	
	return $ret;

}

function sys_formatDataToSystem($data) {

	$ret = substr($data, 6, 4) . "-" . substr($data, 3, 2) . "-" . substr($data, 0, 2);
	return $ret;

}



/*
function sys_enviaEmail ($tipo, $email, $nick, $maisInfo = false){	
	
	/* 
	TIPOS 
	
	1: Bem-vindo (inscrito)
	2: Bem-vindo (convidado)
	3: Alterar minha senha
	
	
	* /
	
	$arrAuxMail = sys_retornaMailInfo ($tipo, $email, $nick, $maisInfo);	
	
	require_once('./phpmailer/class.phpmailer.php');		
	
	$mail = new PHPMailer();

	//file_get_contents('contents.html');
	$body             = eregi_replace("[\]",'',$body);

	$mail->IsSMTP(); // telling the class to use SMTP
	
	//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = SMTP_HOST;      // sets GMAIL as the SMTP server
	$mail->Port       = SMTP_PORT;                   // set the SMTP port for the GMAIL server 587
	$mail->Username   = SMTP_USER;  // GMAIL username
	$mail->Password   = SMTP_PASS;            // GMAIL password		

	$mail->SetFrom('naoresponda@vemprojogo.com', 'vemprojogo.com');

	$mail->AddReplyTo("naoresponda@vemprojogo.com","No Reply");

	$mail->Subject    = $arrAuxMail['subject'];

	$mail->AltBody    = ""; // optional, comment out and test	
	
	$mail->MsgHTML($arrAuxMail['body']);
	
	$mail->AddAddress($email, $nick);	

	if(!$mail->Send()) {
		$ret = false;
	} else {
		$ret = true;
	}
	
	return $ret;
	
}

function sys_retornaMailInfo ($tipo, $email, $nick, $maisInfo = false) {
		
	$subject = "";
	$body = "";
	
	switch ($tipo) {
		
		case 1:	
			// Bem-vindo cadastrado
			$subject = "Bem-vindo!";
			$body .= "Olá <strong>". $nick . "</strong>!<br /><br />";
			$body .= "Seja bem-vindo ao <a href='" . URL_COMPLETA . "'>vemprojogo.com</a><br /><br />";
			$body .= "Agora ficou muito mais fácil ficar ficar por dentro de tudo que acontece na sua cidade.<br /><br />";
			$body .= "Além disso, você também pode:<br /><br />";
			$body .= " * Procurar e juntar-se à pessoas que queiram praticar o mesmo esporte que você<br />";
			$body .= " * Filtrar pessoas por esporte, habilidade, idade, sexo, horários disponíveis e tudo mais<br />";
			$body .= " * Receber convites para jogos<br />";
			$body .= " * Utilizar o site como ferramenta para organizar os jogos da sua turma, evitando furos e mantendo seus amigos mais próximos.<br /><br />";
			$body .= "Navegue pelo site, é bem fácil e simples, temos certeza que você vai adorar!<br /><br />";
			$body .= "Um ótimo jogo pra você!<br />";
			$body .= "- Equipe <a href='" . URL_COMPLETA . "'>vemprojogo.com</a>";			
		break;			
		case 2:
			// Bem-vindo convidado
		break;
		case 3:
			// Alterar minha senha
			$subject = "Alterar senha.";
			$body .= "Olá <strong>". $nick . "</strong>!<br /><br />";
			$body .= "Para informar uma nova senha <a href='" . URL_COMPLETA . "login/recuperar-senha/nova-senha/?email=" . $email . "&sk=" . $maisInfo . "'>clique aqui</a>";
			$body .= "<br /><br />";
			$body .= "Caso o problema persista, envie-nos um e-mail para " . EMAIL_SUPORTE . ".<br /><br />";			
			$body .= "Esperamos você de volta!<br />";
			$body .= "- Equipe <a href='" . URL_COMPLETA . "'>vemprojogo.com</a>";
		break;
		
	}
	
	$arrReturn = array(
		"subject" => $subject,
		"body" => $body
	);	
	
	return $arrReturn;	
}


function sys_login ($email, $senha) {
	
	$select = "*";
	$from = "ATLETA";
	$where = "EMAIL = '" . trim($email) . "' && SENHA = '" . md5($senha) . "'";
	$whereCount = "EMAIL = '" . trim($email) . "'";
	
	$tot = db_countRecords($from, $whereCount);
	
	if (!$tot) {
		
		return 'fail-mail';
	}
	$reg = db_selectRecord($select, $from, $where);	
	
	if (!$reg)
		return 'fail-pass';;
	
	
	return $reg;
	
}

/*function sys_validarForm($arr) {	
	
	/*
	Tipos: str2, str6, email
	* /
		
	$total = count($arr); 
	$i = 0;
	$flag = true;
	$err = "";
	
	while ($i < $total && $flag) {		
		extract ($arr[$i]);		
		switch ($tipo) {
			
			case "str2":
				if (strlen($valor)<3) {
					$flag = false;
					$err = "O campo ".ucfirst($field)." precisa conter no mínimo 3 caracteres";					
				}					
				break;
			
			case "str6":
				if (strlen($valor)<6) {
					$flag = false;
					$err = "O campo ".ucfirst($field)." precisa conter no mínimo 6 caracteres";
				}					
				break;
			
			case "email":
				if (!sys_validarEmail($valor)) {
					$flag = false;
					$err = "e-mail inválido: ".$valor;
				}
				break;
			case "captcha":
				if (strcasecmp ($valor, $_SESSION['CAPTCHA'])) {
					$flag = false;
					$err = "Os carecteres digitados não conferiram com os caracteres da imagem";
				}
				break;	
				
		}			
		$i++;	
	}
	
	$ret = array();
	$ret["err"] = "<span class='validationError'>".$err."</span>";
	$ret["flag"] = $flag;
	
	
	
	return $ret;
	
}

function sys_validarEmail($mail){
	
	$validado = preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $mail);	
	return $validado;
} */


?>