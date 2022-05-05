<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfilusuarioajax extends CS_Sharp {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
         $this->load->model('Perfil_model', 'perfil');
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

    function carregaGruposUsuarios(){
        if($this->input->post('CarregaGruposUsuarios') == ""){
            $registros = $this->perfil->buscaGruposCadastrados();
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($registros));
        }
    }

    function salvaGrupos(){

        if($this->input->post('SalvaGrupo') == ""){
            $form   = $this->input->post('Form');
            $result = $this->perfil->salvaGrupo($form);
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
        }
    }

    function carregaPermissoes(){

        if($this->input->post('CarregarModalPerfis') == ""){
            $perfil = $this->input->post('CodPerfil');
            $dados  = $this->perfil->buscaItensPermissoes($perfil);
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($dados));
        }
    }

    function autalizaPermissao(){

        if($this->input->post('AtivaDesativaPermissao') == ""){
            $perfil  = $this->input->post('codigoPerfil');
            $codigo  = $this->input->post('codigoTelaMenu');
            $tipo    = $this->input->post('tipo');
            $checked = $this->input->post('vCampoSelecionado');
            $result  = $this->perfil->atualizaPermissoes($perfil, $codigo, $tipo, $checked);
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
        }
    }

    function excluiPerfil(){
        if($this->input->post('ExcluiPerfil') == ""){
            $perfil = $this->input->post('CodPerfil');
            $result = $this->perfil->excluiPerfilUsusario($perfil);
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "N")));
        }
    }
}

