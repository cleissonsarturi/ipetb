<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->helper('functions_helper');
        $this->load->model('App_model', 'app');
    }

	function buscaUsuariosCadastrados(){

		$tabela = 'usuario';
		$requestData = $_REQUEST;

	    try{
		      $columns = array(
     					   0 => 'U.USU_NOME',
     					   1 => 'P.PERF_NOME',
     					   2 => 'U.USU_SITUACAO',
     					   3 => ''
    	                );

		      $dataFiltered  = $this->db->get_where($tabela)->num_rows();   
		      $totalFiltered = $dataFiltered; 

		      if(!empty($requestData['search']['value']) ) {
		        $sql = " SELECT U.USU_CODIGO,
		        				U.USU_NOME,
        		        		P.PERF_NOME,
        		        		U.USU_SITUACAO
        		           FROM $tabela U 
        		           INNER JOIN perfilusuario P 
        		              ON P.PERF_CODIGO = U.PERF_CODIGO
		                 WHERE (U.USU_NOME  LIKE '%".$requestData['search']['value']."%' OR 
		                        P.PERF_NOME LIKE '%".$requestData['search']['value']."%'
		                       )
		                   AND U.USU_CODIGO > 0
		                 ORDER BY ".$columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."   
		                 LIMIT ".$requestData['start']." ,".$requestData['length']."
		               ";

		        $query         = $this->db->query($sql);
		        $totalFiltered = $query->num_rows();

		      } else {

		        $sql = " SELECT U.USU_CODIGO,
		        				U.USU_NOME,
        		        		P.PERF_NOME,
        		        		U.USU_SITUACAO
        		           FROM $tabela U 
        		           INNER JOIN perfilusuario P 
        		              ON P.PERF_CODIGO = U.PERF_CODIGO 
        		         WHERE U.USU_CODIGO > 0
		                 ORDER BY ".$columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."   
		                 LIMIT ".$requestData['start']." ,".$requestData['length']."
		               ";

		        $query = $this->db->query($sql);
		      }

		      $dataRows = array();

			  foreach ($query->result() as $row) {

		        $nestedData = array(); 
		        $nestedData[] = $row->USU_NOME;
		        $nestedData[] = $row->PERF_NOME;
		        $nestedData[] = ($row->USU_SITUACAO == 'A') ? 'Ativo' : 'Inativo';
		        $nestedData[] = "<a data-toggle='tooltip' title='Editar' class='fa fa-pencil-square-o' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='usuarios.carregaDadosUsuario(".$row->USU_CODIGO.")'></a>";
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

	function buscaGruposUsuario(){
		$dados = array();

		$sql   = " SELECT PERF_CODIGO, PERF_NOME FROM perfilusuario WHERE PERF_CODIGO > 0 ORDER BY PERF_NOME ";
		$query = $this->db->query($sql);

        if ($query->num_rows() > 0){
       	    foreach ($query->result() as $row) {

 		       $dados[] = array(
        			'vIdGrupo'   => $row->PERF_CODIGO,
        			'vNomeGrupo' => $row->PERF_NOME
 		       );  
        	 }
            return $dados;
        } else {
	      return null;
	    }
	}

	function salvaUsuario($form, $responsavel){
        try{

	        $values = array();
	        parse_str($form, $values);

	        $this->db->select_max('USU_CODIGO');
	        $result = $this->db->get('usuario');
	        $result = $result->row();
	        $maxCod = $result->USU_CODIGO + 1; 

	        $codigo = ($values['edEditar'] == 'S') ? $values['edCodigo'] : $maxCod;

	        if($values['edEditar'] == 'S'){
	            $senhaCript = $values['edSenhaUsuario'];
	            if (strlen($senhaCript) != 60) {
	              $senhaCript = criptografaSenha($values['edSenhaUsuario']);
	            }
	        }else{
	        	$senhaCript = criptografaSenha($values['edSenhaUsuario']);
	        }

			$dados = array(
			          'USU_CODIGO'               => $codigo,
			          'USU_NOME'                 => $values['edNomeUsuario'],
			          'USU_EMAIL'                => $values['edEmailUsuario'],
			          'USU_USUARIO'              => $values['edLoginUsuario'],
			          'USU_SENHA'                => $senhaCript,
			          'PERF_CODIGO'              => $values['cbGrupoUsuario'],
			          'USU_TROCA_SENHA_ACESSO'   => $values['cbAlterarSenhaUsuario'],
			          'USU_SITUACAO'             => $values['cbSituacaoUsuario'],
			          'USU_RESPONSAVEL_CADASTRO' => $responsavel,
					  'USU_ID_WINTHOR'			 => $values['edIdWinthor']
			        );  

			if($values['edEditar'] == 'S'){  
			    $this->db->update('usuario', $dados, array("USU_CODIGO" => $codigo));
			} else {
			    $this->db->insert('usuario', $dados);
			}

			$id = $this->db->affected_rows();
			return ($id);
        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }
	}

	function excluiUsuario($codUsuario){

		try{
			$this->db->delete('usuario', array('USU_CODIGO' => $codUsuario));
		    return ($this->db->affected_rows());
        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }	
	}

	function buscaDadosUsuario($id){
     	$dados = array();

        $sql = " SELECT U.USU_NOME,
						U.USU_EMAIL,
						U.USU_USUARIO,
						U.USU_SENHA,
						U.USU_SITUACAO,
						U.USU_RESPONSAVEL_CADASTRO,
						U.PERF_CODIGO,
			 			U.USU_TROCA_SENHA_ACESSO,
						U.USU_ID_WINTHOR
                   FROM usuario U
                 WHERE U.USU_CODIGO = ?
        	   ";

		$query = $this->db->query($sql, array($id));

        if ($query->num_rows() > 0){
        	 foreach ($query->result() as $row) {
		       $dados = array(
					'vNome'        => $row->USU_NOME, 
					'vEmail'	   => $row->USU_EMAIL,
					'vUsuario'	   => $row->USU_USUARIO,
					'vSenha'       => $row->USU_SENHA,
					'vSituacao'	   => $row->USU_SITUACAO,
					'vResponsavel' => $row->USU_RESPONSAVEL_CADASTRO,
					'vPerfil'	   => $row->PERF_CODIGO,
					'vTrocaSenha'  => $row->USU_TROCA_SENHA_ACESSO,
					'vIdWinthor'   => $row->USU_ID_WINTHOR
		       );  
        	}

            return $dados;
        } else {
	      return null;
	    }
	}
}
