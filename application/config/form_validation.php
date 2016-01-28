<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Validacao de formularios
| -------------------------------------------------------------------------
| Arquivo com definição de validação de todos os formulários
|
|
*/

// Usado pelos formulários de cadastro e alteração de senha
$min_username = 4;
$max_username = 20;
$min_password = 4;
$max_password = 20;

$config = array(
			'alterar_senha'=>array(
								array('field'=>'old_password',
									  'label'=>'senha atual',
									  'rules'=>'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']'
								),
								array('field'=>'new_password',
									  'label'=>'nova senha',
									  'rules'=>'trim|required|xss_clean|min_length['.$min_password.']|max_length['.$max_password.']|matches[confirm_new_password]',			
								),
								array('field'=>'confirm_new_password',
									  'label'=>'confirmar nova senha',
									  'rules'=>'trim|required|xss_clean',								
								)
			),
			'cadastro' => array(
							array('field'=>'email',
								  'label'=>'email',
								  'rules'=>'trim|xss_clean|required|valid_email|is_unique[users.email]'
							),
							array('field'=>'numtel',
								  'label'=>'telefone fixo',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'numcel',
								  'label'=>'celular',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'nome_fantasia',
								  'label'=>'nome fantasia',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'razao_social',
								  'label'=>'razão social',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'cnpj',
								  'label'=>'CNPJ',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'ie',
								  'label'=>'inscrição estadual',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'nome_completo',
								  'label'=>'nome completo',
								  'rules'=>'trim|xss_clean|required'
							),
							array('field'=>'sexo[]',
								  'label'=>'sexo',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'dtnasc',
								  'label'=>'data de nascimento',
								  'rules'=>'trim|xss_clean|required'
							),
							array('field'=>'cpf',
								  'label'=>'CPF',
								  'rules'=>'trim|xss_clean|required|is_unique[ass_dados_pessoais.cpf]'
							),
							array('field'=>'rg',
								  'label'=>'RG',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'pis_pasep',
								  'label'=>'PIS / PASEP',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'profissao[]',
								  'label'=>'profissão',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'funcao_empresa',
								  'label'=>'função na empresa',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'tipo[]',
								  'label'=>'tipo de endereço',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'cep',
								  'label'=>'CEP',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'logradouro',
								  'label'=>'logradouro',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'numero',
								  'label'=>'número',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'complemento',
								  'label'=>'complemento',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'bairro',
								  'label'=>'bairro',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'cidade',
								  'label'=>'cidade',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'estado',
								  'label'=>'estado',
								  'rules'=>'trim|xss_clean'
							),
							array('field'=>'login',
								  'label'=>'login',
								  'rules'=>'trim|xss_clean|required|is_unique[users.username]'
							),
							array('field'=>'senha',
								  'label'=>'senha',
								  'rules'=>'trim|xss_clean|required|matches[conf_senha]'
							),
							array('field'=>'conf_senha',
								  'label'=>'de verificação de senha',
								  'rules'=>'trim|xss_clean|required'
							)
			),
            'gerencia_estoque' => array(
                array('field' => 'tp_mov',
                    'label' => 'Tipo de Movimentação',
                    'rules'=>'trim|xss_clean|required'
                ),
            ),
            'saida_estoque' => array(
                array('field' => 'quantidade_txt',
                    'label' => 'Quantidade',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field' => 'produto-select',
                    'label' => 'Produto',
                    'rules'=>'trim|xss_clean|required'
                )
            ),
            'entrada_estoque' => array(
                array('field' => 'quantidade_txt',
                    'label' => 'Quantidade',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field' => 'produto-select',
                    'label' => 'Produto',
                    'rules'=>'trim|xss_clean|required'
                )
            ),
            'cadastro_imoveis' => array(
                array('field'=>'descricao',
                    'label'=>'descrição',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'tipo[]',
                    'label'=>'tipo de endereço',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'cep',
                    'label'=>'CEP',
                    'rules'=>'trim|xss_clean'
                ),
                array('field'=>'logradouro',
                    'label'=>'logradouro',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'numero',
                    'label'=>'número',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'complemento',
                    'label'=>'complemento',
                    'rules'=>'trim|xss_clean'
                ),
                array('field'=>'bairro',
                    'label'=>'bairro',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'cidade',
                    'label'=>'cidade',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'estado',
                    'label'=>'estado',
                    'rules'=>'trim|xss_clean|required'
                ),
                array('field'=>'telefone',
                    'label'=>'telefone',
                    'rules'=>'trim|xss_clean'
                ),
                array('field'=>'empresa',
                    'label'=>'empresa',
                    'rules'=>'trim|xss_clean|required'
                )
            )
			);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */