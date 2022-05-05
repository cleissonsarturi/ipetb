<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Titulos_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->helper('functions_helper');
        $this->load->model('App_model', 'app');
    }

	function buscaTitulos($vFiliais, $vCliente, $vStatus, $vPracaCob, $vVendedor, $tipoData, $vDataInicial, $vDataFinal){

		$tabela = 'titulos';
		$requestData = $_REQUEST;
	    try{

            $columns = array(
				0 => '',
				1 => 'TIT_NUMTRANSVENDA',
				2 => 'TIT_FILIAL',
				3 => 'TIT_NUMERO_TITULO_WINTHOR',
				4 => 'TIT_CLIENTE',
				5 => 'TIT_PRESTACAO',
				6 => 'TIT_DUPLICATA',
				7 => 'TIT_VALOR',
				8 => 'TIT_DATA_VENCIMENTO',
				9 => 'TIT_STATUS_ENVIO',
				10 => ''
			);


		// Monta os filtros sql

		
		if($vStatus == 'null') {
			$vSQLStatus = '';
		} else {
			$vSQLStatus = ' AND TIT_STATUS_IEPTB = "'.$vStatus.'" ';

		}

		if ($vCliente == 'null') {
			$vSQLCliente = '';
		} else {
			$vSQLCliente = ' AND TIT_ID_CLIENTE = '.$vCliente.' ';
		}

		if($vFiliais != null and $vFiliais != '' and $vFiliais != 0) {
			foreach($vFiliais as $vFilial) {
	
				if ($vFilial == 'null') {
					$todas = true;
				} else {
					$todas = false;
				}
			}
			
			if($todas) {
				$vSQLFilial = '';
			} else {
				$vSQLFilial = ' AND TIT_FILIAL  IN('.implode(',', $vFiliais).')';
			}
			
		} else {
			$vSQLFilial = '';
		}

		if ($vVendedor == 'null') {
			$vSQLVendedor = '';
		} else {
			$vSQLVendedor = ' AND C.CLI_RCA_ID = '.$vVendedor.' ';
		}


		$vDataInicial = formataData($vDataInicial, '-', '/');
		$vDataFinal   = formataData($vDataFinal, '-', '/');

		$concatenaData = "";
		
		if($tipoData == 'DT') {
			$concatenaData .= "(TIT_DATA_VENCIMENTO BETWEEN '".$vDataInicial."' AND '".$vDataFinal."')";
		} else if($tipoData == 'DE') {
			$concatenaData .= "(TIT_DATA_ENVIO BETWEEN '".$vDataInicial."' AND '".$vDataFinal."')";
		} else if($tipoData == 'DP'){
			$concatenaData .= "(TIT_DATA_PAGAMENTO BETWEEN '".$vDataInicial."' AND '".$vDataFinal."')";
		} else if($tipoData == 'DB'){
			$concatenaData .= "(TIT_DATA_BAIXA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."')";
		}

		//Atualiza Status

		$sql_status = "SELECT  TIT_ID,
							   TIT_NUMTRANSVENDA,
							   TIT_FILIAL,
							   TIT_ID_CLIENTE,
							   TIT_NUMERO_TITULO_WINTHOR, 
							   TIT_NUMERO_TITULO_IEPTB,
							   TIT_CLIENTE, 
							   DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
							   format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
							   TIT_DUPLICATA, 
							   TIT_PRESTACAO, 
							   TIT_STATUS_ENVIO,
							   TIT_STATUS_IEPTB,
							   C.CLI_CPF_CNPJ,
							   TIT_ESPECIE,
							   C.CLI_RCA_ID

						FROM $tabela INNER JOIN cliente C ON C.CLI_ID_WINTHOR = TIT_ID_CLIENTE
						WHERE TIT_ID > 0 AND TIT_STATUS_ENVIO = 'S' AND TIT_STATUS_IEPTB <> 'FI'
						AND ".$concatenaData."
							".$vSQLCliente."
							".$vSQLFilial."
							".$vSQLStatus;	
		

			$returnStatus = $this->atualizaStatusTitulos($sql_status);
			// $totalFiltered = $returnStatus->num_rows();

			if(!empty($requestData['search']['value']) ) {

				$order = ($columns[$requestData['order'][0]['column']] != '' && $columns[$requestData['order'][0]['column']] != NULL) ? $columns[$requestData['order'][0]['column']] : 'TIT_ID';

				$sql = " SELECT TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_NUMTRANSVENDA,
							   	TIT_FILIAL,
							   	TIT_ID_CLIENTE,
								TIT_CLIENTE, 
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO, 
								TIT_STATUS_ENVIO,
								TIT_STATUS_IEPTB,
								TIT_ID_CLIENTE,
								TIT_FILIAL,
								C.CLI_RCA_ID
								
						FROM $tabela T INNER JOIN cliente C ON C.CLI_ID_WINTHOR = TIT_ID_CLIENTE
						WHERE (TIT_CLIENTE  LIKE '%".$requestData['search']['value']."%' OR 
								TIT_NUMERO_TITULO_WINTHOR LIKE '%".$requestData['search']['value']."%' OR
								TIT_DUPLICATA LIKE '%".$requestData['search']['value']."%' OR
								TIT_PRESTACAO LIKE '%".$requestData['search']['value']."%' OR
								TIT_DATA_VENCIMENTO LIKE '%".$requestData['search']['value']."%')
								AND (TIT_DATA_VENCIMENTO BETWEEN '".$vDataInicial."' AND '".$vDataFinal."')
								".$vSQLCliente."
								".$vSQLFilial."
								".$vSQLStatus."
						AND TIT_ID > 0 AND TIT_STATUS_ENVIO = 'S'
						ORDER BY ".$order." ".$requestData['order'][0]['dir']."   
						LIMIT ".$requestData['start']." ,".$requestData['length']."
					";
					
				$sql2 = " SELECT TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_NUMTRANSVENDA,
							   	TIT_FILIAL,
								TIT_CLIENTE, 
								TIT_ID_CLIENTE,
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO, 
								TIT_STATUS_ENVIO,
								TIT_STATUS_IEPTB,
								TIT_ID_CLIENTE,
								TIT_FILIAL,
								C.CLI_RCA_ID
								
						FROM $tabela T INNER JOIN cliente C ON C.CLI_ID_WINTHOR = TIT_ID_CLIENTE
						WHERE (TIT_CLIENTE  LIKE '%".$requestData['search']['value']."%' OR  
								TIT_NUMERO_TITULO_WINTHOR LIKE '%".$requestData['search']['value']."%' OR
								TIT_DUPLICATA LIKE '%".$requestData['search']['value']."%' OR
								TIT_PRESTACAO LIKE '%".$requestData['search']['value']."%' OR
								TIT_DATA_VENCIMENTO LIKE '%".$requestData['search']['value']."%')
								AND ".$concatenaData."
								".$vSQLCliente."
								".$vSQLFilial."
								".$vSQLStatus."
						AND TIT_ID > 0 AND TIT_STATUS_ENVIO = 'S'
						ORDER BY ".$order." ".$requestData['order'][0]['dir']."";
					


				$query  = $this->db->query($sql);
				$query2  = $this->db->query($sql2);

				$dataFiltered  = $query2->num_rows();
	  			$totalFiltered = $dataFiltered;
			} else {

				$sql = "SELECT  TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_NUMTRANSVENDA,
							   	TIT_FILIAL,
								TIT_CLIENTE,
								TIT_ID_CLIENTE, 
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO, 
								TIT_STATUS_ENVIO,
								TIT_STATUS_IEPTB,
								C.CLI_RCA_ID

						FROM $tabela INNER JOIN cliente C ON C.CLI_ID_WINTHOR = TIT_ID_CLIENTE
						WHERE TIT_ID > 0 AND TIT_STATUS_ENVIO = 'S'
						  AND ".$concatenaData."
							".$vSQLCliente."
							".$vSQLFilial."
							".$vSQLStatus." LIMIT ".$requestData['start']." ,".$requestData['length'];

				$sql2 = "SELECT  TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_NUMTRANSVENDA,
							   	TIT_FILIAL,
								TIT_CLIENTE, 
								TIT_ID_CLIENTE,
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO, 
								TIT_STATUS_ENVIO,
								TIT_STATUS_IEPTB,
								C.CLI_RCA_ID

						FROM $tabela INNER JOIN cliente C ON C.CLI_ID_WINTHOR = TIT_ID_CLIENTE
						WHERE TIT_ID > 0 AND TIT_STATUS_ENVIO = 'S'
						  AND ".$concatenaData."
							".$vSQLCliente."
							".$vSQLFilial."
							".$vSQLStatus;							
					
					$query = $this->db->query($sql);
					$query2 = $this->db->query($sql2);

					$dataFiltered  = $query2->num_rows();
					$totalFiltered = $dataFiltered;
			}

			$dataRows = array();


			foreach ($query->result() as $row) {

				$status = '';

				if($row->TIT_STATUS_IEPTB == 'PA') {
					$status = 'Pago';
				} else if($row->TIT_STATUS_IEPTB == 'GE') {
					$status = 'Gerado';
				} else if($row->TIT_STATUS_IEPTB == 'EN' ){
					$status = 'Enviado';
				} else if($row->TIT_STATUS_IEPTB == 'DE') {
					$status = 'Devolvido';
				} else if($row->TIT_STATUS_IEPTB == 'CO') {
					$status = 'Confirmado';
				} else if($row->TIT_STATUS_IEPTB == 'RE') {
					$status = 'Retirado';
				} else if($row->TIT_STATUS_IEPTB == 'PR') {
					$status = 'Protestado';
				} else if($row->TIT_STATUS_IEPTB == 'SU') {
					$status = 'Sustado';
				} else if($row->TIT_STATUS_IEPTB == 'CA') {
					$status = 'Cancelado';
				} else if($row->TIT_STATUS_IEPTB == 'FI') {
					$status = 'Finalizado';
				} else if($row->TIT_STATUS_IEPTB == 'CL') {
					$status = 'Coletado';
				}

				$nestedData = array(); 
				$nestedData[] = "<input name='titulosCheckbox' type='checkbox' value='".$row->TIT_ID."' class='form-control' />";
				$nestedData[] = $row->TIT_NUMERO_TITULO_WINTHOR;
				$nestedData[] = $row->TIT_NUMTRANSVENDA;
				$nestedData[] = $row->TIT_FILIAL;
				$nestedData[] = $row->TIT_ID_CLIENTE . ' - '. $row->TIT_CLIENTE;
				$nestedData[] = $row->TIT_DATA_VENCIMENTO;
				$nestedData[] = $row->TIT_DUPLICATA;
				$nestedData[] = $row->TIT_PRESTACAO;
				$nestedData[] = $row->TIT_SALDO;
				$nestedData[] = $status;
				$nestedData[] = "<a data-toggle='tooltip' title='Informações' class='fa fa-info-circle' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='titulos.modalInfo(".$row->TIT_ID.")'></a>";

				$dataRows[] = $nestedData;
			}

			return array(
				"draw"                 => intval( $requestData['draw'] ),
				"iTotalDisplayRecords" => intval( $totalFiltered ), 
				"recordsTotal"         => intval( $dataFiltered ), 
				"recordsFiltered"      => intval( $totalFiltered ), 
				"data"                 => $dataRows
			);

	    } catch(PDOException $e) { 
            echo 'Erro: ' . $e->getMessage();
	    } 
	}  

    function getCaixas() {

		$sql = "SELECT CONF_URL_API FROM configuracoes LIMIT 1 ";
		$query = $this->db->query($sql);
  
		if($query->num_rows() > 0) {
		  foreach($query->result() as $row) {
			$ch = curl_init();
			$url =  $row->CONF_URL_API.'bancos';
			 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				
			$resp = curl_exec($ch);
	  
			if($e = curl_error($ch)) {
			  echo $e;
			} else {
			  $decoded = json_decode($resp, true);
			  foreach($decoded as $value) {
				$registros = $this->salvaCaixas($value['CODBANCO'], $value['NOME']);
			  }
			  return $registros;
			}
		  }
		}
  
	  }

	  function getMoedas() {

		$sql = "SELECT CONF_URL_API FROM configuracoes LIMIT 1 ";
		$query = $this->db->query($sql);
  
		if($query->num_rows() > 0) {
		  foreach($query->result() as $row) {
			$ch = curl_init();
			$url =  $row->CONF_URL_API.'moedas';
			 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				
			$resp = curl_exec($ch);
	  
			if($e = curl_error($ch)) {
			  echo $e;
			} else {
			  $decoded = json_decode($resp, true);
			  foreach($decoded as $value) {
				$registros = $this->salvaMoedas($value['CODMOEDA'], $value['MOEDA']);
			  }
			  return $registros;
			}
		  }
		}
  
	  }

	  function salvaCaixas($codBanco, $nome)  {
		$dados = array(
		  'CAIXA_CODIGO' => $codBanco,
		  'CAIXA_NOME' => $nome
		);
  
		if($this->caixaJaNaBase($codBanco)) {
		  return false;
		} else {
		  $this->db->insert('caixa', $dados);
		  return true;
		}
	  }
  
	  function caixaJaNaBase($codBanco) {
		$sql = " SELECT CAIXA_CODIGO FROM caixa WHERE CAIXA_CODIGO = ?";
		$query = $this->db->query($sql, array($codBanco));
		if($query->num_rows() > 0) {
		  return true;
		}
	  }

	  function salvaMoedas($codMoeda, $moeda)  {
		$dados = array(
		  'MOEDA_CODIGO' => $codMoeda,
		  'MOEDA_NOME' => $moeda
		);
  
		if($this->moedaJaNaBase($codMoeda)) {
		  return false;
		} else {
		  $this->db->insert('moeda', $dados);
		  return true;
		}
	  }
  
	  function moedaJaNaBase($codMoeda) {
		$sql = " SELECT MOEDA_CODIGO FROM moeda WHERE MOEDA_CODIGO = ?";
		$query = $this->db->query($sql, array($codMoeda));
		if($query->num_rows() > 0) {
		  return true;
		}
	  }
  
  


	function atualizaStatusTitulos($sql){

		$vDadosRetorno = '';
		$vToken = $this->app->ValidaTokenIEPTB();
		$vStatus = '';
  
		$query = $this->db->query($sql);
		$queryNumRows = $query->num_rows();
		  if ($query->num_rows() > 0){
		   
		   // O xml é criando conforme é feita a consulta
		   $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
			  xmlns:ser="http://grupobst.com.br/services">
			  <soapenv:Header/>
			  <soapenv:Body>
				 <ser:ConsultarTitulo>
					<token>'.$vToken.'</token>
					<!--Optional:-->
					<completa>S</completa>
					<!--1 or more repetitions:-->';
  
		   foreach ($query->result() as $row) {
  
			  $xml_data .= '
					   <titulo>
						  <devedor>
							 <documento>'.str_replace(str_split('./-'), '', $row->CLI_CPF_CNPJ).'</documento>
						  </devedor>
						  <divida>
							 <numero>'.$row->TIT_ID.'</numero>
							 <nossoNumero>'.$row->TIT_NUMERO_TITULO_IEPTB.'</nossoNumero>
							 <especie>'.$row->TIT_ESPECIE.'</especie>
							 <vencimento>'.$row->TIT_DATA_VENCIMENTO.'</vencimento>
						  </divida>
					   </titulo>
			  '; 
		   }
  
		   $xml_data .= ' </ser:ConsultarTitulo>
			  </soapenv:Body>
		   </soapenv:Envelope>';
		   
		   // chama a função para executar a consulta soap e retorno o json
		   $vRetornoEnvio = $this->app->ConsultaDadosSoapIEPTB($xml_data);

		   if($queryNumRows > 1) {
			   // pega o json e atualiza os campos no banco com o status da integração e se deu erro em algum titulo
			 	
			   $count = is_array($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']) ? count($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']) : 0; 
			   for ($i=0; $i < $count; $i++) { 
					
					$dataValorPago = null;
					$dataPago = null;
					$valorRepasse = null;

					if($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['resposta']['codigo'] != 'INEXISTENTE') {
						if(isset($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['ocorrencia'])) {
							$vCount = (count($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['ocorrencia']) - 1);
						
						   $vStatus = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['ocorrencia'][$vCount]['status'];
						   $vStatusCerto = '';
						   if($vStatus == 'PAGO') {
							   $vStatusCerto = 'PA';
							   $dataValorPago 	 = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['ocorrencia'][$vCount]['dataHora'];
							   $valorPago 	  = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['ocorrencia'][$vCount]['dataHora'];
							   $valorRepasse = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['ocorrencia'][$vCount]['repasse']['valorRepasse'];
						   } else if($vStatus == 'COLETADO') {
							   $vStatusCerto = 'CO';
						   } else if($vStatus == 'GERADO' ){
							   $vStatusCerto = 'GE';
						   } else if($vStatus == 'ENVIADO') {
							   $vStatusCerto = 'EN';
						   } else if($vStatus == 'CONFIRMADO') {
							   $vStatusCerto = 'CO';
						   } else if($vStatus == 'PROTESTADO') {
							   $vStatusCerto = 'PR';
						   } else if($vStatus == 'CANCELADO') {
							   $vStatusCerto = 'CA';
						   } else if($vStatus == 'SUSTADO') {
							   $vStatusCerto = 'SU';
						   } else if($vStatus == 'DEVOLVIDO') {
							   $vStatusCerto = 'DE';
						   }else if($vStatus == 'RETIRADO') {
							   $vStatusCerto = 'RE';
						   }
   
						   $dados = array(
							   'TIT_STATUS_IEPTB' 	 => $vStatusCerto,
							   'TIT_DATA_PAGAMENTO' => ($dataValorPago != null) ? formataDataHora($dataValorPago, '-', '/') : null,
							   'TIT_VALOR_REPASSE'  => $valorRepasse
						   );
	   
						   $this->db->update('titulos', $dados, array('TIT_ID' => $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo'][$i]['divida']['numero']));  

						}
					} 
				}
		   } else {
			   // pega o json e atualiza os campos no banco com o status da integração e se deu erro em algum titulo
			   $count = is_array($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']) ? count($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']) : 0; 
			   for ($i=0; $i < $count; $i++) {  
				
				if($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['resposta']['codigo'] != 'INEXISTENTE') {
					if(isset($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['ocorrencia'])) {
						$vCount = (count($vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['ocorrencia']) - 1);
						$vStatus = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['ocorrencia'][$vCount]['status'];
						
					   $valorPago = null;
					   $valorRepasse = null;
					   $vStatusCerto = '';
					   if($vStatus == 'PAGO') {
						   $vStatusCerto = 'PA';
						   $valorPago 	  = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['ocorrencia'][$vCount]['dataHora'];
						   $valorRepasse = $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['ocorrencia'][$vCount]['repasse']['valorRepasse'];
					   } else if($vStatus == 'COLETADO') {
						   $vStatusCerto = 'CO';
					   } else if($vStatus == 'GERADO' ){
						   $vStatusCerto = 'GE';
					   } else if($vStatus == 'ENVIADO') {
						   $vStatusCerto = 'EN';
					   } else if($vStatus == 'CONFIRMADO') {
						   $vStatusCerto = 'CO';
					   } else if($vStatus == 'PROTESTADO') {
						   $vStatusCerto = 'PR';
					   } else if($vStatus == 'CANCELADO') {
						   $vStatusCerto = 'CA';
					   } else if($vStatus == 'SUSTADO') {
						   $vStatusCerto = 'SU';
					   } else if($vStatus == 'DEVOLVIDO') {
						   $vStatusCerto = 'DE';
					   }else if($vStatus == 'RETIRADO') {
						   $vStatusCerto = 'RE';
					   }
				   
					   $dados = array(
						   'TIT_STATUS_IEPTB' 	 => $vStatusCerto,
						   'TIT_DATA_PAGAMENTO' => formataDataHora($valorPago, '-', '/'),
						   'TIT_VALOR_REPASSE'  => $valorRepasse
					   );
   
					   $this->db->update('titulos', $dados, array('TIT_ID' => $vRetornoEnvio['soap_Body']['ns2_ConsultarTituloResponse']['titulo']['divida']['numero']));  

					}
				} 
			}
		   }

		   return $this->db->affected_rows();
		}
	 }

	function CarregaComboFilial(){

		$dados = array();

		$sql   = " SELECT FIL_ID_WINTHOR, FIL_NOME FROM filial WHERE FIL_ID_WINTHOR > 0 ORDER BY FIL_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vIdFilial'   => $row->FIL_ID_WINTHOR,
        			'vNomeFilial' => $row->FIL_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}

	function carregaComboCliente(){

		$dados = array();
		
		$sql   = " SELECT CLI_ID_WINTHOR, CLI_NOME, CLI_CPF_CNPJ FROM cliente WHERE CLI_ID_WINTHOR > 0 ORDER BY CLI_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vIdCliente'   => $row->CLI_ID_WINTHOR,
        			'vNomeCliente' => $row->CLI_CPF_CNPJ." - ".$row->CLI_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}
	
	function carregaComboStatusTitulo(){

		$dados = array();

		$sql   = " SELECT STA_VALUE, STA_DESCRICAO FROM statustitulo WHERE STA_ID > 0 ORDER BY STA_DESCRICAO ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vIdStatus'   => $row->STA_VALUE,
        			'vNomeStatus' => $row->STA_DESCRICAO
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}
	
	function carregaComboPracaCobranca(){

		$dados = array();

		$sql   = " SELECT PRAC_ID_WINTHOR, PRAC_NOME FROM pracacobranca WHERE PRAC_ID_WINTHOR > 0 ORDER BY PRAC_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vIdPracaCobranca'   => $row->PRAC_ID_WINTHOR,
        			'vNomePracaCobranca' => $row->PRAC_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}

	function carregaComboVendedores(){

		$dados = array();
		
		$sql   = " SELECT RCA_ID_WINTHOR, RCA_NOME FROM rca WHERE RCA_ID_WINTHOR > 0 ORDER BY RCA_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vIdVendedor'   => $row->RCA_ID_WINTHOR,
        			'vNomeVendedor' => $row->RCA_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}

	function isPago($id) {

		$sql_status = "SELECT  TIT_ID,
						TIT_NUMTRANSVENDA,
						TIT_FILIAL,
						TIT_NUMERO_TITULO_WINTHOR, 
						TIT_NUMERO_TITULO_IEPTB,
						TIT_CLIENTE, 
						DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
						format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
						TIT_DUPLICATA, 
						TIT_PRESTACAO, 
						TIT_STATUS_ENVIO,
						TIT_STATUS_IEPTB,
						C.CLI_CPF_CNPJ,
						TIT_ESPECIE,
						C.CLI_RCA_ID

				FROM titulos INNER JOIN cliente C ON C.CLI_ID_WINTHOR = TIT_ID_CLIENTE
				WHERE TIT_ID = ".$id." AND TIT_STATUS_ENVIO = 'S' AND TIT_STATUS_IEPTB <> 'FI' ";	
	

		$returnStatus = $this->atualizaStatusTitulos($sql_status);

		if(isset($id)) {
			$dados = array();

			$sql = " SELECT T.TIT_DUPLICATA,
							C.CLI_NOME,
							T.TIT_STATUS_IEPTB
						FROM titulos T
						INNER JOIN cliente C 
							ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
					WHERE T.TIT_ID = ? AND TIT_STATUS_IEPTB <> 'FI' ";
			
			$query = $this->db->query($sql, array($id));

			if($query->num_rows() > 0) {
				foreach($query->result() as $result) {
					$dados = array(
						'duplicata' => $result->TIT_DUPLICATA,
						'nome'		=> $result->CLI_NOME,
						'status'	=> $result->TIT_STATUS_IEPTB
					);
				}

				return $dados;

			} else {
				return null;
			}
			
		}
	}

	function EnviaTitulosParaIEPTB($titulos){

		$vToken    = $this->app->ValidaTokenIEPTB();

		// monta consulta xml
		$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://grupobst.com.br/services">
			<soapenv:Header/>
			<soapenv:Body>
			<ser:Autenticar>
			<credenciais>
				<usuario>samuel_ws</usuario>
				<senha>Samuel@2021</senha>
			</credenciais>
			</ser:Autenticar>
			</soapenv:Body>
		</soapenv:Envelope>';

		// chama a função para executar a consulta soap e retorno o json para a tela
		return $vToken;
	}
	

	// Carrega os dados para serem exibidos na modal de informações 
	function modalInfo($id){

		$dados = array();
		
		$sql   = " SELECT
					T.TIT_ID,
					T.TIT_NUMERO_TITULO_WINTHOR,
				/*nosso numero*/
				/*numero*/
					format(T.TIT_SALDO,2,'de_DE') AS TIT_SALDO,
					format(T.TIT_VALOR,2,'de_DE') AS TIT_VALOR,
					T.TIT_CLIENTE,
					DATE_FORMAT(T.TIT_DATA_EMISSAO, '%d/%m/%Y') as TIT_DATA_EMISSAO,
					DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO,
					T.TIT_ESPECIE,
					T.TIT_ACEITE,
					T.TIT_TIPOENDOSSO,
					T.TIT_DECLARACAO_PORTADOR,
					T.TIT_STATUS_ENVIO,
					TIT_USUARIO_BAIXA_NOME,
					TIT_CAIXA_BAIXA_NOME,
					TIT_MOEDA_BAIXA_NOME,
					T.TIT_MOTIVO,
					T.TIT_STATUS_IEPTB,
					T.TIT_DATA_PAGAMENTO,
					format(T.TIT_VALOR_JUROS,2,'de_DE') AS TIT_VALOR_JUROS,
					format(T.TIT_VALOR_DESPESAS_CARTORIO,2,'de_DE') AS TIT_VALOR_DESPESAS_CARTORIO,
					T.TIT_PRACA_COBRANCA_ID,
					T.TIT_FILIAL,
					T.TIT_DOCUMENTO_TIPO,
					T.TIT_DATA_BAIXA_WINTHOR,
					DATE_FORMAT(T.TIT_DATA_BAIXA, '%d/%m/%Y') AS TIT_DATA_BAIXA,
					format(T.TIT_VALOR_MULTA, 2,'de_DE') AS TIT_VALOR_MULTA, 
					format(T.TIT_VALOR_JUROS, 2,'de_DE') AS TIT_VALOR_JUROS, 
				/*a partir daqui os campos do devedor*/
					C.CLI_NOME,
					C.CLI_NOME_FANTASIA,
					C.CLI_ENDERECO,
					C.CLI_CIDADE,
					C.CLI_BAIRRO,
					C.CLI_EMAIL,
					C.CLI_TELEFONE_COBRANCA,
					C.CLI_UF,
				/*documento */
					C.CLI_CPF_CNPJ,
				/*a partir daqui os campos do sacador */
					F.FIL_ID,
					F.FIL_ID_WINTHOR,
					F.FIL_NOME,
					F.FIL_CNPJ,
					F.FIL_ENDERECO,
					F.FIL_UF,
					F.FIL_MUNICIPIO,
					F.FIL_CEP
				FROM
					titulos T
					INNER JOIN cliente C ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
					INNER JOIN filial F ON F.FIL_ID_WINTHOR = T.TIT_FILIAL 
				WHERE
					T.TIT_ID = ?
					LIMIT 1 ";

		$query = $this->db->query($sql, array($id));

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
				$status = '';
				if($row->TIT_STATUS_IEPTB == 'PA') {
					$status = 'Pago';
				} else if($row->TIT_STATUS_IEPTB == 'GE') {
					$status = 'Gerado';
				} else if($row->TIT_STATUS_IEPTB == 'EN' ){
					$status = 'Enviado';
				} else if($row->TIT_STATUS_IEPTB == 'DE') {
					$status = 'Devolvido';
				} else if($row->TIT_STATUS_IEPTB == 'CO') {
					$status = 'Confirmado';
				} else if($row->TIT_STATUS_IEPTB == 'RE') {
					$status = 'Retirado';
				} else if($row->TIT_STATUS_IEPTB == 'PR') {
					$status = 'Protestado';
				} else if($row->TIT_STATUS_IEPTB == 'SU') {
					$status = 'Sustado';
				} else if($row->TIT_STATUS_IEPTB == 'CA') {
					$status = 'Cancelado';
				} else if($row->TIT_STATUS_IEPTB == 'FI') {
					$status = 'Finalizado';
				} else if($row->TIT_STATUS_IEPTB == 'CL') {
					$status = 'Coletado';
				}

		        $dados[] = array(
        			'vId' 					 =>  $row->TIT_ID,
					'vNossoNumero' 			 =>  $row->TIT_NUMERO_TITULO_WINTHOR,
					'vSaldo' 				 =>  $row->TIT_SALDO,
					'vValor' 				 =>  $row->TIT_VALOR,
					'vCliente' 				 =>  $row->TIT_CLIENTE,
					'vDataEmissao' 			 =>  $row->TIT_DATA_EMISSAO,
					'vDataVencimento' 		 =>  $row->TIT_DATA_VENCIMENTO,
					'vEspecie' 				 =>  $row->TIT_ESPECIE,
					'vMotivo'				 =>  $row->TIT_MOTIVO,
					'vAceite'				 =>  $row->TIT_ACEITE,
					'vEndosso' 				 =>  $row->TIT_TIPOENDOSSO,
					'vPortador' 			 =>  $row->TIT_DECLARACAO_PORTADOR,
					'vStatusieptb' 			 =>  $status,
					'vDataPagamento' 		 =>  $row->TIT_DATA_PAGAMENTO,
					'vValorJuros' 			 =>  $row->TIT_VALOR_JUROS,
					'vValorDespesasCartorio' =>  $row->TIT_VALOR_DESPESAS_CARTORIO,
					'vPracaCobranca' 	   	 =>  $row->TIT_PRACA_COBRANCA_ID,
					'vFilial' 			   	 =>  $row->TIT_FILIAL,
					'vDocumentoTipo'       	 =>  $row->TIT_DOCUMENTO_TIPO,
					'vDataBaixaWinthor'    	 =>  $row->TIT_DATA_BAIXA,
					'vUsuarioBaixa'	 	   	 =>	 $row->TIT_USUARIO_BAIXA_NOME,
					'vCaixaBaixa'		   	 =>	 $row->TIT_CAIXA_BAIXA_NOME,
					'vMoedaBaixa'		   	 =>	 $row->TIT_MOEDA_BAIXA_NOME,
					'vClienteNome' 		   	 =>  $row->CLI_NOME,
					'vClienteNomeFantasia' 	 =>  $row->CLI_NOME_FANTASIA,
					'vClienteEndereco' 	   	 =>  $row->CLI_ENDERECO,
					'vClienteCidade' 	   	 =>  $row->CLI_CIDADE,
					'vClienteBairro' 	   	 =>  $row->CLI_BAIRRO,
					'vClienteEmail' 	   	 =>  $row->CLI_EMAIL,
					'vClienteTelefone'     	 =>  $row->CLI_TELEFONE_COBRANCA,
					'vClienteUF' 		   	 =>  $row->CLI_UF,
					'vClienteCPFCNPJ'      	 =>  $row->CLI_CPF_CNPJ, 
					'vFilialID' 	  	   	 =>  $row->FIL_ID,
					'vFilialIDWinthor'	   	 =>  $row->FIL_ID_WINTHOR,
					'vFilialNome' 	  	   	 =>  $row->FIL_NOME,
					'vFilialCNPJ' 	  	   	 =>  $row->FIL_CNPJ,
					'vFilialEndereco' 	   	 =>  $row->FIL_ENDERECO,
					'vFilialUF' 	  	   	 =>  $row->FIL_UF,
					'vFilialCidade'   	   	 =>  $row->FIL_MUNICIPIO,
					'vFilialCep'      	   	 =>  $row->FIL_CEP,
					'vMulta'				 =>  $row->TIT_VALOR_MULTA,
					'vJuro'					 =>  $row->TIT_VALOR_JUROS
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}

	function carregaComboUsuariosWinthor() {
		$dados = array();

		$sql   = " SELECT USU_ID_WINTHOR, USU_NOME FROM usuario WHERE USU_ID_WINTHOR > 0 ORDER BY USU_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vIdWinthor'   => $row->USU_ID_WINTHOR,
        			'vNomeWinthor' => $row->USU_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}

	function carregaComboMoeda() {
		$dados = array();

		$sql   = " SELECT MOEDA_CODIGO, MOEDA_NOME FROM moeda WHERE MOEDA_ID > 0 ORDER BY MOEDA_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vId'   => $row->MOEDA_CODIGO,
        			'vNome' => $row->MOEDA_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}
	function carregaComboCaixa() {
		$dados = array();

		$sql   = " SELECT CAIXA_CODIGO, CAIXA_NOME FROM caixa WHERE CAIXA_ID > 0 ORDER BY CAIXA_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		        $dados[] = array(
        			'vId'   => $row->CAIXA_CODIGO,
        			'vNome' => $row->CAIXA_NOME
		        );  
        	}
            return $dados;
        } else {
	      return null;
	    }
	}

	function getIdConjunto($vNossoNumero) {
		$dados = array();
		$sql = " SELECT T.TIT_NUMTRANSVENDA, T.TIT_FILIAL, T.TIT_PRESTACAO FROM titulos T WHERE T.TIT_ID = ? LIMIT 1";
		$query = $this->db->query($sql, array($vNossoNumero));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$dados = array(
					'numtransvenda' => $row->TIT_NUMTRANSVENDA,
					'filial'		=> $row->TIT_FILIAL,
					'prestacao' 	=> $row->TIT_PRESTACAO
				);
			}

			return $dados;
		} else {
			return null;
		}
		
	}

	function getDadosTitulo($titulo) {
		$dados = array();

		$sql = " SELECT TIT_FILIAL, TIT_SALDO, TIT_VALOR_REPASSE, TIT_DATA_PAGAMENTO FROM titulos WHERE TIT_ID = ? ";
		$query = $this->db->query($sql, array($titulo));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$dados = array(
					'filial' 		=> $row->TIT_FILIAL,
					'saldo'  	   	=> $row->TIT_SALDO,
					'dataPagamento'	=> $row->TIT_DATA_PAGAMENTO,
					'repasse'		=> $row->TIT_VALOR_REPASSE
				);
			}
			return $dados;
		}
	}

	function baixarWinthor($usuario, $usuarioNome, $moeda, $moedaNome, $caixa, $caixaNome, $titulosPagos){
        try{

			foreach($titulosPagos as $titulo) {

				$idConjunto 	 = $this->getIdConjunto($titulo);
				$dadosBase  	 = $this->getDadosTitulo($titulo);
				$vParametrizacao = $this->app->BuscaParametrizacaoSistema();
				$vCobranca 		 = $vParametrizacao['vCobranca'];
				$user_data 		 = $this->session->userdata('logged_in');
				$codfuncultalter = $user_data['sessao_id_winthor'];
				$vURLEnvio 	 	 = $vParametrizacao['vWinthorUrl'];


				$dadosAPI = array(
					'codfilial' => intval($dadosBase['filial']),
					'numtransvenda' => intval($idConjunto['numtransvenda']),
					'prest' => intval($idConjunto['prestacao']),
					'codfuncultalter' => intval($codfuncultalter),
					'valorpago' => $dadosBase['repasse'],
					'valorJuroPago' => ($dadosBase['repasse'] > $dadosBase['saldo']) ? $dadosBase['saldo'] - $dadosBase['repasse'] : 0,
					'datapagamento' => formataData(substr($dadosBase['dataPagamento'], 0, -9), '/', '-'),
					'codcobbanco' => $moeda,
					'codbanco' => $caixa
				);

				$ch = curl_init();
				$url =  $vURLEnvio.'/baixatitulowinthor';
						$request_headers = array("Content-Type:" . 'application/json');
		
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dadosAPI));
					
				$resp = curl_exec($ch);
				curl_close($ch);
		
				$arrayResult = json_decode($resp);

				$dados = array(
						  'TIT_STATUS_IEPTB'	   => 'FI',
						  'TIT_MOEDA_BAIXA_ID'     => $moeda,
						  'TIT_MOEDA_BAIXA_NOME'   => $moedaNome,
						  'TIT_CAIXA_BAIXA_ID'     => $caixa,
						  'TIT_CAIXA_BAIXA_NOME'   => $caixaNome,
						  'TIT_USUARIO_BAIXA_ID'   => $user_data['sessao_id_winthor'],
						  'TIT_USUARIO_BAIXA_NOME' => $usuarioNome,
						  'TIT_DATA_BAIXA'		   => date('Y-m-d')
						);  
			
				$this->db->update('titulos', $dados, array("TIT_ID" => $titulo));
				$id = $this->db->affected_rows();
			}
			
			return $id;

        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }
	}

	function cancelaProtesto($titulosProtestados) {

		try {
			$return = array();
			$id = 0;
			$error_data = array();
			$vToken = $this->app->ValidaTokenIEPTB();

			foreach($titulosProtestados as $titulo) {
				$documento = $this->getDocumentoTitulo($titulo);
				$numero = $titulo;
				$nossoNumero = $this->getNossoNumeroTitulo($titulo);
				$vencimento = $this->getVencimento($titulo);


				$xml_data = '
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://grupobst.com.br/services">
					<soapenv:Header/>
					<soapenv:Body>
					<ser:OperacaoTitulo>
						<token>'.$vToken.'</token>
						<titulo>
							<autoriza>S</autoriza>
							<operacao>CANCELAMENTO</operacao>
							<devedor>
								<documento>'.$documento.'</documento>
							</devedor>
							<divida>
								<numero>'.$numero.'</numero>
								<nossoNumero>'.$titulo.'</nossoNumero>
								<vencimento>'.$vencimento.'</vencimento>
							</divida>
						</titulo>
					</ser:OperacaoTitulo>
					</soapenv:Body>
				</soapenv:Envelope>';

				$retorno = $this->app->ConsultaDadosSoapIEPTB($xml_data);

				if($retorno['soap_Body']['ns2_OperacaoTituloResponse']['titulo']['resposta']['codigo'] == 'INEXISTENTE') {
					$error_data[] = array(
						'id' => $titulo,
						'nome' => $this->getNomeCliente($titulo),
						'duplicata' => $this->getDuplicata($titulo)
					);
				} else {
					$dados = array(
						'TIT_STATUS_IEPTB'   => 'CA'
					  );  
		  
			 		  $this->db->update('titulos', $dados, array("TIT_ID" => $titulo));
					  $id = $this->db->affected_rows();
				}

				
			}
			
			$return = array('rows' => $id, 'error' => $error_data);

			return $return;

			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}

	}

	function getDocumentoTitulo($titulo) {

		$sql   = " SELECT C.CLI_CPF_CNPJ FROM cliente C INNER JOIN titulos T ON T.TIT_ID_CLIENTE = C.CLI_ID_WINTHOR WHERE T.TIT_ID = ? ";
		$query = $this->db->query($sql, array($titulo));

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
			   $retorno = str_replace(str_split('./-'), '', $row->CLI_CPF_CNPJ);
		       return $retorno;
        	}
        } else {
	      return null;
	    }
	}

	function getNomeCliente($titulo) {
		$sql   = " SELECT C.CLI_NOME FROM cliente C INNER JOIN titulos T ON T.TIT_ID_CLIENTE = C.CLI_ID_WINTHOR WHERE T.TIT_ID = ? ";
		$query = $this->db->query($sql, array($titulo));

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		       return $row->CLI_NOME;
        	}
        } else {
	      return null;
	    }
	}

	// function getNumeroTitulo($titulo) {

	// 	$sql   = " SELECT T.TIT_ID_WINTHOR FROM titulos T WHERE T.TIT_ID = ? ";
	// 	$query = $this->db->query($sql, array($titulo));

    //     if ($query->num_rows() > 0){
    //     	foreach ($query->result() as $row) {
	// 	       return $row->TIT_ID_WINTHOR;
    //     	}
    //     } else {
	//       return null;
	//     }
	// }

	function getDuplicata($titulo) {

		$sql   = " SELECT T.TIT_DUPLICATA FROM titulos T WHERE T.TIT_ID = ? ";
		$query = $this->db->query($sql, array($titulo));

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
		       return $row->TIT_DUPLICATA;
        	}
        } else {
	      return null;
	    }
	}

	function getNossoNumeroTitulo($titulo) {

		$sql   = " SELECT T.TIT_NUMERO_TITULO_WINTHOR FROM titulos T WHERE T.TIT_ID = ? ";
		$query = $this->db->query($sql, array($titulo));

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
				return $row->TIT_NUMERO_TITULO_WINTHOR;
        	}
        } else {
	      return null;
	    }
	}

	function getVencimento($titulo) {

		$sql   = " SELECT DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO FROM titulos T WHERE T.TIT_ID = ? ";
		$query = $this->db->query($sql, array($titulo));

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
				return $row->TIT_DATA_VENCIMENTO;
        	}
        } else {
	      return null;
	    }
	}
}

