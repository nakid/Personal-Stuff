<?session_start();
//echo 'b';
include ("includes/includes.inc.php");
//echo 'c';
if($_POST) {	
	
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	
	$login = usu_login($email, $senha);	
	
	
	if (!is_array($login)) {
		
		if ($login == 'fail-mail')
			$erMsg = 'Falha no login';
		elseif ($login == 'fail-pass') {
			$erMsg = 'Falha no login';
		}
		
	} else {
        
		$_SESSION['ID'] = $login["ID"];
		$_SESSION['ID_DADOS'] = $login["ID"];
		$_SESSION['NOME'] = $login["NOME"];
		$_SESSION['COR'] = $login["COR"];						
		$_SESSION['ORDEM_ARTISTA'] = "cat";
		Header("Location: index.php");
	}	
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	
	<base href="<?=URL_COMPLETA?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!--<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">-->
	<title>Admin</title>
	
	<link rel="stylesheet" href="css/base.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="css/jquery-ui-1.10.2.hot-sneaks.css" type="text/css" media="screen" charset="utf-8" />
	
	<script type="text/javascript" src="js/jquery-1.8.2.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js" charset="utf-8"></script>
	
	<script src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		
</head>
<body style="padding:40px">
-----------------------------<br>
LOGIN<br>
-----------------------------<br>
<br><br><br>


<? if (isset ($erMsg)) echo '<span style="color:#900">' . $erMsg . '</span>'; ?>
<form id="formLogin" name="formLogin" method="post">		
	
	<label>User</label>
	<input id="email" name="email" type="text" size="30" maxlength="50" value="<?=($_POST['email']?$_POST['email']:($_GET['email']?$_GET['email']:''))?>" />		
	<div style="clear:left"></div>
	
	<label>Pass</label>
	<input id="senha" name="senha" type="password" size="30" maxlength="20"/>
	<div style="clear:left"></div>		
	
	<input id="postSimples" name="postSimples" type="submit" value="entrar" />	
	
</form>

<br><br>



	


<?
include ("includes/footer.php");
?>