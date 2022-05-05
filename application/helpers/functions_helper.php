<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('formataValor')){

    function formataValor($valor, $tipo = 1){
    	// 1 - americano para real
    	// 2 - real para americano
    	if ($tipo == 1){
    		return number_format($valor, 2, ',', '.');
    	}else if($tipo == 2){
        	return str_replace(',','.', str_replace('.','',  $valor));
    	}
    }
} 

if ( ! function_exists('transformaMesParaPortugeus')){
  function transformaMesParaPortugeus($data) {
      
    if($data == 1) {
      return 'Janeiro';
    } else if($data == 2) {
      return 'Fevereiro';
    } else if($data == 3) {
      return 'Março';
    } else if($data == 4) {
      return 'Abril';
    } else if($data == 5) {
      return 'Maio';
    }else if($data == 6) {
      return 'Junho';
    } else if($data == 7) {
      return 'Julho';
    } else if($data == 8) {
      return 'Agosto';
    } else if($data == 9) {
      return 'Setembro';
    } else if($data == 10) {
      return 'Outubro';
    } else if($data == 11) {
      return 'Novembro';
    } else if($data == 12) {
      return 'Dezembro';
    }

  }
}

  /*FUNÇÃO USADA PARA CONVERTER A DATA PARA SALVAR NO BANCO*/
  /*O PADRÃO DOS SEPARADORES PARA SALVAR É '-' E '/' */
if ( ! function_exists('formataData')){
    function formataData( $data, $separador1, $separador2 ) {
        return implode( $separador1, array_reverse( explode( $separador2, $data ) ) );
    }
}

if ( ! function_exists('formataDataHora')){
    function formataDataHora($dataHora, $separador1, $separador2){
      $dataHora = explode(" ", $dataHora);
      return formataData($dataHora[0], $separador1, $separador2).' '.$dataHora[1];
    }
}

if ( ! function_exists('retornaDataHoraTexto')){
    function retornaDataHoraTexto($dataHora){
      $dataHora = strtotime($dataHora);
      return utf8_encode(
                ucwords(strftime('%A', $dataHora)).', '.strftime('%d',  $dataHora).' de '.ucwords(strftime('%B', $dataHora)).' de '.strftime('%Y', $dataHora).' &agrave;s '.strftime('%H:%M', $dataHora)
             );
    }
}

if ( ! function_exists('procuraMatchPalavra')){
    function procuraMatchPalavra($haystack, $needle, $caseSensitive = false) {
        return $caseSensitive ?
                (strpos($haystack, $needle) === FALSE ? FALSE : TRUE):
                (stripos($haystack, $needle) === FALSE ? FALSE : TRUE);
    }
}

if ( ! function_exists('montaNomeUrl')){

    function montaNomeUrl($nome){
        return preg_replace('{\W}', '-', preg_replace('{ +}', '-', strtr(
            utf8_decode(html_entity_decode($nome)),
            utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'),
            'AAAAEEIOOOUUCNaaaaeeiooouucn')));
    }
}

if ( ! function_exists('validaAjustaUrl')){
    function validaAjustaUrl($url){
        $baseUrl     = $url; 
        $posted_url  = $url;

        $regularExpression  = "((https?|ftp)\:\/\/)?"; // SCHEME Check
        $regularExpression .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass Check
        $regularExpression .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP Check
        $regularExpression .= "(\:[0-9]{2,5})?"; // Port Check
        $regularExpression .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path Check
        $regularExpression .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query String Check
        $regularExpression .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor Check

        if(preg_match("/^$regularExpression$/i", $posted_url)) { 
            if(preg_match("@^http|https://@i",$posted_url)) {
                $final_url = preg_replace("@(http://)+@i",'http://',$posted_url);
            }else { 
                $final_url = 'http://'.$posted_url;
            }
        }else {
            $final_url = "";
        }
        return $final_url;
    }
}

if ( ! function_exists('geraProtocolo')){
   function geraProtocolo($qtd){
       $chars        = '1234567890';
       $chars_length = (strlen($chars) - 1);
       $token        = $chars{rand(0, $chars_length)};

       for ($i = 1; $i < $qtd; $i = strlen($token)){
           $r = $chars{rand(0, $chars_length)};
           if ($r != $token{$i - 1}) $token .=  $r;
       }

       return $token;
   }
}

if ( ! function_exists('carregaMenu')){

    function carregaMenu(){
        $CI = get_instance();

        $CI->load->model('Index_model', 'index');

        $itensMenu = $CI->index->menu();   

        if(isset($itensMenu)){
          return $itensMenu;
        }else{
          redirect(base_url().'login','refresh');
        }


    }
}

if ( ! function_exists('retornaDatasProximas')){
    function retornaDatasProximas($dataAtual){
        $datas        = array();
        $dataAtual    = formataData($dataAtual, '-', '/');
        $dataAjustada = new DateTime($dataAtual);
        $proximosDias = new DatePeriod(
            $dataAjustada,
            DateInterval::createFromDateString('+1 days'),
            14
        );

        foreach($proximosDias as $value){
          foreach($value as $key => $data){
            if($key == 'date'){
              array_push($datas, date_format(date_create($data), 'Y-m-d'));
            }
          }
        }
        return $datas;
    }
}

if ( ! function_exists('carregaConfigSite')){

    function carregaConfigSite(){
        $CI = get_instance();

        $CI->load->model('Index_model', 'index');

        $config = $CI->index->buscaConfigSite();   

        return $config;
    }
}

if(! function_exists('criptografaSenha')){
    function criptografaSenha($senha) {

        $custo = '08';
        $salt = substr(md5(uniqid(rand(), true)),0,22);
        
        // Gera um hash baseado em bcrypt
        $hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
        
        return $hash;
    }
}

if(! function_exists('retornaParamsDatatables')){

    function retornaParamsDatatables($tabela){
      
        $urlCallBack  = "";
        $conf         = array();
        $colOrdem     = array();
        $arrayDefs    = json_encode(array());
        $arrayOrdem   = json_encode(array());

        if(isset($tabela)){
          foreach ($tabela as $key => $value) {
            if($key == 'urlCallBack'){
              $urlCallBack = $value;
            }
            if($key == 'columnDefs'){
              foreach ($value as $defs) {
                $conf[] = $defs;
              }
            }
            if($key == 'ordemInicial'){
              foreach ($value as $sort) {
                $colOrdem[] = $sort;
              }
            }
          }
          $arrayDefs  = json_encode($conf);
          $arrayOrdem = json_encode($colOrdem); 
          return (array('urlCallBack' => $urlCallBack, 'arrayDefs' => $arrayDefs, 'arrayOrdem' => $arrayOrdem));
        }
    }
}

