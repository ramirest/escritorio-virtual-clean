<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "escritorio-virtual/dashboard";
#$route['default_controller'] = "escritorio-virtual/cadastro";
$route['404_override'] = '';

$route['cadastro/(:any)'] = "escritorio-virtual/cadastro/index/$1";
$route['escritorio-virtual/empresarios/cadastro'] = "escritorio-virtual/cadastro";
$route['cadastro'] = "escritorio-virtual/cadastro";

$route['escritorio-virtual/empresas/ver/(:num)'] = "escritorio-virtual/empresas/editar/$1/TRUE";

$route['escritorio-virtual/planos/cadastro'] = "escritorio-virtual/planos/adicionar";

$route['escritorio-virtual/empresarios/(P)'] = "escritorio-virtual/rede/linear/$1";

$route['escritorio-virtual/empresarios/(A)'] = "escritorio-virtual/rede/linear/$1";

$route['escritorio-virtual/empresarios/(I)'] = "escritorio-virtual/rede/linear/$1";

$route['escritorio-virtual/configs/(:any)'] = "escritorio-virtual/configs/$1";

$route['escritorio-virtual/cms/(:num)'] = "escritorio-virtual/cms/index/$1";

$route['escritorio-virtual/ads/index/(:any)'] = "escritorio-virtual/ads/index/$1";

$route['oauth/client_id/(:any)/redirect_uri/(:any)/response_type/(:any)'] = "oauth/index/client_id?$1&redirect_uri=$2&response_type=$3";

//$route['perfil/(:any)/(:num)'] = "escritorio-virtual/empresarios/editar/$1/$2";

$route['faleconosco'] = "principal/faleconosco";
$route['faq'] = "principal/faq";
$route['login'] = "auth";
$route['logout'] = "auth/logout";
$route['recuperar_senha'] = "auth/forgot_password";
$route['auth/recriar_senha/(:any)/(:any)'] = "auth/reset_password/$1/$2";
$route['alterar_senha'] = "escritorio-virtual/empresarios/alterar_senha";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
