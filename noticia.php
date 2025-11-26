<?php

require_once "src/Database/Conecta.php";
require_once "src/Services/NoticiaServico.php";
require_once "src/Helpers/Utils.php";

$erro = null;
$noticiaServico = new NoticiaServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
if(!$id) Utils::redirecionarPara("index.php");

try {
    $dados = $noticiaServico->exibirNoticiaCompleta($id);
    Utils::dump($dados);
} catch (\Throwable $th) {
    $erro = "Erro ao exibir a noticia. <br>".$e->getMessage();
}

require_once "includes/cabecalho.php";
?>


<div class="row my-1 mx-md-n1">

    <?php if($erro): ?>
		<p class="alert alert-danger text-center" > <?=$erro?> </p>
	<?php endif; ?>	

    <article class="col-12">
        <h2> Título da notícia... </h2>
        <p class="font-weight-light">
            <time>11/11/2011 - 21:12</time> - 
            <span>Autor da notícia...</span>
        </p>
        <img src="images/abstrato.jpg" alt="" class="float-start pe-2 img-fluid">
        <p class="ajusta-texto">Texto da notícia...</p>
    </article>
    

</div>        
                  

<?php 
require_once "includes/rodape.php";
?>

