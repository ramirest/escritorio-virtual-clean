<div class="portlet portlet-default">
	<div id="defaultPortlet" class="panel-collapse collapse in">
		<div class="portlet-body">
		<?php
		if ($this->session->flashdata ( 'credito' ))
			echo $this->session->flashdata ( 'credito' );

		$form_action = isset ( $associado ) ? $associado->aid : "";
		?>
		<?php echo form_open('escritorio-virtual/pedidos/gerar_credito/'.$form_action, array('id'=>'gera-credito','name'=>'gera-credito', 'class'=>'form')); ?>
		<?php if(isset($associado)): ?>
		<?php echo form_fieldset('Gerar crédito para o associado <span class="label label-primary">'.$associado->Nome.'</span>'); ?>
		<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
		<?php else: ?>
		<div class="row">
			<div class="form-group col-sm-6">
			<?php echo form_label('Gerar crédito para o associado ', 'associado_txt'); ?>
			<?php 
				$associado_txt = array(
				        'name'=>'associado_txt',
				        'id'=>'associado_txt',
						'class'=>'form-control',
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
				<?php echo form_label('Motivo do crédito', 'motivo'); ?>
				<?php 
				$motivo = array('name'=>'motivo', 
								'id'=>'motivo',
								'class'=>'form-control',    		
								'value'=>set_value('motivo'));	
				?>
			    <?php echo form_input($motivo);?>	
				<?php echo form_error('motivo', 
			                          $this->config->item('err_msg_style'), 
			                          $this->config->item('msg_style_end')); ?>
			</div>
			<div class="form-group col-sm-3">
				<?php echo form_label('Valor do crédito', 'valor'); ?>
			    <div class=" input-group">
			    <span class="input-group-addon">R$</span>
				<?php 
				$valor = array('name'=>'valor', 
								'id'=>'valor',
								'class'=>'form-control', 
								'value'=>set_value('valor'));
				?>
			    <?php echo form_input($valor);
				?>
			    </div>                      
				<?php echo form_error('valor', 
			                          $this->config->item('err_msg_style'), 
			                          $this->config->item('msg_style_end')); ?>
			</div>
		</div>
		<?php
		$btn_save = $this->config->item ( 'btn_save' );
		$btn_save ['disabled'] = 'disabled';
		echo form_button ( $btn_save); 
		echo form_close();
		?>
		</div>
	</div>
</div>