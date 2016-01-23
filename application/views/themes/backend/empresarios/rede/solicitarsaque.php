<?php error_reporting(0);

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





echo "Saldo atual:  ". number_format($TotalSaldo, 2, ',', '.');
echo "</br>";
echo "Solicitações pendentes:  ". number_format($TotalPendente, 2, ',', '.');
echo "</br>";
// echo "Disponível para solicitações: ". number_format($TotalSaldo-$TotalPendente, 2, ',', '.');

echo "</br>";
echo "</br>";
?>
 <p style="color:green" > <?php echo $this->session->flashdata('mensagem_sucesso');?></p>
<p style="color:red" > <?php echo $this->session->flashdata('mensagem_erro'); ?></p>
<?php echo form_open('escritorio-virtual/rede/salvasolicitarsaque'); ?>
    <div class="row">
    <div class="form-group col-sm-3">

        <input type="hidden" value='<?php echo $Codigo ?>' id='assoc' name='assoc' />

        <?php echo form_label('Valor', 'valor'); ?>
        <div class=" input-group">
            <span class="input-group-addon">R$</span>
            <?php echo form_input(array('name'=>'valor',
                'id'=>'valor',
                'class'=>'form-control',
                'data-required'=>''), set_value('valor'));
            ?>
        </div>
        <?php echo form_error('valor',
            $this->config->item('err_msg_style'),
            $this->config->item('msg_style_end')); ?>
    </div>
</div>
<?php echo form_button($this->config->item('btn_save')); ?>
<?php echo form_close(); ?>

<p style="color:red" >  * O  Associado poderá realizar 1(um) saque por semana (segunda- feira a domingo).   </p>
<p style="color:red" >  * Saque Mínimo R$ 100,00   </p>
<p style="color:red" >  * Taxa Saque R$ 10,00   </p>


<?php

$sql = "SELECT * FROM get_solicitar_saque where get_solicitar_saque.aid=$Codigo  ";


$sql .= " order by get_solicitar_saque.sdid desc ";
$sql = $this->db->query($sql);

echo "<table id='table-geral' class='table table-striped table-bordered table-hover table-green''>";
echo "<tr>";
echo "<thead>";
  echo "<th>  Valor bruto</th>";
  echo "<th>  Taxa / Inss / IRRF</th>";
  echo "<th>  Valor Líquido  </th>";
  echo "<th> Data Solicitação </th>";
  echo "<th> Data Depósito </th>";
  echo "<th> Status </th>";
echo "</thead>";
echo "</tr>";

foreach($sql->result_array() as $lin):
    $DataSolicitacao = substr($lin['data_solicitacao'],0,10);
    $HoraSolicitacao = substr($lin['data_solicitacao'],10,17);

    $DataDeposito = substr($lin['data_deposito'],0,10);
    $HoraDeposito = substr($lin['data_deposito'],10,17);

    $TotalSaldo = $this->db->query(" SELECT sum(ass_saldo.valor) as TotalSaldo  FROM ass_saldo WHERE aid='$lin[aid]' ");
    $lSaldo = $TotalSaldo->result_array();
    $TotalSaldo = $lSaldo["TotalSaldo"];
    $valor_bruto = $lin['valor'] + $lin['valor_inss'] + $lin['valor_ir'] + $this->config->item('taxa_saque');

    echo "<tr>";
    echo "<tbody>";
    echo "<td>R$ ".number_format($valor_bruto, 2, ',', '.')."</td>";
    echo "<td style='color:red'>R$ ".number_format($this->config->item('taxa_saque'), 2, ',', '.').' / R$ '.number_format($lin['valor_inss'], 2, ',', '.').' / R$ '.number_format($lin['valor_ir'], 2, ',', '.')."</td>";
    echo "<td style=color:green>R$ ".number_format($lin['valor'], 2, ',', '.')."</td>";
    echo "<td>".FormataDataBR($DataSolicitacao)."   -   $HoraSolicitacao </td>";
    echo "<td>".FormataDataBR($DataDeposito)."   -   $HoraDeposito </td>";
    echo "<td>";
    if(($lin['Status']=='Liberado') or ($lin['Status']=='Bloqueado'))
    {
        echo "Pendente";
    }
    else
    {
        echo $lin['Status'];
    }

    // Verifica Funcionário
    if(($lin['bloqueado']=='S') and ($lin['Status']=='Bloqueado')){
        $sqlFuncionario = $this->db->query(" SELECT   ass_dados_pessoais.nome_completo
            FROM  ass_dados_pessoais INNER JOIN funcionarios ON funcionarios.aid = ass_dados_pessoais.aid
            where  funcionarios.fid = '$lin[fid]'    ");
        $lFuncionario = $sqlFuncionario->result_array();

        //echo "(".$lFuncionario[nome_completo].")";
    }
    echo "</td>";
    echo "</tbody>";
    echo "</tr>";
endforeach;
echo "</table>";


?>
