<?php

$link = isset($imovel->iid)?("escritorio-virtual/imoveis/cadastro/".$imovel->iid):"";

echo form_open($link, array('onload'=>'validacaoFormulario();'));

echo form_error('descricao',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

echo form_error('tipo',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

echo form_error('cep',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

echo form_error('endereco',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

echo form_error('numero',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

echo form_error('complemento',
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

echo form_error('telefone',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

echo form_error('empresa',
    sprintf($this->config->item('err_msg_style'), 'row'),
    $this->config->item('msg_style_end'));

?>

<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
            <div class="row">
                <div class="form-group col-sm-8">
                    <?php echo form_label('Descrição', 'descricao'); ?>
                    <?php
                    $descricao = array(
                        'name'=>'descricao',
                        'id'=>'descricao',
                        'value'=>set_value('descricao', isset($imovel->descricao)?($imovel->descricao):''),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($descricao); ?>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo form_label('Tipo', 'tipo'); ?>
                    <?php echo form_dropdown('tipo', $tipos, set_value('tipo', isset($imovel->tiid)?($imovel->tiid):''), 'class="form-control"'); ?>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo form_label('CEP', 'cep'); ?>
                    <?php
                    $cep = array(
                        'name'=>'cep',
                        'id'=>'cep',
                        'data-conditional'=>'cep',
                        'value'=>set_value('cep', isset($imovel->cep)?($imovel->cep):''),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($cep); ?>
                    <a href="http://www.buscacep.correios.com.br/" target="_blank">N&atilde;o sei o cep</a>
                    <small id="msg" class="row"></small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <?php echo form_label('Endereço', 'logradouro'); ?>
                    <?php
                    $logradouro = array(
                        'name'=>'logradouro',
                        'id'=>'logradouro',
                        'value'=>set_value('logradouro', isset($imovel->logradouro)?($imovel->logradouro):''),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($logradouro); ?>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo form_label('N&uacute;mero', 'numero'); ?>
                    <?php
                    $numero = array(
                        'name'=>'numero',
                        'id'=>'numero',
                        'value'=>set_value('numero', isset($imovel->numero)?($imovel->numero):''),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($numero); ?>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo form_label('Complemento', 'complemento'); ?>
                    <?php
                    $complemento = array(
                        'name'=>'complemento',
                        'id'=>'complemento',
                        'value'=>set_value('complemento', isset($imovel->complemento)?($imovel->complemento):''),
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
                        'value'=>set_value('bairro', isset($imovel->bairro)?($imovel->bairro):''),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($bairro); ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <?php echo form_label('Cidade', 'cidade'); ?>
                    <?php
                    $cidade = array(
                        'name'=>'cidade',
                        'id'=>'cidade',
                        'value'=>set_value('cidade', isset($imovel->cidade)?($imovel->cidade):''),
                        'class'=>'form-control');
                    ?>
                    <?php echo form_input($cidade); ?>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo form_label('Estado', 'estado'); ?>
                    <?php
                    echo form_dropdown('estado', $estados, set_value('estado', isset($imovel->estado)?($imovel->estado):''), 'class="form-control" id="estado"');
                    ?>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo form_label('<i class="fa fa-phone fa-fw"></i> Telefone', 'telefone'); ?>
                    <?php
                    $telefone = array(
                        'name'=>'telefone',
                        'id'=>'telefone',
                        'placeholder'=>'(000) 0000-0000',
                        'value'=>set_value('telefone', isset($imovel->telefone)?($imovel->telefone):''),
                        'class'=>'form-control telefone');
                    ?>
                    <?php echo form_input($telefone); ?>
                </div>
                <div class="form-group col-sm-4">
                    <?php echo form_label('Empresa', 'empresa'); ?>
                    <?php
                    echo form_dropdown('empresa', $empresas, set_value('empresa', isset($imovel->eid)?$imovel->eid:''), 'class="form-control" id="empresa"');
                    ?>
                </div>
            </div>
            <br class="quebra"/>
            <div class="help-block">Para regiões que utilizam cinco dígitos no prefixo do telefone, o primeiro dígito deve ser informado dentro dos parênteses, logo após o DDD. para as demais regiões, conforme o exemplo nos campos acima.</div>

            <?php
            $btn_save = $this->config->item ( 'btn_save' );
            echo form_button ( $btn_save);
            echo form_close();
            ?>

            <button type="button" onClick="window.location.replace('/escritorio-virtual/imoveis/gerenciar');" class="btn btn-default">Cancelar</button>
        </div>
    </div>
</div>