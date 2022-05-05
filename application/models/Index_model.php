<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_model extends CI_Model {

     public function __construct(){
        parent::__construct();
     }

     function login($data){

		$this->db->select('U.USU_CODIGO, U.USU_ID_WINTHOR, U.USU_USUARIO, U.USU_NOME, U.USU_SENHA, U.PERF_CODIGO, P.PERF_NOME, U.USU_TROCA_SENHA_ACESSO')    
		         ->from('usuario U')
		         ->join('perfilusuario P', ' U.PERF_CODIGO = P.PERF_CODIGO')
		         ->where('U.USU_USUARIO', $data['username'])
		         ->where('U.USU_SITUACAO', 'A')
		         ->limit(1);
		
		$query = $this->db->get()->row();
		
		if(count($query) == 1){
			if (crypt($data['password'], $query->USU_SENHA) === $query->USU_SENHA){
		       $dados = array(
		         'cod'        => $query->USU_CODIGO,
				 'idWinthor'  => $query->USU_ID_WINTHOR,
		         'usuario'    => $query->USU_USUARIO,
		         'nome'       => $query->USU_NOME,
		         'codPerfil'  => $query->PERF_CODIGO,
		         'nomePerfil' => $query->PERF_NOME,
		         'trocaSenha' => $query->USU_TROCA_SENHA_ACESSO
		       ); 
		       return $dados;
			}else{
			   return null;
			}
		}else{
		   return null;
		}

    }

    function changePassword($user, $senhaAtual, $senhaNova, $confirmaSenha){
		$this->db->select('U.USU_SENHA')    
		         ->from('usuario U')
		         ->where('U.USU_CODIGO', $user)
		         ->where('U.USU_SITUACAO', 'A')
		         ->limit(1);
		$query = $this->db->get()->row();
		         
		if(crypt($senhaAtual, $query->USU_SENHA) === $query->USU_SENHA){
			if ($senhaNova == $confirmaSenha){
				if (!(crypt($senhaNova, $query->USU_SENHA) === $query->USU_SENHA)){
					$this->db->update('usuario', array('USU_SENHA' => criptografaSenha($senhaNova), 'USU_TROCA_SENHA_ACESSO' => 'N'), array("USU_CODIGO" => $user));
					return $this->db->affected_rows();
				}else{
					return "A nova senha deve ser diferente da senha antiga";	
				}
			}else{
				return "Nova senha e confirmação de senha não conferem";
			}
		}else{
			return "A senha atual está incorreta";
		}
    }

    function auth($codPerfil, $dataCI){
    	$telas = array();

    	$sql = " SELECT M.MENU_CAMINHO AS CAMINHO
				   FROM menu M
				   INNER JOIN acessomenu ACM
				 	  ON M.MENU_CODIGO = ACM.MENU_CODIGO
				 WHERE ACM.PERF_CODIGO = ?
				   AND M.MENU_CAMINHO IS NOT NULL
 
				 UNION 
 
				 SELECT T.TELA_CAMINHO AS CAMINHO
				   FROM tela T
				   INNER JOIN acessotela ACT
				      ON T.TELA_CODIGO = ACT.TELA_CODIGO
				 WHERE ACT.PERF_CODIGO = ?
				   AND T.TELA_CAMINHO IS NOT NULL   
    			";
    	$query = $this->db->query($sql, array($codPerfil, $codPerfil));
        if ($query->num_rows() > 0){
        	 foreach ($query->result() as $row) {
        	 	 array_push($telas, strtolower($row->CAMINHO));
        	 }
        }

        $telaAtual  = ($dataCI['method'] != '') ? $dataCI['controller'].'/'.$dataCI['method'] : $dataCI['controller'];
        if (in_array(strtolower($telaAtual), $telas)){
        	return true;
        }else{
        	return false;
        }
    }

	function menu(){

     	$dados     = array();
     	$user_data = $this->session->userdata('logged_in');

        $sql = " SELECT M.MENU_CODIGO,
						M.MENU_NOME,
				        M.MENU_ICONE,
				        M.MENU_SUBMENU,
						M.MENU_CAMINHO
				   FROM menu M
                   INNER JOIN acessomenu ACM
            		  ON M.MENU_CODIGO = ACM.MENU_CODIGO
            	 WHERE ACM.PERF_CODIGO = ?
				 ORDER BY M.MENU_POSICAO ASC
        	   ";

		$query = $this->db->query($sql, array($user_data['sessao_cod_perfil']));

        if ($query->num_rows() > 0){
        	 foreach ($query->result() as $row) {
		       $dados[] = array(
		         'idMenu'       => $row->MENU_CODIGO,
		         'nome'         => $row->MENU_NOME,
		         'icone'        => $row->MENU_ICONE,
		         'submenu'      => $row->MENU_SUBMENU,
		         'caminho'      => $row->MENU_CAMINHO,
		         'itensSubMenu' => $this->subMenu($row->MENU_CODIGO, $user_data['sessao_cod_perfil'])
		       );  
        	 }
            return $dados;
        } else {
	      return null;
	    }

	 }  

	function subMenu($menu, $codPerfil){
     	
     	$dados = array();

        $sql = " SELECT T.TELA_NOME,
						T.TELA_CAMINHO
			       FROM tela T
                   INNER JOIN acessotela ACT
                      ON T.TELA_CODIGO = ACT.TELA_CODIGO
				 WHERE T.MENU_CODIGO = ? AND ACT.PERF_CODIGO = ?
			     ORDER BY T.TELA_CODIGO ASC
        	   ";

		$query = $this->db->query($sql, array($menu, $codPerfil));

        if ($query->num_rows() > 0){
        	 foreach ($query->result() as $row) {
		       $dados[] = array(
		         	'subNome'      => $row->TELA_NOME,
		         	'subCaminho'   => $row->TELA_CAMINHO
		       );  
        	 }
            return $dados;
        } else {
	      return null;
	    }
	 } 

     function configuracoes($id){

        $sql = " SELECT C.CONF_NOME,
						C.CONF_CPF_CNPJ,
						C.CONF_ENDERECO,
						CD.CID_NOME,
						E.EST_NOME,
						C.CONF_TELEFONE_1,
						C.CONF_TELEFONE_2,
						C.CONF_LOGO,
						C.CONF_PLANO
			       FROM configuracoes C
                   INNER JOIN cidades CD
                      ON CD.CID_ID = C.CID_ID
                   INNER JOIN estados E 
                      ON E.EST_ID = C.EST_ID
                 WHERE C.CONF_ID = ?
			     LIMIT 1;
        	   ";

		$query = $this->db->query($sql, array($id));
		
        if ($query->num_rows() > 0){
        	 foreach ($query->result() as $row) {
		       $dados = array(
		         'nome'      => $row->CONF_NOME,
		         'cpf_cnpj'  => $row->CONF_CPF_CNPJ,
		         'endereco'  => $row->CONF_ENDERECO,
		         'cidade'    => $row->CID_NOME,
		         'estado'    => $row->EST_NOME,
		         'telefone1' => $row->CONF_TELEFONE_1,
		         'telefone2' => $row->CONF_TELEFONE_2,
		         'logo'      => $row->CONF_LOGO,
		         'plano'     => $row->CONF_PLANO
		       ); 
			}
	       return $dados;
		}else{
		   return null;
		}
    }

	function buscaQtdDados($tipo, $vData) {
		$dados = array();

		$vMes = substr($vData, 0, -5);
		$vAno = substr($vData, 3);
		

		if($tipo == 'E') {			
			//enviados
			$sql = " SELECT COUNT(T.TIT_ID) as QTD, format(SUM(T.TIT_SALDO), 2,'de_DE') as VALOR
						FROM titulos T
					  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_ENVIO = 'S' AND T.TIT_STATUS_IEPTB NOT IN ('CA') ";
		} else if($tipo == 'P') {
			$sql = " SELECT COUNT(T.TIT_ID) as QTD, format(SUM(T.TIT_SALDO), 2,'de_DE') as VALOR
						FROM titulos T
					  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_IEPTB IN ('PA', 'FI') ";
		} else if($tipo == 'A') {
			$sql = " SELECT COUNT(T.TIT_ID) as QTD, format(SUM(T.TIT_SALDO), 2,'de_DE') as VALOR
						FROM titulos T
					  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_IEPTB NOT IN ('PA', 'CA', 'FI') ";
		}

		$query = $this->db->query($sql, array($vAno, $vMes));

		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$dados = array('quantia' => $row->QTD, 'valor' => 'R$ '.$row->VALOR);
			}
			return $dados;
		} else {
			return null;
		}
	}

	function buscaDados($tipo, $vData) {

		$dados = array();

		if($vData == 'atual') {

			$vAno = date('Y');
			$vMes = date('m');

			if($tipo == 'E') {			
				//enviados
				$sql = " SELECT T.TIT_NUMERO_TITULO_WINTHOR,
								T.TIT_ID,
								format(T.TIT_SALDO, 2,'de_DE') as TIT_SALDO,
								DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO,
								C.CLI_NOME
							FROM titulos T INNER JOIN
								cliente C
									ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
						  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_ENVIO = 'S'  AND T.TIT_STATUS_IEPTB NOT IN ('CA') ";

			} else if($tipo == 'P') {
				//pagos
				$sql = "SELECT T.TIT_NUMERO_TITULO_WINTHOR,
								T.TIT_ID,
								format(T.TIT_SALDO, 2,'de_DE') as TIT_SALDO,
								DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO,
								C.CLI_NOME
							FROM titulos T INNER JOIN
								cliente C
									ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
						  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_IEPTB IN ('PA', 'FI')";

			} else if($tipo == 'A') {
				//em aberto
				$sql = " SELECT T.TIT_NUMERO_TITULO_WINTHOR,
								T.TIT_ID,
								format(T.TIT_SALDO, 2,'de_DE') as TIT_SALDO,
								DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO,
								C.CLI_NOME
							FROM titulos T INNER JOIN
								cliente C
									ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
						  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_IEPTB NOT IN ('PA', 'CA', 'FI')";
			}
	
			$query = $this->db->query($sql, array($vAno, $vMes));
		
		} else {
			$vMes = substr($vData, 0, -5);
			$vAno = substr($vData, 3);
			
			if($tipo == 'E') {			
				//enviados
				$sql = " SELECT T.TIT_NUMERO_TITULO_WINTHOR,
								T.TIT_ID,
								format(T.TIT_SALDO, 2,'de_DE') as TIT_SALDO,
								DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO,
								C.CLI_NOME
							FROM titulos T INNER JOIN
								cliente C
									ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
						  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_ENVIO = 'S' AND T.TIT_STATUS_IEPTB NOT IN ('CA') ";

			} else if($tipo == 'P') {
				//pagos
				$sql = "SELECT T.TIT_NUMERO_TITULO_WINTHOR,
								T.TIT_ID,
								format(T.TIT_SALDO, 2,'de_DE') as TIT_SALDO,
								DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO,
								C.CLI_NOME
							FROM titulos T INNER JOIN
								cliente C
									ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
						  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_IEPTB IN ('PA', 'FI')";

			} else if($tipo == 'A') {
				//em aberto
				$sql = " SELECT T.TIT_NUMERO_TITULO_WINTHOR,
								T.TIT_ID,
								format(T.TIT_SALDO, 2,'de_DE') as TIT_SALDO,
								DATE_FORMAT(T.TIT_DATA_VENCIMENTO, '%d/%m/%Y') AS TIT_DATA_VENCIMENTO,
								C.CLI_NOME
							FROM titulos T INNER JOIN
								cliente C
									ON C.CLI_ID_WINTHOR = T.TIT_ID_CLIENTE
						  WHERE YEAR(T.TIT_DATA_VENCIMENTO) = ? AND MONTH(T.TIT_DATA_VENCIMENTO) = ? AND T.TIT_STATUS_IEPTB NOT IN ('PA', 'CA', 'FI')";
			}
	
			$query = $this->db->query($sql, array($vAno, $vMes));
		}


		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$dados[] = array(
								 'nossoNumero' => $row->TIT_NUMERO_TITULO_WINTHOR,
								 'id' 		   => $row->TIT_ID,
								 'saldo' 	   => $row->TIT_SALDO,
								 'data' 	   => $row->TIT_DATA_VENCIMENTO,
								 'cliente'     => $row->CLI_NOME
				);
			}
			return $dados;
		} else {
			return null;
		}

	}

}
