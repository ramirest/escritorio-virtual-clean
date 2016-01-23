<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_associados {

    function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->helper("text");
        $this->ci->load->library('DX_Auth');
        $this->ci->load->library("typography");
        $this->ci->load->library('Session');
        $this->ci->load->library("data");
        $this->ci->load->model('adm/ModelAssociados', 'mass');
        $this->ci->load->model('Modelboleto', 'mboleto');
        $this->ci->load->model('adm/Modelplanos', 'mplano');
        $this->ci->load->model('adm/Modelpedidos', 'mped');
        $this->ci->load->model('adm/Modelrede', 'mrede');
    }

    public function _getNomeAssociado($associado="", $sobrenome = FALSE){
        $aid = $associado==""?$this->ci->dx_auth->get_associado_id():$associado;
        $dados = word_limiter($this->ci->mass->get_name($aid)->nome,$sobrenome===TRUE?2:1,"");
        return $dados;
    }

    public function set_patrocinador($patrocinador){
        if(($patrocinador = $this->ci->mass->getAssociado('', 'Login', $patrocinador)) !== FALSE):
            $pat = $patrocinador->row();
            $this->ci->session->set_userdata('patrocinador', $pat);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function get_saldo(){
        if(($rendimentos = $this->ci->mped->get_saldo($this->ci->dx_auth->get_associado_id())) !== FALSE)
            $saldo = $rendimentos;
        else
            $saldo = '0.00';

        return $saldo;
    }

    function salvar_imoveis(){
        $form = $this->_get_form_values();
        //efetua o cadastro do associado
        if(($id = $this->ci->mass->pre_cadastro($form)) !== FALSE):

            $this->ci->session->set_userdata("aid",$id);
            //cria o associado de acesso ao sistema e envia um email de confirmacao
            $this->ci->dx_auth->register($form['infoconta']['login'], $form['infoconta']['senha'], $form['infocontato']['email'], $id);

            //configuracao do boleto
            if(($boleto = $this->ci->mboleto->getBoleto()) !== FALSE):
                foreach($boleto->result() as $result):
                    $dados_boleto['all'] = $result;
                endforeach;

                //vencimento da taxa de adesao
                $vencimento = date("Y-m-d", now() + ($dados_boleto['all']->dias_prazo_pagamento * 86400));

                $valor_cobrado = str_replace(",", ".",$this->ci->config->item('taxa_adesao'));
                //calcula valor da taxa de adesao
                $valor=number_format($valor_cobrado+$dados_boleto['all']->taxa_boleto, 2, ',', '');


                //gera faturas
                $this->ci->mped->geraFatura($this->ci->mass->aid, $vencimento, $valor);
                $msg =
                    $this->ci->config->item('suc_msg_style').
                    'Seu cadastro foi efetuado com sucesso!<br>'.
                    'Segue abaixo seus dados cadastrados, utilize-os para acessar o sistema.<br><br>'.
                    'Nome: '.$form['dados_pessoais']['nome_completo']."<br>".
                    'ID: '.$id."<br>".
                    'Login: '.$form['infoconta']['login']."<br>".
                    'Email: '.$form['infocontato']['email']."<br>".
                    'Senha: Por questões de segurança não exibiremos sua senha,
                    guarde-a em local seguro e utilize-a juntamente com seu login ou email para acessar o sistema. <br><br>
                    Seja bem vindo ao SICOVE!<br><br>'.
                    '<strong>Equipe SICOVE</strong>'.
                    $this->ci->config->item('msg_style_end');




            endif;
            return $msg;
        else:
            return FALSE;
        endif;
    }


    function adicionar() {
        $form = $this->_get_form_values();
        //efetua o cadastro do associado
        if(($id = $this->ci->mass->inserirAssociado($form)) !== FALSE):
            //cria o associado de acesso ao sistema e envia um email de confirmacao
            $this->ci->dx_auth->register($form['infoconta']['login'], $form['infoconta']['senha'], $form['infocontato']['email'], $id);

            /*
            switch($count = $this->ci->mass->get_num_afiliados($form['infoconta']['patrocinador'])):
              case $count < 5:
                  $this->ci->mass->alterarQualificacao($form['infoconta']['patrocinador'], 2);
                  break;
              case $count == 5:
                  $this->ci->mass->alterarQualificacao($form['infoconta']['patrocinador'], 3);
                  break;
              case $count == 10:
                  $this->ci->mass->alterarQualificacao($form['infoconta']['patrocinador'], 4);
                  break;
              case $count == 50:
                  $this->ci->mass->alterarQualificacao($form['infoconta']['patrocinador'], 5);
                  break;
            endswitch;
            */


            //configuracao do boleto
            if(($boleto = $this->ci->mboleto->getBoleto()) !== FALSE):
                foreach($boleto->result() as $result):
                    $dados_boleto['all'] = $result;
                endforeach;

                //vencimento da taxa de adesao
                $vencimento = date("Y-m-d", now() + ($dados_boleto['all']->dias_prazo_pagamento * 86400));

                //verifica se o periodo de pré-cadastro está habilitado
                $pre = $this->ci->config->item('precadastro') === TRUE?30:0;

                $valor_cobrado = str_replace(",", ".",$this->ci->config->item('taxa_adesao')+$pre);
                //calcula valor da taxa de adesao
                $valor=number_format($valor_cobrado+$dados_boleto['all']->taxa_boleto, 2, ',', '');

                //seleciona o valor da entrada do plano escolhido caso não seja um cadastro de consumidor
                if(($plano = $this->ci->mplano->getPlano('pid',$form['plano']['pid'])) !== FALSE):
                    foreach($plano->result() as $p):
                        $valor_entrada = $p->valor_plano > 0?$p->valor_entrada - $pre:0;
                        $valor_plano = $p->valor_plano > 0?$p->valor_parcelas:0;
                        $valor_total = $p->valor_plano > 0?$p->valor_plano:0;
                    endforeach;
                else:
                    $valor_plano = 0;
                endif;

                //gera faturas
                if($valor_plano > 0):
                    if($form['forma_pgto_plano'] == 'AP'):
                        //taxa de adesao e pre-cadastro (se estiver ativo)
                        $this->ci->mped->geraFatura($this->ci->mass->aid, $vencimento, $valor);
                        for($i=1;$i<=$this->config->item('total_parcelas');$i++):
                            if($i == 1):
                                //gera fatura com o valor da entrada
                                $this->ci->mped->geraFatura($this->ci->mass->aid, $vencimento, $valor_entrada);
                            else:
                                for($v=30;$v<=($this->config->item('total_parcelas')-1*30);$v+30):
                                    //gera faturas com o valor das parcelas
                                    $this->ci->mped->geraFatura($this->ci->mass->aid, $vencimento+$v, $valor_plano, 'Mensalidade');
                                endfor;
                            endif;

                        endfor;
                    else:
                        $this->ci->mped->geraFatura($this->ci->mass->aid, $vencimento, $valor_total);
                    endif;
                endif;
                //configura exibicao do boleto
                $this->ci->session->set_flashdata('nome', $form['dados_pessoais']['nome_completo']);
                $this->ci->session->set_flashdata('id', $id);
                $this->ci->session->set_flashdata('login', $form['infoconta']['login']);
                $this->ci->session->set_flashdata('email', $form['infocontato']['email']);
            endif;
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function _get_form_values($editando = FALSE)
    {
        if($editando===TRUE):
            //caso esteja editando um registro
            $v['dados_pessoais']['aid'] = $this->ci->input->post('aid');
        endif;
        //dados pessoais
        $v['dados_pessoais']['tp_cadastro'] = $this->ci->input->post('tp_cadastro');
        $v['dados_pessoais']['nome_completo'] = $this->ci->typography->format_characters($this->ci->input->post('nome_completo'));
        $v['dados_pessoais']['sexo'] = $this->ci->input->post('sexo');
        $v['dados_pessoais']['dtnasc'] = $this->ci->data->human_to_mysql($this->ci->input->post('dtnasc'));
        $v['dados_pessoais']['cpf'] = $this->ci->input->post('cpf');
        $v['dados_pessoais']['rg'] = $this->ci->input->post('rg');
        $v['dados_pessoais']['pis_pasep'] = $this->ci->input->post('pis_pasep');
        $v['dados_pessoais']['profissao'] = $this->ci->typography->format_characters($this->ci->input->post('profissao'));
        $v['dados_pessoais']['funcao_empresa'] = $this->ci->typography->format_characters($this->ci->input->post('funcao_empresa'));
        if($this->ci->input->post('tp_cadastro') == 'PJ'):
            $v['dados_empresa']['nome_fantasia'] = $this->ci->input->post('nome_fantasia');
            $v['dados_empresa']['razao_social'] = $this->ci->input->post('razao_social');
            $v['dados_empresa']['cnpj'] = $this->ci->input->post('cnpj');
            $v['dados_empresa']['ie'] = $this->ci->input->post('ie');
        endif;

        //endereco
        $v['endereco']['tipo'] = $this->ci->input->post('tipo');
        $v['endereco']['cep'] = $this->ci->input->post('cep');
        $v['endereco']['logradouro'] = $this->ci->typography->format_characters($this->ci->input->post('logradouro'));
        $v['endereco']['numero'] = $this->ci->input->post('numero');
        $v['endereco']['complemento'] = $this->ci->input->post('complemento');
        $v['endereco']['bairro'] = $this->ci->typography->format_characters($this->ci->input->post('bairro'));
        $v['endereco']['cidade'] = $this->ci->typography->format_characters($this->ci->input->post('cidade'));
        $v['endereco']['estado'] = $this->ci->input->post('estado');

        //informacoes para contato
        $v['infocontato']['numtel'] = $this->ci->input->post('numtel');
        $v['infocontato']['numcel'] = $this->ci->input->post('numcel');
        $v['infocontato']['email'] = $this->ci->input->post('email');

        //informacoes da conta do associado
        $v['infoconta']['login'] = $this->ci->input->post('login');
        $v['infoconta']['senha'] = $this->ci->input->post('senha');
        $v['infoconta']['patrocinador'] = $this->ci->input->post('patrocinador');
        //rede onde o associado deverá ser alocado
        $v['infoconta']['rede_alocacao'] = $this->ci->input->post('rede_alocacao');

        //informacoes para bancárias para recebimento
        $v['infobanco']['titular'] = $this->ci->input->post('titular');
        $v['infobanco']['banco'] = $this->ci->input->post('banco');
        $v['infobanco']['tpconta'] = $this->ci->input->post('tpconta');
        $v['infobanco']['agencia'] = $this->ci->input->post('agencia');
        $v['infobanco']['conta'] = $this->ci->input->post('conta');
        $v['infobanco']['op'] = $this->ci->input->post('op');

        //informações sobre o plano
        /* 		$v['plano']['pid'] = $this->ci->input->post('plano');
         */
        //Forma de pagamento do plano
        /*         $v['forma_pgto'] = $this->ci->input->post('forma_pgto_plano');
         */
        return $v;

    }

}

/* End of file lib_associados.php */
/* Location: ./system/application/libraries/lib_associados.php */