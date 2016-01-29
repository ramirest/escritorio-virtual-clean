<?php
$ci_uri = trim($this->uri->uri_string(), '/');
$attr = ' class="active"';
$nav = ' in';
?>

<!-- inicio DASHBOARD -->
<li><a<?php echo (preg_match("|^escritorio-virtual/dashboard.*$|", $ci_uri) > 0)? $attr: ''; ?> href="<?php echo site_url('escritorio-virtual/dashboard'); ?>"> <i
            class="fa fa-dashboard"></i> <span>Principal</span>
    </a></li>
<!-- fim DASHBOARD-->


<!-- inicio REDE -->
<li class="panel"><a href="javascript:;" data-parent="#side"
                     data-toggle="collapse" class="accordion-toggle"
                     data-target="#rede"> <i class="fa fa-sitemap"></i> Rede <i
            class="fa fa-caret-down"></i>
    </a>
    <ul class="collapse nav<?php echo (preg_match("|^escritorio-virtual/rede.*$|", $ci_uri) > 0)? $nav: ''; ?>" id="rede">
        <li><a<?php echo (preg_match("|^escritorio-virtual/rede/binario.*$|", $ci_uri) > 0)? $attr: ''; ?>
                href="<?php echo site_url('escritorio-virtual/rede/binario/'.$this->dx_auth->get_associado_id()); ?>">
                <i class="fa fa-angle-double-right"></i> Binário
            </a></li>
    </ul></li>
<!-- fim REDE -->

<!-- inicio FINANCEIRO -->
<li class="panel">
    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#financeiro">
        <i class="fa fa-money"></i> Financeiro <i class="fa fa-caret-down"></i>
    </a>
    <ul class="collapse nav<?php echo (preg_match("|^escritorio-virtual/financeiro.*$|", $ci_uri) > 0)? $nav: ''; ?>" id="financeiro">

        <li><a<?php echo (preg_match("|^escritorio-virtual/financeiro/extrato.*$|", $ci_uri) > 0)? $attr: ''; ?>
                href="<?php echo site_url('escritorio-virtual/financeiro/extrato/'.$this->dx_auth->get_associado_id()); ?>">
                <i class="fa fa-angle-double-right"></i> Extrato
            </a>
        </li>

        <?php if($this->dx_auth->is_role(array("admin", "root")) ): ?>
            <li><a<?php echo (preg_match("|^escritorio-virtual/rede/gerenciarsaque.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/rede/gerenciarsaque/'.$this->dx_auth->get_associado_id()); ?>">
                    <i class="fa fa-angle-double-right"></i> Gerenciar Saque
                </a></li>
        <?php endif; ?>

        <?php if(!$this->dx_auth->is_role(array("admin", "root")) ): ?>
            <li><a<?php echo (preg_match("|^escritorio-virtual/rede/solicitarsaque.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/rede/solicitarsaque/'.$this->dx_auth->get_associado_id()); ?>">
                    <i class="fa fa-angle-double-right"></i> Solicitar Saque
                </a></li>
        <?php endif; ?>

        <?php if($this->dx_auth->is_role(array("admin", "root")) ): ?>
            <li><a<?php echo (preg_match("|^escritorio-virtual/empresarios/retorno_bancario.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/empresarios/retorno_bancario'); ?>">
                    <i class="fa fa-angle-double-right"></i> Retorno Bancário
                </a></li>
        <?php endif; ?>


    </ul>
</li>
<!-- fim FINANCEIRO -->



<!-- inicio EMPRESARIO -->
<li><a<?php echo (preg_match("|^escritorio-virtual/empresarios/cadastro.*$|", $ci_uri) > 0)? $attr: ''; ?>
        href="<?php echo site_url('escritorio-virtual/empresarios/cadastro'); ?>">
        <i class="fa fa-user"></i> Cadastrar Empresário
    </a></li>
<!-- fim EMPRESARIO -->

<?php if($this->dx_auth->is_role(array("admin", "root")) ): ?>
    <!-- inicio ASSOCIADOS -->
    <li class="panel"><a href="javascript:;" data-parent="#side"
                         data-toggle="collapse" class="accordion-toggle"
                         data-target="#empresarios"> <i class="fa fa-briefcase"></i> Empresários
            <i class="fa fa-caret-down"></i>
        </a>
        <ul class="collapse nav<?php echo (preg_match("|^escritorio-virtual/empresarios.*$|", $ci_uri) > 0)? $nav: ''; ?>" id="empresarios">
            <li><a<?php echo (preg_match("|^escritorio-virtual/empresarios/P.*$|", $ci_uri) > 0)? $attr: ''; ?> href="<?php echo site_url('escritorio-virtual/empresarios/P'); ?>"> <i
                        class="fa fa-angle-double-right"></i> Pendentes
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/empresarios/A.*$|", $ci_uri) > 0)? $attr: ''; ?> href="<?php echo site_url('escritorio-virtual/empresarios/A'); ?>"> <i
                        class="fa fa-angle-double-right"></i> Ativos
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/empresarios/I.*$|", $ci_uri) > 0)? $attr: ''; ?> href="<?php echo site_url('escritorio-virtual/empresarios/I'); ?>"> <i
                        class="fa fa-angle-double-right"></i> Inativos
                </a></li>

        </ul></li>
    <!-- fim ASSOCIADOS -->

    <!-- inicio TRANSFERENCIA -->
    <!--
    Recurso desativado temporariamente para evitar bugs no sistema

<li><a<?php //echo (preg_match("|^escritorio-virtual/pedidos/transferir_credito.*$|", $ci_uri) > 0)? $attr: ''; ?>
        href="<?php //echo site_url('escritorio-virtual/pedidos/transferir_credito'); ?>">
        <i class="fa fa-money"></i> Transferência
    </a></li>
    -->
    <!-- fim TRANSFERENCIA -->

<?php endif; ?>

<?php
if($this->dx_auth->is_role(array("admin","root")) ):
    ?>

    <!-- inicio GERENCIAR PEDIDOS PLANOS -->
    <li><a<?php echo (preg_match("|^escritorio-virtual/pedidos/gerenciar_planos.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/pedidos/gerenciar_planos'); ?>">
            <i class="fa fa-shopping-cart"></i> Pedidos de planos
        </a></li>
    <!-- fim GERENCIAR PEDIDOS PLANOS -->

    <!-- inicio GERENCIAR CONTEÚDO -->
    <li><a<?php echo (preg_match("|^escritorio-virtual/cms/gerenciar.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/cms/gerenciar'); ?>">
            <i class="fa fa-rss-square"></i> CMS
        </a></li>
    <!-- fim GERENCIAR CONTEÚDO -->

    <!-- inicio GERENCIAR ANUNCIOS -->
    <li><a<?php echo (preg_match("|^escritorio-virtual/ads/gerenciar.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/ads/gerenciar'); ?>">
            <i class="fa fa-bullhorn"></i> ADS
        </a></li>
    <!-- fim GERENCIAR ANUNCIOS -->

    <!-- inicio GERENCIAR ESTOQUE -->
    <li><a<?php echo (preg_match("|^escritorio-virtual/estoque.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/estoque'); ?>">
            <i class="fa fa-angle-double-right"></i> Gerenciar Estoque
        </a></li>
    <!-- fim GERENCIAR ESTOQUE -->

    <li><a<?php echo (preg_match("|^escritorio-virtual/configs/tipo_produto.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/configs/tipo_produto'); ?>">
            <i class="fa fa-angle-double-right"></i> Tipos de produtos
        </a></li>
    <li><a<?php echo (preg_match("|^escritorio-virtual/configs/produto.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/configs/produto'); ?>">
            <i class="fa fa-angle-double-right"></i> Produtos
        </a></li>
    <li><a<?php echo (preg_match("|^escritorio-virtual/configs/revista.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php echo site_url('escritorio-virtual/configs/revista'); ?>">
            <i class="fa fa-angle-double-right"></i> Revistas
        </a></li>

    <!-- inicio GERAR CREDITOS -->
    <!--
    Recurso desativado temporariamente para evitar bugs no sistema
    <li><a<?php //echo (preg_match("|^escritorio-virtual/pedidos/gerar_credito.*$|", $ci_uri) > 0)? $attr: ''; ?>
            href="<?php //echo site_url('escritorio-virtual/pedidos/gerar_credito'); ?>">
            <i class="fa fa-credit-card"></i> Gerar créditos
        </a></li>
    -->
    <!-- fim GERAR CREDITOS -->



<?php
endif;
?>


<?php
if($this->dx_auth->is_role(array("admin","root")) ):
    ?>
    <!-- inicio CONFIGURAÇÕES -->
    <li class="panel"><a href="javascript:;" data-parent="#side"
                         data-toggle="collapse" class="accordion-toggle"
                         data-target="#configuracoes"> <i class="fa fa-cogs"></i> Configurações <i
                class="fa fa-caret-down"></i>
        </a>
        <ul class="collapse nav<?php echo (preg_match("|^escritorio-virtual/configs.*$|", $ci_uri) > 0)? $nav: ''; ?>" id="configuracoes">

            <li><a<?php echo (preg_match("|^escritorio-virtual/imoveis/gerenciar.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/imoveis/gerenciar'); ?>">
                    <i class="fa fa-angle-double-right"></i> Imóveis
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/empresa.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/empresa'); ?>">
                    <i class="fa fa-angle-double-right"></i> Empresa
                </a></li>

            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/enquadramento.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/enquadramento'); ?>">
                    <i class="fa fa-angle-double-right"></i> Enquadramento
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/cadernos.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/cadernos'); ?>">
                    <i class="fa fa-angle-double-right"></i> Cadernos
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/profissoes.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/profissoes'); ?>">
                    <i class="fa fa-angle-double-right"></i> Profissões
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/ramo_atividade.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/ramo_atividade'); ?>">
                    <i class="fa fa-angle-double-right"></i> Ramo de Atividade
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/status_transacao.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/status_transacao'); ?>">
                    <i class="fa fa-angle-double-right"></i> Status da transação
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/motivo_credito.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/motivo_credito'); ?>">
                    <i class="fa fa-angle-double-right"></i> Motivos do crédito
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/tipo_saida.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/tipo_saida'); ?>">
                    <i class="fa fa-angle-double-right"></i> Tipos de saída
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/tipo_entrada.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/tipo_entrada'); ?>">
                    <i class="fa fa-angle-double-right"></i> Tipos de entrada
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/tipo_imovel.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/tipo_imovel'); ?>">
                    <i class="fa fa-angle-double-right"></i> Tipos de imóveis
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/fundos.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/fundos'); ?>">
                    <i class="fa fa-angle-double-right"></i> Fundos
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/fundos/subfundos.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/fundos/subfundos'); ?>">
                    <i class="fa fa-angle-double-right"></i> Sub-fundos
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/fundos/grupos.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/fundos/grupos'); ?>">
                    <i class="fa fa-angle-double-right"></i> Grupos
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/aplicacoes.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/aplicacoes'); ?>">
                    <i class="fa fa-angle-double-right"></i> Aplicações
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/escopos.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/escopos'); ?>">
                    <i class="fa fa-angle-double-right"></i> Escopos
                </a></li>
            <li><a<?php echo (preg_match("|^escritorio-virtual/configs/boleto.*$|", $ci_uri) > 0)? $attr: ''; ?>
                    href="<?php echo site_url('escritorio-virtual/configs/boleto'); ?>">
                    <i class="fa fa-angle-double-right"></i> Boleto
                </a></li>
            <?php
            if($this->dx_auth->is_role(array("root")) ):
                ?>
                <li><a<?php echo (preg_match("|^escritorio-virtual/configs/papeis.*$|", $ci_uri) > 0)? $attr: ''; ?>
                        href="<?php echo site_url('escritorio-virtual/configs/papeis'); ?>">
                        <i class="fa fa-angle-double-right"></i> Papéis
                    </a></li>
            <?php
            endif;
            if($this->dx_auth->is_role(array("root")) ):
                ?>
                <li><a<?php echo (preg_match("|^escritorio-virtual/configs/usuarios.*$|", $ci_uri) > 0)? $attr: ''; ?>
                        href="<?php echo site_url('escritorio-virtual/configs/usuarios'); ?>">
                        <i class="fa fa-angle-double-right"></i> Usuários
                    </a></li>
            <?php
            endif;
            if($this->dx_auth->is_role(array("root")) ):
                ?>
                <li><a<?php echo (preg_match("|^escritorio-virtual/configs/planos.*$|", $ci_uri) > 0)? $attr: ''; ?>
                        href="<?php echo site_url('escritorio-virtual/configs/planos'); ?>">
                        <i class="fa fa-angle-double-right"></i> Planos
                    </a></li>
            <?php
            endif;
            if($this->dx_auth->is_role(array("root")) ):
                ?>
                <li><a<?php echo (preg_match("|^escritorio-virtual/configs/graduacoes.*$|", $ci_uri) > 0)? $attr: ''; ?>
                        href="<?php echo site_url('escritorio-virtual/configs/graduacoes'); ?>">
                        <i class="fa fa-angle-double-right"></i> Graduações
                    </a></li>
            <?php
            endif;
            ?>
        </ul></li>
    <!-- fim CONFIGURAÇÕES -->
<?php
endif;
?>

<!-- inicio RELATORIOS -->
<li class="panel">
    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#relatorios">
        <i class="fa fa-bars"></i> Relatórios <i class="fa fa-caret-down"></i>
    </a>
    <ul class="collapse nav<?php echo (preg_match("|^escritorio-virtual/bonus.*$|", $ci_uri) > 0)? $nav: ''; ?>" id="relatorios">
        <li><a<?php echo (preg_match("|^escritorio-virtual/bonus/unilevel.*$|", $ci_uri) > 0)? $attr: ''; ?>
                href="<?php echo site_url('escritorio-virtual/bonus/unilevel/'.$this->dx_auth->get_associado_id()); ?>">
                <i class="fa fa-angle-double-right"></i> Bônus Unilevel
            </a>
        </li>
    <?php if($this->dx_auth->is_role(array("admin","root")) ): ?>
        <li><a<?php echo (preg_match("|^escritorio-virtual/configs/logs.*$|", $ci_uri) > 0)? $attr: ''; ?>
                href="<?php echo site_url('escritorio-virtual/relatorios/logs'); ?>">
                <i class="fa fa-angle-double-right"></i> Logs
            </a></li>

        <li><a<?php echo (preg_match("|^escritorio-virtual/configs/indicadores.*$|", $ci_uri) > 0)? $attr: ''; ?>
                href="<?php echo site_url('escritorio-virtual/relatorios/indicadores'); ?>">
                <i class="fa fa-angle-double-right"></i> Indicadores
            </a></li>
    <?php endif; ?>

    </ul>

</li>
<!--
<li class="panel"><a href="javascript:;" data-parent="#side"
                     data-toggle="collapse" class="accordion-toggle"
                     data-target="#relatorios"> <i class="fa fa-briefcase"></i> Relatórios
        <i class="fa fa-caret-down"></i>
    </a>
    <ul class="collapse nav" id="relatorios">
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/binario'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus binário
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/capacitacao'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus capacitação
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/cash'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus cash
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/click'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus click
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/distribuidor'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus distribuidor
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/executivo'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus executivo
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/lideranca'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus liderança
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/linear'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus linear
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/palestrantes'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus palestrantes
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/planos'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus planos
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/revendedor'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus revendedor
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/bonus/unilevel'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Bônus unilevel
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/fundos/diretoria'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Fundo diretoria
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/fundos/g12'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Fundo G12
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/fundos/pl'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Fundo PL
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/fundos/programadores'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Fundo programadores
            </a></li>
        <li><a href="<?php //echo site_url('escritorio-virtual/relatorios/fundos/social'); ?>"> <i
                    class="fa fa-angle-double-right"></i> Fundo social
            </a></li>
    </ul></li>
    -->
<!-- fim RELATORIOS -->
