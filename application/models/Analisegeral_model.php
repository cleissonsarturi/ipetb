<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisegeral_model extends MY_Model  {

    public function __construct(){
        parent::__construct();
        $this->load->helper('functions_helper');
        $this->load->model('App_model', 'app');
    }


	function carregaComboSupervisores($vVisaoRelatorio){

	    $dados = array();

	    if ($vVisaoRelatorio == 'Ger') {
	    	// consultas que aparece os gerentes
	    	$sql = "SELECT CODGERENTE, NOMEGERENTE FROM PCGERENTE";

		    $query = $this->db2->query($sql);

		    if ($query->num_rows() > 0){
		    	$dados[] = array(
		          'IdSuper'   => 0,
		          'nomeSuper' => 'GERAL'
		        );
		      foreach ($query->result() as $row) {
		        $dados[] = array(
		          'IdSuper'   => $row->CODGERENTE,
		          'nomeSuper' => $row->NOMEGERENTE
		        );
		      }
			     return $dados;
		    } else {
		      return null;
		    }
	    } else if ($vVisaoRelatorio == 'sup') {
	    	// consulta que aparece os supervisores

	    	$sql = "SELECT CODSUPERVISOR, NOME FROM PCSUPERV WHERE CODSUPERVISOR NOT IN (5, 3, 4)";

		    $query = $this->db2->query($sql);

		    if ($query->num_rows() > 0){
		      foreach ($query->result() as $row) {
		        $dados[] = array(
		          'IdSuper'   => $row->CODSUPERVISOR,
		          'nomeSuper' => $row->NOME
		        );
		      }
			     return $dados;
		    } else {
		      return null;
		    }
	    } else {
	    	// consulta que aparece os vendedores
	    	$sql = "SELECT CODUSUR, NOME FROM PCUSUARI WHERE CODUSUR NOT IN (31,70,30,29,17,18,19,20,3,52,32, 121,133)";

		    $query = $this->db2->query($sql);

		    if ($query->num_rows() > 0){
		      foreach ($query->result() as $row) {
		        $dados[] = array(
		          'IdSuper'   => $row->CODUSUR,
		          'nomeSuper' => $row->NOME
		        );
		      }
			     return $dados;
		    } else {
		      return null;
		    }
	    }

	}


    function buscaAnaliseSupervisor($vSupervisor, $vDataInicial, $vDataFinal, $vTipoRelatorio, $vVisaoRelatorio){
	    $dadosLancamentos = array();

	    //Zerando as variaveis
	    $vDiasRealizados = 0;
	    $vDiasUteisMes   = 0;

	    if ($vTipoRelatorio == 'M') {
	    	$vFatDia = '';
	    } else {
	    	$vDataFinal = $vDataInicial;
	    	$vFatDia = "AND PCNFSAID.HORALANC > 08 AND PCNFSAID.HORALANC < 19";
	    }

	    
	    
	    // busca dias uteis e quantidades de dias já realizados do mês
		/* Pegar o dia inicial e final de cada mês
		
		*/

		$partes = explode("/", $vDataInicial);
		
		if ($partes[1] == 1) {
			$vDataIniDias = '01/01/'.$partes[2];
			$vDataFimDia  = '31/01/'.$partes[2];
			$vNomeMes = "Janeiro";
		} else if ($partes[1] == 2) {
			$vDataIniDias = '01/02/'.$partes[2];
			$vDataFimDia  = '29/02/'.$partes[2];
			$vNomeMes = "Fevereiro";
		} else if ($partes[1] == 3) {
			$vDataIniDias = '01/03/'.$partes[2];
			$vDataFimDia  = '31/03/'.$partes[2];
			$vNomeMes = "Março";
		} else if ($partes[1] == 4) {
			$vDataIniDias = '01/04/'.$partes[2];
			$vDataFimDia  = '30/04/'.$partes[2];
			$vNomeMes = "Abril";
		} else if ($partes[1] == 5) {
			$vDataIniDias = '01/05/'.$partes[2];
			$vDataFimDia  = '31/05/'.$partes[2];
			$vNomeMes = "Maio";
		} else if ($partes[1] == 6) {
			$vDataIniDias = '01/06/'.$partes[2];
			$vDataFimDia  = '30/06/'.$partes[2];
			$vNomeMes = "Junho";
		} else if ($partes[1] == 7) {
			$vDataIniDias = '01/07/'.$partes[2];
			$vDataFimDia  = '31/07/'.$partes[2];
			$vNomeMes = "Julho";
		} else if ($partes[1] == 8) {
			$vDataIniDias = '01/08/'.$partes[2];
			$vDataFimDia  = '31/08/'.$partes[2];
			$vNomeMes = "Agosto";
		} else if ($partes[1] == 9) {
			$vDataIniDias = '01/09/'.$partes[2];
			$vDataFimDia  = '30/09/'.$partes[2];
			$vNomeMes = "Setembro";
		} else if ($partes[1] == 10) {
			$vDataIniDias = '01/10/'.$partes[2];
			$vDataFimDia  = '31/10/'.$partes[2];
			$vNomeMes = "Outubro";
		} else if ($partes[1] == 11) {
			$vDataIniDias = '01/11/'.$partes[2];
			$vDataFimDia  = '30/11/'.$partes[2];
			$vNomeMes = "Novembro";
		} else if ($partes[1] == 12) {
			$vDataIniDias = '01/12/'.$partes[2];
			$vDataFimDia  = '31/12/'.$partes[2];
			$vNomeMes = "Dezembro";
		} 

		if (date('m') == $partes[1]) {
		
			$sqlDatas = "SELECT 
							    (SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND '".$vDataFimDia."' AND DIAUTIL = 'S') DIASUTEIS,
								(SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND SYSDATE AND DIAUTIL = 'S') DIASREALIZADOS
						 
						 FROM PCDATAS 

						 WHERE DATA = TO_DATE(SYSDATE, 'DD/MM/YY')";
		} else {
			$sqlDatas = "SELECT 
							    (SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND '".$vDataFimDia."' AND DIAUTIL = 'S') DIASUTEIS,
								(SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND '".$vDataFimDia."' AND DIAUTIL = 'S') DIASREALIZADOS
						 
						 FROM PCDATAS 

						 WHERE DATA = TO_DATE(SYSDATE, 'DD/MM/YY')";
		}

	    $query = $this->db2->query($sqlDatas);

	    if ($query->num_rows() > 0){
	      foreach ($query->result() as $row) {
	    	
	    	$vDiasUteisMes   = $row->DIASUTEIS;
	        $vDiasRealizados = $row->DIASREALIZADOS;
	      }
	    }

	    if ($vTipoRelatorio == 'D') {
	    	$vDataFimDia = $vDataFinal;
	    } 



	    if ($vVisaoRelatorio == "sup") {
	    	// SQL que busca os dados
	      $sql = "SELECT DISTINCT (U.CODUSUR),
				       U.NOME,
				       U.CODSUPERVISOR,
				       '' AS CNPJ,
				       
				       -- META
				       nvl((SELECT to_char(SUM(PCMETARCA.VLVENDAPREV), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
				          FROM PCMETARCA
				          WHERE PCMETARCA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFimDia."'
				            AND PCMETARCA.CODFILIAL IN('1')
				            AND PCMETARCA.CODUSUR = U.CODUSUR
				       ),0)META,
				       
				       -- REALIZADO
				       nvl((SELECT to_char(SUM(VLTOTAL - nvl((SELECT SUM(QT*PBONIFIC) FROM PCMOV WHERE PCMOV.NUMNOTA = PCNFSAID.NUMNOTA AND CODOPER = 'SB'),0)), 'FM999G999G999D90', 'nls_numeric_characters='',.''') 
       
		                    FROM PCNFSAID 
		                   
		                    WHERE DTSAIDA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
		                      AND CODCOB <> 'BNF'
		                      AND PCNFSAID.CODFISCAL NOT IN (522, 622, 722, 532, 632, 732)
		                      AND PCNFSAID.CONDVENDA NOT IN (4, 8, 10, 13, 20, 98, 99)
		                      AND (PCNFSAID.DTCANCEL IS NULL)
		                      AND NVL(PCNFSAID.TIPOVENDA,'X') NOT IN ('SR', 'DF')
		                      ".$vFatDia."
		                      AND PCNFSAID.CODUSUR = U.CODUSUR
						       ),0) REALIZADO,
		               
		               -- DEVOLUCOES
		               nvl((SELECT to_char(SUM( NVL(m.QT, 0) * (NVL(m.PUNIT, 0) + NVL(m.VLOUTROS, 0))), 'FM999G999G999D90', 'nls_numeric_characters='',.''') AS DELV FROM PCMOV M, PCESTCOM E, PCNFENT  F
							         WHERE E.NUMTRANSENT = F.NUMTRANSENT AND M.NUMTRANSENT = F.NUMTRANSENT
							         AND M.CODOPER = 'ED' AND M.DTCANCEL IS NULL 
		      					   AND F.TIPODESCARGA IN ('6', '7', 'T')
		      					   AND NVL(F.CODFISCAL,0) IN (131, 132, 231, 232, 199, 299)
		      					   AND M.DTCANCEL IS NULL
		      					   AND NVL(F.TIPOMOVGARANTIA, -1) = -1
		      					   AND NVL(F.OBS, 'X') <> 'NF CANCELADA'
		                   AND M.CODUSUR = U.CODUSUR
		      
		      
		      					           AND M.CODFILIAL IN('1')
		      					           AND F.CODFILIAL IN('1')
		      					   AND F.DTENT BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
		      					                              TO_DATE('".$vDataFinal."', 'DD/MM/YYYY')
		               ),0) DEVOLUCAO,
		               
				       
				       -- NÃO FATURADO
				       nvl((SELECT to_char(SUM(PCPEDC.VLATEND), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
				          FROM PCPEDC
				          WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
				                AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
				                AND PCPEDC.DTCANCEL IS NULL
				                AND PCPEDC.POSICAO IN ('B', 'L', 'M', 'P')
				                AND PCPEDC.CODFILIAL IN('1')
				                AND PCPEDC.CODUSUR = U.CODUSUR
				       ),0)NAO_FATURADO,
				       
				       
				       -- VISITAS PREVISTAS
				       '' AS VISITAS_PREVISTAS,
				       
				       -- VISITAS REALIZADAS
				       nvl((SELECT COUNT(CODCLI) FROM
				              (SELECT DISTINCT CODCLI, DATA 
				                  FROM PCVISITA
				               WHERE PCVISITA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
				                 AND NVL(PCVISITA.TIPO,' ') <> 'C'
				                 AND PCVISITA.CODUSUR = U.CODUSUR

				       UNION

				               SELECT DISTINCT CODCLI, DATA
				                  FROM PCPEDC
				               WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
				                 AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
				                 --AND PCPEDC.DTCANCEL IS NULL
				                 AND PCPEDC.CODFILIAL IN('1')
				                 AND PCPEDC.CODUSUR = U.CODUSUR) VISITAS),0) VISITAS_REALIZADAS,
				        
				       -- VISITAS POSITIVADAS
				       NVL((SELECT COUNT(CODCLI) FROM
				                   (SELECT DISTINCT CODCLI, DATA
				                  FROM PCPEDC
				               WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
				                 AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
				                 AND PCPEDC.DTCANCEL IS NULL
				                 AND PCPEDC.CODFILIAL IN('1')
				                 AND PCPEDC.CODUSUR = U.CODUSUR)), 0)POSITIVADAS

				FROM PCUSUARI U

				WHERE CODSUPERVISOR NOT IN (5) 
				  AND CODUSUR NOT IN (17,18,19,20, 32, 31, 33, 25, 116, 119, 127, 121,133)
	  			  
			    AND U.CODSUPERVISOR = ".$vSupervisor."	  			 

				ORDER BY U.CODSUPERVISOR ";
	    } else if ($vVisaoRelatorio == "Ger") {
	    	// SQL que busca os dados
	        $sql = "SELECT U.CODSUPERVISOR as CODUSUR,
			               PCSUPERV.NOME,
			               '' AS CNPJ,
			               				       
					       -- META
					       nvl((SELECT to_char(SUM(PCMETARCA.VLVENDAPREV), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
					          FROM PCMETARCA, PCUSUARI

	                  WHERE PCMETARCA.CODUSUR = PCUSUARI.CODUSUR
					            AND PCMETARCA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFimDia."' 
					            AND PCMETARCA.CODFILIAL IN ('1')
					            AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR
					       ),0) META,
					       
					       -- REALIZADO
				       nvl((SELECT to_char(SUM(VLTOTAL - nvl((SELECT SUM(QT*PBONIFIC) FROM PCMOV WHERE PCMOV.NUMNOTA = PCNFSAID.NUMNOTA AND CODOPER = 'SB'),0)), 'FM999G999G999D90', 'nls_numeric_characters='',.''') 
       
		                    FROM PCNFSAID, PCUSUARI 
		                   
		                    WHERE DTSAIDA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
		                      AND CODCOB <> 'BNF'
		                      AND PCNFSAID.CODUSUR = PCUSUARI.CODUSUR
		                      AND PCNFSAID.CODFISCAL NOT IN (522, 622, 722, 532, 632, 732)
		                      AND PCNFSAID.CONDVENDA NOT IN (4, 8, 10, 13, 20, 98, 99)
		                      AND (PCNFSAID.DTCANCEL IS NULL)
		                      AND NVL(PCNFSAID.TIPOVENDA,'X') NOT IN ('SR', 'DF')
		                      ".$vFatDia."
		                      AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR
						       ),0) REALIZADO,
		               
		               -- DEVOLUCOES
		               nvl((SELECT to_char(SUM( NVL(m.QT, 0) * (NVL(m.PUNIT, 0) + NVL(m.VLOUTROS, 0))), 'FM999G999G999D90', 'nls_numeric_characters='',.''') AS DELV FROM PCMOV M, PCESTCOM E, PCNFENT  F, PCUSUARI
							         WHERE E.NUMTRANSENT = F.NUMTRANSENT AND M.NUMTRANSENT = F.NUMTRANSENT AND M.CODUSUR = PCUSUARI.CODUSUR
							         AND M.CODOPER = 'ED' AND M.DTCANCEL IS NULL 
		      					   AND F.TIPODESCARGA IN ('6', '7', 'T')
		      					   AND NVL(F.CODFISCAL,0) IN (131, 132, 231, 232, 199, 299)
		      					   AND M.DTCANCEL IS NULL
		      					   AND NVL(F.TIPOMOVGARANTIA, -1) = -1
		      					   AND NVL(F.OBS, 'X') <> 'NF CANCELADA'
		                   			AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR
		      
		      
		      					           AND M.CODFILIAL IN('1')
		      					           AND F.CODFILIAL IN('1')
		      					   AND F.DTENT BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
		      					                              TO_DATE('".$vDataFinal."', 'DD/MM/YYYY')
		               ),0) DEVOLUCAO,
					       
					       -- NÃO FATURADO
					       nvl((SELECT to_char(SUM(PCPEDC.VLATEND), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
					          FROM PCPEDC, PCUSUARI

	                  WHERE PCPEDC.CODUSUR = PCUSUARI.CODUSUR
					                AND PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'  
					                AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
					                AND PCPEDC.DTCANCEL IS NULL
					                AND PCPEDC.POSICAO IN ('B', 'L', 'M', 'P')
					                AND PCPEDC.CODFILIAL IN('1')
					                AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR
					       ),0)NAO_FATURADO,
					       
					       
					       -- VISITAS PREVISTAS
					       '' AS VISITAS_PREVISTAS,
					       
					       -- VISITAS REALIZADAS
					       nvl((SELECT COUNT(CODCLI) FROM
					              (SELECT DISTINCT CODCLI, DATA 
					                  FROM PCVISITA, PCUSUARI

	                       WHERE PCVISITA.CODUSUR = PCUSUARI.CODUSUR
					               AND PCVISITA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					                 AND NVL(PCVISITA.TIPO,' ') <> 'C'
					                 AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR

					       UNION

					               SELECT DISTINCT CODCLI, DATA
					                  FROM PCPEDC, PCUSUARI

	                       WHERE PCPEDC.CODUSUR = PCUSUARI.CODUSUR
					                 AND PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					                 AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
					                 --AND PCPEDC.DTCANCEL IS NULL
					                 AND PCPEDC.CODFILIAL IN('1')
					                 AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR) VISITAS),0) VISITAS_REALIZADAS,
					        
					       -- VISITAS POSITIVADAS
					       NVL((SELECT COUNT(CODCLI) FROM
					                   (SELECT DISTINCT CODCLI, DATA
					                  FROM PCPEDC, PCUSUARI

	                       WHERE PCPEDC.CODUSUR = PCUSUARI.CODUSUR
					                 AND PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					                 AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
					                 AND PCPEDC.DTCANCEL IS NULL
					                 AND PCPEDC.CODFILIAL IN('1')
					                 AND PCUSUARI.CODSUPERVISOR = U.CODSUPERVISOR)), 0)POSITIVADAS

					FROM PCUSUARI U, PCSUPERV

					WHERE U.CODSUPERVISOR  = PCSUPERV.CODSUPERVISOR
	          AND U.CODSUPERVISOR NOT IN (5, 3, 4) 
					  AND CODUSUR NOT IN (17,18,19,20, 32, 133)
		  			  
		  			 
	        GROUP BY U.CODSUPERVISOR, PCSUPERV.NOME
					ORDER BY U.CODSUPERVISOR";
	    } else {

	    	if ($vTipoRelatorio == 'D') {
		    	$vSQLRealizadoVend = "nvl((SELECT to_char(SUM(PCPEDC.VLATEND), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
						                  FROM PCPEDC
						                  WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
						                        AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
						                        AND PCPEDC.DTCANCEL IS NULL
						                        AND PCPEDC.POSICAO IN ('F')
						                        AND PCPEDC.CODFILIAL IN('1')
						                        AND PCPEDC.CODCLI = C.CODCLI
						               ),0) REALIZADO,

						               0 AS DEVOLUCAO,";
		    } else {
		    	$vSQLRealizadoVend = "nvl((SELECT to_char(SUM(VLTOTAL - nvl((SELECT SUM(QT*PBONIFIC) FROM PCMOV WHERE PCMOV.NUMNOTA = PCNFSAID.NUMNOTA AND CODOPER = 'SB'),0)), 'FM999G999G999D90', 'nls_numeric_characters='',.''') 
					       
					                    FROM PCNFSAID 
					                   
					                    WHERE DTSAIDA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
					                      AND CODCOB <> 'BNF'
					                      AND PCNFSAID.CODFISCAL NOT IN (522, 622, 722, 532, 632, 732)
					                      AND PCNFSAID.CONDVENDA NOT IN (4, 8, 10, 13, 20, 98, 99)
					                      AND (PCNFSAID.DTCANCEL IS NULL)
					                      ".$vFatDia."
					                      AND NVL(PCNFSAID.TIPOVENDA,'X') NOT IN ('SR', 'DF')
					                      AND PCNFSAID.CODCLI = C.CODCLI
					               ),0) REALIZADO,
									
					               nvl((SELECT to_char(SUM( NVL(m.QT, 0) * (NVL(m.PUNIT, 0) + NVL(m.VLOUTROS, 0))), 'FM999G999G999D90', 'nls_numeric_characters='',.''') AS DELV FROM PCMOV M, PCESTCOM E, PCNFENT  F
					                   WHERE E.NUMTRANSENT = F.NUMTRANSENT AND M.NUMTRANSENT = F.NUMTRANSENT
					                   AND M.CODOPER = 'ED' AND M.DTCANCEL IS NULL 
					                   AND F.TIPODESCARGA IN ('6', '7', 'T')
					                   AND NVL(F.CODFISCAL,0) IN (131, 132, 231, 232, 199, 299)
					                   AND M.DTCANCEL IS NULL
					                   AND NVL(F.TIPOMOVGARANTIA, -1) = -1
					                   AND NVL(F.OBS, 'X') <> 'NF CANCELADA'
					                   AND M.CODCLI = C.CODCLI
					      
					      
					                           AND M.CODFILIAL IN('1')
					                           AND F.CODFILIAL IN('1')
					                   AND F.DTENT BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
					                                              TO_DATE('".$vDataFinal."', 'DD/MM/YYYY')
					               ),0) DEVOLUCAO,

					               ";
		    }

	    	// SQL que busca os dados dos clientes 
	        $sql = "SELECT DISTINCT (C.CODCLI) AS CODUSUR,
					                 C.CLIENTE AS NOME,
					                 C.CGCENT AS CNPJ,
					               
					               -- META
					               '0.00' AS META,
					               
					               -- REALIZADO
					               ".$vSQLRealizadoVend."
					               					               
					               
					               -- NÃO FATURADO
					               nvl((SELECT to_char(SUM(PCPEDC.VLATEND), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
					                  FROM PCPEDC
					                  WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
					                        AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
					                        AND PCPEDC.DTCANCEL IS NULL
					                        AND PCPEDC.POSICAO IN ('B', 'L', 'M', 'P')
					                        AND PCPEDC.CODFILIAL IN('1')
					                        AND PCPEDC.CODCLI = C.CODCLI
					               ),0)NAO_FATURADO,
					               
					               
					               -- VISITAS PREVISTAS
					               '' AS VISITAS_PREVISTAS,
					               
					               -- VISITAS REALIZADAS
					               nvl((SELECT COUNT(CODCLI) FROM
					                      (SELECT DISTINCT CODCLI, DATA 
					                          FROM PCVISITA
					                       WHERE PCVISITA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					                         AND NVL(PCVISITA.TIPO,' ') <> 'C'
					                         AND PCVISITA.CODCLI = C.CODCLI

					               UNION

					                       SELECT DISTINCT CODCLI, DATA
					                          FROM PCPEDC
					                       WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					                         AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
					                         --AND PCPEDC.DTCANCEL IS NULL
					                         AND PCPEDC.CODFILIAL IN('1')
					                         AND PCPEDC.CODCLI = C.CODCLI) VISITAS),0) VISITAS_REALIZADAS,
					                
					               -- VISITAS POSITIVADAS
					               NVL((SELECT COUNT(CODCLI) FROM
					                           (SELECT DISTINCT CODCLI, DATA
					                          FROM PCPEDC
					                       WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					                         AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
					                         AND PCPEDC.DTCANCEL IS NULL
					                         AND PCPEDC.CODFILIAL IN('1')
					                         AND PCPEDC.CODCLI = C.CODCLI)), 0)POSITIVADAS

					        FROM PCCLIENT C, PCUSUARI U

					        WHERE C.CODUSUR1 = U.CODUSUR
					          AND CODSUPERVISOR NOT IN (5, 3, 4) 
					          AND CODUSUR NOT IN (17,18,19,20, 32, 133)
					          
					          AND C.CODUSUR1 = ".$vSupervisor."

					        ORDER BY VISITAS_REALIZADAS DESC";
	    }

	    $query = $this->db2->query($sql);

	    if ($query->num_rows() > 0){
	      foreach ($query->result() as $row) {

	      	// variaveis de controle dos contatores por rca
	      	$vContVisita = 0;
	      	$vDataIni = '';

	      	// BUSCA AS INFORMAÇÕES PARA CALCULAR A QUANTIDADE DE VISITAS
	      	if ($vVisaoRelatorio == "Ger") {
				$sqlVisitas = " SELECT PCROTACLI.CODUSUR,
							       DIASEMANA,
							       CODCLI,
							       PERIODICIDADE,
							       DTPROXVISITA,
                       			   NUMSEMANA
							       
							FROM PCROTACLI, PCUSUARI
              
              				WHERE PCROTACLI.CODUSUR = PCUSUARI.CODUSUR 
              				  AND PCUSUARI.CODSUPERVISOR = ".$row->CODUSUR;

			} else if ($vVisaoRelatorio == "sup") {
				$sqlVisitas = " SELECT CODUSUR,
								       DIASEMANA,
								       CODCLI,
								       PERIODICIDADE,
								       DTPROXVISITA,
                       				   NUMSEMANA
								       
								FROM PCROTACLI 
								WHERE CODUSUR = ".$row->CODUSUR;
			} else if ($vVisaoRelatorio == "vend") {
				// aqui as informações quando for aparecer por cliente

				$sqlVisitas = " SELECT CODUSUR,
								       DIASEMANA,
								       CODCLI,
								       PERIODICIDADE,
								       DTPROXVISITA,
                       				   NUMSEMANA
								       
								FROM PCROTACLI 
								WHERE CODCLI = ".$row->CODUSUR;
			}

	      	$queryVisitas = $this->db2->query($sqlVisitas);
	      	$dd = '';
	      	$vContVisita2 = '';
		    if ($queryVisitas->num_rows() > 0){
		      foreach ($queryVisitas->result() as $rowVisitas) {
		      	
		      	// while para percorer todos os dias entre a data inicial e a data final
		      	$date_ini = formataData($vDataInicial, '-', '/');//'2019-10-01'; //Data inicial
				$end_date = formataData($vDataFinal , '-', '/');//'2019-10-05';
				$diasemana = array('DOMINGO', 'SEGUNDA', 'TERCA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO');
				// ---- encontrar forma de zerar o array de dias
				$vVetorVisitas = array();
				

				$data_ano_inicial = '2019-01-01';
				$data_ano_final   = '2019-12-31';

				$vDataVis = formataData($rowVisitas->DTPROXVISITA, '-', '/');
					
				//cria vetor com todos os dias de visitas, quando a periodicidade for igual a 15
				if ($rowVisitas->PERIODICIDADE == 15) {
					//data inicial até a data da proxima visita
					$h = 0;
					while (strtotime($data_ano_inicial) <= strtotime($vDataVis)) {
						if ($h == 0) {
							array_push($vVetorVisitas, '20'.$vDataVis);
							$h++;
						} else {
							array_push($vVetorVisitas, $vDataVis);
						}
						
						$vDataVis = date("Y-m-d", strtotime("-".$rowVisitas->PERIODICIDADE." day", strtotime($vDataVis)));
					}

					$vDataVisMais = formataData($rowVisitas->DTPROXVISITA, '-', '/');
					$vDataVisMais = date("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($vDataVisMais)));
					while (strtotime($vDataVisMais) <= strtotime($data_ano_final)) {
						array_push($vVetorVisitas, $vDataVisMais);
						$vDataVisMais = date("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($vDataVisMais)));
					}
				}
	
				while (strtotime($date_ini) <= strtotime($end_date)) {

		      		// encontrar a data da primeira visita
		      		$diasemana_numero = date('w', strtotime($date_ini));

		      		//testa a periodicidade, se for 7 dias sempre calcula, mas se for 15 vai para o else
		      		if ($rowVisitas->PERIODICIDADE == 7) {
		      			
		      			// aqui calcula as visitas semanais
		      			if ($diasemana[$diasemana_numero] == $rowVisitas->DIASEMANA) {
		      				$date_ini = date ("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($date_ini)));
							//echo "7dias";
							$vContVisita++;
			      		} else {
			      			$date_ini = date ("Y-m-d", strtotime("+1 day", strtotime($date_ini)));
			      		}
		      		} else if ($rowVisitas->PERIODICIDADE == 30) {
		      			// aqui calcula a visita mensal
		      			if (date("d", strtotime($date_ini)) == date("d", strtotime($vDataVis))) {
			      			$date_ini = date ("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($date_ini)));
							//echo "30dias";
							$vContVisita++;
			      		} else {
			      			$date_ini = date ("Y-m-d", strtotime("+1 day", strtotime($date_ini)));
			      		}
		      		} else {
		      			
		      			// testar se é semana par ou semana impar
		      			if (in_array($date_ini, $vVetorVisitas)) { 
		      				$date_ini = date ("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($date_ini)));
							$vContVisita++;	
			      		} else {
			      			$date_ini = date ("Y-m-d", strtotime("+1 day", strtotime($date_ini)));
			      		}
		      		}

		      		
				}
		      }
		  	}

	      	$dadosLancamentos[] = array(
	          'CODUSUR'            => $row->CODUSUR,
	          'NOME'               => $row->NOME,
	          'CNPJ'               => $row->CNPJ,
	          'META'               => $row->META,
	          'REALIZADO'          => $row->REALIZADO,
	          'DEVOLUCAO'          => $row->DEVOLUCAO,
	          'NAO_FATURADO'       => $row->NAO_FATURADO,
	          'VISITAS_PREVISTAS'  => $vContVisita,
	          'VISITAS_REALIZADAS' => $row->VISITAS_REALIZADAS,
	          'POSITIVADAS'        => $row->POSITIVADAS,
	          'DIASUTEIS'          => $vDiasUteisMes,
	          'DIASREALIZADOS'     => $vDiasRealizados,
	          'NOMEMES'			   => $vNomeMes
	        );
	      	
	      }
	    }

	    return $dadosLancamentos;
	
    }


    function exportatxt($vDataInicial, $vDataFinal, $vTipoRelatorio){
	    $dadosLancamentos = array();
	    $file = fopen("xml/teste.txt","w");
	    fwrite($file, "codigo;nome;visitas;positivadas \n");

	    //Zerando as variaveis
	    $vDiasRealizados = 0;
	    $vDiasUteisMes   = 0;

	    if ($vTipoRelatorio == 'M') {
	    	$vFatDia = '';
	    } else {
	    	$vDataFinal = $vDataInicial;
	    	$vFatDia = "AND PCNFSAID.HORALANC > 08 AND PCNFSAID.HORALANC < 19";
	    }


		$partes = explode("/", $vDataInicial);
		
		if ($partes[1] == 1) {
			$vDataIniDias = '01/01/'.$partes[2];
			$vDataFimDia  = '31/01/'.$partes[2];
			$vNomeMes = "Janeiro";
		} else if ($partes[1] == 2) {
			$vDataIniDias = '01/02/'.$partes[2];
			$vDataFimDia  = '29/02/'.$partes[2];
			$vNomeMes = "Fevereiro";
		} else if ($partes[1] == 3) {
			$vDataIniDias = '01/03/'.$partes[2];
			$vDataFimDia  = '31/03/'.$partes[2];
			$vNomeMes = "Março";
		} else if ($partes[1] == 4) {
			$vDataIniDias = '01/04/'.$partes[2];
			$vDataFimDia  = '30/04/'.$partes[2];
			$vNomeMes = "Abril";
		} else if ($partes[1] == 5) {
			$vDataIniDias = '01/05/'.$partes[2];
			$vDataFimDia  = '31/05/'.$partes[2];
			$vNomeMes = "Maio";
		} else if ($partes[1] == 6) {
			$vDataIniDias = '01/06/'.$partes[2];
			$vDataFimDia  = '30/06/'.$partes[2];
			$vNomeMes = "Junho";
		} else if ($partes[1] == 7) {
			$vDataIniDias = '01/07/'.$partes[2];
			$vDataFimDia  = '31/07/'.$partes[2];
			$vNomeMes = "Julho";
		} else if ($partes[1] == 8) {
			$vDataIniDias = '01/08/'.$partes[2];
			$vDataFimDia  = '31/08/'.$partes[2];
			$vNomeMes = "Agosto";
		} else if ($partes[1] == 9) {
			$vDataIniDias = '01/09/'.$partes[2];
			$vDataFimDia  = '30/09/'.$partes[2];
			$vNomeMes = "Setembro";
		} else if ($partes[1] == 10) {
			$vDataIniDias = '01/10/'.$partes[2];
			$vDataFimDia  = '31/10/'.$partes[2];
			$vNomeMes = "Outubro";
		} else if ($partes[1] == 11) {
			$vDataIniDias = '01/11/'.$partes[2];
			$vDataFimDia  = '30/11/'.$partes[2];
			$vNomeMes = "Novembro";
		} else if ($partes[1] == 12) {
			$vDataIniDias = '01/12/'.$partes[2];
			$vDataFimDia  = '31/12/'.$partes[2];
			$vNomeMes = "Dezembro";
		} 

		if (date('m') == $partes[1]) {
		
			$sqlDatas = "SELECT 
							    (SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND '".$vDataFimDia."' AND DIAUTIL = 'S') DIASUTEIS,
								(SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND SYSDATE AND DIAUTIL = 'S') DIASREALIZADOS
						 
						 FROM PCDATAS 

						 WHERE DATA = TO_DATE(SYSDATE, 'DD/MM/YY')";
		} else {
			$sqlDatas = "SELECT 
							    (SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND '".$vDataFimDia."' AND DIAUTIL = 'S') DIASUTEIS,
								(SELECT COUNT(DIAUTIL) FROM PCDATAS WHERE DATA BETWEEN '".$vDataIniDias."' AND '".$vDataFimDia."' AND DIAUTIL = 'S') DIASREALIZADOS
						 
						 FROM PCDATAS 

						 WHERE DATA = TO_DATE(SYSDATE, 'DD/MM/YY')";
		}

	    $query = $this->db2->query($sqlDatas);

	    if ($query->num_rows() > 0){
	      foreach ($query->result() as $row) {
	    	
	    	$vDiasUteisMes   = $row->DIASUTEIS;
	        $vDiasRealizados = $row->DIASREALIZADOS;
	      }
	    }

	    if ($vTipoRelatorio == 'D') {
	    	$vDataFimDia = $vDataFinal;
	    } 



	    
    	// SQL que busca os dados
      $sql = "SELECT DISTINCT (U.CODUSUR),
			       U.NOME,
			       U.CODSUPERVISOR,
			       '' AS CNPJ,
			       
			       -- META
			       nvl((SELECT to_char(SUM(PCMETARCA.VLVENDAPREV), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
			          FROM PCMETARCA
			          WHERE PCMETARCA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFimDia."'
			            AND PCMETARCA.CODFILIAL IN('1')
			            AND PCMETARCA.CODUSUR = U.CODUSUR
			       ),0)META,
			       
			       -- REALIZADO
			       nvl((SELECT to_char(SUM(VLTOTAL - nvl((SELECT SUM(QT*PBONIFIC) FROM PCMOV WHERE PCMOV.NUMNOTA = PCNFSAID.NUMNOTA AND CODOPER = 'SB'),0)), 'FM999G999G999D90', 'nls_numeric_characters='',.''') 
   
	                    FROM PCNFSAID 
	                   
	                    WHERE DTSAIDA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
	                      AND CODCOB <> 'BNF'
	                      AND PCNFSAID.CODFISCAL NOT IN (522, 622, 722, 532, 632, 732)
	                      AND PCNFSAID.CONDVENDA NOT IN (4, 8, 10, 13, 20, 98, 99)
	                      AND (PCNFSAID.DTCANCEL IS NULL)
	                      AND NVL(PCNFSAID.TIPOVENDA,'X') NOT IN ('SR', 'DF')
	                      ".$vFatDia."
	                      AND PCNFSAID.CODUSUR = U.CODUSUR
					       ),0) REALIZADO,
	               
	               -- DEVOLUCOES
	               nvl((SELECT to_char(SUM( NVL(m.QT, 0) * (NVL(m.PUNIT, 0) + NVL(m.VLOUTROS, 0))), 'FM999G999G999D90', 'nls_numeric_characters='',.''') AS DELV FROM PCMOV M, PCESTCOM E, PCNFENT  F
						         WHERE E.NUMTRANSENT = F.NUMTRANSENT AND M.NUMTRANSENT = F.NUMTRANSENT
						         AND M.CODOPER = 'ED' AND M.DTCANCEL IS NULL 
	      					   AND F.TIPODESCARGA IN ('6', '7', 'T')
	      					   AND NVL(F.CODFISCAL,0) IN (131, 132, 231, 232, 199, 299)
	      					   AND M.DTCANCEL IS NULL
	      					   AND NVL(F.TIPOMOVGARANTIA, -1) = -1
	      					   AND NVL(F.OBS, 'X') <> 'NF CANCELADA'
	                   AND M.CODUSUR = U.CODUSUR
	      
	      
	      					           AND M.CODFILIAL IN('1')
	      					           AND F.CODFILIAL IN('1')
	      					   AND F.DTENT BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
	      					                              TO_DATE('".$vDataFinal."', 'DD/MM/YYYY')
	               ),0) DEVOLUCAO,
	               
			       
			       -- NÃO FATURADO
			       nvl((SELECT to_char(SUM(PCPEDC.VLATEND), 'FM999G999G999D90', 'nls_numeric_characters='',.''')
			          FROM PCPEDC
			          WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
			                AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
			                AND PCPEDC.DTCANCEL IS NULL
			                AND PCPEDC.POSICAO IN ('B', 'L', 'M', 'P')
			                AND PCPEDC.CODFILIAL IN('1')
			                AND PCPEDC.CODUSUR = U.CODUSUR
			       ),0)NAO_FATURADO,
			       
			       
			       -- VISITAS PREVISTAS
			       '' AS VISITAS_PREVISTAS,
			       
			       -- VISITAS REALIZADAS
			       nvl((SELECT COUNT(CODCLI) FROM
			              (SELECT DISTINCT CODCLI, DATA 
			                  FROM PCVISITA
			               WHERE PCVISITA.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."' 
			                 AND NVL(PCVISITA.TIPO,' ') <> 'C'
			                 AND PCVISITA.CODUSUR = U.CODUSUR

			       UNION

			               SELECT DISTINCT CODCLI, DATA
			                  FROM PCPEDC
			               WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
			                 AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
			                 --AND PCPEDC.DTCANCEL IS NULL
			                 AND PCPEDC.CODFILIAL IN('1')
			                 AND PCPEDC.CODUSUR = U.CODUSUR) VISITAS),0) VISITAS_REALIZADAS,
			        
			       -- VISITAS POSITIVADAS
			       NVL((SELECT COUNT(CODCLI) FROM
			                   (SELECT DISTINCT CODCLI, DATA
			                  FROM PCPEDC
			               WHERE PCPEDC.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
			                 AND PCPEDC.CONDVENDA NOT IN (4, 5, 6, 8, 10, 11, 12, 13, 16, 20)
			                 AND PCPEDC.DTCANCEL IS NULL
			                 AND PCPEDC.CODFILIAL IN('1')
			                 AND PCPEDC.CODUSUR = U.CODUSUR)), 0)POSITIVADAS

			FROM PCUSUARI U

			WHERE CODSUPERVISOR NOT IN (5) 
			  AND CODUSUR NOT IN (17,18,19,20, 32, 31, 33)
  		
			ORDER BY U.CODSUPERVISOR ";
	    

	    $query = $this->db2->query($sql);

	    if ($query->num_rows() > 0){
	      foreach ($query->result() as $row) {

	      	// variaveis de controle dos contatores por rca
	      	$vContVisita = 0;
	      	$vDataIni = '';

	      	// BUSCA AS INFORMAÇÕES PARA CALCULAR A QUANTIDADE DE VISITAS
	      	
			$sqlVisitas = " SELECT CODUSUR,
							       DIASEMANA,
							       CODCLI,
							       PERIODICIDADE,
							       DTPROXVISITA,
                   				   NUMSEMANA
							       
							FROM PCROTACLI 
							WHERE CODUSUR = ".$row->CODUSUR;
			

	      	$queryVisitas = $this->db2->query($sqlVisitas);
	      	$dd = '';
	      	$vContVisita2 = '';
		    if ($queryVisitas->num_rows() > 0){
		      foreach ($queryVisitas->result() as $rowVisitas) {
		      	
		      	// while para percorer todos os dias entre a data inicial e a data final
		      	$date_ini = formataData($vDataInicial, '-', '/');//'2019-10-01'; //Data inicial
				$end_date = formataData($vDataFinal , '-', '/');//'2019-10-05';
				$diasemana = array('DOMINGO', 'SEGUNDA', 'TERCA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO');
				// ---- encontrar forma de zerar o array de dias
				$vVetorVisitas = array();
				

				$data_ano_inicial = '2019-01-01';
				$data_ano_final   = '2019-12-31';

				$vDataVis = formataData($rowVisitas->DTPROXVISITA, '-', '/');
					
				//cria vetor com todos os dias de visitas, quando a periodicidade for igual a 15
				if ($rowVisitas->PERIODICIDADE == 15) {
					//data inicial até a data da proxima visita
					$h = 0;
					while (strtotime($data_ano_inicial) <= strtotime($vDataVis)) {
						if ($h == 0) {
							array_push($vVetorVisitas, '20'.$vDataVis);
							$h++;
						} else {
							array_push($vVetorVisitas, $vDataVis);
						}
						
						$vDataVis = date("Y-m-d", strtotime("-".$rowVisitas->PERIODICIDADE." day", strtotime($vDataVis)));
					}

					$vDataVisMais = formataData($rowVisitas->DTPROXVISITA, '-', '/');
					$vDataVisMais = date("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($vDataVisMais)));
					while (strtotime($vDataVisMais) <= strtotime($data_ano_final)) {
						array_push($vVetorVisitas, $vDataVisMais);
						$vDataVisMais = date("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($vDataVisMais)));
					}
				}
	
				while (strtotime($date_ini) <= strtotime($end_date)) {

		      		// encontrar a data da primeira visita
		      		$diasemana_numero = date('w', strtotime($date_ini));

		      		//testa a periodicidade, se for 7 dias sempre calcula, mas se for 15 vai para o else
		      		if ($rowVisitas->PERIODICIDADE == 7) {
		      			
		      			// aqui calcula as visitas semanais
		      			if ($diasemana[$diasemana_numero] == $rowVisitas->DIASEMANA) {
		      				$date_ini = date ("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($date_ini)));
							//echo "7dias";
							$vContVisita++;
			      		} else {
			      			$date_ini = date ("Y-m-d", strtotime("+1 day", strtotime($date_ini)));
			      		}
		      		} else if ($rowVisitas->PERIODICIDADE == 30) {
		      			// aqui calcula a visita mensal
		      			if (date("d", strtotime($date_ini)) == date("d", strtotime($vDataVis))) {
			      			$date_ini = date ("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($date_ini)));
							//echo "30dias";
							$vContVisita++;
			      		} else {
			      			$date_ini = date ("Y-m-d", strtotime("+1 day", strtotime($date_ini)));
			      		}
		      		} else {
		      			
		      			// testar se é semana par ou semana impar
		      			if (in_array($date_ini, $vVetorVisitas)) { 
		      				$date_ini = date ("Y-m-d", strtotime("+".$rowVisitas->PERIODICIDADE." day", strtotime($date_ini)));
							$vContVisita++;	
			      		} else {
			      			$date_ini = date ("Y-m-d", strtotime("+1 day", strtotime($date_ini)));
			      		}
		      		}

		      		
				}
		      }
		  	}

			fwrite($file, $row->CODUSUR.";".$row->NOME.";".$vContVisita.";".$row->POSITIVADAS."\n");

	      	$dadosLancamentos[] = array(
	          'CODUSUR'            => $row->CODUSUR,
	          'NOME'               => $row->NOME,
	          'CNPJ'               => $row->CNPJ,
	          'META'               => $row->META,
	          'REALIZADO'          => $row->REALIZADO,
	          'DEVOLUCAO'          => $row->DEVOLUCAO,
	          'NAO_FATURADO'       => $row->NAO_FATURADO,
	          'VISITAS_PREVISTAS'  => $vContVisita,
	          'VISITAS_REALIZADAS' => $row->VISITAS_REALIZADAS,
	          'POSITIVADAS'        => $row->POSITIVADAS,
	          'DIASUTEIS'          => $vDiasUteisMes,
	          'DIASREALIZADOS'     => $vDiasRealizados,
	          'NOMEMES'			   => $vNomeMes
	        );
	      	
	      }
	      fclose($file);
	    }

	    return $dadosLancamentos;
	
    }
}