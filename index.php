<?php

require_once "src/Database/Conecta.php";
require_once "src/Services/NoticiaServico.php";
require_once "src/Helpers/Utils.php";

$erro = null;
$noticias = [];
$noticiaServico = new NoticiaServico();

try{
    $noticias = $noticiaServico->buscarNoticiasParaAreaPublica();
    Utils::dump($noticias);
} catch (Throwable $e) {
    $erro = "Erro ao buscar noticias. <br>".$e->getMessage();
}

require_once "includes/cabecalho.php";
?>

<div class="row my-1 mx-md-n1">

    <!-- INÍCIO Card -->

    <div class="col-md-6 my-1 px-md-1">
        <article class="card shadow-sm h-100">
            <a href="noticia.php" class="card-link">
                <img src="images/abstrato.jpg" class="card-img-top" alt="Imagem de capa do card">
                <div class="card-body">
                    <h3 class="fs-4 card-title">Título da notícia...</h3>
                    <p class="card-text">Resumo da notícia...</p>
                </div>
            </a>
        </article>
    </div>

    <!-- FIM Card -->

</div>


<?php
require_once "includes/rodape.php";
?>