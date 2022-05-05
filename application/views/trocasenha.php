<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="box" style="height: 480px;">
        <div id="header">
          <div id="cont-lock"><i class="material-icons lock">lock</i></div>
          <div id="bottom-head"><h1 id="logintoregister">Trocar Senha</h1></div>
        </div> 
         <?php echo form_open('trocarsenha'); ?>
            <div class="group">      
              <input class="inputMaterial" name="edSenhaAtual"  id="edSenhaAtual" type="password" required>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Senha Atual</label>
            </div>
            <div class="group">      
              <input class="inputMaterial" name="edSenhaNova" id="edSenhaNova" type="password" required>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Nova Senha</label>
            </div>
            <div class="group">      
              <input class="inputMaterial" name="edConfirmaSenhaNova" id="edConfirmaSenhaNova" type="password" required>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Confirmar Senha</label>
            </div>
            <button id="buttonlogintoregister" type="submit" name="btnConfirmarSenha" value="Trocar Senha">Trocar Senha</button>
         <?php echo form_close(); 

          $message = $this->session->flashdata('message');

         ?>
        <div id="footer-box" style="height: 55px;">
          <p class="footer-text">
            <span class="sing-message"> 
              <?php 
                if($message != ""){
                  echo $message; 
                }else{
                  ?>
                    <a href="http://cssharp.com.br" target="_blank">
                        <span class="cssharp"><label class="cs cs_label">CS</label><label class="sharp2 cs_label">SHARP</label></span>
                        <img style="position: relative !important; top:-7px !important" src="<?php echo base_url();?>assets/images/logo_footer.jpg" width="22" height="22">
                    </a> 
                  <?php
                }
              ?>
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>




