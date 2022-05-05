<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model {

	private $usuario;
	private $usuariolog;

    public function __construct(){
        parent::__construct();
        $this->load->helper('functions_helper');

 		$user_data = $this->session->userdata('logged_in');
		$this->usuario = $user_data['sessao_nome_user'];
		$this->usuariolog = $user_data['sessao_usuario_user'];
    }

    /*Funções para as notificações*/

		function notificacoesPadroes(){
			// Função para aplicar notificações
		}

		function buscaNotificacoes(){

		}

		function atualizaStatusNotificacao($codNotificacao, $lerNaoler, $excluir){

		}

		function geraNotificacao($descricao, $tipo, $notificacaoPadrao = 'N', $linkDirecionamento = null){ //tipos: S = Solicitações de Reservas | A = Avisos | Notificações padrões são as geradas pelo sistema. Do contrário, setar o parâmetro como N.

		}

    /*Funções para as notificações*/

	function retornaUsuario() {
		return $this->usuario;
	}

	function BuscaParametrizacaoSistema(){
		// Buscar os dados da tabela de parametro do sistema
		$dados = array();

        $sql = " SELECT CONF_ID,
						CONF_IDCLIENTEI7,
						CONF_PRODI7,
						CONF_DIAS_ENVIO_PROTESTO,
						CONF_WEB_SERVICE_IEPTB_URL,
						CONF_WEB_SERVICE_IEPTB_USUARIO,
						CONF_WEB_SERVICE_IEPTB_SENHA,
						CONF_TOKEN_IEPTB,
						CONF_DATA_CRIACAO_TOKEN,
						CONF_IEPTB_ACEITE_PADRAO,
						CONF_IEPTB_MOTIVO_PADRAO,
						CONF_IEPTB_PORTADOR_PADRAO,
						CONF_IEPTB_ESPECIE_PADRAO,
						CONF_IEPTB_ENDOSSO_PADRAO,
						CONF_WEB_SERVICE_WINTHOR,
						CONF_COBRANCA_PADRAO

                   FROM configuracoes
				   
                 WHERE CONF_ID = 1";

		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
        	foreach ($query->result() as $row) {
				$dados = array(
					'vID'                => $row->CONF_ID, 
					'vIDClienteI7'	     => $row->CONF_IDCLIENTEI7,
					'vProdutoI7'	     => $row->CONF_PRODI7,
					'vDiasEnvioProtesto' => $row->CONF_DIAS_ENVIO_PROTESTO,
					'vIEPTBUrl'          => $row->CONF_WEB_SERVICE_IEPTB_URL,
					'vIEPTBUsuario'      => $row->CONF_WEB_SERVICE_IEPTB_USUARIO,
					'vIEPTBSenha'        => $row->CONF_WEB_SERVICE_IEPTB_SENHA,
					'vToken'             => $row->CONF_TOKEN_IEPTB,
					'vDataToken'         => $row->CONF_DATA_CRIACAO_TOKEN,
					'vAceitePadrao'      => $row->CONF_IEPTB_ACEITE_PADRAO,
					'vMotivoPadrao'      => $row->CONF_IEPTB_MOTIVO_PADRAO,
					'vPortadorPadrao'    => $row->CONF_IEPTB_PORTADOR_PADRAO,
					'vEspeciePadrao'     => $row->CONF_IEPTB_ESPECIE_PADRAO,
					'vEndossoPadrao'     => $row->CONF_IEPTB_ENDOSSO_PADRAO,
					'vWinthorUrl'        => $row->CONF_WEB_SERVICE_WINTHOR,
					'vCobranca'			 => $row->CONF_COBRANCA_PADRAO
		       );  
        	}

            return $dados;
        } else {
		  return 'Erro na configuracao'; 
	    }
	}

	function VerificaVendedorCadastrado($idWinthor, $nome){
		$this->db->select('RCA_ID_WINTHOR FROM rca WHERE RCA_ID_WINTHOR = '.$idWinthor, false);
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			return 'ok';
		} else {
			$sql = "INSERT INTO rca (RCA_ID_WINTHOR, RCA_NOME) VALUES (".$idWinthor.", '".$nome."')";
			$this->db->query($sql);
			return 'Inseriu';
		}
	}

	function VerificaFilialCadastrada($idWinthor, $nome, $cnpj, $cidade, $cep, $bairro, $numero, $uf, $endereco){
		$this->db->select('FIL_ID_WINTHOR FROM filial WHERE FIL_ID_WINTHOR = '.$idWinthor, false);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){
			return 'ok';
		} else {
			// fazer uma consulta no winthor para trazer os outros dados de endereço da filial
			// Esse cadastro tem que estar completo para poder ser enviado os titulos
			$sql = "INSERT INTO filial (FIL_ID_WINTHOR, FIL_NOME, FIL_CNPJ, FIL_ENDERECO, FIL_NUMERO, FIL_CEP, FIL_BAIRRO, FIL_MUNICIPIO, FIL_UF) VALUES (".$idWinthor.", '".$nome."', '".$cnpj."', '".$endereco."', '".$numero."', '".$cep."', '".$bairro."', '".$cidade."', '".$uf."')";
			$this->db->query($sql);
			return 'Inseriu';
		}
	}

	function RemoverCaracteresEspeciais($valor) {

		return str_replace("'", '', $valor);
	}

	function ValidaTokenIEPTB(){
		
		// essa funçao tem que pegar os parametros no banco de dados e com eles fazer uma requisição pro ieptb gerar um novo token
		// esse token vai ser salvo na base de dados com a validade desse token, e será atualizado a cada 3 horas
		date_default_timezone_set('America/Sao_Paulo');
		$vParametrizacao = $this->BuscaParametrizacaoSistema();
		$vURLEnvio = $vParametrizacao['vIEPTBUrl'];
		$vUsuario  = $vParametrizacao['vIEPTBUsuario'];
		$vSenha    = $vParametrizacao['vIEPTBSenha'];

		//Calcula o tempo que foi gerado o ultimo token
		$vHoraGeradoToken = new DateTime($vParametrizacao['vDataToken']);
		$vHoraAtual       = new DateTime(date('Y-m-d H:i:s', time()));
		$Calculo          = $vHoraGeradoToken->diff($vHoraAtual);
		
		// calcula para criar um novo token a cada 3 horas, se tiver novas requisições
		if((($Calculo->h*60) + $Calculo->i) < 180){
			return $vParametrizacao['vToken'];
		} else {

			$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://grupobst.com.br/services">
				<soapenv:Header/>
				<soapenv:Body>
				<ser:Autenticar>
					<credenciais>
						<usuario>'.$vUsuario.'</usuario>
						<senha>'.$vSenha.'</senha>
					</credenciais>
				</ser:Autenticar>
				</soapenv:Body>
			</soapenv:Envelope>';
			
			$ch = curl_init($vURLEnvio);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			
			$plainXML = $this->mungXML(trim($output));
			$arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

			/*function printFind($item, $key){
				if($key == '[token]' or $key =='token'){
					return $item;
				}
			}*/

			$vToken = $arrayResult['soap_Body']['ns2_AutenticarResponse']['credenciais']['token'];
			
			// Função para salvar ele na base juntamente com a data
			$dados = array(
				'CONF_TOKEN_IEPTB'        => $vToken,
				'CONF_DATA_CRIACAO_TOKEN' => date('Y-m-d H:i:s', time())
			);  
		    
			$this->db->update('configuracoes', $dados, array("CONF_ID" => 1));
		
			return $vToken;
		}
	}

	function ConsultaDadosSoapIEPTB($xml_data){
		
		// Essa função vai receber a consulta que deve ser feita no servidor e retornar um vetor para ser tratado na propria tela de cada um
		$vParametrizacao = $this->BuscaParametrizacaoSistema();
		$vURLEnvio = $vParametrizacao['vIEPTBUrl'];
		
		$ch = curl_init($vURLEnvio);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		
		$plainXML = $this->mungXML(trim($output));
		$arrayResult = json_decode(json_encode(SimpleXML_Load_String(utf8_encode($plainXML), 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $arrayResult;
	}

	function ConsultaDadosJsonWinthor($dados){
		
		// Essa função vai receber a consulta que deve ser feita no servidor e retornar um vetor para ser tratado na propria tela de cada um
		$vParametrizacao = $this->BuscaParametrizacaoSistema();
		$vURLEnvio = $vParametrizacao['vWinthorUrl'];
		
		$ch = curl_init();
        $url =  'http://localhost:56369/titulos';
          
		$request_headers = array("Content-Type:" . 'application/json');

		$data = json_encode($dados); 

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
		$resp = curl_exec($ch);
		curl_close($ch);
		
		$arrayResult = json_decode($resp);
		return $arrayResult;
	}
	
	function mungXML($xml){
		// essa função é usada apenas para ajustar os caracteres que vem no xml do soap client
		$obj = SimpleXML_Load_String(utf8_encode($xml));
		if ($obj === FALSE) return $xml;
	
		$nss = $obj->getNamespaces(TRUE);
		if (empty($nss)) return $xml;
	
		$nsm = array_keys($nss);
		foreach ($nsm as $key) {
			$rgx
			= '#'             
			. '('             
			. '\<'            
			. '/?'            
			. preg_quote($key)
			. ')'             
			. '('             
			. ':{1}'          
			. ')'             
			. '#'             
			;
			$rep
			= '$1'      
			. '_'       
			;
			
			$xml =  preg_replace($rgx, $rep, $xml);
		}
		return $xml;
	}
}

