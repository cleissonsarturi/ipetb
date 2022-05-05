<div class="wrapper">
    <?php $this->load->view('estrutura/menu'); ?>
    <div class="main-panel">
      <?php $this->load->view('estrutura/nav', $breadcrumbs = null); ?>
      <div class="content">
          <div class="container-fluid">
	          <div class="row">
	              <div class="col-lg-12 col-md-12">
	                <div class="card">
	                    <div class="card-header" data-background-color="blue">
	                        <h4 class="title">Dashboard</h4>
	                        <p class="category">Dados de <span id="dadosDe"><?php echo transformaMesParaPortugeus(date('m')); ?> de <?php echo date('Y'); ?></span>  <button id="alterar" class="btn btn-primary" style="padding-top: 5px; padding-bottom: 5px;">Alterar</button> <button id="atualizar" onclick="inicio.atualizar()" class="btn btn-primary" style="padding-top: 5px; padding-bottom: 5px;">Atualizar</button></p>
	                    </div>
	                    
	                    <div class="card-body">
							<div class="row">
								<div class="col-md-4">
									<div class="card" style="cursor:pointer;" onclick="inicio.buscaDadosEnviados()">
										<div class="card-header" style="margin-bottom: 20px;" data-background-color="blue">
											<img src="<?php echo base_url(); ?>assets/images/docenviado.png" style="width: 40px !important; margin: 0 auto; display:block;" width="30px" alt="">
											<h5 class="title text-center" id="qtdEnviado" style="text-align: center !important; font-size: 45px;"></h5>
											<p style="color:#152c8f; font-size: 22px; text-align:center; font-size: 25px; font-weight: 500;">Títulos Enviados</p>
										</div>
									</div>
								</div>

								<div class="col-md-4">
								<div class="card" style="cursor:pointer;" onclick="inicio.buscaDadosPagos()">
										<div class="card-header" style="margin-bottom: 20px;" data-background-color="blue">
											<img src="<?php echo base_url(); ?>assets/images/docpago.png" style="width: 40px !important; margin: 0 auto; display:block;" width="30px" alt="">
											<h5 class="title text-center" id="qtdPago" style="text-align: center !important; font-size: 45px;"></h5>
											<p style="color:#152c8f; font-size: 22px; text-align:center; font-size: 25px; font-weight: 500;">Títulos Pagos</p>
										</div> 
									</div>
								</div>

								<div class="col-md-4">
									<div class="card" style="cursor:pointer;" onclick="inicio.buscaDadosEmAberto()">
										<div class="card-header" style="margin-bottom: 20px;" data-background-color="blue">
											<img src="<?php echo base_url(); ?>assets/images/docaberto.png" style="width: 40px !important; margin: 0 auto; display:block;" width="30px" alt="">
											<h5 class="title text-center" id="qtdAberto" style="text-align: center !important; font-size: 45px;"></h5>
											<p style="color:#152c8f; font-size: 22px; text-align:center; font-size: 25px; font-weight: 500;">Títulos em Aberto</p>
										</div>
									</div>
							</div>
						</div>

						<div class="row">
								<div class="col-md-4">
									<div class="card" style="cursor:pointer;">
										<div class="card-header" style="margin-bottom: 20px;" data-background-color="blue">
											<img src="<?php echo base_url(); ?>assets/images/money.png" style="width: 40px !important; margin: 0 auto; display:block;" width="30px" alt="">
											<h5 class="title text-center" id="valorEnviado" style="text-align: center !important; font-size: 45px;"></h5>
											<p style="color:#152c8f; font-size: 22px; text-align:center; font-size: 25px; font-weight: 500;">Valores Enviados</p>
										</div>
									</div>
								</div>

								<div class="col-md-4">
								<div class="card" style="cursor:pointer;">
										<div class="card-header" style="margin-bottom: 20px;" data-background-color="blue">
											<img src="<?php echo base_url(); ?>assets/images/money.png" style="width: 40px !important; margin: 0 auto; display:block;" width="30px" alt="">
											<h5 class="title text-center" id="valorPago" style="text-align: center !important; font-size: 45px;"></h5>
											<p style="color:#152c8f; font-size: 22px; text-align:center; font-size: 25px; font-weight: 500;">Valores Pagos</p>
										</div> 
									</div>
								</div>

								<div class="col-md-4">
									<div class="card" style="cursor:pointer;">
										<div class="card-header" style="margin-bottom: 20px;" data-background-color="blue">
											<img src="<?php echo base_url(); ?>assets/images/money.png" style="width: 40px !important; margin: 0 auto; display:block;" width="30px" alt="">
											<h5 class="title text-center" id="valorAberto" style="text-align: center !important; font-size: 45px;"></h5>
											<p style="color:#152c8f; font-size: 22px; text-align:center; font-size: 25px; font-weight: 500;">Valores em Aberto</p>
										</div>
									</div>
							</div>

							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group label-floating">
										<label class="control-label">Data de Exibição</label>
										<div class='input-group date' id="edDataDadosDiv">
											<input type="text" class="form-control" name="edDataDados" id="edDataDados"  value="">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar" id="edCalendarioCampoData1" style="font-size: 24px;"></span>
											</span>
										</div>
									</div>
								</div>
							</div>
                        </div>


						<br><br><br><br><br><br><br><br><br><br>
	                    
	                </div>
	              </div>
	          </div>
          </div>
      </div>
      <?php $this->load->view('estrutura/footer'); ?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="modalDadosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header card-header" style="background-color: linear-gradient(#fff, #fff) !important; background-color: #fff !important; background: #fff !important border-left: 8px solid #152c8f !important; border-bottom: 2px solid #152c8f !important;">
        <h5 class="modal-title title" id="modalDadosLabel" style="font-size: 18px !important; text-transform: uppercase !important; text-align: left !important; letter-spacing: 1px !important; font-weight:900 !important; width: 100% !important;color: #2b2b2b !important;"><span id="tituloTitulos"></span></h5>

        
        <button type="button" class="close" style="margin-top: -50px !important;" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

	  	<table class="table">
			<tr>
				<th>Nosso Número</th>
				<th>Saldo</th>
				<th>Data de Vencimento</th>
				<th>Cliente</th>
			</tr>
			<tbody id="append">

			</tbody>	
		</table>


      </div>        

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
