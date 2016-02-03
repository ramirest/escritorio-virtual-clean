<?



// Proteção contra injeção de SPAM

foreach ($_POST as $j =>$value) {

if (stristr($value,"Content-Type")) {

header("HTTP/1.0 403 Forbidden");

exit;

}

}



###### Bloqueando o acesso direto a este arquivo #####

if (!preg_match("/index.php/i", $PHP_SELF))

        {

            die ("Você não tem permissão para acessar esse arquivo");

        }

######################################################





/*Código de confirmação

require('captcha/php-captcha.inc.php');

$codigo_captcha = $_POST['codigo'];

if (PhpCaptcha::Validate($codigo_captcha)) {

} else {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\"><b>O código de confirmação digitado está incorreto!<br><br> Por favor, tente novamente!</b></div>");

return false;

}    */





// Validando o campo Titular da Conta

if (empty($titular_b)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"Titular da Conta\" não pode ficar em branco!</div>");

return false; }



// Verificando o campo Agência

if (empty($agencia_b)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"Agência\" não pode ficar em branco!</div>");

return false; }



// Verificando o campo Nº da Conta

if (empty($conta_b)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"N° da Conta\" não pode ficar em branco!</div>");

return false; }



// Verificando o campo Nome Completo

if (empty($nome)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"Nome Completo\" não pode ficar em branco!</div>");

return false; }



// Verificando o campo Login no Sistema

if (empty($login)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"Login no Sistema\" não pode ficar em branco!</div>");

return false; }



// Verificando o campo Email Cadastro

if (empty($email)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"E-Mail Cadastrado\" não pode ficar em branco!</div>");

return false; }



// Verificando se o email é válido

if  (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$", $email)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O \"E-mail Cadastrado\" que você digitou é inválido!</div>");

return false; }



// Verificando o campo Data do Depósito

if (empty($datadeposito)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"Data do Depósito\" não pode ficar em branco!</div>");

return false; }


if (empty($valor_b)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O campo \"Valor\" não pode ficar em branco!</div>");

return false; }


// Verificando o campo Banco

/*if (empty($banco_b)) {

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">Por favor, selecione o banco onde foi feito o depósito!</div>");

return false; }  */





// Qual o banco em que foi feito o depósito?

if($banco_b == "Banco do Brasil") {

$detalhes .= "TERM.: $term \n";

$detalhes .= "N. TRANS.: $ntrans";

}



if($banco_b == "Bradesco") {

$detalhes .= "TERM.: $term \n";

$detalhes .= "N. TRANS.: $ntrans";

}



    if($banco_b == "Pagseguro") {

$detalhes .= "TERM.: $term \n";

$detalhes .= "N. TRANS.: $ntrans";

}



if ($banco_b == "Caixa Econômica Federal") {

$detalhes = "Nº do Comprovante: $comprovante";

}



// Corpo da mensagem

$body = "Confirmação de Pagamento Enviada por $nome dia $data_brasil as $hora
IP de envio: $_SERVER[REMOTE_ADDR]
---------------------

Informações completas a respeito do beneficiário:


Títular da conta: $titular_b
Agência: $agencia_b
Nº da conta: $conta_b

Informações a respeito do depositante:

Nome Completo: $nome
Login no Sistema: $login
E-mail cadastrado: $email
Data do depósito: $datadeposito
Valor pago: $valor_b
Hora: $horadeposito
Dados do comprovante: $agvinculada

Observações: $agvinculada2

";



// Verificando o restante do anexo e colocando os cabecários do email

$mime_list = array("html"=>"text/html","htm"=>"text/html", "txt"=>"text/plain", "rtf"=>"text/enriched","csv"=>"text/tab-separated-values","css"=>"text/css","gif"=>"image/gif");



$boundary = "XYZ-" . date(dmyhms) . "-ZYX";



$message = "--$boundary\n";

$message .= "Content-Transfer-Encoding: 8bits\n";

$message .= "Content-Type: text/plain; charset=\"ISO-8859-1\"\n\n";

$message .= $body;

$message .= "\n";



$attachments[1] = $anexo;



foreach ($attachments as $key => $full_path) {

if ($full_path !='') {

       if (file_exists($full_path)){

             if ($fp = fopen($full_path,"rb")) {

                     $filename = array_pop(explode(chr(92),$full_path));

                     $contents = fread($fp,filesize($full_path));

                     $encoded = base64_encode($contents);

                     $encoded_split = chunk_split($encoded);

                     fclose($fp);

                     $message .= "--$boundary\n";

                     $message .= "Content-Type: $anexo_type\n";

                     $message .= "Content-Disposition: attachment; filename=\"$anexo_name\" \n";

                     $message .= "Content-Transfer-Encoding: base64\n\n";

                     $message .= "$encoded_split\n";

             }

             else {

                         $conteudo=pagina_erro("<div align=\"center\" class=\"texto\">Impossível abrir o arquivo$key: $filename</div>");

            return false; }

       }

       else {

                    $conteudo=pagina_erro("<div align=\"center\" class=\"texto\">O arquivo$key não existe: $filename</div>");

            return false;

                         }



}

}



$extensao = substr($anexo_name,-3);

if ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "gif" && $anexo != ""){

$conteudo=pagina_erro("<div align=\"center\" class=\"texto\">Só é possível o envio de arquivos do tipo *.jpg, *.png, *.jpeg ou *.gif.</div>");

return false; }



$message .= "--$boundary--\r\n";



$headers = "MIME-Version: 1.0\n";

$headers .= "From: <$emailgeral>\r\n";

$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";



// Envia o email

$mensagem=mail("$emailgeral", "Confirmação de Pagamento Via Formulário - $nomedosite", $message, $headers);



if ($mensagem) {

        $conteudo=pagina_mensagem("<div align=\"center\" class=\"texto\">Sua confirmação de pagamento foi enviada com sucesso!<br><br>

        Por favor aguarde o prazo de até 24 horas úteis para ativação de seu cadastro no Sistema!</div>");

        return false;



}



?>

