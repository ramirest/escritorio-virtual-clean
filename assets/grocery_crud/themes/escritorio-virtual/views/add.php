<?php
$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/pace/pace.css');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/pace/pace.js');

$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/bootstrap/css/bootstrap.min.css');
$this->set_css('https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic', FALSE);
$this->set_css('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800', FALSE);
$this->set_css($this->default_theme_path.'/escritorio-virtual/icons-flex/font-awesome/css/font-awesome.min.css');

$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/messenger/messenger.css');
$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/messenger/messenger-theme-flat.css');
$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/messenger/messenger-theme-block.css');

$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/style.css');
$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins.css');


if (!$this->is_IE7()) {
    $this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/html5shiv.js');
    $this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/respond.min.js');
}

$this->set_js('https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', FALSE);
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/jquery-migrate-1.2.1.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/bootstrap/bootstrap.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/slimscroll/jquery.slimscroll.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/popupoverlay/jquery.popupoverlay.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/popupoverlay/defaults.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/eldarion-ajax.min.js');
$this->set_js_lib($this->default_theme_path.'/escritorio-virtual/js/jquery.form.js');


$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/popupoverlay/logout.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/hisrc/hisrc.js');

$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/messenger/messenger.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/messenger/messenger-theme-flat.js');

$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/flex.js');

//CONFIGURAÇÕES
$this->set_js($this->default_theme_path.'/escritorio-virtual/js/app/twitter-bootstrap-add.js');
//	JAVASCRIPTS - JQUERY-FUNCTIONS
$this->set_js($this->default_theme_path.'/escritorio-virtual/js/jquery.functions.js');
?>
<h3><?php echo $this->l('form_add'); ?> <?php echo $subject?></h3>

<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">

                <!-- CONTENT FOR ALERT MESSAGES -->
                <div id="message-box"></div>
                <?php
                echo form_open( $insert_url, 'method="post" id="crudForm" autocomplete="off" enctype="multipart/form-data" role="form"' );
                    foreach($fields as $field)
                    {
                        ?>
                        <div class="row">
                            <div class="form-group col-sm-12" id="<?php echo $field->field_name; ?>_field">
                                <?php echo form_label($input_fields[$field->field_name]->display_as); ?><?php echo ($input_fields[$field->field_name]->required)? '<i class="text-danger"> *</i>' : ""; ?>
                                <?php echo $input_fields[$field->field_name]->input; ?>
                            </div>
                        </div>
                            <?php
                    }
                    //	Hidden Elements
                    foreach($hidden_fields as $hidden_field){
                        echo $hidden_field->input;
                    }
                    ?>

                    <input type="button" value="<?php echo $this->l('form_save'); ?>"  class="btn btn-large btn-primary submit-form"/>
                    <?php 	if(!$this->unset_back_to_list) { ?>
                        <input type="button" value="<?php echo $this->l('form_save_and_go_back'); ?>" id="save-and-go-back-button"  class="btn btn-large btn-primary"/>
                        <input type="button" value="<?php echo $this->l('form_cancel'); ?>" class="btn btn-large return-to-list" />
                    <?php 	} ?>

                    <div class="hide" id="ajax-loading">
                        <p><?php echo $this->l('form_update_loading'); ?></p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
	var validation_url = "<?php echo $validation_url?>",
		list_url = "<?php echo $list_url?>",
		message_alert_add_form = "<?php echo $this->l('alert_add_form')?>",
		message_insert_error = "<?php echo $this->l('insert_error')?>";
</script>