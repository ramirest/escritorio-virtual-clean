<div class="portlet portlet-default">
	<div class="portlet-body">
		<div class="table-responsive">
        	<?php echo form_open($this->uri->uri_string(), $this->config->item('form_style')); ?>
					<div class="row">
						<div class="col-sm-12">
							<div id="table-geral_length2" class="dataTables_length">
								<?php echo form_button($this->config->item('btn_ban')); ?>
								<?php echo form_button($this->config->item('btn_unban')); ?>
								<?php echo form_button($this->config->item('btn_reset_pass')); ?>                									
							</div>
						</div>
					</div>		
					<table id="table-geral"
				class="table table-striped table-bordered table-hover table-green">
				<thead>
					<tr>
						<th></th>
						<th>Login</th>
						<th>Email</th>
						<th>Papel</th>
						<th>Bloqueado</th>
						<th>Último IP</th>
						<th>Último Login</th>
						<th>Criado em</th>
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
				foreach ($users as $user): 
				$i++;
				if(($i % 2) == 0)
					$classe = 'odd';
				else
					$classe = 'even';
				
				$banned = ($user->banned == 1) ? 'Sim' : 'Não';				
				?>
					<tr class="<?php echo $classe; ?> gradeX">
						<td><?php echo form_checkbox('checkbox_'.$user->id, $user->id); ?></td>
						<td><?php echo $user->username; ?></td>
						<td><?php echo $user->email; ?></td>
						<td><?php echo $user->role_name; ?></td>
						<td><?php echo $banned; ?></td>
						<td><?php echo $user->last_ip; ?></td>
						<td><?php echo date('d/m/Y', strtotime($user->last_login)); ?></td>
						<td><?php echo date('d/m/Y', strtotime($user->created)); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
