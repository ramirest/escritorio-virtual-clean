<script type="application/javascript">
    list_url='';
    function goToList(message_text){

        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
            theme: 'block'
        }

        msg = Messenger().post({
            message: message_text,
            id: "Only-one-message",
            type: 'info',
            showCloseButton: true,
            actions: {
                não: {
                    action: function() {
                        msg.hide()
                    }
                },
                sim: {
                    action: function(){
                        window.location = list_url
                    }
                }
            }
        });
    }
</script>

<a href="<?php echo site_url('escritorio-virtual/imoveis/cadastro/'); ?>" title="Adicionar" class="btn btn-white btn-square btn-adicionar">
    <i class="fa fa-plus"></i>
    Adicionar
</a>

<div class="portlet portlet-default">
    <div class="portlet-body">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-info">
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <?php echo isset($msg)?$this->config->item('suc_msg_style').$msg.$this->config->item('msg_style_end'):''; ?>
            <!--		--><?php //echo form_open('escritorio-virtual/imoveis', array('id'=>'cria-imovel','name'=>'cria-imovel', 'class'=>'form')); ?>
            <?php
            if($this->session->flashdata('mensagem'))
                echo $this->session->flashdata('mensagem');
            ?>

            <table id="table-geral" class="table table-striped table-bordered table-hover table-green">
                <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Logradouro</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($imoveis !== FALSE):
                    $i = 0;
                    foreach ($imoveis->result() as $obj):
                        $i++;
                        if(($i % 2) == 0)
                            $classe = 'odd';
                        else
                            $classe = 'even';
                        ?>
                        <tr class="<?php echo $classe; ?> gradeX">
                            <td><?php echo $obj->descricao; ?></td>
                            <td><?php echo $obj->tipo; ?></td>
                            <td><?php echo $obj->logradouro; ?></td>
                            <td><?php echo $obj->bairro; ?></td>
                            <td><?php echo $obj->cidade; ?></td>
                            <td><?php echo $obj->estado; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown">Ação <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="<?php echo site_url('escritorio-virtual/imoveis/alterar/'.$obj->iid); ?>">Alterar</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('escritorio-virtual/imoveis/excluir/'.$obj->iid); ?>">Excluir</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>	