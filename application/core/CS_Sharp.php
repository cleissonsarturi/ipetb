<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CS_Sharp extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('Index_model', 'index');

        $user_data = $this->session->userdata('logged_in');

        if($user_data){
            $dataCI = array('controller' => $this->router->class,
                            'method'     => (strtolower($this->router->method) != 'index') ? $this->router->method : ''
                      );
            // aqui onde permite o acesso de cada tela
            $permissed = array('appajax', 'perfilusuarioajax', 'usuariosajax', 'titulosajax', 'enviartitulosajax', 'confajax', 'inicioajax');
            
            if(!in_array(strtolower($dataCI['controller']), $permissed)){
                $hasPermission = $this->index->auth($user_data['sessao_cod_perfil'], $dataCI);
                
                if(!$hasPermission){
                    $this->session->set_flashdata('noPermission', true);
                    redirect('inicio', 'refresh');
                }
            }
        }else{
            redirect('login', 'refresh');
        }

    }

}
