<?php

require_once "src/Database/Conecta.php";
require_once "src/Services/NoticiaServico.php";
require_once "src/Helpers/Utils.php";

$erro = null;
$noticiaServico = new NoticiaServico();

// Obter o valor que foi digitado no campo de busca
$termo = Utils::sanitizar($_GET['busca']);

try {
    $dados = $noticiaServico->buscarNoticias($termo);
    Utils::dump($dados);
} catch (Throwable $e) {
    $erro = "Erro ao fazer a busca no sistema.<br>".$e->getMessage();
}

require_once "includes/cabecalho.php";
?>

    <?php if(isset($mensagem)):?>
            <p class="alert alert-warning text-center my-2"><?= $mensagem?></p>
    <?php endif;?>    

<div class="row my-1 mx-md-n1">
    <h2 class="col-12 fs-5 fw-light">
        Você procurou por 
        <span class="badge bg-dark"><?= $termo ?></span> e
        obteve <span class="badge bg-info">  <?= count($dados) ?> </span> resultados
    </h2>
    
    <p class="alert alert-warning text-center">Nenhum resultado encontrado!</p>

        

    <div class="col-12 my-1">
        <article class="card">
            <div class="card-body">
                <h3 class="fs-4 card-title fw-light">
                    Título da notícia...
                </h3>
                <p class="card-text">
                    <time>11/11/2011 21:12</time> - 
                    Resumo da notícia...
                </p>
                
                <a href="noticia.php" 
                class="btn btn-primary btn-sm">Continuar lendo</a>
            </div>
        </article>
    </div>

</div>     


<?php
require_once "includes/rodape.php";
?>