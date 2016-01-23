<?php
$data = explode("-", $carregar->data);
$data = @date("d/m/Y", mktime(0,0,0,$data[1], $data[2], $data[0]));
$data2 = explode("-", $carregar->vencimento);
$data2 = date("d/m/Y", mktime(0,0,0,$data2[1], $data2[2], $data2[0]));
?>

<?php echo "Data do processamento: " . $data; ?><br />
<?php echo "Vencimento: " . $data2; ?>