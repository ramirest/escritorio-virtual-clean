<div class="portlet portlet-default">
	<div class="portlet-body">
		<div class="table-responsive">
        	<?php echo form_open($this->uri->uri_string(), $this->config->item('form_style')); ?>
			<div class="row">
				<div class="col-sm-4">
					<div id="table-geral_length2" class="dataTables_length">
						<?php echo form_button($this->config->item('btn_delete')); ?>			
					</div>
				</div>
				<div class="col-sm-8">
					<div id="table-geral_length2" class="dataTables_length">
						<?php 
							$options[0] = 'Nenhum';
							foreach ($roles as $role)
							{
								$options[$role->id] = $role->name;
							}						
						?>					
						<?php echo form_label('Regra pai', 'role_parent_label'); ?>			
						<?php echo form_dropdown('role_parent', $options, '', 'class="full-width"'); ?>            								
						<?php echo form_label('Nome da regra', 'role_name_label'); ?>			
						<?php echo form_input('role_name', '', 'class="full-width"') ?>            								
						<?php echo form_button($this->config->item('btn_add')); ?>            								
					</div>
				</div>				
			</div>
			<table id="table-geral"
				class="table table-striped table-bordered table-hover table-green">
				<thead>
					<tr>
						<th></th>
						<th>Código</th>
						<th>Nome</th>
						<th>Regra Pai</th>
					</tr>
				</thead>
				<tbody>                
				<?php  							
				// Show reset password message if exist
				if (isset($reset_message))
					echo $this->config->item('ale_msg_style') . $reset_message . $this->config->item('msg_style_end');
				
				// Show error
				echo validation_errors();
				$i = 0;
				foreach ($roles as $role):
				$options[$role->id] = $role->name;
				$i++;
				if(($i % 2) == 0)
					$classe = 'odd';
				else
					$classe = 'even';
				
				?>
					<tr class="<?php echo $classe; ?> gradeX">
						<td><?php echo form_checkbox('checkbox_'.$role->id, $role->id); ?></td>
						<td><?php echo $role->id; ?></td>
						<td><?php echo $role->name; ?></td>
						<td><?php echo $role->parent_id; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
