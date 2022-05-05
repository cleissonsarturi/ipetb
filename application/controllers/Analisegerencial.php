<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisegerencial extends CS_Sharp {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){

        $data['title']       = 'Gerencial';
        $data['conteudo']    = 'analisegerencial';
        $data['breadcrumbs'] = array('inicio' => 'Início', 
                                     ''       => $data['title']);


        $this->load->view('estrutura/template', $data);
    }
}
