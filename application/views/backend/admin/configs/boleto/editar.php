<section class="grid_12">
<div class="block-border">
<?php echo $this->session->flashdata('msg')?$this->config->item('suc_msg_style').$this->session->flashdata('msg').$this->config->item('msg_style_end'):''; ?>

<?php echo isset($msg)?$msg:''; ?><br />
<?php 
$action = "escritorio-virtual/configs/boleto/".$boleto->cid;
echo form_open($action, $this->config->item('form_style')); ?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
        	<?php echo anchor($this->config->item('btn_back_url'),
							  $this->config->item('btn_back_txt'),
							  $this->config->item('btn_back_attr'));
			?>
		</div>
		
		<div class="float-right"> 
			<?php echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>'<img src="'.$this->config->item('img').'icons/fugue/tick-circle.png"> Salvar')); ?>            
		</div>
			
	</div></div>
	<!-- End control bar -->


<?php echo form_hidden("cid", $boleto->cid);?>
<?php echo form_fieldset(); ?>
<p>
	<?php echo form_label('Identifica&ccedil;&atilde;o', 'identificacao'); ?>
    <?php echo form_input(array('name'=>'identificacao', 
								'id'=>'identificacao', 
								'size'=>100), 
						  set_value('identificacao', $boleto->identificacao));
	?>
</p>
<p>
	<?php echo form_label('CNPJ', 'cnpj'); ?>
	<?php echo form_input(array('name'=>'cnpj', 
								'id'=>'cnpj', 
								'size'=>19), 
						  set_value('cpnj', $boleto->cnpj));
	?>
</p>      
<p>
	<?php echo form_label('Endere&ccedil;o', 'endereco'); ?>
	<?php echo form_input(array('name'=>'endereco', 
								'id'=>'endereco', 
								'size'=>100), 
						  set_value('endereco', $boleto->endereco));
	?>
</p>
<p>
	<?php echo form_label('Cidade-UF', 'cidade_uf'); ?>
	<?php echo form_input(array('name'=>'cidade_uf', 
								'id'=>'cidade_uf', 
								'size'=>100), 
						  set_value('cidade_uf', $boleto->cidade_uf));
	?>
    <div class="hint">Ex: Ipatinga - MG</div>
</p>
<p>
	<?php echo form_label('Raz&atilde;o Social', 'razao_social'); ?>
    <?php echo form_input(array('name'=>'razao_social', 
								'id'=>'razao_social', 
								'size'=>100), 
						  set_value('razao_social', $boleto->razao_social));
	?>
</p>
<p>
	<?php echo form_label('Dias de prazo para pagamento', 'dias_prazo_pagamento'); ?>
	<?php echo form_input(array('name'=>'dias_prazo_pagamento', 
								'id'=>'dias_prazo_pagamento', 
								'size'=>3), 
						  set_value('dias_prazo_pagamento', $boleto->dias_prazo_pagamento));
	?>    
</p>
<p>
	<?php echo form_label('Taxa do Boleto', 'taxa_boleto'); ?>
	<?php echo form_input(array('name'=>'taxa_boleto', 
								'id'=>'taxa_boleto', 
								'size'=>6), 
						  set_value('taxa_boleto', $boleto->taxa_boleto));
	?>
</p>
<p>
	<?php echo form_label('Valor', 'valor'); ?>
	<?php echo form_input(array('name'=>'valor', 
								'id'=>'valor', 
								'size'=>6), 
						  set_value('valor', $boleto->valor));
	?>
</p>
<p>
	<?php echo form_label('Demonstrativo 01', 'demonstrativo01'); ?>
	<?php echo form_input(array('name'=>'demonstrativo01', 
								'id'=>'demonstrativo01', 
								'size'=>100), 
						  set_value('demonstrativo01', $boleto->demonstrativo01));
	?>
</p>
<p>
	<?php echo form_label('Demonstrativo 02', 'demonstrativo02'); ?>
	<?php echo form_input(array('name'=>'demonstrativo02', 
								'id'=>'demonstrativo02', 
								'size'=>100), 
						  set_value('demonstrativo02', $boleto->demonstrativo02));
	?>
</p>
<p>
	<?php echo form_label('Demonstrativo 03', 'demonstrativo03'); ?>
	<?php echo form_input(array('name'=>'demonstrativo03', 
								'id'=>'demonstrativo03', 
								'size'=>100), 
						  set_value('demonstrativo03', $boleto->demonstrativo03));
	?>
</p>
<p>
	<?php echo form_label('Instru&ccedil;&otilde;es 01', 'instrucoes01'); ?>
	<?php echo form_input(array('name'=>'instrucoes01', 
								'id'=>'instrucoes01', 
								'size'=>100), 
						  set_value('instrucoes01', $boleto->instrucoes01));
	?>
</p>
<p>
	<?php echo form_label('Instru&ccedil;&otilde;es 02', 'instrucoes02'); ?>
	<?php echo form_input(array('name'=>'instrucoes02', 
								'id'=>'instrucoes02', 
								'size'=>100), 
						  set_value('instrucoes02', $boleto->instrucoes02));
	?>
</p>
<p>
	<?php echo form_label('Instru&ccedil;&otilde;es 03', 'instrucoes03'); ?>
	<?php echo form_input(array('name'=>'instrucoes03', 
								'id'=>'instrucoes03', 
								'size'=>100), 
						  set_value('instrucoes03', $boleto->instrucoes03));
	?>
</p>
<p>
	<?php echo form_label('Instru&ccedil;&otilde;es 04', 'instrucoes04'); ?>
	<?php echo form_input(array('name'=>'instrucoes04', 
								'id'=>'instrucoes04', 
								'size'=>100), 
						  set_value('instrucoes04', $boleto->instrucoes04));
	?>
</p>
<p>
	<?php echo form_label('Quantidade', 'quantidade'); ?>
	<?php echo form_input(array('name'=>'quantidade', 
								'id'=>'quantidade', 
								'size'=>11), 
						  set_value('quantidade', $boleto->quantidade));
	?>
</p>
<p>
	<?php echo form_label('Valor Unit&aacute;rio', 'valor_unitario'); ?>
	<?php echo form_input(array('name'=>'valor_unitario', 
								'id'=>'valor_unitario', 
								'size'=>11), 
						  set_value('valor_unitario', $boleto->valor_unitario));
	?>
</p>
<p>
	<?php echo form_label('Aceite', 'aceite'); ?>
	<?php echo form_input(array('name'=>'aceite', 
								'id'=>'aceite', 
								'size'=>1), 
						  set_value('aceite', $boleto->aceite));
	?>
</p>
<p>
	<?php echo form_label('Esp&eacute;cie', 'especie'); ?>
	<?php echo form_input(array('name'=>'especie', 
								'id'=>'especie', 
								'size'=>19), 
						  set_value('especie', $boleto->especie));
	?>
</p>
<p>
	<?php echo form_label('Esp&eacute;cie Doc.', 'especie_doc'); ?>
	<?php echo form_input(array('name'=>'especie_doc', 
								'id'=>'especie_doc', 
								'size'=>19), 
						  set_value('especie_doc', $boleto->especie_doc));
	?>
</p>

<p>
	<?php echo form_label('Ag&ecirc;ncia', 'agencia'); ?>
	<?php echo form_input(array('name'=>'agencia', 
								'id'=>'agencia', 
								'size'=>19), 
						  set_value('agencia', $boleto->agencia));
	?>
</p>
<p>
	<?php echo form_label('Conta', 'conta'); ?>
	<?php echo form_input(array('name'=>'conta', 
								'id'=>'conta', 
								'size'=>19), 
						  set_value('conta', $boleto->conta));
	?>
</p>
<p>
	<?php echo form_label('D&iacute;gito Conta', 'conta_dv'); ?>
	<?php echo form_input(array('name'=>'conta_dv', 
								'id'=>'conta_dv', 
								'size'=>19), 
						  set_value('conta_dv', $boleto->conta_dv));
	?>
</p>
<p>
	<?php echo form_label('Conta Cedente', 'conta_cedente'); ?>
	<?php echo form_input(array('name'=>'conta_cedente', 
								'id'=>'conta_cedente', 
								'size'=>19), 
						  set_value('conta_cedente', $boleto->conta_cedente));
	?>
</p>
<p>
	<?php echo form_label('Carteira', 'carteira'); ?>
	<?php echo form_input(array('name'=>'carteira', 
								'id'=>'carteira', 
								'size'=>19), 
						  set_value('carteira', $boleto->carteira));
	?>
</p>
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
</div>
</section>