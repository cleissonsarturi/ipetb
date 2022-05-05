<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfilusuario extends CS_Sharp {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){
        $data['title']    = 'Cadastro de Grupos';
        $data['conteudo'] = 'perfilusuario';
        $data['breadcrumbs'] = array('inicio' => 'Início', 
                                     ''       => $data['title']);

        $data['tabelaGrupoUsuario'] = array(
                                        'theadsTabela' => array('Código'        => array('posicao' => 'left',   'width' => 20), 
                                                                'Nome do Grupo' => array('posicao' => 'center', 'width' => 65), 
                                                                'Ações'         => array('posicao' => 'center', 'width' => 15)
                                                          ),

                                        'columnDefs'   => array(
                                                            array('targets' => array(0), 'className' => 'dt-center'),
                                                            array('targets' => array(2), 'orderable' => false, 'className' => 'dt-center')
                                                          ),

                                        'ordemInicial' => array()
                                      );

        $this->load->view('estrutura/template', $data);
    }
}

