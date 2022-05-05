<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conf extends CS_Sharp {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){
        $data['title']       = 'Configurações';
        $data['conteudo']    = 'conf';
        $data['breadcrumbs'] = array('inicio' => 'Início', 
                                     ''       => $data['title']);

                            
        $this->load->view('estrutura/template', $data);

    }

}

