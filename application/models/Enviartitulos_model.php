<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Enviartitulos_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->helper('functions_helper');
        $this->load->model('App_model', 'app');
    }

	function carregaTitulos($caixa = null){

		$tabela = 'titulos';
		$requestData = $_REQUEST;

		$concatena = "";
		if($caixa != null and $caixa != 0) {
			$concatena .= " AND TIT_CAIXA_BAIXA_ID = ".$caixa;
		}
	    
		try{

            $columns = array(
				0  => 'TIT_CLIENTE',
				1  => 'TIT_DATA_VENCIMENTO',
				2  => 'TIT_DUPLICATA',
				3  => 'TIT_PRESTACAO',
				4  => 'TIT_VALOR',
				5  => 'TIT_VALOR_JUROS',
				6  => 'TIT_VALOR_MULTA',
				7  => 'TIT_SALDO',
				8  => 'TIT_CONDICAO_PAGAMENTO',
				9  => 'TIT_DIAS_ATRASADOS',
				10  => 'TIT_USUARIO_BAIXA_NOME',
				11  => ''
			);


		      if(!empty($requestData['search']['value']) ) {

		        $sql = " SELECT TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_CLIENTE, 
								TIT_ID_CLIENTE,
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO,
								format(TIT_VALOR,2,'de_DE') AS TIT_VALOR, 
								format(TIT_VALOR_JUROS,2,'de_DE') AS TIT_VALOR_JUROS,
								format(TIT_VALOR_MULTA,2,'de_DE') AS TIT_VALOR_MULTA,
								TIT_STATUS_ENVIO,
								TIT_CONDICAO_PAGAMENTO,
								TIT_USUARIO_BAIXA_NOME,,
								TIT_BANCO
        		        		
        		           FROM $tabela 
		                 WHERE (TIT_CLIENTE  LIKE '%".$requestData['search']['value']."%' OR 
		                        TIT_NUMERO_TITULO_WINTHOR LIKE '%".$requestData['search']['value']."%' OR
		                        TIT_DUPLICATA LIKE '%".$requestData['search']['value']."%' OR
		                        TIT_PRESTACAO LIKE '%".$requestData['search']['value']."%' OR
								TIT_DATA_VENCIMENTO LIKE '%".$requestData['search']['value']."%')
		                   AND TIT_ID > 0 AND TIT_STATUS_ENVIO = 'N' ".$concatena."
		                 LIMIT ".$requestData['start']." ,".$requestData['length']."
		               ";

		        $sql2 = " SELECT TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_CLIENTE, 
								TIT_ID_CLIENTE,
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO,
								format(TIT_VALOR,2,'de_DE') AS TIT_VALOR, 
								format(TIT_VALOR_JUROS,2,'de_DE') AS TIT_VALOR_JUROS,
								format(TIT_VALOR_MULTA,2,'de_DE') AS TIT_VALOR_MULTA,
								TIT_STATUS_ENVIO,
								TIT_CONDICAO_PAGAMENTO,
								TIT_USUARIO_BAIXA_NOME,
								DATEDIFF(TIT_DATA_VENCIMENTO, CURDATE()) AS TIT_DIAS_ATRASADOS,
								TIT_BANCO
        		        		
        		           FROM $tabela 
		                 WHERE (TIT_CLIENTE  LIKE '%".$requestData['search']['value']."%' OR 
		                        TIT_NUMERO_TITULO_WINTHOR LIKE '%".$requestData['search']['value']."%' OR
		                        TIT_DUPLICATA LIKE '%".$requestData['search']['value']."%' OR
		                        TIT_PRESTACAO LIKE '%".$requestData['search']['value']."%' OR
								TIT_DATA_VENCIMENTO LIKE '%".$requestData['search']['value']."%')
		                   AND TIT_ID > 0 AND TIT_STATUS_ENVIO = 'N' ".$concatena."
		               ";
                       
		        $query  = $this->db->query($sql);
		        $query2  = $this->db->query($sql2);

				$dataFiltered  =  $query2->num_rows();
				$totalFiltered = $dataFiltered; 				
		      } else {

		        $sql = "SELECT  TIT_ID,
								TIT_NUMERO_TITULO_WINTHOR, 
								TIT_CLIENTE,
								TIT_ID_CLIENTE, 
								DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
								format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
								TIT_DUPLICATA, 
								TIT_PRESTACAO, 
								format(TIT_VALOR,2,'de_DE') AS TIT_VALOR, 
								format(TIT_VALOR_JUROS,2,'de_DE') AS TIT_VALOR_JUROS,
								format(TIT_VALOR_MULTA,2,'de_DE') AS TIT_VALOR_MULTA,
								TIT_STATUS_ENVIO,
								TIT_CONDICAO_PAGAMENTO,
								TIT_USUARIO_BAIXA_NOME,
								DATEDIFF(TIT_DATA_VENCIMENTO, CURDATE()) AS TIT_DIAS_ATRASADOS,
								TIT_BANCO

						FROM $tabela
						WHERE TIT_ID > 0 AND TIT_STATUS_ENVIO = 'N' ".$concatena."
						
						LIMIT ".$requestData['start']." ,".$requestData['length']."";

						$sql2 = "SELECT  TIT_ID,
						TIT_NUMERO_TITULO_WINTHOR, 
						TIT_ID_CLIENTE,
						TIT_CLIENTE, 
						DATE_FORMAT(TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO, 
						format(TIT_SALDO,2,'de_DE') AS TIT_SALDO, 
						TIT_DUPLICATA, 
						TIT_PRESTACAO, 
						format(TIT_VALOR,2,'de_DE') AS TIT_VALOR, 
						format(TIT_VALOR_JUROS,2,'de_DE') AS TIT_VALOR_JUROS,
						format(TIT_VALOR_MULTA,2,'de_DE') AS TIT_VALOR_MULTA,
						TIT_STATUS_ENVIO,
						TIT_CONDICAO_PAGAMENTO,
						TIT_USUARIO_BAIXA_NOME,
						DATEDIFF(TIT_DATA_VENCIMENTO, CURDATE()) AS TIT_DIAS_ATRASADOS,
						TIT_BANCO

						FROM $tabela
						WHERE TIT_ID > 0 AND TIT_STATUS_ENVIO = 'N' ".$concatena."";

		        $query = $this->db->query($sql);
		        $query2 = $this->db->query($sql2);
				$dataFiltered  =  $query2->num_rows();
				$totalFiltered = $dataFiltered; 				
		      }

		      $dataRows = array();

			  foreach ($query->result() as $row) {

		        $nestedData = array(); 
				$nestedData[] = "<input name='titulosCheckbox' type='checkbox' value='".$row->TIT_ID."' class='form-control' />";
		        $nestedData[] = $row->TIT_ID_CLIENTE .' - '. $row->TIT_CLIENTE;
				$nestedData[] = $row->TIT_DATA_VENCIMENTO;
		        $nestedData[] = $row->TIT_DUPLICATA;
		        $nestedData[] = $row->TIT_PRESTACAO;
		        $nestedData[] = $row->TIT_VALOR;
		        $nestedData[] = $row->TIT_VALOR_JUROS;
		        $nestedData[] = $row->TIT_VALOR_MULTA;
				$nestedData[] = $row->TIT_SALDO;
		        $nestedData[] = $row->TIT_CONDICAO_PAGAMENTO;
		        $nestedData[] = $row->TIT_BANCO;
		        $nestedData[] = str_replace('-', '', $row->TIT_DIAS_ATRASADOS);
		        $nestedData[] = "<a data-toggle='tooltip' title='Remover da Lista' class='fa fa-trash' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='enviartitulos.excluiTituloParaNaoEnviarProCartorio(".$row->TIT_ID.")'></a>";

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

	function BuscaDadosWinthor(){

     	// buscar dados de parametrização
		$vConfiguracao =  $this->app->BuscaParametrizacaoSistema();
		$vConteudo = "";
		$teste = "";
		// forma de pegar a configuração -> $vConfiguracao['vDiasEnvioProtesto'];

		// Faz requisão pra api do winthor para buscar os dados dos titulos, resultado vem em json
		$vParametrizacao = $this->app->BuscaParametrizacaoSistema();
		$vURLEnvio = $vParametrizacao['vWinthorUrl'];
		
		$ch = curl_init();
        $url =  $vURLEnvio.'/titulos';
		
		$request_headers = array("Content-Type:" . 'application/json');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
		$resp = curl_exec($ch);
		curl_close($ch);

		
		$arrayResult = json_decode($resp);

		// Aqui começa o array que vai varrer todo o conteudo do vetor de retorno, e salvar os dados conforme a tabela que ele pertence
		for ($i=0; $i < count($arrayResult); $i++) {
		
			// Chama a função para verificar se o vendedor esta cadastrado, utilizado para filtros
			$this->app->VerificaVendedorCadastrado($arrayResult[$i]->CODUSUR, $this->app->RemoverCaracteresEspeciais($arrayResult[$i]->NOME));
			
			// Chama a função para verificar se a filial esta cadastrado, utilizado para filtros
			$this->app->VerificaFilialCadastrada($arrayResult[$i]->CODIGO, $arrayResult[$i]->RAZAOSOCIAL, $arrayResult[$i]->CGC, $arrayResult[$i]->CIDADE, $arrayResult[$i]->CEP, $arrayResult[$i]->BAIRRO, $arrayResult[$i]->NUMERO, $arrayResult[$i]->UF, $arrayResult[$i]->ENDERECO);

			// verifica se o cliente já foi importado, se não foi cadastra ele na base local
			$this->db->select('CLI_ID_WINTHOR FROM cliente WHERE CLI_ID_WINTHOR = '.$arrayResult[$i]->CODCLI, false);
			$query = $this->db->get();
			
			if ($query->num_rows() == 0){
				$sql = "INSERT INTO cliente(CLI_ID_WINTHOR, 
											CLI_NOME, 
											CLI_NOME_FANTASIA, 
											CLI_TIPO_PESSOA, 
											CLI_CPF_CNPJ, 
											CLI_EMAIL, 
											CLI_INSCRICAO_ESTADUAL, 
											CLI_TELEFONE_COBRANCA, 
											CLI_ENDERECO, 
											CLI_BAIRRO, 
											CLI_NUMERO, 
											CLI_CIDADE, 
											CLI_UF, 
											CLI_CEP, 
											CLI_CODIGO_IBGE, 
											CLI_COMPLEMENTO, 
											CLI_RCA_ID) 
									
									VALUES (".$arrayResult[$i]->CODCLI.", 
											'".$this->app->RemoverCaracteresEspeciais($arrayResult[$i]->CLIENTE)."', 
											'".$this->app->RemoverCaracteresEspeciais($arrayResult[$i]->FANTASIA)."', 
											'".$arrayResult[$i]->TIPOFJ."', 
											'".$arrayResult[$i]->CGCENT."', 
											'".$arrayResult[$i]->EMAIL."', 
											'".$arrayResult[$i]->IEENT."', 
											'".$arrayResult[$i]->TELCOB."', 
											'".$arrayResult[$i]->ENDERCOB."', 
											'".$arrayResult[$i]->BAIRROCOB."', 
											'', 
											'".$arrayResult[$i]->NOMECIDADE."', 
											'".$arrayResult[$i]->ESTCOB."', 
											'".$arrayResult[$i]->CEPCOB."', 
											'".$arrayResult[$i]->CODIBGE."', 
											'', 
											".$arrayResult[$i]->CODUSUR.");";
			 	$query = $this->db->query($sql);
			}

			// verifica se o titulo já foi importado, se não foi cadastra ele na base local
			$this->db->select('TIT_NUMTRANSVENDA FROM titulos WHERE TIT_FILIAL = '.$arrayResult[$i]->CODIGO.' AND TIT_NUMTRANSVENDA = '.$arrayResult[$i]->NUMTRANSVENDA.' AND TIT_PRESTACAO = '.$arrayResult[$i]->PREST, false);
			$query = $this->db->get();
			
			if ($query->num_rows() == 0){

				// Função para verificar o tamanho do nosso numero, pois no winthor é maior que no ieptb
				 
				if (strlen($arrayResult[$i]->NOSSONUMBCO) > 15) {
					$vNossoNumeroIEPTB = $arrayResult[$i]->NOSSONUMBCO;
				} else {
					$vNossoNumeroIEPTB = $arrayResult[$i]->NOSSONUMBCO;
				}

				$this->db->select_max('TIT_ID');
				$result = $this->db->get('titulos');
				$result = $result->row();
				$maxCod = $result->TIT_ID + 1; 

				$sql = "INSERT INTO titulos(TIT_NUMERO_TITULO_WINTHOR, 
											TIT_CLIENTE, 
											TIT_VALOR, 
											TIT_DATA_VENCIMENTO, 
											TIT_DATA_EMISSAO, 
											TIT_NUMERO_TITULO_IEPTB, 
											TIT_ID_CLIENTE, 
											TIT_ESPECIE, 
											TIT_SALDO, 
											TIT_NUMTRANSVENDA, 
											TIT_ACEITE, 
											TIT_MOTIVO, 
											TIT_DECLARACAO_PORTADOR, 
											TIT_DUPLICATA, 
											TIT_PRESTACAO, 
											TIT_STATUS_ENVIO, 
											TIT_STATUS_IEPTB, 
											TIT_VALOR_JUROS, 
											TIT_FILIAL,
											TIT_TIPOENDOSSO,
											TIT_VALOR_MULTA,
											TIT_BANCO,
											TIT_CONDICAO_PAGAMENTO)
			
									VALUES ('".$arrayResult[$i]->NOSSONUMBCO."',
											'".$this->app->RemoverCaracteresEspeciais($arrayResult[$i]->CLIENTE)."', 
											".$arrayResult[$i]->VALOR.", 
											'".$arrayResult[$i]->DTVENC."', 
											'".$arrayResult[$i]->DTEMISSAO."', 
											'".$maxCod."',
											".$arrayResult[$i]->CODCLI.", 
											'".$vConfiguracao['vEspeciePadrao']."',
											".($arrayResult[$i]->VALOR + $arrayResult[$i]->VALORMULTA + $arrayResult[$i]->VALORJUROS).",
											'".$arrayResult[$i]->NUMTRANSVENDA."', 
											'".$vConfiguracao['vAceitePadrao']."', 
											'".$vConfiguracao['vMotivoPadrao']."',
											'".$vConfiguracao['vPortadorPadrao']."',
											".$arrayResult[$i]->DUPLIC.", 
											".$arrayResult[$i]->PREST.", 
											'N', 
											NULL,
											".$arrayResult[$i]->VALORJUROS.", 
											".$arrayResult[$i]->CODIGO.",
											'".$vConfiguracao['vEndossoPadrao']."',
										    ".$arrayResult[$i]->VALORMULTA.",
											'".$arrayResult[$i]->COBRANCA."',
											'".$arrayResult[$i]->CONDPAGAMENTO."'
										);";
					$query = $this->db->query($sql);
				}

		}

		return true;
	}


	function BuscaConfiguracoesPadrao(){

		// buscar dados de parametrização
	    $vConfiguracao =  $this->app->BuscaParametrizacaoSistema();
	   
	    $dados = array(
			'vAceitePadrao'   => $vConfiguracao['vAceitePadrao'],
			'vMotivoPadrao'   => $vConfiguracao['vMotivoPadrao'],
			'vPortadorPadrao' => $vConfiguracao['vPortadorPadrao'],
			'vEspeciePadrao'  => $vConfiguracao['vEspeciePadrao'],
		  	'vEndossoPadrao'  => $vConfiguracao['vEndossoPadrao']
	 	);

	    return $dados;
    }
	
	function excluiTituloParaNaoEnviarProCartorio($idTitulo){
		
		try{
			$this->db->delete('titulos', array('TIT_ID' => $idTitulo));
		    return ($this->db->affected_rows());
        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }	
	}

	function EnviaTitulosParaIEPTB($titulos){

		if(count($titulos) > 1) {
			$vDadosRetorno = array();
		} else {
			$vDadosRetorno = '';
		}
		// Essa função consulta todos os titulos com a situação de envio como N e os envia para o IEPTB
		$vToken = $this->app->ValidaTokenIEPTB();

		if ($titulos == '') {
		
			$sql = "SELECT  T.TIT_ID,
							T.TIT_NUMERO_TITULO_WINTHOR,
							T.TIT_NUMERO_TITULO_IEPTB,
							T.TIT_NUMTRANSVENDA,
							T.TIT_SALDO,
							T.TIT_VALOR,
							T.TIT_CLIENTE,
							DATE_FORMAT(T.TIT_DATA_EMISSAO, '%d/%m/%Y') as TIT_DATA_EMISSAO,
							DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO,
							T.TIT_ESPECIE,
							T.TIT_ACEITE,
							T.TIT_TIPOENDOSSO,
							T.TIT_DECLARACAO_PORTADOR,
							T.TIT_MOTIVO,
							T.TIT_STATUS_ENVIO,
							T.TIT_VALOR_JUROS,
							T.TIT_FILIAL,
							T.TIT_DOCUMENTO_TIPO,
							C.CLI_NOME,
							C.CLI_TIPO_PESSOA,
							C.CLI_ENDERECO,
							C.CLI_CIDADE,
							C.CLI_BAIRRO,
							C.CLI_NUMERO,
							C.CLI_CEP,
							C.CLI_TELEFONE_COBRANCA,
							C.CLI_CIDADE,
							C.CLI_UF,
							C.CLI_CPF_CNPJ,
							C.CLI_ID_WINTHOR,
							F.FIL_ID,
							F.FIL_ID_WINTHOR,
							F.FIL_NOME,
							F.FIL_CNPJ,
							F.FIL_ENDERECO,
							F.FIL_UF,
							F.FIL_MUNICIPIO,
							F.FIL_CEP,
							F.FIL_NUMERO,
							F.FIL_BAIRRO

					FROM titulos T, filial F, cliente C

					WHERE T.TIT_ID_CLIENTE = C.CLI_ID_WINTHOR
					AND T.TIT_FILIAL = F.FIL_ID_WINTHOR
					AND T.TIT_STATUS_ENVIO = 'N'";
		} else {
			$vTitulosEnviar = '';
			for ($i=0; $i < count($titulos); $i++) { 
				if ($i == 0) {
					$vTitulosEnviar = $titulos[$i];
				} else {
					$vTitulosEnviar = $vTitulosEnviar.','.$titulos[$i];
				}				
			}

			$sql = "SELECT  T.TIT_ID,
							T.TIT_NUMERO_TITULO_WINTHOR,
							T.TIT_NUMERO_TITULO_IEPTB,
							T.TIT_NUMTRANSVENDA,
							T.TIT_SALDO,
							T.TIT_VALOR,
							T.TIT_CLIENTE,
							DATE_FORMAT(T.TIT_DATA_EMISSAO, '%d/%m/%Y') as TIT_DATA_EMISSAO,
							DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') as TIT_DATA_VENCIMENTO,
							T.TIT_ESPECIE,
							T.TIT_ACEITE,
							T.TIT_TIPOENDOSSO,
							T.TIT_DECLARACAO_PORTADOR,
							T.TIT_MOTIVO,
							T.TIT_STATUS_ENVIO,
							T.TIT_VALOR_JUROS,
							T.TIT_FILIAL,
							T.TIT_DOCUMENTO_TIPO,
							C.CLI_NOME,
							C.CLI_TIPO_PESSOA,
							C.CLI_ENDERECO,
							C.CLI_CIDADE,
							C.CLI_BAIRRO,
							C.CLI_NUMERO,
							C.CLI_CEP,
							C.CLI_TELEFONE_COBRANCA,
							C.CLI_CIDADE,
							C.CLI_UF,
							C.CLI_CPF_CNPJ,
							C.CLI_ID_WINTHOR,
							F.FIL_ID,
							F.FIL_ID_WINTHOR,
							F.FIL_NOME,
							F.FIL_CNPJ,
							F.FIL_ENDERECO,
							F.FIL_UF,
							F.FIL_MUNICIPIO,
							F.FIL_CEP,
							F.FIL_NUMERO,
							F.FIL_BAIRRO

					FROM titulos T, filial F, cliente C

					WHERE T.TIT_ID_CLIENTE = C.CLI_ID_WINTHOR
					AND T.TIT_FILIAL = F.FIL_ID_WINTHOR
					AND T.TIT_STATUS_ENVIO = 'N'
					AND T.TIT_ID IN (".$vTitulosEnviar.")";
		}

		$query = $this->db->query($sql);
        if ($query->num_rows() > 0){
        	
			// O xml é criando conforme é feita a consulta
			$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
				xmlns:ser="http://grupobst.com.br/services">
				<soapenv:Header/>
				<soapenv:Body>
					<ser:EnviarTitulo>
						<token>'.$vToken.'</token> ';

			foreach ($query->result() as $row) {

				$xml_data .= '
							<titulo>
								<cedente>
									<codigo>'.$row->FIL_ID_WINTHOR.'</codigo>
									<nome>'.$row->FIL_NOME.'</nome>
									<documentoTipo>'.(( (strlen($row->FIL_CNPJ)) == 14) ? 2 : 1).'</documentoTipo>
									<documento>'.str_replace(str_split('./-'), '', $row->FIL_CNPJ).'</documento>
									<endereco>'.$row->FIL_ENDERECO.'</endereco>
									<numero>'.$row->FIL_NUMERO.'</numero>
									<cep>'.str_replace(str_split('./-'), '', $row->CLI_CEP).'</cep>
									<bairro>'.substr($row->FIL_BAIRRO, 0,20).'</bairro>
									<municipio>'.$row->FIL_MUNICIPIO.'</municipio>
									<uf>'.$row->FIL_UF.'</uf>
								</cedente>
								<sacador>
									<nome>'.$row->FIL_NOME.'</nome>
									<documentoTipo>'.(( (strlen($row->FIL_CNPJ)) == 14) ? 2 : 1).'</documentoTipo>
									<documento>'.str_replace(str_split('./-'), '', $row->FIL_CNPJ).'</documento>
									<endereco>'.$row->FIL_ENDERECO.'</endereco>
									<numero>'.$row->FIL_NUMERO.'</numero>
									<cep>'.str_replace(str_split('./-'), '', $row->CLI_CEP).'</cep>
									<bairro>'.substr($row->FIL_BAIRRO, 0,20).'</bairro>
									<municipio>'.$row->FIL_MUNICIPIO.'</municipio>
									<uf>'.$row->FIL_UF.'</uf>
								</sacador>
								<devedor>
									<nome>'.$row->CLI_NOME.'</nome>
									<documentoTipo>'.(($row->CLI_TIPO_PESSOA == 'J') ? 2 : 1).'</documentoTipo>
									<documento>'.str_replace(str_split('./-'), '', $row->CLI_CPF_CNPJ).'</documento>
									<endereco>'.$row->CLI_ENDERECO.'</endereco>
									<numero>1</numero>
									<cep>'.str_replace(str_split('./-'), '', $row->CLI_CEP).'</cep>
									<bairro>'.substr($row->FIL_BAIRRO, 0,20).'</bairro>
									<municipio>'.$row->CLI_CIDADE.'</municipio>
									<uf>'.$row->CLI_UF.'</uf>
								</devedor>
								<divida>
									<especie>'.$row->TIT_ESPECIE.'</especie>
									<numero>'.$row->TIT_ID.'</numero>
									<nossoNumero>'.$row->TIT_NUMERO_TITULO_IEPTB.'</nossoNumero>
									<valor>'.$row->TIT_VALOR.'</valor>
									<saldo>'.$row->TIT_SALDO.'</saldo>
									<tipoEndosso>'.$row->TIT_TIPOENDOSSO.'</tipoEndosso>
									<aceite>'.$row->TIT_ACEITE.'</aceite>
									<finsFalimentares>'.$row->TIT_MOTIVO.'</finsFalimentares>
									<declaracaoPortador>'.$row->TIT_DECLARACAO_PORTADOR.'</declaracaoPortador>
									<emissao>'.$row->TIT_DATA_EMISSAO.'</emissao>
									<vencimento>'.$row->TIT_DATA_VENCIMENTO.'</vencimento>
								</divida>
							</titulo>
				'; 
        	}

			$xml_data .= ' </ser:EnviarTitulo>
				</soapenv:Body>
			</soapenv:Envelope>';

			// chama a função para executar a consulta soap e retorno o json
			$vRetornoEnvio = $this->app->ConsultaDadosSoapIEPTB($xml_data);


			// testa se vem mais do que um título

			if(count($titulos) > 1) {
				// pega o json e atualiza os campos no banco com o status da integração e se deu erro em algum titulo
				for ($i=0; $i < count($vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']); $i++) { 
					if ($vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['resposta']['codigo'] == 'WS_SUC_201') {
						$dados = array(
							'TIT_STATUS_ENVIO' => 'S',
							'TIT_STATUS_IEPTB' => 'CL',
							'TIT_DATA_ENVIO'   => date('Y-m-d')
						);

	  
						  $this->db->update('titulos', $dados, array("TIT_NUMERO_TITULO_IEPTB" => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['divida']['nossoNumero'], "TIT_ID" => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['divida']['numero']));
						
						  $vParametrizacao = $this->app->BuscaParametrizacaoSistema();
						  $vURLEnvio = $vParametrizacao['vWinthorUrl'];
						  $vCobranca = $vParametrizacao['vCobranca'];

						  $user_data = $this->session->userdata('logged_in');
						  $codfuncultalter = $user_data['sessao_id_winthor'];

						  $idConjunto = $this->getIdConjunto($vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['divida']['nossoNumero']);

						  if($idConjunto != null) {

							  $arrayEnvioAPI = array(
								  'cobranca' 		=> $vCobranca, 
								  'codfuncultalter' => $codfuncultalter,
								  'prest'			=> $idConjunto['prestacao'],
								  'numtransvenda' 	=> $idConjunto['numtransvenda'],
								  'codfilial' 		=> $idConjunto['filial']
							  );
							
								$ch = curl_init();
								$url =  $vURLEnvio.'/atualizaCobrancatitulos';
								
								$request_headers = array("Content-Type:" . 'application/json');
						
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
								curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arrayEnvioAPI));
									
								$resp = curl_exec($ch);
								curl_close($ch);
						
								$arrayResult = json_decode($resp);

						  }
					}
					
					$vDadosRetorno[] = array(
						'vNossoNumero'    => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['divida']['nossoNumero'],
						'vVencimento'     => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['divida']['vencimento'],
						'vCodigoMensagem' => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['resposta']['codigo'],
						'vMensagem'       => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['resposta']['mensagem'],
						'vDevedor'        => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo'][$i]['devedor']['documento']
					);
				}
			} else {
				// pega o json e atualiza os campos no banco com o status da integração e se deu erro em algum titulo
				for ($i=0; $i < count($vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']); $i++) { 
					if ($vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['resposta']['codigo'] == 'WS_SUC_201') {
						$dados = array(
							'TIT_STATUS_ENVIO' => 'S',
							'TIT_STATUS_IEPTB' => 'CL',
							'TIT_DATA_ENVIO'   => date('Y-m-d')
						);
	  
						  $this->db->update('titulos', $dados, array("TIT_NUMERO_TITULO_IEPTB" => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['divida']['nossoNumero'], "TIT_ID" => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['divida']['numero']));
						
						  $vParametrizacao = $this->app->BuscaParametrizacaoSistema();
						  $vURLEnvio = $vParametrizacao['vWinthorUrl'];
						  $vCobranca = $vParametrizacao['vCobranca'];

						  $user_data = $this->session->userdata('logged_in');
						  $codfuncultalter = $user_data['sessao_id_winthor'];

						  $idConjunto = $this->getIdConjunto($vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['divida']['nossoNumero']);

						  if($idConjunto != null) {

							  $arrayEnvioAPI = array(
								  'cobranca' 		=> $vCobranca, 
								  'codfuncultalter' => $codfuncultalter,
								  'prest'			=> $idConjunto['prestacao'],
								  'numtransvenda' 	=> $idConjunto['numtransvenda'],
								  'codfilial' 		=> $idConjunto['filial']
							  );
							
								$ch = curl_init();
								$url =  $vURLEnvio.'/atualizaCobrancatitulos';
								
								$request_headers = array("Content-Type:" . 'application/json');
						
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
								curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arrayEnvioAPI));
									
								$resp = curl_exec($ch);
								curl_close($ch);
						
								$arrayResult = json_decode($resp);

						  }
						  
						  
					}
					
					$vDadosRetorno = array(
						'vNossoNumero'    => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['divida']['nossoNumero'],
						'vVencimento'     => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['divida']['vencimento'],
						'vCodigoMensagem' => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['resposta']['codigo'],
						'vMensagem'       => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['resposta']['mensagem'],
						'vDevedor'        => $vRetornoEnvio['soap_Body']['ns2_EnviarTituloResponse']['titulo']['devedor']['documento']
					);
				}
			}


			
			return $vDadosRetorno;
		} else {
			return 'Erro na configuracao'; 
		}
	}

	function getIdConjunto($vNossoNumero) {
		$dados = array();
		$sql = " SELECT T.TIT_NUMTRANSVENDA, T.TIT_FILIAL, T.TIT_PRESTACAO FROM titulos T WHERE T.TIT_NUMERO_TITULO_IEPTB = ? LIMIT 1";
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

	function carregaEndosso() {

		$dados = array();
		$sql   = " SELECT END_VALUE, END_DESC FROM endosso WHERE END_ID > 0 ORDER BY END_DESC ";
		$query = $this->db->query($sql);
  
		if ($query->num_rows() > 0){
  		    foreach ($query->result() as $row) {
			   $dados[] = array(
					'vValue' => $row->END_VALUE,
  					'vDesc'  => $row->END_VALUE.' - '.$row->END_DESC
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
  					'vValue' => $row->MOT_VALUE,
  					'vDesc'  => $row->MOT_VALUE.' - '.$row->MOT_DESC
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
  					'vValue' => $row->PORT_VALUE,
  					'vDesc'  => $row->PORT_VALUE.' - '.$row->PORT_DESC
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

	function AtualizaInformacoesTitulos($vEndosso, $vMotivo, $vAceite, $vPortador, $vEspecie, $vTitulos){

		try{

			$dados = array(
			          'TIT_MOTIVO'              => $vMotivo,
			          'TIT_TIPOENDOSSO'         => $vEndosso,
			          'TIT_ACEITE'              => $vAceite,
			          'TIT_DECLARACAO_PORTADOR' => $vPortador,
			          'TIT_ESPECIE'             => $vEspecie
			        );  
					
			for ($i=0; $i < count($vTitulos); $i++) { 
				$this->db->update('titulos', $dados, array("TIT_ID" => $vTitulos[$i]));
			}
			
			return true;
        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }
	}
}

