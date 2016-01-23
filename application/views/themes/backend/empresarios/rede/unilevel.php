<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th class="warning">Nível</th>
                    <th class="warning">Nome</th>
                    <th class="warning">Id</th>
                    <th class="warning">Login</th>
                </thead>
                <tbody>
                    <?php
                    foreach($associados as $a=>$associado):
                        $count = 1 + count($associado);
                        echo '<tr>';
                        echo '<td rowspan="'. $count .'">'."$a</td>";
                        echo '</tr>';
                        foreach($associado as $ass)
                            echo $ass;

                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>