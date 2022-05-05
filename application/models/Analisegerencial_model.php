<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisegerencial_model extends MY_Model  {

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

	    	$sql = "SELECT CODSUPERVISOR, NOME FROM PCSUPERV WHERE CODSUPERVISOR NOT IN (1,5)";

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
	    	$sql = "SELECT CODUSUR, NOME FROM PCUSUARI WHERE CODUSUR NOT IN (31,70,30,29,17,18,19,20,3,52,32)";

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


    function buscaAnaliseSupervisor($vSupervisor, $vDataInicial, $vDataFinal, $vTipoRelatorio, $vVisaoRelatorio, $vRelatorio){
	    $dadosLancamentos = array();

	    //Zerando as variaveis
	    $vDiasRealizados = 0;
	    $vDiasUteisMes   = 0;

	    $partes = explode("/", $vDataInicial);
		
		if ($partes[1] == 1) {
			$vNomeMes = "Janeiro";
		} else if ($partes[1] == 2) {
			$vNomeMes = "Fevereiro";
		} else if ($partes[1] == 3) {
			$vNomeMes = "Março";
		} else if ($partes[1] == 4) {
			$vNomeMes = "Abril";
		} else if ($partes[1] == 5) {
			$vNomeMes = "Maio";
		} else if ($partes[1] == 6) {
			$vNomeMes = "Junho";
		} else if ($partes[1] == 7) {
			$vNomeMes = "Julho";
		} else if ($partes[1] == 8) {
			$vNomeMes = "Agosto";
		} else if ($partes[1] == 9) {
			$vNomeMes = "Setembro";
		} else if ($partes[1] == 10) {
			$vNomeMes = "Outubro";
		} else if ($partes[1] == 11) {
			$vNomeMes = "Novembro";
		} else if ($partes[1] == 12) {
			$vNomeMes = "Dezembro";
		}

	    
	    if ($vVisaoRelatorio == "Ger") {
	    	//geral
	    	$vsqlConsulta = "";

	    } else if ($vVisaoRelatorio == "sup") {
	    	if ($vTipoRelatorio == 'D') {
	    		$vsqlConsulta = "AND VW_VENDASPEDIDO.CODSUPERVISOR IN ('".$vSupervisor."')";
	    	} else {
	    		$vsqlConsulta = "AND  NVL(PCNFSAID.CODSUPERVISOR,PCSUPERV.CODSUPERVISOR)   IN ('".$vSupervisor."')";
	    	}
	    } else {
	    	if ($vTipoRelatorio == 'D') {
	    		$vsqlConsulta = " AND VW_VENDASPEDIDO.CODUSUR IN ('".$vSupervisor."')";
	    	} else {
	    		$vsqlConsulta = " AND  NVL(PCNFSAID.CODUSUR,PCUSUARI.CODUSUR)   IN ('".$vSupervisor."')";
	    	}
	    }

	    if ($vRelatorio == "Forn") {
	    	// busca os dados de vendas por fornecedores

	    	if ($vTipoRelatorio == 'D') {
	    		//
	    		$sql = "SELECT DISTINCT 
					       PCPRODUT.CODFORNEC, 
					       PCFORNEC.FORNECEDOR,
					       to_char(MAX(NVL(VENDAS.PVENDA,0)), 'FM999G999G999D90', 'nls_numeric_characters='',.''') VLVENDA
					  FROM PCPRODUT, PCFORNEC,
					       ( SELECT 
					       PCPRODUT.CODFORNEC, 
					MAX((SELECT COUNT(P.CODPROD) FROM PCPRODUT P,PCDEPTO D WHERE P.CODEPTO = D.CODEPTO
					   AND P.CODFORNEC = PCFORNEC.CODFORNEC
					   AND NVL(P.OBS2,'  ') <> ('FL'))) AS QTMIXCAD,
					         COUNT(DISTINCT(VW_VENDASPEDIDO.CODCLI)) QTCLIPOS, 
					         COUNT(DISTINCT(VW_VENDASPEDIDO.CODPROD)) TOTMIXPROD, 
					         SUM(VW_VENDASPEDIDO.QT) QT, 
					         SUM(VW_VENDASPEDIDO.PVENDA) PVENDA, 
					         SUM(VW_VENDASPEDIDO.TOTPESOBRUTO) AS TOTPESO,
					         SUM(VW_VENDASPEDIDO.LITRAGEM) LITRAGEM, 
					         SUM(VW_VENDASPEDIDO.TOTQTUNIT) TOTQTUNIT, 
					         SUM(VW_VENDASPEDIDO.TOTQTUNITCX)TOTQTUNITCX, 
					         MAX(VW_VENDASPEDIDO.QTUNIT) QTUNIT, 
					         COUNT(DISTINCT(VW_VENDASPEDIDO.NUMPED)) AS QTPEDIDO,
					         COUNT(DISTINCT(VW_VENDASPEDIDO.CODPROD)) AS QTMIX,
					         COUNT(VW_VENDASPEDIDO.CODPROD) NUMITENS,
					         MAX(VW_VENDASPEDIDO.QTMIXCAD) 
					          FROM (VW_VENDASPEDIDO), PCUSUARI, PCPRODUT, PCFORNEC 
					         WHERE 
					         VW_VENDASPEDIDO.CODUSUR = PCUSUARI.CODUSUR
					         AND PCPRODUT.CODPROD    = VW_VENDASPEDIDO.CODPROD
					         AND PCFORNEC.CODFORNEC  = VW_VENDASPEDIDO.CODFORNEC
					AND  VW_VENDASPEDIDO.CODFILIAL IN ('1')
					".$vsqlConsulta."
					 AND VW_VENDASPEDIDO.DATA BETWEEN '".$vDataInicial."' AND '".$vDataFinal."'
					         GROUP BY 
					       PCPRODUT.CODFORNEC 
					                  ) VENDAS					 
					WHERE 
					 PCPRODUT.CODFORNEC = PCFORNEC.CODFORNEC
					AND PCFORNEC.REVENDA IN ('S', 'X')
					AND PCPRODUT.CODFORNEC = VENDAS.CODFORNEC(+)
					AND NVL(VENDAS.PVENDA,0)+NVL(VENDAS.TOTPESO,0) + NVL(VENDAS.QT,0)>0
					GROUP BY PCPRODUT.CODFORNEC, PCFORNEC.FORNECEDOR 
					ORDER BY LPAD(VLVENDA,100) DESC";

	    	} else {

		        $sql = " SELECT  
						       DECODE(VENDAS.CODFORNEC ,'', DEVOLUCAO.CODFORNEC,  VENDAS.CODFORNEC ) CODFORNEC,
						       DECODE(VENDAS.FORNECEDOR,'', DEVOLUCAO.FORNECEDOR, VENDAS.FORNECEDOR) FORNECEDOR, 
						       to_char(SUM(NVL(VENDAS.VLVENDA,0) - NVL(DEVOLUCAO.VLDEVOLUCAO,0)), 'FM999G999G999D90', 'nls_numeric_characters='',.''') VLVENDA
						       
						FROM  (SELECT CODFORNEC,
						 0 ROTA,
						 '' DESCROTA,
						              FORNECEDOR,

						              SUM(NVL(VLVENDA,0)  + NVL(VALORST,0) + NVL(VALORIPI,0)) VLVENDA FROM (  
						       SELECT PCNFSAID.NUMTRANSVENDA, PCMOV.CODCLI,
						       PCCLIENT.CLIENTE,
						       PCFORNEC.FORNECEDOR,
						       PCFORNEC.CODFORNEC,
						 PCNFSAID.CODUSUR  CODUSUR, 
						 NVL(PCNFSAID.CODSUPERVISOR,PCSUPERV.CODSUPERVISOR)  CODSUPERVISOR, 
						       PCSUPERV.NOME SUPERV, 
						       (SELECT X.CLIENTE 
						          FROM PCCLIENT X 
						         WHERE X.CODCLI = NVL(PCCLIENT.CODCLIPRINC, PCCLIENT.CODCLI)) CLIENTEPRINC, 
						       PCNFSAID.NUMPED,
						       ROUND((DECODE(PCMOV.CODOPER,  
						                     'SB',         
						                     PCMOV.QTCONT,   
						                     0)) *           
						       NVL(PCMOV.VLREPASSE, 0),      
						       2) VLREPASSEBNF,              
						         ROUND((NVL(PCMOV.QT, 0) * 
						         DECODE(PCNFSAID.CONDVENDA,
						                 5,
						                 0,
						                 6,
						                 0,
						                 11,
						                 0,
						                 12,
						                 0,
						                 DECODE(PCMOV.CODOPER,'SB',0,nvl(pcmov.VLIPI,0)))),2) VALORIPI,
						                 0 VALORIPIX,
						         ROUND(NVL(PCMOV.QT, 0) * 
						         DECODE(PCNFSAID.CONDVENDA,
						                 5,
						                 0,
						                 6,
						                 0,
						                 11,
						                 0,
						                 12,
						                 0,
						                 DECODE(PCMOV.CODOPER,'SB',0,(nvl(pcmov.ST,0)+NVL(PCMOVCOMPLE.VLSTTRANSFCD,0)))),2) VALORST,
						         (SELECT PCCLIENT.CODPLPAG || ' - ' || PCPLPAG.DESCRICAO  FROM PCPLPAG WHERE PCCLIENT.CODPLPAG = PCPLPAG.CODPLPAG) DESCRICAOPLANOCLI,
						       ROUND((((DECODE(PCMOV.CODOPER,                                           
						                       'S',                                                   
						                       (NVL(DECODE(PCNFSAID.CONDVENDA,                          
						                                   7,                                           
						                                   PCMOV.QTCONT,                                
						                                   PCMOV.QT),                                   
						                            0)),                                                
						                       'ST',                                                  
						                       (NVL(DECODE(PCNFSAID.CONDVENDA,                          
						                                   7,                                           
						                                   PCMOV.QTCONT,                                
						                                   PCMOV.QT),                                   
						                            0)),                                                
						                       'SM',                                                  
						                       (NVL(DECODE(PCNFSAID.CONDVENDA,                          
						                                   7,                                           
						                                   PCMOV.QTCONT,                                
						                                   PCMOV.QT),                                   
						                            0)),                                                
						                       0)) *                                                    
						             (NVL(DECODE(PCNFSAID.CONDVENDA,                                    
						                           7,                                                   
						                           (NVL(PUNITCONT, 0) - NVL(PCMOV.VLIPI, 0) -           
						                           (nvl(pcmov.ST,0)+NVL(PCMOVCOMPLE.VLSTTRANSFCD,0))) + NVL(PCMOV.VLFRETE, 0) +          
						                           NVL(PCMOV.VLOUTRASDESP, 0) +                         
						                           NVL(PCMOV.VLFRETE_RATEIO, 0) +                       
						                           DECODE(PCMOV.TIPOITEM,                               
						                                  'C',                                        
						                                  (SELECT NVL((SUM(M.QTCONT *                   
						                                                   NVL(M.VLOUTROS, 0)) /        
						                                          PCMOV.QT), 0) VLOUTROS                
						                                     FROM PCMOV M                               
						                                    WHERE M.NUMTRANSVENDA =                     
						                                          PCMOV.NUMTRANSVENDA                   
						                                      AND M.TIPOITEM = 'I'                    
						                                      AND CODPRODPRINC = PCMOV.CODPROD),        
						                                  NVL(PCMOV.VLOUTROS, 0))                       
						                          - NVL(PCMOV.VLREPASSE, 0)                             
						                           ,(NVL(PCMOV.PUNIT, 0) - NVL(PCMOV.VLIPI, 0) -         
						                           (nvl(pcmov.ST,0)+NVL(PCMOVCOMPLE.VLSTTRANSFCD,0))) + NVL(PCMOV.VLFRETE, 0) +          
						                           NVL(PCMOV.VLOUTRASDESP, 0) +                         
						                           NVL(PCMOV.VLFRETE_RATEIO, 0) +                       
						                           DECODE(PCMOV.TIPOITEM,                               
						                                  'C',                                        
						                                  (SELECT NVL((SUM(M.QTCONT *                   
						                                                   NVL(M.VLOUTROS, 0)) /        
						                                          PCMOV.QT), 0) VLOUTROS                
						                                     FROM PCMOV M                               
						                                    WHERE M.NUMTRANSVENDA =                     
						                                          PCMOV.NUMTRANSVENDA                   
						                                      AND M.TIPOITEM = 'I'                    
						                                      AND CODPRODPRINC = PCMOV.CODPROD),        
						                                  NVL(PCMOV.VLOUTROS, 0))                       
						                         -   NVL(PCMOV.VLREPASSE, 0)                            
						                    ),0)))),                                                    
						             2) VLVENDA
						 
						  FROM PCNFSAID,
						       PCPRODUT,
						       PCMOV,
						       PCCLIENT,
						       PCUSUARI,
						       PCSUPERV,
						       PCPLPAG,
						       PCFORNEC,
						       PCATIVI, 
						       PCPRACA,
						       PCDEPTO,
						       PCSECAO,
						       PCPEDC,
						       PCGERENTE,
						       PCCIDADE,
						       PCMARCA,
						       PCROTAEXP,
						       PCMOVCOMPLE
						 WHERE PCMOV.NUMTRANSVENDA = PCNFSAID.NUMTRANSVENDA
						   AND PCMOV.DTMOV BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
						                                 TO_DATE('".$vDataFinal."', 'DD/MM/YYYY') 
						   AND PCMOV.CODPROD = PCPRODUT.CODPROD
						   AND PCNFSAID.CODPRACA = PCPRACA.CODPRACA(+)
						   AND PCATIVI.CODATIV(+) = PCCLIENT.CODATV1
						   AND PCMOV.CODCLI = PCCLIENT.CODCLI
						   AND PCFORNEC.CODFORNEC = PCPRODUT.CODFORNEC
						   AND  PCNFSAID.CODUSUR   = PCUSUARI.CODUSUR 
						   AND PCPRACA.ROTA = PCROTAEXP.CODROTA(+)
						   AND PCMOV.NUMTRANSITEM = PCMOVCOMPLE.NUMTRANSITEM(+)
						   AND PCPRODUT.CODMARCA = PCMARCA.CODMARCA(+)
						   AND PCCLIENT.CODCIDADE = PCCIDADE.CODCIDADE(+)
						  AND PCMOV.CODOPER <> 'SR' 
						  AND NVL(PCNFSAID.TIPOVENDA,'X') NOT IN ('SR', 'DF')
						  AND PCMOV.CODOPER <> 'SO' 
						   AND  NVL(PCNFSAID.CODSUPERVISOR,PCSUPERV.CODSUPERVISOR)   = PCSUPERV.CODSUPERVISOR
						   AND PCNFSAID.CODPLPAG = PCPLPAG.CODPLPAG
						   AND PCNFSAID.NUMPED = PCPEDC.NUMPED(+)
						   AND PCPRODUT.CODEPTO = PCDEPTO.CODEPTO(+)
						   AND PCPRODUT.CODSEC = PCSECAO.CODSEC(+)
						   AND PCNFSAID.CODGERENTE = PCGERENTE.CODGERENTE(+) 
						   AND PCNFSAID.CODFISCAL NOT IN (522, 622, 722, 532, 632, 732)
						   AND PCNFSAID.CONDVENDA NOT IN (4, 8, 10, 13, 20, 98, 99)
						   AND (PCNFSAID.DTCANCEL IS NULL)
						       AND PCNFSAID.CONDVENDA IN (1)
						 ".$vsqlConsulta."

						   AND PCNFSAID.DTSAIDA BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
						                                 TO_DATE('".$vDataFinal."', 'DD/MM/YYYY') 
						           AND PCMOV.CODFILIAL IN('1')
						           AND PCNFSAID.CODFILIAL IN('1')
						)
						        GROUP BY CODFORNEC,   
						 0 ,
						 '',
						              FORNECEDOR
						              ) VENDAS,
						      ( SELECT CODFORNEC,
						      FORNECEDOR,
						 0 ROTA,
						 '' DESCROTA,

						               SUM(NVL(VLDEVOLUCAO,0)) VLDEVOLUCAO
						                FROM  (SELECT PCFORNEC.CODFORNEC, 
						       PCFORNEC.FORNECEDOR, 
						       PCNFENT.CODMOTORISTADEVOL,
						    (SELECT X.CLIENTE 
						       FROM PCCLIENT X
						      WHERE X.CODCLI = NVL(PCCLIENT.CODCLIPRINC, PCCLIENT.CODCLI)) CLIENTEPRINC,    
						  (DECODE(PCNFSAID.CONDVENDA, 5, 0, DECODE(NVL(PCMOVCOMPLE.BONIFIC, 'N'), 'N', NVL(PCMOV.QT, 0), 0)) * 
						  DECODE(PCNFSAID.CONDVENDA,                                                    
						          5,                                                                    
						          0,                                                                    
						          6,                                                                    
						          0,                                                                    
						          11,                                                                   
						          0,                                                                    
						          (DECODE(PCMOV.PUNIT,                                                  
						                  0,                                                            
						                  PCMOV.PUNITCONT,                                              
						                  NULL,                                                         
						                  PCMOV.PUNITCONT,                                              
						                  PCMOV.PUNIT) + NVL(PCMOV.VLFRETE, 0) +                        
						          NVL(PCMOV.VLOUTRASDESP, 0) + NVL(PCMOV.VLFRETE_RATEIO, 0)             
						        - NVL(PCMOV.VLREPASSE, 0)                                          
						          + NVL(PCMOV.VLOUTROS, 0)))) VLDEVOLUCAO,                              
						  (DECODE(PCNFSAID.CONDVENDA, 5, 0, DECODE(NVL(PCMOVCOMPLE.BONIFIC, 'N'), 'N', NVL(PCMOV.QT, 0), 0)) * 
						  DECODE(PCNFSAID.CONDVENDA,                                                    
						          5,                                                                    
						          0,                                                                    
						          6,                                                                    
						          0,                                                                    
						          11,                                                                   
						          0,                                                                    
						          nvl(PCMOV.VLIPI,0) )) VALORIPI,                                          
						       CASE WHEN  (  SELECT SUM ( NVL(PCMOV.QT, 0) * (NVL(PCMOV.PUNIT, 0) + NVL(PCMOV.VLOUTROS, 0)) ) FROM PCMOV M, PCESTCOM E, PCNFENT  F
						         WHERE E.NUMTRANSENT = F.NUMTRANSENT AND M.NUMTRANSENT = F.NUMTRANSENT
						         AND M.CODOPER = 'ED' AND M.DTCANCEL IS NULL
						         AND PCNFSAID.NUMTRANSVENDA = E.NUMTRANSVENDA )  >= NVL(PCNFSAID.VLTOTAL,0) THEN
						            PCFORNEC.CODFORNEC 
						            ELSE
						            0 END DEVOLVIDO
						      
						  FROM PCNFENT, PCESTCOM, PCEMPR, PCNFSAID, PCMOV, PCPRODUT, PCCLIENT, PCFORNEC, PCPRACA, PCTABDEV, PCTABDEV PCTABDEV2, 
						       PCDEPTO, PCSECAO, PCUSUARI, PCPLPAG, PCSUPERV, PCATIVI, PCPEDC, PCCIDADE, PCMARCA, PCGERENTE, PCMOVCOMPLE 
						 
						 WHERE PCNFENT.NUMTRANSENT = PCESTCOM.NUMTRANSENT
						   AND PCCLIENT.CODPRACA = PCPRACA.CODPRACA
						   AND PCESTCOM.NUMTRANSENT = PCMOV.NUMTRANSENT
						   AND PCFORNEC.CODFORNEC = PCPRODUT.CODFORNEC
						   AND PCNFSAID.NUMPED  = PCPEDC.NUMPED(+)
						   AND PCNFENT.CODDEVOL = PCTABDEV.CODDEVOL(+)
						   AND PCMOV.CODDEVOL = PCTABDEV2.CODDEVOL(+)
						   AND PCPRODUT.CODEPTO = PCDEPTO.CODEPTO(+)
						AND PCNFENT.CODUSURDEVOL = PCUSUARI.CODUSUR(+)
						AND NVL(PCNFSAID.CODSUPERVISOR,PCUSUARI.CODSUPERVISOR) = PCSUPERV.CODSUPERVISOR
						   AND PCPRODUT.CODSEC = PCSECAO.CODSEC(+)
						   AND PCCLIENT.CODATV1 = PCATIVI.CODATIV(+)
						   AND PCNFENT.CODFUNCLANC  = PCEMPR.MATRICULA(+)
						   AND PCESTCOM.NUMTRANSVENDA = PCNFSAID.NUMTRANSVENDA(+)
						   AND PCCLIENT.CODCIDADE = PCCIDADE.CODCIDADE(+)
						   AND NVL(PCNFSAID.CODPLPAG,PCCLIENT.CODPLPAG) = PCPLPAG.CODPLPAG
						   AND PCPRODUT.CODMARCA = PCMARCA.CODMARCA(+)
						   AND PCMOV.NUMTRANSITEM = PCMOVCOMPLE.NUMTRANSITEM(+)
						   AND PCNFSAID.CODGERENTE = PCGERENTE.CODGERENTE(+)
						      -- numtransvenda = 0 refere-se a devolucoes avulsas que nao
						      -- devem ser incluidas no resumo de faturamento
						   AND PCESTCOM.NUMTRANSVENDA <> 0
						   AND PCMOV.CODPROD = PCPRODUT.CODPROD
						   AND PCNFENT.CODFORNEC = PCCLIENT.CODCLI 
						   AND PCNFENT.TIPODESCARGA IN ('6', '7', 'T')
						   AND NVL(PCNFENT.CODFISCAL,0) IN (131, 132, 231, 232, 199, 299)
						   AND PCMOV.DTCANCEL IS NULL
						   AND PCMOV.CODOPER = 'ED' 
						   AND NVL(PCNFENT.TIPOMOVGARANTIA, -1) = -1
						   AND NVL(PCNFENT.OBS, 'X') <> 'NF CANCELADA'
						    
						          AND NVL(PCNFSAID.CONDVENDA, 0) NOT IN (4, 8, 10, 13, 20, 98, 99)


						           AND PCMOV.CODFILIAL IN('1')
						           AND PCNFENT.CODFILIAL IN('1')
						   AND PCNFENT.DTENT BETWEEN  TO_DATE('".$vDataInicial."', 'DD/MM/YYYY') AND 
						                              TO_DATE('".$vDataFinal."', 'DD/MM/YYYY') 
						 ".$vsqlConsulta."
						 AND NVL(PCNFSAID.CONDVENDA,0) IN (1)
						)

						        GROUP BY CODFORNEC, 
						 0 ,
						 '', 
						 FORNECEDOR
						       ) DEVOLUCAO,
						     PCFORNEC
						WHERE PCFORNEC.CODFORNEC = VENDAS.CODFORNEC(+)
						  AND PCFORNEC.CODFORNEC = DEVOLUCAO.CODFORNEC(+)
						AND ( (NVL(DEVOLUCAO.VLDEVOLUCAO,0) <> 0)  OR (NVL(VENDAS.VLVENDA,0) <> 0) OR (NVL(VENDAS.CODFORNEC,0) <> 0) ) 

						GROUP BY VENDAS.CODFORNEC,
						         VENDAS.FORNECEDOR,
						         DEVOLUCAO.FORNECEDOR,
						         DEVOLUCAO.CODFORNEC,
						         VENDAS.ROTA,
						         VENDAS.DESCROTA
						ORDER BY LPAD(VLVENDA,100) DESC




		        ";
		    }
	    }

	    $query = $this->db2->query($sql);
	    if ($query->num_rows() > 0){
	      foreach ($query->result() as $row) {
  			$dadosLancamentos[] = array(
	          'CODUSUR'            => $row->CODFORNEC,
	          'NOME'               => $row->FORNECEDOR,
	          'REALIZADO'          => $row->VLVENDA,
	          'NOMEMES'			   => $vNomeMes
	        );		
	      }
	    }

	    return $dadosLancamentos;
	
    }



}