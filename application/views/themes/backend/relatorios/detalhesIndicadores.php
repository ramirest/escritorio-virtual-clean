<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><?php echo $titulo;?></h4>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="portlet-body">

                <div>
                    <button onclick="javascript:history.back()" class="btn btn-default">Voltar</button>
                    <button class="btn btn-default" data-toggle="modal" data-target="#standardModal">Script</button>

                    <div class="modal fade in" id="standardModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="standardModalLabel">Script</h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo $scriptDetalhes;?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <br>
                    <br>
                </div>

                <div class="table-responsive">
                    <table id="extrato" class="table table-striped table-bordered table-hover table-green dataTable" aria-describedby="example-table_info">
                        <thead>

                        <tr role="row">
                            <?php
								$sql = $this->db->query($scriptDetalhes);
								foreach($sql->list_fields() as $field):
                                    echo " <th class=\"sorting\" role=\"columnheader\" tabindex=\"0\" aria-controls=\"example-table\" rowspan=\"1\" colspan=\"1\" aria-label=\"Nome: activate to sort column ascending\" style=\"text-align:center;\">".$field."</th>";
                                endforeach;
                            ?>
                        </tr>

                        </thead>

                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                        <?php						
						$sql = $this->db->query($scriptDetalhes);
						foreach($sql->result_array() as $lin):	
                            echo "<tr>";
							$sql = $this->db->query($scriptDetalhes);
							foreach($sql->list_fields() as $field):
                                echo "<td>".$lin[$field]."</td>";
							endforeach;
                            echo "</tr>";
						endforeach;	
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>