<?php		 					
// Show error
echo validation_errors();

// Build drop down menu
$options[0] = 'None';
foreach ($roles as $role)
{
	$options[$role->id] = $role->name;
}

// Build table
$this->table->set_template($this->config->item('table_template'));
$this->table->set_heading('', 'C&oacute;digo', 'Nome', 'Regra Pai');

foreach ($roles as $role):
	$this->table->add_row(form_checkbox('checkbox_'.$role->id, $role->id), 
						  $role->id, 
						  $role->name, 
						  $role->parent_id);
endforeach;

// Build form
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
			<?php echo form_button($this->config->item('btn_delete')); ?>			
			<?php echo form_button($this->config->item('btn_add')); ?>            
		</div>
			
	</div></div>
	<!-- End control bar -->
<?php

echo '<hr/>';

echo '<div class="colums">';
	echo '<div class="colx3-left">';
		echo form_label('Regra pai', 'role_parent_label');
		echo form_dropdown('role_parent', $options, '', 'class="full-width"'); 
	echo '</div>';
	echo '<div class="colx3-center">';
		echo form_label('Nome da regra', 'role_name_label');
		echo form_input('role_name', '', 'class="full-width"'); 
	echo '</div>';
echo '</div>';
		
// Show table
echo $this->table->generate(); 

echo form_close();
	
?>
