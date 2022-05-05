<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->model('App_model', 'app');
    }

	function buscaGruposCadastrados(){

		$tabela = 'perfilusuario';
		$requestData = $_REQUEST;

	    try{

		      $columns = array(
     					   0 => 'PERF_CODIGO',
     					   1 => 'PERF_NOME',
     					   2 => ''
     	                );

		      $dataFiltered  = $this->db->where('perfilusuario.PERF_CODIGO > 0')->get($tabela)->num_rows();   
		      $totalFiltered = $dataFiltered; 

		      if(!empty($requestData['search']['value']) ) {

		        $sql = " SELECT G.PERF_CODIGO,
        		        		G.PERF_NOME

        		           FROM $tabela G

		                 WHERE (G.PERF_CODIGO LIKE '%".$requestData['search']['value']."%' OR 
    	                        G.PERF_NOME   LIKE '%".$requestData['search']['value']."%'
		                        )
		                   AND G.PERF_CODIGO > 0

		                 ORDER BY ".$columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."   
		                 LIMIT ".$requestData['start']." ,".$requestData['length']."
		               ";

		        $query         = $this->db->query($sql);
		        $totalFiltered = $query->num_rows();
		      } else {

		        $sql = " SELECT G.PERF_CODIGO,
        		        		G.PERF_NOME

        		           FROM $tabela G
		                 WHERE G.PERF_CODIGO > 0 
		                 ORDER BY ".$columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."   
		                 LIMIT ".$requestData['start']." ,".$requestData['length']."
		               ";
              
		        $query = $this->db->query($sql);
  	        }

	      $dataRows = array();

			  foreach ($query->result() as $row) {
		        $nestedData = array(); 
		        $nestedData[] = $row->PERF_CODIGO;
		        $nestedData[] = $row->PERF_NOME;
		        $nestedData[] = ($row->PERF_CODIGO > 1) ? 
		        				"<a data-toggle='tooltip' title='Editar' class='fa fa-pencil-square-o' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='grupos.carregaGrupoCampo(".$row->PERF_CODIGO.", \"".$row->PERF_NOME."\")'></a>&nbsp;&nbsp;
								 <a data-toggle='tooltip' title='Definir Permissões' class='fa fa-eye' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='grupos.carregaPermissoes(".$row->PERF_CODIGO.")'></a>&nbsp;&nbsp;
								 <a data-toggle='tooltip' title='Excluir' class='fa fa-close' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='grupos.excluirPerfilUsuario(".$row->PERF_CODIGO.")'></a>"
								 :
								 "<a data-toggle='tooltip' title='Definir Permissões' class='fa fa-eye' aria-hidden='true' style='cursor: pointer; font-size: 20px;' onclick='grupos.carregaPermissoes(".$row->PERF_CODIGO.")'></a>&nbsp;&nbsp;";
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

	function buscaItensPermissoes($perfil){

		$retorno = '<input id="" name="" value="" type="checkbox" style="display: none;"/>';
    	$sql = " SELECT M.MENU_CODIGO, M.MENU_NOME FROM menu M ";
        $queryMenu = $this->db->query($sql, array($perfil));
        foreach ($queryMenu->result() as $menu) {
	        $sql       = " SELECT TELA_CODIGO, TELA_NOME FROM tela WHERE MENU_CODIGO = ? ";
	        $queryTela = $this->db->query($sql, ($menu->MENU_CODIGO));
	 		$retorno .= ' <div class="col-xs-12 col-sm-6 col-md-4">';
	 		$retorno .= '  <div class="panel panel-default">';
			$retorno .= '   <div class="panel-heading">'.$menu->MENU_NOME;
				$rowsMenu = 0;
		        $rowsMenu = $this->db->get_where('acessomenu', array('MENU_CODIGO' => $menu->MENU_CODIGO, 'PERF_CODIGO' => $perfil))->num_rows(); 
	            $vPermissaoMenu = ($rowsMenu > 0) ? "checked" : "";

			if(!in_array($menu->MENU_NOME, array('Início', 'Pessoas', ($perfil == 1) ? 'Configurações' : ''))){

	            $retorno .= '      <div class="material-switch pull-right">';
	            $retorno .= '          <input id="menu'.$menu->MENU_CODIGO.'" name="menu'.$menu->MENU_CODIGO.'" value="'.$menu->MENU_CODIGO.'" type="checkbox" '.$vPermissaoMenu.' onClick="grupos.ativaDesativaPermissao('.$menu->MENU_CODIGO.', '.$perfil.', 1)"/>';
	            $retorno .= '          <label for="menu'.$menu->MENU_CODIGO.'" class="label-primary"></label>';
	            $retorno .= '      </div>';
        	}else{
	            $retorno .= '      <div class="pull-right">';
	            $retorno .= '          <label class="">Obrigatório</label>';
	            $retorno .= '      </div>';
        	}

			$retorno .= ' </div>';

            $retorno .= '    <ul class="list-group">';
	            foreach($queryTela->result() as $tela) {
	            	$rows = $this->db->get_where('acessotela', array('TELA_CODIGO' => $tela->TELA_CODIGO, 'PERF_CODIGO' => $perfil))->num_rows(); 
	            	$vPermissaoTela = ($rows > 0) ? "checked" : "";
	                if(!($perfil > 1 && $tela->TELA_NOME == 'Grupos de Usuários')){
		                $retorno .= ' <li class="list-group-item">';
		                $retorno .=  $tela->TELA_NOME;
		                	if(!in_array($tela->TELA_NOME, array(($perfil == 1) ? 'Grupos de Usuários' : ''))){
				                $retorno .= '    <div class="material-switch pull-right">';
				                $retorno .= '        <input id="tela'.$tela->TELA_CODIGO.'" name="tela'.$tela->TELA_CODIGO.'" value="'.$tela->TELA_CODIGO.'" type="checkbox" '.$vPermissaoTela.' onClick="grupos.ativaDesativaPermissao('.$tela->TELA_CODIGO.', '.$perfil.', 0)"/>';
				                $retorno .= '        <label for="tela'.$tela->TELA_CODIGO.'" class="label-primary"></label>';
				                $retorno .= '    </div>';
				        	}else{
					            $retorno .= '      <div class="pull-right">';
					            $retorno .= '          <label class="">Obrigatório</label>';
					            $retorno .= '      </div>';
				        	}

		                $retorno .= ' </li> ';
		            }
	            }

	 		$retorno .= '    </ul>';
	        $retorno .= '  </div> ';
	        $retorno .= ' </div> ';
        }

        return $retorno;
	}

	function atualizaPermissoes($perfil, $codigo, $tipo, $checked){

		$id = 0;
		if($tipo){
			if($checked == 'S'){
		    	$this->db->insert('acessomenu', array('PERF_CODIGO' => $perfil, 'MENU_CODIGO' => $codigo));
			}else{        	
	        	$sql = " SELECT TELA_CODIGO FROM tela WHERE MENU_CODIGO = ? ";
	        	$queryTela = $this->db->query($sql, ($codigo));		
				if ($queryTela->num_rows() > 0){
		            foreach($queryTela->result() as $tela) {
		            	$this->db->delete('acessotela', array('PERF_CODIGO' => $perfil, 'TELA_CODIGO' => $tela->TELA_CODIGO));
		            }	
		        }

				$this->db->delete('acessomenu', array('PERF_CODIGO' => $perfil, 'MENU_CODIGO' => $codigo)); 	
			}

			$id = $this->db->affected_rows();
		}else{
			if($checked == 'S'){
		    	$this->db->insert('acessotela', array('PERF_CODIGO' => $perfil, 'TELA_CODIGO' => $codigo));
			}else{        	
				$this->db->delete('acessotela', array('PERF_CODIGO' => $perfil, 'TELA_CODIGO' => $codigo)); 	
			}
			$id = $this->db->affected_rows();
		}

		return $id;
	}

	function salvaGrupo($form){

        try{
	        $values = array();
	      
	        parse_str($form, $values);

	        $this->db->select_max('PERF_CODIGO');
	        $result = $this->db->get('perfilusuario');
	        $result = $result->row();
	        $maxCod = $result->PERF_CODIGO + 1; 

	        $codigo = ($values['edEditar'] == 'S') ? $values['edCodigo'] : $maxCod;

			$dados = array(
			          'PERF_CODIGO' => $codigo,
			          'PERF_NOME'   => $values['edNomeGrupo']
			        );  

			$campos = array(array('descricao' => 'Nome Grupo', 'campoBanco' => 'PERF_NOME', 'dado' => $values['edNomeGrupo'], 'configuracao' => false));
			
			if($values['edEditar'] == 'S'){  
			    $this->db->update('perfilusuario', $dados, array("PERF_CODIGO" => $codigo));
			} else {

			    $this->db->insert('perfilusuario', $dados);
			    $this->db->insert('acessomenu', array('PERF_CODIGO' => $codigo, 'MENU_CODIGO' => 1));
			}

			$id = $this->db->affected_rows();
			return ($id);
        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }
	}

	function excluiPerfilUsusario($perfil){

		try{

			$rows = $this->db->get_where('usuario', array('PERF_CODIGO' => $perfil))->num_rows(); 
			if($rows > 0){
				return 0;
			}else{
				$this->db->delete('acessomenu', array('PERF_CODIGO' => $perfil)); 	
				$this->db->delete('acessotela', array('PERF_CODIGO' => $perfil)); 	
				$this->db->delete('perfilusuario', array('PERF_CODIGO' => $perfil)); 	
			}

		    return ($this->db->affected_rows());
        } catch(PDOException $e) { 
           echo 'Erro: ' . $e->getMessage();
        }	
	}
}

