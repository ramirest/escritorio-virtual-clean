<?php echo $this->session->flashdata('msg'); ?>
<div class="menu">
    <ul>
        <li><a href="<?php echo site_url("empresa"); ?>" title="A Empresa" class="menu_empresa"></a></li>
        <li><a href="<?php echo site_url("apresentacao"); ?>" title="Apresenta&ccedil;&atilde;o" class="menu_apresentacao"></a></li>
        <li><a href="<?php echo site_url("cadastro"); ?>" title="Cadastro" class="menu_cadastro"></a></li>
        <li><a href="#" title="V&iacute;deos" class="menu_videos"></a></li>
        <li><a href="<?php echo site_url("faq"); ?>" title="FAQ" class="menu_faq"></a></li>
        <li><a href="<?php echo site_url("faleconosco"); ?>" title="Fale Conosco" class="menu_faleconosco"></a></li>
        <li><a href="#" title="Depoimentos" class="menu_depoimentos"></a></li>
        <!--
        <li><a href="#" title="Loja" class="menu_loja"></a></li>
        -->
    </ul>
</div>
