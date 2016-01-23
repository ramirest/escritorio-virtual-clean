<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresarios extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('adm/ModelAssociados', 'mass');
        $this->load->model("adm/Modelrede", "mrede");
        $this->load->model('adm/ModelPlanos', 'mplanos');
        $this->load->model('adm/Modelpedidos', 'mped');
        $this->load->model("adm/ModelLocalizacao", "mlocalizacao");
        $this->load->model("adm/ModelGeneral", "mGeneral");
        $this->load->library('localizacao');
        $this->load->library('tipos');
        $this->load->library('general');
        $this->load->library('data');
        $this->load->library('grocery_CRUD');
        $this->load->helper("text");
        $this->_container = "backend/container";
    }

    public function _submenu_cadastro($aid, $voltar = FALSE)
    {
        $links = array(	'info'=>site_url("escritorio-virtual/empresarios/editar/info/$aid"),
            'dependentes'=>site_url("escritorio-virtual/empresarios/editar/dependentes/$aid"),
            'endereco'=>site_url("escritorio-virtual/empresarios/editar/endereco/$aid"),
            'banco'=>site_url("escritorio-virtual/empresarios/editar/banco/$aid"),
            'senha'=>site_url("escritorio-virtual/empresarios/editar/senha/$aid"));
        if($voltar === TRUE)
            $links['voltar'] = '<a href="'.site_url("escritorio-virtual/empresarios/perfil/$aid").'" class="btn btn-orange btn-block">Voltar</a>';
        else
            $links['voltar'] = '';

        $submenu = <<<HTML
						<h3>Atualizar perfil</h3>
						{$links['voltar']}
						<a href="{$links['info']}" class="btn btn-default btn-block">Informações básicas</a>
						<a href="{$links['dependentes']}" class="btn btn-default btn-block">Dependentes</a>
						<a href="{$links['endereco']}" class="btn btn-default btn-block">Endereço</a>
						<a href="{$links['banco']}" class="btn btn-default btn-block">Dados bancários</a>
						<a href="{$links['senha']}" class="btn btn-default btn-block">Alterar Senha</a>
HTML;
        return $submenu;
    }

    function getPlano(){
        $this->form_validation->set_rules('s', 's', 'required|xss_clean');
        if ($this->form_validation->run() != FALSE):
            $planos['dados'] = $this->mplanos->getPlano();
            $cadernos['dados'] = $this->mcadernos->getCaderno();
            $pagina = 'backend/admin/associados/planos';
            $this->load->vars($planos);
            $this->load->vars($cadernos);
            $this->load->view($pagina);
        endif;
    }

    public function perfil($aid)
    {
        if($this->dx_auth->is_logged_in() && ($this->dx_auth->get_associado_id() == $aid)):
            if(($associado = $this->mass->getAssociado($aid, "", "", "", "aid, Nome, Email, sexo, tel_fixo, tel_celular, tel_comercial")) !== FALSE):

                if(($faturas = $this->mass->getfaturas('aid', $aid)) !== FALSE)
                    $dados['faturas'] = $faturas;
                else
                    $dados['faturas'] = FALSE;

                $dados['submenu'] = $this->_submenu_cadastro($aid);
                $dados['associado'] = $associado->row();
                $dados['pagina'] = 'themes/backend/empresarios/perfil';
                $dados['titulo'] = 'Perfil';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                //	Empresário não encontrado
                // $dados['msg'] = $this->config->item('errno')['1010'];
                $dados['pagina'] = 'themes/backend/messages/confirmacao';
                $dados['titulo'] = 'Perfil';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    public function plano_check()
    {
        foreach($this->mplanos->getPlano('pid', $this->input->post('plano'))->result() as $plano):
            if(($plano->percentual_ganho != 0) && $this->mass->getPatrocinadorConsumidor($this->input->post('patrocinador')) === TRUE):
                $this->form_validation->set_message('plano_check', 'O patrocinador informado não pode cadastrar empresários em outros planos além do plano "consumo", por favor, altere o plano ou informe outro patrociador');
                return FALSE;
            else:
                return TRUE;
            endif;
        endforeach;


    }

    function editar($sessao='info', $aid = '')
    {
        if($this->dx_auth->is_logged_in() && ($this->dx_auth->get_associado_id() == $aid)):
            $dados['page_js_foot'] = "rede";
            $dados['page_plugin'] = 'date';
            $dados['pagina'] = "themes/backend/empresarios/perfil/$sessao";
            switch ($sessao):
                case 'info':
                    if(($associado = $this->mass->getAssociado($aid, "", "", "", "aid, nm_patrocinador, Nome, sexo, dtnasc, cpf, rg, pis_pasep, profissao, tel_fixo, tel_celular, tel_comercial")) !== FALSE):
                        $dados['associado'] = $associado->row();
                    else:
                        $dados['associado'] = FALSE;
                    endif;
                    $dados['profissoes'] = $this->mGeneral->fillCombo($this->mass->getProfissoes(), 'pid', 'descricao', "908");

                    $dados['submenu'] = $this->_submenu_cadastro($aid, TRUE);

                    $dados['titulo'] = "Dados Pessoais";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                    break;
                case 'dependentes':
                    $dados['associado'] = $aid;
                    if(($dependentes = $this->mass->getDependente($aid, "", "", "adid, tdid, nm_dependente, tp_dependente, sexo_dependente, dtnasc_dependente, cpf_dependente")) !== FALSE):
                        $dados['dependentes'] = $dependentes->result();
                    else:
                        $dados['dependentes'] = FALSE;
                    endif;
                    $dados['tp_dependente'] = $this->mGeneral->fillCombo($this->mass->getTipoDependente(), 'tdid', 'descricao');

                    $dados['submenu'] = $this->_submenu_cadastro($aid, TRUE);

                    $dados['titulo'] = "Dependentes";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                    break;
                case 'endereco':
                    if(($associado = $this->mass->getAssociado($aid, "", "", "", "aid, tp_endereco, cep, logradouro, numero, complemento, bairro, cidade, estado")) !== FALSE):
                        $dados['associado'] = $associado->row();
                    else:
                        $dados['associado'] = FALSE;
                    endif;
                    $dados['tipos'] = $this->tipos->endereco();
                    $dados['estados'] = $this->mGeneral->fillCombo($this->mlocalizacao->getEstado(), 'uf', 'uf');

                    $dados['submenu'] = $this->_submenu_cadastro($aid, TRUE);

                    $dados['titulo'] = "Endereço";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                    break;
                case 'senha':

                    $dados['submenu'] = $this->_submenu_cadastro($aid, TRUE);
                    $dados['titulo'] = "Alterar senha";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                    break;
                case 'banco':
                    //Edita informações bancárias para recebimento de comissões e bonificações
                    if(($banco = $this->mass->getAssociado($aid, "", "", "", "aid, titular, banco, tpconta, agencia, conta, op")) !== FALSE):
                        $dados['associado'] = $banco->row();
                    else:
                        $dados['associado'] = FALSE;
                    endif;
                    $dados['bancos'] = $this->tipos->bancos();
                    $dados['tpconta'] = $this->tipos->tpconta();

                    $dados['submenu'] = $this->_submenu_cadastro($aid, TRUE);
                    $dados['titulo'] = "Informações bancárias";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                    break;
            endswitch;
        else:
            $this->general->redirect('login');
        endif;
    }

    function salvar($sessao, $aid)
    {


        if ($this->dx_auth->is_logged_in ()) :
            $v = $this->lib_associados->_get_form_values ( TRUE );
            switch ($sessao) :
                case "banco" :
                    if($this->mass->editarInfoBanco ( $v ['infobanco'], $v ['dados_pessoais'] ['aid'] ) == 1)
                        $msg = "Informações bancárias atualizadas com sucesso";
                    else
                        $msg = "Não foi possível atualizar as informações bancárias, tente novamente";
                    break;
                case "endereco" :
                    $this->mass->editarEndereco ( $v ['endereco'], $v ['dados_pessoais'] ['aid'] );
                    $msg = "Endereço atualizado com sucesso";
                    break;
                case "dependentes" :
                    if ($this->input->post('add')):
                        // Criar dependente
                        $this->mass->criarDependente($v['dependente'], $v['dados_pessoais']['aid']);
                        $this->session->set_flashdata ( 'msg', "Dependente adicionado com sucesso" );
                        $this->general->redirect ( "escritorio-virtual/empresarios/editar/dependentes/$aid");
                    elseif ($this->input->post('delete')):
                        // Faz um loop através do array $_POST e exclui os checkboxes selecionados
                        foreach ($_POST as $key => $value):
                            // Se o checkbox for encontrado
                            if (substr($key, 0, 9) == 'checkbox_'):
                                // Exclui dependente
                                $this->mass->excluirDependente($v['dados_pessoais']['aid'], $value);
                            endif;
                        endforeach;
                        $this->session->set_flashdata ( 'msg', "Dependente(s) excluído(s) com sucesso" );
                        $this->general->redirect ( "escritorio-virtual/empresarios/editar/dependentes/$aid");
                    endif;
                    break;
                case "info" :
                    if($this->mass->editarDadosPessoais ( $v, $v['dados_pessoais']['aid'] ) == 1)
                        $msg = "Informações atualizadas com sucesso";
                    else
                        $msg = "Não foi possível atualizar seus dados, por favor, tente novamente.";
                    break;
            endswitch;

            $this->session->set_flashdata ( 'msg', $msg );
            $this->general->redirect ( "escritorio-virtual/empresarios/perfil/$aid");
        else :
            $this->general->redirect('login');
        endif;
    }

    function recaptcha_check()
    {
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin","root"))):
                $result = $this->dx_auth->is_recaptcha_match();
                if ( ! $result)
                {
                    $this->form_validation->set_message('recaptcha_check', 'O c&oacute;digo informado n&atilde;o &eacute; o mesmo da imagem. Tente novamente.');
                }

                return $result;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function escolha_plano($msg = ""){
        if($this->dx_auth->is_logged_in()):

            $dados['titulo'] = "Planos de Assinatura";
            $dados['pagina'] = "themes/backend/empresarios/escolha_plano";
            $dados['page_js_foot'] = 'funcoes';
            if($msg == md5('sem_cadernos'))
                $msg = "Por favor escolha os cadernos da revista online que deseja acessar";

            $dados['msg'] = $msg;
            $this->session->set_userdata("aid", $this->dx_auth->get_associado_id());
            $dados['planos'] = $this->mplanos->getPlano();
            $dados['cadernos'] = $this->mass->getCaderno();

            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }




    function salvar_escolha_plano()
    {

        $ar = $this->input->post('cid');
        //verifica se o usuário esqueceu de escolher os cadernos
        if(empty($ar) && ($this->input->post('pid') != '52') && ($this->input->post('pid') != '53')):
            //cadernos não escolhidos nos planos de empresários
            $msg = md5('sem_cadernos');
            $this->general->redirect("escritorio-virtual/empresarios/escolha_plano/$msg");
        endif;

        $aid = $this->input->post('aid');
        //verifica se por algum motivo obscuro o código do associado não foi enviado
        if(empty($aid))
            $this->general->redirect('escritorio-virtual/empresarios/escolha_plano');

        if(($this->input->post('pid') != '52') && ($this->input->post('pid') != '53')):
            for($i=0;$i<count($ar);$i++)
            {
                mysql_query(" INSERT INTO `ass_caderno` (`aid`, `cid`, `status`) VALUES ('".$aid."', '".$ar[$i]."', 'Inativo') ") or die (mysql_error());
            }
        endif;

        $pedido['aid'] = $aid;
        $pedido['dtpedido'] = date("Y-m-d H:i:s");
        $pedido['descricao'] = "Cadastro";
        $pedido['plano']  =  $this->input->post('pid'); // Plano Id !!
        $formapagamento =  $this->input->post('formapagamento');

        // echo $dados['formapagamento'];
        $pl = $this->mplanos->getPlano('pid', $pedido['plano']);
        $plano = $pl->row(); // Busca plano

        // echo $v->valor_plano;

        if($formapagamento=="AVISTA"):
            $pedido['forma_pgto_plano'] = "AV";
            $this->mass->setStatusAssociado($aid, 'P');
            $this->mass->grava_salva_plano($pedido, $plano);
        else:
            if($formapagamento=="APRAZO"):
                $pedido['forma_pgto_plano'] = "AP";
                $this->mass->setStatusAssociado($aid, 'P');
                $this->mass->grava_salva_plano($pedido, $plano);
            endif;
        endif;
        $this->session->unset_userdata('aid');
        $this->general->redirect('escritorio-virtual/dashboard');

    }

    function retorno_bancario()
    {
        if($this->dx_auth->is_logged_in()):

            $dados['titulo'] = "Retorno Bancário ";
            $dados['pagina'] = "themes/backend/empresarios/retorno_bancario";

            $config['upload_path'] = './upload_arquivo/arqs/';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = date("His").'_cobranca_titulos.xlsx';
            $config['max_size']     = '1000000';
            $this->load->library('upload', $config);

            if($this->upload->do_upload()):
                $dados['msg'] = '';

                $this->load->library("excel");

                $data = $this->upload->data();
                $inputFileName = $data['file_name'];

                if(strstr($inputFileName, ".xlsx") == true)
                    $inputFileType = 'Excel2007';
                else
                    $inputFileType = 'Excel5';

                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($data['file_path'].$inputFileName);

                $dados['msg'] .= '<hr />';

                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                $dados['msg'] .= '<h1>Importação:</h1>';

                $linha = 1;
                $_linha_erro = 0;
                foreach($sheetData as $ch => $array){
                    $coluna = 1;
                    foreach($array as $campo => $valor){
                        if($coluna == 1){
                            /*
                            COLUNA          DADO
                            A               SEU NÚMERO
                            B               NOSSO NÚMERO
                            C               VENCIMENTO
                            D               DATA DA LIQUIDAÇÃO
                            E               VALOR DO TÍTULO
                            F               VALOR COBRADO
                            G               OSCILAÇÃO
                            H               SACADO
                            I               CONTA COBRANÇA
                            */

                            // Ajustando a data
                            if($array['D'] != NULL):
                                $_data = explode('/', $array['D']);
                                if(count($_data) > 1)
                                    $_data = '20'.$_data[2].'-'.$_data[1].'-'.$_data[0];
                            endif;

                            // Ajustando o valor cobrado
                            $array['F'] = str_replace(',', '.', $array['F']);

                            // Ajustando nosso número
                            $_nosso_numero = (int) $array['B'];

                            // Inicia o controle de transaçao
                            //@todo - migrar as conexões do método para dentro da estrutura do codeigniter
                            $conn = mysqli_connect("aa15cdlwzjztwet.cwc8q91bdfgt.sa-east-1.rds.amazonaws.com", "evsicove", "evs1c0v3", "escritorio");
                            mysqli_autocommit($conn, FALSE);
                            $erro = 0; // Controle de erros
                            $_nosso_numero = (int)$_nosso_numero;
                            // Busca pela fatura
                            if(strlen($_nosso_numero) > 1 && strlen($_nosso_numero) > 2){
                                $q = "SELECT fid FROM ass_faturas WHERE nosso_numero = '".$_nosso_numero."' AND valor = '".$array['F']."' AND status ='Pendente'  ";

                                $d = mysqli_query($conn, $q) or die (mysqli_error($conn));
                                if(!$d) $erro++;

                                $n = mysqli_num_rows($d);
                                if($n > 0){
                                    $r = mysqli_fetch_array($d);
                                    // Se encontrar baixa a mesma

                                    $_q = "UPDATE ass_faturas SET dtpagamento = '".$_data."', ret_valor = '".$array['F']."', status = 'Pago' WHERE fid = '".$r['fid']."'";
                                    $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                    if(!$_d) $erro++;

                                    // Atualizar o plano do associado para o plano atual
                                    // Alterar Status(associados) Ativo = A
                                    $_q = "SELECT a.fid, b.aid, b.plano, b.pid, c.patrocinador, (a.valor*0.10) 'valor'
                                                                                FROM ass_faturas a
                                                                                        JOIN ass_pedidos b ON a.pedido = b.pid
                                                                                        JOIN associados c ON b.aid = c.aid
                                                                                WHERE a.status = 'Pago' AND a.fid = '".$r['fid']."'
                                                                                ORDER BY a.fid DESC";

                                    $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                    if(!$_d) $erro++;

                                    if(mysqli_num_rows($_d) > 0){
                                        $r = mysqli_fetch_array($_d);
                                        $_q = "UPDATE associados SET plano_atual = '".$r['plano']."', pedido_atual = '".$r['pid']."' , status = 'A'
                                                                                        WHERE aid = '".$r['aid']."'";

                                        $CodigoAssociado = $r['aid'];

                                        $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                        if(!$_d) $erro++;

                                        // Insere uma entrada 22 - Baixa Fatura
                                        $_q = "INSERT ass_entrada SET aid = '".$r['patrocinador']."', teid = '22', valor = '".$r['valor']."', data = NOW()";
                                        $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));

                                        if(!$_d) $erro++;

                                        // Atualizando o saldo do patrocinador
                                        $_q = "SELECT 1 FROM ass_saldo a WHERE a.aid = '".$r['patrocinador']."'";

                                        $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                        if(!$_d) $erro++;
                                        if(mysqli_num_rows($_d) > 0){
                                            $_q = "UPDATE ass_saldo SET valor = (valor + ".$r['valor'].") WHERE aid = '".$r['patrocinador']."'";
                                            $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                            if(!$_d) $erro++;
                                        } else{
                                            $_q = "INSERT INTO ass_saldo SET valor = '".$r['valor']."', aid = '".$r['patrocinador']."'";
                                            $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                            if(!$_d) $erro++;
                                        }

                                        //  Gravar na revista (rvt_user_bride)   id= increment pass=   aid=
                                        $conexao = mysqli_connect("aa15cdlwzjztwet.cwc8q91bdfgt.sa-east-1.rds.amazonaws.com", "evsicove", "evs1c0v3","revistapillares")
                                        or die("Não foi possível conectar com o banco de dados da Revista Pillares!");

                                        mysqli_query($conexao," INSERT INTO `rvt_user_bridge` (`aid`) VALUES ('$CodigoAssociado')  ");



                                        // Ativa os cadernos inativos
                                        $_q = "UPDATE ass_caderno SET status = 'Ativo' WHERE aid = '".$r['aid']."'";
                                        $_d = mysqli_query($conn, $_q) or die (mysqli_error($conn));
                                        if(!$_d) $erro++;

                                        if ($erro == 0)
                                            mysqli_commit($conn);
                                        else
                                            mysqli_rollback($conn);
                                    }

                                    $dados['msg'] .= '<font color="#009900">Linha: <strong>['.$linha.']</strong> e nosso número: ';
                                    $dados['msg'] .= '<strong>['.$array['B'].']</strong> encontrados e a fatura baixada com sucesso.</font><br />';
                                } else{
                                    // As que não encontra informa o erro
                                    $_linha_erro[$linha] = $array['B'];
                                }
                            }
                            $linha++;
                        }
                        $coluna++;
                    }
                }

                if(is_array($_linha_erro) && count($_linha_erro) > 0){

                    $dados['msg'] .= '<h1>Erros:</h1>';
                    foreach($_linha_erro as $linha => $nosso_numero){
                        $dados['msg'] .= '<font color="#FF0000">Linha: <strong>['.$linha.']</strong> e nosso número: ';
                        $dados['msg'] .= '<strong>['.$nosso_numero.']</strong> não foram encontrados nas faturas do sistema.</font><br />';
                    }
                }
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $file = $this->upload->data();
                $dados['msg'] = $this->upload->display_errors();


                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }


    function alterar_senha()
    {
        // Verifica se o usuário está logado
        if ($this->dx_auth->is_logged_in())
        {
            $val = $this->form_validation;
            // Validate rules and change password
            if ($val->run('alterar_senha') AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
            {
                $rvtdb = $this->load->database('revista', TRUE);
                //Insert raw password into temp table
                $revdata = array(
                    'aid'=>$this->dx_auth->get_associado_id(),
                    'pass'=>$val->set_value('new_password')
                );
                $rvtdb->set($revdata);
                $rvtdb->insert("rvt_user_bridge");
                $rvtdb->close();

                $this->session->set_flashdata('nova_senha', 'Sua senha foi alterada com sucesso!<br><br>Acesse o sistema novamente com sua nova senha.');
                $this->general->redirect('logout');
            }
            else
            {
                $dados['titulo'] = "Alterar Senha";
                $dados['pagina'] = 'themes/backend/empresarios/perfil/senha';
                $dados['submenu'] = $this->_submenu_cadastro($this->dx_auth->get_associado_id(), TRUE);
                $this->load->vars($dados);
                $this->load->view($this->_container);
            }
        }
        else
        {
            // Redirect to login page
            $this->general->redirect('login');
        }
    }


}

/* End of file empresarios.php */
/* Location: ./system/application/controllers/escritorio-virtual/empresarios.php */
