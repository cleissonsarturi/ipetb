<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends CI_Controller {



    public function __construct() {

        parent::__construct();



        $this->session->unset_userdata('cod_user');

        $this->session->unset_userdata('logged_in');



        $this->load->helper('url');

        $this->load->helper('functions_helper');

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->load->library('session');

        $this->load->model('Index_model', 'index');

    }



    public function index(){



        if($this->input->method() === 'post') {



            $btnLogin = $this->input->post('btnLogin');





            if($btnLogin == "Logar"){



                $this->form_validation->set_rules('edUsername', 'Usuário', 'required');

                $this->form_validation->set_rules('edPassword', 'Senha',   'required');



                if ($this->form_validation->run() == TRUE) {



                    $data = array(

                        'username' => $this->input->post('edUsername'),

                        'password' => $this->input->post('edPassword')

                    );

                    $result = $this->index->login($data);

                    

                    if (isset($result)) {



                        if($result['trocaSenha'] == 'N'){

                            $session_data = array(
                                'sessao_cod_user'     => $result['cod'],
                                'sessao_usuario_user' => $result['usuario'],
                                'sessao_nome_user'    => $result['nome'],
                                'sessao_cod_perfil'   => $result['codPerfil'],
                                'sessao_nome_perfil'  => $result['nomePerfil'],
                                'sessao_id_winthor'   => $result['idWinthor']
                            );



                            $this->session->set_userdata('logged_in', $session_data);

                            redirect(base_url().'inicio');

                        }else{

                            $this->session->set_userdata('cod_user', $result['cod']);

                            redirect(base_url().'trocarsenha', 'refresh');

                        }



                    } else {

                        $this->session->set_flashdata('message', 'Usuário ou Senha inválidos');

                        redirect(current_url(), 'refresh');

                    }

                }else{

                    redirect(current_url(), 'refresh');

                }

            }else{

               redirect(current_url(), 'refresh');

            }

        }





        $data['title']    = 'Login';
        $data['conteudo'] = 'login';

        $this->load->view('estrutura/template', $data);

    }



}

