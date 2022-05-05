<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CS_Sharp {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){
        $data['title']    = 'Cadastro de Usuarios';
        $data['conteudo'] = 'usuarios';
        $data['breadcrumbs'] = array('inicio' => 'Início', 
                                     ''       => $data['title']);

        $data['tabelaUsuarios'] = array(
                                    'theadsTabela' => array('Nome'     => array('posicao' => 'left',   'width' => 50), 
                                                            'Grupo'    => array('posicao' => 'center', 'width' => 20), 
                                                            'Situação' => array('posicao' => 'center', 'width' => 15), 
                                                            'Ação'     => array('posicao' => 'center', 'width' => 15)
                                                      ),

                                    'columnDefs'   => array(
                                                        array('targets' => array(1),   'className' => 'dt-center'),
                                                        array('targets' => array(2,3), 'orderable' => false, 'className' => 'dt-center')
                                                      ),

                                    'ordemInicial' => array()
                                );

        $user_data = $this->session->userdata('logged_in');
        $data['responsavel'] = $user_data['sessao_nome_user'];
        $this->load->view('estrutura/template', $data);
    }
}
