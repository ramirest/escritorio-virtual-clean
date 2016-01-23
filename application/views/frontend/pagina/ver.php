<?php echo anchor(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:site_url(), 'Voltar'); ?>
<?php foreach($dados->result() as $pagina): ?>
<h2><?php echo $pagina->titulo; ?></h2>
<?php echo $pagina->corpo; ?>
<?php endforeach; ?>