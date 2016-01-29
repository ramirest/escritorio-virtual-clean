<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
        
<?php echo isset($msg)?$this->config->item('suc_msg_style').$msg.$this->config->item('msg_style_end'):''; ?>
<?php echo form_open('escritorio-virtual/configs/planos', array('id'=>'cria-plano','name'=>'cria-plano', 'class'=>'form')); ?>
			<div class="row">
				<div class="col-sm-12">
					<div id="table-geral_length2" class="dataTables_length">
						<?php echo form_button($this->config->item('btn_delete')); ?>            
					</div>
				</div>
			</div>
			
			<table id="table-geral"	class="table table-striped table-bordered table-hover table-green">
				<thead>
					<tr>
						<th></th>
						<th>Nome do plano</th>
						<th>Valor</th>
						<th>Ganhos no binário</th>
						<th>Pontos no binário</th>
					</tr>
				</thead>
				<tbody>                			
<?php
if(!isset($plano->pid)):
	if($planos !== FALSE):
		$i = 0;
		foreach ($planos as $p):
			$i++;
			if(($i % 2) == 0)
				$classe = 'odd';
			else
				$classe = 'even';
?>
				<tr class="<?php echo $classe; ?> gradeX">
					<td><?php echo form_checkbox('checkbox_'.$p->pid, $p->pid); ?></td>
					<td><?php echo anchor($this->uri->uri_string().'/'.$p->pid, $p->nmplano); ?></td>
					<td><?php echo 'R$ '.$p->valor_plano; ?></td>
					<td><?php echo  $p->percentual_ganho.' %'; ?></td>
					<td><?php echo $p->pontos_binario; ?></td>
				</tr>
<?php							  
		endforeach;
?>
				</tbody>
			</table>
<?php
	endif;
endif;
?>
<?php echo form_fieldset('Plano'); ?>
<?php echo form_hidden('pid', isset($plano->pid)?$plano->pid:''); ?>
<div class="form-group">
	<?php echo form_label('Nome do plano', 'nmplano'); ?>
    <?php echo form_input(array('name'=>'nmplano', 
								'id'=>'nmplano', 
								'class'=>'form-control'), isset($plano->nmplano)?$plano->nmplano:'');
	?>
</div>
<div class="row">
<div class="form-group col-sm-3">
	<?php echo form_label('Percentual de ganhos no binário', 'percentual_ganho'); ?>
	<div class="input-group">
	<?php echo form_input(array('name'=>'percentual_ganho', 
								'id'=>'percentual_ganho', 
								'class'=>'form-control'), isset($plano->percentual_ganho)?$plano->percentual_ganho:'');
	?>
	<span class="input-group-addon">%</span>
	</div>
</div>
</div>
<div class="form-group">
	<?php echo form_label('Informações ao usuário', 'info'); ?>
    <?php echo form_textarea(array('name'=>'info', 
								'id'=>'info', 
								'class'=>'form-control',
								'rows'=>10,
								'cols'=>50), isset($plano->info)?$plano->info:'');
	?>
</div>
<div class="row">
<div class="form-group col-sm-3">
	<?php echo form_label('Valor do plano', 'valor_plano'); ?>
	<div class="input-group">
	<span class="input-group-addon">R$</span>
    <?php echo form_input(array('name'=>'valor_plano', 
								'id'=>'valor_plano', 
								'class'=>'form-control'), isset($plano->valor_plano)?$plano->valor_plano:'');
	?>
	</div>
</div>
<div class="form-group col-sm-3">
	<?php echo form_label('Valor da entrada', 'valor_entrada'); ?>
	<div class="input-group">
	<span class="input-group-addon">R$</span>
	<?php echo form_input(array('name'=>'valor_entrada', 
								'id'=>'valor_entrada', 
								'class'=>'form-control'), isset($plano->valor_entrada)?$plano->valor_entrada:'');
	?>
	</div>
</div>
<div class="form-group col-sm-3">
	<?php echo form_label('Quantidade de parcelas', 'qtde_parcelas'); ?>
    <?php echo form_input(array('name'=>'qtde_parcelas', 
								'id'=>'qtde_parcelas', 
								'class'=>'form-control'), isset($plano->qtde_parcelas)?$plano->qtde_parcelas:'');
	?>
</div>
<div class="form-group col-sm-3">
	<?php echo form_label('Valor das parcelas', 'valor_parcelas'); ?>
	<div class="input-group">
	<span class="input-group-addon">R$</span>
	<?php echo form_input(array('name'=>'valor_parcelas', 
								'id'=>'valor_parcelas', 
								'class'=>'form-control'), isset($plano->valor_parcelas)?$plano->valor_parcelas:'');
	?>
	</div>
</div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        <?php echo form_label('Pontos do plano no binário', 'pontos_binario'); ?>
        <div class="input-group">
        <?php echo form_input(array('name'=>'pontos_binario',
                                    'id'=>'pontos_binario',
                                    'class'=>'form-control'), isset($plano->pontos_binario)?$plano->pontos_binario:'');
        ?>
        <span class="input-group-addon">%</span>
        </div>
    </div>
    <div class="form-group col-sm-4">
        <?php echo form_label('Pontos do plano no binário - Entrada', 'pontos_binario_entrada'); ?>
        <div class="input-group">
            <?php echo form_input(array('name'=>'pontos_binario_entrada',
                'id'=>'pontos_binario_entrada',
                'class'=>'form-control'), isset($plano->pontos_binario_entrada)?$plano->pontos_binario_entrada:'');
            ?>
            <span class="input-group-addon">%</span>
        </div>
    </div>
    <div class="form-group col-sm-4">
        <?php echo form_label('Pontos do plano no binário - Parcela', 'pontos_binario_parcela'); ?>
        <div class="input-group">
            <?php echo form_input(array('name'=>'pontos_binario_parcela',
                'id'=>'pontos_binario_parcela',
                'class'=>'form-control'), isset($plano->pontos_binario_parcela)?$plano->pontos_binario_parcela:'');
            ?>
            <span class="input-group-addon">%</span>
        </div>
    </div>
</div>
<div class="row">
<div class="form-group col-sm-4">
	<?php echo form_label('Valor mínimo para saque', 'minimo_saque'); ?>
	<div class="input-group">
	<span class="input-group-addon">R$</span>
	<?php echo form_input(array('name'=>'minimo_saque', 
								'id'=>'minimo_saque', 
								'class'=>'form-control'), isset($plano->minimo_saque)?$plano->minimo_saque:'');
	?>
	</div>
</div>
<div class="form-group col-sm-4">
	<?php echo form_label('Valor limite para saque diário', 'maximo_diario'); ?>
	<div class="input-group">
	<span class="input-group-addon">R$</span>
	<?php echo form_input(array('name'=>'maximo_diario', 
								'id'=>'maximo_diario', 
								'class'=>'form-control'), isset($plano->maximo_diario)?$plano->maximo_diario:'');
	?>
	</div>
</div>
</div>
<?php echo form_button($this->config->item('btn_save')); ?>

<?php echo form_close(); ?>
		</div>
	</div>
</div>