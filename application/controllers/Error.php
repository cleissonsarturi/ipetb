<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index(){
        $data['title']     = 'Página não Encontrada';
        $data['header']    = array(array('titulo' => $data['title'], 'icone' => 'fa fa-chevron-right'));
        $data['conteudo']  = 'errors/404.php';
        
        $this->output->set_status_header('404');
        $this->load->view('estrutura/template', $data);
    }

}
