<body>
	
	<!-- Header -->
	
	<!-- Server status -->
	<header><div class="container_12">
		
		<p id="skin-name"><small>Sicove<br> Dashboard</small> <strong>v<?php echo $this->config->item('versao');?></strong></p>
		<div class="server-info"><!--Seu saldo: --><strong><?php //echo $this->lib_associados->get_saldo(); ?></strong></div>
		
	</div></header>
	<!-- End server status -->
	
	<!-- Main nav -->
	<?php
    $ci_uri = trim($this->uri->uri_string(), '/');
    $att = ' current';
	$attr = ' class="current"';
    if($this->dx_auth->is_logged_in() && $this->dx_auth->is_role(array("admin","root")) ):
    ?>
	<nav id="main-nav">
		
		<ul class="container_12">
			<li class="home<?php echo (preg_match("|^dashboard.*$|", $ci_uri) > 0)? $att: ''; ?>"><a href="#" title="Home">Home</a>
				<ul>
					<li<?php echo (preg_match("|^dashboard.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('dashboard', 'Dashboard'); ?></li>
					<li class="with-menu<?php echo (preg_match("[binario|linear]", $ci_uri) > 0)? $att: ''; ?>"><?php echo anchor('rede/binario/'.$this->dx_auth->get_associado_id(), 'Rede'); ?>
						<div class="menu">
							<img src="<?php echo $this->config->item('img');?>menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_status-away"><?php echo anchor('rede/binario/'.$this->dx_auth->get_associado_id(), 'Binário'); ?></li>
								<li class="icon_status"><?php echo anchor('rede/linear/'.$this->dx_auth->get_associado_id(), 'Linear'); ?></li>
							</ul>
						</div>
					</li>
					<li<?php echo (preg_match("|^escritorio-virtual/pedidos.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/pedidos', 'Gerenciar pedidos'); ?></li>
					<li<?php echo (preg_match("|^escritorio-virtual/pedidos/gerar_credito.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/pedidos/gerar_credito', 'Gerar créditos'); ?></li>

		


					<!--<li><a href="#" title="My profile">Meu perfil</a></li>-->
				</ul>
			</li>
			<li class="users<?php echo (preg_match("|^escritorio-virtual/empresarios.*|", $ci_uri) > 0)? $att: ''; ?>"><a href="#" title="Associados">Associados</a>
				<ul>
					<li class="with-menu<?php echo (preg_match("[P|A|I]", $ci_uri) > 0)? $att: ''; ?>"><?php echo anchor('escritorio-virtual/empresarios', 'Exibir'); ?>
						<div class="menu">
							<img src="<?php echo $this->config->item('img');?>menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_status-away"><?php echo anchor('escritorio-virtual/empresarios/P', 'Pendentes'); ?></li>
								<li class="icon_status"><?php echo anchor('escritorio-virtual/empresarios/A', 'Ativos'); ?></li>
								<li class="icon_status-busy"><?php echo anchor('escritorio-virtual/empresarios/I', 'Inativos'); ?></li>
							</ul>
						</div>
					</li>
					<li<?php echo (preg_match("|^escritorio-virtual/empresarios/cadastro.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/empresarios/cadastro', 'Cadastrar'); ?></li>
					<!--<li><a href="#" title="Settings">Configurações</a></li>-->
				</ul>
			</li>
			<!--<li class="stats"><a href="#" title="Relatórios">Relatórios</a></li>-->
			<li class="settings<?php echo (preg_match("|^escritorio-virtual/configs.*|", $ci_uri) > 0)? $att: ''; ?>"><a href="#" title="Configura&ccedil;&otilde;es">Configura&ccedil;&otilde;es</a>
				<ul>
					<li<?php echo (preg_match("|^escritorio-virtual/configs/boleto.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/configs/boleto', 'Boleto'); ?></li>
					<li<?php echo (preg_match("|^escritorio-virtual/configs/papeis.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/configs/papeis', 'Pap&eacute;is'); ?></li>
					<li<?php echo (preg_match("|^escritorio-virtual/configs/usuarios.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/configs/usuarios', 'Usu&aacute;rios'); ?></li>
					<li<?php echo (preg_match("|^escritorio-virtual/configs/planos.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/configs/planos', 'Planos'); ?></li>
					<li<?php echo (preg_match("|^escritorio-virtual/configs/graduacoes.*|", $ci_uri) > 0)? $attr: ''; ?>><?php echo anchor('escritorio-virtual/configs/graduacoes', 'Graduações'); ?></li>
				</ul>            
            </li>
		</ul>
	</nav>
	<?php endif; ?>
	<!-- End main nav -->
	
	<!-- Sub nav -->
	<div id="sub-nav"><div class="container_12">
		
		<a href="#" title="Ajuda" class="nav-button"><b>Ajuda</b></a>
	
		<form id="search-form" name="search-form" method="post" action="search.html">
			<input type="text" name="sa" id="sa" value="" title="Buscar..." autocomplete="off">
		</form>
	
	</div></div>
	<!-- End sub nav -->
	
	<!-- Status bar -->
	<div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
			<li class="spaced">Entrou como: <strong><?php echo $this->dx_auth->get_nome_associado();?></strong></li>
			<li>
				<a href="#" class="button" title="5 messages"><img src="<?php echo $this->config->item('img');?>icons/fugue/mail.png" width="16" height="16"> <strong>5</strong></a>
				<div id="messages-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-mail">
						<li>
							<a href="#"><strong>10:15</strong> Veja as novidades...<br>
							<small>De: Sistema</small></a>
						</li>
						<li>
							<a href="#"><strong>Ontem</strong> Olá<br>
							<small>De: Jane</small></a>
						</li>
						<li>
							<a href="#"><strong>Ontem</strong> System update<br>
							<small>De: Sistema</small></a>
						</li>
						<li>
							<a href="#"><strong>2 dias</strong> Nova graduação<br>
							<small>De: Sistema</small></a>
						</li>
						<li>
							<a href="#"><strong>2 dias</strong> Re: dificuldade ao cadastrar<br>
							<small>De: Max</small></a>
						</li>
					</ul>
					
					<p id="messages-info" class="result-info"><a href="#">Ir para caixa de entrada &raquo;</a></p>
				</div>
			</li>
			<li>
				<a href="#" class="button" title="25 comments"><img src="<?php echo $this->config->item('img');?>icons/fugue/balloon.png" width="16" height="16"> <strong>25</strong></a>
				<div id="comments-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-comment">
						<li>
							<a href="#"><strong>Jane</strong>: Gostei das dicas<br>
							<small>Em <strong>Título da mensagem</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Ken_54</strong>: Qual a diferença das graduações...<br>
							<small>Em <strong>Título da mensagem</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Jane</strong> Certo, mas não hoje.<br>
							<small>Em <strong>Outra mensagem</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Max</strong>: Você viu que...<br>
							<small>Em <strong>Título da mensagem</strong></small></a>
						</li>
						<li>
							<a href="#"><strong>Anônimo</strong>: Boa sorte!<br>
							<small>Em <strong>Minha primeira postagem</strong></small></a>
						</li>
					</ul>
					
					<p id="comments-info" class="result-info"><a href="#">Manage comments &raquo;</a></p>
				</div>
			</li>
			<li><?php echo anchor('auth/logout', '<span class="smaller">SAIR</span>', array('class'=>'button red', 'title'=>'Sair')); ?></li>
		</ul>
		
		<!-- v1.5: you can now add class red to the breadcrumb -->
		<ul id="breadcrumb" class="red">
			<li><a href="#" title="Home">Home</a></li>
			<li><?php echo $this->uri->segment(2)?ucfirst($this->uri->segment(2)):''; ?></li>
			<li><?php echo $this->uri->segment(3)?ucfirst($this->uri->segment(3)):''; ?></li>
		</ul>
	
	</div></div>
	<!-- End status bar -->
	
	<div id="header-shadow"></div>
	<!-- End header -->
		
	<!-- Content -->
	<article class="container_12">
		
		<div class="clear"></div>
		
		<?php 
		if(isset($pagina)):
			$this->load->view($pagina);
		else:  				
		echo '<input type="hidden" value="'.$cadastros_semana.'" id="cad_semana">';
 		endif; 
?>

		
    <div id="g1"></div>
		<div class="clear"></div>
				
	</article>
	
	<!-- End content -->
	
	<footer>
		
		<div class="float-left">
			<a href="#" class="button">Fale conosco</a>
			<a href="#" class="button">Sobre o SICOVE</a>
		</div>
		
		<div class="float-right">
			<a href="#top" class="button"><img src="<?php echo $this->config->item('img');?>icons/fugue/navigation-090.png" width="16" height="16"> Topo da página</a>
		</div>
		
	</footer>
	
	<!--
	
	Updated as v1.5:
	Libs are moved here to improve performance
	
	-->

	<!-- Combined JS load -->
	<script src="<?php echo $this->config->item('js');?>mini.php?files=libs/jquery-1.10.2.min,libs/jquery-migrate-1.2.1.min,libs/jquery.hashchange,jquery.accessibleList,searchField,common,standard,jquery.tip,jquery.contextMenu,jquery.modal,list,functions,libs/jquery.tooltipster/jquery.tooltipster,jquery-validate.min"></script>
	<!--[if lte IE 8]><script src="<?php echo $this->config->item('js');?>standard.ie.js"></script><![endif]-->
	
    <script src="<?php echo $this->config->item('js_f');?>bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('js_f');?>mask.min.js"></script>

	<!-- Charts library -->
	<!--Load the AJAX API-->
	<script src="http://www.google.com/jsapi"></script>
	
</body>
</html>