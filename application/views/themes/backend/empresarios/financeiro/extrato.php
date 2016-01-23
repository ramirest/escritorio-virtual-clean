<?php

    $dataInicial = $this->input->post("dataInicial");
    $dataFinal = $this->input->post("dataFinal");
    $tipo = $this->input->post("tipo");

    function FormataDataBR($data){
        if ($data == '')
            return '';
        $data_f = explode('-',$data);
        return $data_f[2].'/'.$data_f[1].'/'.$data_f[0];
    }

    function FormataDataBD($data){
        if ($data == '')
            return '';
        $data_f = explode('/',$data);
        return $data_f[2].'-'.$data_f[1].'-'.$data_f[0];
    }
?>

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Extrato de movimentações</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <?php echo form_open(''); ?>
                <div class="col-sm-12" style="border: solid 1px #dddddd; padding: 0px;">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Filtro de Pesquisa Avançada</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" id="datepicker8">
                                <input placeholder="Data Inicial" type="text" class="form-control" id="dataInicial" name="dataInicial" value="<?php echo set_value("dataInicial",$dataInicial);?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" id="datepicker9">
                                <input placeholder="Data Final" type="text" class="form-control" id="dataFinal" name="dataFinal" value="<?php echo set_value("dataFinal",$dataFinal);?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" style="width: 100%;" id="datetimepicker9">
                                <?php
                                    $tipoValores = array('" disabled selected style="display:none;'=>'Tipo', 'Todos'=>'Todos', 'Entrada'=>'Entrada', 'Saída'=>'Saída');
                                    echo form_dropdown('tipo', $tipoValores, set_value('tipo',$tipo), 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker9">
                                <button type="submit" onclick="#" class="btn btn-default">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

                <br class="quebra"><br><br>
                <div class="table-responsive">

                        <table id="extrato" class="table table-striped table-bordered table-hover table-green dataTable" aria-describedby="example-table_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Valor: activate to sort column descending" style="width: 110px;">Valor</th>
                                <th class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Tipo: activate to sort column ascending" style="width: 90px;">Origem</th>
                                <th class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Data da Movimentação: activate to sort column ascending" style="width: 267px;">Data da Movimentação</th>
                                <th class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Origem: activate to sort column ascending" style="width: 247px;">Tipo</th>
                            </tr>
                            </thead>

                            <tbody role="alert" aria-live="polite" aria-relevant="all">

                            <?php

                            $dataInicialBD = FormataDataBD($dataInicial);
                            $dataFinalBD = FormataDataBD($dataFinal);

                            $sql = "";
                            $sqlEntrada = " select e.eid id, e.aid, te.descricao tipo, e.valor, e.data, 'Entrada' origem
                                             from ass_entrada e inner join tipo_entrada te on te.teid = e.teid
                                             where e.aid = '$Codigo' ";

                            $sqlSaida = " select sd.sid id, sd.aid, case when ts.tsid = 3 then concat(ts.descricao, ' (', dp.nome_completo, ' - ', num_parcela, ')') else ts.descricao end tipo, sd.valor, sd.data, 'Saída' origem
                                           from ass_saida sd inner join tipo_saida ts on ts.tsid = sd.tsid
                                                             left join ass_faturas f on f.fid = sd.fid
                                                             left join ass_pedidos p on p.pid = f.pedido
                                                             left join ass_dados_pessoais dp on dp.aid = p.aid
                                           where sd.aid = '$Codigo' ";

                            if ($dataInicialBD!=""):
                                $sqlEntrada = $sqlEntrada." and e.data >= '".$dataInicialBD."' ";
                                $sqlSaida = $sqlSaida." and sd.data >= '".$dataInicialBD."' ";
                            endif;

                            if ($dataFinalBD!=""):
                                $sqlEntrada = $sqlEntrada." and e.data <= '".$dataFinalBD."' ";
                                $sqlSaida = $sqlSaida." and sd.data <= '".$dataFinalBD."' ";
                            endif;

                            if (($tipo=="Todos") || ($tipo=="")):
                                $sql = $sqlEntrada." union ".$sqlSaida." order by data desc ";
                            elseif ($tipo=="Entrada"):
                                $sql = $sqlEntrada." order by data desc ";
                            elseif ($tipo=="Saída"):
                                $sql = $sqlSaida." order by data desc ";
                            endif;

                            $sql = mysql_query($sql);

                            while($lin = mysql_fetch_array($sql))
                            {
                                $DataMovimentacao = substr($lin["data"],0,10);
                                $HoraMovimentacao = substr($lin["data"],10,17);

                                $TotalSaldo = mysql_query(" SELECT valor total FROM ass_saldo WHERE aid=$Codigo ") or die (mysql_error());
                                $lSaldo = mysql_fetch_array($TotalSaldo);
                                $TotalSaldo = $lSaldo["total"];

                                echo "<tr>";
                                echo "<td>R$ ".number_format($lin["valor"], 2, ',', '.')."</td>";
                                echo "<td>".$lin["tipo"]."</td>";
                                echo "<td>".FormataDataBR($DataMovimentacao)." ".$HoraMovimentacao."</td>";
                                echo "<td>".$lin["origem"]."</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
