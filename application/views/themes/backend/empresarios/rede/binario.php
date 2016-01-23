<div class="portlet portlet-default">
    <div class="portlet-body" style="background: rgba(255, 255, 255, 2.5)!important; min-width: 640px!important;">
        <div class="tab-content">
            <ul id="redeBinariaTab" class="nav nav-pills">
                <li class="active"><a href="#redeBinaria" data-toggle="tab" id="lnk1"><i class="fa fa-user fa-fw"></i>Rede Binária</a></li>
                <li><a href="#infoRede" data-toggle="tab" id="lnk2"><i class="fa fa-road fa-fw"></i>Informações</a></li>
                <li><a href="#configRede" data-toggle="tab" id="lnk3"><i class="fa fa-envelope-o fa-fw"></i>Configurações</a></li>







                <!--  inicio botão drop legenda -->
                <div class="btn-group group-legenda">
                    <button class="btn btn-default btn-lg dropdown-toggle btn-group-legenda" type="button" data-toggle="dropdown">
                        Legenda
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li style="width: 208px;">

                            <div style="float: left; width: 120px; margin-left: 10px; margin-bottom: 7px;">
                                <strong>EMPREENDEDORES</strong>
                            </div>

                            <br class="quebra">

                            <div class="legenda">
                                <div class="col-xs-2">
                                    <img class="img-circle circle_leg" src="<?php echo $this->config->item('img'); ?>arvore/ativo.jpg" alt="">
                                </div>
                                <div class="col-xs-10">
                                    <p>
                                        <strong style="color: #ff9517;">Ativo</strong>
                                    </p>

                                </div>
                            </div>
                            <div class="legenda">
                                <div>
                                    <img class="img-circle" style="border: solid 2px #fe8484;" src="<?php echo $this->config->item('img'); ?>arvore/pendente.jpg" alt="">
                                </div>
                                <div>
                                    <p>
                                        <strong style="color: #fe8484;">Pendente</strong>
                                    </p>

                                </div>
                            </div>
                            <div class="legenda">
                                <div class="col-xs-2">
                                    <img class="img-circle" style="border: solid 2px #8b8888;" src="<?php echo $this->config->item('img'); ?>arvore/inativo.jpg" alt="">
                                </div>
                                <div>
                                    <p>
                                        <strong style="color: #8b8888;">Inativo</strong>
                                    </p>

                                </div>
                            </div>

                        <li class="divider didi" style="margin-left: 10px;"></li>

                        <div style="float: left; width: 120px; margin-left: 10px; margin-bottom: 7px;">
                            <strong>CLIENTES</strong>
                        </div>
                        <br class="quebra">

                        <div class="legenda">
                            <div class="col-xs-2">
                                <img class="img-circle circle_leg" src="<?php echo $this->config->item('img'); ?>arvore/cliente_ativo.jpg" alt="">
                            </div>
                            <div class="col-xs-10">
                                <p>
                                    <strong style="color: #ff9517;">Ativo</strong>
                                </p>

                            </div>
                        </div>

                        <div class="legenda">
                            <div class="col-xs-2">
                                <img class="img-circle" style="border: solid 2px #8b8888;" src="<?php echo $this->config->item('img'); ?>arvore/cliente_inativo.jpg" alt="">
                            </div>
                            <div>
                                <p>
                                    <strong style="color: #8b8888;">Inativo</strong>
                                </p>

                            </div>
                        </div>

                        </li>

                        <li class="divider didi" style="margin-left: 10px;"></li>

                        <div style="float: left; width: 120px; margin-left: 10px; margin-bottom: 7px;">
                            <strong>INEXISTENTE</strong>
                        </div>
                        <br class="quebra">

                        <div class="legenda">
                            <div class="col-xs-2">
                                <img class="img-circle circle_leg"  style="border: solid 2px #aaa6a7;" src="<?php echo $this->config->item('img'); ?>arvore/sem_cadastro.jpg" alt="">
                            </div>
                            <div class="col-xs-10">
                                <p>
                                    <strong style="color: #ff9517;">Sem cadastro</strong>
                                </p>

                            </div>
                        </div>






                    </ul>
                </div>
                <!--  fim botão drop legenda -->

                <button class="btn btn-default"><?php echo $inicio; ?></button>

                <button class="btn btn-default"> <?php echo anchor('escritorio-virtual/empresarios/cadastro',
                        'Cadastrar', 'class="btn btn-block btn_viwer_num_cad btn_cad01"'); ?></button>









            </ul>



            <div id="redeBinariaTabContent" class="tab-content">
                <div id="redeBinaria" class="tab-pane fade in active">
                    <div class="arvore">
                        <div class="sub_arvore">
                            <div class="col-md-12" style="min-width: 495px; padding-left: 0px;">
                                <div class="col-lg-6 col-sm-6 dimie">
                                    <div class="circle-tile">
                                        <a href="#">
                                            <div class="circle-tile-heading cor_light">
                                                <i class="fa fa-chevron-circle-left dimi2"></i>
                                            </div>
                                        </a>
                                        <div class="circle-tile-content cor_light dimi3">
                                            <div class="dimi4">
                                                <div class="circle-tile-description text-faded">
                                                    CADASTROS
                                                </div>
                                                <div class="circle-tile-number text-faded dimi5">
                                                    <?php echo $rede_esquerda; ?>
                                                </div>
                                            </div>
                                            <div class="dimi44">
                                                <div class="circle-tile-description text-faded">
                                                    PONTOS
                                                </div>
                                                <div class="circle-tile-number text-faded dimi5">
                                                    <?php echo $pontos_esquerda; ?>
                                                </div>
                                            </div>
                                            <br class="quebra">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 dimid">
                                    <div class="circle-tile">
                                        <a href="#">
                                            <div class="circle-tile-heading cor_top">
                                                <i class="fa fa-chevron-circle-right dimi2"></i>
                                            </div>
                                        </a>
                                        <div class="circle-tile-content cor_top dimi3">
                                            <div class="dimi4">
                                                <div class="circle-tile-description text-faded">
                                                    CADASTROS
                                                </div>
                                                <div class="circle-tile-number text-faded dimi5">
                                                    <?php echo $rede_direita; ?>
                                                </div>
                                            </div>
                                            <div class="dimi44">
                                                <div class="circle-tile-description text-faded">
                                                    PONTOS
                                                </div>
                                                <div class="circle-tile-number text-faded dimi5">
                                                    <?php echo $pontos_direita; ?>
                                                </div>
                                            </div>
                                            <br class="quebra">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br class="quebra" />
                            <?php echo $html;?>
                        </div>
                    </div>
                </div>
                <div id="infoRede" class="tab-pane fade">
                    <?php echo $rede; ?>
                </div>
                <div id="configRede" class="tab-pane fade">
                    <div id="response_novos_cadastros"></div>
                </div>
            </div>

        </div>
        <br class="quebra">
    </div>
</div>
