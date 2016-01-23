<section class="grid_12">
<div class="block-border">
<?php echo isset($msg)?$this->config->item('suc_msg_style').$msg.$this->config->item('msg_style_end'):''; ?>
<?php echo form_open('escritorio-virtual/pedidos', array('id'=>'cria-pedido','name'=>'cria-pedido', 'class'=>'form')); ?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
        	<?php echo anchor($this->config->item('btn_back_url'),
							  $this->config->item('btn_back_txt'),
							  $this->config->item('btn_back_attr'));
			?>
		</div>
		<!--
		<div class="float-right"> 
			<?php //echo form_button($this->config->item('btn_save')); ?>            
			<?php //echo form_button($this->config->item('btn_delete')); ?>            
		</div>
		-->	
	</div></div>
	<!-- End control bar -->
<?php
if($this->session->flashdata('pagamento'))
	echo $this->session->flashdata('pagamento');
	
if($pedidos !== FALSE):
// Build table
$this->table->set_template($this->config->item('table_template'));
$this->table->set_heading('', 'Associado', 'Vencimento', 'Fatura', 'Valor', 'Descri&ccedil;&atilde;o','Situa&ccedil;&atilde;o', '');
$contextual_menu = '
<ul class="mini-menu">
    <li>'.anchor('escritorio-virtual/pedidos/gerar_credito/%s', '<img src="'.$this->config->item('img').'icons/fugue/plus-circle-blue.png" width="16" height="16"> Adicionar crédito', 'title="Adicionar crédito"').'</li>
</ul>
';

foreach ($pedidos->result() as $p):
	$this->table->add_row(form_checkbox('checkbox_'.$p->pid, $p->pid),
						  $p->associado.sprintf($contextual_menu, $p->aid),
						  $this->data->mysql_to_human($p->dtvencimento),
						  $p->fid,
						  'R$ '.$p->valor, 
						  $p->descricao,
						  $p->status,
						  anchor('escritorio-virtual/pedidos/pagar_fatura/'.$p->fid.'/'.$p->aid, 'Confirmar pagamento'));
endforeach;


// Show table
echo $this->table->generate(); 
endif;
?>