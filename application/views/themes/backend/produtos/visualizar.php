<?php

//BEGIN PRODUTOS
    $detalhes = "";

    $titulo = $produto->titulo;

    //CESTA
    switch($produto->type):
        case 'cestas':

            $peso = $produto->peso;
            $qtde_itens = $produto->qtde_itens;

            $corpo_detalhes = <<<HTML
                                    <ul id="myTab" class="nav nav-tabs">
                                        <li class="active"><a href="#composicao" data-toggle="tab">Composição</a></li>
                                        <li class="active"><a href="#detalhes" data-toggle="tab">Detalhes</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div class=" tab-pane fade active in" id="composicao">
                                            {$produto->composicao}
                                        </div>
                                        <div class=" tab-pane fade active in" id="detalhes">
                                            Peso: {$peso}
                                            Qtde de ítens: {$qtde_itens}
                                        </div>
                                    </div>
HTML;
            break;
        default:
            $corpo_detalhes = <<<HTML
                                    <ul id="myTab" class="nav nav-tabs">
                                        <li class="active"><a href="#detalhes" data-toggle="tab">Detalhes</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div class=" tab-pane fade active in" id="detalhes">
                                            {$produto->descricao}
                                        </div>
                                    </div>
HTML;



    endswitch;
    $detalhes = <<<HTML
                        <div class="row ec-row">
                            <div class="col-lg-12">
                                <div class="portlet portlet-default ec-portlet">
                                    <div class="portlet-heading" style=" background-color: #7db641">
                                        <div class="portlet-title">
                                            <h4>Descrição</h4>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="portlet-body">
                                        {$corpo_detalhes}
                                    </div>
                                </div>
                            </div>
                        </div>
HTML;




    $url_s3 = "//cdn-homologacao.s3.amazonaws.com/";
    $prod_pb = $produto->pbinario > 0?'<span>Pontos Binário:</span> <a href="#">'.$produto->pbinario.' pts</a><br>':'';
    $prod_pu = $produto->punilevel > 0?'<span>Pontos Unilevel:</span> <a href="#">'.$produto->punilevel.' pts</a><br>':'';
    $prod_pb_s = $produto->pbinario;
    $prod_pu_s = $produto->punilevel;
    $prod_est = $produto->qtde_estoque > 0?'disponível':'indisponível';
    $prod_preco = $this->cart->format_number_BRL($produto->preco);
    $prod_title2 = md5($produto->titulo);
    if($produto->qtde_estoque > 0):
        $prod_btn = '<input type="button" value="Comprar" class="button-e-c adicionar-carrinho" data-peso="'.$produto->peso.'" data-sku="'.$produto->sku.'" data-price="'.$prod_preco.'" data-pbin="'.$prod_pb_s.'" data-puni="'.$prod_pu_s.'" data-title="'.$prod_title2.'" data-title2="'.$titulo.'">';
    else:
        $prod_btn = '<a href="" type="button" class="button-e-c">Indisponível</a>';
    endif;
    $prod_uri = str_replace("s3://", $url_s3, $produto->uri);
    $prod_img_title = $produto->img_title;
    $prod_img_alt = $produto->img_alt;
    $prod_img_width = $produto->img_width;
    $prod_img_height = $produto->img_height;
    echo form_open();
    echo form_close();

    $html = <<<HTML
        <div id="content" class="ec-bg">
            <div class="product-info">
                <div class="row ec-row">
                    <div class="col-lg-6 col-md-6 image-container">
                        <div class="image">
                            <a href="#" title="{$titulo}" class="colorbox">
                                <img src="{$prod_uri}" title="{$prod_img_title}" alt="{$prod_img_alt}" id="image" data-zoom-image="{$prod_uri}" class="product-image-zoom" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h1>{$titulo}</h1>
                        <div class="description">
                            {$prod_pb}
                            {$prod_pu}
                            <span>Código do produto:</span> {$produto->sku}<br>
                            <span>Estoque:</span> {$prod_est}<br>
                            <span> Descrição:</span> <br>
                            {$produto->descricao}<br>
                        </div>
                        <div class="price">
                            R$ {$prod_preco}
                        </div>
                        <div class="product-extra">
                            <div class="quantity-adder">
                                Qtde:          <input class="form-control qty" type="text" name="quantity" id="qty" size="2" value="1">
                                <span class="add-up add-action">+</span>
                                <span class="add-down add-action">-</span>
                            </div>
                            <div class="product-action">
                                <span class="cart">{$prod_btn}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {$detalhes}

        </div>
HTML;
    echo $html;
//END PRODUTOS
