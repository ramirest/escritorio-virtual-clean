<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configs extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library("session");
		//$this->load->library('Pagination');
		$this->load->library("general");
        $this->load->library('grocery_CRUD');

        $this->_container = "backend/container";
        $this->_container_crud = "themes/backend/container";
        $this->load->model("Modelboleto", "mboleto");
    }

    function empresa(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('empresa')->
                        set_subject('Empresa')->
                        required_fields('pid','eeid','registro_empresa')->
                        columns('pid','eeid','registro_empresa')->
                        display_as('pid', 'Empresa')->
                        display_as('eeid', 'Enquadramento Empresarial')->
                        display_as('registro_empresa', 'Data de Registro')->
                        set_rules('registro_empresa', 'Data de Registro', 'callback_data_validation')->
                        set_relation('pid','parceiros','fantasia')->
                        set_relation('eeid','enquadramento_empresa','descricao');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Enquadramento Empresarial";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function enquadramento(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('enquadramento_empresa')->
                        set_subject('Enquadramento Empresarial')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Enquadramento Empresarial";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function cadernos(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('cadernos')->
                        set_subject('Cadernos')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Cadernos";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function profissoes(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('ass_profissao')->
                        set_subject('Profissões')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Profissões";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function tipo_produto(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin", "root"))):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('tipo_produto')->
                        set_subject('Tipo de Produto')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Tipos de Produtos";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function produto(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin", "root"))):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('produtos')->
                        set_subject('Produto')->
                        set_relation('tpid', 'tipo_produto', 'descricao')->
                        set_relation('fornecedor_preferencial', 'parceiros', 'fantasia')->
                        required_fields('tpid','descricao')->
                        columns('tpid','descricao', 'fornecedor_preferencial')->
                        display_as('descricao', 'Descrição')->
                        display_as('tpid', 'Tipo de Produto')->
                        display_as('fornecedor_preferencial', 'Fornecedor Preferencial');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Produtos";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function revista(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin", "root"))):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('revista')->
                        set_subject('Revista')->
                        set_relation('pid', 'produtos', 'descricao')->
                        required_fields('pid','data_edicao','peso','qtde_paginas')->
                        columns('pid','data_edicao','peso','qtde_paginas')->
                        display_as('pid', 'Produto')->
                        display_as('data_edicao', 'Data da Edição')->
                        display_as('qtde_paginas', 'Quantidade de Páginas');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Revistas";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function tipo_imovel(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('tipo_imovel')->
                        set_subject('Tipo do Imóvel')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Tipos de Imóveis";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function tipo_entrada(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('tipo_entrada')->
                        set_subject('Tipo de Entrada')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Tipos de Entrada";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function tipo_saida(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('tipo_saida')->
                        set_subject('Tipo de Saída')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Tipos de Saída";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function motivo_credito(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('motivo_credito')->
                        set_subject('Motivo de Crédito')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Motivos de Créditos";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function status_transacao(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('status_transacao')->
                        set_subject('Status da Transação')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Status da Transação";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function ramo_atividade(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('ramo_atividade')->
                        set_subject('Ramo de Atividade')->
                        required_fields('descricao')->
                        columns('descricao')->
                        display_as('descricao', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão do Ramo de Atividade";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     * Registrar aplicações para acessar o sistema através do token de acesso no oauth
     *
     *
     */

    function aplicacoes(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();
                    $crud->set_theme('escritorio-virtual')->
                           set_table('oauth_applications')->
                           set_subject('Aplicativo')->
                           required_fields('client_id')->
                           columns('name','client_id','client_secret', 'redirect_uri')->
                           display_as('name', 'Nome')->
                           display_as('client_id', 'Cliente')->
                           display_as('client_secret', 'Senha')->
                           display_as('auto_approve', 'Aprovar automaticamente')->
                           display_as('autonomous', 'Autônomo')->
                           display_as('suspended', 'Suspenso')->
                           display_as('notes', 'Notas')->
                           display_as('redirect_uri', 'URI de Direcionamento');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Aplicativos";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function escopos(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                        set_table('oauth_scopes')->
                        set_subject('Escopo')->
                        required_fields('scope')->
                        columns('scope','name','description')->
                        display_as('name', 'Nome')->
                        display_as('scope', 'Escopo')->
                        display_as('description', 'Descrição');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Escopo de aplicativo";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function papeis()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("root")):
            $this->load->model('dx_auth/roles', 'roles');

            /* Database related */
			
            // If Add role button pressed
            if ($this->input->post('add')):
            	// Create role
                $this->roles->create_role($this->input->post('role_name'), $this->input->post('role_parent'));
            elseif ($this->input->post('delete')):
                // Loop trough $_POST array and delete checked checkbox
                foreach ($_POST as $key => $value):
                	// If checkbox found
                    if (substr($key, 0, 9) == 'checkbox_'):
                    	// Delete role
                        $this->roles->delete_role($value);
					endif;
                endforeach;
            endif;

            /* Showing page to user */

            // Get all roles from database
            $data['roles'] = $this->roles->get_all()->result();
            $data['page_js_foot'] = "tables";
            
            // Load view
            $data['titulo'] = "Papéis";
            $data['pagina'] = "themes/backend/configs/usuarios/roles";
            $this->load->vars($data);
            $this->load->view($this->_container);
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        $this->general->redirect('login');
      endif;
    }

    function usuarios()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("root")):

            $this->load->model('dx_auth/users', 'users');

            // Search checkbox in post array
            foreach ($_POST as $key => $value):
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_'):
                    // If ban button pressed
                    if (isset($_POST['ban'])):
                            // Ban user based on checkbox value (id)
                            $this->users->ban_user($value);
                    // If unban button pressed
                    elseif (isset($_POST['unban'])):
                            // Unban user
                            $this->users->unban_user($value);
                    elseif (isset($_POST['reset_pass'])):
                        // Set default message
                        $data['reset_message'] = 'Erro ao recriar a senha';

                        // Get user and check if User ID exist
                        if ($query = $this->users->get_user_by_id($value) AND $query->num_rows() == 1):
                            // Get user record
                            $user = $query->row();

                            // Create new key, password and send email to user
                            if ($this->dx_auth->forgot_password($user->username)):
                                // Query once again, because the database is updated after calling forgot_password.
                                $query = $this->users->get_user_by_id($value);
                                // Get user record
                                $user = $query->row();

                                // Reset the password
                                if ($this->dx_auth->reset_password($user->username, $user->newpass_key)):
                                    $data['reset_message'] = 'Senha recriada com sucesso';
                                endif;
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;

            // Get all users
            $dados['users'] = $this->users->get_all()->result();
            $dados['page_js_foot'] = "tables";
            
            /* Showing page to user */


/*            
            // Get offset and limit for page viewing
            $offset = (int) $this->uri->segment(4);
            // Number of record showing per page
            $row_count = 10;
            // Pagination config
            $p_config['base_url'] = base_url(index_page().'/escritorio-virtual/configs/usuarios');
            $p_config['uri_segment'] = 4;
            $p_config['num_links'] = 2;
            $p_config['total_rows'] = $this->users->get_all()->num_rows();
            $p_config['per_page'] = $row_count;

            // Init pagination
            $this->pagination->initialize($p_config);
            // Create pagination links
            $data['pagination'] = $this->pagination->create_links();
*/
            // Load view
            $dados['titulo'] = "Usuários";
            $dados['pagina'] = "themes/backend/configs/usuarios/users";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        $this->general->redirect('login');
      endif;
    }

    function boleto($cid = "")
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role(array("admin","root"))):
            if($cid != ""):
                $this->_salva_boleto($cid);
            else:
            foreach($this->mboleto->getBoleto()->result() as $boleto):
                $dados['boleto'] = $boleto;
            endforeach;
            $dados['titulo'] = "Boleto";
            $dados['pagina'] = "themes/backend/configs/boleto/editar";
            $this->load->vars($dados);
            $this->load->view($this->_container);
            endif;
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        $this->general->redirect('login');
      endif;
    }
	
	function planos($pid = ""){
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("root")):
			$this->load->model('adm/modelplanos', 'mplanos');
			
			if($this->input->post('save')):
			  if($this->input->post('pid') == ""):
				  if($this->mplanos->inserirPlano($this->input->post()) === TRUE):
					$dados['msg'] = 'Plano gravado com sucesso';
				  endif;
			  else:
			  	  if($this->mplanos->editarPlano($this->input->post()) === TRUE):
				  	$dados['msg'] = 'Plano gravado com sucesso';
				  else:
				  	$dados['msg'] = 'Ocorreu um erro ao gravar o plano';
				  endif;
				  $pid = "";
			  endif;
            elseif($this->input->post('delete')):
                // Loop trough $_POST array and delete checked checkbox
                foreach ($_POST as $key => $value):
                	// If checkbox found
                    if (substr($key, 0, 9) == 'checkbox_'):
                    	// Delete role
                        $this->mplanos->excluirPlano($value);
						$dados['msg'] = 'Plano excluído com sucesso';
					endif;
                endforeach;
				$pid = "";
			endif;
			if ($pid != ""):
				$dados['plano'] = $this->mplanos->getPlano('pid', $pid)->row();
			else:
				if($this->mplanos->getPlano() !== FALSE)
				   $dados['planos'] = $this->mplanos->getPlano()->result();
				else
				   $dados['planos'] = FALSE;
            endif;
            $dados['page_js_foot'] = "tables";
            $dados['titulo'] = "Planos";
            $dados['pagina'] = "themes/backend/configs/planos";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
         $this->general->redirect('login');
      endif;
	}

	function graduacoes($gid = ""){
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("root")):
			$this->load->model('adm/modelgraduacoes', 'mgrad');
			
			if($this->input->post('save')):
			  if($this->input->post('gid') == ""):
				  if($this->mgrad->inserirGraduacao($this->input->post()) === TRUE):
					$dados['msg'] = 'Graduação gravada com sucesso';
				  endif;
			  else:
			  	  if($this->mgrad->editarGraduacao($this->input->post()) === TRUE):
				  	$dados['msg'] = 'Graduação gravada com sucesso';
				  else:
				  	$dados['msg'] = 'Ocorreu um erro ao gravar a graduação';
				  endif;
				  $gid = "";
			  endif;
            elseif($this->input->post('delete')):
                // Loop trough $_POST array and delete checked checkbox
                foreach ($_POST as $key => $value):
                	// If checkbox found
                    if (substr($key, 0, 9) == 'checkbox_'):
                    	// Delete role
                        $this->mgrad->excluirGraduacao($value);
						$dados['msg'] = 'Graduação excluída com sucesso';
					endif;
                endforeach;
				$gid = "";
			endif;
			if ($gid != ""):
				$dados['graduacao'] = $this->mgrad->getGraduacao('gid', $gid)->row();
			else:
				if($this->mgrad->getGraduacao() !== FALSE)
				   $dados['graduacoes'] = $this->mgrad->getGraduacao()->result();
				else
				   $dados['graduacoes'] = FALSE;
            endif;
            $dados['titulo'] = "Graduações";
            $dados['pagina'] = "themes/backend/configs/graduacoes";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        $this->general->redirect('login');
      endif;
	}

    function _salva_boleto($cid)
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role(array("admin","root"))):
            $this->load->library("typography");

            $v['cid'] = $this->input->post("cid");
            $v['identificacao'] = $this->typography->format_characters($this->input->post('identificacao'));
            $v['cnpj'] = $this->input->post('cnpj');
            $v['endereco'] = $this->input->post('endereco');
            $v['cidade_uf'] = $this->input->post('cidade_uf');
            $v['razao_social'] = $this->input->post('razao_social');
            $v['dias_prazo_pagamento'] = $this->input->post('dias_prazo_pagamento');
            $v['taxa_boleto'] = $this->input->post('taxa_boleto');
            $v['valor'] = $this->input->post('valor');
            $v['demonstrativo01'] = $this->input->post('demonstrativo01');
            $v['demonstrativo02'] = $this->input->post('demonstrativo02');
            $v['demonstrativo03'] = $this->input->post('demonstrativo03');
            $v['instrucoes01'] = $this->input->post('instrucoes01');
            $v['instrucoes02'] = $this->input->post('instrucoes02');
            $v['instrucoes03'] = $this->input->post('instrucoes03');
            $v['instrucoes04'] = $this->input->post('instrucoes04');
            $v['quantidade'] = $this->input->post('instrucoes04');
            $v['valor_unitario'] = $this->input->post('valor_unitario');
            $v['aceite'] = $this->input->post('aceite');
            $v['especie'] = $this->input->post('especie');
            $v['especie_doc'] = $this->input->post('especie_doc');
            $v['agencia'] = $this->input->post('agencia');
            $v['conta'] = $this->input->post('conta');
            $v['conta_dv'] = $this->input->post('conta_dv');
            $v['conta_cedente'] = $this->input->post('conta_cedente');
            $v['carteira'] = $this->input->post('carteira');

            $this->mboleto->salva_boleto($v);
            $this->session->set_flashdata("msg", "Configura&ccedil;&otilde;es salvas com sucesso.");
            $this->general->redirect('escritorio-virtual/configs/boleto');
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        $this->general->redirect('login');
      endif;
    }


}

/* End of file configs.php */
/* Location: ./system/application/controllers/escritorio-virtual/configs.php */
