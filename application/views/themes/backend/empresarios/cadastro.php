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
        <li class="active"><a href="#dados-pessoais" data-toggle="tab" id="lnk1"><i class="fa fa-user fa-fw"></i>Informações básicas</a></li>
        <li><a href="#endereco" data-toggle="tab" id="lnk2"><i class="fa fa-road fa-fw"></i>Endereço</a></li>
        <li><a href="#informacoes-contato" data-toggle="tab" id="lnk3"><i class="fa fa-envelope-o fa-fw"></i>Informações para contato</a></li>
        <li><a href="#informacoes-conta" data-toggle="tab" id="lnk4"><i class="fa fa-lock fa-fw"></i>Informações da conta</a></li>
    </ul>
</div>
<div class="col-sm-9">
<div id="userSettingsContent" class="tab-content">
<div id="dados-pessoais" class="tab-pane fade in active">
    <div class="row">
        <div class="form-group col-sm-6">
            <?php echo form_label('Patrocinador'); ?>
            <?php if($patrocinador === FALSE):?>
                <?php
                $patrocinador_txt = array(
                    'name'=>'patrocinador_txt',
                    'id'=>'patrocinador_txt',
                    'data-required'=>'',
                    'data-conditional'=>'patrocinador',
                    'value'=>set_value('patrocinador_txt'),
                    'style'=> 'text-transform: lowercase;',
                    'class'=>'form-control');
                ?>
                <?php echo form_input($patrocinador_txt); ?>
                <small id="patrocinador-description"></small>
            <?php
            else:
                $ass = $patrocinador->row();
                echo "<br>".$ass->Nome."<br>";
                echo anchor('cadastro', 'Trocar patrocinador');
                echo form_hidden('patrocinador', $ass->aid);
                echo "<br><br>";
            endif;
            ?>
        </div>
        <div class="form-group col-sm-6">
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
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <?php echo form_label('Sexo', 'sexo'); ?>
            <?php
            $sexo = array('M'=>'Masculino', 'F'=>'Feminino');
            echo form_dropdown('sexo', $sexo, set_value('sexo'), 'class="form-control"');
            ?>
        </div>
        <div class="form-group col-sm-6">
            <?php echo form_label('Data de Nascimento', 'dtnasc'); ?>
            <?php
            $dtnasc = array(
                'name'=>'dtnasc',
                'id'=>'dtnasc',
                'placeholder'=>'01/01/2000',
                'data-required'=>'',
                'data-describedby'=>'data-description',
                'data-description'=>'data',
                'data-conditional'=>'data',
                'value'=>set_value('dtnasc'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($dtnasc);  ?>
            <small id="data-description"></small>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <?php echo form_label('CPF', 'cpf'); ?>
            <?php
            $cpf = array(
                'name'=>'cpf',
                'id'=>'cpf',
                'data-required'=>'',
                'data-conditional'=>'cpf',
                'value'=>set_value('cpf'),
                'class'=>'form-control');
            ?>
            <?php echo form_input($cpf);  ?>
            <small id="cpf-description"></small>
        </div>
        <div class="form-group col-sm-6">
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
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
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
        <div class="form-group col-sm-6">
            <?php echo form_label('Profissão', 'profissao'); ?>
            <?php
            echo form_dropdown('profissao', $profissoes, set_value('profissao'), 'class="form-control" id="profissao"');
            ?>
        </div>
    </div>
    <div class="col-sm-offset-10 col-sm-1">
        <button type="button" onClick="$('#lnk2').click();" class="btn btn-default">Próximo</button>
    </div>
</div>
<div id="endereco" class="tab-pane fade">
    <div class="form-group col-sm-4">
        <?php echo form_label('Tipo', 'tipo'); ?>
        <?php echo form_dropdown('tipo', $tipos, set_value('tipo'), 'class="form-control"'); ?>
    </div>
    <div class="form-group col-sm-4">
        <?php echo form_label('CEP', 'cep'); ?>
        <?php
        $cep = array(
            'name'=>'cep',
            'id'=>'cep',
            'data-conditional'=>'cep',
            'value'=>set_value('cep'),
            'class'=>'form-control');
        ?>
        <?php echo form_input($cep); ?>
        <a href="http://www.buscacep.correios.com.br/" target="_blank">N&atilde;o sei o cep</a>
        <small id="msg" class="row"></small>
    </div>
    <div class="form-group col-sm-4">
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
    <div class="form-group col-sm-6">
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
    <div class="form-group col-sm-6">
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
    <div class="form-group col-sm-4">
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
    <div class="form-group col-sm-4">
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
    <div class="form-group col-sm-4">
        <?php echo form_label('Estado', 'estado'); ?>
        <?php
        echo form_dropdown('estado', $estados, set_value('estado'), 'class="form-control" id="estado"');
        ?>
    </div>
    <!--  <a href="#informacoes-contato" title="Settings">Próximo</a>-->

    <br class="quebra"/>

    <div class="col-sm-offset-10 col-sm-1">
        <button type="button" onClick="$('#lnk3').click();" class="btn btn-default">Próximo</button>
    </div>
</div>
<div id="informacoes-contato" class="tab-pane fade">
    <div class="form-group col-sm-12">
        <?php echo form_label('<i class="fa fa-envelope-o fa-fw"></i> Email', 'email'); ?>
        <?php
        $email = array(
            'name'=>'email',
            'id'=>'email',
            'data-required'=>'',
            'data-conditional'=>'email',
            'value'=>set_value('email'),
            'class'=>'form-control');
        ?>
        <?php echo form_input($email); ?>
        <div id="email-description"></div>
    </div>
    <div class="form-group col-sm-4">
        <?php echo form_label('<i class="fa fa-phone fa-fw"></i> Telefone fixo', 'tel_fixo'); ?>
        <?php
        $tel_fixo = array(
            'name'=>'tel_fixo',
            'id'=>'tel_fixo',
            'placeholder'=>'(031) 3616-0917',
            'value'=>set_value('tel_fixo'),
            'class'=>'form-control');
        ?>
        <?php echo form_input($tel_fixo); ?>
    </div>
    <div class="form-group col-sm-4">
        <?php echo form_label('<i class="fa fa-mobile-phone fa-fw"></i> Celular', 'tel_celular'); ?>
        <?php
        $tel_celular = array(
            'name'=>'tel_celular',
            'id'=>'tel_celular',
            'placeholder'=>'(031) 3616-0917',
            'value'=>set_value('tel_celular'),
            'class'=>'form-control');
        ?>
        <?php echo form_input($tel_celular); ?>
    </div>
    <div class="form-group col-sm-4">
        <?php echo form_label('<i class="fa fa-phone fa-fw"></i> Comercial', 'tel_comercial'); ?>
        <?php
        $tel_comercial = array(
            'name'=>'tel_comercial',
            'id'=>'tel_comercial',
            'placeholder'=>'(031) 3616-0917',
            'value'=>set_value('tel_comercial'),
            'class'=>'form-control');
        ?>
        <?php echo form_input($tel_comercial); ?>
    </div>
    <div class="help-block col-sm-12">Para regiões que utilizam cinco dígitos no prefixo, o primeiro dígito deve ser informado dentro dos parênteses, logo após o DDD. para as demais regiões, conforme o exemplo nos campos acima.</div>
    <div class="col-sm-offset-10 col-sm-1">
        <button type="button" onClick="$('#lnk4').click();" class="btn btn-default">Próximo</button>
    </div>
</div>
<div id="informacoes-conta" class="tab-pane fade">
    <div class="form-group col-sm-12">
        <?php echo form_label('Login', 'login'); ?>
        <?php
        $login = array(
            'name'=>'login',
            'id'=>'login',
            'style'=>'text-transform:lowercase',
            'data-required'=>'',
            'data-conditional'=>'login',
            'value'=>set_value('login'),
            'class'=>'form-control');
        ?>
        <?php echo form_input($login); ?>
        <small id="login-description" class="row"></small>
    </div>
    <div class="form-group col-sm-6">
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
    <div class="form-group col-sm-6">
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

    <div class="col-sm-12" style="font-size:20px">
        Ao clicar em salvar, confirmo ter lido e concordado com todos os <a style="color:red;" href="<?php echo $this->config->item('url_contrato') ?>" target="_blank">termos do contrato.</a>
    </div>

    <div class="col-sm-offset-10 col-sm-1" id="save-button" style="margin-top: 11px;">
        <?php echo form_button($this->config->item('btn_save')); ?>
    </div>
</div>
</div>
</div>
<?php echo form_close(); ?>
