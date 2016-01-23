<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data {

    function human_to_mysql($data){
        if((isset($data)) && ($data !== FALSE)):
            $data = explode("/", $data);
            $data = date("Y-m-d", mktime(0,0,0, $data[1], $data[0], $data[2]));
        else:
            $data = '';
        endif;
        return $data;
    }

    function mysql_to_human($data){
        if((isset($data)) && ($data !== FALSE)):
            $data = explode("-", substr($data, 0, 10));
            $data = date("d/m/Y", mktime(0,0,0,$data[1], $data[2], $data[0]));
        else:
            $data = '';
        endif;
        return $data;
    }

    function select_month($data)
    {
        $mes = explode('-', $data);
        $mes = $mes[1];
        return $mes;
    }
	
	function FormataDataBR($data){
		if ($data == '')
			return '';
		$data_f = explode('-',$data);
		return $data_f[2].'/'.$data_f[1].'/'.$data_f[0];
	}

	function FormataDataBD($data){
		if ($data == '')
			return '';
		$data_f = explode('/',$data);
		return $data_f[2].'-'.$data_f[1].'-'.$data_f[0];
	}
	
	
	
	
	function SomaMesData($data,$v) {
		
	 $data = explode("/",$data);
	 $ano = $data[2];
	 // echo $ano;
	 $mes = $data[1];
	 // echo $mes;

	 $dia = $data[0];
	 // echo $dia;


     $nextdate = mktime ( 0, 0, 0, $mes + $v, $dia, $ano );
     $date =  strftime("%Y%m%d", $nextdate);
	 $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 ); 
	 
	 return $thisday."/".$thismonth."/".$thisyear;
	}
	
	function SomaDiaData($data,$d) {
		
	 $data = explode("/",$data);
	 $ano = $data[2];
	 // echo $ano;
	 $mes = $data[1];
	 // echo $mes;

	 $dia = $data[0];
	 // echo $dia;


     $nextdate = mktime ( 0, 0, 0, $mes, $dia+$d, $ano );
     $date =  strftime("%Y%m%d", $nextdate);
	 $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 ); 
	 
	 return $thisday."/".$thismonth."/".$thisyear;
	}
}





/* End of file planos.php */
/* Location: ./system/application/libraries/planos.php */