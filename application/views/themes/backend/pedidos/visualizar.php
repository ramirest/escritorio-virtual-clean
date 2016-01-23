<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-12">
        <div class="portlet portlet-default">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <h1><i class="fa fa-gears"></i> <?php echo $titulo; ?></h1>
                        <br>
                    </div>
                    <div class="col-md-6 invoice-terms">
                        <h3>Fatura #<?php echo $pedidos->row()->fid; ?></h3>
                        <p>
                            Data da fatura: <?php echo $this->data->mysql_to_human($pedidos->row()->dtpedido); ?>
                            <br>
                            <?php if ($pedidos->row()->status >= 3): ?>
                            <strong><span class="text-red">Fatura paga</span></strong>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <!-- /.row -->
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Cliente</h3>
                        <address>
                            <strong><?php echo $pedidos->row()->nome; ?></strong>
                            <br><?php echo $pedidos->row()->cep; ?> - <?php echo $pedidos->row()->logradouro; ?>, <?php echo $pedidos->row()->numero; ?>
                            <br><?php echo $pedidos->row()->bairro; ?>, <?php echo $pedidos->row()->cidade; ?> - <?php echo $pedidos->row()->estado; ?>
                            <br>
                            <abbr title="Telefones">F:</abbr> <?php echo $pedidos->row()->telefones; ?>
                        </address>
                    </div>
                </div>
                <!-- /.row -->
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Itens</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Quantidade</th>
                                    <th>Descriç&atilde;o</th>
                                    <th>Preço</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($pedidos->result() as $pedido): ?>
                                    <tr>
                                        <td><?php echo $pedido->qty; ?></td>
                                        <td>
                                            <?php
                                            $db_loja = $this->load->database('loja', TRUE);
                                            $item = $db_loja->query("
                                                select titulo, preco from lista_produtos
                                                where sku = '$pedido->sku'
                                            ");
                                            echo $item->row()->titulo;
                                            ?>
                                        </td>
                                        <td><?php echo $this->cart->format_number_BRL($item->row()->preco); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td></td>
                                    <td class="text-right"><strong>Subtotal:</strong>
                                    </td>
                                    <td><strong><?php echo $pedidos->row()->valor - $pedidos->row()->valor_frete; ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right"><strong>Frete:</strong>
                                    </td>
                                    <td><strong><?php echo $pedidos->row()->valor_frete; ?></strong>
                                    </td>
                                </tr>
                                <tr class="text-red">
                                    <td></td>
                                    <td class="text-right"><strong>Total:</strong>
                                    </td>
                                    <td><strong><?php echo $pedidos->row()->valor; ?></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Avanço das faturas</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $fatura_status = $this->db->query("select status, date from faturas_status where fid = ".$pedidos->row()->fid);
                                ?>
                                <?php foreach($fatura_status->result() as $status): ?>
                                    <tr>
                                        <td>
                                            <?php echo $this->cart->check_status_all($status->status); ?>
                                        </td>
                                        <td>
                                            <?php echo $this->data->mysql_to_human($status->date); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
