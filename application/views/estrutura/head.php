<head>

	<?php 

		$titlePrincipal  = 'INFLUENCE AGÊNCIA DIGITAL';

		$keysPrincipal   = ''; 

		$descPrincipal   = '';

	?>



	<title><?php echo (isset($title)) ? $title.' | '.$titlePrincipal : $titlePrincipal; ?></title>



	<meta name="HandheldFriendly"   content="true" />

	<meta name="MobileOptimized"    content="320" />

	<meta name="viewport"           content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <meta name="viewport" content="width=device-width" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="keywords"           content="<?php echo (isset($keywords))  ? $keywords.','.$keysPrincipal   : $keysPrincipal; ?>" />

	<meta name="description"        content="<?php echo (isset($descricao)) ? $descricao.'. '.$descPrincipal : $descPrincipal; ?>" />

    <meta name="author"             content="CSSHARP - Soluções em Tecnologia">

    



	<meta name="application-name" content="<?php echo $titlePrincipal; ?>">

	<link rel="shortcut icon" type="image/x-icon" href="https://i7solution.com.br/wp-content/uploads/2020/01/logo.png">

	<meta name="msapplication-TileColor" content="#ffffff">

	<meta name="theme-color" content="#ffffff">



    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css"                     rel="stylesheet" />

    <link href="<?php echo base_url();?>assets/css/material-dashboard.css?v=1.2.0"        rel="stylesheet" />

    <link href="<?php echo base_url();?>assets/css/style.css"                             rel="stylesheet" />

    <link href="<?php echo base_url();?>assets/css/cssharp.css"                           rel="stylesheet" />

    <link href="<?php echo base_url();?>assets/css/bootstrap-select.min.css"              rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/font-awesome.css"                      rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/jquery.loader.min.css"                 rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/loader.css"                 rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

	<link href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css"          rel="stylesheet" type="text/css">

	<link href="<?php echo base_url();?>assets/css/responsive.bootstrap.min.css"          rel="stylesheet" type="text/css">

	<link href="<?php echo base_url();?>assets/css/owl.carousel.css"                	  rel="stylesheet" type="text/css"/>

	<link href="<?php echo base_url();?>assets/css/owl.theme.default.css"           	  rel="stylesheet" type="text/css"/>

	<link href="<?php echo base_url();?>assets/css/fileinput.min.css"          rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/buttons.dataTables.min.css"            rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/material-cards.css" rel="stylesheet" type="text/css">	
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons" rel="stylesheet" type="text/css">



	<?php 

	  

	  $isLogin   = ($conteudo == 'login' || $conteudo == 'trocasenha') ? true : false; 

	  if($isLogin){

	  	echo "<link href='".base_url()."assets/css/login.css' rel='stylesheet' />";

	  }

	  if($conteudo == 'mapaquartos'){

	  	echo "<link href='".base_url()."assets/css/ScrollTabla.css' rel='stylesheet' />";	

	  }



	  setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

	  date_default_timezone_set('America/Sao_Paulo');



	?>



</head>

