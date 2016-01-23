<?php if ($associado->tipo == 'PJ'): ?>
<h3><?php echo $associado->Nome; ?></h3>
<p> Responsável:
<?php echo "&nbsp;".$associado->Contato; ?>
</p>
<?php else: ?>
<h3><?php echo $associado->Nome; ?></h3>
<?php endif; ?>