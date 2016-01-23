<?php
$tema = $this->config->item('tema');
$sexo = $this->dx_auth->get_sexo_associado();
$img_dir = $this->config->item('img_f');
?>
<body>
	<div id="wrapper">

		<!-- begin TOP NAVIGATION -->
		<nav class="navbar-top" role="navigation">

			<!-- inicio CABEÇALHO LOGO -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle pull-right"
					data-toggle="collapse" data-target=".sidebar-collapse">
					<i class="fa fa-bars"></i> Menu
				</button>
				<div class="navbar-brand">
                    <?php
                        $logo = '<img src="'. $img_dir. 'logo.png" class="img-responsive" alt="">';
                        echo anchor('escritorio-virtual/dashboard', $logo);
                    ?>
				</div>
			</div>
			<!-- fim CABEÇALHO LOGO -->
			<?php 
			  $class = 'class="collapsed"'; // Esconde menu tipo usuário pendente;
			  if($this->dx_auth->is_logged_in()):
			  $class = "";
			?>

			<div class="nav-top">

				<!-- begin LEFT SIDE WIDGETS -->
				<ul class="nav navbar-left">
					<li class="tooltip-sidebar-toggle"><a href="#" id="sidebar-toggle"
						data-toggle="tooltip" data-placement="right"
						title="Alterar Navegação Lateral"> <i class="fa fa-bars"></i>
					</a></li>
					<!-- You may add more widgets here using <li> -->
				</ul>
				<!-- end LEFT SIDE WIDGETS -->

				<!-- begin MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->
				<ul class="nav navbar-right">

					<!-- inicio MENU DE AÇÕES DO EMPRESÁRIO -->
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> <i class="fa fa-user"></i> <i
							class="fa fa-caret-down"></i>
					</a>
						<ul class="dropdown-menu dropdown-user">
							<?php 
							if($this->dx_auth->get_associado_id())
								$associado_id = $this->dx_auth->get_associado_id();
							else
								$associado_id = 1;	
							?>
							<li><a href="<?php echo site_url("escritorio-virtual/empresarios/perfil/$associado_id"); ?>"> <i class="fa fa-user"></i> Meu Perfil
							</a></li>
							<li class="divider"></li>
							<li><a class="logout_open" href="#logout"> <i
									class="fa fa-sign-out"></i> Sair <strong><?php echo $this->dx_auth->get_nome_associado(); ?></strong>
							</a></li>
						</ul> <!-- /.dropdown-menu --></li>
					<!-- /.dropdown -->
					<!-- fim MENU DE AÇÕES DO EMPRESÁRIO -->

				</ul>
				<!-- /.nav -->
				<!-- end MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->

			</div>
			<!-- /.nav-top -->
		</nav>
		<!-- /.navbar-top -->
		<!-- end TOP NAVIGATION -->

		<!-- inicio NAVEGAÇÃO LATERAL -->
		<nav class="navbar-side" role="navigation">
			<div class="navbar-collapse sidebar-collapse collapse">
				<ul id="side" class="nav navbar-nav side-nav">
					<!-- inicio PAINEL DE NAVEGAÇÃO LATERAL DO EMPRESÁRIO -->
					<li class="side-user hidden-xs"><img class="img-circle"
						src="<?php echo $tema['img']; ?>perfil-<?php echo $sexo; ?>.png"
						alt="">
						<p class="welcome">
							<i class="fa fa-key"></i> Logado como
						</p>
						<p class="name tooltip-sidebar-logout">
                            <?php echo $this->dx_auth->get_nome_associado(); ?> <a
								style="color: inherit" class="logout_open" href="#logout"
								data-toggle="tooltip" data-placement="top" title="Logout"><i
								class="fa fa-sign-out"></i></a>
						</p>
						<div class="clearfix"></div></li>
					<!-- fim PAINEL DE NAVEGAÇÃO LATERAL DO EMPRESÁRIO -->
					<!-- inicio PESQUISA -->
					<li class="nav-search">
						<form role="form">
							<input type="search" class="form-control"
								placeholder="Pesquisar...">
							<button class="btn">
								<i class="fa fa-search"></i>
							</button>
						</form>
					</li>
					<!-- fim PESQUISA -->

                    <!-- MENU -->

                        <?php $this->load->view('themes/backend/menu'); ?>

                    <!-- fim MENU -->
                    
                    
                </ul>
				<!-- /.side-nav -->
			</div>
			<!-- /.navbar-collapse -->
		</nav>
		<!-- /.navbar-side -->
		<!-- fim NAVEGAÇÃO LATERAL -->
		<?php endif; ?>
		<!-- begin MAIN PAGE CONTENT -->
		<div id="page-wrapper" <?php echo $class; ?>>

			<div class="page-content">

				<!-- inicio LINHA TÍTULO DA PÁGINA -->
				<div class="row">
					<div class="col-lg-12">
						<div class="page-title">
							<h1>
                                <?php echo $titulo; ?>
                            </h1>
							<ol class="breadcrumb">
								<li><i class="fa fa-dashboard"></i> <a
									href="<?php echo site_url('escritorio-virtual/dashboard'); ?>">Dashboard</a></li>
								<li class="active"><?php echo $titulo; ?></li>
							</ol>
						</div>
					</div>
					<!-- /.col-lg-12 -->

				</div>
				<!-- /.row -->
				<!-- fim LINHA TÍTULO DA PÁGINA -->

				<!-- inicio LINHA CONTEÚDO -->
				<div class="row">
					<div class="col-lg-12">
					<?php 
                    if(isset($pagina)):
                        $this->load->view($pagina);
                    endif; 
                    ?>
                    </div>
					<!-- /.col-lg-12 -->

				</div>
				<!-- /.row -->
				<!-- fim LINHA CONTEÚDO -->
                    
                <?php
                    if($this->dx_auth->is_logged_in() && $this->dx_auth->is_role("admin") && isset($cadastros_semana) && isset($cadastros_mes)):
                ?>
                    <!-- Cadastros na semana -->
                    <div class="col-lg-6">
                        <div class="portlet portlet-orange">
                            <div class="portlet-heading">
                                <div class="portlet-title">
                                    <h4>Últimos cadastros</h4>
                                </div>
                                <div class="portlet-widgets">
                                    <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                                    <span class="divider"></span>
                                    <input type="hidden" id="cad_semana" value="<?php echo $cadastros_semana; ?>">
                                    <input type="hidden" id="cad_mes" value="<?php echo $cadastros_mes; ?>">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#donutChart">
                                    <i class="fa fa-chevron-down"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="donutChart" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <div class="portlet-body">
                                        <div id="morris-chart-donut"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				<!-- /.col-lg-12 -->
                <?php endif; ?>
            </div>
			<!-- /.page-content -->

		</div>
		<!-- /#page-wrapper -->
		<!-- end MAIN PAGE CONTENT -->

	</div>
	<!-- /#wrapper -->

	<!-- GLOBAL SCRIPTS -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script
		src="<?php echo $this->config->item('js'); ?>libs/jquery-migrate-1.2.1.min.js"></script>
	<script
		src="<?php echo $tema['js']; ?>plugins/bootstrap/bootstrap.min.js"></script>
	<script
		src="<?php echo $tema['js']; ?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script
		src="<?php echo $tema['js']; ?>plugins/popupoverlay/jquery.popupoverlay.js"></script>
	<script
		src="<?php echo $tema['js']; ?>plugins/popupoverlay/defaults.js"></script>
	<!-- Logout Notification Box -->
	<div id="logout">
		<div class="logout-message">
			<img class="img-circle img-logout"
				src="<?php echo $tema['img']; ?>perfil-<?php echo $sexo; ?>.png"
				alt="">
			<h3>
				<i class="fa fa-sign-out text-green"></i> Finalizar sessão
			</h3>
			<p>Tem certeza de que deseja finalizar sua sessão?</p>
			<ul class="list-inline">
				<li><a href="<?php echo site_url('logout'); ?>"
					class="btn btn-green"> <strong>Sim</strong>
				</a></li>
				<li>
					<button class="logout_close btn btn-green">Não</button>
				</li>
			</ul>
		</div>
	</div>
	<!-- /#logout -->

	<script src="<?php echo $tema['js']; ?>plugins/popupoverlay/logout.js"></script>

	<script src="<?php echo $tema['js']; ?>plugins/hisrc/hisrc.js"></script>

	<?php
	if (isset ( $page_plugin )) :
		$plugins = $this->config->item ( 'plugins' );
		foreach ( $plugins ['js'] [$page_plugin] as $style ) :
			echo $style;
		endforeach;	
	endif;
	
	
	?>

    <!-- SCRIPTS DO TEMA -->
	<script src="<?php echo $tema['js']; ?>flex.js"></script>
    <?php
	if(isset($page_js_foot)):
		$scripts = $this->config->item('scripts');
		foreach($scripts[$page_js_foot]['foot'] as $script):
			echo $script;
		endforeach;
	endif;
	?>

    <!-- SCRIPTS CRUD -->
    <?php if(isset($js_files)): ?>
        <?php foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-51536975-2', 'sicove.com.br');
	  ga('send', 'pageview');
	
	</script>
</body>

</html>
