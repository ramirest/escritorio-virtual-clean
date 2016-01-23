<div class="portlet portlet-default">
    <div class="portlet-body">
        <div class="table-responsive">
            <?php echo isset($msg)?$msg:''; ?>
            <?php
            if($this->session->flashdata('pagamento'))
                echo $this->session->flashdata('pagamento');
            ?>
            <table id="table-geral" class="table table-striped table-bordered table-hover table-green">
                <thead>
                <tr>
                    <th>Associado</th>
                    <th>Fatura</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($pedidos !== FALSE):
                    $i = 0;
                    foreach ($pedidos->result() as $p):
                        $i++;
                        if(($i % 2) == 0)
                            $classe = 'odd';
                        else
                            $classe = 'even';
                        ?>
                        <tr class="<?php echo $classe; ?> gradeX">
                            <td><?php echo $p->associado; ?></td>
                            <td><?php echo  $p->fid; ?></td>
                            <td><?php echo 'R$ '.$p->valor; ?></td>
                            <td><?php echo $p->descricao; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown">Ação <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <?php echo form_open('escritorio-virtual/pedidos/pagar_fatura/'.$p->fid.'/'.$p->aid); ?>
                                            <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmacao" data-title="Confirmar pagamento" data-message="Tem certeza de que deseja confirmar o pagamento deste associado?">
                                                <i class="fa fa-money"></i> Confirmar pagamento
                                            </button>
                                            <?php echo form_close(); ?>
                                        </li>
                                        <li>
                                            <?php echo form_open('escritorio-virtual/pedidos/ativar_doacao/'.$p->fid.'/'.$p->aid); ?>
                                            <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmacao" data-title="Ativar doação" data-message="Tem certeza de que deseja confirmar a doação para este associado?">
                                                <i class="fa fa-gift"></i> Doação
                                            </button>
                                            <?php echo form_close(); ?>
                                        </li>
                                    </ul>
                                    <!-- Confirmação -->
                                    <div class="modal modal-flex fade" id="confirmacao" tabindex="-1" role="dialog" aria-labelledby="confirmacaoLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="confirmacaoLabel">Confirma pagamento?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Tem certeza de que deseja confirmar o pagamento deste associado?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                                                    <button type="button" class="btn btn-danger" id="confirm">Sim</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.confirmação-->

                                </div>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>	