<?php $this->load->view('estrutura/menu', $breadcrumbs = null); ?>

<div class="container">
	<section class="sectionConteudo">
		<div class="row">
			<div class="col-md-12">
				<div class="bs-callout bs-callout-primary">
				  <?php 
				  	if(isset($header)){
				  		foreach ($header as $value) {
				  		echo "<h3><span class='".$value['icone']."' aria-hidden='true'></span> ".$value['titulo']."</h3>";
				  		}
				  	}
				  ?>	
				</div>
			</div>
		</div>
		<div class="row rowItens">
			<div class="col-md-12">
			  <div class="error-404 text-center divInner">
			  	<div class="text-center">
			  		<i class="fa fa-5x fa-frown-o"></i>
					<h1>Ops</h1>
					<h2>Página não encontrada</h2>
			  	</div>
			  	<br>
			  	<button type="button" class="btnForm btnForm-4 btnForm-sep icon-reply" onclick="history.back()" value="Voltar">Voltar</button>
			  </div>				
			</div>
		</div>
	</section>
</div>