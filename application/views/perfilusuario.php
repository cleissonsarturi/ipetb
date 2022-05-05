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
                        <h4 class="title">Grupos Cadastrados</h4>
                        <p class="category">Clique no lápis para editar</p>
                    </div>

                    <div class="card-content table-responsive">
                      <table id="tabelaGrupoUsuario" class="table table-bordered dt-responsive display nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                <?php 
                                  if(isset($tabelaGrupoUsuario)){
                                    foreach ($tabelaGrupoUsuario as $key => $value) {
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
                    <h4 class="title">Dados do Grupo</h4>
                    <p class="category">Preencha os campos abaixo</p>
                  </div>
                  <div class="card-content">
                      <form name="formGrupo" id="formGrupo" action="" method="">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Nome do Grupo</label>
                                      <input type="text" class="form-control" name="edNomeGrupo" id="edNomeGrupo"  value="">
                                  </div>
                              </div>
                          </div>

                          <button type="button" class="btn btn-info pull-right" id="btnLimparGrupoUsusario" name="btnLimparGrupoUsusario" onclick="grupos.limpaAtivaCamposGrupos()">Cancelar</button>
                          <button type="button" class="btn btn-info pull-right" id="btnSalvarGrupoUsuario" name="btnSalvarGrupoUsuario" onclick="grupos.salvarCadastro($('#formGrupo').serialize())">Salvar</button>
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

<div class="modal fade" id="modalGruposUsuarios" tabindex="-1" role="dialog" aria-labelledby="modalGruposUsuariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalGruposUsuariosLabel">Definir Permissões do Grupo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <span id="ConteudoModalGruposUsuarios"></span>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<?php
  $conf         = array();
  $colOrdem     = array();
  $arrayDefs    = json_encode(array());
  $arrayOrdem   = json_encode(array());

  if(isset($tabelaGrupoUsuario)){
    foreach ($tabelaGrupoUsuario as $key => $value) {
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
  var columnDefs  = [];
  var colOrdem    = [];

  columnDefs = <?php echo $arrayDefs; ?>;
  colOrdem   = <?php echo $arrayOrdem; ?>;
</script>