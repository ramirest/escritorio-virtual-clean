<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelimoveis extends CI_Model {

    var $tabela_1 = "empresa_imoveis";
    var $tabela_2 = "tipo_imovel";
    var $tabela_3 = "empresa";
    var $tabela_4 = "parceiros";
    var $imovel = 0;

    function __construct()
    {
        parent::__construct();
    }

    function getImoveis($key = '', $value = '')
    {
        $this->db->select("i.iid, i.descricao, logradouro, complemento, numero, bairro, cidade, cep,
                           estado, telefone, t.tiid, t.descricao tipo, e.eid, p.razao_social empresa", FALSE);
        $this->db->from($this->tabela_1." i");
        $this->db->join($this->tabela_2." t", "i.tiid = t.tiid", "inner");
        $this->db->join($this->tabela_3." e", "i.eid = e.eid", "inner");
        $this->db->join($this->tabela_4." p", "e.pid = p.pid", "inner");

        if($key != ''):
            $this->db->where($key, $value);
        endif;

        $imoveis = $this->db->get();

        if($imoveis->num_rows() > 0)
            return $imoveis;
        else
            return FALSE;
    }

    function inserirImovel($dados)
    {
        //verificar se o imóvel ja esta cadastrado
        if($this->getImoveis('iid', $dados['iid']) === FALSE):
            $this->db->set($this->_setImovel($dados));
            $this->db->insert($this->tabela_1);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function _setImovel($dados)
    {
        $imovel = array(
            'descricao'=>$dados['descricao'],
            'eid'=>$dados['empresa'],
            'tiid'=>$dados['tipo'],
            'cep'=>$dados['cep'],
            'logradouro'=>$dados['logradouro'],
            'numero'=>$dados['numero'],
            'complemento'=>$dados['complemento'],
            'bairro'=>$dados['bairro'],
            'cidade'=>$dados['cidade'],
            'estado'=>$dados['estado'],
            'telefone'=>$dados['telefone']
        );
        return $imovel;
    }

    function editarImovel($dados)
    {
        $this->db->set($this->_setImovel($dados));
        $this->db->where("iid", $dados['iid']);
        if($this->db->update($this->tabela_1))
            return TRUE;
        else
            return FALSE;
    }

    function excluirImovel($iid){
        $this->db->where("iid", $iid);
        if($this->db->delete($this->tabela_1)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}

/* End of file modelImoveis.php */
/* Location: ./system/application/models/adm/modelImoveis.php */