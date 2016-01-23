<?php 

function FormataDataBR($data){
if ($data == '')
	return '';
$data_f = explode('-',$data);
return $data_f[2].'/'.$data_f[1].'/'.$data_f[0];
}


function numberBR($valor)
{
 return number_format($valor, 2, ',', '.');
}

?>