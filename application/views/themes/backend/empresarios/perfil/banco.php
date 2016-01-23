<div class="col-sm-8">
<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
			<?php echo form_open("escritorio-virtual/empresarios/salvar/banco/$associado->aid", $this->config->item('form_style')); ?>
			<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Titular da conta'); ?>
		        <?php 		        
		        $titular = array(
								'name'=>'titular',
								'id'=>'titular',
								'value'=>set_value('titular', $associado->titular),
								'class'=>'form-control');
		        
		        ?>		        
		        <?php echo form_input($titular); ?>
			</div>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Banco'); ?>
		        <?php echo form_dropdown('banco', $bancos, set_value('banco', $associado->banco), 'class="form-control"'); ?>		        
			</div>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Tipo de conta'); ?>
		        <?php echo form_dropdown('tpconta', $tpconta, set_value('tpconta', $associado->tpconta), 'class="form-control"'); ?>		        
			</div>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Agência'); ?>
		        <?php 		        
		        $agencia = array(
								'name'=>'agencia',
								'id'=>'agencia',
								'value'=>set_value('agencia', $associado->agencia),
								'class'=>'form-control');
		        
		        ?>		        
		        <?php echo form_input($agencia); ?>
			</div>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Conta'); ?>
		        <?php 		        
		        $conta = array(
								'name'=>'conta',
								'id'=>'conta',
								'value'=>set_value('conta', $associado->conta),
								'class'=>'form-control');
		        
		        ?>		        
		        <?php echo form_input($conta); ?>
			</div>
			
			<div class="form-group col-sm-6">			
		        <?php echo form_label('Operação'); ?>
		        <?php 		        
		        $op = array(
								'name'=>'op',
								'id'=>'op',
								'value'=>set_value('op', $associado->op),
								'class'=>'form-control');
		        
		        ?>		        
		        <?php echo form_input($op); ?>
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