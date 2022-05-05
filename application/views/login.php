
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <br><br><br><br>
      <img src="<?php echo base_url(); ?>assets/images/logos/logo-i7.svg"style="width: 200px; margin: 0 auto; display:block;" alt="logo i7">
      <h1 style="font-size: 30px; font-weight:500;" class="text-center">Seja bem Vindo</h1>
    </div>
        <div class="box" style="background: transparent !important; box-shadow: none;">
          <?php echo form_open('login'); ?>
              <div class="form-group label-floating">
                <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-envelope-o" id="edCalendarioCampoData2" style="font-size: 24px; color: #30588c;"></i>
                  </span>
                  <input type="text" class="form-control" placeholder="Usuário" name="edUsername" id="edUsername"  value="">
                </div>
              </div>
              <div class="form-group label-floating">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock" id="edCalendarioCampoData2" style="font-size: 24px;  color: #30588c;"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Senha" name="edPassword" id="edPassword"  value="">
                  </div>
              </div>
            <button id="buttonlogintoregister" style="background: #eeeeee; width:100%; color: #069dbf; border-color: #069dbf; font-size: 20px; font-weight: 800; border: 3px solid; border-radius: 5px;" type="submit" name="btnLogin" value="Logar">Login</button>
          <?php echo form_close(); 
              $message = $this->session->flashdata('message');
          ?>
        </div>

  </div>
</div>





