<script type="text/javascript">
    $(function(){
        $("#cpf").blur(function(){
            $.ajax({
                type:"POST",
                data:"cpf="+$(this).val(),
                url:"<?php echo site_url("auth/cpf_check"); ?>",
                success:function(msg){
                    $("#response_cpf").html(msg);
                    if($("#response_cpf div").hasClass("ui-state-error")){
                        $("#uname").val("");
                    }
                }
            })
        });
        $("#email").blur(function(){
            $.ajax({
                type:"POST",
                data:"email="+$(this).val(),
                url:"<?php echo site_url("auth/email_check"); ?>",
                success:function(msg){
                    $("#response_email").html(msg);
                    if($("#response_email div").hasClass("ui-state-error")){
                        $("#email").val("");
                    }
                }
            })
        });
        $("#patrocinador").blur(function(){
            $.ajax({
                type:"POST",
                data:"usuario="+$(this).val(),
                url:"<?php echo site_url("auth/patrocinador_check"); ?>",
                success:function(msg){
                    $("#response_patrocinador").html(msg);
                    if($("#response_patrocinador div").hasClass("ui-state-error")){
                        $("#patrocinador").val("");
                    }
                }
            })
        });
    })
</script>
<style>
    legend{
        font-family:verdana;
        font-size:1em;
        text-transform:uppercase;
    }
</style>
<div id="formulario">
<form action="<?php echo site_url("cadastro"); ?>" method="post" id="cadastro">
<fieldset>
<legend>Patrocinador</legend>
<table border="0" cellpadding="4" cellspacing="0">
    <tbody>
      <tr>
        <td>ID</td>
      </tr>
      <tr>
        <td>
          <?php echo form_input(array('name'=>'patrocinador', 'title'=>'Patrocinador', 'class'=>'obrigatorio', 'id'=>'patrocinador')); ?>
          <?php echo form_error('patrocinador', '<div class="ui-widget ui-state-error">', '<span class="ui-icon ui-icon-alert" style="float:left; margin-right:0.3em"></div>'); ?>
          <div id="response_patrocinador"></div>
          <cite>antes de efetivar o cadastro, confira o c&oacute;digo e o nome de seu patrocinador, pois uma vez cadastrado n&atilde;o ser&aacute; poss&iacute;vel trocar.</cite>
        </td>
      </tr>
    </tbody>
</table>
</fieldset>
<fieldset>
<legend>Plano de Assinatura</legend>
<table border="0" cellpadding="4" cellspacing="0">
<tbody>
<?php
if($planos !== FALSE):
?>
<tr>
    <td>
    <div id="planos-abas">
        <ul>
        <?php
        foreach($planos['operadora']->result() as $p):
          $operadoras['abas'][$p->oid] = $p->oid;
          echo "<li><a href='#operadora-$p->oid'>".$p->nome."</a></li>";
        endforeach;
        foreach($operadoras['abas'] as $v => $k):
        ?>
        <div id="operadora-<?php echo $v; ?>">
        <script type="text/javascript">
            $(function(){
              $.ajax({
                  type:"POST",
                  data:"operadora="+<?php echo $v; ?>,
                  url:"<?php echo site_url("usuarios/getPlanos"); ?>",
                  success:function(msg){
                      $("#operadora-<?php echo $v; ?>").html(msg);
                  }
              })
            })
        </script>
        </div>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
	</td>
</tr>
<?php endif; ?>
<tr>
    <td>Vencimento da taxa de manuten&ccedil;&atilde;o mensal*</td>
</tr>
<tr>
    <td>
      <?php
        echo form_radio('vencimento_taxa', 1)."Dia 5";
        echo form_radio('vencimento_taxa', 2)."Dia 10";
        echo form_radio('vencimento_taxa', 3)."Dia 15";
        echo form_radio('vencimento_taxa', 4)."Dia 20";
        echo form_radio('vencimento_taxa', 5)."Dia 25";
        echo form_radio('vencimento_taxa', 6)."Dia 30";
      ?>
    </td>
</tr>
<tr>
    <td><em>* O valor da taxa de manuten&ccedil;&atilde;o (R$ 10,00) ser&aacute; acrescido do valor do plano escolhido.</em></td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset>
<legend>Informa&ccedil;&otilde;es para Contato</legend>
<table>
<tbody>
<tr>
	<td>Telefone Celular (para recebimento dos cr&eacute;ditos)</td>
</tr>
<tr>
    <td><?php echo form_input(array('name'=>'numcel','id'=>'numcel')); ?></td>
</tr>
<tr>
    <td>Telefone para contato</td>
</tr>
<tr>
	<td>
    	<?php echo form_input(array('name'=>'numtel','id'=>'numtel')); ?>
    	<?php echo form_hidden('tp_telefone', "Residencial"); ?>
    </td>
</tr>
<tr>
	<td>Email</td>
</tr>
<tr>
	<td>
    	<?php echo form_input(array("name"=>"email","id"=>"email")); ?>
		<?php echo form_error('email', '<div class="erro">', '</div>'); ?>
        <div id="response_email"></div>
    </td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset>
<legend>Dados Pessoais</legend>
<table border="0" cellpadding="4" cellspacing="0">
<tbody>
<tr>
	<td>Nome Completo</td>
</tr>
<tr>
    <td>
    	<?php echo form_input(array('name'=>'nome_completo','id'=>'nome_completo',  'title'=>'Nome Completo', 'class'=>'obrigatorio'));  ?>
		<?php echo form_error('nome_completo', '<div class="ui-widget ui-state-error">', '<span class="ui-icon ui-icon-alert" style="float:left; margin-right:0.3em"></div>'); ?>
    </td>
</tr>
<tr>
	<td>CPF</td>
</tr>
<tr>
    <td>
    	<?php echo form_input(array('name'=>'cpf','id'=>'cpf', 'title'=>'CPF', 'class'=>'obrigatorio'));  ?>
		<?php echo form_error('cpf', '<div class="ui-widget ui-state-error">', '<span class="ui-icon ui-icon-alert" style="float:left; margin-right:0.3em"></div>'); ?>
        <div id="response_cpf"></div>
    </td>
</tr>
<tr>
	<td>RG</td>
</tr>
<tr>
    <td>
    	<?php echo form_input('rg');  ?>
		<?php echo form_error('rg', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td>Data de Nascimento</td>
</tr>
<tr>
    <td>
    	<?php echo form_input(array('name'=>'dtnasc','id'=>'dtnasc'));  ?>
		<?php echo form_error('dtnasc', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset>
<legend>Endere&ccedil;o</legend>
<table border="0" cellpadding="4" cellspacing="0">
<tbody>
<tr>
	<td>Tipo</td>
</tr>
<tr>
    <td>
    	<?php echo form_dropdown('tipo', $tipos); ?>
		<?php echo form_error('tipo', '<div class="erro">', '</div>'); ?>
	</td>
    <td><!-- <a href="#" id="add_email">Adicionar</a> --></td>
</tr>
<tr>
	<td>CEP</td>
</tr>
<tr>
    <td>
    	<?php echo form_input(array('name'=>'cep','id'=>'cep')); ?>
		<?php echo form_error('cep', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td>Logradouro</td>
</tr>
<tr>
    <td>
        <?php echo form_input('logradouro'); ?><br /><em>Avenida, Rua, Pra&ccedil;a, etc.</em>
		<?php echo form_error('logradouro', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td>N&uacute;mero</td>
</tr>
<tr>
    <td>
    	<?php echo form_input('numero'); ?>
		<?php echo form_error('numero', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td>Complemento</td>
</tr>
<tr>
    <td>
    	<?php echo form_input('complemento'); ?>
    </td>
</tr>
<tr>
	<td>Bairro</td>
</tr>
<tr>
    <td>
    	<?php echo form_input('bairro'); ?>
		<?php echo form_error('bairro', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td>Cidade</td>
</tr>
<tr>
    <td>
    	<?php echo form_input('cidade'); ?>
		<?php echo form_error('cidade', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td>Estado</td>
</tr>
<tr>
    <td>
    	<?php echo form_dropdown('estado', $estados); ?>
		<?php echo form_error('estado', '<div class="erro">', '</div>'); ?>
	</td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset>
<legend>Controle de Acesso</legend>
<table border="0" cellpadding="4" cellspacing="0">
<tbody>
<tr>
	<td>Senha</td>
</tr>
<tr>
    <td>
    	<?php echo form_password(array('name'=>'senha', 'title'=>'Senha', 'class'=>'obrigatorio')); ?>
		<?php echo form_error('senha', '<div class="ui-widget ui-state-error">', '<span class="ui-icon ui-icon-alert" style="float:left; margin-right:0.3em"></div>'); ?>
    </td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset>
    <legend>Informa&ccedil;&otilde;es para recebimento dos b&ocirc;nus</legend>
<table border="0" cellpadding="4" cellspacing="0">
<tbody>
<tr>
	<td>Titular da Conta</td>
</tr>
<tr>
    <td><?php echo form_input(array('name'=>'titular', 'id'=>'titular')); ?></td>
</tr>
<tr>
	<td>Banco</td>
</tr>
<tr>
    <td>
    <?php
    echo form_dropdown('banco',$bancos);
    ?>
    </td>
</tr>
<tr>
	<td>Tipo de Conta</td>
</tr>
<tr>
    <td><?php echo form_dropdown('tpconta', $tpconta); ?></td>
</tr>
<tr>
	<td>Ag&ecirc;ncia</td>
</tr>
<tr>
    <td><?php echo form_input('agencia'); ?></td>
</tr>
<tr>
	<td>Conta</td>
</tr>
<tr>
    <td><?php echo form_input('conta'); ?></td>
</tr>
<tr>
	<td>Opera&ccedil;&atilde;o</td>
</tr>
<tr>
    <td><?php echo form_input('op'); ?></td>
</tr>
</tbody>
</table>
</fieldset>
<fieldset>
<table>
<tr>
<td>
Declaro que li e aceitei os <a href="contrato" target="_blank">termos do contrato</a>
<input type="checkbox" name="aceite" id="aceite"><br /><br />
<input name="cadastrar" id="cadastrar" value="Cadastrar" type="submit" class="ui-state-default ui-state-disabled" disabled>
<input name="limpar" value="Limpar Formul&aacute;rio" type="reset" class="ui-state-default">
</td>
</tr>
</table>
</fieldset>
</form>
</div>