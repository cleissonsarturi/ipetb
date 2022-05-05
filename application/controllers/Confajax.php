<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Confajax extends CS_Sharp {
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('functions_helper');
    $this->load->model('Conf_model', 'conf');
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

  function getCobrancas() {
    if($this->input->post('getCobrancas') == ""){
      $dados  = $this->conf->getCobrancas();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function getComboCobrancas() {
    if($this->input->post('getComboCobrancas') == '') {
      $dados  = $this->conf->getComboCobrancas();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }  
  }

  function carregaComboEstado(){
    if($this->input->post('carregaComboEstado') == ""){
      $dados  = $this->conf->carregaComboEstado();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaEndosso(){
    if($this->input->post('carregaEndosso') == ""){
      $dados  = $this->conf->carregaEndosso();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaMotivo(){
    if($this->input->post('carregaMotivo') == ""){
      $dados  = $this->conf->carregaMotivo();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaPortador(){
    if($this->input->post('carregaPortador') == ""){
      $dados  = $this->conf->carregaPortador();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaEspecie(){
    if($this->input->post('carregaEspecie') == ""){
      $dados  = $this->conf->carregaEspecie();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaComboCidade(){
    if($this->input->post('carregaComboCidade') == ""){
      $idEstado = $this->input->post('idEstado');
      $dados  = $this->conf->carregaComboCidade($idEstado);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function salvarConf(){
    if($this->input->post('salvarConf') == ""){
      $form      = $this->input->post('Form');
      $imagens   = $this->input->post('imagens');
      $endosso   =  $this->input->post('endosso');
      $aceite    =  $this->input->post('aceite');
      $motivo    =  $this->input->post('motivo');
      $portador  =  $this->input->post('portador');
      $especie   = $this->input->post('especie');
      $cobranca  = $this->input->post('cobranca');
      $result    = $this->conf->salvarConf($form, $imagens, $endosso, $aceite, $motivo, $portador, $especie, $cobranca);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
    }
  }

  function getData(){
    if($this->input->post('GetData') == ""){
      $result  = $this->conf->getData();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }
  }

  function imageUpload(){
    $imagens = array();
    if($_FILES["edImagens"]["name"] != '') {
      $output = '';
      $config["upload_path"] = 'assets/images/logos/';
      $config["allowed_types"] = 'gif|jpg|png|jpeg';

      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      for($count = 0; $count<count($_FILES["edImagens"]["name"]); $count++) {

        $_FILES["file"]["name"]     = md5($_FILES["edImagens"]["name"][$count].date('Y-m-d H:i:s')).$_FILES["edImagens"]["name"][$count];
        $_FILES["file"]["type"]     = $_FILES["edImagens"]["type"][$count];
        $_FILES["file"]["tmp_name"] = $_FILES["edImagens"]["tmp_name"][$count];
        $_FILES["file"]["error"]    = $_FILES["edImagens"]["error"][$count];
        $_FILES["file"]["size"]     = $_FILES["edImagens"]["size"][$count];

        if($this->upload->do_upload('file')) {

          $data = $this->upload->data();
          $dir = 'assets/images/logos/'.str_replace(' ', '_', md5($_FILES["edImagens"]["name"][$count].date('Y-m-d H:i:s')).$_FILES["edImagens"]["name"][$count]);

          if($this->input->post('qtImagem') > 0) {
            $codImg = $this->input->post('qtImagem') + ($count + 1);
          } else {
            $codImg = $count;
          }

          $imagens[] = array(
            "cod" => $codImg,
            "url" => $dir
          );
        }
      }

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($imagens));   
    }
  }
}



