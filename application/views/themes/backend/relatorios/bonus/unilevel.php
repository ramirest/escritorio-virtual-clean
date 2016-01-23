<?php
$mes = $this->input->post("mes");
$ano = $this->input->post("ano");

if ($mes == ''){
    $mes = round(date("m"));
}

if ($ano == ''){
    $ano = date("Y");
}
?>

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Bônus no Unilevel</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div>
                    O percentual pago para cada geração vai depender do plano assinado.
                    <br>
                    Segue abaixo o percentual de cada plano:
                    <br>
                    <br>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <a>
                                Confira a tabela do Unilevel
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="extrato" class="table table-striped table-bordered table-hover table-green dataTable" aria-describedby="example-table_info">
                                    <thead>

                                    <tr role="row">
                                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="2" colspan="1" aria-sort="ascending" aria-label="Plano: activate to sort column descending" style="width: 110px;padding-bottom:27px;">Plano</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="12" aria-label="1ª Geração: activate to sort column ascending" style="text-align:center;">Geração</th>
                                    </tr>

                                    <tr role="row">
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="1ª Geração: activate to sort column ascending" style="text-align:center;">1ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="2ª Geração: activate to sort column ascending" style="text-align:center;">2ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="3ª Geração: activate to sort column ascending" style="text-align:center;">3ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="4ª Geração: activate to sort column ascending" style="text-align:center;">4ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="5ª Geração: activate to sort column ascending" style="text-align:center;">5ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="6ª Geração: activate to sort column ascending" style="text-align:center;">6ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="7ª Geração: activate to sort column ascending" style="text-align:center;">7ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="8ª Geração: activate to sort column ascending" style="text-align:center;">8ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="9ª Geração: activate to sort column ascending" style="text-align:center;">9ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="10ª Geração: activate to sort column ascending" style="text-align:center;">10ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="11ª Geração: activate to sort column ascending" style="text-align:center;"">11ª</th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="12ª Geração: activate to sort column ascending" style="text-align:center;">12ª</th>
                                    </tr>

                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all">

                                    <?php

                                    $sql = " select case when a.plano_atual is not null then concat(nmplano,' (Ativo)') else nmplano end nmplano, round(perc_ganhos_unilevel_g1*100,0) g1, round(perc_ganhos_unilevel_g2*100,0) g2, round(perc_ganhos_unilevel_g3*100,0) g3,
                                        round(perc_ganhos_unilevel_g4*100,0) g4, round(perc_ganhos_unilevel_g5*100,0) g5, round(perc_ganhos_unilevel_g6*100,0) g6,
                                        round(perc_ganhos_unilevel_g7*100,0) g7, round(perc_ganhos_unilevel_g8*100,0) g8, round(perc_ganhos_unilevel_g9*100,0) g9,
                                        round(perc_ganhos_unilevel_g10*100,0) g10, round(perc_ganhos_unilevel_g11*100,0) g11, round(perc_ganhos_unilevel_g12*100,0) g12, a.plano_atual
                                 from planos p left join associados a on a.plano_atual = p.pid
                                                                     and a.aid = '$Codigo'
                                 order by percentual_ganho ";

                                    $sql = mysql_query($sql);

                                    while($lin = mysql_fetch_array($sql))
                                    {
                                        $estilo1="";
                                        $estilo2="";
                                        $estilo3="";
                                        $estilo4="";
                                        $estilo5="";
                                        $estilo6="";
                                        $estilo7="";
                                        $estilo8="";
                                        $estilo9="";
                                        $estilo10="";
                                        $estilo11="";
                                        $estilo12="";
                                        $estilo_ativo_inicio = "";
                                        $estilo_ativo_fim = "";

                                        $icone_0_perc ="<i class=\"fa fa-times\"></i>";

                                        $perc_g1 = $lin["g1"]."%";
                                        $perc_g2 = $lin["g2"]."%";
                                        $perc_g3 = $lin["g3"]."%";
                                        $perc_g4 = $lin["g4"]."%";
                                        $perc_g5 = $lin["g5"]."%";
                                        $perc_g6 = $lin["g6"]."%";
                                        $perc_g7 = $lin["g7"]."%";
                                        $perc_g8 = $lin["g8"]."%";
                                        $perc_g9 = $lin["g9"]."%";
                                        $perc_g10 = $lin["g10"]."%";
                                        $perc_g11 = $lin["g11"]."%";
                                        $perc_g12 = $lin["g12"]."%";

                                        if($perc_g1=='0%'){ $estilo1="background-color: #C7C7C7;"; $perc_g1=$icone_0_perc; }
                                        if($perc_g2=='0%'){ $estilo2="background-color: #C7C7C7;"; $perc_g2=$icone_0_perc; }
                                        if($perc_g3=='0%'){ $estilo3="background-color: #C7C7C7;"; $perc_g3=$icone_0_perc; }
                                        if($perc_g4=='0%'){ $estilo4="background-color: #C7C7C7;"; $perc_g4=$icone_0_perc; }
                                        if($perc_g5=='0%'){ $estilo5="background-color: #C7C7C7;"; $perc_g5=$icone_0_perc; }
                                        if($perc_g6=='0%'){ $estilo6="background-color: #C7C7C7;"; $perc_g6=$icone_0_perc; }
                                        if($perc_g7=='0%'){ $estilo7="background-color: #C7C7C7;"; $perc_g7=$icone_0_perc; }
                                        if($perc_g8=='0%'){ $estilo8="background-color: #C7C7C7;"; $perc_g8=$icone_0_perc; }
                                        if($perc_g9=='0%'){ $estilo9="background-color: #C7C7C7;"; $perc_g9=$icone_0_perc; }
                                        if($perc_g10=='0%'){ $estilo10="background-color: #C7C7C7;"; $perc_g10=$icone_0_perc; }
                                        if($perc_g11=='0%'){ $estilo11="background-color: #C7C7C7;"; $perc_g11=$icone_0_perc; }
                                        if($perc_g12=='0%'){ $estilo12="background-color: #C7C7C7;"; $perc_g12=$icone_0_perc; }

                                        if($lin["plano_atual"]!=""){
                                            $estilo_ativo_inicio = "<b>";
                                            $estilo_ativo_fim = "</b>";
                                        }

                                        echo "<tr>";
                                        echo "<td>".$estilo_ativo_inicio.$lin["nmplano"].$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo1."\">".$estilo_ativo_inicio.$perc_g1.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo2."\">".$estilo_ativo_inicio.$perc_g2.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo3."\">".$estilo_ativo_inicio.$perc_g3.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo4."\">".$estilo_ativo_inicio.$perc_g4.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo5."\">".$estilo_ativo_inicio.$perc_g5.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo6."\">".$estilo_ativo_inicio.$perc_g6.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo7."\">".$estilo_ativo_inicio.$perc_g7.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo8."\">".$estilo_ativo_inicio.$perc_g8.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo9."\">".$estilo_ativo_inicio.$perc_g9.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo10."\">".$estilo_ativo_inicio.$perc_g10.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo11."\">".$estilo_ativo_inicio.$perc_g11.$estilo_ativo_fim."</td>";
                                        echo "<td style=\"text-align:center;".$estilo12."\">".$estilo_ativo_inicio.$perc_g12.$estilo_ativo_fim."</td>";
                                        echo "</tr>";
                                    }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_open(''); ?>
                <div class="col-sm-12" style="border: solid 1px #dddddd; padding: 0px;">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Filtro de Pesquisa</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group" style="width: 100%;">
                                <?php
                                $meses = array('" disabled selected style="display:none;'=>'Mês',
                                    '01'=>'Janeiro',
                                    '02'=>'Fevereiro',
                                    '03'=>'Março',
                                    '04'=>'Abril',
                                    '05'=>'Maio',
                                    '06'=>'Junho',
                                    '07'=>'Julho',
                                    '08'=>'Agosto',
                                    '09'=>'Setembro',
                                    '10'=>'Outubro',
                                    '11'=>'Novembro',
                                    '12'=>'Dezembro');
                                echo form_dropdown('mes', $meses, set_value('mes',$mes), 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input placeholder="Ano" type="text" class="form-control" id="ano" name="ano" value="<?php echo set_value("ano",$ano);?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group">
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
                            <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Geração: activate to sort column descending">Geração</th>
                            <th class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Total de Pontos no Mês: activate to sort column ascending" style="width: 120px;">Pontos</th>
                            <th class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Percentual: activate to sort column ascending" style="width: 120px;">Percentual</th>
                            <th class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Valor Parcial: activate to sort column ascending" style="width: 120px;">Valor</th>
                            <th class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Valor Parcial: activate to sort column ascending" style="width: 120px;">Ação</th>
                        </tr>
                        </thead>

                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                        <?php

                        $sql2 = "select puid, geracao, pontos, round(percentual*100,0) percentual, pontos*percentual valor
                                from
                                (select puid, geracao, pontos,
                                case when geracao = '1ª Geração' then perc_ganhos_unilevel_g1 else
                                case when geracao = '2ª Geração' then perc_ganhos_unilevel_g2 else
                                case when geracao = '3ª Geração' then perc_ganhos_unilevel_g3 else
                                case when geracao = '4ª Geração' then perc_ganhos_unilevel_g4 else
                                case when geracao = '5ª Geração' then perc_ganhos_unilevel_g5 else
                                case when geracao = '6ª Geração' then perc_ganhos_unilevel_g6 else
                                case when geracao = '7ª Geração' then perc_ganhos_unilevel_g7 else
                                case when geracao = '8ª Geração' then perc_ganhos_unilevel_g8 else
                                case when geracao = '9ª Geração' then perc_ganhos_unilevel_g9 else
                                case when geracao = '10ª Geração' then perc_ganhos_unilevel_g10 else
                                case when geracao = '11ª Geração' then perc_ganhos_unilevel_g11 else
                                case when geracao = '12ª Geração' then perc_ganhos_unilevel_g12 else 0 end end end end end end end end end end end end percentual
                                from (select puid, '1ª Geração' geracao, pontos_g1 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '2ª Geração' geracao, pontos_g2 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '3ª Geração' geracao, pontos_g3 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '4ª Geração' geracao, pontos_g4 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '5ª Geração' geracao, pontos_g5 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '6ª Geração' geracao, pontos_g6 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '7ª Geração' geracao, pontos_g7 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '8ª Geração' geracao, pontos_g8 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '9ª Geração' geracao, pontos_g9 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '10ª Geração' geracao, pontos_g10 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '11ª Geração' geracao, pontos_g11 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano." union
                                      select puid, '12ª Geração' geracao, pontos_g12 pontos from pontos_unilevel where aid = '$Codigo' and mes = ".$mes."	and ano = ".$ano.") temp
                                inner join associados a on a.aid = '$Codigo'
                                left join planos p on p.pid = a.plano_atual) temp2 ";

                        $sql2 = mysql_query($sql2);

                        $total = 0;
                        while($lin2 = mysql_fetch_array($sql2))
                        {
                            $total = $total + $lin2["valor"];
                            $estilo_perdendo = " style=\"vertical-align: middle;\"";
                            if($lin2["percentual"]=='0'){
                                $estilo_perdendo = " style=\"background-color:#C7C7C7;vertical-align:middle;\"";
                            } else {

                            }

                            echo "<tr>";
                            echo "<td".$estilo_perdendo.">".$lin2["geracao"]."</td>";
                            echo "<td class=\"text-center\"".$estilo_perdendo.">".$lin2["pontos"]."</td>";
                            echo "<td class=\"text-center\"".$estilo_perdendo.">".$lin2["percentual"]."%</td>";
                            echo "<td class=\"text-center\"".$estilo_perdendo.">R$ ".number_format($lin2["valor"], 2, ',', '.')."</td>";
                            echo "<td class=\"text-center\"".$estilo_perdendo.">";

                            $link = site_url('escritorio-virtual/bonus/origemUnilevel?controle='.$lin2["puid"].'&geracao='.str_replace("ª Geração", "", $lin2["geracao"]));

                            if($lin2["pontos"]!='0'){
                                echo "<div style=\"padding-left:9px;\" class=\"input-group\">
                                        <button onclick=\"window.location.href='".$link."'\" class=\"btn btn-default\">Detalhar</button>
                                      </div>";
                            }

                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "<tr>";
                        echo "<td colspan=\"3\">Total</td>";
                        echo "<td class=\"text-center\">R$ ".number_format($total, 2, ',', '.')."</td>";
                        echo "</tr>";

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>