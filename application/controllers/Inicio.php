<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CS_Sharp {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){
        $data['title']    = 'Início';
        $data['conteudo'] = 'inicio';

        if($this->session->flashdata('noPermission')) {
            $data['noPermission'] = true;
        }
 
        $this->load->view('estrutura/template', $data);
    }

}
