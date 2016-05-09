<?

session_start();
if (!isset($_SESSION["ID"])) Header("Location: login.php");
$id = 5270;

include ("includes/includes.inc.php");


$frcid = "sao-paulo";
$frart = $_GET['frart'];
$dia = $_GET['dia'];

$flag_hoje = ($dia == date("d-m-Y") ? true : false );


$show = new show($frcid, $frart, $dia);
//dev_print($show);
if ($show->id === NULL) {
	//do 404
	dev_echo("<script type='text/javascript'>window.location.href='http://www.showsem.com.br/404.php'; </script>");
}


//dev_print($show);


?>

<!DOCTYPE html>
<html>
    
    <head>
	
        <?
		include ("includes/header.php");
		?>
		
		<!-- SEO -->
		<title><?=SITE_NOME?>! <?=SITE_SLOGAN?></title>
		<meta name="description" content="Acompanhe os pŕoximos shows em São Paulo, Rio de Janeiro, Curitiba, BH, Floripa ou em qualquer outra cidade do Brasil! <?=SITE_SLOGAN?>" />
		
		
    </head>
    
    <body>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
            		  var js, fjs = d.getElementsByTagName(s)[0];
            		  if (d.getElementById(id)) return;
            		  js = d.createElement(s); js.id = id;
            		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=150261801677101";
            		  fjs.parentNode.insertBefore(js, fjs);
            		}(document, 'script', 'facebook-jssdk'));
        </script>
        <!-- Go to www.addthis.com/dashboard to customize your tools
        -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-554109df5eb53a61"
        async="async"></script>
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
		
		
        <!-- HEADER -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <a href="<?=URL_COMPLETA?>"><img src="img/logo.png" class="img-responsive center-block" style="margin-top:10px;"></a>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <br class="hidden-lg">
                        <a href="#"><img src="img/an_728-90.png" class="center-block"></a>
                    </div>
                </div>
            </div>
        </div>
        
		
		<!-- SHOW -->
        <div class="section hidden-sm hidden-xs">
            <div class="container">
                <div class="row">
                   
					<div class="col-md-12">
                    
						<h1>
                            <!--i class="-o fa fa-fw fa-angle-double-right"></i-->
                            <strong><?=$show->artista?>: show em São Paulo dia <?=$dia?></strong>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row" style="margin: 10px 0 0 0;">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 ">
                        <?
                            $src_img = "";
                            if ($show->imagem !== NULL) {
                                $src_img = URL_IMAGEM_SHOWS.$show->imagem;
                            } else {
                                $src_img = URL_COMPLETA."imagens/artistas/".$show->artista_foto.".jpg";
                            }
                        ?>


                        <img src="<?=$src_img?>" alt="<?=$show->artista?>" class="img-responsive">
						<br><br>
						<!--a href="#"><img src="img/an_texto.png" class="center-block"></a-->
						
                    </div>
					
					<div class="col-sm-8 col-xs-8 hidden-lg hidden-md ">
						<h1 class="hidden-xs" style="margin-bottom: 0px; margin-top: 0px;">
                            <strong><?=$show->artista?>: show em São Paulo dia <?=$dia?></strong>
                        </h1>
						
						<h3 class="hidden-sm">
                            <strong><?=$show->artista?>: show em São Paulo dia <?=$dia?></strong>
                        </h3>
						
						<br>
						<img src="img/addthis.png">
					</div>
					
					<div class="hidden-md hidden-lg" style="width:100%; float:left; height:15px;">&nbsp;</div>
					
					
					
					
                    <div class="col-md-6 ">
                        <div class="row hidden-sm hidden-xs">
                            <div class="col-xs-12">
                                <img src="img/addthis.png">
                            </div>
                        </div>
                        
						<?
						$release = false;
						if($show->detalhes !== NULL) 
							$release = $show->detalhes;
						elseif($show->artista_txt_resumo !== NULL) 
							$release = '<strong>'.$show->artista.'</strong>:'.$show->artista_txt_resumo;




						if($release) {
							?>
						
							<div class="row" style="padding: 15px 0 0 0">
								<div class="col-xs-12">
									<p>
										 <?=$release?>
										<br><a href="javascript:void(0)"class="art-saiba-mais">Saiba mais </a> sobre este artista.
									</p>
								</div>
							</div>
							<?
						}
                        ?>
						
						
						<div class="row" style="padding: 10px 0 10px 6px">
                            <div class="col-xs-12">
                                <div style="float:left; padding: 0 5px 0 0;">
                                    <i class="fa fa-3x fa-calendar-o fa-fw text-muted"></i>
                                </div>
                                <div style="float:left">
                                    <h3 style="margin: 0"><?=$show->data?></h3>
                                    <p><?=($show->hora !== NULL ? $show->hora : "não consta o horário")?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px 0">
                            <div class="col-xs-12">
                                <div style="float:left">
                                    <i class="fa fa-3x fa-fw fa-map-marker text-muted"></i>
                                </div>
                                <div style="float:left">
                                    
									<?
									if ($show->id_casa !== NULL) {
										?>
										<h3 style="margin: 0"><?=$show->casa?></h3>
										<p>
											
											<?=($show->casa_endereco !== NULL ? $show->casa_endereco : '')?>
											<?=($show->casa_numero !== NULL ? ', ' . $show->casa_numero : '')?></span>
											<?=($show->casa_bairro !== NULL ? '<br /> ' . $show->casa_bairro : '')?>
											<?=($show->casa_referencia !== NULL ? '<br /> ' . $show->casa_referencia : '')?>
											
										</p>
										<?
									}
									else {
									
										if ($show->local !== NULL) { 
											?>
											
											<h3 style="margin: 0; <?=($show->endereco === NULL ? 'padding-top:5px;' : '')?>"><?=$show->local?></h3>
											<?=($show->endereco !== NULL ? '<p>' . $show->endereco . '</p>' : '')?>
											<?
										} 
										else {
											?>
											<h3 style="margin: 0">Local</h3>
											<p>Não consta esta informação</p>
											<?
										}
									}
									?>									
                                    <!--a href="#">Ver Mapa</a-->
                                </div>
                            </div>
                        </div>
                        
						<?
						if ($show->preco_min !== NULL) {
							?>
							<div class="row" style="padding: 5px 0">
								<div class="col-xs-12">
									<div style="float:left">
										<i class="fa fa-3x fa-fw fa-ticket text-muted"></i>
									</div>
									<div style="float:left">
										
									
										<h3 style="margin: 0; <?=($show->ingresso_link1 !== NULL ? '' : 'padding-top:5px;')?>">
											<?
											if ($show->preco_max !== NULL) {
												?>
												Entre R$<?=$show->preco_min?>,00 e R$<?=$show->preco_max?>,00
												<?
											}
											else {
												?>
												R$<?=$show->preco_min?>,00
												<?
											}
											?>
										</h3>	
										<?
										
										if ($show->ingresso_link1 !== NULL) {
											?>
											<p>
												<a href="<?=$show->ingresso_link1?>" target="_blank"> Clique aqui</a> e compre sua entrada
												<? /* =($show->ingresso_label1 !== NULL ? 'no ' . $show->ingresso_label1 : '') */?>
												
											</p>
											<?
										}
										?>	
										
										<!--a href="#">Ver Mapa</a-->
									</div>
								</div>
							</div>
							<?
						}
						?>						
							
						<?
						if ($show->classificacao !== NULL) {
							?>
							<div class="row" style="padding: 5px 0">
								<div class="col-xs-12">
									<div style="float:left">
										<i class="fa fa-3x fa-child fa-fw text-muted"></i>
									</div>
									<div style="float:left">
										<h3 style="margin: 0; <?=($show->classificacao_com_pais !== NULL ? '' : 'padding-top:8px; padding-bottom: 20px;')?>">
											Para Maiores de <?=$show->classificacao?> anos
										</h3>
										<?
										if ($show->classificacao_com_pais !== NULL) {
											?>
											<p>
												<?
												if ($show->classificacao_com_pais > 0) {
													?>
													Ou maiores de <?=$show->classificacao_com_pais?> com pais ou responsáveis
													<?
												} else {
													?>
													Menores de <?=$show->classificacao?> com pais ou responsáveis
													<?
												}
												?>
											</p>
											<?
										}
										?>	
									</div>
								</div>
							</div>
							<?
						}
						?>
						
						
						<?
						if ($show->casa_fone1 || $show->casa_fone2 || $show->casa_site || $show->casa_email || $show->fone || $show->link) {
							?>
							<div class="row" style="padding: 5px 0">
								<div class="col-xs-12">
									<div style="float:left">
										<i class="fa fa-3x fa-fw fa-plus text-muted"></i>
									</div>
									<div style="float:left">
										<h3 style="margin: 0">Mais informações</h3>
										<?=($show->casa_fone1?'<p style="margin: 0">Fone: ' . $show->casa_fone1 . '</p>' : '')?>
										<?=($show->casa_email?'<p style="margin: 0">Email: ' . $show->casa_email . '</p>' : '')?>
										<? 
										if ($show->casa_site !== NULL) {
											?>
											<p style="margin: 0">Site da casa:
												<a href="<?=$show->casa_site?>" target="_blank">acesse</a>
											</p>
											<?
										}
										if ($show->link!== NULL) {
											?>
											<p style="margin: 0">Link do evento:
												<a href="<?=$show->link?>" target="_blank">acesse</a>
											</p>
											<?
										}
										?>
										
										<!--a href="#">Ver Mapa</a-->
									</div>
								</div>
							</div>
							<?
						}
						?>
                        
						
						<? /*
						if ($flag_hoje) {
							?>
							<div class="row" style="padding: 10px 0 0 0">
								<div class="col-xs-12">
									<a href="<?=URL_COMPLETA.'#shows'?>" class="btn btn-block btn-danger btn-lg">Veja todos os shows em São Paulo</a>
								</div>
							</div>
							<?
						}
						else {
							?>
							
							<div class="row" style="padding: 10px 0 0 0">
								<div class="col-xs-12">
									<a href="<?=URL_COMPLETA.$dia.'/#shows'?>" class="btn btn-block btn-danger btn-lg">Veja outros shows neste mesmo dia</a>
								</div>
							</div>
							
							<div class="row" style="padding: 10px 0 0 0">
								<div class="col-xs-12">
									<a href="<?=URL_COMPLETA.'#shows'?>" class="btn btn-block btn-danger btn-lg">Veja os shows de hoje</a>
								</div>
							</div>
							<?
						} */
						?>						
						
						
						<div class="row" style="padding: 10px 0 0 0">
                            <div class="col-xs-12">
                                <h3 style="color:#d9534f; font-weight:bold">Neste mesmo dia em São Paulo:</h3>
                            </div>
                        </div>
						
						<?
						
						$regs = sho_retornarPorData ($show->dataraw, $_SESSION['GENEROS']);
						
						if ($regs["total"] > 0) {
							?>
							<div class="row" style="padding: 10px 0 0 0">
							 <?
								$j=0;
								foreach ($regs["dados"] as $i) {
									$j++;
									?>
									<div class="col-xs-4 col-sm-3">
										
										<?
		                                $src_img = "";
		                                if ($i['SHO_IMAGEM'] !== NULL) {
		                                    $src_img = URL_IMAGEM_SHOWS.$i['SHO_IMAGEM'];
		                                } else {
		                                    $src_img = "imagens/artistas/".$i['ART_FOTO'].".jpg";
		                                }
		                                ?>

										<img src="<?=$src_img?>" class="img-responsive" />
										<!--a style="font-size: 18px;" href="<?=URL_COMPLETA.$i['ART_FRURL']."/".$i['SHO_DATA_LINK']?>">
											<?=$i['ART_NOME']?>
										</a-->
										
										<h2 style="padding-top:0px; margin-top:10px; margin-bottom: 5px; font-size:18px"><?=$i['ART_NOME']?></h2>
										<p>	
											<strong>Gênero: </strong><?=$i['GEN_NOME']?><br />
											<a href="<?=URL_COMPLETA.$i['ART_FRURL']."/".$i['SHO_DATA_LINK']?>" class="btn btn-md btn-sm btn-success" style="margin-top:10px">+ detalhes do show</a>
											<br><br>
										</p>
										
										
									</div>
									<?
									
									if ($j % 3 == 0) {
										?>
										<div class="clearfix hidden-lg hidden-md hidden-sm"></div>
										<?
									}
									if ($j % 4 == 0) {
										?>
										<div class="clearfix hidden-xs"></div>
										<?
									}
									
								}
								?>
							</div>
							<?							
						}
						
						?>
						
						
						<div class="row" style="padding: 10px 0 0 0">
							<div class="col-xs-12">
								<a href="<?=URL_COMPLETA.'#shows'?>" class="btn btn-block btn-danger btn-lg">Veja todos os shows em São Paulo</a>
							</div>
						</div>
						
						
						
                        <div class="row tk-art-saiba-mais" style="padding: 10px 0 0 0">
                            <div class="col-xs-12">
                                <h3>Saiba mais sobre <?=$show->artista?></h3>
                            </div>
                        </div>
                        
						<?
						
						$artista = new artista($show->artista_frurl);
						
						?>
						
						<div class="row" style="padding: 10px 0 0 0">
                            <div class="col-xs-12">
                                
								<?
								if ($artista->site !== NULL) {
									?>
									<span style="float:left; margin-right:8px">
										<i class="fa fa-2x fa-fw fa-link text-muted"></i>
										<a style="font-size: 18px;" target="_blank" href="<?=$artista->site?>">Site oficial</a>
									</span>
									<?
								}
								?>
								
								<?
								if ($artista->myspace !== NULL) {
									?>
									<span style="float:left; margin-right:8px">
										<i class="fa fa-2x fa-fw fa-link text-muted"></i>
										<a style="font-size: 18px;" target="_blank" href="<?=$artista->myspace?>">My Space</a>
									</span>
									<?
								}
								?>
								
								<?
								if ($artista->twitter !== NULL) {
									?>
									<span style="float:left; margin-right:8px">
										<i class="fa fa-2x fa-fw fa-twitter text-muted"></i>
										<a style="font-size: 18px;" target="_blank" href="<?=$artista->twitter?>">Twitter</a>
									</span>
									<?
								}
								?>

								<?
								if ($artista->facebook_page !== NULL) {
									?>
									<span style="float:left; margin-right:8px">
										<i class="fa fa-2x fa-facebook-f fa-fw text-muted"></i>
										<a style="font-size: 18px;" target="_blank" href="<?=$artista->facebook_page?>">Fan page</a>
									</span>
									<?
								}
								?>
								
								<?
								if ($artista->fanzone !== NULL) {
									?>
									<span style="float:left; margin-right:8px">
										<i class="fa fa-2x fa-fw fa-link text-muted"></i>
										<a style="font-size: 18px;" target="_blank" href="<?=$artista->fanzone?>">Fan Zone</a>
									</span>
									<?
								}
								?>
								
								<?
								if ($artista->wikipedia !== NULL) {
									?>
									<span style="float:left; margin-right:8px">
										<i class="fa fa-2x fa-fw fa-link text-muted"></i>
										<a style="font-size: 18px;" target="_blank" href="<?=$artista->wikipedia?>">Wikipedia</a>
									</span>
									<?
								}
								?>
                            </div>
                        </div>
                        
						
						<?
						if ($artista->youtube !== NULL) {
							?>
							<div class="row" style="padding: 30px 0 50px 0">
								<div class="col-xs-12">
									<iframe width="500" height="281" src="https://www.youtube.com/embed/<?=$artista->youtube?>"
									frameborder="0" allowfullscreen=""></iframe>
								</div>
							</div>
							<?         		            		
						}
						?>
						
						
						
                    </div>
                    <div class="col-lg-4 col-md-3" style="background-color:#fff">
                        <img src="img/fb_comments.png">
                        <!--div class="fb-comments" data-href="http://developers.facebook.com/docs/plugins/comments/"
                        data-width="300" data-numposts="20" data-colorscheme="light"></div-->
                    </div>
                </div>
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

            $(".art-saiba-mais").click(function () {
                ponto = $('.tk-art-saiba-mais').offset().top
                scrollWin(ponto, 400);
            });

            function scrollWin(point, time) {
                $('html,body').animate({
                    scrollTop: point
                }, time);
            }
    
        </script>
		
		
		
		
    </body>

</html>