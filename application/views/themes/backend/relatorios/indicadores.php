<form >
    <input type="submit" name="atualizar" id="atualizar" value="Atualizar" />
</form>

<div id="indicadores">

    <?php
    echo "<table id='table-geral' class='table table-striped table-bordered table-hover table-green''>";
    echo "<tr>";
    echo "<thead>";
    echo "<th>  Descrição </th>";
    echo "<th>  Total </th>";
    echo "<th>  Detalhes </th>";
    echo "</thead>";
    echo "</tr>";

    $sql_v = $this->db->query($ultra_sql);
	foreach($sql_v->result_array() as $lc):
        echo "<tr>";
        echo "<tbody>";
        echo "<td>".$lc['descricao']."</td>";
        echo "<td>".$lc['Total']."</td>";

        $link = site_url('escritorio-virtual/relatorios/detalhesIndicadores/'.$lc['iid']);
        echo "<td>";
        echo "<div style=\"padding-left:9px;\" class=\"input-group\">";
        if(($lc['Total']!='0') && ($lc['scriptDetalhes']!='')){
            echo "<button onclick=\"window.location.href='".$link."'\" class=\"btn btn-default\">Exibir</button>";
        }
        echo "</div>";
        echo "</td>";

        echo "</tbody>";
        echo "</tr>";
	endforeach;

    echo "</table>";
    ?>

</div>
