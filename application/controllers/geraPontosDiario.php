<?php

/**
 * Classe com os métodos para geração dos pontos diário do associado.
 *
 * @author	Ramires Teixeira
 * @date 05/2014
 * @version	1.0.0
 *
 */

class GeraPontosDiario extends CI_Controller {


    function __construct(){
        parent::__construct();
        $this->load->library("general");
        $this->load->model("adm/modelGeneral", "mlog");
        $this->load->model("adm/modelpontos", "mpt");
    }

    /**
     * @abstract Busca as faturas que ainda não tiveram seus pontos processados e executa o processamentos destes.
     *           Primeiramente a busca é feita nos pedidos efetuados de planos através das tabelas ass_pedidos e ass_faturas
     *           e posteriormente busca nos pedidos efetuados de produtos através do escritório virtual
     */

    function index(){
        $hoje = date("Y-m-d", mktime(0,0,0, date('m', time()), date('d', time()), date('Y', time())));
        //Busca todas as faturas pagas, que gerem bônus, que não sejam doações e que tenham os pontos binário e unilevel maior que zero
        if(($dados = $this->mpt->getFaturasPagas("aid, doacao, fid, pedido, gera_bonus, pontos_binario, pontos_unilevel, dtpagamento")) !== FALSE):
            foreach($dados as $fatura):
                //Gera os pontos binário para toda a rede upline do associado
                if($fatura->pontos_binario > 0)
                  $this->pontosBinario($fatura->aid, $fatura, $hoje);
                //Gera os pontos unilevel para toda a rede upline do associado
                if($fatura->pontos_unilevel > 0)
                  $this->pontosUnilevel($fatura->aid, $fatura->pontos_unilevel, $fatura->dtpagamento);
            endforeach;
        else:
            $this->mlog->geraLog("INFO", "Nenhum ponto a ser gerado", "geraPontosDiario", "index");
        endif;
    }

    /*
     * @abstract Método gerador dos pontos binário que será executado de hora em hora no servidor.
     *           Será feita uma verificação na tabela de faturas para obter as faturas que foram pagas
     *           pelos empresários e que ainda não tenham gerado os devidos pontos na rede
     */
    //Variavel que irá conter o ID do próximo upline que irá receber os pontos

    public function pontosBinario($aid, $fatura, $hoje)
    {
        $next = $aid;
        do{
            $next = $this->mpt->geraPontosBinario($next, $fatura->pontos_binario, $hoje);
            if($next == 1)
                break;
            //Se ao final do bloco de geração de pontos houver mais registros a serem processados,
            // executa o loop novamente
        }while(($this->mpt->BuscaProximoUpline($next)) !== FALSE);
        //Marca, na fatura, a data/hora em que os pontos foram gerados
        $this->mpt->setDtgeracao_pontos($fatura->fid);
    }

    function pontosUnilevel($aid, $pontos, $dtpagamento)
    {
        $data = explode('-', $dtpagamento);
        $mes = $data[1];
        $ano = $data[0];
        if($this->mpt->geraPontosUnilevelOrigem($aid, $pontos, $dtpagamento, $mes, $ano) === TRUE):
            $this->mpt->geraPontosUnilevel($aid, $pontos, $mes, $ano);
        else:
            $this->mlog->geraLog("ERRO", "Falha ao gerar os pontos unilevel para a fatura do usuário #$aid", "geraPontosDiario", "pontosUnilevel");
        endif;

    }



}


/* End of file geraPontosDiario.php */
/* Location: ./system/application/controllers/geraPontsDiario.php */
