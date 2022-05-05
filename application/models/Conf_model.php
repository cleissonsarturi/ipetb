<?php 



defined('BASEPATH') OR exit('No direct script access allowed');

class Conf_model extends CI_Model {



     public function __construct(){

        parent::__construct();

        $this->load->helper('functions_helper');

        $this->load->model('App_model', 'app');

     }



 

    function carregaComboEstado(){



        $dados = array();

        $sql   = " SELECT EST_CODIGO, EST_NOME FROM estado WHERE EST_CODIGO > 0 ORDER BY EST_NOME ";

        $query = $this->db->query($sql);

        

        if ($query->num_rows() > 0){

             foreach ($query->result() as $row) {

               $dados[] = array(

                    'vId'   => $row->EST_CODIGO,

                    'vNome' => $row->EST_NOME

               );  

             }

            return $dados;

        } else {

          return null;

        }
    }

    function getComboCobrancas() {
      $dados = array();
      $sql   = " SELECT COB_CODIGO, COB_COBRANCA FROM cobranca WHERE COB_ID > 0 ORDER BY COB_COBRANCA ";
      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
           foreach ($query->result() as $row) {
             $dados[] = array(
                  'vId'   => $row->COB_CODIGO,
                  'vNome' => $row->COB_COBRANCA
             );  
           }
          return $dados;
      } else {
        return null;
      }
    }


    function getCobrancas() {

      $sql = "SELECT CONF_URL_API FROM configuracoes LIMIT 1 ";
      $query = $this->db->query($sql);

      if($query->num_rows() > 0) {
        foreach($query->result() as $row) {
          $ch = curl_init();
          $url =  $row->CONF_URL_API.'cobrancas';
           
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              
          $resp = curl_exec($ch);
    
          if($e = curl_error($ch)) {
            echo $e;
          } else {
            $decoded = json_decode($resp, true);
            foreach($decoded as $value) {
              $registros = $this->salvaCobrancas($value['CODCOB'], $value['COBRANCA']);
            }
            return $registros;
          }
        }
      }

    }

    function salvaCobrancas($codCob, $cobranca)  {
      $dados = array(
        'COB_CODIGO' => $codCob,
        'COB_COBRANCA' => $cobranca
      );

      if($this->cobrancaJaNaBase($codCob)) {
        return false;
      } else {
        $this->db->insert('cobranca', $dados);
        return true;
      }
    }

    function cobrancaJaNaBase($codCob) {
      $sql = " SELECT COB_CODIGO FROM cobranca WHERE COB_CODIGO = ?";
      $query = $this->db->query($sql, array($codCob));
      if($query->num_rows() > 0) {
        return true;
      }
    }

    function carregaEndosso() {

      $dados = array();

      $sql   = " SELECT END_VALUE, END_DESC FROM endosso WHERE END_ID > 0 ORDER BY END_DESC ";

      $query = $this->db->query($sql);

      

      if ($query->num_rows() > 0){

           foreach ($query->result() as $row) {

             $dados[] = array(

                  'vValue'   => $row->END_VALUE,

                  'vDesc' => $row->END_VALUE.' - '.$row->END_DESC

             );  

           }

          return $dados;

      } else {

        return null;

      }

    }



    function carregaMotivo() {

      $dados = array();

      $sql   = " SELECT MOT_VALUE, MOT_DESC FROM motivo WHERE MOT_ID > 0 ORDER BY MOT_DESC ";

      $query = $this->db->query($sql);

      

      if ($query->num_rows() > 0){

           foreach ($query->result() as $row) {

             $dados[] = array(

                  'vValue'   => $row->MOT_VALUE,

                  'vDesc' => $row->MOT_VALUE.' - '.$row->MOT_DESC

             );  

           }

          return $dados;

      } else {

        return null;

      }

    }



    function carregaPortador() {

      $dados = array();

      $sql   = " SELECT PORT_VALUE, PORT_DESC FROM declaracaoportador WHERE PORT_ID > 0 ORDER BY PORT_DESC ";

      $query = $this->db->query($sql);

      

      if ($query->num_rows() > 0){

           foreach ($query->result() as $row) {

             $dados[] = array(

                  'vValue'   => $row->PORT_VALUE,

                  'vDesc' => $row->PORT_VALUE.' - '.$row->PORT_DESC

             );  

           }

          return $dados;

      } else {

        return null;

      }

    }



    function carregaEspecie() {

      $dados = array();

      $sql   = " SELECT ESP_VALUE, ESP_DESC FROM especie WHERE ESP_ID > 0 ORDER BY ESP_DESC ";

      $query = $this->db->query($sql);

      

      if ($query->num_rows() > 0){

           foreach ($query->result() as $row) {

             $dados[] = array(

                  'vValue'   => $row->ESP_VALUE,

                  'vDesc' => $row->ESP_VALUE.' - '.$row->ESP_DESC

             );  

           }

          return $dados;

      } else {

        return null;

      }

    }

        

    function carregaComboCidade($idEstado){

        

        $dados = array();

        $sql   = " SELECT CID_CODIGO, CID_NOME FROM cidade WHERE EST_CODIGO = ".$idEstado." ORDER BY CID_NOME ";

        $query = $this->db->query($sql);

        

        if ($query->num_rows() > 0){

             foreach ($query->result() as $row) {

               $dados[] = array(

                    'vId'   => $row->CID_CODIGO,

                    'vNome' => $row->CID_NOME

               );  

             }

            return $dados;

        } else {

          return null;

        }

    }



	function salvarConf($form, $imagens, $endosso, $aceite, $motivo, $portador, $especie, $cobranca){

        try{



	        $values = array();

            $imagemUrl = '';



	        parse_str($form, $values);



            if(isset($imagens)) {

              foreach($imagens as $imagem) {

                  $imagemUrl = $imagem['url'];

              }

            }



			$dados = array(

			          'CONF_NOME'                      => $values['edNome'],
			          'CONF_CPF_CNPJ'                  => $values['edCpfCnpj'],
			          'CONF_ENDERECO'                  => $values['edEndereco'],
			          'CID_ID'   			                 => $values['cbCidade'],
			          'EST_ID'				                 => $values['cbEstado'],
			          'CONF_TELEFONE_1'		             => $values['edTelefone1'],
			          'CONF_TELEFONE_2'			           => $values['edTelefone2'],
			          'CONF_LOGO'		                   => $imagemUrl,
			          'CONF_IDCLIENTEI7'				       => $values['edClienteI7'],
			          'CONF_PRODI7'				             => $values['edProdI7'],
			          'CONF_DIAS_ENVIO_PROTESTO'	     => $values['edDiasEnvioProtesto'],
			          'CONF_WEB_SERVICE_IEPTB_URL'	   => $values['ieptburl'],
                'CONF_WEB_SERVICE_IEPTB_SENHA'   => $values['ieptbsenha'],
			          'CONF_WEB_SERVICE_IEPTB_USUARIO' => $values['ieptbusuario'],
                'CONF_WEB_SERVICE_WINTHOR'       => $values['edAPI'],
                'CONF_IEPTB_ENDOSSO_PADRAO'      => $endosso,
                'CONF_IEPTB_ACEITE_PADRAO'       => $aceite,
                'CONF_IEPTB_MOTIVO_PADRAO'       => $motivo,
                'CONF_IEPTB_PORTADOR_PADRAO'     => $portador,
                'CONF_IEPTB_ESPECIE_PADRAO'      => $especie,
                'CONF_COBRANCA_PADRAO'           => $cobranca

			        );  

		

		

            $this->db->update('configuracoes', $dados, array("CONF_ID" => 1));



			$id = $this->db->affected_rows();

			return ($id);



        } catch(PDOException $e) { 

           echo 'Erro: ' . $e->getMessage();

        }



	}



  function getData() {

  

      $dados = array();



      $sql = "SELECT C.CONF_ID,
                     C.CONF_NOME,
                     C.CONF_CPF_CNPJ,
                     C.CONF_ENDERECO,
                     C.CID_ID,
                     C.EST_ID,
                     C.CONF_TELEFONE_1,
                     C.CONF_TELEFONE_2,
                     C.CONF_LOGO,
                     C.CONF_IDCLIENTEI7,
                     C.CONF_PRODI7,
                     C.CONF_DIAS_ENVIO_PROTESTO,
                     C.CONF_WEB_SERVICE_IEPTB_URL,
                     C.CONF_WEB_SERVICE_IEPTB_USUARIO,
                     C.CONF_WEB_SERVICE_IEPTB_SENHA,
                     C.CONF_TOKEN_IEPTB,
                     C.CONF_DATA_CRIACAO_TOKEN,
                     C.CONF_IEPTB_ENDOSSO_PADRAO,
                     C.CONF_IEPTB_ACEITE_PADRAO, 
                     C.CONF_IEPTB_MOTIVO_PADRAO,  
                     C.CONF_IEPTB_PORTADOR_PADRAO,
                     C.CONF_IEPTB_ESPECIE_PADRAO,
                     C.CONF_WEB_SERVICE_WINTHOR,
                     C.CONF_COBRANCA_PADRAO

              FROM configuracoes C ";



      $query = $this->db->query($sql);



      if ($query->num_rows() > 0){

        foreach ($query->result() as $row) {



          $imagem[] = array(

            'cod'  => $row->CONF_ID, 
            'url' => $row->CONF_LOGO

          );  



          $dados = array(

            'id'                        => $row->CONF_ID,
            'nome'                      => $row->CONF_NOME,
            'cpfcnpj'                   => $row->CONF_CPF_CNPJ,
            'endereco'                  => $row->CONF_ENDERECO,
            'cidade'                    => $row->CID_ID,
            'estado'                    => $row->EST_ID,
            'telefone1'                 => $row->CONF_TELEFONE_1,
            'telefone2'                 => $row->CONF_TELEFONE_2,
            'logo'                      => $imagem,
            'idclientei7'               => $row->CONF_IDCLIENTEI7,
            'prodi7'                    => $row->CONF_PRODI7,
            'diasenvioprotesto'         => $row->CONF_DIAS_ENVIO_PROTESTO,
            'webservice_ieptb_url'      => $row->CONF_WEB_SERVICE_IEPTB_URL,
            'webservice_ieptb_usuario'  => $row->CONF_WEB_SERVICE_IEPTB_USUARIO,
            'webservice_ieptb_senha'    => $row->CONF_WEB_SERVICE_IEPTB_SENHA,
            'token'                     => $row->CONF_TOKEN_IEPTB,
            'datatoken'                 => $row->CONF_DATA_CRIACAO_TOKEN,
            'endosso'                   => $row->CONF_IEPTB_ENDOSSO_PADRAO,
            'aceite'                    => $row->CONF_IEPTB_ACEITE_PADRAO, 
            'motivo'                    => $row->CONF_IEPTB_MOTIVO_PADRAO,  
            'portador'                  => $row->CONF_IEPTB_PORTADOR_PADRAO,
            'especie'                   => $row->CONF_IEPTB_ESPECIE_PADRAO,
            'api'                       => $row->CONF_WEB_SERVICE_WINTHOR,
            'cobranca'                  => $row->CONF_COBRANCA_PADRAO
          );  







        }



        return $dados;

      } else {

        return null;

      }

    

  }





}



