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


$session_fid = 1;


/// Gerencia Ações Página
$acao = $_GET['acao'];

switch($acao)
{
    // Processa pagamento selecionados  (Alterar codeigniter)
    case 'pps':
        $sdid= $_POST['sdid'];

        foreach($_POST['sdid'] as $campo => $valor )
        {
            mysql_query(" UPDATE ass_solicitacao_deposito SET stid='6', bloqueado = 'S', fid='$session_fid'   WHERE (sdid='$valor') ") or die (mysql_error());
            mysql_query( " INSERT INTO transacao_deposito (stid, sdid) VALUES ('6', '$valor') ") or die (msql_error());
        }

        echo "<script language='JavaScript' type='text/javascript'>
							window.location.href='../../../escritorio-virtual/rede/gerenciarsaque/$Codigo';
						  </script>";

        break;
    // Confirma pagamento
    case 'cps':
        $sdid = $_GET['id'];
        $aid = $_GET['ass']; // Código associado

        // Por segurança verifica antes se o saque ja se encontra confirmado
        $sqlVerificacaoConfirmacaoSaque = mysql_query(" select * from get_solicitar_saque
                where Status != 'Concluido'
                AND sdid = '$sdid'
                ") or die (mysql_error());
        if(mysql_num_rows($sqlVerificacaoConfirmacaoSaque)>0)
        {
            if(($fundo = $this->mass->getFundo($aid)) !== FALSE)
                $origem = $fundo->fid;
            else
                $origem = FALSE;

            if($origem):
                $tabela_saldo = "ass_saldo_membro";
                $omid = 2;
            else:
                $tabela_saldo = "ass_saldo";
                $omid = 1;
            endif;

            $data = date('Y-m-d');
            $data .= ' '.date('H:i:s');
            mysql_query(" UPDATE ass_solicitacao_deposito SET stid='7', data_deposito='$data'  WHERE (sdid='$sdid')  ") or die (mysql_error());
            mysql_query( " INSERT INTO transacao_deposito (stid, sdid) VALUES ('7', '$sdid') ") or die (msql_error());

            // Busca Saldo Atual
            $valorSaldoAtual  = 0;
            $sqlSaldo = mysql_query(" select valor from $tabela_saldo where aid = '$aid'  ") or die (mysql_error());
            $l = mysql_fetch_array($sqlSaldo);
            $valorSaldoAtual  = $l['valor'];


            // Busca Valor Deposito
            $valorSaldoDeposito  = 0;
            $sqlSaldo = mysql_query("select round(valor, 2) valor, round(valor_taxa, 2) valor_taxa, round(valor_inss, 2) valor_inss, round(valor_ir, 2) valor_ir from ass_solicitacao_deposito where sdid = '$sdid'  ") or die (mysql_error());
            $l = mysql_fetch_array($sqlSaldo);
            $valorSaldoDeposito  = $l['valor'];
            $valor_taxa = $l['valor_taxa'];
            $valor_inss = $l['valor_inss'];
            $valor_ir = $l['valor_ir'];
            $valor_total = $valorSaldoDeposito + $valor_taxa + $valor_inss + $valor_ir;

            $Saldo =  $valorSaldoAtual-$valor_total;

            mysql_query(" UPDATE $tabela_saldo SET valor='$Saldo' WHERE (aid='$aid') ") or die (mysql_error());


            // Saída
            mysql_query(" INSERT INTO ass_saida (aid, tsid, omid, valor)
                         VALUES ($aid, 2, $omid, '$valorSaldoDeposito') ") or die(mysql_error());
            // Codigo tsid 2 = Valor
            mysql_query("INSERT INTO ass_saida (aid, tsid, omid, valor)
                         VALUES ($aid, 4, $omid, '$valor_inss') ") or die(mysql_error());
            // Codigo tsid 4 = IRRF
            mysql_query("INSERT INTO ass_saida (aid, tsid, omid, valor)
                         VALUES ($aid, 5, $omid, '$valor_taxa') ") or die(mysql_error());
            // Codigo tsid 5 = Taxa
            if($valor_ir > 0):
                mysql_query("INSERT INTO ass_saida (aid, tsid, omid, valor)
                             VALUES ($aid, 6, $omid, '$valor_ir') ") or die(mysql_error());
                // Codigo tsid 6 = Taxa
            endif;

        }


        echo "<script language='JavaScript' type='text/javascript'>
							window.location.href='../../../escritorio-virtual/rede/gerenciarsaque/$Codigo';
						  </script>";


        break;


    // Cancelar Solicitação
    case 'cancel':

        $sdid = $_GET['id'];
        $aid = $_GET['ass']; // Código associado


        mysql_query(" UPDATE ass_solicitacao_deposito SET stid='4', data_deposito=NULL  WHERE (sdid='$sdid')  ") or die (mysql_error());
        mysql_query( " INSERT INTO transacao_deposito (stid, sdid,detalhes`) VALUES ('4', '$sdid','Cancelado pelo Sicove') ") or die (msql_error());


        echo "<script language='JavaScript' type='text/javascript'>
							// alert('Cadastro realizado com sucesso!');
							window.location.href='../../../escritorio-virtual/rede/gerenciarsaque/$Codigo';
						  </script>";
        break;
}
/// Fim Ações Página
?>

<?php
// Incio Query pesquisa
$sql = "SELECT *
    FROM get_solicitar_saque where 1=1  ";

$DataSolicitacao = "";
if($_GET[p]=='s')
{
    if(!empty($_POST['DataSolicitacao'])):
        $DataSolicitacao = $_POST['DataSolicitacao'];
        $sql .= " and  date_format(data_solicitacao,'%d/%m/%Y')= '".$DataSolicitacao."'  ";
    endif;

    if(!empty($_POST['status_transacao'])):
        $sql .= "  and stid = ".$_POST['status_transacao']."  ";
    endif;
}
//  echo $sql;
$sql .= " order by get_solicitar_saque.sdid ";

$sql = mysql_query($sql);
// Fina Query Pesquisa

// where get_solicitar_saque.`Status` = 'Liberado' or get_solicitar_saque.`Status` = 'Bloqueado'


// Inicia Pesquisa Solicitações Saque
//ho "<form action='escritorio-virtual/empresarios/cadastro' method='post'>";
echo form_open("escritorio-virtual/rede/gerenciarsaque?p=s", $this->config->item('form_style'));
echo "<fieldset>";
echo "<legend> Filtro </legend>";
echo "<label> Data de Solicitação </br> <input type='text' name='DataSolicitacao' id='DataSolicitacao' value='$DataSolicitacao'   style='padding: 5px;' placeholder='dd/mm/aaaa' />  </label>";
echo "</br>";
echo "<label> Meus Processamentos </br> <input type='checkbox' name='MeusProcessamentos' id='MeusProcessamentos' />  </label>";
echo "</br>";
echo "<label> Status </br>  </label>";
echo "</br>";

$sqlStatus = mysql_query(" select * from status_transacao order by descricao ");
echo "<select id='status_transacao' name='status_transacao'>";
echo "<option value=''> Todos </option>";
while($lin = mysql_fetch_array($sqlStatus))
{
    if($_POST['status_transacao']==$lin['stid']){ $marcado = "selected=selected";  } else { $marcado = ""; }
    echo "<option value='".$lin['stid']."' $marcado  >".$lin['descricao']."</option>";
}
echo "</select>";
echo "</br>";
echo "</br>";
echo "<input type='submit' value='Buscar' class='btn btn-white' />";
echo "</br>";
echo "</br>";
echo "<fieldset>";
echo "</form>";


//  echo  $_POST[status_transacao];
// Fim Pesquisa Solicitações Saque


echo form_open("escritorio-virtual/rede/gerenciarsaque?acao=pps", $this->config->item('form_style'));
echo "<table id='table-geral' class='table table-striped table-bordered table-hover table-green''>";

echo "<tr>";
echo "<thead>";
echo "<th> #  </th>";
echo "<th>  Associado </th>";
echo "<th>  V. Bruto </th>";
echo "<th>  V. Taxa/INSS/IRRF  </th>";
echo "<th>  V. Líquido  </th>";
echo "<th> V. Saldo </th>";
echo "<th> Data Solicitação </th>";
echo "<th> Data Depósito </th>";
echo "<th> Selecionar  </th>";
echo "<th> Ações  </th>";
echo "</thead>";
echo "</tr>";

while($lin = mysql_fetch_array($sql))
{
    $DataSolicitacao = substr($lin['data_solicitacao'],0,10);
    $HoraSolicitacao = substr($lin['data_solicitacao'],10,17);

    $DataDeposito = substr($lin['data_deposito'],0,10);
    $HoraDeposito = substr($lin['data_deposito'],10,17);

    if(($fundo = $this->mass->getFundo($lin['aid'])) !== FALSE)
        $origem = $fundo->fid;
    else
        $origem = FALSE;

    if($origem):
        $tabela_saldo = "ass_saldo_membro";
    else:
        $tabela_saldo = "ass_saldo";
    endif;

    $TotalSaldo = mysql_query("SELECT sum(valor) as TotalSaldo  FROM $tabela_saldo WHERE aid='". $lin['aid']. "'") or die (mysql_error());
    $lSaldo = mysql_fetch_array($TotalSaldo);
    $TotalSaldo = $lSaldo["TotalSaldo"];
    $valor_solicitado = $lin['valor'] + $lin['valor_taxa'] + $lin['valor_inss'] + $lin['valor_ir'];

    echo "<tr>";
    echo "<tbody>";
    echo "<td> ". $lin['sdid']. "  </td>";
    echo "<td>".utf8_encode($lin['nome_completo'])."</td>";
    echo "<td>".number_format($valor_solicitado, 2, ',', '.')."</td>";
    echo "<td style=color:red>".number_format($lin['valor_taxa'], 2, ',', '.') . ' / ' . number_format($lin['valor_inss'], 2, ',', '.') . ' / ' . number_format($lin['valor_ir'], 2, ',', '.'). "</td>";
    echo "<td style=color:green>".number_format($lin['valor'], 2, ',', '.')."</td>";

    echo "<td>".number_format($TotalSaldo, 2, ',', '.')."</td>";
    echo "<td>".FormataDataBR($DataSolicitacao)."   -   $HoraSolicitacao </td>";
    echo "<td>".FormataDataBR($DataDeposito)."   -   $HoraDeposito </td>";
    echo "<td>".$lin[Status];
    // Verifica Funcionário
    if(($lin[bloqueado]=='S') and ($lin['Status']=='Bloqueado')){
        $sqlFuncionario = mysql_query("
                                SELECT nome_completo dp
                                FROM ass_dados_pessoais dp INNER JOIN funcionarios f ON f.aid = dp.aid
                                where f.fid = '".$lin['fid']."'"
        );
        $lFuncionario = mysql_fetch_array($sqlFuncionario);

        echo "(".$lFuncionario['nome_completo'].")";

    }
    echo "</td>";

    echo "<td>";
    if($lin['Status']=='Liberado'):
        echo "<input type='checkbox' name='sdid[]' id='sdid' value='".$lin['sdid']."' />";
    endif;

    $attr_ext = array(
        'class'=>'btn btn-social-icon fa fa-money',
        'title'=>'Extrato'
    );
    //echo anchor("escritorio-virtual/rede/exibirsaque?id=$lin[sdid]", ' ', $attr_ext);
    echo anchor("escritorio-virtual/rede/gerenciarsaque", ' ', $attr_ext);

    if( ($lin['bloqueado']=='S') and ($lin['Status']=='Bloqueado')):
        $attr_conf = array(
            'class'=>'btn btn-social-icon fa fa-thumbs-o-up',
            'title'=>'Confirmar'
        );
        echo anchor("escritorio-virtual/rede/gerenciarsaque?acao=cps&id=$lin[sdid]&ass=$lin[aid]", ' ', $attr_conf);
    endif;

    if($lin['Status']=='Liberado'):
        $attr_canc = array(
            'class'=>'btn btn-social-icon fa fa-thumbs-o-down',
            'title'=>'Cancelar'
        );
        echo anchor("escritorio-virtual/rede/gerenciarsaque?acao=cancel&id=$lin[sdid]&ass=$lin[aid]", ' ', $attr_canc);
    endif;

    echo "</tbody>";
    echo "</tr>";
}
echo "</table>";

echo "<input type='submit' value='Processar pagamentos selecionados' class='btn btn-white' />";
echo "</form>";

?>