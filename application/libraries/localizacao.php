<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Localizacao {

    function cidades(){

    }
    function estados($pid = ''){
        $estados = array(''=>"Selecione",
                         'AC'=>"Acre",
                         'AL'=>"Alagoas",
                         'AP'=>"Amapá",
                         'AM'=>"Amazonas",
                         'BA'=>"Bahia",
                         'CE'=>"Ceará",
                         'DF'=>"Distrito Federal",
                         'ES'=>"Espirito Santo",
                         'GO'=>"Goiás",
                         'MA'=>"Maranhão",
                         'MT'=>"Mato Grosso",
                         'MS'=>"Mato Grosso do Sul",
                         'MG'=>"Minas Gerais",
                         'PA'=>"Pará",
                         'PB'=>"Paraíba",
                         'PR'=>"Paraná",
                         'PE'=>"Pernambuco",
                         'PI'=>"Piauí",
                         'RJ'=>"Rio de Janeiro",
                         'RN'=>"Rio Grande do Norte",
                         'RS'=>"Rio Grande do Sul",
                         'RO'=>"Rondônia",
                         'RR'=>"Roraima",
                         'SC'=>"Santa Catarina",
                         'SP'=>"São Paulo",
                         'SE'=>"Sergipe",
                         'TO'=>"Tocantins");
        return $estados;
    }


}

/* End of file localizacao.php */
/* Location: ./system/application/libraries/localizacao.php */