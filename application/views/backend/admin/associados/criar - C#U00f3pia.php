<div class="row">
<?php 
?>
<?php
echo form_open("adm/associados/criar", $this->config->item('form_style'));

echo form_error('email', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('numtel', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('numcel', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('patrocinador', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('nome_fantasia',
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('razao_social',
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('cnpj', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('ie', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('nome_completo',
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('dtnasc', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('cpf', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('rg', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('profissao',
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('funcao_empresa',
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('tipo', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('cep', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end'));

echo form_error('logradouro', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('numero', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('bairro', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('cidade', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('estado', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 

echo form_error('login', 
				sprintf($this->config->item('err_msg_style'), 'row'), 
				$this->config->item('msg_style_end')); 
?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		<div class="float-left">
        	<?php echo anchor($this->config->item('btn_back_url').'/associados',
							  $this->config->item('btn_back_txt').' de associados',
							  $this->config->item('btn_back_attr'));
			?>
		</div>
		
		<div class="float-right" id="save-button"> 
			<?php echo form_button(array('name'=>'enviar','id'=>'save','type'=>'submit','content'=>'<img src="'.$this->config->item('img').'icons/fugue/tick-circle.png"> Salvar')); ?>            
		</div>
			
	</div></div>
	<!-- End control bar -->

<hr>
<div class="col-sm-3">
    <ul id="userSettings" class="nav nav-pills nav-stacked">
        <li><a href="#dados-pessoais" data-toggle="tab" id="lnk1"><i class="fa fa-user fa-fw"></i>Dados Pessoais</a></li>
        <li><a href="#endereco" data-toggle="tab" id="lnk2"><i class="fa fa-road fa-fw"></i>Endereço</a></li>
        <li><a href="#informacoes-contato" data-toggle="tab" id="lnk3"><i class="fa fa-envelope-o fa-fw"></i>Informações para contato</a></li>
        <li><a href="#informacoes-conta" data-toggle="tab" id="lnk4"><i class="fa fa-lock fa-fw"></i>Informações da conta</a></li>
    </ul>
</div>
<div class="col-sm-9">
<div class="tab-content">
<div id="dados-pessoais" class="tab-pane fade in active">
	<?php if($this->session->userdata('patrocinador') === FALSE):?>
    <div class="row">
      <div class="col-md-6 form-group" style=" margin-top:2px;">
        <p>
            <?php echo form_label('Patrocinador', 'patrocinador_txt'); ?>
            <?php 
            $patrocinador_txt = array(
                'name'=>'patrocinador_txt',
                'id'=>'patrocinador_txt',
                'data-required'=>'',
                'data-validate'=>'patrocinador',
                'value'=>set_value('patrocinador_txt'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($patrocinador_txt); ?>
        <small id="patrocinador-description"></small>
        </p>
      </div>  
    </div>  
	<?php
    else:
        $ass = $this->session->userdata('patrocinador');
        echo $ass->Nome."<br>";
		echo anchor('adm/associados/criar/0', 'Trocar patrocinador');
        echo form_hidden('patrocinador', $ass->aid);
		echo "<br><br>";
    endif;
    ?>
    <p>
        <?php echo form_label('Em qual rede deseja posicionar o novo empresário?', 'rede_alocacao'); ?>
        <?php 
        $redes = array('AUTO'=>'Rede Menor', 'D'=>'Direita', 'E'=>'Esquerda');
        echo form_dropdown('rede_alocacao', $redes, 'AUTO'); 					
        ?>
    </p>
    <p>
        <?php echo form_label('Tipo de cadastro', 'tp_cadastro'); ?>
		<?php 
        $tpcadastro = array('PF'=>'Pessoa Física', 'PJ'=>'Pessoa Jurídica');
        echo form_dropdown('tp_cadastro', $tpcadastro, set_value('tp_cadastro'), 'class="form-control"'); 	
        ?>
    </p>
    <div id="pessoa_juridica" style="display:none">
        <p>
            <?php echo form_label('Nome fantasia', 'nome_fantasia'); ?>
            <?php echo form_input('nome_fantasia', set_value('nome_fantasia'));  ?>
        </p>
        <p>
            <?php echo form_label('Razão social', 'razao_social'); ?>
            <?php echo form_input('razao_social', set_value('razao_social'));  ?>
        </p>
        <p>
			<?php
            $cnpj = array(
                'name'=>'cnpj',
                'id'=>'cnpj',
                'value'=>set_value('cnpj'),
                'class'=>'form-control');
            ?>
            <?php echo form_label('CNPJ', 'cnpj'); ?>
            <?php echo form_input($cnpj);  ?>
        </p>
        <p>
            <?php echo form_label('IE', 'ie'); ?>
            <?php echo form_input('ie', set_value('ie'));  ?>
        </p>
    </div>
    <div id="pessoa_fisica" style="display:block">
    	<p>
    	<h3 id="contato_empresa" style="display:none">Pessoa responsável</h3>
        </p>
        <div class="row">
          <div class="col-md-6" style=" margin-top:2px;">
            <p>
            <?php echo form_label('Nome completo', 'nome_completo'); ?>
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
            </p>
          </div>  
        </div>    
        <p>
            <?php echo form_label('Sexo', 'sexo'); ?>
            <?php 
            $sexo = array('M'=>'Masculino', 'F'=>'Feminino');
            echo form_dropdown('sexo', $sexo, set_value('sexo'), 'class="form-control"'); 					
            ?>
        </p>
        <div class="row">
          <div class="col-md-6" style=" margin-top:2px;">
            <p>
            <?php echo form_label('Data de Nascimento', 'dtnasc'); ?>
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
        </div>    
        <div class="row">
          <div class="col-md-6" style=" margin-top:2px;">
            <p>
            <?php echo form_label('CPF', 'cpf'); ?>
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
        </div>   
        <p>
            <?php echo form_label('RG', 'rg'); ?>
            <?php echo form_input('rg', set_value('rg'));  ?>
        </p>
        <p>
            <?php echo form_label('PIS / PASEP', 'pis_pasep'); ?>
            <?php echo form_input('pis_pasep', set_value('pis_pasep')); ?>
        </p>        
        <p>
            <?php echo form_label('Profissão', 'profissao'); ?>
            <?php echo form_input('profissao', set_value('profissao'));  ?>
        </p>        
        <p>
            <?php echo form_label('Função na empresa', 'funcao_empresa'); ?>
            <?php echo form_input('funcao_empresa', set_value('funcao_empresa'));  ?>
        </p>        
    </div>

    <br class="quebra"/>
    
    <button type="button" onClick="$('#lnk2').click();"><img src="http://www.sicove.com.br/files/backend/images/icons/fugue/navigation.png" width="16" height="16"><span style="color:#fff!important; margin-left:5px; margin-top:15px;">Próximo</span></button>
</div>    
<div id="endereco" class="tab-pane fade">
    <p>
        <?php echo form_label('Tipo', 'tipo'); ?>
        <?php echo form_dropdown('tipo', $tipos, set_value('tipo')); ?>
    </p>
    <div class="row">
      <div class="col-md-6" style=" margin-top:2px;">
        <p>
        <?php echo form_label('CEP', 'cep'); ?>
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
    </div>    
    <p>
        <?php echo form_label('Endereço', 'logradouro'); ?>
		<?php
			$logradouro = array(
							'name'=>'logradouro',
							'id'=>'logradouro',
							'value'=>set_value('logradouro'));
        ?>
        <?php echo form_input($logradouro); ?>
    </p>
    <p>
        <?php echo form_label('N&uacute;mero', 'numero'); ?>
		<?php
			$numero = array(
						'name'=>'numero',
						'id'=>'numero',
						'value'=>set_value('numero'));
        ?>
        <?php echo form_input($numero); ?>
    </p>
    <p>
        <?php echo form_label('Complemento', 'complemento'); ?>
        <?php echo form_input('complemento', set_value('complemento')); ?>
    </p>
    <p>
        <?php echo form_label('Bairro', 'bairro'); ?>
		<?php
			$bairro = array(
						'name'=>'bairro',
						'id'=>'bairro',
						'value'=>set_value('bairro'));
        ?>
        <?php echo form_input($bairro); ?>
    </p>
    <p>
        <?php echo form_label('Cidade', 'cidade'); ?>
		<?php
			$cidade = array(
						'name'=>'cidade',
						'id'=>'cidade',
						'value'=>set_value('cidade'));
        ?>
        <?php echo form_input($cidade); ?>
    </p>
    <p>
        <?php echo form_label('Estado', 'estado'); ?>
		<?php
			$estado = array(
						'name'=>'estado',
						'id'=>'estado',
						'value'=>set_value('estado'));
        ?>
        <?php echo form_input($estado); ?>
    </p>
  <!--  <a href="#informacoes-contato" title="Settings">Próximo</a>-->
    
        <br class="quebra"/>
    
    <button type="button" onClick="$('#lnk3').click();"><img src="http://www.sicove.com.br/files/backend/images/icons/fugue/navigation.png" width="16" height="16"><span style="color:#fff!important; margin-left:5px; margin-top:15px;">Próximo</span></button>
</div>
<div id="informacoes-contato" class="tab-pane fade">
    <div class="row">
      <div class="col-md-6" style=" margin-top:2px;">
        <p>
        <?php echo form_label('Email', 'email'); ?>
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
        </p>
      </div>  
    </div>
    <div class="row">
      <div class="col-md-6" style=" margin-top:2px;">
        <p>
        <?php echo form_label('Telefone fixo', 'numtel'); ?>
        <?php
        $telefone = array(
					'name'=>'numtel',
					'id'=>'numtel',
					'placeholder'=>'(031) 3616-0917',
					'value'=>set_value('numtel'),
					'class'=>'form-control');
		?>
        <?php echo form_input($telefone); ?>
                              
        <?php echo form_label('Celular', 'numcel'); ?>
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
        <br class="quebra"/>
      <div class="help-block">Para regiões que utilizam cinco dígitos no prefixo, o primeiro dígito deve ser informado dentro dos parênteses, logo após o DDD. para as demais regiões, conforme o exemplo nos campos acima.</div>
    
    <button type="button" onClick="$('#lnk4').click();"><img src="http://www.sicove.com.br/files/backend/images/icons/fugue/navigation.png" width="16" height="16"><span style="color:#fff!important; margin-left:5px; margin-top:15px;">Próximo</span></button>
</div>
<div id="informacoes-conta" class="tab-pane fade">
    <div class="row">
      <div class="col-md-6 form-group" style=" margin-top:2px;">
        <p>
        <?php echo form_label('Login', 'login'); ?>
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
    </div>    
    <div class="row">
      <div class="col-md-6" style=" margin-top:2px;">
        <p>
        <?php echo form_label('Senha', 'senha'); ?>
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
    <div class="row">
      <div class="col-md-6" style=" margin-top:2px;">
        <p>
        <?php echo form_label('Digite a senha novamente', 'conf_senha'); ?>
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
    <div class="float-left" id="save-button"> 
			<button name="enviar" type="submit" id="enviar"><img src="http://www.sicove.com.br/files/backend/images/icons/fugue/tick-circle.png"> Salvar</button>            
		</div>
</div>
</div>
</div>
<?php echo form_close(); ?>
</div>
</div>
