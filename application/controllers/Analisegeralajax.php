<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisegeralajax extends CS_Sharp {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
        $this->load->model('Analisegeral_model', 'analiseGeral');
    }

    public function index(){
        redirect(base_url().'login');
    }

    function _remap($method){
        if (method_exists($this, $method) && $_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->$method();
        } else {
            $this->index($method);
        }
    }

    function carregaComboSupervisores(){
        if($this->input->post('carregaComboSupervisores') == ""){
            
            $vVisaoRelatorio  = $this->input->post('vVisaoRelatorio');

            $registros = $this->analiseGeral->carregaComboSupervisores($vVisaoRelatorio);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($registros));
        }
    }

    function exportatxt(){

        if($this->input->post('exportatxt') == ""){
            $vDataInicial     = $this->input->post('vDataInicial');
            $vDataFinal       = $this->input->post('vDataFinal');
            $vTipoRelatorio   = $this->input->post('vTipoRelatorio');
            
            $result = $this->analiseGeral->exportatxt($vDataInicial, $vDataFinal, $vTipoRelatorio);
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    function buscaAnaliseSupervisor(){

        if($this->input->post('buscaAnaliseSupervisor') == ""){
            $vSupervisor      = $this->input->post('IdSupervisor');
            $vDataInicial     = $this->input->post('vDataInicial');
            $vDataFinal       = $this->input->post('vDataFinal');
            $vTipoRelatorio   = $this->input->post('vTipoRelatorio');
            $vVisaoRelatorio  = $this->input->post('vVisaoRelatorio');
            
            $result = $this->analiseGeral->buscaAnaliseSupervisor($vSupervisor, $vDataInicial, $vDataFinal, $vTipoRelatorio, $vVisaoRelatorio);
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

}
