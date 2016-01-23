<?php

if (uri_string() == "escritorio-virtual/estoque") {

    echo form_open("escritorio-virtual/estoque", $this->config->item('form_style'));
    echo "<fieldset>";
//echo "<legend> Filtro </legend>";
    echo "<div style='float: left; margin-right: 25px;'>";
    echo anchor('escritorio-virtual/estoque/entradaestoque', '<i class="fa fa-plus-square"></i> Entrada no Estoque');
    echo "</div>";
    echo "<div>";
    echo anchor('escritorio-virtual/estoque/saidaestoque', '<i class="fa fa-minus-square"></i> Saída no Estoque');
    echo "</div>";
    echo "</br>";
    echo "<label> Tipo de Movimentação </label>";
    echo "</br>";
    echo "<select id='tp_mov' name='tp_mov' onchange='this.form.submit()'>";
    if($_POST['tp_mov']=='S' || !$_POST) {
        echo "<option value = 'S' selected> Saída </option>";
        echo "<option value = 'E'> Entrada </option>";
    }
    elseif($_POST['tp_mov']=='E') {
        echo "<option value = 'S'> Saída </option>";
        echo "<option value = 'E' selected> Entrada </option>";
    }
    echo "</select>";
    echo "</br></br>";
    echo "<label> Data da Movimentação </br> <input type='text' name='DataMovEstoque' id='DataMovEstoque' value='DataMovEstoque'   style='padding: 5px;' placeholder='dd/mm/aaaa' />  </label>";
    echo "</br>";
    /*
    echo "<label> Status </br>  </label>";
    echo "</br>";



    $sqlStatus = mysql_query(" select * from status_transacao order by descricao ");
    echo "<select id='status_transacao' name='status_transacao'>";
    echo "<option value=''> Todos </option>";
    while($lin = mysql_fetch_array($sqlStatus))
    {
        if($_POST[status_transacao]==$lin[stid]){ $marcado = "selected=selected";  } else { $marcado = ""; }
        echo "<option value='".$lin['stid']."' $marcado  >".$lin[descricao]."</option>";
    }
    echo "</select>";
    echo "</br>";
    */
    echo "</br>";
    echo "<input type='submit' value='Buscar' />";
    echo "</br>";
    echo "</br>";
    echo "<fieldset>";
    echo "</form>";

    echo "<table id='table-geral' class='table table-striped table-bordered table-hover table-green''>";

    echo "<tr>";
    echo "<thead>";
    echo  "<th> Tipo  </th>";
    echo "<th> Descrição  </th>";
    echo "<th> Data  </th>";
    echo "<th> Quantidade </th>";
    echo " <th> Destinatário </th>";
    echo "</thead>";
    echo "</tr>";

    foreach($produtos->result() as $produto):
        echo "<tr>";
        switch ($produto->tipo) {
            case "S":
                echo "<th> Saída </th>";
                break;
            case "E":
                echo "<th> Entrada </th>";

                break;
        }
        echo "<th> $produto->descricao </th>";
        echo "<th> $produto->data </th>";
        echo "<th> $produto->qtde </th>";
        echo "<th> $produto->nome_completo </th>";
        echo "</tr>";
    endforeach;

    echo "</table>";

}

elseif (uri_string() == "escritorio-virtual/estoque/saidaestoque") {

    if(!$_POST) {

        echo form_open("escritorio-virtual/estoque/saidaestoque", $this->config->item('form_style'));
        echo "<div id='datamovimentacao-bloco'>";
        echo "<label>Data da Movimentação</label></br>";
        ?>
        <div class="form-group">
            <div id="datepicker8" class="input-group date data-movimentacao">
                <input type="text" value="<?php echo date('d/m/Y');?>" name="dataMov" id="dataMov" class="form-control" placeholder="<?php echo date('d/m/Y');?>">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span> </span>
            </div>
        </div>
        </div>
        <div id="destinatario-bloco">
            <label>Destinatário</label></br>
            <!--<input type="text" class="form-control" style="text-transform: lowercase;" data-conditional="destinatario" data-required="" id="destinatario_txt" value="" name="destinatario_txt">-->
            <select required="" class="form-control" multiple="" name="destinatario_txt" id="destinatario_txt">
                <?php
                foreach($allassoc->result() as $allassoc):
                    echo "<option value='$allassoc->username'>$allassoc->nome_completo</option>";
                endforeach;
                ?>
            </select>
        </div>
        </br>
        <div id="produto-bloco">
            <div class="form-group">
                <label>Produto</label>
                <select class="form-control produto-select" name="produto-select">
                    <?php
                    foreach($prod->result() as $prod):
                        echo "<option value='$prod->rid'>$prod->descricao - $prod->descri</option>";
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div id="quantidade-bloco">
            <div class="form-group">
                <label>Quantidade</label>
                <input type="text" class="form-control" style="text-transform: lowercase;" data-conditional="quantidade" data-required="" id="quantidade_txt" value="1" name="quantidade_txt">
            </div>
        </div></br>
        <button value="save" class="btn btn-default" id="save" type="submit" name="save"><i class="fa fa-save"></i>Salvar</button>

        <?php
        echo "</form>";

    }
    else {

        //echo $assoc;
        echo "Saída no estoque efetuada com sucesso <br /><br />";
        echo anchor('escritorio-virtual/estoque/saidaestoque', '<i class="fa fa-minus-square"></i> Saída no Estoque');

    }
}

elseif (uri_string() == "escritorio-virtual/estoque/entradaestoque") {

    if(!$_POST) {

        echo form_open("escritorio-virtual/estoque/entradaestoque", $this->config->item('form_style'));
        echo "<div id='datamovimentacao-bloco'>";
        echo "<label>Data da Movimentação</label></br>";
        ?>
        <div class="form-group">
            <div id="datepicker8" class="input-group date data-movimentacao">
                <input type="text" value="<?php echo date('d/m/Y');?>" name="dataMov" id="dataMov" class="form-control" placeholder="<?php echo date('d/m/Y');?>">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span> </span>
            </div>
        </div>
        </div>
        <div id="fornecedor-bloco">
            <label>Fornecedor</label></br>
            <!--<input type="text" class="form-control" style="text-transform: lowercase;" data-conditional="destinatario" data-required="" id="destinatario_txt" value="" name="destinatario_txt">-->
            <select required="" class="form-control" multiple="" name="fornecedor_txt" id="fornecedor_txt">
                <?php
                foreach($allparc->result() as $allparc):
                    echo "<option value='$allparc->pid'>$allparc->fantasia</option>";
                endforeach;
                ?>
            </select>
        </div>
        </br>
        <div id="produto-bloco">
            <div class="form-group">
                <label>Produto</label>
                <select class="form-control produto-select" name="produto-select">
                    <?php
                    foreach($prod->result() as $prod):
                        echo "<option value='$prod->rid'>$prod->descricao - $prod->descri</option>";
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div id="quantidade-bloco">
            <div class="form-group">
                <label>Quantidade</label>
                <input type="text" class="form-control" style="text-transform: lowercase;" data-conditional="quantidade" data-required="" id="quantidade_txt" value="1" name="quantidade_txt">
            </div>
        </div></br>
        <button value="save" class="btn btn-default" id="save" type="submit" name="save"><i class="fa fa-save"></i>Salvar</button>
        <?php
        echo "</form>";
    }
    else {

        echo "Entrada no estoque efetuada com sucesso <br /><br />";
        echo anchor('escritorio-virtual/estoque/entradaestoque', '<i class="fa fa-minus-square"></i> Entrada no Estoque');

    }
}

?>