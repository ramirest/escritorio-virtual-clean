<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
		<?php
		if($this->session->flashdata('credito'))
			echo $this->session->flashdata('credito');
			
		$form_action = 	isset($associado)?$associado->aid:"";
		?>
		<?php echo form_open('escritorio-virtual/pedidos/transferir_credito/'.$form_action, array('id'=>'transferir-credito','name'=>'transferir-credito', 'role'=>'form')); ?>
		<?php if(isset($associado)): ?>    
		<?php echo form_fieldset('Transferir crédito para o associado <span class="label label-primary">'.$associado->Nome.'</span>'); ?>
		<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
		<?php else: ?>
		<div class="row">
			<div class="form-group col-sm-6">
				<?php echo form_label('Transferir crédito para o associado ', 'associado_txt'); ?>
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
		<div class="row">
			<div class="form-group col-sm-3">
				<?php echo form_label('Valor do crédito', 'valor'); ?>
			    <div class=" input-group">
			    <span class="input-group-addon">R$</span>
			    <?php echo form_input(array('name'=>'valor', 
											'id'=>'valor',
											'class'=>'form-control',
											'data-required'=>''), set_value('valor'));
				?>
			    </div>                      
				<?php echo form_error('valor', 
			                          $this->config->item('err_msg_style'), 
			                          $this->config->item('msg_style_end')); ?>
			</div>
		</div>
<?php echo form_button($this->config->item('btn_save')); ?>            

<?php echo form_close(); ?>
        </div>
    </div>
</div>
