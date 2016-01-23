<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias extends CI_Controller {

    // records per page
    private $limit = 5;

    // column to order by at listing
    private $order_by = 'titulo';

    function __construct(){
        parent::__construct();
        
        $this->load->library('data');
        // send and show messages to user
        $this->load->library('messages');
        $this->load->helper('msg');

        $this->load->model('adm/Modelnoticias', 'mnoticias');

        $dados['backend'] = "admin";
        $this->load->vars($dados);
        $this->_container = "backend/container";
    }

    function index($offset = 0){
        
        $dados = array();

        // http://localhost/ci_sandbox/index/(offset)
        $uri_segment = 3;
        // where this page begins
        $offset = $this->uri->segment($uri_segment);

        // load data list
        $dados['lista'] = $this->mnoticias->get_paged_list($this->limit, $offset, $this->order_by)->result();

        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('adm/noticias/index/');
        $config['total_rows'] = $this->mnoticias->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $dados['pagination'] = $this->pagination->create_links();

        $dados['titulo'] = "NOT&Iacute;CIAS";
        $dados['pagina'] = "backend/admin/noticias/listar";
        $this->load->vars($dados);
        $this->load->view($this->_container);
    }

    function prepareInsert() {
            // set validation properties
            $dados['values']['nid'] = '';
            $dados['values']['autor'] = '';
            $dados['values']['titulo'] = '';
            $dados['values']['subtitulo'] = '';
            $dados['values']['corpo'] = '';
            $dados['values']['data'] = '';
            $dados['values']['publicado'] = '';

            // set common properties
            $dados['action'] = site_url('adm/noticias/insert');

            $dados['titulo'] = "NOVA NOT&Iacute;CIA";
            $dados['pagina'] = "backend/admin/noticias/form";
            $this->load->vars($dados);
            $this->load->view($this->_container);
    }

    function prepareUpdate($nid) {

            // prefill form values
            $obj = $this->mnoticias->get_by_id($nid)->row();
            $dados['values']['nid'] = $nid;
            $dados['values']['autor'] = $obj->autor;
            $dados['values']['titulo'] = $obj->titulo;
            $dados['values']['subtitulo'] = $obj->subtitulo;
            $dados['values']['corpo'] = $obj->corpo;
            $dados['values']['data'] = $this->data->mysql_to_human($obj->data);
            $dados['values']['publicado'] = $obj->publicado;

            // set common properties
            $dados['action'] = site_url('adm/noticias/update');

            $dados['titulo'] = "EDITAR NOT&Iacute;CIA";
            $dados['pagina'] = "backend/admin/noticias/form";
            $this->load->vars($dados);
            $this->load->view($this->_container);
    }

    function insert() {
            $this->_save('insert');
    }


    function update() {
            $this->_save('update');
    }

    function _save($action = 'insert') {
            // set common properties
            if ($action == 'update') {
                    $dados['titulo'] = 'EDITAR NOT&Iacute;CIA';
                    $dados['action'] = site_url('adm/noticias/update');
            } else {
                    $dados['title'] = 'NOVA NOT&Iacute;CIA';
                    $dados['action'] = site_url('adm/noticias/insert');
            }

            // set validation properties
            $this->form_validation->set_rules('nid','','');
            $this->form_validation->set_rules('autor','Autor','trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('titulo','T&iacute;tulo','trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('subtitulo','Subt&iacute;tulo','trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('corpo','Corpo','trim|required|xss_clean');
            $this->form_validation->set_rules('data','Data','trim|required|xss_clean');
            $this->form_validation->set_rules('publicado','Publicado','trim|xss_clean');
            $this->form_validation->set_error_delimiters('<p class="erro">', '</p>');

            // run validation
            if ($this->form_validation->run() == FALSE) {
                    $dados['values']['autor'] = set_value('autor');
                    $dados['values']['titulo'] = set_value('titulo');
                    $dados['values']['subtitulo'] = set_value('subtitulo');
                    $dados['values']['corpo'] = set_value('corpo');
                    $dados['values']['data'] = set_value('data');
                    $dados['values']['publicado'] = set_value('publicado');
                    $dados['values']['nid'] = set_value('nid');

                    $dados['titulo'] = "EDITAR NOT&Iacute;CIA";
                    $dados['pagina'] = "backend/admin/noticias/form";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
            } else {
                    // save data
                    if ($action == 'update') {
                            $nid = $this->input->post('nid');
                    }
                    $obj = array(
                            'autor' => $this->input->post('autor'),
                            'titulo' => $this->input->post('titulo'),
                            'subtitulo' => $this->input->post('subtitulo'),
                            'corpo' => $this->input->post('corpo'),
                            'data' => $this->data->human_to_mysql($this->input->post('data')),
                            'publicado' => $this->input->post('publicado')
                    );
                    if ($action == 'update') {
                            $this->mnoticias->update($nid, $obj);
                    } else {
                            $nid = $this->mnoticias->save($obj);
                    }

                    // set user message
                    if ($action == 'update') {
                            $this->messages->add('Not&iacute;cia atualizada', 'success');
                    } else {
                            $this->messages->add('Not&iacute;cia criada', 'success');
                    }

                    // redirect to list page
                    redirect('adm/noticias/index/','refresh');
            }

    }

    function delete($nid) {
            $this->mnoticias->delete($nid);

            // set user message
            $this->messages->add('Not&iacute;cia removida', 'success');

            // redirect to list page
            redirect('adm/noticias/index/','refresh');
    }

}

/* End of file noticias.php */
/* Location: ./system/application/controllers/adm/noticias.php */