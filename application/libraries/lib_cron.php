<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class lib_cron {

    function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->model("adm/modelgerapontosunilevelmensal","mGeraUnilevel");
        $this->ci->load->model("adm/modelprocessaunilevelmensal","mProcessaUnilevel");
        $this->ci->load->model("adm/modelprocessabinariodiario","mProcessaBinario");
        $this->ci->load->model("adm/modelgeneral","mlog");
        $this->ci->load->model("adm/modelgerafundog12es16comsubfundosegrupos","mGeraFundos");
        $this->ci->load->model("adm/modeldistribuisaldogruposmensal","mDistribui");
        $this->ci->load->model("adm/modelgerafundosdeorigem","mFundosOrigem");
    }

    function geraPontosUnilevelMensal(){
        $this->ci->mGeraUnilevel->geraRegistroPontosUnilevelTodosAssociados();
    }

    function processaUnilevelMensal(){
        $this->ci->mProcessaUnilevel->geraSaldoUnilevelMensalAssociados();
        $this->ci->mProcessaUnilevel->geraSaldo();
        $this->ci->mProcessaUnilevel->geraEntradasUnilevel();
        $this->ci->mProcessaUnilevel->geraRegistroSaldoUnilevelAssociadosRestantes();
    }

    function processaBinarioDiario(){
        /*
        geraRegistroPontosBinarios
        ----------------------------------------------------------------------------------------------------------------
        Pegar todos os associados que estejam ativos e que a pontuação no binário esteja com 0 (zero) na perna da esquerda
        ou na perna da direita. Independente da situação financeira dele, ele não terá saldo gerado pois uma das pernas
        no mínimo estará zerada.
        Busca também os associados que estão com alguma fatura atrazada. Neste caso o sistema ficará aguardando a entrada
        do pagamento das faturas atrazadas para processar os pontos a partir da data de pagamento registrada. Os pontos
        binários do associado continuarão a ser gerados nas pernas da esquerda e da direita enquanto ele estiver irregular.
        Caso esse período de irregularidade chegue a 95 dias, o usuário ficará INATIVO e todas as suas pendências, saldos,
        graduções, pedidos abertos, faturas em atraso, etc, serão desativados.
        Apenas será gerado um novo registro na data atual com a mesma pontuação. Dessa forma nas próximas execuções não
        será necessário recarregá-los.
         */

        $this->ci->mProcessaBinario->geraRegistroPontosBinariosAssociadosSemPontosEComFaturasAtrasadas();
        $this->ci->mProcessaBinario->geraRegistroPontosBinariosAssociadosInativos();

        /*
        getAssociados
        ----------------------------------------------------------------------------------------------------------------
        Aqui o sistema busca todos os associados ativos para converter os pontos binários em valor financeiro no saldo
        dos usuários. Para que os usuários venham nesta consulta é necessário:
            * que eles estejam ativos
            * que o registro na tabela pontos_binarios tenha sido gerado no dia anterior
            * que ele tenha pontos na perna da direita e na perna da esquerda
            * que ele não possua nenhuma fatura atrazada
        Essa consulta retorna os pontos que o usuario possui atualmente(registro de ontem) na perna direita e na perna
        esquerda. Eles poderão ser usados na geração do saldo caso o usuário esteja ativo ontem. Para saber se o usuário
        estava ativo ontem eu verifico se algum  */

        foreach($this->ci->mProcessaBinario->getAssociados() as $result):

            $aid = $result->aid;
            $fid = $result->fid;
            $pid = $result->pid;
            $pontos_direita = $result->pontos_direita;
            $pontos_esquerda = $result->pontos_esquerda;
            $percentual_ganho = $result->percentual_ganho;

            // Este associado não tem fatura com cálculo retroativo
            if ($fid == ""){
                if ($pid != ""){

                    if ($pontos_esquerda < $pontos_direita)
                        $pontosParaProcessar = $pontos_esquerda;
                    else
                        $pontosParaProcessar = $pontos_direita;

                    $pontos_direita = $pontos_direita - $pontosParaProcessar;
                    $pontos_esquerda = $pontos_esquerda - $pontosParaProcessar;

                    $this->ci->mProcessaBinario->atualizaPontosAcumuladosParaGraduacao($aid, $pontosParaProcessar*2);

                    // Busca total de pontos já acumulados pelo associado e verifica se a graduação atual que ele se
                    // encontra condiz com a que ele deveria ter. Caso não, chama o método geraGraduacao()
                    $pontos_acumulados = $this->ci->mProcessaBinario->buscaTotalPontosAcumulados($aid);
                    if ($pontos_acumulados->graduacao_atual != $pontos_acumulados->graduacao_necessaria){
                        $totalPontos = $this->ci->mProcessaBinario->geraGraduacao($aid,$pontos_acumulados->graduacao_necessaria);
                    }

                    $valor = $pontosParaProcessar * $percentual_ganho;
                    if ($valor > 0) {
                        $this->ci->mProcessaBinario->geraValorSaldo($aid, $valor);
                        $this->ci->mProcessaBinario->geraValorEntrada($aid, $valor);
                    } else {
                        $this->ci->mlog->geraLog('INFO',"Nenhum saldo ou entrada gerados",'processaBinarioDiario','index');
                    }

                    $this->ci->mProcessaBinario->geraRegistroPontosBinariosAssociados($aid, $pontos_direita, $pontos_esquerda);
                } else {
                    // @TODO Esta parte do código deverá ser implementada quando os cadastros de clientes estiverem funcionando.
                    // Por hora o log de erro abaixo será implementado, pois não é admitida nenhuma situação em que nesta
                    // parte do código chegue algum associado sem pedido

                    // Logar de ERRO
                }
            }else{
                $dtpagamento = $result->dtpagamento;
                $dtvencimento = $result->dtvencimento;
                $pontos = $this->ci->mProcessaBinario->calculaEProcessaPontosRetroativos($aid,$dtpagamento,$dtvencimento);

                $pontos_direita_disponiveis = $pontos_direita - $pontos->pontos_direita_pgto + $pontos->pontos_direita_venc;
                $pontos_esquerda_disponiveis = $pontos_esquerda - $pontos->pontos_esquerda_pgto + $pontos->pontos_esquerda_venc;

                // Caso alguma das pernas esteja com zero, significa que esse associado não possui pontos a serem
                // transformados em dinheiro, ele simplismente terá o seu registro da tabela pontos_binarios gerado
                if (($pontos_direita_disponiveis == 0) || ($pontos_esquerda_disponiveis == 0)){
                    $this->ci->mProcessaBinario->geraRegistroPontosBinariosAssociados($aid, $pontos_direita_disponiveis, $pontos_esquerda_disponiveis);
                } else {

                    if ($pontos_esquerda_disponiveis < $pontos_direita_disponiveis)
                        $pontosParaProcessar = $pontos_esquerda_disponiveis;
                    else
                        $pontosParaProcessar = $pontos_direita_disponiveis;

                    $pontos_direita_disponiveis = $pontos_direita_disponiveis - $pontosParaProcessar;
                    $pontos_esquerda_disponiveis = $pontos_esquerda_disponiveis - $pontosParaProcessar;

                    $this->ci->mProcessaBinario->atualizaPontosAcumuladosParaGraduacao($aid, $pontosParaProcessar*2);

                    // Busca total de pontos já acumulados pelo associado e verifica se a graduação atual que ele se
                    // encontra condiz com a que ele deveria ter. Caso não, chama o método geraGraduacao()
                    $pontos_acumulados = $this->ci->mProcessaBinario->buscaTotalPontosAcumulados($aid);
                    if ($pontos_acumulados->graduacao_atual != $pontos_acumulados->graduacao_necessaria){
                        $totalPontos = $this->ci->mProcessaBinario->geraGraduacao($aid,$pontos_acumulados->graduacao_necessaria);
                    }

                    $valor = $pontosParaProcessar * $percentual_ganho;
                    if ($valor > 0) {
                        $this->ci->mProcessaBinario->geraValorSaldo($aid, $valor);
                        $this->ci->mProcessaBinario->geraValorEntrada($aid, $valor);
                    } else {
                        $this->ci->mlog->geraLog('ERRO',"Erro ao gerar o valor do saldo e da entrada para o associado #$aid",'processaBinarioDiario','index');
                    }

                    $this->ci->mProcessaBinario->geraRegistroPontosBinariosAssociados($aid, $pontos_direita_disponiveis, $pontos_esquerda_disponiveis);
                }
            }
        endforeach;
    }

    function geraFundoG12eS16ComSubFundosEGrupos(){
        $this->ci->mGeraFundos->geraFundoG12(); // OK
        $this->ci->mGeraFundos->geraSaidasMembrosOrigemFundosG12();
        $this->ci->mGeraFundos->zeraSaldoMembrosFundoG12(); // OK
        $this->ci->mGeraFundos->geraSubFundosQueCompoemG12(); // OK
        $this->ci->mGeraFundos->geraGruposQueCompoemG12(); // OK

        $this->ci->mGeraFundos->geraFundoS16(); // OK
        $this->ci->mGeraFundos->geraSaidasMembrosOrigemFundosS16();
        $this->ci->mGeraFundos->zeraSaldoMembrosFundoS16(); // OK
        $this->ci->mGeraFundos->geraSubFundosQueCompoemS16(); // OK
        $this->ci->mGeraFundos->geraGruposQueCompoemS16(); // OK
    }

    function distribuiSaldoGruposMensal(){

        //##############################################################################################################
        //##############################        DISTRIBUIÇÃO DO BÔNUS GERENCIAL       ##################################
        //##############################################################################################################
        $montanteGrupoGerencial = $this->ci->mDistribui->buscaMontanteGrupo('Gerencial');
        if ($montanteGrupoGerencial > 0) {
            $resultado = $this->ci->mDistribui->buscaFuncionariosComMontanteGrupoGerencialDividido($montanteGrupoGerencial);
            $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Gerencial');
            foreach($resultado as $result):
                $associado = $result->aid;
                $valor = $result->valor_funcionario;

                $origem = $this->ci->mDistribui->buscaOrigemSaldo($associado);

                $this->ci->mDistribui->atualizaSaldoComBonusGerencial($associado,$valor, $origem);
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociado($associado,$valor,$tipoEntrada, $origem);
            endforeach;
        }

        //##############################################################################################################
        //###############################        DISTRIBUIÇÃO DO BÔNUS LINEAR       ####################################
        //##############################################################################################################
        $montanteGrupoLinear = $this->ci->mDistribui->buscaMontanteGrupo('Linear');
        if ($montanteGrupoLinear > 0) {
            $total_associados = $this->ci->mDistribui->buscaTotalAssociadosAReceberBonusLinear();
            if ($total_associados > 0){
                $valor_por_associado = $montanteGrupoLinear/$total_associados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Linear');
                $this->ci->mDistribui->atualizaSaldoComBonusLinear($valor_por_associado);
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLinear($valor_por_associado,$tipoEntrada);
            }
        }

        //##############################################################################################################
        //###############################        DISTRIBUIÇÃO DO BÔNUS CASH       ######################################
        //##############################################################################################################
        $montanteGrupoPopCash = $this->ci->mDistribui->buscaMontanteGrupo('Pop');
        $montanteGrupoMegaCash = $this->ci->mDistribui->buscaMontanteGrupo('Mega');
        $montanteGrupoTopCash = $this->ci->mDistribui->buscaMontanteGrupo('Top');

        $totalAssociadosPop = $this->ci->mDistribui->buscaTotalAssociadosPlanoCash('Pop');
        $totalAssociadosMega = $this->ci->mDistribui->buscaTotalAssociadosPlanoCash('Mega');
        $totalAssociadosTop = $this->ci->mDistribui->buscaTotalAssociadosPlanoCash('Top');

        $totalAssociadosPopMegaTop = $totalAssociadosPop + $totalAssociadosMega + $totalAssociadosTop;
        $totalAssociadosMegaTop = $totalAssociadosMega + $totalAssociadosTop;

        $valorPopCashAPagar = $montanteGrupoPopCash / $totalAssociadosPopMegaTop;
        $valorMegaCashAPagar = $montanteGrupoMegaCash / $totalAssociadosMegaTop;
        $valorTopCashAPagar = $montanteGrupoTopCash / $totalAssociadosTop;

        $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Cash Pop');
        $this->ci->mDistribui->atualizaSaldoComBonusCash($valorPopCashAPagar,"'Pop','Mega','Top'");
        $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosCash($valorPopCashAPagar,$tipoEntrada,"'Pop','Mega','Top'");

        $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Cash Mega');
        $this->ci->mDistribui->atualizaSaldoComBonusCash($valorMegaCashAPagar,"'Mega','Top'");
        $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosCash($valorMegaCashAPagar,$tipoEntrada,"'Mega','Top'");

        $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Cash Top');
        $this->ci->mDistribui->atualizaSaldoComBonusCash($valorTopCashAPagar,"'Top'");
        $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosCash($valorTopCashAPagar,$tipoEntrada,"'Top'");

        //##############################################################################################################
        //###############################        DISTRIBUIÇÃO DO BÔNUS LIDERANÇA       #################################
        //##############################################################################################################
        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Bronze');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Bronze','Prata','Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Bronze');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Bronze','Prata','Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Bronze','Prata','Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Prata');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Prata','Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Prata');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Prata','Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Prata','Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Ouro');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Ouro');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Ouro','Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Ametista');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Ametista');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Ametista','Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Topázio');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Topázio');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Topázio','Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Rubi');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Rubi');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Rubi','Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Safira');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Safira');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Safira','Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Esmeralda');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Esmeralda');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Esmeralda','Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Diamante');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Diamante');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Diamante','Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Duplo Diamante');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Duplo Diamante','Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Duplo Diamante');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Duplo Diamante','Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Duplo Diamante','Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Triplo Diamante');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Triplo Diamante','Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Triplo Diamante');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Triplo Diamante','Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Triplo Diamante','Embaixador'");
            endif;
        endif;

        $montanteGrupo = $this->ci->mDistribui->buscaMontanteGrupo('Embaixador');
        if($montanteGrupo > 0):
            $totalAssociados = $this->ci->mDistribui->buscaTotalAssociadosGraduacao("'Embaixador'");
            if($totalAssociados > 0):
                $valorPorAssociado = $montanteGrupo/$totalAssociados;
                $tipoEntrada = $this->ci->mDistribui->buscaIdTipoEntrada('Liderança Embaixador');
                $this->ci->mDistribui->atualizaSaldoComBonusLideranca($valorPorAssociado,"'Embaixador'");
                $this->ci->mDistribui->incluiRegistroEntradaParaAssociadosLideranca($valorPorAssociado,$tipoEntrada,"'Embaixador'");
            endif;
        endif;
    }

    function geraFundosDeOrigem(){
        $this->ci->mFundosOrigem->geraFundosDeOrigem();
        $this->ci->mFundosOrigem->geraSaidasMembrosFundosDeOrigem();
        $this->ci->mFundosOrigem->zeraSaldosMembrosFundosDeOrigem();

        $this->ci->mFundosOrigem->geraEntradasMembrosFundoDiretoria();
        $this->ci->mFundosOrigem->distribuiFundoDiretoria();

        $this->ci->mFundosOrigem->geraEntradasMembrosFundoProgramadores();
        $this->ci->mFundosOrigem->geraEntradasMembrosFundoJornalistas();

        $this->ci->mFundosOrigem->distribuiFundoProgramadores();
        $this->ci->mFundosOrigem->distribuiFundoJornalistas();

        $this->ci->mFundosOrigem->zeraSaldoDaAmanda();
    }
}
