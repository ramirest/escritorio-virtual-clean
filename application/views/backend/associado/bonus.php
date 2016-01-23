<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/themes/blue/style.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_css');?>jquery-ui.css" rel="stylesheet" />
</head>
<body>
<?php
if($this->dx_auth->is_logged_in() && $this->dx_auth->is_role("admin") ):
    if(!$this->uri->segment(3)):
      echo '<strong>ATEN&Ccedil;&Atilde;O: ao clicar em "confirmar todos pagamentos" no extrato resumido, os pagamentos de todos os b&ocirc;nus para o usu&aacute;rio ser&atilde;o confirmados.</strong>';
      echo anchor('adm/bonus/detalhado', 'Detalhado', array('class'=>'ui-icon ui-icon-plus', 'title'=>'Detalhado')).'<br />';
      echo form_open('adm/bonus');
    else:
      echo anchor('adm/bonus', 'Resumido', array('class'=>'ui-icon ui-icon-minus', 'title'=>'Resumido')).'<br />';
      echo form_open('adm/bonus/detalhado');
    endif;
    $meses = array(
                'todos'=>'Todos',
                '01'=>'Janeiro','02'=>'Fevereiro',
                '03'=>'Mar&ccedil;o','04'=>'Abril',
                '05'=>'Maio','06'=>'Junho',
                '07'=>'Junho','08'=>'Agosto',
                '09'=>'Setembro','10'=>'Outubro',
                '11'=>'Novembro','12'=>'Dezembro'
            );
    $ano0 = date('Y') - 1;
    $ano1 = date('Y');
    $ano2 = date('Y') + 1;
    $anos = array($ano0=>$ano0, $ano1=>$ano1, $ano2=>$ano2);
    $smt = "onChange='form.submit();'";
    echo 'M&ecirc;s: '.form_dropdown('mes', $meses, $this->input->post('mes')?$this->input->post('mes'):date('m'), $smt);
    echo 'Ano: '.form_dropdown('ano', $anos, $this->input->post('ano')?$this->input->post('ano'):date('Y'), $smt);
    echo form_submit('submir', 'Pesquisar');
    echo form_close();
endif;
echo $bonus;
?>
</body>
</html>