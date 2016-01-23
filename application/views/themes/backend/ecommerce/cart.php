<?php echo form_open('escritorio-virtual/ecommerce/checkout'); ?>

<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

    <tr>
        <th>QTDE</th>
        <th>Descrição do ítem</th>
        <th style="text-align:right">Preço</th>
        <th style="text-align:right">Sub-Total</th>
    </tr>
    <?php
        $i = 1;
        $peso_total = 0;
        foreach ($this->cart->contents() as $items): ?>

        <tr>
            <td>
                <?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5', 'data-price' =>$items['price'], 'data-peso' =>$items['options']['peso'], 'class'=>'qty')); ?>
                <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
            </td>
            <td>
                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

                    <p>
                        <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

                            <?php
                            switch($option_name):
                                case 'title':
                                    $option_name = '';
                                    break;
                                case 'pbin':
                                    $option_name = 'Pontos binário:';
                                    $option_value = $option_value > 1?$option_value. ' pts':$option_value.' pt';
                                    break;
                                case 'puni':
                                    $option_name = 'Pontos unilevel:';
                                    $option_value = $option_value > 1?$option_value. ' pts':$option_value.' pt';
                                    break;
                                case 'frete':
                                    $peso_total = $peso_total + ($items['qty'] * $option_value);
                                    $option_name = '';
                                    $option_value = '';
                                    break;
                            endswitch;
                            ?>
                            <strong><?php echo $option_name; ?></strong> <?php echo $option_value; ?><br />

                        <?php endforeach; ?>
                    </p>

                <?php endif; ?>

            </td>
            <td style="text-align:right">R$ <?php echo $this->cart->format_number_BRL($items['price']); ?></td>
            <td style="text-align:right" id="subtotal_cart">R$ <?php echo $this->cart->format_number_BRL($items['subtotal']); ?></td>
        </tr>

        <?php $i++; ?>

    <?php endforeach; ?>

    <tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Frete</strong></td>
        <td class="right" id="valor_frete" data-frete="<?php echo $peso_total; ?>">R$ <?php
            $frete = $this->correios->calcula_frete('41106', EMPRESA_CEP, $cep, $this->cart->converte_peso($peso_total),'n',0,'n');
            echo $frete['valor'];

            ?></td>
    </tr>
    <tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Prazo de entrega</strong></td>
        <td class="right" id="valor_frete""><?php
            echo $frete['prazo']+EMPRESA_DIAS_FRETE . ' dia(s)';

            ?></td>
    </tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Total</strong></td>
        <td class="right" id="total_cart" data-total="<?php echo $this->cart->format_number_BRL($this->cart->total()); ?>">R$
            <?php
            $a = $this->cart->format_number_BRL($this->cart->total()+$this->cart->unformat_number($frete['valor']));
            echo $a;
            //$a = $frete['valor'];
            //echo substr_replace($a,'',-3,1);
            //echo substr_replace($a,'',-3,1);
            ?>
        </td>
    <tr>
    </tr>

</table>
<p><?php echo form_submit('', 'Finalizar compra'); ?></p>