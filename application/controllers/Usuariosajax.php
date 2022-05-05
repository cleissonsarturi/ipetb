<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuariosajax extends CS_Sharp {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('functions_helper');
        $this->load->model('Usuarios_model', 'user');
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

    function carregaUsuarios(){
        if($this->input->post('CarregaUsuarios') == ""){
            $registros = $this->user->buscaUsuariosCadastrados();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($registros));
        }
    }

    function salvaUsuario(){

        if($this->input->post('SalvaUsuario') == ""){
            $form   = $this->input->post('Form');
            $responsavel = $this->input->post('responsavel');
            $result = $this->user->salvaUsuario($form, $responsavel);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
        }
    }

    function carregaComboGrupos(){
        if($this->input->post('CarregaComboGrupos') == ""){
            $dados  = $this->user->buscaGruposUsuario();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($dados));
        }
    }

    function carregaDadosUsuario(){
        if($this->input->post('DadosUsuario') == ""){
            $usuario = $this->input->post('usuario');
            $dados   = $this->user->buscaDadosUsuario($usuario);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($dados));
        }
    }

    function excluiUsuario(){
        if($this->input->post('ExcluiUsuario') == ""){
            $usuario = $this->input->post('codUsuario');
            $result  = $this->user->excluiUsuario($usuario);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
        }
    }
}
