<?

if(!isset($cad_usuario)) {

$cad_usuario = $user_cobranca;

}



########### Código Pagseguro ##############

$codigo_brpay = "<form target=\"brpay\" action=\"https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx\" method=\"post\">

<input type=\"hidden\" name=\"email_cobranca\" value=\"$emailpagseguro\">

<input type=\"hidden\" name=\"tipo\" value=\"CP\">

<input type=\"hidden\" name=\"moeda\" value=\"BRL\">

<input type=\"hidden\" name=\"item_id_1\" value=\"$cad_usuario $data_brasil\">

<input type=\"hidden\" name=\"item_descr_1\" value=\"$nomedosite ($cad_usuario)\">

<input type=\"hidden\" name=\"item_quant_1\" value=\"1\">

<input type=\"hidden\" name=\"item_valor_1\" value=\"$valorpagseguro\">

<input type=\"hidden\" name=\"item_frete_1\" value=\"000\">

<input type=\"image\" src=\"https://pagseguro.uol.com.br/Security/Imagens/btnPagueComBR.jpg\" name=\"submit\" alt=\"Pague com Pagseguro - é rápido, grátis e seguro!\">

</form>";

#######################################



?>

