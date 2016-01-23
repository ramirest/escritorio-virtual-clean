<div class="row">
<?php
echo form_open("escritorio-virtual/empresarios/cadastro", $this->config->item('form_style'));

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
<div class="col-sm-3">
    <ul id="userSettings" class="nav nav-pills nav-stacked">
        <li class="active"><a href="#dados-pessoais" data-toggle="tab" id="lnk1"><i class="fa fa-user fa-fw"></i>Informações Básicas</a></li>
        <li><a href="#endereco" data-toggle="tab" id="lnk2"><i class="fa fa-road fa-fw"></i>Endereço</a></li>
        <li><a href="#informacoes-contato" data-toggle="tab" id="lnk3"><i class="fa fa-envelope-o fa-fw"></i>Informações para contato</a></li>
        <li><a href="#informacoes-conta" data-toggle="tab" id="lnk4"><i class="fa fa-lock fa-fw"></i>Informações da conta</a></li>
    </ul>
</div>
<div class="col-sm-9">
<div id="userSettingsContent" class="tab-content">
<div id="dados-pessoais" class="tab-pane fade in active">
    <div class="form-group">
	<?php if($this->session->userdata('patrocinador') === FALSE):?>
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
	<?php
    else:
        $ass = $this->session->userdata('patrocinador');
        echo $ass->Nome."<br>";
		echo anchor('escritorio-virtual/empresarios/cadastro/0', 'Trocar patrocinador');
        echo form_hidden('patrocinador', $ass->aid);
		echo "<br><br>";
    endif;
    ?>
    </div>  
    <div class="form-group">
        <?php echo form_label('Em qual rede deseja posicionar o novo empresário?', 'rede_alocacao'); ?>
        <?php 
        $redes = array('AUTO'=>'Rede Menor', 'D'=>'Direita', 'E'=>'Esquerda');
        echo form_dropdown('rede_alocacao', $redes, set_value('rede_alocacao'), 'class="form-control"'); 					
        ?>
    </div>
    <div class="form-group">
        <?php echo form_label('Tipo de cadastro', 'tp_cadastro'); ?>
		<?php 
        $tpcadastro = array('PF'=>'Pessoa Física', 'PJ'=>'Pessoa Jurídica');
        echo form_dropdown('tp_cadastro', $tpcadastro, set_value('tp_cadastro'), 'class="form-control"'); 	
        ?>
    </div>
    <div id="pessoa_juridica" style="display:none">
        <div class="form-group">
            <?php echo form_label('Nome fantasia', 'nome_fantasia'); ?>
            <?php echo form_input('nome_fantasia', set_value('nome_fantasia'));  ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Razão social', 'razao_social'); ?>
            <?php echo form_input('razao_social', set_value('razao_social'));  ?>
        </div>
        <div class="form-group">
			<?php
            $cnpj = array(
                'name'=>'cnpj',
                'id'=>'cnpj',
                'value'=>set_value('cnpj'),
                'class'=>'form-control');
            ?>
            <?php echo form_label('CNPJ', 'cnpj'); ?>
            <?php echo form_input($cnpj);  ?>
        </div>
        <div class="form-group">
            <?php echo form_label('IE', 'ie'); ?>
            <?php echo form_input('ie', set_value('ie'));  ?>
        </div>
    </div>
    <div id="pessoa_fisica" style="display:block">
    	<div class="form-group">
    	<h3 id="contato_empresa" style="display:none">Pessoa responsável</h3>
        </div>
            <div class="form-group">
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
            </div>
        <div class="form-group">
            <?php echo form_label('Sexo', 'sexo'); ?>
            <?php 
            $sexo = array('M'=>'Masculino', 'F'=>'Feminino');
            echo form_dropdown('sexo', $sexo, set_value('sexo'), 'class="form-control"'); 					
            ?>
        </div>
            <div class="form-group">
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
            </div>
            <div class="form-inline">
            <div class="form-group">
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
           </div>
        <div class="form-group">
            <?php echo form_label('RG', 'rg'); ?>
			<?php
            $rg = array(
                'name'=>'rg',
                'id'=>'rg',
                'value'=>set_value('rg'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($rg);  ?>
        </div>
        <div class="form-group">
            <?php echo form_label('PIS / PASEP', 'pis_pasep'); ?>
			<?php
            $pis_pasep = array(
                'name'=>'pis_pasep',
                'id'=>'pis_pasep',
                'value'=>set_value('pis_pasep'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($pis_pasep); ?>
        </div>
        </div>        
        <div class="form-group">
            <?php echo form_label('Profissão', 'profissao'); ?>
			<?php
            $profissao = array(
                'name'=>'profissao',
                'id'=>'profissao',
                'value'=>set_value('profissao'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($profissao);  ?>
        </div>        
        <div class="form-group">
            <?php echo form_label('Função na empresa', 'funcao_empresa'); ?>
			<?php
            $funcao_empresa = array(
                'name'=>'funcao_empresa',
                'id'=>'funcao_empresa',
                'value'=>set_value('funcao_empresa'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($funcao_empresa);  ?>
        </div>        
    </div>

    <br class="quebra"/>
    
    <div class="col-sm-offset-10 col-sm-10">
    <button type="button" onClick="$('#lnk2').click();" class="btn btn-default">Próximo</button>
    </div>
</div>    
<div id="endereco" class="tab-pane fade">
    <div class="form-group">
        <?php echo form_label('Tipo', 'tipo'); ?>
        <?php echo form_dropdown('tipo', $tipos, set_value('tipo')); ?>
    </div>
        <div class="form-group">
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
        </div>
    <div class="form-group">
        <?php echo form_label('Endereço', 'logradouro'); ?>
		<?php
			$logradouro = array(
							'name'=>'logradouro',
							'id'=>'logradouro',
							'value'=>set_value('logradouro'),
                    		'class'=>'form-control');
        ?>
        <?php echo form_input($logradouro); ?>
    </div>
    <div class="form-inline">
        <div class="form-group">
            <?php echo form_label('N&uacute;mero', 'numero'); ?>
            <?php
                $numero = array(
                            'name'=>'numero',
                            'id'=>'numero',
                            'value'=>set_value('numero'),
                    		'class'=>'form-control');
            ?>
            <?php echo form_input($numero); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Complemento', 'complemento'); ?>
            <?php
            	$complemento = array(
									'name'=>'complemento',
									'id'=>'complemento',
									'value'=>set_value('complemento'),
                    				'class'=>'form-control');
			?>
            <?php echo form_input($complemento); ?>
        </div>
    </div>
    <div class="form-inline">
        <div class="form-group">
        <?php echo form_label('Bairro', 'bairro'); ?>
		<?php
			$bairro = array(
						'name'=>'bairro',
						'id'=>'bairro',
						'value'=>set_value('bairro'),
                    	'class'=>'form-control');
        ?>
        <?php echo form_input($bairro); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Cidade', 'cidade'); ?>
            <?php
                $cidade = array(
                            'name'=>'cidade',
                            'id'=>'cidade',
                            'value'=>set_value('cidade'),
                    		'class'=>'form-control');
            ?>
            <?php echo form_input($cidade); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Estado', 'estado'); ?>
            <?php
                $estado = array(
                            'name'=>'estado',
                            'id'=>'estado',
                            'value'=>set_value('estado'),
                    		'class'=>'form-control');
            ?>
            <?php echo form_input($estado); ?>
        </div>
    </div>
  <!--  <a href="#informacoes-contato" title="Settings">Próximo</a>-->
    
        <br class="quebra"/>
    
    <div class="col-sm-offset-10 col-sm-10">
    <button type="button" onClick="$('#lnk3').click();" class="btn btn-default">Próximo</button>
    </div>
</div>
<div id="informacoes-contato" class="tab-pane fade">
        <div class="form-group">
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
        </div>
        <div class="form-inline">
        <div class="form-group">
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
        </div>
        <div class="form-group">                              
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
        </div>
        </div>
        <br class="quebra"/>
      <div class="help-block">Para regiões que utilizam cinco dígitos no prefixo, o primeiro dígito deve ser informado dentro dos parênteses, logo após o DDD. para as demais regiões, conforme o exemplo nos campos acima.</div>
    <div class="col-sm-offset-10 col-sm-10">
    <button type="button" onClick="$('#lnk4').click();" class="btn btn-default">Próximo</button>
    </div>
</div>
<div id="informacoes-conta" class="tab-pane fade">
        <div class="form-group">
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
        </div>
        <div class="form-inline">        
            <div class="form-group">
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
            </div>
            <div class="form-group">
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
            </div>
        </div>
    <div class="col-sm-offset-10 col-sm-10" id="save-button"> 
			<button name="enviar" type="submit" id="enviar" class="btn btn-default">Salvar</button>            
		</div>
</div>
</div>
</div>
<?php echo form_close(); ?>
</div>
</div>
