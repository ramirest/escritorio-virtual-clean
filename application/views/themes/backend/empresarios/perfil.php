<div class="portlet portlet-default">
	<div class="portlet-body">
	<?php if($this->session->flashdata('msg')): ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata('msg'); ?>
		</div>
	<?php endif; ?>
		<ul id="userTab" class="nav nav-tabs">
			<li class="active"><a href="#overview" data-toggle="tab">Resumo</a></li>
			</li>
		</ul>
		<div id="userTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="overview">

				<div class="row">
					<div class="col-lg-3 col-md-3">
						<?php $tema = $this->config->item('tema'); ?>						
                        <img class="img-responsive img-profile"
							src="<?php echo $tema['img']; ?>empresario-<?php echo $this->dx_auth->get_sexo_associado(); ?>.jpg" alt="">

						<h4>Informações de Contato</h4>
						<p>
							<i class="fa fa-envelope-o fa-muted fa-fw"></i> <?php echo $associado->Email; ?>
						</p>
						<?php if(!empty($associado->tel_fixo)):?>
						<p>
							<i class="fa fa-phone fa-muted fa-fw" title="Telefone fixo"></i> <?php echo $associado->tel_fixo; ?>
						</p>
						<?php endif; ?>
						<?php if(!empty($associado->tel_celular)):?>
						<p>
							<i class="fa fa-mobile-phone fa-muted fa-fw" title="Telefone celular"></i> <?php echo $associado->tel_celular; ?>
						</p>
						<?php endif; ?>
                        <?php if(!empty($associado->tel_comercial)):?>
                            <p>
                                <i class="glyphicon glyphicon-phone-alt fa-muted fa-fw" title="Telefone comercial"></i> <?php echo $associado->tel_comercial; ?>
                            </p>
                        <?php endif; ?>

					</div>
					<div class="col-lg-6 col-md-9">
						<h1> <?php echo $associado->Nome; ?> </h1>
						<?php 
						/**
						 * @todo	exibir pin de graduação, pontos que faltam para a próxima graduação, pontos no binário, pontos no linear
						 */
						
/* 						<ul class="list-inline">
							<li><i class="fa fa-map-marker fa-muted"></i> Bayville, FL</li>
							<li><i class="fa fa-user fa-muted"></i> Administrator</li>
							<li><i class="fa fa-group fa-muted"></i> Sales, Marketing,
								Management</li>
							<li><i class="fa fa-trophy fa-muted"></i> Top Seller</li>
							<li><i class="fa fa-calendar fa-muted"></i> Member Since: 5/13/11</li>
						</ul>
 */						?>	
 						<?php if($faturas !== FALSE): ?>
						<h3>Faturas recentes</h3>
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr>
										<th>Número</th>
										<th>Vencimento</th>
										<th>Descrição</th>
										<th>Valor</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($faturas as $fatura): ?>
									<tr>
										<td><?php echo $fatura->fid; ?></td>
										<td><?php echo $fatura->dtvencimento; ?></td>
										<td><?php echo $fatura->descricaofatura; ?></td>
										<td><?php echo $fatura->valor; ?></td>
										<td>
										<?php if($fatura->status == "Pendente"): ?>
										<a class="btn btn-xs btn-orange disabled"><i
												class="fa fa-clock-o"></i> Pendente</a>
										<?php else: ?>
										<a class="btn btn-xs btn-green"><i
												class="fa fa-arrow->circle-right"></i> Pago</a>
										<?php endif; ?>		
										</td>
									</tr>
								<?php endforeach; ?>	
								</tbody>
							</table>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-lg-3 col-md-4">
						<?php echo $submenu; ?>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /.portlet-body -->
</div>
<!-- /.portlet -->
