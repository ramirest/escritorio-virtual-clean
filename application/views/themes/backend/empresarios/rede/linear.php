<div class="portlet portlet-default">
    <div class="portlet-body">
        <div class="table-responsive">
            <table id="table-geral" class="table table-striped table-bordered table-hover table-green">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Cidade / UF</th>
                    <th>Status</th>
                    <!--<th>Ações</th>-->
                </tr>
                </thead>
                <tbody>
                <?php
                echo $this->session->flashdata('msg');

                if(isset($associados)):
                    $i = 0;
                    foreach($associados->result() as $v):
                        $i++;
                        if(($i % 2) == 0)
                            $classe = 'odd';
                        else
                            $classe = 'even';
                        ?>
                        <tr class="<?php echo $classe; ?> gradeX">
                            <td><?php echo $v->Nome; ?></td>
                            <td><?php echo $v->Login; ?></td>
                            <td><?php echo $v->cidade.' / '.$v->estado; ?></td>
                            <?php
                            switch($v->status):
                                case 'P':
                                    $status = array(
                                        'label'=>'Pendente',
                                        'item'=>'text-orange');
                                    break;
                                case 'A':
                                    $status = array(
                                        'label'=>'Ativo',
                                        'item'=>'text-green');
                                    break;
                                case 'I':
                                    $status = array(
                                        'label'=>'Inativo',
                                        'item'=>'text-red');
                                    break;
                            endswitch;
                            ?>
                            <td class="center">
                                <a href="#" id="status" data-toggle="tooltip" data-placement="top" title="<?php echo $status['label']?>">
                                    <i class="fa fa-circle <?php echo $status['item']; ?>"></i></a></td>
                            <!-- Ações -->
                            <!--
                            <td class="center">

                                <div class="btn-group">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown">Selecione <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="<?php //echo site_url('escritorio-virtual/pedidos/transferir_credito/'.$v->aid); ?>">Transferir crédito</a>
                                        </li>
                                        <?php
                                        //verifica se o usuário está pendente e permite ao empresário ativá-lo usando seus créditos
                                        //if($v->status == "P"):
                                            //if($this->lib_associados->get_saldo() >= $this->config->item('taxa_adesao')):
                                                ?>
                                                <li>
                                                    <a href="#ativar" data-toggle="modal">Ativar</a>
                                                </li>
                                            <?php
                                            //endif;
                                        //endif;
                                        ?>
                                        <?php //if($this->dx_auth->is_role(array("admin","root"))): ?>
                                            <!-- <li><a href="#" title="Desativar"><i class="fa fa-lock"></i></a></li> -->
                                        <?php //endif; ?>
                                        <!--
                                    </ul>
                                </div>
                            </td>
                            -->
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
            </table>
            <!-- Flex Modal -->
            <div class="modal modal-flex fade" id="ativar" tabindex="-1" role="dialog" aria-labelledby="ativacaoLbl" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="ativacaoLbl">Ativar Empresário</h4>
                        </div>
                        <div class="modal-body">
                            <h3>
                                <i class="fa fa-sign-out text-green"></i> Tem certeza de que deseja ativar o empresário selecionado utilizando seus créditos?
                            </h3>
                            <p>Após a confirmação, o valor da ativação será subtraído de seu saldo.
                                <br>Esta ação não poderá ser desfeita.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <a href="<?php echo site_url('adm/pedidos/ativar/'.$v->aid); ?>" class="btn btn-green">
                                <strong>Ativar</strong>
                            </a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.portlet-body -->
</div>
<!-- /.portlet -->    
