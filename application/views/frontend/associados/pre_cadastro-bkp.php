<div class="cadastro001">
    <div class="sub_cadastro001">

<br class="quebra">
<br>
<br>
<br>
<br>


<?php
echo form_open("hotsite/pre_cadastro");

echo form_error('email', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('numtel', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('numcel', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('patrocinador', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('nome_fantasia', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('razao_social', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('cnpj', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('ie', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('nome_completo', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('dtnasc', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('cpf', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('rg', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('profissao', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('funcao_empresa', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('tipo', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('cep', $this->config->item('err_msg_style'), $this->config->item('msg_style_end'));

echo form_error('logradouro', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('numero', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('bairro', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('cidade', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('estado', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 

echo form_error('login', $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); 
?>
<div id="abas_cadastro">
        <ul>
            <li style="width: 139px; height: 37px"><a href="#tabs-1">Contato</a></li>
            <li style="width: 139px; height: 37px"><a href="#tabs-2">Dados pessoais</a></li>
            <li style="width: 139px; height: 37px"><a href="#tabs-3">Endereço</a></li>
            <li style="width: 139px; height: 38px"><a href="#tabs-4">Acesso</a></li>
        </ul>
        <div id="tabs-1"> 



 <div style=" font-size:15px;">Email:</div>
 <div class="row">
      <div class="col-md-10 form-group" style=" margin-top:2px;">
        <?php
            $email = array(
                        'name'=>'email',
                        'id'=>'email',
                        'data-required'=>'',
                        'data-validate'=>'email',
                        'value'=>set_value('email'),
                        'class'=>'form-control');
            ?>
        <?php echo form_input($email); ?>
        
      <small id="email-description"></small>
       </div>
 </div>
<div style=" float:left;">
    
    <div style=" float:left;">
      <div style=" margin-top:15px; font-size:15px;">Telefone fixo:</div>
      
      
      
      <p style=" margin-top:2px; float:left;">
        <?php
        $telefone = array(
					'name'=>'numtel',
					'id'=>'numtel',
					'placeholder'=>'(031) 3616-0917',
					'value'=>set_value('numtel'),
					'class'=>'form-control');
		?>
        <?php echo form_input($telefone); ?>
        </p>
      
      
      </div>
    
    
    <div style=" float:left;">
      <div style="margin-top:15px; margin-left:52px; font-size:15px;">Celular:</div>
      
      <p style="margin-top:2px; margin-left:53px; float:left;">
        <?php
        $celular = array(
					'name'=>'numcel',
					'id'=>'numcel',
					'placeholder'=>'(031) 3616-0917',
					'value'=>set_value('numcel'),
					'class'=>'form-control');
		?>
        <?php echo form_input($celular); ?>
        </p>
      
      </div>
  </div>
  <br class="quebra">
      <span class="help-block">Para regiões que utilizam cinco dígitos no prefixo, o primeiro dígito deve ser informado dentro dos parênteses, logo após o DDD, Ex: (119) 3616-0917. para as demais regiões, conforme o exemplo nos campos acima.</span>
  <br>
          <a href="#" id="btn_proximo_2">Próximo</a>
          </div>


          <div id="tabs-2">
            <div style=" font-size:15px;">Patrocinador:</div>
              
            <?php if($this->session->userdata('patrocinador') === FALSE):?>
            <div class="row">    
                <div class="col-md-10 form-group" style=" margin-top:2px;">
                <?php 
                $patrocinador_txt = array(
                    'name'=>'patrocinador_txt',
                    'id'=>'patrocinador_txt',
                    'data-validate'=>'patrocinador',
                    'class'=>'form-control');
                ?>
                <?php echo form_input($patrocinador_txt); ?>
                <small id="patrocinador-description"></small>
                </div>
            </div>  
            <?php
			else:
				$ass = $this->session->userdata('patrocinador');
				echo $ass->Nome;
				echo form_hidden('patrocinador', $ass->aid);
            endif;
			?>
            <div style=" font-size:15px;  margin-top:15px;">Tipo de cadastro</div>
              
          <div class="row">    
            <div class="styled-select">
			<?php 
            $tpcadastro = array('PF'=>'Pessoa Física', 'PJ'=>'Pessoa Jurídica');
            echo form_dropdown('tp_cadastro', $tpcadastro, set_value('tp_cadastro'), 'class="form-control"'); 	
            ?>
            </div>
          </div>    
              
            <div id="pessoa_juridica" style="display:none">
              <div style=" font-size:15px; margin-top:15px;">Nome Fantasia:</div>
          <div class="row">    
              <p class="col-md-10" style=" margin-top:2px;">
                <?php
        $nome_fantasia = array(
					'name'=>'nome_fantasia',
					'value'=>set_value('nome_fantasia'),
					'class'=>'form-control');
		?>
                <?php echo form_input($nome_fantasia);  ?>
              </p>
          </div>      
                
              <div style=" font-size:15px; margin-top:15px;">Razão Social:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $razao_social = array(
                        'name'=>'razao_social',
                        'value'=>set_value('razao_social'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($razao_social);  ?>
                  </p>
              </div>      
                
              <div style=" font-size:15px; margin-top:15px;">CNPJ:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $cnpj = array(
                        'name'=>'cnpj',
                        'id'=>'cnpj',
                        'value'=>set_value('cnpj'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($cnpj);  ?>
                  </p>
              </div>      
                
              <div style=" font-size:15px; margin-top:15px;">IE:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $ie = array(
                        'name'=>'ie',
                        'value'=>set_value('ie'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($ie);  ?>
                  </p>
              </div>    
            </div>
            <div id="pessoa_fisica" style="display:block">
              <h4  style="float:left; margin-top:25px; display:none;" id="contato_empresa">Pessoa Responsável</h4> 
                
              <br class"quebra"><br> <br>
                
              <div style=" font-size:15px; margin-top:15px;">Nome Completo:</div>
              <div class="row">    
                  <div class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $nome_completo = array(
                        'name'=>'nome_completo',
                        'id'=>'nome_completo',
                        'data-required'=>'',
                        'data-describedby'=>'nome-description',
                        'data-description'=>'nome',
                        'value'=>set_value('nome_completo'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($nome_completo);  ?>
                    <small id="nome-description"></small>
                  </div>
               </div>
                
              <div style=" font-size:15px;  margin-top:15px;">Sexo</div>
              <div class="row">    
                  <p class="col-md-10 styled-select">
					<?php echo form_label('Sexo', 'sexo'); ?>
                    <?php 
                    $sexo = array('M'=>'Masculino', 'F'=>'Feminino');
                    echo form_dropdown('sexo', $sexo, set_value('sexo'), 'class="form-control"'); 					
                    ?>
                  </p>
              </div>      
                
              <div style=" font-size:15px; margin-top:15px;">Data de Nascimento:</div>
              <div class="row">    
                  <p class="col-md-6" style=" margin-top:2px;">
					<?php
                    $dtnasc = array(
                        'name'=>'dtnasc',
                        'id'=>'dtnasc',
						'placeholder'=>'01/01/2000',
						'data-required'=>'',
                        'data-describedby'=>'data-description',
                        'data-description'=>'data',
                        'value'=>set_value('dtnasc'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($dtnasc);  ?>
                    <small id="data-description"></small>
                  </p>
              </div>      
                
              <div style=" font-size:15px; margin-top:15px;">CPF:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $cpf = array(
                        'name'=>'cpf',
                        'id'=>'cpf',
						'data-required'=>'',
						'data-conditional'=>'cpf',
                        'data-describedby'=>'cpf-description',
                        'data-description'=>'cpf',
                        'value'=>set_value('cpf'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($cpf);  ?>
                    <small id="cpf-description"></small>
                  </p>
             </div>       
                
              <div style=" font-size:15px; margin-top:15px;">RG:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $rg = array(
                        'name'=>'rg',
                        'value'=>set_value('rg'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($rg);  ?>
                  </p>
              </div>  
                  
              <div style=" font-size:15px;  margin-top:15px;">PIS / PASEP</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $pis = array(
                        'name'=>'pis_pasep',
                        'value'=>set_value('pis_pasep'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($pis); ?>
                  </p>
              </div>      
                
              <div style=" font-size:15px; margin-top:15px;">Profissão:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $profissao = array(
                        'name'=>'profissao',
                        'value'=>set_value('profissao'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($profissao);  ?>
                  </p>
             </div>       
                
              <div style=" font-size:15px; margin-top:15px;">Função na empresa:</div>
              <div class="row">    
                  <p class="col-md-10" style=" margin-top:2px;">
                    <?php
                    $funcao_empresa = array(
                        'name'=>'funcao_empresa',
                        'value'=>set_value('funcao_empresa'),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($funcao_empresa);  ?>
                  </p>
              </div>
            </div>
            
              <br class="quebra">

          <a href="#" id="btn_proximo_3">Próximo</a>  
</div>
          <div id="tabs-3">
  <div style=" font-size:15px;  margin-top:15px;">Tipo:</div>
              
            <div class="styled-select" style=" margin-left:0; margin-top:5px; width:345px;">
              <?php echo form_dropdown('tipo', $tipos, set_value('tipo'), 'style="width:345px"'); ?>
            </div>
              
              
              
            <div style=" font-size:15px; margin-top:15px;">CEP:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
                  <?php
                    $cep = array(
                                'name'=>'cep',
                                'id'=>'cep',
								'data-required'=>'',
								'data-conditional'=>'cep',
								'data-describedby'=>'msg',
								'data-description'=>'cep',
                                'value'=>set_value('cep'),
                                'class'=>'form-control');
                  ?>
                  <?php echo form_input($cep); ?>
                <a href="http://www.buscacep.correios.com.br/" target="_blank">N&atilde;o sei o cep</a>
                <small id="msg" class="row"></small>  
                </p>
            </div>  
              
            <div style=" font-size:15px; margin-top:15px;">Endereço:</div>
            <div class="row">    
                <p class="col-md-10" style=" margin-top:2px;">
              <?php
        $logradouro = array(
					'name'=>'logradouro',
					'id'=>'logradouro',
					'value'=>set_value('logradouro'),
					'class'=>'form-control');
		?>
              <?php echo form_input($logradouro); ?>
                </p>
            </div>
              
            <div style=" font-size:15px; margin-top:15px;">Número:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				<?php
                $numero = array(
                    'name'=>'numero',
                    'id'=>'numero',
                    'value'=>set_value('numero'),
                    'class'=>'form-control');
                ?>
				<?php echo form_input($numero); ?>
                </p>
              </div>
              
            <div style=" font-size:15px; margin-top:15px;">Complemento:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				<?php
                $complemento = array(
                    'name'=>'complemento',
                    'value'=>set_value('complemento'),
                    'class'=>'form-control');
                ?>
                <?php echo form_input($complemento); ?>
                </p>
             </div> 
              
            <div style=" font-size:15px; margin-top:15px;">Bairro:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				<?php
                $bairro = array(
                    'name'=>'bairro',
                    'id'=>'bairro',
                    'value'=>set_value('bairro'),
                    'class'=>'form-control');
                ?>
				<?php echo form_input($bairro); ?>
                </p>
              </div>
              
            <div style=" font-size:15px; margin-top:15px;">Cidade:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				<?php
                $cidade = array(
                    'name'=>'cidade',
                    'id'=>'cidade',
                    'value'=>set_value('cidade'),
                    'class'=>'form-control');
                ?>
                <?php echo form_input($cidade); ?>
                </p>
              </div>
              
            <div style=" font-size:15px;  margin-top:15px;">Estado:</div>
              
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				<?php
                $estado = array(
                    'name'=>'estado',
                    'id'=>'estado',
                    'value'=>set_value('estado'),
                    'class'=>'form-control');
                ?>
                <?php echo form_input($estado); ?>
                    
                </p>
            </div>
            
              <br class="quebra">

          <a href="#" id="btn_proximo_4">Próximo</a>  
          </div>


<div id="tabs-4">
    <div style=" font-size:15px; margin-top:15px;">Login:</div>
    <div class="row">    
        <p class="col-md-4" style=" margin-top:2px;">
		<?php
        $login = array(
                    'name'=>'login',
                    'id'=>'login',
					'data-required'=>'',
					'data-describedby'=>'login_description',
					'data-description'=>'login',
                    'value'=>set_value('login'),
                    'class'=>'form-control');
        ?>
		<?php echo form_input($login); ?>
        <small id="login_description" class="row"></small>  
        </p>
     </div>   
  
    <div style=" float:left;">
        <div style=" font-size:15px; margin-top:15px;">Senha:</div>
        <div class="row">    
            <p class="col-md-10" style=" margin-top:2px;">
			<?php
			$senha = array(
						'name'=>'senha',
						'id'=>'senha',
						'data-required'=>'',
						'data-describedby'=>'senha_description',
						'data-description'=>'senha',
						'class'=>'form-control');
            ?>
            <?php echo form_password($senha); ?>
            <small id="senha_description" class="row"></small>  
            </p>
        </div>
	</div>

    <div style=" float:left;">
        <div style="margin-top:15px; margin-left:52px; font-size:15px;">Redigite a senha:</div>
        <div class="row">    
            <p class="col-md-10" style=" margin-top:2px;">
			<?php
			$conf_senha = array(
						'name'=>'conf_senha',
						'id'=>'conf_senha',
						'data-conditional'=>'conf_senha',
						'data-describedby'=>'conf_senha_description',
						'data-description'=>'conf_senha',
						'class'=>'form-control');
            ?>
            <?php echo form_password($conf_senha); ?>
            <small id="conf_senha_description" class="row"></small>  
            </p>
         </div>   
  	</div>
  
<!--  
  <br class="quebra" />
  </br>
  
  <div class="contrato">

<p>PowerPoint faz muito mais do que apenas a exibição de texto e imagens. É cheio de truques e petiscos para que você pode fazer quase qualquer coisa, como criar uma caixa de texto de rolagem. Se você tem muito texto para caber na tela, ou você quer criar o efeito de uma página da Web dentro da sua apresentação, você pode utilizar uma caixa de texto de rolagem. no PowerPoint requer o uso de um controle ActiveX, que é uma ferramenta de design do site, mas pode ser incorporado em software Microsoft Office.</p>
<p>Passo 1</p>
<p>Clique no "Developer" guia no canto direito da fita do Microsoft Office em PowerPoint. Se você não vê a guia Desenvolvedor, ative-o. Clique na guia "Arquivo", clique em "Opções", selecione "Personalizar Faixa de Opções" e clique em "Developer" na seção Guias principal. Clique em "OK".</p>
<p>Passo 2</p>
<p>Clique no botão "Caixa de Texto" controle ActiveX da seção Controles. Se você não sabe qual ícone ou seja, mantenha o mouse sobre os ícones até a ponta da ferramenta aparece.</p>
<p>Passo 3</p>
<p>Clique e arraste sobre o slide para desenhar a caixa de texto.</p>
<p>Passo 4</p>
<p>Botão direito do mouse na caixa de texto ActiveX e selecione "Propriedades".</p>
<p>Passo 5</p>
<p>Faça os seguintes ajustes: Defina o valor para barras de rolagem para "3 - fmScrollBarsBoth". Defina o valor para MultiLine como "True". Digite o texto que deseja na caixa de valor para o texto. Clique no botão "X" no canto superior direito quando você está feito. As entradas são automaticamente confirmada quando você os digita.</p>
<p>Passo 6</p>
<p>Pressione "Shift-F5" para iniciar a apresentação de slides em que slide. O efeito de rolagem só vai ocorrer quando a apresentação de slides está em execução e se não houver texto suficiente para ir além da parte inferior da caixa de texto. Redimensionar a caixa de texto com as alças se quiser maior ou menor.</p>
<p>Dicas</p>
<p>Você não pode usar a roda de rolagem do mouse-a rolar na caixa de texto. Você deve clicar e arrastar a barra de rolagem ou clique nas setas para cima e para baixo.</p>
</div>

  <div style=" float:left; margin-top:15px;">

<div class="roundedTwo">
	<input type="checkbox" value="None" id="roundedTwo" name="check" />
	<label for="roundedTwo"></label>
</div>

<div style=" float:left; font-size:18px; font-family:eras_medium_itcregular, arial; margin-top:10px; margin-left:5px;">LI E CONCORDO COM OS TERMOS</div>
</div>

-->  
  
  
  
  <br class="quebra" />
  </br>
  
  <p style=" margin-top:-19px; margin-left:8px;">
    <?php echo form_button(array('name'=>'enviar','id'=>'enviar','type'=>'submit','content'=>'<img src="'.$this->config->item('img_f').'02.jpg">')); ?>
    </p>
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
