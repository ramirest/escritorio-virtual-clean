<section class="grid_12">
<div class="block-border">
<?php echo isset($msg)?$this->config->item('suc_msg_style').$msg.$this->config->item('msg_style_end'):''; ?>
<?php echo form_open('escritorio-virtual/configs/planos', array('id'=>'cria-plano','name'=>'cria-plano', 'class'=>'form')); ?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
        	<?php echo anchor($this->config->item('btn_back_url'),
							  $this->config->item('btn_back_txt'),
							  $this->config->item('btn_back_attr'));
			?>
		</div>
		
		<div class="float-right"> 
			<?php echo form_button($this->config->item('btn_save')); ?>            
			<?php echo form_button($this->config->item('btn_delete')); ?>            
		</div>
			
	</div></div>
	<!-- End control bar -->
<?php
if(!isset($plano->pid)):
	if($planos !== FALSE):
	// Build table
	$this->table->set_template($this->config->item('table_template'));
	$this->table->set_heading('', 'Nome do plano', 'Valor', 'Ganhos no binário','Pontos no linear','Pontos no binário');
	
	foreach ($planos as $p):
		$this->table->add_row(form_checkbox('checkbox_'.$p->pid, $p->pid),
							  anchor($this->uri->uri_string().'/'.$p->pid, $p->nmplano),
							  'R$ '.$p->valor_plano.',00', 
							  $p->percentual_ganho.' %',
							  $p->perc_pontos_linear.' %',
							  $p->perc_pontos_binario.' %');
	endforeach;
	
	
	// Show table
	echo $this->table->generate(); 
	endif;
endif;
?>
<?php echo form_fieldset('Plano'); ?>
<?php echo form_hidden('pid', isset($plano->pid)?$plano->pid:''); ?>
<p>
	<?php echo form_label('Nome do plano', 'nmplano'); ?>
    <?php echo form_input(array('name'=>'nmplano', 
								'id'=>'nmplano', 
								'size'=>100), isset($plano->nmplano)?$plano->nmplano:'');
	?>
</p>
<p>
	<?php echo form_label('Percentual de ganhos no binário', 'percentual_ganho'); ?>
    <?php echo form_input(array('name'=>'percentual_ganho', 
								'id'=>'percentual_ganho', 
								'size'=>10), isset($plano->percentual_ganho)?$plano->percentual_ganho:'').' %';
	?>
</p>
<p>
	<?php echo form_label('Informações ao usuário', 'info'); ?>
    <?php echo form_textarea(array('name'=>'info', 
								'id'=>'info', 
								'class'=>'full-width',
								'rows'=>10,
								'cols'=>50), isset($plano->info)?$plano->info:'');
	?>
</p>
<p>
	<?php echo form_label('Valor do plano', 'valor_plano'); ?>
    <?php echo 'R$ '.form_input(array('name'=>'valor_plano', 
								'id'=>'valor_plano', 
								'size'=>10), isset($plano->valor_plano)?$plano->valor_plano:'').',00';
	?>
</p>
<p>
	<?php echo form_label('Valor da entrada', 'valor_entrada'); ?>
    <?php echo 'R$ '.form_input(array('name'=>'valor_entrada', 
								'id'=>'valor_entrada', 
								'size'=>10), isset($plano->valor_entrada)?$plano->valor_entrada:'').',00';
	?>
</p>
<p>
	<?php echo form_label('Quantidade de parcelas', 'qtde_parcelas'); ?>
    <?php echo form_input(array('name'=>'qtde_parcelas', 
								'id'=>'qtde_parcelas', 
								'size'=>10), isset($plano->qtde_parcelas)?$plano->qtde_parcelas:'');
	?>
</p>
<p>
	<?php echo form_label('Valor das parcelas', 'valor_parcelas'); ?>
    <?php echo 'R$ '.form_input(array('name'=>'valor_parcelas', 
								'id'=>'valor_parcelas', 
								'size'=>10), isset($plano->valor_parcelas)?$plano->valor_parcelas:'').',00';
	?>
</p>
<p>
	<?php echo form_label('Pontos do plano no linear', 'perc_pontos_linear'); ?>
    <?php echo form_input(array('name'=>'perc_pontos_linear', 
								'id'=>'perc_pontos_linear', 
								'size'=>10), isset($plano->perc_pontos_linear)?$plano->perc_pontos_linear:'').' %';
	?>
</p>
<p>
	<?php echo form_label('Pontos do plano no binário', 'perc_pontos_binario'); ?>
    <?php echo form_input(array('name'=>'perc_pontos_binario', 
								'id'=>'perc_pontos_binario', 
								'size'=>10), isset($plano->perc_pontos_binario)?$plano->perc_pontos_binario:'').' %';
	?>
</p>
<p>
	<?php echo form_label('Valor mínimo para saque', 'minimo_saque'); ?>
    <?php echo 'R$ '.form_input(array('name'=>'minimo_saque', 
								'id'=>'minimo_saque', 
								'size'=>10), isset($plano->minimo_saque)?$plano->minimo_saque:'').',00';
	?>
</p>
<p>
	<?php echo form_label('Valor limite para saque diário', 'maximo_diario'); ?>
    <?php echo 'R$ '.form_input(array('name'=>'maximo_diario', 
								'id'=>'maximo_diario', 
								'size'=>10), isset($plano->maximo_diario)?$plano->maximo_diario:'').',00';
	?>
</p>
<?php echo form_close(); ?>