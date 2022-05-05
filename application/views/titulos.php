<div class="wrapper">
    <?php $this->load->view('estrutura/menu'); ?>
    <div class="main-panel">
        <?php $this->load->view('estrutura/nav',$breadcrumbs = null); ?>

        <div class="content">

          <div class="container-fluid">

            <div class="row">

              <div class="col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="blue">
                    <h4 class="title">Filtrar Títulos</h4>
                  </div>

                  <div class="card-content">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione a Filial</label>
                            <select class="selectpicker show-tick" data-container="body" title="Selecione" data-style="select-with-transition" multiple id="cbFilial" name="cbFilial">
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione um Cliente</label>
                            <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition" id="cbCliente" name="cbCliente"> 
                            </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione o status do titulo</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition"  data-live-search="true" id="cbStatus" name="cbStatus">
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
  
                      <div class="col-md-4">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione o filtro de data</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true"  id="cbTipoData" name="cbTipoData">
                              <option value="DT">Data do Título</option>
                              <option value="DE">Data de Envio para Cartório</option>
                              <option value="DP">Data de Pagamento</option>
                              <option value="DB">Data de Baixa</option>
                            </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Data Inicial</label>
                            <div class='input-group date' id="edDataInicialDiv">
                                <input type="text" class="form-control" name="edDataInicial" id="edDataInicial"  value="">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar" id="edCalendarioCampoData1" style="font-size: 24px;"></span>
                                </span>
                            </div>
                        </div>

                      </div>

                      <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Data Final</label>
                            <div class='input-group date' id="edDataFinalDiv">
                                <input type="text" class="form-control" name="edDataFinal" id="edDataFinal"  value="">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar" id="edCalendarioCampoData2" style="font-size: 24px;"></span>
                                </span>
                            </div>
                        </div>

                      </div>  
                      
                    </div>
                    <center>
                      <button class="btn btn-style-1" style="display: inline;" onclick="titulos.BuscaDadoECarregaTabela(columnDefs, colOrdem)">Buscar</button>
                      <button class="btn btn-style-2" style="display:inline; margin-top: 20px;" onclick="titulos.LimparDadosTela()">Limpar</button>
                    </center>
                    </div>
                </div>

            </div>
          </div>
        </div>

        <div class="content" id="divApresentacaoTitulos" style="display: none;">

          <div class="container-fluid">

            <div class="row">

              <div class="col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="blue">
                    <h4 class="title">Títulos</h4>
                  </div>

                  <div class="card-content">

                  <button class="btn btn-style-2" onclick="titulos.selecionarTudo()"><span class="material-icons md-48">checkbox</span>Selecionar Tudo (Por Página)</button>
                  <button class="btn btn-style-2" onclick="titulos.verificaPago()"><span class="material-icons md-48">download</span>Baixar no Winthor</button>
                  <button class="btn btn-style-2" onclick="titulos.verificaProtestado()"><span class="material-icons md-48">delete</span>Cancelar Protesto</button>
                  <!-- <button class="btn btn-style-2"  data-toggle="modal" data-target="#modalInfo"><span class="material-icons md-48">info</span>Informações</button> -->
                  
                  </div>

                  <div class="card-content table-responsive">

                  <table id="tabela" class="table table-bordered dt-responsive display nowrap" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                            <?php 
                              if(isset($tabela)){
                                foreach ($tabela as $key => $value) {
                                  if($key == 'theadsTabela'){
                                    foreach ($value as $nomes => $conf) {
                                      echo "<th width='".$conf['width']."%' style='text-align:".$conf['posicao'].";'>".$nomes."</th>";
                                    }
                                  }
                                }
                              }
                            ?>
                          </tr>
                      </thead>
                  </table>
                </div>

            </div>
          </div>
        </div>        


    </div>

</div>



<!-- Modal -->
<div class="modal fade" id="modalBaixa" tabindex="-1" aria-labelledby="modalBaixaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header card-header" style="background-color: linear-gradient(#fff, #fff) !important; background-color: #fff !important; background: #fff !important border-left: 8px solid #152c8f !important; border-bottom: 2px solid #152c8f !important;">
        <h5 class="modal-title title" id="modalBaixaLabel" style="font-size: 18px !important; text-transform: uppercase !important; text-align: left !important; letter-spacing: 1px !important; font-weight:900 !important; width: 100% !important;color: #2b2b2b !important;">Baixar No Winthor</h5>

        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12">
            <center><div class="btn btn-style-1" style="margin:0 auto; display:block; width: 25%; margin-bottom: 15px;" onclick="titulos.getCaixasMoedas()">Atualizar Caixas e Moedas</div></center>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group label-floating is-focused">
                <label class="control-label">Usuário</label>
                <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" title="Selecione" id="cbUsuarioWinthor" name="cbUsuarioWinthor">
                </select>
            </div>
          </div>
          <div class="col-md-4">
          <div class="form-group label-floating is-focused">
                <label class="control-label">Caixa</label>
                <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" title="Selecione" id="cbCaixa" name="cbCaixa">
                </select>
            </div>
          </div>
          <div class="col-md-4">
          <div class="form-group label-floating is-focused">
                <label class="control-label">Moeda</label>
                <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" title="Selecione" id="cbMoeda" name="cbMoeda">
                </select>
            </div>
          </div>
        </div>

      </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="titulos.baixarWinthor()">Baixar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header card-header" style="background-color: linear-gradient(#fff, #fff) !important; background-color: #fff !important; background: #fff !important border-left: 8px solid #152c8f !important; border-bottom: 2px solid #152c8f !important;">
        <h5 class="modal-title title" id="modalInfoLabel" style="font-size: 18px !important; text-transform: uppercase !important; text-align: left !important; letter-spacing: 1px !important; font-weight:900 !important; width: 100% !important;color: #2b2b2b !important;">Número: <span id="numeroH"></span>  - <div class="badge" id="statusPagamentoH"></div></h5>
        <p style="color: #2b2b2b;"><span style="font-weight: 900;">Nosso Número:</span> <span id="nossoNumeroH"> </span></p>
        <p style="color: #2b2b2b;"><span style="font-weight: 900;">Devedor:</span> <span id="devedor"> </span> - <span id="docDevedor"> </span></p>

        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-header" style="background-color: #152c8f;">
            <h5 style="color:#fff; font-size: 22px;">Sacador</h5>
          </div>  
          <br>
          <div class="card-body perkele">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <p>Nome: <spanS style="font-weight: 400;" id="nomeSacador"></span></p>
                  <p>Endereço: <spanS style="font-weight: 400;" id="enderecoSacador"></span></p>
                  <p>Cidade: <spanS style="font-weight: 400;" id="cidadeSacador"></span></p>
                  <!-- <p>Email: <spanS style="font-weight: 400;" id="emailSacador"></span></p> -->
                </div>
                <div class="col-md-6">
                  <p>Documento: <spanS style="font-weight: 400;" id="documentoSacador"></span></p>
                  <p>UF: <spanS style="font-weight: 400;" id="ufSacador"></span></p>
                  <p>CEP: <spanS style="font-weight: 400;" id="cepSacador"></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" style="background-color: #152c8f;">
            <h5 style="color:#fff; font-size: 22px;">Devedor</h5>
          </div>  
          <br>
          <div class="card-body perkele">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <p>Nome: <span style="font-weight: 400;" id="nomeDevedor"></span></p>
                  <p>Endereço: <span style="font-weight: 400;" id="enderecoDevedor"></span></p>
                  <p>Cidade: <span style="font-weight: 400;" id="cidadeDevedor"></span></p>
                  <p>Email: <span style="font-weight: 400;" id="emailDevedor"></span></p>
                </div>
                <div class="col-md-6">
                  <p>Documento: <span style="font-weight: 400;" id="documentoDevedor"></span></p>
                  <p>Bairro: <span style="font-weight: 400;" id="bairroDevedor"></span></p>
                  <p>UF: <span style="font-weight: 400;" id="ufDevedor"></span></p>
                  <!-- <p>CEP: <span style="font-weight: 400;" id="cepDevedor"></span></p> -->
                  <p>Fone: <span style="font-weight: 400;" id="foneDevedor"></span></p>
                </div>
              </div>
            </div>
          </div>
          <br>                      
          <div class="card">
          <div class="card-header" style="background-color: #152c8f;">
            <h5 style="color:#fff; font-size: 22px;">Dívida</h5>
          </div>  
          <br>
          <div class="card-body perkele">
            <div class="container-fluid">
              <ul class="list-group" style="width:100%;">
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-6">
                      <p>Número: <span style="font-weight:400;" id="numeroDivida"></span> </p>
                    </div>
                    <div class="col-md-6">
                      <p>Nosso Número: <span style="font-weight:400;" id="nossoNumero"></span></p>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-6">
                      <p>Valor: <span style="font-weight:400;" id="valorDivida"></span> </p>
                    </div>
                    <div class="col-md-6">
                      <p>Saldo: <span style="font-weight:400;" id="saldoDivida"></span></p>
                    </div>
                  </div>
                </li>

                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-6">
                      <!-- <p>Gerado <span style="font-weight:400;" id="geradoDivida"></span> </p> -->
                      <p>Emissão: <span style="font-weight:400;" id="emissaoDivida"></span> </p>
                    </div>
                    <div class="col-md-6">
                      <p>Vencimento: <span style="font-weight:400;" id="vencimentoDivida"></span> </p>
                    </div>
                    <!-- <div class="col-md-4">
                      <p>Vencimento À Vista<span style="font-weight:400;" id="vencimentoavistaDivida"></span> </p> 
                    </div>-->
                  </div>
                </li>

                <li class="list-group-item">
                  <div class="row">
                      <div class="col-md-6">
                        <p>Juros: <span style="font-weight:400;" id="juroDivida"></span> </p>
                      </div>
                      <div class="col-md-6">
                        <p>Multa: <span style="font-weight:400;" id="multaDivida"></span> </p>
                      </div>
                    </div>
                </li>

                <li class="list-group-item">
                  
                  <div class="row">
                    <div class="col-md-3">
                      <p>Espécie: <span style="font-weight:400;" id="especieDivida"></span> </p>
                    </div>
                    <div class="col-md-3">
                      <p>Endosso: <span style="font-weight:400;" id="endossoDivida"></span> </p>
                    </div>
                    <div class="col-md-3">
                      <p>Aceite: <span style="font-weight:400;" id="aceiteDivida"></span> </p>
                    </div>
                    <div class="col-md-3">
                      <p>Motivo: <span style="font-weight:400;" id="motivoDivida"></span> </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <p>Declaração Portador: <span style="font-weight:400;" id="declaraoDivida"></span></p>
                    </div>  

                  </div>
                </li>

              </ul>
            </div>
          </div>

          <br>

          <div class="card">
          <div class="card-header" style="background-color: #152c8f;">
            <h5 style="color:#fff; font-size: 22px;">Dívida</h5>
          </div>  
          <br>
          <div class="card-body perkele">
            <div class="container-fluid">
              <ul class="list-group" style="width:100%;">
              
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-3">
                      <p>Data da Baixa: <span style="font-weight:400;" id="dataBaixa"></span> </p>
                    </div>
                    <div class="col-md-3">
                      <p>Usuário: <span style="font-weight:400;" id="usuarioBaixa"></span> </p>
                    </div>
                    <div class="col-md-3">
                      <p>Caixa: <span style="font-weight:400;" id="caixaBaixa"></span></p>
                    </div>
                    <div class="col-md-3">
                      <p>Moeda: <span style="font-weight:400;" id="moedaBaixa"></span></p>
                    </div>
                  </div>
                </li>


              </ul>
            </div>
          </div>
          
          
        </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<?php

  $conf         = array();
  $colOrdem     = array();
  $arrayDefs    = json_encode(array());
  $arrayOrdem   = json_encode(array());

  if(isset($tabela)){
    foreach ($tabela as $key => $value) {
      if($key == 'columnDefs'){
        foreach ($value as $defs) {
          $conf[] = $defs;
        }
      }
      if($key == 'ordemInicial'){
        foreach ($value as $sort) {
          $colOrdem[] = $sort;
        }
      }
    }
    $arrayDefs  = json_encode($conf);
    $arrayOrdem = json_encode($colOrdem); 
  }

?>

<script>
  var responsavel = "";
  var columnDefs  = [];
  var colOrdem    = [];

  columnDefs  = <?php echo $arrayDefs; ?>;
  colOrdem    = <?php echo $arrayOrdem; ?>;
  baseUrl = "<?php echo base_url(); ?>"
</script>

