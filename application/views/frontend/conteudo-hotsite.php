  <body data-controller="marketing" data-action="index">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Alternar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar">
            <!--/\/\/\/\/\/\/\/\/\/\/\/\/\EXIBE PATROCINADOR/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\-->
				<?php if($this->session->userdata('nome_patrocinador') !== FALSE):?>
                <?php echo 'Voce foi convidado por: '. $this->session->userdata('nome_patrocinador'); ?>
                <?php endif; ?>            
            <!--\/\/\/\/\/\/\/\/\/\/\/\/\/FIM - EXIBE PATROCINADOR\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/-->
            </span>
          </button>
        </div>
        <div class="collapse navbar-collapse menu_001">
          <ul class="nav navbar-nav sub_menu_001">
			<?php
            $ci_uri = trim($this->uri->uri_string(), '/');
            $attr = ' class="active"';
            ?>
            <div class="logo_cab">
            		  <?php echo anchor('', '<img src="'.$this->config->item('img_f').'logo.png">', 'class="navbar-brand"'); ?>
                   
                      </div>
            <li<?php echo (preg_match("|^.*|", $ci_uri) > 0)? $attr: ''; ?>>
				<?php echo anchor('login', '<span>Escrit&oacute;rio virtual</span>'); ?>
            </li>
            <li class="dropdown">
            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">O Sicove <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li class="dropdown-header">PLANO DE NEG&Oacute;CIO</li>
                    <li><?php echo anchor('manual/index', 'Plano de Neg&oacute;cio (Slide)'); ?></li>
                    <li><?php echo anchor($this->config->item('misc_f').'downloads/pns.rar', 'Download vers&atilde;o PDF'); ?></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">PLANO DE ASSINATURA</li>
                    <li><?php echo anchor(site_url('planos/top'), 'Plano Top'); ?></li>
                    <li><?php echo anchor(site_url('planos/mega'), 'Plano Mega'); ?></li>
                    <li><?php echo anchor(site_url('planos/pop'), 'Plano Pop'); ?></li>
                    <li><?php echo anchor(site_url('planos/light'), 'Plano Light'); ?></li>
                    <li class="divider"></li>
                    <li><?php echo anchor('formas_ganho', 'Formas de Ganho'); ?></li>
                </ul>
            </li>
            <li><?php echo anchor('escritorio-virtual/empresarios/cadastro', 'Cadastre-se'); ?></li>
            <li><?php echo anchor('revista', 'Revista'); ?></li>
            <li><?php echo anchor('armazem', 'Armaz&eacute;m'); ?></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container-fluid">

<?php if(!isset($tabs)): ?>
<header id="intro" class="l-marketing-intro-header js-intro" data-url-path="/">
	<div class="js-intro-video" data-video-src="<?php echo $this->config->item('vds_f');?>marketing-intro-f76be4067208b0c548862a2303e014aa.mp4" data-alt-video-src="<?php echo $this->config->item('vds_f');?>marketing-intro-0262a349eae4d2e1cdee58a6c7013da2.webm" data-poster-src="<?php echo $this->config->item('vds_f');?>marketing-intro-d26f4d0e135fb75e83441c9d9de1907d.jpg"></div>
    <div class="head1"><br class="quebra" />
        <div class="sub_head1">
            <div>
            <br class="quebra" />
            <div style=" text-align:center; margin-top:-20px;">
                <img src="<?php echo $this->config->item('img_f'); ?>01.png" />
            </div>
            </div>
        </div>
    </div>
</header>
<div class="l-marketing-features">



  <div id="payments" class="l-marketing-feature l-marketing-payments js-feature js-feature-payments" data-url-path="features/payments">



  <div class="l-marketing-feature__frame">
    <div class="l-marketing-payments__left">
      <h1 class="marketing-feature-heading marketing-feature-heading--white marketing-feature-heading--large">
        Cadastre-se j&aacute;!
        <br>

        
      </h1>
      <div class="marketing-feature-bubble">
        <div class="marketing-feature-bubble__contents">
          <h2 class="marketing-feature-bubble__contents__heading">Cadastro f&aacute;cil SICOVE</h2>
          <p class="marketing-feature-bubble__contents__description">Fa&ccedil;a seu cadastro e comece a participar do show de vantagens
SICOVE.</p>
<p class="marketing-feature-bubble__contents__description"> S&atilde;o muitas formas de <span style=" color:#ff9c00" > GANHO!</span></p>
<p class="marketing-feature-bubble__contents__description"> Al&eacute;m das melhores <span style=" color:#ff9c00" >FERRAMENTAS</span> do mercado!</p>
<!--
<p class="marketing-feature-bubble__contents__description"> Cadastro feito atravé da pessoa que lhe indicou <span style=" color:#ff9c00" >PROCURE-O!</span></p>
       --> 
       
       
 <a class="but" target="_blank" href="http://www.sicove.com.br/hotsite/pre_cadastro.html">Clique aqui</a>
        </div>

        <div class="marketing-feature-control marketing-feature-control--prev js-feature-control js-feature-prev " data-direction="prev">
  <!-- <div class="marketing-feature-control__circle js-feature-control-circle"></div>
 

  <div class="marketing-feature-control__inner marketing-feature-control__inner--prev js-feature-control-arrow">
    prev
  </div>
  -->
  
</div>
        <div class="marketing-feature-control marketing-feature-control--next js-feature-control js-feature-next " data-direction="next">
        
  <!--  <div class="marketing-feature-control__circle js-feature-control-circle"></div>
  <div class="marketing-feature-control__inner marketing-feature-control__inner--next js-feature-control-arrow">
    next
  </div>
  -->
  
</div>
      </div>
    </div>

    <div class="l-marketing-payments__right">
      <div class="marketing-ipad js-anim-payments-ipad">

        <div class="marketing-ipad__contents js-payments-slider">
          <ul>
            <li>
              <span data-picture data-alt="Invited members provide their credit card details when accepting their invitation.">
  <span data-src="http://www.sicove.com.br/files/frontend/images/cad_01.png" data-media="(min-width: 655px)"></span>

  <noscript>
    <img src="<?php echo $this->config->item('img_f'); ?>cad_01.png" />
  </noscript>
</span>

              <div class="popover is-on-top is-visible">
                <div class="popover__inner">
                  <div class="popover__close">Close Popover</div>
                  <div class="popover__stem"></div>
                  <p>This is some sample copy, but popovers can contain just about any kind of content.</p>
                </div>
              </div>
            </li>
            <li>
              <span data-picture data-alt="Keep better track of finances, payment issues, and refunds with Desktime&#x27;s payment history.">
  <span data-src="http://www.sicove.com.br/files/frontend/images/cad_02.png" data-media="(min-width: 655px)"></span>

  <noscript>
   <img src="<?php echo $this->config->item('img_f'); ?>cad_01.png" />
  </noscript>
</span>
            </li>
          </ul>
        </div>
        
         <a target="_blank" href="http://www.sicove.com.br/hotsite/pre_cadastro.html">
<img class="marketing-ipad__chrome" src="<?php echo $this->config->item('img_f'); ?>iphad.png" /></a>
      </div>
    </div>
  </div>
    
</div>

  <div id="booking" class="l-marketing-feature l-marketing-booking js-feature js-feature-booking" data-url-path="features/booking">


  <div class="l-marketing-feature__frame">

    <div class="l-marketing-booking__main">
      <h1 class="marketing-feature-heading marketing-feature-heading--large">
        Apresenta&ccedil;&atilde;o do Plano de Neg&oacute;cio
      </h1>
      <div class="marketing-desktop js-booking-slider">
      
      
      
        <ul>
          <li class="marketing-desktop__slide">
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--01 js-anim-booking-browser"></div>
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--03 js-anim-booking-browser"></div>
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--02 js-anim-booking-browser"></div>
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--screenshot js-anim-booking-initial-screenshot">
              <figure>
              <span data-picture data-alt="Monthly Booking Schedule">
  <span data-src="http://www.sicove.com.br/files/frontend/images/sl_01.png" data-media="(min-width: 655px)"></span>

  <noscript>
    <img src="<?php echo $this->config->item('img_f'); ?>bg_cadastro.png" />
  </noscript>
</span>
              </figure>
            </div>
          </li>
          <li class="marketing-desktop__slide">
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--screenshot">
              <figure>
              <span data-picture data-alt="Sent Invitation">
  <span data-src="http://www.sicove.com.br/files/frontend/images/sl_03.png" data-media="(min-width: 655px)"></span>

  <noscript>
    <img src="<?php echo $this->config->item('img_f'); ?>bg_cadastro.png" />
  </noscript>
</span>
              </figure>
            </div>
          </li>
          <li class="marketing-desktop__slide">
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--screenshot">
              <figure>
              <span data-picture data-alt="Active Members">
  <span data-src="http://www.sicove.com.br/files/frontend/images/sl_02.png" data-media="(min-width: 655px)"></span>

  <noscript>
   <img src="<?php echo $this->config->item('img_f'); ?>bg_cadastro.png" />
  </noscript>
</span>
              </figure>
            </div>
          </li>
          <li class="marketing-desktop__slide">
            <div class="marketing-desktop__slide__browser marketing-desktop__slide__browser--screenshot">
              <figure>
              <span data-picture data-alt="Inviting a new Member">
  <span data-src="http://www.sicove.com.br/files/frontend/images/sl_01.png" data-media="(min-width: 655px)">
  </span>

  <noscript>
  <img src="<?php echo $this->config->item('img_f'); ?>bg_cadastro.png" />
    
  </noscript>
</span>
              </figure>
            </div>
          </li>
        </ul>
      </div>

      <div class="marketing-feature-bubble marketing-feature-bubble--dark">
        <div class="marketing-feature-bubble__contents">
          <h2 class="marketing-feature-bubble__contents__heading">Apresenta&ccedil;&atilde;o CLEAN</h2>
          <p class="marketing-feature-bubble__contents__description">Preparamos uma apresenta&ccedil;&atilde;o clara e de f&aacute;cil compreens&atilde;o. Aqui voc&ecirc; poder&aacute; visualizar tudo que preparamos para seu SUCESSO.</p>     
        

         
          <a class="but" target="_blank" href="http://www.sicove.com.br/manual/index.html">Clique aqui</a>
         
        </div>

                <div class="marketing-feature-control marketing-feature-control--prev js-feature-control js-feature-prev " data-direction="prev">
  <div class="marketing-feature-control__circle js-feature-control-circle"></div>
  <div class="marketing-feature-control__inner marketing-feature-control__inner--prev js-feature-control-arrow">
    prev
  </div>
</div>
        <div class="marketing-feature-control marketing-feature-control--next js-feature-control js-feature-next " data-direction="next">
  <div class="marketing-feature-control__circle js-feature-control-circle"></div>
  <div class="marketing-feature-control__inner marketing-feature-control__inner--next js-feature-control-arrow">
    next
  </div>
</div>


        </div>


      </div>
    </div>
  </div>
</div>










<div class="adesao">
<div class="sub_adesao">

 <div style=" float:left; padding-bottom:30px;">
        <h1 class="marketing-feature-heading marketing-feature-heading--large">
        Planos de Assinatura
      </h1>

      </div>
   
    <br class="quebra" />
    <div style=" float:left;">
    
						<div class="block_2">
                       
							<div class="button_2">
                         
                            <img src="<?php echo $this->config->item('img_f'); ?>page4_pic1.png" />
                            
                            <span class="bg flipper"><q><span style=" font-size:15px; text-align:left; margin-top:23px;">R$</span><br /><span style=" margin-top:-15px;">1.700</span></q><span class="bg_2"></span></span>
							<p class="txt">SICOVE</p>

							</div>
                            
                            <div style=" border-bottom:1px dotted #696f78; padding-bottom:15px">
                           <img src="<?php echo $this->config->item('img_f'); ?>top.png" />
                           
                            </div>
							<p style=" margin-top:10px;">10% sobre comiss&atilde;o de venda.</p>
                            
                                <p style="color:#000;  font-weight:bold;"">De 40% &agrave; 50% no BIN&Aacute;RIO</p>

                           
<?php echo anchor(site_url('planos/top'), '<span class="part"></span><span class="part_1"></span><span>Saiba Mais</span>', 'class="btn animate"'); ?>
                            
                            
                            
                            
						</div>


</div>
    <div style=" float:left;  margin-left:15px;">
    
						<div class="block_2">
                       
							<div class="button_2">

                            <img src="<?php echo $this->config->item('img_f'); ?>page4_pic2.png" />
                            <span class="bg flipper" style=" background-color:#c24454;"><q><span style=" font-size:15px; text-align:left; margin-top:23px;">R$</span><br /><span style=" margin-top:-15px;">1.200</span></q><span class="bg_2"></span></q><span class="bg_2"></span></span>
							<p class="txt">SICOVE</p>

							</div>
                            
                            <div style=" border-bottom:1px dotted #696f78; padding-bottom:15px">
                        
                                <img src="<?php echo $this->config->item('img_f'); ?>mega.png" />
                            </div>
							<p style=" margin-top:10px;">10% sobre comiss&atilde;o de venda.</p>
                            
                            <p style="color:#000;  font-weight:bold;">30% no BIN&Aacute;RIO</p>
<?php echo anchor(site_url('planos/mega'), '<span class="part"></span><span class="part_1"></span><span>Saiba Mais</span>', 'class="btn animate"'); ?>
						</div>
</div>
    <div style=" float:left;  margin-left:15px;">
    
						<div class="block_2">
                       
							<div class="button_2">
                        
                              <img src="<?php echo $this->config->item('img_f'); ?>page4_pic3.png" />
                            <span class="bg flipper" style=" background-color:#4caca0;"><q><span style=" font-size:15px; text-align:left; margin-top:23px;">R$</span><br /><span style=" margin-top:-15px;">900</span></q><span class="bg_2"></span></q><span class="bg_2"></span></span>
							<p class="txt">SICOVE</p>
							</div>
                            
                            <div style=" border-bottom:1px dotted #696f78; padding-bottom:15px">
                      
                              <img src="<?php echo $this->config->item('img_f'); ?>pop.png" />
                            </div>
							<p style=" margin-top:10px;">10% sobre comiss&atilde;o de venda.</p>
                            
                              <p style="color:#000;  font-weight:bold;">20% no BIN&Aacute;RIO</p>

                               <!-- <p><a href="#"> Saiba Mais</a></p>-->

<?php echo anchor(site_url('planos/pop'), '<span class="part"></span><span class="part_1"></span><span>Saiba Mais</span>', 'class="btn animate"'); ?>
						
                        </div>


</div>


























    <div style=" float:left; margin-left:15px;">
    
						<div class="block_2">
                       
							<div class="button_2">
                           
               
                            <img src="<?php echo $this->config->item('img_f'); ?>page4_pic4.png" />
							
							
			
                         
                            <span class="bg flipper" style=" background-color:#387a9a;"><q><span style=" font-size:15px; text-align:left; margin-top:23px;">R$</span><br /><span style=" margin-top:-15px;">360</span></q><span class="bg_2"></span></q><span class="bg_2"></span></span>
							<p class="txt">SICOVE</p>

							</div>
                            
                            <div style=" border-bottom:1px dotted #696f78; padding-bottom:15px">
                           
                            

                             <img src="<?php echo $this->config->item('img_f'); ?>light.png" />
                            </div>
							<p style=" margin-top:10px;">10% sobre comiss&atilde;o de venda.</p>
                            
                                <p style="color:#000;  font-weight:bold;">10% no BIN&Aacute;RIO</p>

                            <!--<p><a href="#" style=" text-decoration:underline; color:Red;">saiba mais</a></p-->



                          
<?php echo anchor(site_url('planos/light'), '<span class="part"></span><span class="part_1"></span><span>Saiba Mais</span>', 'class="btn animate"'); ?>


        </div>


      </div>
    </div>
  </div>
<?php else: ?>
<div class="container">
<?php
	if(isset($pagina)):
		$this->load->view($pagina);
	endif;
?>
<br class="quebra" />
</div>
<?php endif; ?>

    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


	<script src="<?php echo $this->config->item('misc_f');?>js/drop_down.js"></script>
    <script src="<?php echo $this->config->item('js_f');?>modernizr-30e457852d4d48ab60f46d512e51277e.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="<?php echo $this->config->item('js_f');?>jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo $this->config->item('js_f');?>jquery-validate.min.js"></script>
    <script src="<?php echo $this->config->item('js_f');?>functions.js"></script>
	<script src="<?php echo $this->config->item('misc_f');?>jQueryAssets/jquery-ui-1.9.2.tabs.custom.min.js"></script>
    <script src="<?php echo $this->config->item('js_f');?>bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('js_f');?>mask.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({ scrollTop: $(this.hash).offset().top }, 800);
            });
        });
    </script>
    <script type="text/javascript">
//<![CDATA[
        window.jQuery || document.write(unescape('%3Cscript src="https://desktime-production-assets.s3.amazonaws.com/assets/jquery-a6476dc65eb9dae7616b701d0a9a0346.js" type="text/javascript">%3C/script>'))
//]]>
    </script>
    <script src="<?php echo $this->config->item('js_f');?>marketing-e052ea889927716fd9e20c49119ae11e.js" type="text/javascript"></script>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-47265451-1', 'sicove.com.br');
      ga('send', 'pageview');
    
    </script>
  </body>
</html>