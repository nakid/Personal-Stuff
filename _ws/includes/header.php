<?
session_start();
if (!isset($_SESSION["ID"])) Header("Location: login.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	
	<base href="<?=URL_COMPLETA?>" />
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<meta http-equiv="Content-Language" content="pt-br" />
	
	<!--<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">-->
	<title>Admin</title>
	
	<link rel="stylesheet" href="css/base.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="css/jquery-ui-1.10.2.hot-sneaks.css" type="text/css" media="screen" charset="utf-8" />
	
	<script type="text/javascript" src="js/jquery-1.8.2.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery-limit-1.2.source.js" charset="utf-8"></script>
		
	<script src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
	
</head>
<body style="padding-left:40px;">
