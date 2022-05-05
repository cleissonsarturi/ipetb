<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titulos extends CS_Sharp {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){
        $data['title']       = 'Títulos';
        $data['conteudo']    = 'titulos';
        $data['breadcrumbs'] = array('inicio' => 'Início', 
                                     ''       => $data['title']);

        $data['tabela'] = array(
                                'theadsTabela' => array('' => array('posicao' => 'left',   'width' => 5),
                                                        'Nosso Número'        => array('posicao' => 'center', 'width' => 8), 
                                                        'Numtransvenda'       => array('posicao' => 'center', 'width' => 4), 
                                                        'Filial'              => array('posicao' => 'center', 'width' => 4), 
                                                        'Cliente'             => array('posicao' => 'left',   'width' => 30), 
                                                        'Data de Vencimento'  => array('posicao' => 'center', 'width' => 12),
                                                        'Duplicata'           => array('posicao' => 'center', 'width' => 8),
                                                        'Prestação'           => array('posicao' => 'center', 'width' => 8),
                                                        'Valor Total'         => array('posicao' => 'center', 'width' => 8),
                                                        'Status IEPTB'        => array('posicao' => 'center', 'width' => 8),
                                                        'Informações'         => array('posicao' => 'center', 'width' => 5)
                                                    ),
                                'columnDefs'   => array(
                                                    array('targets' => array(0,1,2,3), 'orderable' => false, 'className' => 'dt-center'),
                                                    array('targets' => array(4),  'className' => 'dt-left'),
                                                    array('targets' => array(5,6,7,8, 9, 10), 'orderable' => false, 'className' => 'dt-center')
                                                    ),
                                'ordemInicial' => array()
                            );
                            
        $this->load->view('estrutura/template', $data);

    }

}

