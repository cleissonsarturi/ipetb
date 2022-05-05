<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titulosajax extends CS_Sharp {
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('functions_helper');
    $this->load->model('Titulos_model', 'titulos');
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

  function atualizarStatus() {
    if($this->input->post('AtualizarStatus') !== '') {
      $registros = $this->titulos->atualizarStatus();

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($registros));
    }
  }

  function getCaixasMoedas() {
    if($this->input->post('getCaixasMoedas') == ""){
      $dados  = $this->titulos->getMoedas();
      $dados2  = $this->titulos->getCaixas();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }
  function carregaTitulos(){
    if($this->input->post('CarregaTitulos') == ""){
        
      $vFilial      = $this->input->post('vFilial');
      $vCliente     = $this->input->post('vCliente');
      $vStatus      = $this->input->post('vStatus');
      $vPracaCob    = $this->input->post('vPracaCob');
      $vVendedor    = $this->input->post('vVendedor');
      $tipoData     = $this->input->post('vTipoData');
      $vDataInicial = $this->input->post('vDataInicial');
      $vDataFinal   = $this->input->post('vDataFinal');
      
      $registros = $this->titulos->buscaTitulos($vFilial, $vCliente, $vStatus, $vPracaCob, $vVendedor, $tipoData, $vDataInicial, $vDataFinal);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($registros));
    }
  }

  function CarregaComboFilial(){
    if($this->input->post('CarregaComboFilial') == ""){
      $dados  = $this->titulos->CarregaComboFilial();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaComboUsuariosWinthor(){
    if($this->input->post('CarregaComboUsuariosWinthor') == ""){
      $dados  = $this->titulos->carregaComboUsuariosWinthor();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function baixarWinthor(){
    if($this->input->post('BaixarWinthor') == ""){
      $usuario = $this->input->post('usuario');
      $usuarioNome = $this->input->post('usuarioNome');
      $moeda = $this->input->post('moeda');
      $moedaNome = $this->input->post('moedaNome');
      $caixa = $this->input->post('caixa');
      $caixaNome = $this->input->post('caixaNome');
      $titulosPagos = $this->input->post('titulosPagos');

      $dados  = $this->titulos->baixarWinthor($usuario, $usuarioNome, $moeda, $moedaNome, $caixa, $caixaNome, $titulosPagos);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function cancelaProtesto(){
    if($this->input->post('CancelaProtesto') == ""){

      $titulosProtestados = $this->input->post('titulosProtestados');
      
      $dados  = $this->titulos->cancelaProtesto($titulosProtestados);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaComboMoeda(){
    if($this->input->post('CarregaComboMoeda') == ""){
      $dados  = $this->titulos->carregaComboMoeda();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaComboCaixa(){
    if($this->input->post('CarregaComboCaixa') == ""){
      $dados  = $this->titulos->carregaComboCaixa();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaComboCliente(){
    if($this->input->post('carregaComboCliente') == ""){
      $dados  = $this->titulos->carregaComboCliente();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }
  
  function carregaComboStatusTitulo(){
    if($this->input->post('carregaComboStatusTitulo') == ""){
      $dados  = $this->titulos->carregaComboStatusTitulo();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function carregaComboPracaCobranca(){
    if($this->input->post('carregaComboPracaCobranca') == ""){
      $dados  = $this->titulos->carregaComboPracaCobranca();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }
  
  function carregaComboVendedores(){
    if($this->input->post('carregaComboVendedores') == ""){
      $dados  = $this->titulos->carregaComboVendedores();
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
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
  
  function modalInfo() {
    if($this->input->post('ModalInfo') == ""){
      $id = $this->input->post('id');
      $dados   = $this->titulos->modalInfo($id);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function isPago(){
    if($this->input->post('IsPago') == ""){
      $id = $this->input->post('id');
      $dados  = $this->titulos->isPago($id);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

  function buscaStatusTitulos(){
    if($this->input->post('buscaStatusTitulos') == ""){
      $dados   = $this->titulos->buscaStatusTitulos();
      
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($dados));
    }
  }

}

