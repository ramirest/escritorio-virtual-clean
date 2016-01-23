<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	It is recommended for you to change 'auth_login_incorrect_password' and 'auth_login_username_not_exist' into something vague.
	For example: Username and password do not match.
*/

$lang['auth_login_incorrect_password'] = "Sua senha está incorreta.";
$lang['auth_login_username_not_exist'] = "Nome de Usuário não existe.";

$lang['auth_username_or_email_not_exist'] = "Nome de Usuário ou email não existe.";
$lang['auth_not_activated'] = "Sua conta ainda não foi ativada. Por favor, verifique seu email.";
$lang['auth_request_sent'] = "Seu pedido de alteração de senha já foi enviado. Por favor, verifique seu email.";
$lang['auth_incorrect_old_password'] = "Sua senha antiga está incorreta.";
$lang['auth_incorrect_password'] = "Sua senha está incorreta.";

// Email subject
$lang['auth_account_subject'] = "Detalhes da conta %s";
$lang['auth_activate_subject'] = "Ativação %s";
$lang['auth_forgot_password_subject'] = "Solicitação de nova senha";

// Email content
$lang['auth_account_content'] = "Bem vindo ao %s,

Obrigado por se registrar. Sua conta foi criada com sucesso.

Você pode efetuar login com seu nome de usuário ou email:

Login: %s
Email: %s
Senha: %s

Você pode acessar agora indo em %s

Esperamos superar todas as suas expectativas e estamos trabalhando muito para que isso aconteça!

Atenciosamente,
Equipe %s";

$lang['auth_activate_content'] = "Bem vindo ao %s,

Para ativar sua conta, você precisa clicar no link de ativação abaixo:
%s

Por favor, ative sua conta dentro %s horas, do contrário seu registro se tornará inválido e você terá que se registrar novamente.

Você pode usar seu nome de usuário ou email para entrar.
Os detalhes de sua conta segue abaixo:

Login: %s
Email: %s
Senha: %s

Nós desejamos que você atenda todas as suas expectativas juntamente conosco. :)

Atenciosamente,
Equipe %s";

$lang['auth_forgot_password_content'] = "%s,

Você solicitou que sua senha fosse alterada, pelo fato de tê-la esquecido.
Por favor, clique no link abaixo a fim de completar o processo de alteração de senha:
%s

Sua nova senha: %s
Chave para ativação: %s

Depois de completar este processo, você poderá trocar para uma senha que preferir.

Caso ainda não consiga acessar sua conta, por favor entre em contato com %s.

Atenciosamente,
Equipe %s";

/* End of file dx_auth_lang.php */
/* Location: ./application/language/english/dx_auth_lang.php */