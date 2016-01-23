<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DesativaAssociados extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("adm/ModelDesativaAssociados","mDesativa");
        $this->load->model("adm/modelgeneral","mlog");
        $this->load->library("session");
    }

    function index(){
        $associados = "";
        $a1="";
        $a2="";
        $a3="";
        $a4="";
        $a5="";
        $a6="";
        $a7="";
        $a8="";
        $a9="";

        $b1="";
        $b2="";
        $b3="";
        $b4="";
        $b5="";
        $b6="";
        $b7="";
        $b8="";
        $b9="";

        $resultado = $this->mDesativa->getAssociadosSemRenovacaoApos1Ano();
        foreach($resultado as $result):
            if ($associados!=""):
                $associados = $associados + "," + $result->aid;
            else:
                $associados = $result->aid;
            endif;
        endforeach;

        $data = date("Y-m-d H:i:s ");

        if($associados != ""){
            $a1 = $this->mDesativa->mudaStatusAssociadoParaInativo($associados);
            $a2 = $this->mDesativa->zeraPontosAcumulados($associados);
            $a3 = $this->mDesativa->zeraPontosUnilevel($associados);
            $a4 = $this->mDesativa->zeraPontosBinario($associados);
            $a5 = $this->mDesativa->geraSolicitacaoSaqueParaAssociadosComSaldo($associados,$data);
            $a6 = $this->mDesativa->geraStatusTransacaoSolicitacaoSaque($associados,$data);
            $a7 = $this->mDesativa->zeraSaldo($associados);
            $a8 = $this->mDesativa->desativaPedidos($associados);
            $a9 = $this->mDesativa->desativaGraduacoes($associados);

            if($a1 == true):
                $tplog['a1'] = 'INFO';
                $msglog['a1'] = 'Mudança de status do associado para inativo efetuada com sucesso. Associados: '.$associados;
            else:
                $tplog['a1'] = 'ERRO';
                $msglog['a1'] = 'Ocorreu um erro ao mudar o status do associado para inativo. Associados: '.$associados;
            endif;
            if($a2 == true):
                $tplog['a2'] = 'INFO';
                $msglog['a2'] = 'Os pontos acumulados foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['a2'] = 'ERRO';
                $msglog['a2'] = 'Ocorreu um erro ao zerar os pontos acumulados. Associados: '.$associados;
            endif;
            if($a3 == true):
                $tplog['a3'] = 'INFO';
                $msglog['a3'] = 'Os pontos unilevel foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['a3'] = 'ERRO';
                $msglog['a3'] = 'Ocorreu um erro ao zerar os pontos unilevel. Associados: '.$associados;
            endif;
            if($a4 == true):
                $tplog['a4'] = 'INFO';
                $msglog['a4'] = 'Os pontos binário foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['a4'] = 'ERRO';
                $msglog['a4'] = 'Ocorreu um erro ao zerar os pontos binário. Associados: '.$associados;
            endif;
            if($a5 == true):
                $tplog['a5'] = 'INFO';
                $msglog['a5'] = 'Soliticações de saque geradas com sucesso. Associados: '.$associados;
            else:
                $tplog['a5'] = 'ERRO';
                $msglog['a5'] = 'Ocorreu um erro ao gerar solicitações de saque. Associados: '.$associados;
            endif;
            if($a6 == true):
                $tplog['a6'] = 'INFO';
                $msglog['a6'] = 'Status da transação na solicitação de saque gerado com sucesso. Associados: '.$associados;
            else:
                $tplog['a6'] = 'ERRO';
                $msglog['a6'] = 'Ocorreu um erro ao gerar status da transação na solicitação de saque. Associados: '.$associados;
            endif;
            if($a7 == true):
                $tplog['a7'] = 'INFO';
                $msglog['a7'] = 'Os saldos foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['a7'] = 'ERRO';
                $msglog['a7'] = 'Ocorreu um erro ao zerar os saldos. Associados: '.$associados;
            endif;
            if($a8 == true):
                $tplog['a8'] = 'INFO';
                $msglog['a8'] = 'Os pedidos foram desativados com sucesso. Associados: '.$associados;
            else:
                $tplog['a8'] = 'ERRO';
                $msglog['a8'] = 'Ocorreu um erro ao desativar os pedidos. Associados: '.$associados;
            endif;
            if($a9 == true):
                $tplog['a9'] = 'INFO';
                $msglog['a9'] = 'As graduações foram zeradas com sucesso. Associados: '.$associados;
            else:
                $tplog['a9'] = 'ERRO';
                $msglog['a9'] = 'Ocorreu um erro ao desativar as graduações. Associados: '.$associados;
            endif;

            $this->mlog->geraLog($tplog['a1'], $msglog['a1'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'mudaStatusAssociadoParaInativo');
            $this->mlog->geraLog($tplog['a2'], $msglog['a2'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'zeraPontosAcumulados');
            $this->mlog->geraLog($tplog['a3'], $msglog['a3'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'zeraPontosUnilevel');
            $this->mlog->geraLog($tplog['a4'], $msglog['a4'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'zeraPontosBinario');
            $this->mlog->geraLog($tplog['a5'], $msglog['a5'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'geraSolicitacaoSaqueParaAssociadosComSaldo');
            $this->mlog->geraLog($tplog['a6'], $msglog['a6'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'geraStatusTransacaoSolicitacaoSaque');
            $this->mlog->geraLog($tplog['a7'], $msglog['a7'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'zeraSaldo');
            $this->mlog->geraLog($tplog['a8'], $msglog['a8'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'desativaPedidos');
            $this->mlog->geraLog($tplog['a9'], $msglog['a9'], 'desativaAssociados/getAssociadosSemRenovacaoApos1Ano', 'desativaGraduacoes');

        }

        $associados = "";

        $resultado = $this->mDesativa->getAssociadosFaturasAtrasadas();
        foreach($resultado as $result):
            if ($associados!=""):
                $associados = $associados + "," + $result->aid;
            else:
                $associados = $result->aid;
            endif;
        endforeach;

        if($associados != ""){
            $b1 = $this->mDesativa->mudaStatusAssociadoParaInativo($associados);
            $b2 = $this->mDesativa->zeraPontosAcumulados($associados);
            $b3 = $this->mDesativa->zeraPontosUnilevel($associados);
            $b4 = $this->mDesativa->zeraPontosBinario($associados);
            $b5 = $this->mDesativa->geraSolicitacaoSaqueParaAssociadosComSaldo($associados,$data);
            $b6 = $this->mDesativa->geraStatusTransacaoSolicitacaoSaque($associados,$data);
            $b7 = $this->mDesativa->zeraSaldo($associados);
            $b8 = $this->mDesativa->desativaPedidos($associados);
            $b9 = $this->mDesativa->desativaGraduacoes($associados);

            if($b1 == true):
                $tplog['b1'] = 'INFO';
                $msglog['b1'] = 'Mudança de status do associado para inativo efetuada com sucesso. Associados: '.$associados;
            else:
                $tplog['b1'] = 'ERRO';
                $msglog['b1'] = 'Ocorreu um erro ao mudar o status do associado para inativo. Associados: '.$associados;
            endif;
            if($b2 == true):
                $tplog['b2'] = 'INFO';
                $msglog['b2'] = 'Os pontos acumulados foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['b2'] = 'ERRO';
                $msglog['b2'] = 'Ocorreu um erro ao zerar os pontos acumulados. Associados: '.$associados;
            endif;
            if($b3 == true):
                $tplog['b3'] = 'INFO';
                $msglog['b3'] = 'Os pontos unilevel foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['b3'] = 'ERRO';
                $msglog['b3'] = 'Ocorreu um erro ao zerar os pontos unilevel. Associados: '.$associados;
            endif;
            if($b4 == true):
                $tplog['b4'] = 'INFO';
                $msglog['b4'] = 'Os pontos binário foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['b4'] = 'ERRO';
                $msglog['b4'] = 'Ocorreu um erro ao zerar os pontos binário. Associados: '.$associados;
            endif;
            if($b5 == true):
                $tplog['b5'] = 'INFO';
                $msglog['b5'] = 'Soliticações de saque geradas com sucesso. Associados: '.$associados;
            else:
                $tplog['b5'] = 'ERRO';
                $msglog['b5'] = 'Ocorreu um erro ao gerar solicitações de saque. Associados: '.$associados;
            endif;
            if($b6 == true):
                $tplog['b6'] = 'INFO';
                $msglog['b6'] = 'Status da transação na solicitação de saque gerado com sucesso. Associados: '.$associados;
            else:
                $tplog['b6'] = 'ERRO';
                $msglog['b6'] = 'Ocorreu um erro ao gerar status da transação na solicitação de saque. Associados: '.$associados;
            endif;
            if($b7 == true):
                $tplog['b7'] = 'INFO';
                $msglog['b7'] = 'Os saldos foram zerados com sucesso. Associados: '.$associados;
            else:
                $tplog['b7'] = 'ERRO';
                $msglog['b7'] = 'Ocorreu um erro ao zerar os saldos. Associados: '.$associados;
            endif;
            if($b8 == true):
                $tplog['b8'] = 'INFO';
                $msglog['b8'] = 'Os pedidos foram desativados com sucesso. Associados: '.$associados;
            else:
                $tplog['b8'] = 'ERRO';
                $msglog['b8'] = 'Ocorreu um erro ao desativar os pedidos. Associados: '.$associados;
            endif;
            if($b9 == true):
                $tplog['b9'] = 'INFO';
                $msglog['b9'] = 'As graduações foram zeradas com sucesso. Associados: '.$associados;
            else:
                $tplog['b9'] = 'ERRO';
                $msglog['b9'] = 'Ocorreu um erro ao desativar as graduações. Associados: '.$associados;
            endif;

            $this->mlog->geraLog($tplog['b1'], $msglog['b1'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'mudaStatusAssociadoParaInativo');
            $this->mlog->geraLog($tplog['b2'], $msglog['b2'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'zeraPontosAcumulados');
            $this->mlog->geraLog($tplog['b3'], $msglog['b3'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'zeraPontosUnilevel');
            $this->mlog->geraLog($tplog['b4'], $msglog['b4'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'zeraPontosBinario');
            $this->mlog->geraLog($tplog['b5'], $msglog['b5'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'geraSolicitacaoSaqueParaAssociadosComSaldo');
            $this->mlog->geraLog($tplog['b6'], $msglog['b6'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'geraStatusTransacaoSolicitacaoSaque');
            $this->mlog->geraLog($tplog['b7'], $msglog['b7'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'zeraSaldo');
            $this->mlog->geraLog($tplog['b8'], $msglog['b8'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'desativaPedidos');
            $this->mlog->geraLog($tplog['b9'], $msglog['b9'], 'desativaAssociados/getAssociadosFaturasAtrasadas', 'desativaGraduacoes');

        }

    }
}