<div class="col-sm-8">
<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
			<?php echo form_open("escritorio-virtual/empresarios/salvar/endereco/$associado->aid", $this->config->item('form_style')); ?>
			<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
			
			<div class="form-group col-sm-3">			
		        <?php echo form_label('Tipo', 'tipo'); ?>
		        <?php echo form_dropdown('tipo', $tipos, set_value('tipo', $associado->tp_endereco), 'class="form-control"'); ?>
				<?php echo form_error('tipo', '<div class="erro">', '</div>'); ?>			
			</div>
			
			<div class="form-group col-sm-3">
		        <?php echo form_label('CEP', 'cep'); ?>
				<?php
		        $cep = array(
		                    'name'=>'cep',
		                    'id'=>'cep',
		                    'data-conditional'=>'cep',
		                    'value'=>set_value('cep', $associado->cep),
		                    'class'=>'form-control');
		        ?>
		        <?php echo form_input($cep); ?>			
				<?php echo form_error('cep', '<div class="erro">', '</div>'); ?>			
			</div>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Endereço', 'logradouro'); ?>
				<?php
					$logradouro = array(
									'name'=>'logradouro',
									'id'=>'logradouro',
									'value'=>set_value('logradouro', $associado->logradouro),
		                    		'class'=>'form-control');
		        ?>
		        <?php echo form_input($logradouro); ?>			
				<?php echo form_error('logradouro', '<div class="erro">', '</div>'); ?>				
			</div>
			
			<div class="form-group col-sm-2">
				<?php echo form_label('Número'); ?>				
	            <?php
	                $numero = array(
	                            'name'=>'numero',
	                            'id'=>'numero',
	                            'value'=>set_value('numero', $associado->numero),
	                    		'class'=>'form-control');
	            ?>
	            <?php echo form_input($numero); ?>				
				<?php echo form_error('numero', '<div class="erro">', '</div>'); ?>				
			</div>
			
			<div class="form-group col-sm-2">
				<?php echo form_label('Complemento'); ?>				
	            <?php
	            	$complemento = array(
										'name'=>'complemento',
										'id'=>'complemento',
										'value'=>set_value('complemento', $associado->complemento),
	                    				'class'=>'form-control');
				?>
	            <?php echo form_input($complemento); ?>				
			</div>
			
			<div class="form-group col-sm-3">
				<?php echo form_label('Bairro'); ?>
				<?php
					$bairro = array(
								'name'=>'bairro',
								'id'=>'bairro',
								'value'=>set_value('bairro', $associado->bairro),
		                    	'class'=>'form-control');
		        ?>
		        <?php echo form_input($bairro); ?>				
				<?php echo form_error('bairro', '<div class="erro">', '</div>'); ?>				
			</div>
			
			<div class="form-group col-sm-3">
				<?php echo form_label('Cidade'); ?>
	            <?php
	                $cidade = array(
	                            'name'=>'cidade',
	                            'id'=>'cidade',
	                            'value'=>set_value('cidade', $associado->cidade),
	                    		'class'=>'form-control');
	            ?>
	            <?php echo form_input($cidade); ?>				
				<?php echo form_error('cidade', '<div class="erro">', '</div>'); ?>				
			</div>
			
			<div class="form-group col-sm-2">
				<?php echo form_label('Estado'); ?>
		        <?php echo form_dropdown('estado', $estados, set_value('estado', $associado->estado), 'class="form-control" id="estado"'); ?>
		    	<?php echo form_error('estado', '<div class="erro">', '</div>'); ?>				
			</div>
        
			<?php echo form_button($this->config->item('btn_save')); ?>              
			<?php echo form_close(); ?>
			
		</div>
	</div>
</div>
</div>
<div class="col-sm-4">
<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
        <?php echo $submenu; ?>
		</div>
	</div>
</div>		
</div>		