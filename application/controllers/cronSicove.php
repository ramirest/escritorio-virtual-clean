<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Script de execução mensal
 *
 * Será executado à 03:10h do dia 1º de cada mês
 *
 */

class CronSicove extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("adm/modelcron","mcron");
        $this->load->library('lib_cron');
    }

    function index(){
        if(date('d') == 01):
            //script para o dia 01
            if($this->mcron->verificaStatusScript('geraPontosUnilevelMensal') === TRUE):
                $this->lib_cron->geraPontosUnilevelMensal();
            endif;
        elseif(date('d') == 05):
            //script para o dia 05
            if($this->mcron->verificaStatusScript('processaUnilevelMensal') === TRUE):
                $this->lib_cron->processaUnilevelMensal();
            endif;

            //script para o dia 05
            if($this->mcron->verificaStatusScript('geraFundoG12eS16ComSubFundosEGrupos') === TRUE):
                $this->lib_cron->geraFundoG12eS16ComSubFundosEGrupos();
            endif;

            //script para o dia 05
            if($this->mcron->verificaStatusScript('distribuiSaldoGruposMensal') === TRUE):
                $this->lib_cron->distribuiSaldoGruposMensal();
            endif;
        endif;


        //script diario
        if($this->mcron->verificaStatusScript('geraFundosDeOrigem') === TRUE):
            $this->lib_cron->geraFundosDeOrigem();
        endif;

        //script diario
        if($this->mcron->verificaStatusScript('processaBinarioDiario') === TRUE):
            $this->lib_cron->processaBinarioDiario();
        endif;

    }
}

/* End of file lib_cron.php */
/* Location: ./system/application/controllers/lib_cron.php */