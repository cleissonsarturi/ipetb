<div class="sidebar" data-color="blue" data-image="">

    <div class="logo">

        <a style="font-size: 16px;" href="<?php echo base_url().'inicio'; ?>" class="simple-text">

            <img src="https://i7solution.com.br/wp-content/uploads/2020/01/logo.png" width="220" alt="">

        </a>

    </div>

    <div class="sidebar-wrapper">

        <ul class="nav">



        <?php 

            $menu   = carregaMenu();

            $dataCI = array('controller' => $this->router->class,

                            'method'     => (strtolower($this->router->method) != 'index') ? $this->router->method : ''

                      );

            $tela   = ($dataCI['method'] != '') ? $dataCI['controller'].'/'.$dataCI['method'] : $dataCI['controller'];

            

            foreach ($menu as $value) {

                if($value['submenu'] == "N"){

                    $active     = (strtolower($tela) == strtolower($value['caminho'])) ? 'active' : '';

                    $open_modal = (substr($value['caminho'], 0, 1) == "#") ? 'data-toggle="modal" data-target="'.$value['caminho'].'"' : '';

                    echo "<li class='".$active."'> <a class='firstA' href='".base_url().$value['caminho']."' ".$open_modal."><i class='".$value['icone']."'></i><p>".$value['nome']."</p></a></li>";

                }else{

                          

                    if(isset($value['itensSubMenu'])){



                       

                        foreach ($value['itensSubMenu'] as $subMenu) {

                            $activeSub = (strtolower($tela) == strtolower($subMenu['subCaminho'])) ? 'active' : '';

                            if($activeSub != ""){

                                break;

                            }                            

                        }



                        if($activeSub != ""){

                            echo "<li class='".$activeSub."'>";

                        }else{

                            echo "<li>";

                        }

                        

                        $linkCollapsed = ($activeSub != "") ? " class='firstA' aria-expanded='true' " : " class='firstA collapsed' aria-expanded='false' ";

                        $divCollapsed  = ($activeSub != "") ? " class='collapse in' aria-expanded='true' " : " class='collapse' aria-expanded='false' style='height: 0px;' ";

                        echo " <a data-toggle='collapse' href='#page".$value['idMenu']."' ".$linkCollapsed."><i class='".$value['icone']."'></i><p>".$value['nome']." <b class='caret'></b></p></a>";

                        echo "  <div id='page".$value['idMenu']."' ".$divCollapsed.">";

                        echo "      <ul class='nav' style='margin-top: 5px;'>";

                      

                                foreach ($value['itensSubMenu'] as $subMenu) {

                                    $activeSub      = (strtolower($tela) == strtolower($subMenu['subCaminho'])) ? 'active' : '';

                                    $open_modal_sub = (substr($subMenu['subCaminho'], 0, 1) == "#") ? 'data-toggle="modal" data-target="'.$subMenu['subCaminho'].'"' : '';

                                    echo "<li class='".$activeSub."'> <a href='".base_url().$subMenu['subCaminho']."' ".$open_modal_sub."><span class='sidebar-normal'><i class='iconSubMenu fa fa-caret-right'></i>".$subMenu['subNome']."</span> </a></li>";

                                }



                        echo "     </ul>";

                        echo "  </div>";

                        echo "</li>";

                    }

                }

            }



        ?>

            <li class="">

                <a href="<?php echo base_url(); ?>"><i class="fa fa-sign-out"></i><p>Sair</p></a>

            </li>

        </ul>

    </div>

</div>