<?php
if(isset($page_login) && ($page_login === TRUE)):
	//Show login page
	$this->load->view($pagina);
else:
	$this->load->view("themes/backend/cabecalho");
	$this->load->view("themes/backend/conteudo");
endif;
?>