<div class="wrapper">
    <?php $this->load->view('estrutura/menu'); ?>
    <div class="main-panel">
      <?php $this->load->view('estrutura/nav'); ?>
      <div class="content">
    		<div class="container-fluid">
          <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Usuários Cadastrados</h4>
                        <p class="category">Clique no lápis para editar</p>
                    </div>

                    <div class="card-content table-responsive">
                      <table id="tabelaUsuarios" class="table table-bordered dt-responsive display nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                <?php 
                                  if(isset($tabelaUsuarios)){
                                    foreach ($tabelaUsuarios as $key => $value) {
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

            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="blue">
                    <h4 class="title">Dados do Usuário</h4>
                    <p class="category">Preencha os campos abaixo</p>
                  </div>
                  <div class="card-content">
                      <form name="formUsuarios" id="formUsuarios" action="" method="">
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Nome</label>
                                      <input type="text" class="form-control" name="edNomeUsuario" id="edNomeUsuario"  value="">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group label-floating">
                                      <label class="control-label">E-mail</label>
                                      <input type="text" class="form-control" name="edEmailUsuario" id="edEmailUsuario"  value="">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group label-floating is-focused">
                                      <label class="control-label">Grupo de Usuário</label>
                                      <select class="selectpicker show-tick editaCategoria" data-style="select-with-transition" title="Selecione" id="cbGrupoUsuario" name="cbGrupoUsuario"></select>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Login</label>
                                      <input type="text" class="form-control" name="edLoginUsuario" id="edLoginUsuario"  value="">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Senha</label>
                                      <input type="password" class="form-control" name="edSenhaUsuario" id="edSenhaUsuario"  value="">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Confirmar Senha</label>
                                      <input type="password" class="form-control" name="edConfirmaSenhaUsuario" id="edConfirmaSenhaUsuario"  value="">
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Alterar a senha ao logar</label>
                                      <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" id="cbAlterarSenhaUsuario" name="cbAlterarSenhaUsuario">
                                        <option value="S" selected>Sim</option>
                                        <option value="N">Não</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Situação do Usuário</label>
                                      <select class="selectpicker show-tick" data-style="select-with-transition" title="Selecione" id="cbSituacaoUsuario" name="cbSituacaoUsuario">
                                        <option value="A" selected>Ativo</option>
                                        <option value="I">Inativo</option>
                                      </select>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Responsável pelo Cadastro</label>
                                      <input type="text" class="form-control" name="edResponsavelUsuario" id="edResponsavelUsuario"  value="<?php echo $responsavel; ?>" disabled>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group label-floating">
                                  <label class="control-label">Código do Usuário no Winthor</label>
                                  <input type="text" class="form-control" name="edIdWinthor" id="edIdWinthor">
                                </div>
                              </div>
                          </div>
    
                          <button type="button" class="btn btn-info pull-right" id="btnLimparUsuario" name="btnLimparUsuario" onclick="usuarios.limpaAtivaCamposUsuarios()">Cancelar</button>
                          <button type="button" class="btn btn-secondary pull-right" id="btnExcluirUsuario" name="btnExcluirUsuario" onclick="usuarios.excluiUsuario($('#edCodigo').val())">Excluir</button>
                          <button type="button" class="btn btn-info pull-right" id="btnSalvarUsuario" name="btnSalvarUsuario" onclick="usuarios.salvarCadastro($('#formUsuarios').serialize())">Salvar</button>

                          <input type="hidden" name="edEditar" id="edEditar" value="N">
                          <input type="hidden" name="edCodigo" id="edCodigo">
                          <div class="clearfix"></div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
    		</div>
      </div>

      <?php $this->load->view('estrutura/footer'); ?>
    </div>
</div>

<?php
  $conf         = array();
  $colOrdem     = array();
  $arrayDefs    = json_encode(array());
  $arrayOrdem   = json_encode(array());

  if(isset($tabelaUsuarios)){
    foreach ($tabelaUsuarios as $key => $value) {
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
  responsavel = "<?php echo $responsavel; ?>";
</script>