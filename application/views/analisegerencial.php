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
                    <h4 class="title">Gerencial - Rotina 1464</h4>
                    <p class="category"><?php echo retornaDataHoraTexto(date('d-m-Y H:i')); ?></p>
                  </div>
                  <div class="card-content">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Visão do relatório</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition"  title="Selecione a visão relatório" id="cbTipoRelatorio" name="cbTipoRelatorio" onchange="analisegerencial.mostraEscondeComboAnalise()"> 
                              <option value="Ger">GERENTE DE VENDA</option>
                              <option value="sup">SUPERVISOR</option>
                              <option value="vend">VENDEDOR</option>
                            </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label" id="LbTxtComboSup">Supervisor</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" title="Selecione" id="cbSupervisor" name="cbSupervisor">
                            </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Tipo do relatório</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition"  title="Selecione o Tipo" id="cbTipoRel" name="cbTipoRel">
                              <option value="M">MENSAL</option>
                              <option value="D">DIÁRIO</option>
                            </select>
                        </div>
                      </div>
                      
                      <div class="col-md-4">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Relatório</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition"  title="Selecione o Tipo" id="cbRelatorios" name="cbRelatorios">
                              <option value="Forn">FORNECEDOR</option>
                            </select>
                            </select>
                        </div>
                      </div>

                      <div class="col-md-4 IntervaloDatas" >
                        <div class="form-group label-floating">
                            <label class="control-label">Data Inicial</label>
                            <input type="text" class="form-control" id="edDataInicial" name="edDataInicial">
                        </div>
                      </div>
                      <div class="col-md-4 IntervaloDatas" >
                        <div class="form-group label-floating">
                            <label class="control-label">Data Final</label>
                            <input type="text" class="form-control" id="edDataFinal" name="edDataFinal">
                        </div>
                      </div>
                      
                      <div class="col-md-3 divComboTipoAnalise" id="divComboTipoAnaliseMes" style="display: none;">
                        <div class="form-group label-floating is-focused">
                          <label class="control-label">Mês</label>
                          <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" id="cbTipoAnaliseMes" name="cbTipoAnaliseMes" >
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                          </select>
                        </div>
                      </div>





                      <!-- <div class="col-md-3 IntervaloDatas"  style="display: none;">
                        <div class="form-group label-floating">
                            <label class="control-label">Data Inicial</label>
                            <input type="text" class="form-control" id="edDataInicial" name="edDataInicial">
                        </div>
                      </div>
                      <div class="col-md-3 IntervaloDatas"  style="display: none;">
                        <div class="form-group label-floating">
                            <label class="control-label">Data Final</label>
                            <input type="text" class="form-control" id="edDataFinal" name="edDataFinal">
                        </div>
                      </div> -->

                      <div class="col-md-3 divComboTipoAnalise" id="divComboTipoAnalise" style="display: none;">
                        <div class="form-group label-floating is-focused">
                          <label class="control-label">Tipo da analise</label>
                          <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition"  id="cbTipoAnalise" name="cbTipoAnalise" onchange="analisegerencial.mostraEscondeComboTipoAnalise()">
                            <option value="Me">Mensal</option>
                            <option value="An">Anual</option>
                          </select>
                        </div>
                      </div>

                      

                      <div class="col-md-3 divComboTipoAnalise" id="divComboTipoAnaliseAnos" style="display: none;">
                        <div class="form-group label-floating is-focused">
                          <label class="control-label">Ano</label>
                          <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" id="cbTipoAnaliseAnos" name="cbTipoAnaliseAnos" onchange="analisegerencial.mostraEscondeComboTipoAnalise()">
                            <option value="2018">2018</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6" id="divComboIntervaloAnalise" style="display: none;">
                          <div class="form-group label-floating">
                              <label class="control-label">Ano</label>
                              <input type="text" class="form-control" id="edAno" name="edAno">
                          </div>
                      </div>
                    </div>
                    <div class="row" id="divComboCidade" style="display: none;">
                      <div class="col-md-12">
                        <div class="form-group label-floating is-focused">
                            <label class="control-label">Cidades</label>
                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione a cidade" id="cbCidades" name="cbCidades">
                              <option value="Pl">Planalto</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group" align="center">
                          <button type="button" class="btn btn-info" id="btnPesquisarNotas" onclick="analisegerencial.gerenciaGraficosMostrarTela()">Pesquisar</button>
                          <button type="button" class="btn btn-info" onclick="analisegerencial.limparAreaGrafico()">Limpar</button>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <!-- Montar a tabela de apresentação das informações do emerson -->

                      <div class="col-md-12">
                        


                        <div id="LocalRelatorio"></div>  


                      </div>                      
                    </div>

                    
                    <div class="row">
                      <div class="col-md-12">
                        <div id="chart_div"></div>  
                      </div>                      
                    </div>

                    <div class="row">
                      <br><br><br>
                      <div class="col-md-12">
                        <div id="chart_divVendedores"></div>  
                      </div>                      
                    </div>


                  </div>
                  </div>
                </div>

            </div>
          </div>
        </div>
        <?php $this->load->view('estrutura/footer'); ?>
    </div>
</div>
