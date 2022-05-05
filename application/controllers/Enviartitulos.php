<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enviartitulos extends CS_Sharp {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('functions_helper');
    }

    public function index(){
        $data['title']       = 'Títulos';
        $data['conteudo']    = 'enviartitulos';
        $data['breadcrumbs'] = array('inicio' => 'Início', 
                                     ''       => $data['title']);
                                     
        $data['tabela'] = array(
                                'theadsTabela' => array(''                   => array('posicao' => 'left',   'width' => 5),
                                                        'Cliente'            => array('posicao' => 'left',   'width' => 15), 
                                                        'Data de Vencimento' => array('posicao' => 'center', 'width' => 10),
                                                        'Duplicata'          => array('posicao' => 'center', 'width' => 7),
                                                        'Prestação'          => array('posicao' => 'center', 'width' => 8),
                                                        'Valor Título'       => array('posicao' => 'center', 'width' => 10),
                                                        'Juros'              => array('posicao' => 'center', 'width' => 5),
                                                        'Multa'              => array('posicao' => 'center', 'width' => 10),
                                                        'Saldo'              => array('posicao' => 'center', 'width' => 10),
                                                        'Cond. Pgto'         => array('posicao' => 'center', 'width' => 5),
                                                        'Banco'              => array('posicao' => 'center', 'width' => 5),
                                                        'Dias Atrasados'     => array('posicao' => 'center', 'width' => 5),
                                                        'Remover'            => array('posicao' => 'center', 'width' => 5)
                                                    ),
                                'columnDefs'   => array(
                                                    array('targets' => array(0, 9, 11,12), 'orderable' => false, 'className' => 'dt-center'),
                                                    array('targets' => array(5,6,7,8),  'orderable' => false, 'className' => 'dt-body-right'),
                                                    array('targets' => array(1),  'className' => 'dt-left'),
                                                    array('targets' => array(2,3,4), 'orderable' => true, 'className' => 'dt-center')
                                                    ),
                                'ordemInicial' => array()
                            );
                            
        $this->load->view('estrutura/template', $data);
    }
}