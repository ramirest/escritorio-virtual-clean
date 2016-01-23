<?php
if(isset($msg))
    echo $msg;

?>
<h3>Recurso desabilitado no escritório virtual, por favor utilize o sistema de pagamento para efetuar baixas.</h3>
<?php echo form_open_multipart('escritorio-virtual/empresarios/retorno_bancario');?>
<table width="50%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="34%" height="79">Selecione o arquivo:</td>
        <td width="66%"><label for="userfile"></label>
            <input type="file" name="userfile"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" disabled="disabled" name="btnImportar" id="btnImportar" value="Importar"></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">

        </td>
    </tr>
</table>
</form>
