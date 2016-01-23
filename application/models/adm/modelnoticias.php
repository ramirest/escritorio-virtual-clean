<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelnoticias extends CI_Model {

    var $table = "mmn_noticias";

    function __construct(){
        parent::__construct();
    }
/*
    function getNoticias($nid = ''){
        $this->db->select("*");
        $this->db->from("mmn_noticias");
        if($nid != ''):
            $this->db->where("nid", $nid);
        endif;
        $noticia = $this->db->get();

        if($noticia->num_rows() > 0):
            return $noticia;
        else:
            return false;
        endif;
    }

    function inserirNoticia($dados){
        $this->db->set($dados);
        $this->db->insert("mmn_noticias");
    }

    function editarNoticia($dados){
        $this->db->set($dados);
        $this->db->where("nid", $dados['nid']);
        $this->db->update("mmn_noticias");
    }

    function excluirNoticia(){
        $this->db->where("nid", $nid);
        $this->db->delete("mmn_noticias");
    }
 *
 */
    function list_all($order_by = 'nid') {
            $this->db->order_by($order_by,'asc');
            return $this->db->get($this->table);
    }

    function count_all() {
            return $this->db->count_all($this->table);
    }

    function get_paged_list($limit = 10, $offset = 0, $order_by = 'nid') {
            $this->db->order_by($order_by,'asc');
            return $this->db->get($this->table, $limit, $offset);
    }

    function get_by_id($nid) {
            $this->db->where('nid', $nid);
            return $this->db->get($this->table);
    }

    function save($obj) {
            $this->db->insert($this->table, $obj);
            return $this->db->insert_id();
    }

    function update($nid, $obj) {
            $this->db->where('nid', $nid);
            $this->db->update($this->table, $obj);
    }

    function delete($nid) {
            $this->db->where('nid', $nid);
            $this->db->delete($this->table);
    }
}

/* End of file modelnoticias.php */
/* Location: ./system/application/models/adm/modelnoticias.php */