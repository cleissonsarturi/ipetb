<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"                  type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"                     type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/material.min.js"                      type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/jquery.easy-pie-chart.js"             type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/perfect-scrollbar.jquery.min.js"      type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/material-dashboard.js?v=1.2.0"        type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/bootbox.min.js"                       type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-select.min.js"              type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-notify.js"                  type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/jquery.loader.min.js"                 type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/jquery.maskMoney.min.js"              type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.maskedinput.min.js"            type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/moment-with-locales.min.js"           type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/bootstrap-material-datetimepicker.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"             type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js"          type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-filestyle.min.js"           type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/owl.carousel.js"                      type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.responsive.min.js"         type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/responsive.bootstrap.min.js"          type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"            type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"                type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/ckeditor/ckeditor.js"                 type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="<?php echo base_url();?>assets/js/loader.js"                            type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="<?php echo base_url();?>assets/js/app.js"                               type="text/javascript"></script> 

  <?php 
  if($conteudo == 'inicio'){
    echo "<script src='".base_url()."assets/js/viewsJs/inicio.js'></script>";
  ?>
    <script>
      var vData = '';
      $(document).ready(function() {
        app.initApp();
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        noPermission = "<?php echo (isset($noPermission)) ? $noPermission : false; ?>";
        if(noPermission){
          app.showNotification("Ops, você não tem permissão para acessar a tela solicitada", 'danger', 5);
        }
        
        msgRelatorioVazio = "<?php echo ($this->session->flashdata('msgRelatorioVazio')) ? $this->session->flashdata('msgRelatorioVazio') : ''; ?>";

        if(msgRelatorioVazio != ''){
          app.showNotification(msgRelatorioVazio, 'danger', 5);
        }

        inicio.initApp();
    

      });
    </script>
  <?php
  }
  if($conteudo == 'usuarios'){
    echo "<script src='".base_url()."assets/js/viewsJs/usuarios.js'></script>";
  ?>
    <script>
      $(document).ready(function() {
        usuarios.initConfigTela();
        usuarios.initTabelaUsuarios(columnDefs, colOrdem);
        app.initApp();
      });
    </script>
  <?php
  }
  if($conteudo == 'perfilusuario'){
    echo "<script src='".base_url()."assets/js/viewsJs/perfilusuario.js'></script>";
  ?>
    <script>
      $(document).ready(function() {
        grupos.initConfigTela();
        grupos.initTabelaGruposUsuarios(columnDefs, colOrdem);
        app.initApp();
      });
    </script>
  <?php
  }
  if($conteudo == 'titulos'){
    echo "<script src='".base_url()."assets/js/viewsJs/titulos.js'></script>";
  ?>
    <script>
      $(document).ready(function() {
        $('#cbFilial').selectpicker('val', 'null').selectpicker('render').selectpicker('refresh');
        titulos.initApp();
      });
    </script>
  <?php
  }
  if($conteudo == 'conf'){
    echo "<script src='".base_url()."assets/js/viewsJs/conf.js'></script>";
    echo "<script src='".base_url()."assets/js/fileinput.min.js' type='text/javascript'></script>";
  ?>
    <script>
      $(document).ready(function() {
        conf.carregaComboEstado();
        conf.initApp();
      });
    </script>
  <?php
  }
  if($conteudo == 'enviartitulos'){
    echo "<script src='".base_url()."assets/js/viewsJs/enviartitulos.js'></script>";
  ?>
    <script>
      $(document).ready(function() {
        enviartitulos.initTabela(columnDefs, colOrdem);
        enviartitulos.initApp();
      });
    </script>
  <?php
  }















