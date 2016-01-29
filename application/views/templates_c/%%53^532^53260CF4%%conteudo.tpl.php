<?php /* Smarty version 2.6.25-dev, created on 2016-01-28 16:09:16
         compiled from conteudo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ci_config', 'conteudo.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_ci_config(array('name' => 'assets'), $this);?>


<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <div class="sidebar-menu">


        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="index.html">
                    <img src="<?php echo $this->_tpl_vars['assets']; ?>
images/logo@2x.png" width="120" alt="" />
                </a>
            </div>

            <!-- logo collapse icon -->

            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                    <i class="entypo-menu"></i>
                </a>
            </div>



            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                    <i class="entypo-menu"></i>
                </a>
            </div>

        </header>






        <ul id="main-menu" class="">
            <!-- add class "multiple-expanded" to allow multiple submenus to open -->
            <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
            <!-- Search Bar -->
            <li id="search">
                <form method="get" action="">
                    <input type="text" name="q" class="search-input" placeholder="Search something..."/>
                    <button type="submit">
                        <i class="entypo-search"></i>
                    </button>
                </form>
            </li>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </ul>

    </div>
    <div class="main-content">
        <h2>Here starts everything...</h2>

        <br />

        <!-- lets do some work here... --><!-- Footer -->
        <footer class="main">


            &copy; 2014 <strong>Neon</strong> Admin Theme by <a href="http://laborator.co" target="_blank">Laborator</a>

        </footer>	</div>


</div>




<!-- Bottom Scripts -->
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/gsap/main-gsap.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/bootstrap.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/joinable.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/resizeable.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/neon-api.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/neon-custom.js"></script>
<script src="<?php echo $this->_tpl_vars['assets']; ?>
js/neon-demo.js"></script>

</body>
</html>