<?php

include "funcoes.php";

if(($sql) && $sql->num_rows() > 0)
{
    $l = $sql->row();
    echo "Plano Atual: ".$l->plano;
    echo "</br>";
    echo "</br>";
    if($l->plano != 'Top' && !empty($l->plano)):
        echo anchor('escritorio-virtual/dashboard/mudarplano', 'Mudar Plano');
    elseif(empty($l->plano)):
        //Impede o aparecimento do link "Escolher plano" para os associados que ainda não tem plano atual e,
        //no entanto, têm faturas pendentes.
        $associado_pendente = $this->db->query("
                                        select * from associados a
                                        inner join ass_pedidos p on p.aid = a.aid
                                        inner join ass_faturas f on f.pedido = p.pid
                                        where a.aid = $l->aid
                                ");
        if($associado_pendente->num_rows() == 0)
            echo anchor('escritorio-virtual/empresarios/escolha_plano', 'Escolher plano');
    endif;
}


echo "</br>";
echo "</br>";

if($this->config->item('notificacao') != ''):
    $notificacao = <<<HTML
<div class="alert alert-warning">
    {$this->config->item('notificacao')}
</div>
HTML;

    echo $notificacao;
endif;

if(!isset($msg)):

    ?>
    <div class="portlet portlet-default">
        <div class="portlet-body">
            <div class="table-responsive">
                <table id="table-geral" class="table table-striped table-bordered table-hover table-green">
                    <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Parcela</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data Vencimento</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($faturas->result() as $v)
                    {
                        ?>
                        <tr>
                            <th><?php echo $v->nmplano ?></th>
                            <th><?php echo $v->num_parcela ?></th>
                            <th><?php echo $v->descricaofatura ?></th>
                            <th><?php echo "R$ ".numberBR($v->valor) ?></th>
                            <th><?php echo FormataDataBR($v->dtvencimento) ?></th>
                            <th><?php echo $v->status ?></th>

                            <?php if($v->status!="Pago"){ ?>
                                <th align="center">
                                    <?php echo anchor("escritorio-virtual/dashboard/pagamento/$v->fid", "Realizar pagamento"); ?>
                                </th>
                            <?php  }else
                            { ?>
                                <th> - </th>

                            <?php } ?>
                        </tr>
                    <?php } ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
else:
    echo $msg;

    //BEGIN ADS
    if($ads):
        ?>
        <div class="row">
            <div class="col-lg-12" style="margin-top: 15px">
                <?php

                $last_row = anchor_popup(site_url('escritorio-virtual/ads/index/'.md5($ads->last_row()->adsid)), '<img class="img-responsive" alt="'.$ads->last_row()->descricao.'" src="'.$ads->last_row()->url_imagem.'">');
                $prev_row = anchor_popup(site_url('escritorio-virtual/ads/index/'.md5($ads->previous_row()->adsid)), '<img class="img-responsive" alt="'.$ads->previous_row()->descricao.'" src="'.$ads->previous_row()->url_imagem.'">');
                $conteudo_ads = <<<HTML
            <div class="col-lg-5 coldash">{$last_row}</div>
            <div class="col-lg-2"></div>
            <div class="col-lg-5  coldash">{$prev_row}</div>
HTML;
                echo $conteudo_ads;
                ?>
            </div>
        </div>

        <div id="content455" class="grid_12">
            <h2 class="h2h2"><span style="color:#85c1d6 ">Notícias</span > &amp; <span style="color: #12e68a;">Novidades</span></h2>
        </div>
    <?php
    endif;
//END ADS

    //BEGIN CMS
    if($cms):
        ?>
        <!-- SLIDE NOTICIAS NOVIDADES-->

        <div class="row">
            <div class="col-lg-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

                        <?php
                        $i = 0;
                        foreach($cms->result() as $conteudo):
                            $i++;
                            switch($conteudo->tp_conteudo):
                                case 'noticia':
                                    $class_i = "iconformas_noticias";
                                    $class_h = "iconformas33";
                                    $tipo = "NOTÍCIA";
                                    $style = "border: 2px solid #4abcdd; color: #4abcdd";
                                    break;
                                case 'novidade':
                                    $class_i = "iconformas";
                                    $class_h = "iconformas3";
                                    $tipo = "NOVIDADE";
                                    $style = "border: 2px solid #12e68a; color: #12e68a";
                                    break;
                            endswitch;
                            $active = $i==1?' active':'';
                            $link = anchor("escritorio-virtual/cms/$conteudo->cid", 'Leia mais', "class='btn btn-outline-white btn-big' style='$style'");
                            $html = <<<HTML
                        <div class="item{$active}">
                            <div class="col-lg-6 coldash" style="border-right: solid 1px #ecf0f1;">
                                <img class="img-responsive" src="{$conteudo->url_imagem}">
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <i class="fa fa-chevron-right {$class_i}"></i>
                                    <h3 class="{$class_h}">{$tipo} <span style="font-size: 12px"> {$conteudo->data}</span></h3>
                                </div>
                                <br class="quebra">
                                <div class="pts2" style="margin-bottom: 15px">
                                    <span style="font-weight: bold">{$conteudo->titulo}</span><br>
                                    {$conteudo->corpo}
                                </div>
                                {$link}
                            </div>
                        </div>
HTML;
                            echo $html;
                        endforeach;
                        ?>
                    </div>
                    <?php if($cms_count > 1): ?>
                        <a class="left carousel-control slide78" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left slide80"></span>
                        </a>
                        <a class="right carousel-control slide78" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right slide79"></span>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- FIM SLIDE NOTICIAS NOVIDADES-->

    <?php
    endif;
    //END CMS

endif;
?>
