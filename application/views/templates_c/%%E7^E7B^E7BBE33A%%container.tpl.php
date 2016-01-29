<?php /* Smarty version 2.6.25-dev, created on 2016-01-27 16:09:44
         compiled from container.tpl */ ?>
<?php if (( $this->_tpl_vars['page_login'] ) && ( $this->_tpl_vars['page_login'] == TRUE )): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['pagina']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
    <?php if ($this->_tpl_vars['crud']): ?>
        <?php 
            //	JAVASCRIPTS - JQUERY LAZY-LOAD
            $this->set_js_lib($this->default_javascript_path.'/common/lazyload-min.js');

            if (!$this->is_IE7()) {
            $this->set_js_lib($this->default_javascript_path.'/common/list.js');
            }
            //	JAVASCRIPTS - TWITTER BOOTSTRAP
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/libs/bootstrap/application.js');
            //	JAVASCRIPTS - MODERNIZR
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/libs/modernizr/modernizr-2.6.1.custom.js');
            //	JAVASCRIPTS - TABLESORTER
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/libs/tablesorter/jquery.tablesorter.min.js');
            //	JAVASCRIPTS - JQUERY-COOKIE
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/cookies.js');
            //	JAVASCRIPTS - JQUERY-FORM
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/jquery.form.js');
            //	JAVASCRIPTS - JQUERY-NUMERIC
            $this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.numeric.min.js');
            //	JAVASCRIPTS - JQUERY-PRINT-ELEMENT
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/libs/print-element/jquery.printElement.min.js');
            //	JAVASCRIPTS - JQUERY FANCYBOX
            $this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.fancybox-1.3.4.js');
            //	JAVASCRIPTS - JQUERY EASING
            $this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.easing-1.3.pack.js');

            //	JAVASCRIPTS - twitter-bootstrap - CONFIGURAÇÕES
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/app/twitter-bootstrap.js');
            //	JAVASCRIPTS - JQUERY-FUNCTIONS
            $this->set_js($this->default_theme_path.'/twitter-bootstrap/js/jquery.functions.js');
         ?>
    <?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cabecalho.tpl", 'smarty_include_vars' => array('titulo' => ($this->_tpl_vars['titulo']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "conteudo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
