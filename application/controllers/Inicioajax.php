<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicioajax extends CS_Sharp {
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('functions_helper');
    $this->load->model('Index_model', 'inicio');
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

  function buscaDados(){
    if($this->input->post('BuscaDados') == ""){
        
      $vData = $this->input->post('data');

      $registros = $this->inicio->buscaDados($vData);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($registros));
    }
  }

  function buscaQtdDados() {
    if($this->input->post('BuscaQtdDados') == ""){
        
        $vTipo = $this->input->post('tipo');
        $vData = $this->input->post('data');
  
        $registros = $this->inicio->buscaQtdDados($vTipo, $vData);
        $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($registros));
      }
  }

  function getMesAnoAtual() {
      if($this->input->post('getMesAnoAtual') == "") {
        $data = date('m/Y');
    
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
    }
  }

  function buscaDadosEnviados() {
    if($this->input->post('buscaDadosEnviados') == ""){
        
        $vData = $this->input->post('data');
  
        $registros = $this->inicio->buscaDados('E', $vData);
        $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($registros));
      }
  }

  function buscaDadosPagos() {
    if($this->input->post('buscaDadosPagos') == ""){
        
        $vData = $this->input->post('data');
  
        $registros = $this->inicio->buscaDados('P', $vData);
        $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($registros));
      }
  }

  function buscaDadosEmAberto() {
    if($this->input->post('buscaDadosEmAberto') == ""){
        
        $vData = $this->input->post('data');
  
        $registros = $this->inicio->buscaDados('A', $vData);
        $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($registros));
      }
  }

  function atualizaData() {
    if($this->input->post('AtualizaData') == ""){
        
        $vData = $this->input->post('data');
	
        $vMes = substr($vData, 0, -5);
		    $vAno = substr($vData, 3);

        $vMesString = transformaMesParaPortugeus($vMes);
  
        $registros = array('mes' => $vMesString, 'ano' => $vAno);
        $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($registros));
    }
  }

}

