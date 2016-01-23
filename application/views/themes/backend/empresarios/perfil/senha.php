<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'		=> 'old_password',
	'class' => 'form-control',	
	'size' 	=> 30,
	'value' => set_value('old_password')
);

$new_password = array(
	'name'	=> 'new_password',
	'id'		=> 'new_password',
	'class' => 'form-control',	
	'size'	=> 30
);

$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'		=> 'confirm_new_password',
	'class' => 'form-control',	
	'size' 	=> 30
);

?>
<?php echo $this->dx_auth->get_auth_error(); ?>
<?php echo form_error($old_password['name']); ?>
<?php echo form_error($new_password['name']); ?>
<?php echo form_error($confirm_new_password['name']); ?>
<div class="col-sm-8">
<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">

			<?php echo form_open("alterar_senha"); ?>
			
			<div class="form-group col-sm-4">
		        <?php echo form_label('Senha Atual', $old_password['id']); ?>
		        <?php echo form_password($old_password); ?>
		    </div>
			
			<div class="form-group col-sm-4">
		        <?php echo form_label('Nova Senha', $new_password['id']); ?>
		        <?php echo form_password($new_password); ?>
		    </div>
		    
			<div class="form-group col-sm-4">
		        <?php echo form_label('Confirmar Nova Senha', $confirm_new_password['id']); ?>
		        <?php echo form_password($confirm_new_password); ?>
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