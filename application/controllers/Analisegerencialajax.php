<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisegerencialajax extends CS_Sharp {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
        $this->load->model('Analisegerencial_model', 'analiseGerencial');
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

            $registros = $this->analiseGerencial->carregaComboSupervisores($vVisaoRelatorio);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($registros));
        }
    }

    function buscaAnaliseSupervisor(){

        if($this->input->post('buscaAnaliseSupervisor') == ""){
            $vSupervisor      = $this->input->post('IdSupervisor');
            $vDataInicial     = $this->input->post('vDataInicial');
            $vDataFinal       = $this->input->post('vDataFinal');
            $vTipoRelatorio   = $this->input->post('vTipoRelatorio');
            $vVisaoRelatorio  = $this->input->post('vVisaoRelatorio');
            $vRelatorio       = $this->input->post('vRelatorio');
            
            $result = $this->analiseGerencial->buscaAnaliseSupervisor($vSupervisor, $vDataInicial, $vDataFinal, $vTipoRelatorio, $vVisaoRelatorio, $vRelatorio);
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

}
