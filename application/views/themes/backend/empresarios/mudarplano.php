<?php
// Verifica plano Atual Associado
$sqlVerificaPlano = mysql_query(" select aid, `status`
     from get_faturas where status = 'Pendente' and aid='$Codigo'  ") or die (mysql_error());

if(mysql_num_rows($sqlVerificaPlano)>0)
{
    echo "<div style='color:red'>".
         "Prezado cliente, para mudar de plano é necessário quitar todas as faturas pendentes.<br>".
         "Se você já efetuou o pagamento de suas faturas, por favor aguarde o tempo de compensação do pagamento e tente novamente.<br>".
         "Caso tenha alguma dúvida, entre em contato com nossa ". anchor("http://www.sicove.com.br/#contact", "central de relacionamento").
         " informando também o seu login para que possamos agilizar seu atendimento.".
         "</di>";
    echo anchor('escritorio-virtual/dashboard', 'Voltar');
}else
{
    $sqlBuscaOrdemPlano = mysql_query(" select nmplano, qtde_cadernos, ordem, valor_plano, pontos_binario, pontos_unilevel  from associados
        inner join planos on associados.plano_atual = planos.pid
        where aid = $Codigo
         ") or die (mysql_error());

    $lin = mysql_fetch_array($sqlBuscaOrdemPlano);
    $ordem = $lin['ordem']; // Busca Ordem Plano
    $ValorPlanoAtual = $lin['valor_plano'];
    $pontos_binario = $lin['pontos_binario'];
    $pontos_unilevel = $lin['pontos_unilevel'];
    $qtd_cad_atuais = $lin['qtde_cadernos'];

    echo "Plano Atual: ".$lin['nmplano'];

    $sqlExibePlanos = mysql_query(" select * from planos where ordem > '$ordem'  order by ordem   ") or die (mysql_error());

    echo "</br>";
    echo "</br>";


    echo "<p style='color:red' >".$this->session->flashdata('mensagem_plano')."</p>";
    echo "<p style='color:red' >".$this->session->flashdata('mensagem_caderno')."</p>";

    echo form_open("escritorio-virtual/dashboard/salvamudarplano");

    ?>
    <input type="hidden" name="qtde_cadernos" id="qtde_cadernos"  value="0" />
    <input type="hidden" name="aid" id="aid"  value="<?php echo $Codigo ?>" />
    <input type="hidden" name="qtde_cadernos_marcados" id="qtde_cadernos_marcados"  value="0" />

    <?php

    echo " <h4>  Escolha o novo plano </h4>";
    echo "  <div class='row pricing-circle'>";

    while($lin = mysql_fetch_array($sqlExibePlanos))
    {
        ?>
        <div class="col-md-4">
            <ul class="plan plan1">
                <li class="plan-name">
                    <h3><?php echo $lin['nmplano'] ?></h3>
                </li>
                <li class="plan-price">
                    <div> <span class="price" ><sup>R$</sup><?php echo number_format($lin['valor_plano']-$ValorPlanoAtual, 2, ',', ' ');  ?></span> <!-- <small>month</small> --> </div>
                </li>
                <li> <strong>Valor Plano: </strong> R$
                    <?php echo $lin['valor_plano']-$ValorPlanoAtual;   ?>  </li>
                <li> <strong>Pagamento: </strong> <?php echo "A VISTA" ?>  </li>
                <li> <strong>Pontos Unilevel: </strong> <?php echo  $lin['pontos_unilevel']-$pontos_unilevel ?>  </li>
                <li> <strong>Pontos Binário: </strong> <?php echo $lin['pontos_binario']-$pontos_binario ?>  </li>
                <li> <strong>Quantidade Cadernos: </strong> <?php echo $lin['qtde_cadernos'] ?>  </li>

                <li class="plan-action"> <?php
                    $js = '  class="pid" ';
                    //		echo form_radio('pid', $v->pid, TRUE, $js)
                    ?>
                    <input type="radio" name="pid" id="pid"  value="<?php echo $lin['pid'] ?>" class="pid"  onclick="pid_click('<?php echo $lin['qtde_cadernos']-$qtd_cad_atuais ?>');" />
                </li>
            </ul>
        </div>
        <?php

        ?>
    <?php

    }
    echo "</div>";


    $sqlCadernos = mysql_query(" select * from cadernos order by descricao   ") or die (mysql_error());
    $qtd_cadernos = 0;
    echo " <table class='table table-striped table-bordered table-hover table-green' style='width: 150px;'>";

    echo "<tr>";

    echo "<th colspan='2'> Cadernos  </th>";

    echo "</tr>";
    while($lin = mysql_fetch_array($sqlCadernos))
    {
        echo "<tr>";
        echo "<td> $lin[descricao]   </td>";

        $sqlVerificaCadernoAssociado = mysql_query(" select * from ass_caderno  where aid=$Codigo and cid=$lin[cid] and status = 'Ativo' ") or die (mysql_error());
        if(mysql_num_rows($sqlVerificaCadernoAssociado)>0)
        {

            ?>  <td> - </td><?php
        }
        else
        {
            $qtd_cadernos++;
            $selecionado = " ";
            ?> <td> <input type='checkbox' id="cid_<?php echo $qtd_cadernos ?>" name="cid[]" value="<?php echo $lin['cid'] ?>" onclick="return VerificaCadernosMarcados(this)" /> </td>
        <?php
        }
        echo "</tr>";
    }
    echo "</table>";

    ?>  <input type="submit" class="btn btn-green ladda-button" value="Salvar" />
<?php
}
?>

<?php echo form_close(); ?>

<script>
    function VerificaCadernosMarcados(campo)
    {
        if(document.getElementById('qtde_cadernos_marcados').value >= document.getElementById('qtde_cadernos').value && campo.checked)
        {
            alert("Quantidade máxima de cadernos atingida.");
            campo.checked = false;
            return true;
        }

        if(campo.checked)
            document.getElementById('qtde_cadernos_marcados').value++;
        else
            document.getElementById('qtde_cadernos_marcados').value--;

    }

    function pid_click(valor)
    {
        document.getElementById('qtde_cadernos').value = valor;
        document.getElementById('qtde_cadernos_marcados').value = 0;

        <?php for($c=1;$c<$qtd_cadernos;$c++){ ?>
        document.getElementById('cid_<?php echo $c; ?>').checked = false;
        <?php } ?>
    }
</script>