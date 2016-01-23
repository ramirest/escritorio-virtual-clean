<div class="portlet portlet-default">
    <div class="portlet-body">
        <div class="table-responsive">
            <table id="table-geral" class="table table-striped table-bordered table-hover table-green">
                <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Última atualização</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php


                foreach($faturas->result() as $v)
                {


                    ?>
                    <tr>
                        <th><?php echo $v->pid ?></th>
                        <th><?php echo "R$ ".$v->valor ?></th>
                        <th><?php
                            echo $this->cart->check_status($v->status);
                            ?>
                        </th>
                        <th>
                            <?php
                            $this->db->select('max(date) date');
                            $this->db->where('fid', $v->fid);
                            $dt_alt = $this->db->get('faturas_status');
                            $data = explode("-", substr($dt_alt->row()->date, 0, 10));
                            $data2 = explode(":", substr($dt_alt->row()->date, 11, 8));
                            $data = date("d/m/Y H:i:s", mktime($data2[0],$data2[1],$data2[2],$data[1], $data[2], $data[0]));

                            echo $data;
                            ?>

                        </th>

                        <?php if($v->status==1 || $v->status==2){ ?>
                            <th align="center">
                                <?php echo anchor("escritorio-virtual/dashboard/pagamento/$v->fid/1", "Realizar pagamento"); ?>
                            </th>
                        <?php  } ?>

                    </tr>
                <?php } ?>


                </tbody>
            </table>
        </div>
    </div>
</div>