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

$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/datatables/datatables.css');

$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/ladda/ladda-themeless.min.css');
$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/bootstrap-social/bootstrap-social.css');
$this->set_css($this->default_theme_path.'/escritorio-virtual/css-flex/plugins/bootstrap-multiselect/bootstrap-multiselect.css');


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
//	JAVASCRIPTS - JQUERY-COOKIE
$this->set_js($this->default_theme_path.'/escritorio-virtual/js/cookies.js');
//	JAVASCRIPTS - JQUERY-FORM
$this->set_js($this->default_theme_path.'/escritorio-virtual/js/jquery.form.js');
//	JAVASCRIPTS - JQUERY-NUMERIC
$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.numeric.min.js');
//	JAVASCRIPTS - JQUERY-PRINT-ELEMENT
$this->set_js($this->default_theme_path.'/escritorio-virtual/js/libs/print-element/jquery.printElement.min.js');

$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/popupoverlay/logout.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/hisrc/hisrc.js');

$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/messenger/messenger.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/messenger/messenger-theme-flat.js');

$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/datatables/jquery.dataTables.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/datatables/datatables-bs3.js');

$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/ladda/spin.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/ladda/ladda.min.js');
$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/plugins/bootstrap-multiselect/bootstrap-multiselect.js');


$this->set_js($this->default_theme_path.'/escritorio-virtual/js-flex/flex.js');

//CONFIGURAÇÕES
$this->set_js($this->default_theme_path.'/escritorio-virtual/js/app/twitter-bootstrap.js');
?>

<script type="text/javascript">
	var base_url = "<?php echo base_url();?>",
		subject = "<?php echo $subject?>",
		ajax_list_info_url = "<?php echo $ajax_list_info_url?>",
		unique_hash = "<?php echo $unique_hash; ?>",
		message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";
</script>

<!-- UTILIZADO PARA IMPRESSÃO DA LISTAGEM -->
<div id="hidden-operations"></div>

<div class="twitter-bootstrap">
	<div id="main-table-box">
		<br/>
		<div id="options-content" class="span12">
			<?php
			if(!$unset_add || !$unset_export || !$unset_print){?>
				<?php if(!$unset_add){?>
					<a href="<?php echo $add_url?>" title="<?php echo $this->l('list_add'); ?> <?php echo $subject?>" class="btn btn-white btn-square">
						<i class="fa fa-plus"></i>
						<?php echo $this->l('list_add'); ?> <?php echo $subject?>
					</a>
	 			<?php
	 			}
	 			if(!$unset_export) { ?>
		 			<a class="btn btn-white btn-square export-anchor" data-url="<?php echo $export_url; ?>" rel="external">
		 				<i class="fa fa-download"></i>
		 				<?php echo $this->l('list_export');?>
		 			</a>
	 			<?php
	 			}
	 			if(!$unset_print) { ?>
		 			<a class="btn btn-white btn-square print-anchor" data-url="<?php echo $print_url; ?>">
		 				<i class="fa fa-print"></i>
		 				<?php echo $this->l('list_print');?>
		 			</a>
	 			<?php
	 			}
	 		} ?>
 			<a class="btn btn-white btn-square" data-toggle="modal" href="#filtering-form-search" >
 				<i class="fa fa-search"></i>
 				<?php echo $this->l('list_search');?>
 			</a>
 		</div>
		<br/>

		<!-- CONTENT FOR ALERT MESSAGES -->
        <div class="alert alert-success alert-dismissable <?php echo ($success_message !== null) ? '' : 'hide'; ?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo ($success_message !== null) ? $success_message : ''; ?>
        </div>

		<div id="ajax_list">
			<?php echo $list_view; ?>
		</div>

		<div class="pGroup span12">
			<select name="tb_per_page" id="tb_per_page">
				<?php foreach($paging_options as $option){?>
					<option value="<?php echo $option; ?>" <?php echo ($option == $default_per_page) ? 'selected="selected"' : ''; ?> ><?php echo $option; ?></option>
				<?php }?>
			</select>

			<span class="pPageStat">
				<?php
				$paging_starts_from = '<span id="page-starts-from">1</span>';
				$paging_ends_to = '<span id="page-ends-to">'. ($total_results < $default_per_page ? $total_results : $default_per_page) .'</span>';
				$paging_total_results = '<span id="total_items" class="badge badge-info">'.$total_results.'</span>';
				echo str_replace( array('{start}','{end}','{results}'), array($paging_starts_from, $paging_ends_to, $paging_total_results), $this->l('list_displaying')); ?>
			</span>

			<span class="pcontrol">
				<?php echo $this->l('list_page'); ?>
				<input name="tb_crud_page" type="text" value="1" size="4" id="tb_crud_page">
				<?php echo $this->l('list_paging_of'); ?>
				<span id="last-page-number"><?php echo ceil($total_results / $default_per_page); ?></span>
			</span>

            <div class="hide" id="ajax-loading">
                <p><?php echo $this->l('form_update_loading'); ?></p>
                <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
                </div>
            </div>

			<ul class="pager">
				<li class="previous first-button"><a href="javascript:void(0);">&laquo; <?php echo $this->l('list_paging_first'); ?></a></li>
				<li class="prev-button"><a href="javascript:void(0);">&laquo; <?php echo $this->l('list_paging_previous'); ?></a></li>
				<li class="next-button"><a href="javascript:void(0);"><?php echo $this->l('list_paging_next'); ?> &raquo;</a></li>
				<li class="next last-button"><a href="javascript:void(0);"><?php echo $this->l('list_paging_last'); ?> &raquo;</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="modal fade" id="filtering-form-search" tabindex="-1" role="dialog" aria-labelledby="form-searchLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open( $ajax_list_url, 'method="post" id="filtering_form" autocomplete = "off"'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="form-searchLabel"><?php echo $this->l('list_search') . ' ' . $subject; ?></h4>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="page" value="1" size="4" id="crud_page">
                        <input type="hidden" name="per_page" id="per_page" value="<?php echo $default_per_page; ?>" />
                        <input type="hidden" name="order_by[0]" id="hidden-sorting" value="<?php if(!empty($order_by[0])){?><?php echo $order_by[0]?><?php }?>" />
                        <input type="hidden" name="order_by[1]" id="hidden-ordering"  value="<?php if(!empty($order_by[1])){?><?php echo $order_by[1]?><?php }?>"/>

                        <?php echo $this->l('list_search');?>: <input type="text" class="qsbsearch_fieldox" name="search_text" size="30" id="search_text">
                        <select name="search_field" id="search_field">
                            <option value=""><?php echo $this->l('list_search_all');?></option>
                            <?php foreach($columns as $column){?>
                                <option value="<?php echo $column->field_name?>"><?php echo $column->display_as; ?></option>
                            <?php }?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" data-dismiss="modal" value="<?php echo $this->l('list_search');?>" id="crud_search">
                <input type="button" class="btn btn-inverse" data-dismiss="modal" value="<?php echo $this->l('list_clear_filtering');?>" id="search_clear">
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>