<div class="col-sm-8">
<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
       
			<?php echo form_open("escritorio-virtual/empresarios/salvar/info/$associado->aid", $this->config->item('form_style')); ?>
			<?php echo form_hidden('aid', set_value('aid', $associado->aid)); ?>
			<div class="form-group">
		        <?php echo form_label('Patrocinador:'); ?>
			    <?php
			        echo $associado->nm_patrocinador."<br>";
					echo "<br><br>";
			    ?>
		    </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <?php echo form_label('Profissão', 'profissao'); ?>
                    <?php
                    echo form_dropdown('profissao', $profissoes, set_value('profissao', $associado->profissao), 'class="form-control" id="profissao"');
                    ?>
                </div>
            </div>
		    <div class="form-group">
		            <?php echo form_label('Nome completo', 'nome_completo'); ?>
				<?php 
		            	echo form_hidden('tp_cadastro', set_value('tp_cadastro', 'PF'));
		            ?>                  
		            <?php
		            $nome_completo = array(
		                'name'=>'nome_completo',
		                'id'=>'nome_completo',
		                'data-required'=>'',
		                'data-describedby'=>'nome-description',
		                'data-description'=>'nome',
		                'value'=>set_value('nome_completo', $associado->Nome),
		                'class'=>'form-control');
		            ?>
		            <?php echo form_input($nome_completo);  ?>
		            <small id="nome-description"></small>
			</div>      
				<div class="row">
			       <div class="form-group col-sm-6">
			            <?php echo form_label('Sexo', 'sexo'); ?>
			            <?php 
			            $sexo = array('M'=>'Masculino', 'F'=>'Feminino');
			            echo form_dropdown('sexo', $sexo, set_value('sexo', $associado->sexo), 'class="form-control"'); 					
			            ?>
			        </div>
			        <div id="sandbox-container" onload="LoadDatepicker()">
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
                                'value'=>set_value('dtnasc', $this->data->mysql_to_human($associado->dtnasc)),
                                'class'=>'form-control');
                            ?>
                            <?php echo form_input($dtnasc);  ?>
                            <small id="data-description"></small>
                        </div>
			        </div>
		        </div>
		        <div class="row">
		            <div class="form-group col-sm-4">
		            <?php echo form_label('CPF', 'cpf'); ?>
					<?php
		            $cpf = array(
		                'name'=>'cpf',
		                'id'=>'cpf',
		                'data-required'=>'',
		                'data-describedby'=>'cpf-description',
		                'data-description'=>'cpf',
		                'value'=>set_value('cpf', $associado->cpf),
		                'class'=>'form-control');
		            ?>
		            <?php echo form_input($cpf);  ?>
		            <small id="cpf-description"></small>
		           </div>
		        	<div class="form-group col-sm-4">
		            <?php echo form_label('RG', 'rg'); ?>
					<?php
		            $rg = array(
		                'name'=>'rg',
		                'id'=>'rg',
		                'value'=>set_value('rg', $associado->rg),
		                'class'=>'form-control');
		            ?>
		            <?php echo form_input($rg);  ?>
		        	</div>
		        	<div class="form-group col-sm-4">
		            <?php echo form_label('PIS / PASEP', 'pis_pasep'); ?>
					<?php
		            $pis_pasep = array(
		                'name'=>'pis_pasep',
		                'id'=>'pis_pasep',
		                'value'=>set_value('pis_pasep', $associado->pis_pasep),
		                'class'=>'form-control');
		            ?>
		            <?php echo form_input($pis_pasep); ?>
		        	</div>
		        </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <?php echo form_label('Telefone fixo'); ?>
                        <?php
                        $tel_fixo = array(
                            'name'=>'tel_fixo',
                            'id'=>'tel_fixo',
                            'placeholder'=>'(031) 3616-0917',
                            'value'=>set_value('tel_fixo', $associado->tel_fixo),
                            'class'=>'form-control');
                        ?>
                        <?php echo form_input($tel_fixo); ?>
                    </div>

                    <div class="form-group col-sm-4">
                        <?php echo form_label('Telefone celular'); ?>
                        <?php
                        $tel_celular = array(
                            'name'=>'tel_celular',
                            'id'=>'tel_celular',
                            'placeholder'=>'(031) 3616-0917',
                            'value'=>set_value('tel_celular', $associado->tel_celular),
                            'class'=>'form-control');
                        ?>
                        <?php echo form_input($tel_celular); ?>
                    </div>

                    <div class="form-group col-sm-4">
                        <?php echo form_label('Telefone comercial'); ?>
                        <?php
                        $tel_comercial = array(
                            'name'=>'tel_comercial',
                            'id'=>'tel_comercial',
                            'placeholder'=>'(031) 3616-0917',
                            'value'=>set_value('tel_comercial', $associado->tel_comercial),
                            'class'=>'form-control');
                        ?>
                        <?php echo form_input($tel_comercial); ?>
                    </div>
                </div>

                <?php echo form_button($this->config->item('btn_save')); ?>
                <?php echo form_close(); ?>
		</div>
	</div>
</div>
</div>
<div class="col-sm-4">
<div class="portlet portlet-default">
    <div id="defaultPortlet" class="panel-collapse collapse in">
        <div class="portlet-body">
        <?php echo $submenu; ?>
		</div>
	</div>
</div>		
</div>		
