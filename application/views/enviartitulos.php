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
                    <h4 class="title">Integradora WINTHOR - IEPTB</h4>
                  </div>

                  <div class="card-content">
                    <button class="btn btn-style-2" onclick="enviartitulos.BuscaDadosNoWinthor()"><span class="material-icons md-48">install_desktop</span> Buscar Títulos Winthor</button>
                    <button class="btn btn-style-2" onclick="enviartitulos.abrirModalAlterarConfiguracao()"><span class="material-icons md-48">autorenew</span> Alterar configuração Títulos</button>
                    <button class="btn btn-style-2" onclick="enviartitulos.EnviaTitulosParaIEPTB()"><span class="material-icons md-48">backup</span> Enviar Títulos para o Cartório</button>

                    <br><br>
                    <div class="filtros">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione o banco</label>
                            <select class="selectpicker show-tick" data-container="body" title="Selecione" onchange="enviartitulos.initTabelaComCaixa(this.value)" data-style="select-with-transition" id="cbCaixa" name="cbCaixa">
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                          <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione as colunas da tabela para remover</label>
                            <select class="selectpicker show-tick" data-container="body" title="Selecione" onchange="enviartitulos.toggleColuna(this.value)" data-style="select-with-transition" multiple id="cbColunas" name="cbColunas">
                              <option value="1">Cliente</option>
                              <option value="2">Data de Vencimento</option>
                              <option value="3">Duplicata</option>
                              <option value="4">Prestação</option>
                              <option value="5">Valor Título</option>
                              <option value="6">Juros</option>
                              <option value="7">Multa</option>
                              <option value="8">Saldo</option>
                              <option value="9">Cond. Pagamento</option>
                              <option value="10">Banco</option>
                              <option value="11">Dias Atrasados</option>
                            </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br><br>

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



<div class="modal fade" id="modalDetalhamentoRetornoEnvio" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header card-header" style="background-color: linear-gradient(#fff, #fff) !important; background-color: #fff !important; background: #fff !important border-left: 8px solid #152c8f !important; border-bottom: 2px solid #152c8f !important;">
        <h5 class="modal-title title" id="modalBaixaLabel" style="font-size: 18px !important; text-transform: uppercase !important; text-align: left !important; letter-spacing: 1px !important; font-weight:900 !important; width: 100% !important;color: #2b2b2b !important;">Retorno do Envio</h5>

        
        <button type="button" class="close" style="margin-top: -50px !important" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <span id="SpanConteudoModalDetalhamentoRetorno"></span>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalAlteracaoConfiguracaoTitulos" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header card-header" style="background-color: linear-gradient(#fff, #fff) !important; background-color: #fff !important; background: #fff !important border-left: 8px solid #152c8f !important; border-bottom: 2px solid #152c8f !important;">
        <h5 class="modal-title title" id="modalBaixaLabel" style="font-size: 18px !important; text-transform: uppercase !important; text-align: left !important; letter-spacing: 1px !important; font-weight:900 !important; width: 100% !important;color: #2b2b2b !important;">Configuração do protesto do título</h5>

        
        <button type="button" class="close" style="margin-top: -50px !important" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group label-floating">
              <label class="control-label">Tipo Endosso </label>
              <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbEndosso" name="cbEndosso"></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group label-floating">
              <label class="control-label">Aceite </label>
              <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition" title="Selecione" id="cbAceite" name="cbAceite">
                <option value="S">Sim</option>
                <option value="N">Não</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group label-floating">
              <label class="control-label">Portador </label>
              <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbPortador" name="cbPortador"></select>
            </div>
          </div>
        </div>
        <div class="row">         
          <div class="col-md-6">
            <div class="form-group label-floating">
              <label class="control-label">Motivo </label>
              <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition" title="Selecione" id="cbMotivo" name="cbMotivo"></select>
            </div>
          </div> 
          <div class="col-md-6">
            <div class="form-group label-floating">
              <label class="control-label">Espécie </label>
              <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbEspecie" name="cbEspecie"></select>
            </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="enviartitulos.AtualizaInformacoesTitulos()">Alterar configurações dos títulos selecionados</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
