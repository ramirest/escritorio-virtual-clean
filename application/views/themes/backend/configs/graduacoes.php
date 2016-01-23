<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">       

<?php echo isset($msg)?$this->config->item('suc_msg_style').$msg.$this->config->item('msg_style_end'):''; ?>
<?php echo form_open('escritorio-virtual/configs/graduacoes', array('id'=>'cria-graduacao','name'=>'cria-graduacao', 'class'=>'form')); ?>
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
						<th>Nome da graduação</th>
						<th>Pontos</th>
					</tr>
				</thead>
				<tbody>                			
			
<?php
if(!isset($graduacao->gid)):
	if($graduacoes !== FALSE):
	$i = 0;
	foreach ($graduacoes as $g):
	$i++;
	if(($i % 2) == 0)
		$classe = 'odd';
	else
		$classe = 'even';
?>
				<tr class="<?php echo $classe; ?> gradeX">
					<td><?php echo form_checkbox('checkbox_'.$g->gid, $g->gid); ?></td>
					<td><?php echo anchor($this->uri->uri_string().'/'.$g->gid, $g->nmgraduacao); ?></td>
					<td><?php echo $g->pontos; ?></td>
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
<?php echo form_fieldset('Graduação'); ?>
<?php echo form_hidden('gid', isset($graduacao->gid)?$graduacao->gid:''); ?>
<div class="row">
<div class="form-group col-sm-6">
	<?php echo form_label('Nome da graduação', 'nmgraduacao'); ?>
    <?php echo form_input(array('name'=>'nmgraduacao', 
								'id'=>'nmgraduacao', 
								'class'=>'form-control'), isset($graduacao->nmgraduacao)?$graduacao->nmgraduacao:'');
	?>
</div>
<div class="form-group col-sm-6">
	<?php echo form_label('Pontos', 'pontos'); ?>
    <?php echo form_input(array('name'=>'pontos', 
								'id'=>'pontos', 
								'class'=>'form-control'), isset($graduacao->pontos)?$graduacao->pontos:'');
	?>
</div>
</div>
<?php echo form_button($this->config->item('btn_save')); ?>

<?php echo form_close(); ?>
		</div>
	</div>
</div>