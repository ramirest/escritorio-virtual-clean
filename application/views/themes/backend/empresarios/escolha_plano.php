<?php
echo $msg;
$aid = $this->session->userdata("aid");
echo form_open("escritorio-virtual/empresarios/salvar_escolha_plano");
?>

<input type="hidden" name="qtde_cadernos" id="qtde_cadernos"  value="0" />
<input type="hidden" name="qtde_cadernos_marcados" id="qtde_cadernos_marcados"  value="0" />


<br class="quebra">
<div class="linhaz" style="border-bottom: 1px dashed #25496D; margin-top: 50px; margin-bottom: 30px;"></div>

<section id="team">
    <div class="row">
        <div class="col-lg-12 col-offset-2" style=" margin-bottom: 50px;">
            <h1 class="text-center" style="color:#c34455">Plano de assinatura</h1>
            <p class="text-center"><small style="font-size: 20px;">Verifique os detalhes do seu plano abaixo</small></p>
        </div>

        <div class="btn-group sterotipo" style="display: block;">
            <?php echo form_hidden('aid', $aid); ?>
            <?php foreach($planos->result() as $v): ?>
                <div class="col-lg-6 col-sm-6">
                    <div class="circle-tile">

                        <!-- nome do plano-->
                        <a href="#">
                            <div class="circle-tile-heading cor_mega">
                                <h3><?php echo $v->nmplano ?></h3>
                            </div>
                        </a>

                        <div class="circle-tile-content cor_mega">


                            <div class="circle-tile-description text-faded">
                                valor
                            </div>

                            <div class="circle-tile-number text-faded">
                                R$<?php echo $v->valor_plano ?>
                            </div>

                            <div class="linhaz"></div>

                            <a href="http://www.sicove.com.br/planos.html#<?php echo strtolower($v->nmplano=='Top'?'about':$v->nmplano); ?>" target="_blank" style="margin-top: 10px; border: solid 1px;" type="button" class="btn btn-top1">Saiba Mais</a>




                            <div class="top_acodeon">
                                <div style="margin-top: 15px;" class="portlet portlet-default">


                                    <div class="linhaz"></div>
                                    <div class="circle-tile-description text-faded">
                                        <?php echo $v->qtde_cadernos ?> cadernos <br>revista online
                                    </div>
                                    <div class="linhaz" style="border-bottom: 1px dashed #d36272;"></div>

                                    <div class="circle-tile-description text-faded">
                                        <?php echo $v->pontos_binario ?> Pontos Binário
                                    </div>
                                    <div class="linhaz" style="border-bottom: 1px dashed #d36272;"></div>
                                    <div class="circle-tile-description text-faded">
                                        <?php echo $v->pontos_unilevel ?> Pontos Unilével
                                    </div>
                                    <div class="linhaz" style="border-bottom: 1px dashed #d36272;"></div>
                                    <div class="circle-tile-description text-faded">
                                        Entrada de R$<?php echo $v->valor_entrada ?>
                                    </div>
                                    <div class="linhaz" style="border-bottom: 1px dashed #d36272;"></div>
                                    <div class="circle-tile-description text-faded">
                                        Pagamento em até <?php echo $v->qtde_parcelas ?>X
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<br class="quebra">
<div class="linhaz" id="linha1" style="border-bottom: 1px dashed #25496D; margin-top: 50px; margin-bottom: 30px;"></div>

<section id="c1">
    <div class="row">
        <div class="col-lg-12">


            <div id="cadernos">
                <div class="col-lg-12 col-offset-2" style=" margin-bottom: 50px;">
                    <h1 class="text-center" style="color:#c34455">Cadernos de notícias</h1>
                    <p class="text-center"><small style="font-size: 20px;">Segue abaixo os cadernos dispon&iacute;veis na sua revista online.</small></p>
                </div>

                <table class="col-lg-12">
                    <?php
                    $qtd_cadernos = 0;
                    foreach($cadernos->result() as $p):

                        ?>

                        <tr>

                            <td style="font-size: 25; padding-left: 10px;">
                                <input type='hidden' id="cid_<?php echo $qtd_cadernos ?>" name="cid[]" value="<?php echo $p->cid ?>" />
                                <?php  echo $p->descricao; ?>
                            </td>
                        </tr>

                        <?php
                        $qtd_cadernos++;
                    endforeach;
                    ?>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="linhaz" style="border-bottom: 1px dashed #25496D; margin-top: 50px; margin-bottom: 30px;"></div>



<div class="row">


    <div class="col-lg-12" style="text-align: center">
        <div class="portlet portlet-default" id="pnlFormaPagamento">

            <div class="col-lg-12 col-offset-2" style=" margin-bottom: 9px;">
                <h1 class="text-center" style="color:#c34455">Por último, defina a forma de pagamento</h1>
                <p class="text-center"><small style="font-size: 20px;">Selecione a forma de pagamento no botão abaixo.</small></p>
            </div>


            <div id="defaultPortlet" class="panel-collapse collapse in">
                <div class="portlet-body">
                    <div class="row">
                        <div class="form-group tttt">
                            <?php
                            echo form_label('Forma de Pagamento', 'formapagamento');
                            $options = array('AVISTA'=>'&Agrave; VISTA', 'APRAZO'=>'&Agrave; PRAZO');
                            $atrr = "class=form-control data-required id=formapagamento";
                            echo form_dropdown('formapagamento', $options, set_value('formapagamento'),$atrr);
                            ?>
                        </div>

                        <div class="col-sm-offset-10 col-sm-1" style="margin-left: 50%;" >
                            <?php

                            echo form_button($this->config->item('btn_save'));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
</div>