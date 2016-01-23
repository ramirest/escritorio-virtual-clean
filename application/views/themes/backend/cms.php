<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <img class="img-responsive" src="<?php echo $conteudo->url_imagem; ?>">
    </div>
    <div class="col-lg-6 col-lg-offset-3">
        <h3><?php echo $conteudo->titulo; ?></h3>
        <p class="lead"><?php echo $conteudo->corpo; ?></p>
        <ul class="list-unstyled">
            <li>
                <a class="btn btn-default" href="<?php echo site_url('escritorio-virtual/dashboard'); ?>">Voltar</a>
            </li>
        </ul>
    </div>
    <!-- /.col-lg-6 -->
</div>
