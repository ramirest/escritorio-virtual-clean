<section class="grid_12">
<div class="block-border">
<?php
if($this->session->flashdata('credito'))
	echo $this->session->flashdata('credito');
	
$form_action = 	isset($associado)?$associado->aid:"";
?>
<?php echo form_open('escritorio-virtual/pedidos/transferir_credito/'.$form_action, array('id'=>'transferir-credito','name'=>'transferir-credito', 'class'=>'form-horizontal', 'role'=>'form')); ?>
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
		</div>
	</div></div>
	<!-- End control bar -->
<?php if(isset($associado)): ?>    
<?php echo '<div class="well">Transferir crédito para o associado <span class="label label-primary">'.$associado->Nome.'</span></div>'; ?>
<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
<?php else: ?>
<div class="form-group" style=" margin-top:25px;">
<?php echo form_label('Transferir crédito para o associado ', 'associado_txt', array('class'=>'col-sm-2 control-label')); ?>
<div class="col-sm-6">
  <?php 
$associado_txt = array(
        'name'=>'associado_txt',
        'id'=>'associado_txt',
		'class'=>'form-control',
		'data-required'=>'',
        'value'=>set_value('associado_txt'));
  ?>
  <?php echo form_input($associado_txt); ?>
  <?php echo form_error('associado_txt', 
                  $this->config->item('err_msg_style'), 
                  $this->config->item('msg_style_end')); ?>
<div id="response_associado"></div>                          
</div>
</div>
<?php endif; ?>
<div class="form-group">
	<?php echo form_label('Valor do crédito', 'valor', array('class'=>'col-sm-2 control-label')); ?>
    <div class="col-sm-6 input-group" style="width: 200px!important; padding-left: 15px;">
    <span class="input-group-addon">R$</span>
    <?php echo form_input(array('name'=>'valor', 
								'id'=>'valor',
								'class'=>'form-control',
								'data-required'=>''), set_value('valor'));
	?>
	<?php echo form_error('valor', 
                          $this->config->item('err_msg_style'), 
                          $this->config->item('msg_style_end')); ?>
    </div>                      
</div>
<?php echo form_close(); ?>