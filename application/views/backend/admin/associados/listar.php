<div class="block-border">
    <div class="block-content no-title">
<?php		
echo $this->session->flashdata('msg');

if(isset($associados)):

    foreach($associados->result() as $v):
?>
<ul class="extended-list icon-user">
    <li>
        <!-- Main content -->
        <a href="#" id="<?php echo site_url('callback/associado_load/'.$v->aid); ?>" class="detalhes_associado">
            <span class="icon"></span>
            <?php echo $v->Nome.' ('.$v->Login.')'; ?><br>
            <small><?php echo $v->cidade.' / '.$v->estado; ?></small>
        </a>
         
        <!-- Example use of the mini-menu -->
        <ul class="mini-menu">
        	<?php echo form_open(); ?>
             <li><a href="<?php echo site_url('escritorio-virtual/pedidos/transferir_credito/'.$v->aid); ?>" title="Transferir crédito para este associado"><img src="<?php echo $this->config->item('img').'icons/fugue/arrow-curve-000-left.png'; ?>" width="16" height="16"></a></li>
       	<?php if($v->status != "A"): ?>
				<?php if($this->lib_associados->get_saldo() >= $this->config->item('taxa_adesao')): ?>
                    <!--<li><button class="btn btn-primary" data-toggle="modal" data-target=".bs-modal-sm">Ativar</button></li>-->
                <?php endif; ?>
            <?php endif; ?>
            <li><a href="#" title="Enviar email"><img src="<?php echo $this->config->item('img').'icons/fugue/mail.png'; ?>" width="16" height="16"></a></li>
            <?php if($this->dx_auth->is_role(array("admin","root"))): ?>
            <li><a href="#" title="Desativar"><img src="<?php echo $this->config->item('img').'icons/fugue/cross-circle.png'; ?>" width="16" height="16"> Desativar</a></li>
            <?php endif; ?>
            <?php form_close(); ?>
        </ul>
         
        <ul class="extended-options">
		<?php 
		switch($v->status): 
			case 'P': 
				echo '<li>
						Status: <strong>Pendente</strong><br>
						<img src="'.$this->config->item('img').'icons/fugue/status-away.png'.'" width="16" height="16">
					  </li>';
				break; 
			case 'A': 
				echo '<li>
						Status: <strong>Ativo</strong><br>
						<img src="'.$this->config->item('img').'icons/fugue/status.png'.'" width="16" height="16">
					  </li>';
				break; 
			case 'I': 
				echo '<li>
						Status: <strong>Inativo</strong><br>
						<img src="'.$this->config->item('img').'icons/fugue/status-busy.png'.'" width="16" height="16">
					  </li>';
				break; 
		endswitch;
		?>
        </ul>             
    </li>
          
</ul>		
<?php
	endforeach;
endif;

?>
    </div>
</div>


<div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="Ativar associado" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      ...
    </div>
    <div class="modal-footer">
        <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal">Não</button>
        <button id="confirm-btn" type="button" class="btn btn-primary" data-loading-text="Ativando...">Sim</button>
    </div>
  </div>
</div>