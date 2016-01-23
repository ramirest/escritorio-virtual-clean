<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">

<?php echo $this->session->flashdata('msg')?$this->config->item('suc_msg_style').$this->session->flashdata('msg').$this->config->item('msg_style_end'):''; ?>

<?php echo isset($msg)?$msg:''; ?><br />
<?php 
$action = "escritorio-virtual/configs/boleto/".$boleto->cid;
echo form_open($action, $this->config->item('form_style')); ?>

<?php echo form_hidden("cid", $boleto->cid);?>
<?php echo form_fieldset(); ?>
<div class="form-group">
	<?php echo form_label('Identifica&ccedil;&atilde;o', 'identificacao'); ?>
    <?php echo form_input(array('name'=>'identificacao', 
								'id'=>'identificacao',
    							'class'=>'form-control'), 
						  set_value('identificacao', $boleto->identificacao));
	?>
</div>
<div class="form-group">
	<?php echo form_label('CNPJ', 'cnpj'); ?>
	<?php echo form_input(array('name'=>'cnpj', 
								'id'=>'cnpj',
    							'class'=>'form-control'), 
						  set_value('cpnj', $boleto->cnpj));
	?>
</div>      
<div class="form-group">
	<?php echo form_label('Endere&ccedil;o', 'endereco'); ?>
	<?php echo form_input(array('name'=>'endereco', 
								'id'=>'endereco',
    							'class'=>'form-control'), 
						  set_value('endereco', $boleto->endereco));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Cidade-UF', 'cidade_uf'); ?>
	<?php echo form_input(array('name'=>'cidade_uf', 
								'id'=>'cidade_uf',
    							'class'=>'form-control'), 
						  set_value('cidade_uf', $boleto->cidade_uf));
	?>
    <div class="hint">Ex: Ipatinga - MG</div>
</div>
<div class="form-group">
	<?php echo form_label('Raz&atilde;o Social', 'razao_social'); ?>
    <?php echo form_input(array('name'=>'razao_social', 
								'id'=>'razao_social',
    							'class'=>'form-control'), 
						  set_value('razao_social', $boleto->razao_social));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Dias de prazo para pagamento', 'dias_prazo_pagamento'); ?>
	<?php echo form_input(array('name'=>'dias_prazo_pagamento', 
								'id'=>'dias_prazo_pagamento',
    							'class'=>'form-control'), 
						  set_value('dias_prazo_pagamento', $boleto->dias_prazo_pagamento));
	?>    
</div>
<div class="form-group">
	<?php echo form_label('Taxa do Boleto', 'taxa_boleto'); ?>
	<?php echo form_input(array('name'=>'taxa_boleto', 
								'id'=>'taxa_boleto',
    							'class'=>'form-control'), 
						  set_value('taxa_boleto', $boleto->taxa_boleto));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Valor', 'valor'); ?>
	<?php echo form_input(array('name'=>'valor', 
								'id'=>'valor',
    							'class'=>'form-control'), 
						  set_value('valor', $boleto->valor));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Demonstrativo 01', 'demonstrativo01'); ?>
	<?php echo form_input(array('name'=>'demonstrativo01', 
								'id'=>'demonstrativo01',
    							'class'=>'form-control'), 
						  set_value('demonstrativo01', $boleto->demonstrativo01));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Demonstrativo 02', 'demonstrativo02'); ?>
	<?php echo form_input(array('name'=>'demonstrativo02', 
								'id'=>'demonstrativo02',
    							'class'=>'form-control'), 
						  set_value('demonstrativo02', $boleto->demonstrativo02));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Demonstrativo 03', 'demonstrativo03'); ?>
	<?php echo form_input(array('name'=>'demonstrativo03', 
								'id'=>'demonstrativo03',
    							'class'=>'form-control'), 
						  set_value('demonstrativo03', $boleto->demonstrativo03));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Instru&ccedil;&otilde;es 01', 'instrucoes01'); ?>
	<?php echo form_input(array('name'=>'instrucoes01', 
								'id'=>'instrucoes01',
    							'class'=>'form-control'), 
						  set_value('instrucoes01', $boleto->instrucoes01));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Instru&ccedil;&otilde;es 02', 'instrucoes02'); ?>
	<?php echo form_input(array('name'=>'instrucoes02', 
								'id'=>'instrucoes02',
    							'class'=>'form-control'), 
						  set_value('instrucoes02', $boleto->instrucoes02));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Instru&ccedil;&otilde;es 03', 'instrucoes03'); ?>
	<?php echo form_input(array('name'=>'instrucoes03', 
								'id'=>'instrucoes03',
    							'class'=>'form-control'), 
						  set_value('instrucoes03', $boleto->instrucoes03));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Instru&ccedil;&otilde;es 04', 'instrucoes04'); ?>
	<?php echo form_input(array('name'=>'instrucoes04', 
								'id'=>'instrucoes04',
    							'class'=>'form-control'), 
						  set_value('instrucoes04', $boleto->instrucoes04));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Quantidade', 'quantidade'); ?>
	<?php echo form_input(array('name'=>'quantidade', 
								'id'=>'quantidade',
    							'class'=>'form-control'), 
						  set_value('quantidade', $boleto->quantidade));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Valor Unit&aacute;rio', 'valor_unitario'); ?>
	<?php echo form_input(array('name'=>'valor_unitario', 
								'id'=>'valor_unitario',
    							'class'=>'form-control'), 
						  set_value('valor_unitario', $boleto->valor_unitario));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Aceite', 'aceite'); ?>
	<?php echo form_input(array('name'=>'aceite', 
								'id'=>'aceite',
    							'class'=>'form-control'), 
						  set_value('aceite', $boleto->aceite));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Esp&eacute;cie', 'especie'); ?>
	<?php echo form_input(array('name'=>'especie', 
								'id'=>'especie',
    							'class'=>'form-control'), 
						  set_value('especie', $boleto->especie));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Esp&eacute;cie Doc.', 'especie_doc'); ?>
	<?php echo form_input(array('name'=>'especie_doc', 
								'id'=>'especie_doc',
    							'class'=>'form-control'), 
						  set_value('especie_doc', $boleto->especie_doc));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Ag&ecirc;ncia', 'agencia'); ?>
	<?php echo form_input(array('name'=>'agencia', 
								'id'=>'agencia',
    							'class'=>'form-control'), 
						  set_value('agencia', $boleto->agencia));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Conta', 'conta'); ?>
	<?php echo form_input(array('name'=>'conta', 
								'id'=>'conta',
    							'class'=>'form-control'), 
						  set_value('conta', $boleto->conta));
	?>
</div>
<div class="form-group">
	<?php echo form_label('D&iacute;gito Conta', 'conta_dv'); ?>
	<?php echo form_input(array('name'=>'conta_dv', 
								'id'=>'conta_dv',
    							'class'=>'form-control'), 
						  set_value('conta_dv', $boleto->conta_dv));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Conta Cedente', 'conta_cedente'); ?>
	<?php echo form_input(array('name'=>'conta_cedente', 
								'id'=>'conta_cedente',
    							'class'=>'form-control'), 
						  set_value('conta_cedente', $boleto->conta_cedente));
	?>
</div>
<div class="form-group">
	<?php echo form_label('Carteira', 'carteira'); ?>
	<?php echo form_input(array('name'=>'carteira', 
								'id'=>'carteira',
    							'class'=>'form-control'), 
						  set_value('carteira', $boleto->carteira));
	?>
</div>
<?php echo form_button($this->config->item('btn_save')); ?>

<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
</div>
</div>
</div>