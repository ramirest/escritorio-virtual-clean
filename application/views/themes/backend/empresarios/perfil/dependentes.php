<div class="col-sm-9">
    <div class="portlet portlet-default">
    <div class="portlet-body">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-info">
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-2">
                <ul id="myStacked" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#dependenteList" data-toggle="tab">Listar</a>
                    </li>
                    <li><a href="#dependenteAdd" data-toggle="tab">Adicionar</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-10">
                <div id="myStackedContent" class="tab-content">
                    <?php echo form_open(site_url("escritorio-virtual/empresarios/salvar/dependentes/$associado"), $this->config->item('form_style')); ?>
                    <div class="tab-pane fade" id="dependenteAdd">
                        <?php
                        $options_s = array(
                            0=>'Nenhum',
                            'M'=>'Masculino',
                            'F'=>'Feminino');
                        ?>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <?php echo form_hidden('aid', $associado); ?>
                                <?php echo form_label('Tipo <i class="text-red">*</i>', 'tipo_dependente_label'); ?>
                                <?php echo form_dropdown('tdid', $tp_dependente, '', 'class="form-control" data-required'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <?php echo form_label('Nome <i class="text-red">*</i>', 'nome_dependente_label'); ?>
                                <?php echo form_input('nome_dependente', '', 'class="form-control" data-required') ?>
                            </div>
                            <div class="form-group col-sm-3">
                                <?php echo form_label('Sexo <i class="text-red">*</i>', 'sexo_label'); ?>
                                <?php echo form_dropdown('sexo', $options_s, '', 'class="form-control" data-required'); ?>
                            </div>
                            <div class="form-group col-sm-3">
                                <?php echo form_label('Data de nascimento <i class="text-red">*</i>', 'dtnasc_label'); ?>
                                <?php echo form_input('dtnasc', '', 'class="form-control" data-required') ?>
                            </div>
                            <div class="form-group col-sm-3">
                                <?php echo form_label('CPF', 'cpf_label'); ?>
                                <?php echo form_input('cpf', '', 'class="form-control"') ?>
                            </div>
                        </div>
                        <?php echo form_button($this->config->item('btn_add')); ?>
                        <i class="label red">Campos com asterisco (*) são de preenchimento obrigatório</i>
                    </div>
                    <div class="tab-pane fade in active" id="dependenteList">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nome</th>
                                        <th>Sexo</th>
                                        <th>Data de nascimento</th>
                                        <th>CPF</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"><?php echo form_button($this->config->item('btn_delete')); ?></td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // Mostra erros de validação
                                    echo validation_errors();
                                    $i = 0;
                                    if($dependentes !== FALSE):
                                        foreach ($dependentes as $dependente):
                                    ?>
                                            <tr>
                                                <td><?php echo form_checkbox('checkbox_'.$dependente->adid, $dependente->adid); ?></td>
                                                <td><?php echo $dependente->nm_dependente; ?></td>
                                                <td><?php echo $dependente->sexo_dependente; ?></td>
                                                <td><?php echo $dependente->dtnasc_dependente; ?></td>
                                                <td><?php echo $dependente->cpf_dependente; ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-sm-3">
    <div class="portlet portlet-default">
        <div id="defaultPortlet" class="panel-collapse collapse in">
            <div class="portlet-body">
                <?php echo $submenu; ?>
            </div>
        </div>
    </div>
</div>