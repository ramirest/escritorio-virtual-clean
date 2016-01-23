<section class="grid_12">
<div class="block-border">
<?php echo isset($msg)?$this->config->item('suc_msg_style').$msg.$this->config->item('msg_style_end'):''; ?>
<?php echo form_open('escritorio-virtual/configs/graduacoes', array('id'=>'cria-graduacao','name'=>'cria-graduacao', 'class'=>'form')); ?>
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
if(!isset($graduacao->gid)):
	if($graduacoes !== FALSE):
	// Build table
	$this->table->set_template($this->config->item('table_template'));
	$this->table->set_heading('', 'Nome da graduação', 'Pontos');
	
	foreach ($graduacoes as $g):
		$this->table->add_row(form_checkbox('checkbox_'.$g->gid, $g->gid),
							  anchor($this->uri->uri_string().'/'.$g->gid, $g->nmgraduacao),
							  $g->pontos);
	endforeach;
	
	
	// Show table
	echo $this->table->generate(); 
	endif;
endif;
?>
<?php echo form_fieldset('Graduação'); ?>
<?php echo form_hidden('gid', isset($graduacao->gid)?$graduacao->gid:''); ?>
<p>
	<?php echo form_label('Nome da graduação', 'nmgraduacao'); ?>
    <?php echo form_input(array('name'=>'nmgraduacao', 
								'id'=>'nmgraduacao', 
								'size'=>100), isset($graduacao->nmgraduacao)?$graduacao->nmgraduacao:'');
	?>
</p>
<p>
	<?php echo form_label('Pontos', 'pontos'); ?>
    <?php echo form_input(array('name'=>'pontos', 
								'id'=>'pontos', 
								'size'=>10), isset($graduacao->pontos)?$graduacao->pontos:'');
	?>
</p>
<?php echo form_close(); ?>