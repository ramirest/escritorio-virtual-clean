<div id="painel01">
<img src="<?php echo base_url().$this->config->item('mmn_css');?>/images/apresentacao.jpg">
</div>
<div id="painel03">
    <embed src="http://www.youtube.com/v/CgUm8DLdYc8" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="290" height="180"></embed>
</div>
<div id="painel02">
<?php
if($cadastros !== false):
foreach($cadastros->result() as $usu):
  echo $usu->nome_completo;
endforeach;
endif;
if($noticias !== false): ?>
<div id="noticias">
<ul>
<?php foreach($noticias->result() as $n): ?>
  <li style="list-style:none;">
    <span>
    <br /><br />
        <?php
        echo $this->data->mysql_to_human($n->data);
        ?>
    </span>
    <h4><?php echo $this->typography->format_characters($n->titulo); ?></h4>
    <p><?php echo $this->typography->format_characters($n->subtitulo); ?></p>
  </li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
</div>