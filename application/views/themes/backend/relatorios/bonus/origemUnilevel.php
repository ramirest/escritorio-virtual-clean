<?php
    $puid = $this->input->get("controle");
    $geracao = $this->input->get("geracao");
    $Codigo = $this->dx_auth->get_associado_id();

    function FormataDataBR($data){
        if ($data == '')
            return '';
        $data_1 = explode(' ',$data);
        $data_2 = explode('-',$data_1[0]);
        return $data_2[2].'/'.$data_2[1].'/'.$data_2[0].' '.$data_1[1];
    }

?>

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Origem do Unilevel</h4>
                </div>
                <div class="clearfix"></div>
            </div>



            <div class="portlet-body">

                <div>
                    <button onclick="javascript:history.back()" class="btn btn-default">Voltar</button>
                    <br>
                    <br>
                </div>

                <div class="table-responsive">
                    <table id="extrato" class="table table-striped table-bordered table-hover table-green dataTable" aria-describedby="example-table_info">
                        <thead>

                        <tr role="row">
                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Nome: activate to sort column ascending" style="text-align:center;">Nome</th>
                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Geração: activate to sort column ascending" style="text-align:center;">Geração</th>
                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Pontos: activate to sort column ascending" style="text-align:center;">Pontos</th>
                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example-table" rowspan="1" colspan="1" aria-label="Data: activate to sort column ascending" style="text-align:center;">Data</th>
                        </tr>

                        </thead>

                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                        <?php

                        $sql = " select nome_completo, geracao, pontos, data_processamento data
                                 from pontos_unilevel_origem puo inner join ass_dados_pessoais adp on adp.aid = puo.associado_origem
                                                                 inner join pontos_unilevel pu on pu.puid = puo.puid
                                 where puo.puid = ".$puid."
                                   and pu.aid = ".$Codigo."
                                   and puo.geracao = ".$geracao;

                        $sql = mysql_query($sql);

                        while($lin = mysql_fetch_array($sql))
                        {
                            echo "<tr>";
                            echo "<td>".$lin["nome_completo"]."</td>";
                            echo "<td class=\"text-center\">".$lin["geracao"]."ª</td>";
                            echo "<td class=\"text-center\">".$lin["pontos"]."</td>";
                            echo "<td class=\"text-center\">".FormataDataBR($lin["data"])."</td>";
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