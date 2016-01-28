{if ($page_login) && ($page_login eq TRUE)}
    {include file="$pagina"}
{else}
    {if $crud }
        {php}
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
        {/php}
    {/if}
{include file="cabecalho.tpl" titulo="$titulo"}
{include file="conteudo.tpl"}
{/if}

