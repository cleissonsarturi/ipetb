<?php 

    $base  = base_url();

?>

<script>

  var baseUrl = "";

  baseUrl     = "<?php echo $base; ?>";

</script>



<div class="modal fade" id="modalFornecedores" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalPessoasLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formFornecedores" id="formFornecedores" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-9">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Nome</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbFornecedoresPesquisaModal" name="cbFornecedoresPesquisaModal"></select>

                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Situação</label>

                              <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" id="cbSituacaoFornecedorModal" name="cbSituacaoFornecedorModal">

                                  <option value="N" selected>Ativa</option>

                                  <option value="S">Inativa</option>

                              </select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomeFornecedorModal" id="edNomeFornecedorModal"  value="">

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group label-floating">

                                            <label class="control-label">CNPJ</label>

                                            <input type="text" class="form-control" id="edCNPJFornecedor" name="edCNPJFornecedor">

                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Frete</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" id="cbFreteFornecedorModal" name="cbFreteFornecedorModal">

                                                <option value="S">Sim</option>

                                                <option value="N">Não</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="col-md-3">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Tipo Cobrança </label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" id="cbTipoCobrancaFornecedorModal" name="cbTipoCobrancaFornecedorModal" disabled>

                                                <option value="K">KG</option>

                                                <option value="P">Porcentagem</option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Valor (KG)</label>

                                            <input type="text" class="form-control" id="edValorKGModal" name="edValorKGModal" disabled>                                            

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Valor (%)</label>

                                            <input type="text" class="form-control" id="edValorPModal" name="edValorPModal" disabled>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Comissão padrão dos produtos</label>

                                            <input type="text" class="form-control" id="edComissaoPadraoProdutoModal" name="edComissaoPadraoProdutoModal">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarFornecedorModal" id="edEditarFornecedorModal" value="N">

                <input type="hidden" name="edCodigoFornecedorModal" id="edCodigoFornecedorModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarFornecedor" onclick="app.salvaFornecedor($('#formFornecedores').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalFornecedores()">Limpar</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalVendedores" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalPessoasLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formVendedores" id="formVendedores" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-9">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Nome</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbVendedoresModal" name="cbVendedoresModal"></select>

                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Situação</label>

                              <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" id="cbSituacaoVendedorModal" name="cbSituacaoVendedorModal">

                                  <option value="N" selected>Ativa</option>

                                  <option value="S">Inativa</option>

                              </select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomeVendedorModal" id="edNomeVendedorModal"  value="">

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Tipo da venda</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbTipoVendaModal" id="cbTipoVendaModal" onchange="app.AjustaPagarComissao()">

                                                <option value="D">Direta</option>

                                                <option value="I">Interna</option>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Pagar Comissão</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbPagarComissaoModal" id="cbPagarComissaoModal" onchange="app.AjustaTipoComissao()">

                                                <option value="S">Sim</option>

                                                <option value="N">Não</option>            

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Tipo Comissão</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbTipoComissaoModal" id="cbTipoComissaoModal" onchange="app.AtivaCampoPorcentagemComissao()">

                                                <option value="P">Valor dos produtos</option>

                                                <option value="N">Valor total da nota</option>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Porcentagem comissão</label>

                                            <input type="text" class="form-control" id="edPorcentagemComissaoModal" name="edPorcentagemComissaoModal" disabled>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarVendedor" id="edEditarVendedorModal" value="N">

                <input type="hidden" name="edCodigoVendedor" id="edCodigoVendedorModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroVendedor" onclick="app.salvarVendedor($('#formVendedores').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalVendedor()">Limpar</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalClientes" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalClientesLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formClientes" id="formClientes" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-12">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Nome</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbClientesModal" name="cbClientesModal"></select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-8">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomeClienteModal" id="edNomeClienteModal" value="">

                                        </div>

                                    </div>

                                    

                                    <div class="col-md-4">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Tipo da Pessoa</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbTipoPessoaModal" id="cbTipoPessoaModal" onchange="app.ajustaCamposTipoPessoaModal(this.value)">

                                                <option value="J" selected>Jurídica</option>

                                                <option value="F">Física</option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group label-floating">

                                            <label class="control-label" id="TextTipoPessoaModal">CNPJ</label>

                                            <input type="text" class="form-control" id="edCNPJClientes" name="edCNPJClientes">

                                            <input type="text" class="form-control" id="edCPFClientes"  name="edCPFClientes" style="display: none;"> 

                                        </div>

                                    </div>



                                    <div class="col-md-6">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Vendedor</label>

                                            <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbVendedoresModalCliente" name="cbVendedoresModalCliente"></select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarClienteModal" id="edEditarClienteModal" value="N">

                <input type="hidden" name="edCodigoClienteModal" id="edCodigoClienteModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroCliente" onclick="app.salvaCliente($('#formClientes').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalCliente()">Limpar</button>

                    <button type="button" class="btn btn-info" id="btnExcluiCadastroCliente" onclick="app.excluiClienteModalCliente($('#edCodigoClienteModal').val())" disabled>Excluir</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalProdutos" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalPessoasLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formProduto" id="formProduto" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-6">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Fornecedor</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbFornecedorPesquisaModalProdutos" name="cbFornecedorPesquisaModalProdutos"></select>

                          </div>

                        </div>



                        <div class="col-md-6">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Produto</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbProdutosPesquisaModal" name="cbProdutosPesquisaModal"></select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomeProdutoModal" id="edNomeProdutoModal"  value="">

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Código Nota</label>

                                            <input type="text" class="form-control" name="edCodigoNotaModal" id="edCodigoNotaModal">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Porcentagem</label>

                                            <input type="text" class="form-control" name="edPorcentagemProdutoModal" id="edPorcentagemProdutoModal">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Fornecedor</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbCodigoFornecedorModal" id="cbCodigoFornecedorModal"></select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarProdutosModal" id="edEditarProdutosModal" value="N">

                <input type="hidden" name="edCodigoProdutosModal" id="edCodigoProdutosModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroProduto" onclick="app.salvaProduto($('#formProduto').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalProduto()">Limpar</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalCadastroStatusNota" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalCadastroStatusNotaLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formCadastroStatus" id="formCadastroStatus" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-12">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Status</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbCadastroStatusModal" name="cbCadastroStatusModal"></select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Status</label>

                                            <input type="text" class="form-control" name="edCadastroStatusModal" id="edCadastroStatusModal" value="">

                                        </div>

                                    </div>

                                </div>  

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarCadastroStatusModal" id="edEditarCadastroStatusModal" value="N">

                <input type="hidden" name="edCodigoCadastroStatusModal" id="edCodigoCadastroStatusModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroStatus" onclick="app.salvaCadastroStatus($('#formCadastroStatus').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalCadastroStatus()">Limpar</button>

                    <button type="button" class="btn btn-info" id="btnExcluiCadastroStatus" onclick="app.excluiStatusModal($('#edCodigoCadastroStatusModal').val())" disabled>Excluir</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalCadastroCaminhoes" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalCaminhoesLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formCaminhao" id="formCaminhao" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-12">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Nome</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbCaminhaoModal" name="cbCaminhaoModal"></select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomeCaminhaoModal" id="edNomeCaminhaoModal" value="">

                                        </div>

                                    </div>



                                    <div class="col-md-3">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Placa</label>

                                            <input type="text" class="form-control" name="edPlacaCaminhaoModal" id="edPlacaCaminhaoModal" value="">

                                        </div>

                                    </div>

                                    

                                    <div class="col-md-3">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Situação</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbSituacaoCaminhaoModal" id="cbSituacaoCaminhaoModal">

                                                <option value="A" selected>Ativo</option>

                                                <option value="I">Inativo</option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarCaminhaoModal" id="edEditarCaminhaoModal" value="N">

                <input type="hidden" name="edCodigoCaminhaoModal" id="edCodigoCaminhaoModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroCaminhao" onclick="app.salvaCaminhao($('#formCaminhao').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalCaminhao()">Limpar</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalCadastroMotoristaAjudante" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalMotoristaAjudanteLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formMotoristaAjudante" id="formMotoristaAjudante" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-12">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Nome</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbMotoristaAjudanteModal" name="cbMotoristaAjudanteModal"></select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomeMotoristaAjudanteModal" id="edNomeMotoristaAjudanteModal" value="">

                                        </div>

                                    </div>



                                    <div class="col-md-3">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Função</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbFuncaoMotoristaAjudanteModal" id="cbFuncaoMotoristaAjudanteModal">

                                                <option value="M" selected>Motorista</option>

                                                <option value="A">Ajudante</option>

                                            </select>

                                        </div>

                                    </div>

                                    

                                    <div class="col-md-3">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Situação</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbSituacaoMotoristaAjudanteModal" id="cbSituacaoMotoristaAjudanteModal">

                                                <option value="A" selected>Ativo</option>

                                                <option value="I">Inativo</option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarMotoristaAjudanteModal" id="edEditarMotoristaAjudanteModal" value="N">

                <input type="hidden" name="edCodigoMotoristaAjudanteModal" id="edCodigoMotoristaAjudanteModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroMotoristaAjudante" onclick="app.salvaMotoristaAjudante($('#formMotoristaAjudante').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalMotoristaAjudante()">Limpar</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modalCadastroPracas" style="overflow: auto !important;" tabindex="-1" role="dialog" aria-labelledby="modalPracasLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form name="formPracas" id="formPracas" action="" method="">

                <div class="modal-header">

                    <div class="row">

                        <div class="col-md-12">

                          <div class="form-group label-floating is-focused">

                              <label class="control-label">Nome</label>

                              <select class="selectpicker show-tick" data-container="body" data-style="select-with-transition" data-live-search="true" title="Selecione" id="cbPracasModal" name="cbPracasModal"></select>

                          </div>

                        </div>

                    </div>

                </div>

                <div class="modal-body">

                    <ul class="nav nav-pills nav-pills-info" role="tablist" style="margin-bottom: 15px;">

                        <li class="active">

                            <a href="#cadastro" role="tab" data-toggle="tab" aria-expanded="true">

                                <i class="fa fa-id-card-o"></i>

                                Cadastro

                            </a>

                        </li>

                    </ul>

                    <div class="content">

                        <div class="tab-content">

                            <div class="tab-pane active" id="cadastro">

                                <div class="row">

                                    <div class="col-md-9">

                                        <div class="form-group label-floating">

                                            <label class="control-label">Nome</label>

                                            <input type="text" class="form-control" name="edNomePracasModal" id="edNomePracasModal" value="">

                                        </div>

                                    </div>

                                    

                                    <div class="col-md-3">

                                        <div class="form-group label-floating is-focused">

                                            <label class="control-label">Situação</label>

                                            <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" name="cbSituacaoPracasModal" id="cbSituacaoPracasModal">

                                                <option value="A" selected>Ativo</option>

                                                <option value="I">Inativo</option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="edEditarPracasModal" id="edEditarPracasModal" value="N">

                <input type="hidden" name="edCodigoPracasModal" id="edCodigoPracasModal" value="0">

                <div class="modal-footer">

                    <button type="button" class="btn btn-info" id="btnSalvarCadastroPracas" onclick="app.salvaPracas($('#formPracas').serialize())">Salvar</button>

                    <button type="button" class="btn btn-info" onclick="app.limpaCamposModalPracas()">Limpar</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                </div>

            </form>

        </div>

    </div>

</div>







<footer class="footer">

    <div class="container-fluid">

        <div class="pull-left">

            Versão: 1.0.0

        </div>

    </div>

</footer>









