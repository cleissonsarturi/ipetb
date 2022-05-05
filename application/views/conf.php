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
                    <h4 class="title">Configuração</h4>
                  </div>

                  <form name="formConf" id="formConf" action="" method="">

                
                  <div class="card-content">
                   
                  
                  <div class="row">

                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Nome</label>
                            <input type="text" class="form-control" id="edNome" name="edNome">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <label class="control-label">CPF/CNPJ</label>
                            <input type="text" class="form-control" id="edCpfCnpj" name="edCpfCnpj">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Endereço</label>
                            <input type="text" class="form-control" id="edEndereco" name="edEndereco">
                        </div>
                    </div>

                    
                      <div class="col-md-3">
                    
                      <div class="form-group label-floating is-focused">
                                <label class="control-label">Selecione o Estado</label>
                                <select class="selectpicker show-tick" data-container="body" onchange="conf.carregaComboCidade(this.value)" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbEstado" name="cbEstado"> 

                                </select>
                            </div>
                      </div>

                </div>

                <div class="row">
                    <div class="col-md-2">
                      <div class="form-group label-floating is-focused">
                            <label class="control-label">Selecione a Cidade</label>
                            <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbCidade" name="cbCidade"> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group label-floating">
                            <label class="control-label">Telefone 1</label>
                            <input type="text" class="form-control" id="edTelefone1" name="edTelefone1">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group label-floating">
                            <label class="control-label">Telefone 2</label>
                            <input type="text" class="form-control" id="edTelefone2" name="edTelefone2">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">ID da Empresa na I7 TEC</label>
                            <input type="text" class="form-control" id="edClienteI7" name="edClienteI7">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">ID do Produto Utilizado</label>
                            <input type="text" class="form-control" id="edProdI7" name="edProdI7">
                        </div>
                    </div>

                      
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Url da API</label>
                            <input type="text" class="form-control" id="edAPI" name="edAPI">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 style="font-size:20px;">Logo</h3>
                        <p style="font-size:14px; color: #000; font-weight: 900;">Tamanho máximo do arquivo: 1mb.</p>
                        <br><br>
                        <div class="form-group label-floating">
                            <label class="control-label">Upload da Imagem</label>
                            <input id="edImagens" name="edImagens[]" type="file" multiple class="filestyle" accept="image/*">
                        </div>
                  
                        <div id="previewFotosNoticia"></div>

                        <!--<input type="hidden" id="edCaminhoImagem" name="edCaminhoImagem" value="">-->
                      </div>
                </div>

            </div>
          </div>
        </div>

        <div class="content">

          <div class="container-fluid">

            <div class="row">

              <div class="col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="blue">
                    <h4 class="title">IEPTB</h4>
                  </div>

                  <div class="card-content">

                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">WEB_SERVICE_IEPTB_URL</label>
                            <input type="text" class="form-control" id="ieptburl" name="ieptburl">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">WEB_SERVICE_IEPTB_USUARIO</label>
                            <input type="text" class="form-control" id="ieptbusuario" name="ieptbusuario">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">WEB_SERVICE_IEPTB_SENHA</label>
                            <input type="text" class="form-control" id="ieptbsenha" name="ieptbsenha">
                        </div>
                    </div>

                    <div class="col-md-3" style="display: none">
                      <div class="form-group label-floating">
                        <label class="control-label">DIAS_ENVIO_PROTESTO</label>
                        <input type="text" class="form-control" id="edDiasEnvioProtesto" name="edDiasEnvioProtesto">
                      </div>
                    </div>
                </div>


                <div class="row">
                  <div class="col-md-3">
                      <div class="form-group label-floating">
                        <label class="control-label">Tipo Endosso </label>
                        <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbEndosso" name="cbEndosso"></select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group label-floating">
                        <label class="control-label">Aceite </label>
                        <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition" title="Selecione" id="cbAceite" name="cbAceite">
                          <option value="S">Sim</option>
                          <option value="N">Não</option>
                        </select>
                      </div>
                  </div>              
                  <div class="col-md-3">
                      <div class="form-group label-floating">
                        <label class="control-label">Portador </label>
                        <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbPortador" name="cbPortador"></select>
                      </div>
                  </div>                  
                  <div class="col-md-3">
                      <div class="form-group label-floating">
                        <label class="control-label">Motivo </label>
                        <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition" title="Selecione" id="cbMotivo" name="cbMotivo"></select>
                      </div>
                  </div> 
                </div>

                <div class="row">
                  <div class="col-md-6">
                       <div class="form-group label-floating">
                          <label class="control-label">Espécie </label>
                          <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbEspecie" name="cbEspecie"></select>
                        </div>
                  </div>
                  <div class="col-md-4">
                       <div class="form-group label-floating">
                          <label class="control-label">Cobrança </label>
                          <select class="selectpicker show-tick" data-container="body" data-live-search="true" data-style="select-with-transition"  title="Selecione" id="cbCobranca" name="cbCobranca"></select>
                        </div>
                  </div>
                  <div class="col-md-2">
                       <div class="btn btn-style-1" onclick="conf.getCobrancas()">Buscar Cobranças</div>
                  </div>                  
                </div>

                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group label-floating">
                        <label class="control-label">Token IEPTB </label>
                        <input type="text" class="form-control" id="edTokenIeptb" name="edTokenIeptb" disabled>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group label-floating">
                        <label class="control-label">Data de Criação do Token IEPTB </label>
                        <input type="text" class="form-control" id="edDataCriacaoToken" name="edDataCriacaoToken" disabled>
                      </div>
                  </div>                  
                </div>

                </form>

     
                <br>
                    <center>
                      <button class="btn btn-style-1" type="button" id="btnSalvar" name="btnSalvar" onclick="conf.salvarConf($('#formConf').serialize())" style="display: inline;">Salvar</button>
                    </center>
                    </div>
                </div>
                  
                  </div>

                </div>

            </div>
          </div>
        </div> 
        
        


    </div>

</div>

<script>
  baseUrl = "<?php echo base_url(); ?>";
</script>

