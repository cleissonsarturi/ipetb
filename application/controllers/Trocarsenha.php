<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trocarsenha extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('functions_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Index_model', 'index');
    }

    public function index(){

        if($this->input->method() === 'post') {

            $btnLogin = $this->input->post('btnConfirmarSenha');
            $user     = $this->session->userdata('cod_user');

            if($btnLogin == "Trocar Senha"){

                $this->form_validation->set_rules('edSenhaAtual',        'Senha Atual',     'required');
                $this->form_validation->set_rules('edSenhaNova',         'Nova Senha',      'required');
                $this->form_validation->set_rules('edConfirmaSenhaNova', 'Confirmar Senha', 'required');

                if ($this->form_validation->run() == TRUE) {

                   if($user > 0){

                        $senhaAtual    = $this->input->post('edSenhaAtual');
                        $senhaNova     = $this->input->post('edSenhaNova');
                        $confirmaSenha = $this->input->post('edConfirmaSenhaNova');

                        $result = $this->index->changePassword($user, $senhaAtual, $senhaNova, $confirmaSenha);
                        if(is_numeric($result) && $result > 0){   
                            $this->session->set_flashdata('message', 'Senha alterada com sucesso.');                       
                            redirect(base_url().'login', 'refresh');
                        }else{
                            $this->session->set_flashdata('message', $result);
                            redirect(current_url(), 'refresh'); 
                        }
                    }else{
                        redirect(base_url().'login', 'refresh');
                    }
                }else{
                    redirect(current_url());
                }
            }else{
               redirect(current_url());
            }
        }

        $data['title']    = 'Trocar Senha';
        $data['conteudo'] = 'trocasenha';
        $this->load->view('estrutura/template', $data);
    }

}
