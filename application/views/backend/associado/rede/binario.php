<div class="col-sm-3">
    <ul id="redeBinariaTab" class="nav nav-pills">
        <li class="active"><a href="#redeBinaria" data-toggle="tab" id="lnk1"><i class="fa fa-user fa-fw"></i>Rede Binária</a></li>
        <li><a href="#infoRede" data-toggle="tab" id="lnk2"><i class="fa fa-road fa-fw"></i>Informações</a></li>
        <li><a href="#configRede" data-toggle="tab" id="lnk3"><i class="fa fa-envelope-o fa-fw"></i>Configurações</a></li>
    </ul>
</div>
<div class="col-sm-9">
<div id="redeBinariaTabContent" class="tab-content">
<div id="redeBinaria" class="tab-pane fade in active">
    <div class="sub_arvore">
        <div class="but1_esq">
             <!--<div class="pontos_esquerda">
               
                <span></span><br />
                <span></span>
                   
            </div>--> 
        
            <div class="cadastro_esquerda">
                <span>CADASTROS</span><br />
                <span><?php echo $rede_esquerda; ?></span>
            </div>
        </div>
        <div class="buts">
            <?php echo $inicio; ?>
            <!--<a class="but_voltar">«VOLTAR</a>-->

            <br class="quebra" />
            
            <?php echo anchor('escritorio-virtual/empresarios/cadastro', 'Cadastrar', 'class="but"'); ?>
        </div>
        
        
        <div class="but1_dir">
            <!-- <div class="pontos_direita">
               
                <span></span><br />
                <span></span>
                   
            </div>--> 
        
            <div class="cadastro_direita">
                <span>CADASTROS</span><br />
                <span><?php echo $rede_direita; ?></span>
            </div>
        </div>

        <br class="quebra" />

        <div class="coluna_voce">
            <div style=" position:absolute; z-index:5000; margin-top:-20px; margin-left:500px;">            
                <div>
                    <div style=" float:left;"><img src="<?php echo $this->config->item('img');?>arvore/l1.jpg" /></div>
                    <div style=" float:left; margin-left:5px; font-size:11px; margin-top:2px;">ATIVA ESQUERDA</div>
                </div>
            
                <br class="quebra" /><br />
                
                <div>
                    <div style=" float:left;"><img src="<?php echo $this->config->item('img');?>arvore/l2.jpg" /></div>
                    <div style=" float:left; margin-left:5px; font-size:11px; margin-top:2px;">ATIVA DIREITA</div>
                </div>
                
                <br class="quebra" /><br />
                
                <div>
                    <div style=" float:left;"><img src="<?php echo $this->config->item('img');?>arvore/l3.jpg" /></div>
                    <div style=" float:left; margin-left:5px; font-size:11px; margin-top:2px;">INATIVO</div>
                </div>
                
                <br class="quebra" /><br />
                
                <div>
                    <div style=" float:left;"><img src="<?php echo $this->config->item('img');?>arvore/l4.jpg" /></div>
                    <div style=" float:left; margin-left:5px; font-size:11px; margin-top:2px;">PENDENTE</div>
                </div>
                
                <br class="quebra" /><br />
                
                <div>
                    <div style=" float:left;"><img src="<?php echo $this->config->item('img');?>arvore/l5.jpg" /></div>
                    <div style=" float:left; margin-left:5px; font-size:11px; margin-top:2px;">CLIENTE</div>
                </div>            
            </div>
        </div>
        <?php echo $html;?>                
                
    </div>
</div>
<div id="infoRede" class="tab-pane fade">
<?php echo $rede; ?>
</div>
<div id="configRede" class="tab-pane fade">
<?php echo form_open(); ?>
<div id="response_novos_cadastros"></div>
<ul class="checkable-list"> Direcionar os novos associados para a rede
<li><input type="radio" name="novos_cadastros" id="AUTO" value="AUTO"> <label for="AUTO">Rede menor</label></li>
<li><input type="radio" name="novos_cadastros" id="direita" value="D"> <label for="direita">Direita</label></li>
<li><input type="radio" name="novos_cadastros" id="esquerda" value="E"> <label for="esquerda">Esquerda</label></li>
</ul>
<?php echo form_close(); ?>
</div>
</div>

</div>