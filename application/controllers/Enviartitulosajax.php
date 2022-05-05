<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enviartitulosajax extends CS_Sharp {
  public function __construct() {
      parent::__construct();
      $this->load->helper('url');
      $this->load->helper('functions_helper');
      $this->load->model('Enviartitulos_model', 'titulos');
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

  function carregaTitulos(){
    if($this->input->post('CarregaTitulos') == ""){
      if($this->input->post('caixa') != '') {
        $caixa = $this->input->post('caixa');
        $registros = $this->titulos->carregaTitulos($caixa);
      } else {
        $registros = $this->titulos->carregaTitulos();
      }
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($registros));
    }
  }

  function BuscaDadosWinthor(){
    if($this->input->post('BuscaDadosWinthor') == ""){
      $dados   = $this->titulos->BuscaDadosWinthor();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function BuscaConfiguracoesPadrao(){
    if($this->input->post('BuscaConfiguracoesPadrao') == ""){
      $dados   = $this->titulos->BuscaConfiguracoesPadrao();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }
  
  function excluiTituloParaNaoEnviarProCartorio(){
    if($this->input->post('excluiTituloParaNaoEnviarProCartorio') == ""){
      $idTitulo = $this->input->post('idTitulo');
      $result  = $this->titulos->excluiTituloParaNaoEnviarProCartorio($idTitulo);
      
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
    }
  }

  function EnviaTitulosParaIEPTB(){
    if($this->input->post('EnviaTitulosParaIEPTB') == ""){
      $titulos = $this->input->post('titulos');
      $dados   = $this->titulos->EnviaTitulosParaIEPTB($titulos);
      
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaEndosso(){
    if($this->input->post('carregaEndosso') == ""){
      $dados  = $this->titulos->carregaEndosso();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaMotivo(){
    if($this->input->post('carregaMotivo') == ""){
      $dados  = $this->titulos->carregaMotivo();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaPortador(){
    if($this->input->post('carregaPortador') == ""){
      $dados  = $this->titulos->carregaPortador();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaEspecie(){
    if($this->input->post('carregaEspecie') == ""){
      $dados  = $this->titulos->carregaEspecie();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function AtualizaInformacoesTitulos(){
    if($this->input->post('AtualizaInformacoesTitulos') == ""){
      $vEndosso  = $this->input->post('vEndosso');
      $vMotivo   = $this->input->post('vMotivo');
      $vAceite   = $this->input->post('vAceite');
      $vPortador = $this->input->post('vPortador');
      $vEspecie  = $this->input->post('vEspecie');
      $vTitulos  = $this->input->post('vTitulos');

      $dados   = $this->titulos->AtualizaInformacoesTitulos($vEndosso, $vMotivo, $vAceite, $vPortador, $vEspecie, $vTitulos);
      
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }
  
  
  
  
  
  
  

}

