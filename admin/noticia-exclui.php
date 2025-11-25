<?php

require_once "../src/Database/Conecta.php";
require_once "../src/Services/NoticiaServico.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/AutenticacaoServico.php";
AutenticacaoServico::exigirLogin();

$erro = null;
$noticiaServico = new NoticiaServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
if (!$id) Utils::redirecionarPara("noticias.php");

try{
	$noticiaServico->excluir($id, $_SESSION['id'], $_SESSION['tipo']);
} catch (Throwable $e) {
	$erro = "Erro ao excluir noticia. <br>".$e->getMessage();

}

require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir notícia
		</h2>

		<?php if($erro):?>
			<p class="alert alert-danger text-center" ><?=$erro?></p>
		<?php else :?>
			<p class="alert alert-success text-center" > A noticia foi excluida com sucesso </p>
		<?php endif;?>

		<div class="text-center">
			<a class="btn btn-light " href="noticias.php">Voltar</a>
		</div>	

	</article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>