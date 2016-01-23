<?php

   
?>

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4> Logs </h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <?php echo form_open(''); ?>
                <div class="col-sm-12" style="border: solid 1px #dddddd; padding: 0px;">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Filtro de Pesquisa Avançada</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" id="datepicker8">
                                
                                
                                <input placeholder="Data Inicial" type="text" class="form-control" id="dataInicial" name="dataInicial">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" id="datepicker9">
                               
                                <input placeholder="Data Final" type="text" class="form-control" id="dataFinal" name="dataFinal">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                   <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" style="width: 100%;" id="datetimepicker9">
                            Tipo
                                <select name="tipo" class="form-control">
                                    <option value="" disabled="" selected="" style="display:none;"></option>
                                    <option value="Todos">Todos</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Saída">Saída</option>
                                    </select>                            
                               </div>
                        </div>
                    </div>        
                    
                    
                    
                       <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" style="width: 100%;" id="datetimepicker9">
                            Método
                                <select name="tipo" class="form-control">
                                    <option value="" disabled="" selected="" style="display:none;"></option>
                                    <option value="Todos">Todos</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Saída">Saída</option>
                                    </select>                            
                               </div>
                        </div>
                    </div>     
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" style="width: 100%;" id="datetimepicker9">
                            Origem
                                <select name="tipo" class="form-control">
                                    <option value="" disabled="" selected="" style="display:none;"></option>
                                    <option value="Todos">Todos</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Saída">Saída</option>
                                    </select>                            
                               </div>
                        </div>
                    </div>     
                        
                        
                         <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group date" style="width: 100%;" id="datetimepicker9">
                            Rotina
                                <select name="tipo" class="form-control">
                                    <option value="" disabled="" selected="" style="display:none;"></option>
                                    <option value="Todos">Todos</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Saída">Saída</option>
                                    </select>                            
                               </div>
                        </div>
                    </div>     
         
         
               
         <div class="col-md-4">
               <div class="form-group">
                   <div class="input-group" id="descricao">
                       Atualização Automática 
                       <input placeholder="" type="text" class="form-control" id="descricao" name="descricao">
                           
                   </div>
               </div>
             </div>
                    
              <div class="col-md-6">
               <div class="form-group">
                   <div class="input-group" id="descricao">
                       Descrição
                       <input placeholder="Descrição" type="text" class="form-control" id="descricao" name="descricao">
                           
                   </div>
               </div>
             </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" style="width: 100%;" id="datetimepicker9">
                                <?php
                                //    $tipoValores = array('" disabled selected style="display:none;'=>'Tipo', 'Todos'=>'Todos', 'Entrada'=>'Entrada', 'Saída'=>'Saída');
                                //    echo form_dropdown('tipo', $tipoValores, set_value('tipo',$tipo), 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker9">
                                <button type="submit" onclick="#" class="btn btn-default">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

                <br class="quebra"><br><br>
                <div class="table-responsive">

                        <table id="extrato" class="table table-striped table-bordered table-hover table-green dataTable" aria-describedby="example-table_info">
                            <thead>
                            <tr role="row">
                                <th >
                                  Tipo
                                </th>
                                <th >
                                  Origem
                                </th>
                                <th >
                                  Método
                                </th>
                                <th >
                                  Rotina
                                </th>
                                <th >
                                  Descrição
                                </th>
                                <th >
                                  Data
                                </th>

                            </tr>
                            </thead>

                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <tr>
                                <td>
                                  Tipo
                                </td>
                                <td >
                                  Origem
                                </td>
                                <td>
                                  Método
                                </th>
                                <td>
                                  Rotina
                                </th>
                                <td>
                                  Descrição
                                </th>
                                <td>
                                  Data
                                </td>
                                </tr>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>

