<?
$nak = $_GET['nak'];
if ($nak!=1) Header("Location: login.php");

session_start();
if (!isset($_SESSION["ID"])) Header("Location: login.php");
$id = 5270;


include ("includes/includes.inc.php");



// GENEROS
if ($_SESSION['GENEROS'] === NULL) $_SESSION['GENEROS'] = 'all';
if ($_SESSION['GENEROS'] == 'all') {
	$info_generos = "Todos os Gêneros Musicais";
} else {
	$genArr = explode(", ",$_SESSION['GENEROS']);
	$info_generos = count($genArr) . " de 37 Gêneros Musicais";
}
$url_generos = URL_COMPLETA.'generos/';


//DATE
$dias = NULL;

if (isset($_GET['dias'])) {
	$dias = $_GET['dias'];
} else {
	$dias = 7;
}	

$sys_full_dia = new DateTime('2016-08-01');
$sys_dia = $sys_full_dia->format('Y-m-d');


//echo "gen -> " . $_SESSION['GENEROS'];



//echo "-->  ???????????????? -> " . $sys_dia;
//temp
/*$sys_full_dia = NULL;
$sys_dia = NULL;
$hum_dia = NULL;

if ($frdia === NULL) {
	$sys_full_dia = new DateTime('2016-05-01');
	$sys_dia = $sys_full_dia->format('Y-m-d');
	$hum_dia = NULL;
} else {
	$sys_dia = sys_formatDataToSystem($frdia);
	$sys_full_dia = new DateTime($sys_dia);
	$hum_dia = $frdia ;
}*/
//temp

//$info_date = sys_retornaDiaSemanaEscrito($sys_full_dia->format('w')) . ', ' . $sys_full_dia->format('d/m/y');

$info_date = "Próximos " . $dias . " dias";

		




/*

	
$datetime = new DateTime();
	
	
//echo "dianull"; else echo 'dia nt null';

$today = getdate(); 
dev_print($today);

$datetime = new DateTime();
$datetime->modify('+3 day');

/*$datetime = new DateTime('tomorrow');


echo $datetime->format('Y-m-d H:i:s');

*/

?>


<!DOCTYPE html>
<html>
    
    <head>
	
		<?
		include ("includes/header.php");
		?>
		
		<!-- SEO -->
		<title>#<?=SITE_NOME?>! <?=SITE_SLOGAN?></title>
		<meta name="description" content="Acompanhe os pŕoximos shows em São Paulo, Rio de Janeiro, Curitiba, BH, Floripa ou em qualquer outra cidade do Brasil! <?=SITE_SLOGAN?>" />
		
		<!-- PARTICULAR INCLUDES -->
		
		
        
    </head>
    
    <body>
        <!-- BARRINHA SUPERIOR -->
        <!--div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#">Contacts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div-->

		
		<div style="margin: auto 0; position: relative; width: 100%; background-image: url('img/texture-gray.jpg'); height:15px;"></div>
		
		
		
		
		
		<!-- MENU FIXED-->
        <div id="glue-menu" class="section section-danger" style="position:fixed; width:100%; top:0; z-index: 9999; display:none">
            <div class="container">
                <div class="row">
                    <!-- LARGE -->
                    <div class="col-lg-12 hidden-md hidden-sm hidden-xs">
                        
						<!--span id="debug">debug</span-->
						<i class="fa fa-3x fa-calendar-o fa-fw text-inverse" style="float:left;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h2>
                        <!--i class="fa fa-3x fa-angle-double-right fa-fw text-inverse"></i>
                        <i class="fa fa-3x fa-fw text-inverse fa-angle-right"></i>
                        <i class="fa fa-3x fa-fw text-inverse fa-caret-right"></i>
                        <i class="fa fa-3x fa-fw text-inverse et-right fa-chevron-right"></i-->
						
						<!--i class="fa fa-3x fa-angle-double-left fa-fw text-inverse"></i>
                        <i class="fa fa-3x fa-fw text-inverse fa-angle-left"></i>
                        <i class="fa fa-3x fa-fw text-inverse fa-caret-left"></i>
                        <i class="fa fa-3x fa-fw text-inverse et-right fa-chevron-left"></i-->
						
						
                        <div class="btn-group btn-group-lg" style="float:left">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff;"> Escolha os dias <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
                        <i class="fa fa-3x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 40px;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h2>
                        <a href="<?=$url_generos?>" class="btn btn-danger btn-lg" style="float:left; border-color: #fff;">Escolha os Gêneros</a>
                    	
						
                    </div>
					
					<!-- MÉDIO -->
                    <div class="col-md-12 hidden-lg hidden-sm hidden-xs">
                        <i class="fa fa-2x fa-fw text-inverse fa-calendar-o" style="float:left; margin: 0 0 0 8px;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h3>
                        <div class="btn-group btn-group-md" style="float:left">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff;"> Escolha os dias <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
                        <i class="fa fa-2x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 40px;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h3>
                        <a href="<?=$url_generos?>" class="btn btn-danger btn-md" style="float:left; border-color: #fff;">Escolha os Gêneros</a>
                        
                    </div>
					
					
					<!-- PEQUENO -->
                    
					<div class="col-sm-8 hidden-lg hidden-md hidden-xs">
						
						<i class="fa fa-3x fa-fw text-inverse fa-calendar-o" style="float:left; margin: 0 0 0 0;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h2>
						
						<div style="clear:left; height:15px; width:100%" ></div>
                        <i class="fa fa-3x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 0;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h2>
					</div>
					
					<div class="col-sm-4 hidden-lg hidden-md hidden-xs">
                        
						<div class="btn-group btn-group-lg" style="float:left; margin-bottom:15px">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff; width:200px;"> Escolha os dias <span class="caret"></span></a>
							
                            <ul class="dropdown-menu" role="menu" style="width:200px;">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
						<a href="<?=$url_generos?>" class="btn btn-danger btn-lg" style="float:left; border-color: #fff; width:200px;">Escolha os Gêneros</a>
						
                    </div>
					
					
					<!-- MUITO PEQUENO -->
                    
					<div class="col-xs-8 hidden-lg hidden-md hidden-sm">
						
						<i class="fa fa-2x fa-fw text-inverse fa-calendar-o" style="float:left; margin: 0 0 0 0;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h3>
						
						<div style="clear:left; height:15px; width:100%" ></div>
                        <i class="fa fa-2x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 0;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h3>
					</div>
					
					<div class="col-xs-4 hidden-lg hidden-md hidden-sm">
                        
						<div class="btn-group btn-group-md" style="float:left; margin-bottom:15px">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff; width:150px;"> Escolha os dias <span class="caret"></span></a>
							
                            <ul class="dropdown-menu" role="menu" style="width:150px;">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
						<a href="<?=$url_generos?>" class="btn btn-danger btn-md" style="float:left; border-color: #fff; width:150px;">Escolha os Gêneros</a>
						
                    </div>
					
					
					
					
                </div>
            </div>
        </div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
        <!-- HEADER -->
        <div class="section" style="padding: 30px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <a href="#"><img src="img/logo.png" class="img-responsive center-block" style="margin-top:14px;"></a>
                    </div>
                    <div class="col-sm-12 hidden-lg">
                        <h1 class="text-center">Procurando por
                            <strong>shows em São Paulo</strong>?
                            <br class="hidden-lg hidden-sm hidden-xs">Então você vai
                            <strong>adorar a gente!</strong>
                        </h1>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <br class="hidden-lg">
						<p class="hidden-xs hidden-sm hidden-md" style="font: 10px Arial,sans-serif,Calibri; color: #a0a0a0; margin:0px; text-align:right; padding-right:12px;">
							PUBLICIDADE
						</p>
						<p class="hidden-xs hidden-sm hidden-lg" style="font: 10px Arial,sans-serif,Calibri; color: #a0a0a0; margin:0px; text-align:right; padding-right:106px;">
							PUBLICIDADE
						</p>
						<p class="hidden-xs hidden-md hidden-lg" style="font: 10px Arial,sans-serif,Calibri; color: #a0a0a0; margin:0px; text-align:right; padding-right:0px;">
							PUBLICIDADE
						</p>
						<p class="hidden-sm hidden-md hidden-lg" style="font: 10px Arial,sans-serif,Calibri; color: #a0a0a0; margin:0px; text-align:right; padding-right:180px;">
							PUBLICIDADE
						</p>
						
						
                        <a href="mailto:divulgue@showsemsp.mus.br"><img src="img/banners/728x90_0.gif" class="center-block hidden-xs"></a>
						<a href="mailto:divulgue@showsemsp.mus.br"><img src="img/banners/320x100_0.gif" class="center-block hidden-sm hidden-md hidden-lg "></a>
                    

                    </div>
                    <div class="col-sm-12 hidden-md hidden-sm hidden-xs">
                        <h1 class="text-center">Procurando por
                            <strong>shows em São Paulo</strong>? Então você vai
                            <strong>adorar a gente!</strong>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- DESTAQUES -->
        <div class="section section-danger" style="background-color:#333!important; background-image: url('img/texture-gray.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-xs-12">
                        <a href="#"><img src="img/825-400_1.jpg" class="img-responsive"></a>
                    </div>
                    <div class="col-sm-3 hidden-xs hidden-sm hidden-md">
                        <a href="#"><img src="img/344-250_1.jpg" class="img-responsive" style="margin-bottom:21px;"></a>
                        <a href="#"><img src="img/344-250_2.jpg" class="img-responsive"></a>
                        <!--a href="#"><img src="img/300-185_1.jpg" class="img-responsive"></a>
                        <a href="#"><img src="img/300-185_2.jpg" class="img-responsive"></a-->
                    </div>
                    <div class="col-sm-3 hidden-xs hidden-sm hidden-lg">
                        <a href="#"><img src="img/344-250_1.jpg" class="img-responsive" style="margin-bottom:30px;"></a>
                        <a href="#"><img src="img/344-250_2.jpg" class="img-responsive"></a>
                        <!--a href="#"><img src="img/300-185_1.jpg" class="img-responsive"></a>
                        <a href="#"><img src="img/300-185_2.jpg" class="img-responsive"></a-->
                    </div>
                    <div class="hidden-md hidden-lg" style="width:100%; float:left; height:30px;">&nbsp;</div>
                    <div class="col-xs-6 hidden-md hidden-lg">
                        <a href="#"><img src="img/344-250_1.jpg" class="img-responsive"></a>
                        <!--a href="#"><img src="img/300-185_1.jpg" class="img-responsive"></a>
                        <a href="#"><img src="img/300-185_2.jpg" class="img-responsive"></a-->
                    </div>
                    <div class="col-xs-6 hidden-md hidden-lg">
                        <a href="#"><img src="img/344-250_2.jpg" class="img-responsive"></a>
                        <!--a href="#"><img src="img/300-185_1.jpg" class="img-responsive"></a>
                        <a href="#"><img src="img/300-185_2.jpg" class="img-responsive"></a-->
                    </div>
                </div>
            </div>
        </div>
        
		
		<!-- MENU -->
		<a id="shows" name="shows"></a>
        <div class="section section-danger">
            <div class="container">
                <div class="row">
                    <!-- LARGE -->
                    <div class="col-lg-12 hidden-md hidden-sm hidden-xs">
                        <i class="fa fa-3x fa-calendar-o fa-fw text-inverse" style="float:left;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h2>
                        <!--i class="fa fa-3x fa-angle-double-right fa-fw text-inverse"></i>
                        <i class="fa fa-3x fa-fw text-inverse fa-angle-right"></i>
                        <i class="fa fa-3x fa-fw text-inverse fa-caret-right"></i>
                        <i class="fa fa-3x fa-fw text-inverse et-right fa-chevron-right"></i-->
                        <div class="btn-group btn-group-lg" style="float:left">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff;"> Escolha os dias <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
                        <i class="fa fa-3x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 40px;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h2>
                        <a href="<?=$url_generos?>" class="btn btn-danger btn-lg" style="float:left; border-color: #fff;">Escolha os Gêneros</a>
                        
						

						
						
                    </div>
					
					<!-- MÉDIO -->
                    <div class="col-md-12 hidden-lg hidden-sm hidden-xs">
                        <i class="fa fa-2x fa-fw text-inverse fa-calendar-o" style="float:left; margin: 0 0 0 8px;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h3>
                        <div class="btn-group btn-group-md" style="float:left">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff;"> Escolha os dias <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
                        <i class="fa fa-2x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 40px;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h3>
                        <a href="<?=$url_generos?>" class="btn btn-danger btn-md" style="float:left; border-color: #fff;">Escolha os Gêneros</a>
                        
                    </div>
					
					
					<!-- PEQUENO -->
                    
					<div class="col-sm-8 hidden-lg hidden-md hidden-xs">
						
						<i class="fa fa-3x fa-fw text-inverse fa-calendar-o" style="float:left; margin: 0 0 0 0;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h2>
						
						<div style="clear:left; height:15px; width:100%" ></div>
                        <i class="fa fa-3x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 0;"></i>
                        <h2 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h2>
					</div>
					
					<div class="col-sm-4 hidden-lg hidden-md hidden-xs">
                        
						<div class="btn-group btn-group-lg" style="float:left; margin-bottom:15px">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff; width:200px;"> Escolha os dias <span class="caret"></span></a>
							
                            <ul class="dropdown-menu" role="menu" style="width:200px;">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
						<a href="<?=$url_generos?>" class="btn btn-danger btn-lg" style="float:left; border-color: #fff; width:200px;">Escolha os Gêneros</a>
						
                    </div>
					
					
					<!-- MUITO PEQUENO -->
                    
					<div class="col-xs-8 hidden-lg hidden-md hidden-sm">
						
						<i class="fa fa-2x fa-fw text-inverse fa-calendar-o" style="float:left; margin: 0 0 0 0;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_date?></h3>
						
						<div style="clear:left; height:15px; width:100%" ></div>
                        <i class="fa fa-2x fa-fw text-inverse -o fa-music" style="float:left; margin: 0 0 0 0;"></i>
                        <h3 style="float:left;  margin: 5px 15px 0 5px; color:#fff "><?=$info_generos?></h3>
					</div>
					
					<div class="col-xs-4 hidden-lg hidden-md hidden-sm">
                        
						<div class="btn-group btn-group-md" style="float:left; margin-bottom:15px">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="border-color: #fff; width:150px;"> Escolha os dias <span class="caret"></span></a>
							
                            <ul class="dropdown-menu" role="menu" style="width:150px;">
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/7#shows'?>">Próximos 7 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/15#shows'?>">Próximos 15 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/30#shows'?>">Próximos 30 dias</a>
                                </li>
                                <li>
                                    <a href="<?=URL_COMPLETA.'proximos-shows/todos#shows'?>">Todos</a>
                                </li>
                            </ul>
                        </div>
						<a href="<?=$url_generos?>" class="btn btn-danger btn-md" style="float:left; border-color: #fff; width:150px;">Escolha os Gêneros</a>
						
                    </div>
					
					
					
					
                </div>
            </div>
        </div>
		
		
		
		
		
        <!-- SETA VERMELHA -->
        <div class="section" style="padding:0">
            <div class="container">
                <img src="img/arrow-green-down.png" style="margin-left: 42px;">
            </div>
        </div>
		
		
        <!-- SHOWS -->
        <div class="section">
            <div class="container">
				<div class="row">
                    
						
					<?
					//$regs = sho_retornarPorCidade('sao-paulo');
					//$regs = sho_retornarPorCidadeAdvanced ($id, $sys_dia, false, true, false);
					
					$regs = sho_retornarPorIntervaloDeData ($sys_dia, $dias, $_SESSION['GENEROS']);
					
					//dev_print($regs);
					
					if ($regs["total"] == 0) {
					//if (1) {
						?>
						<p style="font-size: 18px; min-height: 300px; padding-top: 40px; text-align: left;">
							Ops! Nenhum show foi retornado. <br />
							Aumente a quantidade de dias e o número de gêneros musicais na <strong>Barra de Configurações</strong> acima.
						</p>                 	
						<?
					} else {
						$j=0;
						foreach ($regs["dados"] as $i) {
							
							$j++;
							
							
							
							if ($j == 1) {
								?>
								<div class="col-xs-6 col-sm-4 col-md-3">
									
									<img src="img/addthis.png" class="">
									<br>
									<h3>Junte-se a nós!</h3>Casas se shows, artistas e produtoras,
									<a href="#">entre em contato</a>e envie suas agendas.
									<br>
									<h3>Anuncie!</h3>Promova seu show, sua casa ou seu negócio entre nossos destaques.
									<a href="#">Clique aqui</a>.
									
								</div>
								<?
								$j++;
								
							}
							
							
							
							
							
							
							?>
								
							<div class="col-xs-6 col-sm-4 col-md-3" style="padding-bottom:30px;">
								
                                <?
                                $src_img = "";
                                if ($i['SHO_IMAGEM'] !== NULL) {
                                    $src_img = URL_IMAGEM_SHOWS.$i['SHO_IMAGEM'];
                                } else {
                                    $src_img = "imagens/artistas/".$i['ART_FOTO'].".jpg";
                                }

                                
                                ?>
                                <img src="<?=$src_img?>" class="img-responsive" />
								
                                <h2><?=$i['ART_NOME']?></h2>
								
								<? 
									$flag_art_resumo = false;
									if ($i['SHO_DETALHES'] !== NULL) {
										echo $i['SHO_DETALHES'];
									} else {
										if ($i['ART_RESUMO'] !== NULL) {
											$flag_art_resumo = true;
										}
									}
								?>	
								
								<?=($flag_art_resumo?'<p>'.$i['ART_RESUMO'].'</p>':'')?>
									
								<p>	
									<strong>Data: </strong><?=sys_retornaDiaSemanaEscrito($i['SHO_DIA_SEMANA']).', '.$i['SHO_DATA']?><br />
									<?=($i['SHO_LOCAL'] !== NULL?'<strong>Local: </strong>'.$i['SHO_LOCAL'].'<br />':'')?>
									<strong>Gênero: </strong><?=$i['GEN_NOME']?><br />
									
									<a href="<?=URL_COMPLETA.$i['ART_FRURL']."/".$i['SHO_DATA_LINK']?>" class="btn btn-md btn-sm btn-success" style="margin-top:10px">+ detalhes do show</a>
								</p>
								
							</div>
							<?
							
							if ($j % 2 == 0) {
								?>
								<div class="clearfix hidden-lg hidden-md hidden-sm"></div>
								<?
							}
							
							if ($j % 3 == 0) {
								?>
								<div class="clearfix hidden-lg hidden-md hidden-xs"></div>
								<?
							}
							
							if ($j % 4 == 0) {
								?>
								<div class="clearfix hidden-sm hidden-xs"></div>
								<?
							}
							
							
							
							
							
							
							
							if ($j == 12) {
								?>
								<!--div class="col-xs-6 col-sm-4 col-md-3">
									
									<img src="img/an_336-280.png">
									<br /><br /><br />
									<img src="img/an_180-150.png">
									
									
								</div-->
								
								<div class="col-xs-12 col-sm-8 col-md-6" style="padding: 60px 0 80px 50px;">
									
   								<p style="font: 10px Arial,sans-serif,Calibri; margin:0px; color: #a0a0a0; ">PUBLICIDADE</p>
									
									<a href="mailto:divulgue@showsemsp.mus.br">
										<img src="img/banners/336X280_0.jpg">
									</a>
									
									
									
									<!--br /><br />
									<img src="img/an_180-150.png">
									
									<img src="img/an_320-100.png">
									<br /><br />
									<img src="img/an_320-100.png">
									<br><br>
									<img src="img/an_320-100.png"-->
									
									
									
								</div>
								
								
								<?
								$j+=2;
								
								if ($j % 2 == 0) {
									?>
									<div class="clearfix hidden-lg hidden-md hidden-sm"></div>
									<?
								}
								
								if ($j % 3 == 0) {
									?>
									<div class="clearfix hidden-lg hidden-md hidden-xs"></div>
									<?
								}
								
								if ($j % 4 == 0) {
									?>
									<div class="clearfix hidden-sm hidden-xs"></div>
									<?
								}
								
							}
						}	

						if ($j < 18) {
							?>
							
							<div class="col-xs-6 col-sm-4 col-md-3">
									
								<p style="font-size: 20px; text-align: left; text-align:center; padding: 0 10px;">
									<span style="font-size:35px; font-weight:bold; line-height:35px; padding-bottom:20px; float:left; color:#d9534f ">
									Gostaria de ver mais shows?</span> <br />
									Aumente a quantidade de dias e o número de gêneros musicais na <strong>Barra de Configurações</strong> acima.
								</p>     
								
							</div>
							
							
							<?
						
						}
						
					} 
					?>	
                    
                </div>
				
				
				
				
				
				
				<?
				/*
				<div class="row">
                    <div class="col-md-9 col-sm-8">
                        
						<div class="row">
						
							<?
							//$regs = sho_retornarPorCidade('sao-paulo');
							//$regs = sho_retornarPorCidadeAdvanced ($id, $sys_dia, false, true, false);
							
							$regs = sho_retornarPorIntervaloDeData ($sys_dia, $dias);
							
							//dev_print($regs);
							
							if ($regs["total"] == 0) {
								?>
								<p style="text-align:left;"><br /><br /><br /><br />Não consta entre nossos registros nenhum show programado para esta cidade.<br />
								Cheque novamente dentro de alguns dias.<br /><br />
								Obrigado!   
								</p>                 	
								<?
							} else {
								$j=0;
								foreach ($regs["dados"] as $i) {
									
									$j++;
									?>
										
										<div class="col-md-4 col-xs-6">
											<img src="imagens/artistas/<?=$i['ART_FOTO']?>.jpg" class="img-responsive" />
											<h2><?=$i['ART_NOME']?></h2>
											<p style="margin: 0 0 40px; width:90%">
												<?=($i['ART_RESUMO'] !== NULL?$i['ART_RESUMO'].'<br />':'')?>
												<strong>Data: </strong><?=sys_retornaDiaSemanaEscrito($i['SHO_DIA_SEMANA']).', '.$i['SHO_DATA']?><br />
												<?=($i['SHO_LOCAL'] !== NULL?'<strong>Local: </strong>'.$i['SHO_LOCAL'].'<br />':'')?>
												<a href="<?=URL_COMPLETA.$i['ART_FRURL']."/".$i['SHO_DATA_LINK']?>" class="btn btn-md btn-sm btn-success" style="margin-top:10px">+ detalhes do show</a>
											</p>
											
										</div>
										<?
										
										if ($j % 2 == 0) {
											?>
											<div class="clearfix hidden-lg hidden-md"></div>
											<?
										}
										
										if ($j % 3 == 0) {
											?>
											<div class="clearfix hidden-sm hidden-xs"></div>
											<?
										}
								}
							} 
							?>	
							
						</div>
						
						
						
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div style="width:100%; background-color:#ddd; padding:15px;">
                            <img src="img/addthis.png" class="">
                            <hr>
                            <h3>Junte-se a nós!</h3>Casas se shows, artistas e produtoras,
                            <a href="#">entre em contato</a>e envie suas agendas.
                            <hr>
                            <h3>Anuncie!</h3>Promova seu show, sua casa ou seu negócio entre nossos destaques.
                            <a
                            href="#">Clique aqui</a>.
                                <hr>
                                <img src="img/an_180-150.png">
                                <hr>
                                <img src="img/an_180-150.png">
                                <hr>
                                <img src="img/an_180-150.png">
                                <!--img src="img/an_texto.png"-->
                        </div>
                    </div>
                </div>
                */ ?>
            </div>
        </div>
        <footer class="section section-danger" style="background-image:url('img/texture-gray.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Footer header</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
                            <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
                            <br>Ut enim ad minim veniam, quis nostrud</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-info text-right">
                            <br>
                            <br>
                        </p>
                        <div class="row">
                            <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hidden-xs text-right">
                                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
		
		
		 <script>

            /*var tokenVest = 420;

            var flagTabVest = false;*/

			$(document).ready(function(){
			
				var token_glue_menu = Math.round(parseInt($("#shows").offset().top)) + 6;
				//alert (token_glue_menu);
				
				
				$(window).scroll(function () {

					var $window = $(window);

					var top = $window.scrollTop(); //position of the scrollbar
					
					
					
					//$("#debug").html("DEBUGs: " + top);

					if (top > token_glue_menu) {
						if ($('#glue-menu').is(":hidden"))
							//$('#glue-menu').fadeIn("fast");
							$('#glue-menu').show();
					} else {
						if ($('#glue-menu').is(":visible")) {
							//$('#glue-menu').fadeOut("fast");
							$('#glue-menu').hide();
						}
					}
				});
			
			});
			
		</script>
		
		
		
		
    </body>

</html>