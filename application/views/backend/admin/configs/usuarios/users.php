<?php  				
// Show reset password message if exist
if (isset($reset_message))
	echo $this->config->item('ale_msg_style') . $reset_message . $this->config->item('msg_style_end');

// Show error
echo validation_errors();

$this->table->set_template($this->config->item('table_template'));
$this->table->set_heading('', 'Usu&aacute;rio', 'Email', 'Papel', 'Bloqueado', '&Uacute;ltimo IP', '&Uacute;ltimo login', 'Criado em');

foreach ($users as $user): 
	$banned = ($user->banned == 1) ? 'Sim' : 'N&atilde;o';
	
	$this->table->add_row(
		form_checkbox('checkbox_'.$user->id, $user->id),
		$user->username, 
		$user->email, 
		$user->role_name, 			
		$banned, 
		$user->last_ip,
		date('d/m/Y', strtotime($user->last_login)),
		date('d/m/Y', strtotime($user->created)));
		
endforeach;

echo form_open($this->uri->uri_string(), $this->config->item('form_style'));
?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
        	<?php echo anchor($this->config->item('btn_back_url'),
							  $this->config->item('btn_back_txt'),
							  $this->config->item('btn_back_attr'));
			?>
		</div>
		
		<div class="float-right">
			<?php echo form_button($this->config->item('btn_ban')); ?>			
			<?php echo form_button($this->config->item('btn_unban')); ?>            
			<?php echo form_button($this->config->item('btn_reset_pass')); ?>            
		</div>
			
	</div></div>
	<!-- End control bar -->
<?php
		
echo '<hr/>';

echo $this->table->generate(); 

echo form_close();

echo $pagination;
	
?>
