<?php 
    $user_data = $this->session->userdata('logged_in');
?>
<nav class="navbar navbar-transparent navbar-absolute nav-top-itens">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php 
              $is_home = ($conteudo == 'inicio') ? true : false;

              if(!$is_home){
                if (isset($breadcrumbs)){
                   $total = count($breadcrumbs);
                   $breadcrumb = "";
                   foreach ($breadcrumbs as $controllers => $nomeLink) {
                     $total--;
                     $caminho = ($controllers == "inicio") ? base_url().'inicio' : base_url().$controllers; 
                     $links   = ($controllers != "") ? "<a class='navbar-brand' href='".$caminho."' style='padding: 10px 5px;'>".$nomeLink."</a>" : "<a class='navbar-brand' style='padding: 10px 5px;'>".$nomeLink."</a>";

                     if($total > 0){
                       $breadcrumb = $breadcrumb . $links .' <i class="navbar-brand fa fa-caret-right" aria-hidden="true" style="padding: 10px 5px;"></i> ';
                     }else{
                       $breadcrumb = $breadcrumb . $links;
                     }
                   }
                   echo $breadcrumb;
                }
              }else{
                echo "<a class='navbar-brand' href='#'> Bem vindo  ".$user_data['sessao_nome_user']."</a>";
              } 
            ?>
        </div>
    </div>
</nav>