<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appajax extends CS_Sharp {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
        $this->load->model('App_model', 'app');
    }

    public function index(){
        redirect(base_url().'login');
    }
    
    function _remap($method){
      if (method_exists($this, $method) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $this->$method();
      }else {
        $this->index($method);
      }
    }

    /*Funções para as notificações*/
    function buscaNotificacoes(){

        if($this->input->post('Notificacoes') == ""){
            $dados = $this->app->buscaNotificacoes();
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($dados));
        }
    }
    function atualizaStatusNotificacao(){
        if($this->input->post('Notificacao') == ""){
            $codNotificacao = $this->input->post('codNotificacao');
            $lerNaoler      = $this->input->post('lerNaoler');
            $excluir        = $this->input->post('excluir');
            $result         = $this->app->atualizaStatusNotificacao($codNotificacao, $lerNaoler, $excluir);
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
        } 
    }
}
