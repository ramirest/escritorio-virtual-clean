<div align="center">
	<table border="0" width="688" id="table1" cellpadding="0" style="border-collapse: collapse">
		<tr>
			<td><?

###### Bloqueando o acesso direto a este arquivo #####

if (!preg_match("/index.php/i", $PHP_SELF))

        {

            die ("Você não tem permissão para acessar esse arquivo");


        }


######################################################

##### Extraindo os dados do cookie #####

$indicador="$aff";

########################################

##### Validando o formulário ######

if (empty($cad_nome)) {

$conteudo=pagina_erro("O Campo \"Primeiro Nome\" ficou em branco!");

return false;

} if (empty($cad_sobrenome)) {

$conteudo=pagina_erro("O Campo \"Sobrenome\" ficou em branco!");

return false;

} if (empty($cad_usuario)) {


$conteudo=pagina_erro("O Campo \"Nome de Usuário\" é obrigatório!");


return false;


} if(eregi("[(){}[!@#$%¨&*()-+={}´`^~<>.,:;?/\|]", $cad_usuario)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"textos\">O Usuário digitado contém caracteres inválidos.<br> Por favor, digite um nome de usuário usando somente letras (sem acentuação gráfica), números ou _ (underline).</div>");

return false;

} if(eregi("[áàãâäéèêëíìîïóòôõöúùûüç°ºª§¬¢£³²¹ñ]", $cad_usuario)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"textos\">O Usuário digitado contém caracteres inválidos.<br> Por favor, digite um nome de usuário usando somente letras (sem acentuação gráfica), números ou _ (underline).</div>");

return false;

} if(eregi(" ", $cad_usuario)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"textos\">Seu Usuário não pode conter espaços.<br> Digite apenas um nome ou use _ (underline).</div>");


return false;

} if (empty($cad_senha1)) {


$conteudo=pagina_erro("O Campo \"Senha\" é obrigatório!");

return false;

} if (empty($cad_senha2)) {

$conteudo=pagina_erro("O Campo \"Confirme a Senha\" é obrigatório!");

return false;

} if ($cad_senha1 != $cad_senha2) {


$conteudo=pagina_erro("A senha e a confirmação de senha não conferem!");

return false;


} if (empty($cad_email)) {


$conteudo=pagina_erro("O Campo \"E-mail\" ficou em branco!");

return false;


} if  (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $cad_email)) {

$conteudo=pagina_erro("O E-mail digitado é inválido!");

return false;

/*} if (empty($cad_email2)) {

$conteudo=pagina_erro("O Campo \"E-mail Alternativo\" ficou em branco!");

return false;

} if  (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $cad_email2)) {

$conteudo=pagina_erro("O E-mail Alternativo digitado é inválido!");

return false;

} if ($cad_email == $cad_email2) {

$conteudo=pagina_erro("O E-mail e o E-mail Alternativo precisam ser diferentes");

return false;*/


} if (empty($cad_endereco)) {

$conteudo=pagina_erro("O Campo \"Endereço\" ficou em branco!");

return false;


} if (empty($cad_cidade)) {

$conteudo=pagina_erro("O Campo \"Cidade\" ficou em branco!");

return false;

} if ($cad_estado == "--") {

$conteudo=pagina_erro("Por favor, selecione uma opção no campo \"Estado\"!");

return false;

}

##############################################################


conecta(); // Função que faz conexão com o banco


##### Verificando se o email ou apelido postado já está em uso #####

$verifica1 = mysql_query("SELECT * FROM uni_usuario WHERE email='$cad_email'"); // Verifica se o email cadastrado já existe na base de dados

$verifica2 = mysql_query("SELECT * FROM uni_usuario WHERE usuario='$cad_usuario'"); // Verifica se o apelido já está em uso

if (mysql_num_rows($verifica1) != 0) {

$conteudo=pagina_erro("O email $cad_email já se encontra cadastrado em nossa base de dados!");

} elseif (mysql_num_rows($verifica2) !=0) {

$conteudo=pagina_erro("O Nome de Usuário $cad_usuario já está em uso. Por favor, tente outro!");

} else {

##################################################################


###### Buscando os uplines na base de dados #####


            $sql = mysql_query("SELECT * FROM uni_usuario WHERE usuario = '$indicador'");

                $emailupline1 = @mysql_result($sql, 0, "email");
                $emailupline2 = @mysql_result($sql, 0, "email2");
                
                $upline2 = @mysql_result($sql, 0, "upline1");
                $upline3 = @mysql_result($sql, 0, "upline2");
                $upline4 = @mysql_result($sql, 0, "upline3");
                $upline5 = @mysql_result($sql, 0, "upline4");
                $upline6 = @mysql_result($sql, 0, "upline5");
                $upline7 = @mysql_result($sql, 0, "upline6");
                $upline8 = @mysql_result($sql, 0, "upline7");
                $upline9 = @mysql_result($sql, 0, "upline8");
                $upline10 = @mysql_result($sql, 0, "upline9");
                $upline11 = @mysql_result($sql, 0, "upline10");
                $upline12 = @mysql_result($sql, 0, "upline11");



################################################

##### Inserindo o novo usuário na base de dados #####


$datacad = date('Y-m');

$insere = "INSERT INTO uni_usuario (nome, sobrenome, usuario, sexo, nascimento, senha, email, email2, endereco, bairro, pais, cidade, estado, cep, fone, fax, celular, skype, msn, bancou, agenciau, contau, indicador, upline1, upline2, upline3, upline4, upline5, upline6, upline7, upline8, upline9, upline10, upline11, upline12, vencimento, datacad, situacao) VALUES ('$cad_nome', '$cad_sobrenome', '$cad_usuario', '$cad_sexo', '$cad_nascimento', '$cad_senha1', '$cad_email', '$cad_email2', '$cad_endereco', '$cad_bairro', '$cad_pais', '$cad_cidade', '$cad_estado', '$cad_cep', '$cad_fone', '$cad_fax', '$cad_celular', '$cad_skype', '$cad_msn', '', '', '', '$indicador', '$indicador', '$upline2', '$upline3', '$upline4', '$upline5', '$upline6', '$upline7', '$upline8', '$upline9', '$upline10', '$upline11', '$upline12', '$data', '$datacad', 'pendente')";

$resultado = mysql_query($insere);
#####################################################
##### Mensagem de confirmação que será enviada para o usuário #####

include "brpay.php";

$mensagem = "<p align=\"left\" class=\"texto\"><strong>Parab&eacute;ns $cad_nome $cad_sobrenome </strong></p><br>

<p align=\"justify\" class=\"texto\">Seu cadastro foi realizado com sucesso em nosso sistema. </strong></p> <br>

<p align=\"justify\" class=\"texto\">Para se tornar ativo no sistema, &eacute; preciso efetuar o pagamento de sua adesão. Ap&oacute;s confirma&ccedil;&atilde;o de seu pagamento, iremos ativar seu cadastro

  e seu website de membro. <br>

   <p class=\"texto\"><strong>Voc&ecirc; pode efetuar seus pagamento atrav&eacute;s do Pagseguro no bot&atilde;o

  abaixo: </strong></p>  <br>

<p class=\"texto\">$codigo_brpay</p><br>

<p class=\"texto\">Se peferir faça um depósito na conta abaixo:  </p><br>

<p class=\"texto\">$banco </p>

  <p class=\"texto\">$agencia</p>

  <p class=\"texto\">$conta</p>

  <p class=\"texto\">$valor1</p>

  <p class=\"texto\">$titular</p>  <br>


              <p class=\"texto\">$banco2</p>

  <p class=\"texto\">$agencia2</p>

  <p class=\"texto\">$conta2</p>

   <p class=\"texto\">$valor2</p>

                <p class=\"texto\">$titular2</p> <br>

<p class=\"texto\">Ap&oacute;s efetuar o dep&oacute;sito, envie-nos a confirmação através do link <a href=\"http://www.$urldosite/index.php?p=confirmar\" class=\"texto-link\">http://www.$urldosite/index.php?p=confirmar</a></p><br>

<p class=\"texto\">O prazo de toler&acirc;ncia para comprova&ccedil;&atilde;o do pagamento &eacute;

  de 3 dias. Ap&oacute;s isso, o membro que n&atilde;o comprovar o pagamento,


  n&atilde;o poder&aacute; mais permanecer na matriz. </p>


<p class=\"texto\">Desejamos a você, sucesso e prosperidade!</p> <br>


<p class=\"texto\">Atenciosamente, <br>

<strong>Equipe $nomedosite!</strong></p>


";

#################################################################


mail($cad_email,"$nomedosite - Confirme seu cadastro",$mensagem,"From: $nomedosite <$emailgeral>\nContent-Type: text/html; charset=iso-8859-1\n"); // Enviando o email

if ($cad_email2 != "") mail($cad_email2,"$nomedosite - Confirme seu cadastro",$mensagem,"From: $nomedosite <$emailgeral>\nContent-Type: text/html; charset=iso-8859-1\n"); // Enviando o email


##### Mensagem para o Upline #####################

$mensagem_upline = "Prezado $indicador

$cad_nome $cad_sobrenome ($cad_email) acaba de se cadastrar em sua página no $nomedosite.

Entre em contato com essa pessoa e o incentive a permanecer em sua rede de associados.


ATENÇÃO

A inclusão do novo assinante é feita após o pagamento de sua adesão através de depósito bancário.

Este e-mail não garante que a pessoa quitou a adesão.

Lembre-se, no marketing de rede você é responsável pelo progresso dos seus convidados.

Entre em contato com seu novo Consultor e/ou cliente o mais rápido possível e garanta assim um crescimento forte e firme de sua rede.

Seja atencioso e invista em sua equipe.

O não pagamento dessa proposta de adesão ao sistema fará que o novo assinante seja excluído de sua rede, sendo que após isso o mesmo poderá se cadastrar com outro consultor.

Após a comprovação de pagamento deste novo associado você receberá a comissão correspondente.


Atenciosamente

Administração
$nomedosite

";

mail($emailupline1,"Novo Indicado em Sua Rede",$mensagem_upline,"From: $nomedosite <$emailgeral>");


if ($emailupline2 != "") mail($emailupline2,"Novo Indicado em Sua Rede",$mensagem_upline,"From: $nomedosite <$emailgeral>");

#################################################

$conteudo=pagina_mensagem("$mensagem");

}

?>



</td>
		</tr>
	</table>
</div>
