<section class="grid_12">
<div class="block-border">
<?php
if($this->session->flashdata('credito'))
	echo $this->session->flashdata('credito');
	
$form_action = 	isset($associado)?$associado->aid:"";
?>
<?php echo form_open('escritorio-virtual/pedidos/gerar_credito/'.$form_action, array('id'=>'gera-credito','name'=>'gera-credito', 'class'=>'form')); ?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
        	<?php echo anchor($this->config->item('btn_back_url'),
							  $this->config->item('btn_back_txt'),
							  $this->config->item('btn_back_attr'));
			?>
		</div>
		<div class="float-right"> 
			<?php 
			$btn_save = $this->config->item('btn_save');
			$btn_save['disabled'] = 'disabled';
			echo form_button($btn_save); 
			?>
			<?php //echo form_button($this->config->item('btn_delete')); ?>            
		</div>
	</div></div>
	<!-- End control bar -->
<?php if(isset($associado)): ?>    
<?php echo form_fieldset('Gerar crédito para o associado '.$associado->Nome); ?>
<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
<?php else: ?>
<p>
<?php echo form_label('Gerar crédito para o associado ', 'associado_txt'); ?>
  <?php 
$associado_txt = array(
        'name'=>'associado_txt',
        'id'=>'associado_txt',
        'value'=>set_value('associado_txt'),
        'size'=>'30',
        'style'=>'border:1px solid #9d9d9d; padding:6px 6px 6px 6px; background-color:rgba(127, 255, 212, 0); color:#4a0523; margin-top:0px; font-size:15px; width:345px; height:40px;');
  ?>
  <?php echo form_input($associado_txt); ?>
  <?php echo form_error('associado_txt', 
                  $this->config->item('err_msg_style'), 
                  $this->config->item('msg_style_end')); ?>
<div id="response_associado"></div>                          
</p>
<?php endif; ?>
<p>
	<?php echo form_label('Motivo do crédito', 'motivo'); ?>
    <?php echo form_input(array('name'=>'motivo', 
								'id'=>'motivo', 
								'size'=>100), set_value('motivo'));
	?>
	<?php echo form_error('motivo', 
                          $this->config->item('err_msg_style'), 
                          $this->config->item('msg_style_end')); ?>
</p>
<p>
	<?php echo form_label('Valor do crédito', 'valor'); ?>
    <?php echo 'R$ '.form_input(array('name'=>'valor', 
								'id'=>'valor', 
								'size'=>10), set_value('valor'));
	?>
	<?php echo form_error('valor', 
                          $this->config->item('err_msg_style'), 
                          $this->config->item('msg_style_end')); ?>
</p>
<?php echo form_close(); ?>