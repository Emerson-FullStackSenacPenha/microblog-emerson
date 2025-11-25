<?php
require_once "../src/Database/Conecta.php";
require_once "../src/Models/Noticia.php";
require_once "../src/Services/NoticiaServico.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/AutenticacaoServico.php";
AutenticacaoServico::exigirLogin();

$erro = null;
$noticiaServico = new NoticiaServico();

$id = Utils::sanitizar($_GET['id'], 'inteiro');
if(!$id) Utils::redirecionarPara('noticias.php');

try {
	$dados = $noticiaServico->buscarPorId($id, $_SESSION['tipo'], $_SESSION['id']);
    if(!$dados) $erro = "Noticia não encontrada";
    // Utils::dump($dados);
} catch (\Throwable $e) {
	$erro = "Erro ao buscar usuário. <br>".$e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (
		// empty = Vázio, ou seja, Se algum campo estiver vazio
		empty($_POST['titulo']) || empty($_POST['resumo']) || empty($_POST['texto'])
	) {

		$erro = "Preencha todos os campos";
	} else {

		try {

			$titulo = Utils::sanitizar($_POST['titulo']);
			$texto = Utils::sanitizar($_POST['texto']);
			$resumo = Utils::sanitizar($_POST['resumo']);
			$arquivo = $_FILES['imagem'];
			
            /* Se o usuário enviar uma NOVA imagem e se não tem erro no envio */

            if (!empty($arquivo) && $arquivo['error'] === UPLOAD_ERR_OK ) {
                
                // Vamos fazer um novo Upload
                // Enviamos o arquivo para o servidor (UPLOAD)
			    Utils::upload($arquivo);

                // Aproveitampos para pegar apenas o nome e extensão do novo arquivo
                $imagem = $arquivo['name'];

            } else {

                // Caso contrário, vamos manter a imagem que já existe
                $imagem = $dados['imagem'];    

            }

			// Criando um objeto para novas noticias
			$noticia = new Noticia($titulo, $resumo, $texto, $imagem, $_SESSION['id'], $id);

			// Atualizar a noticia passando ela e o tipo de usuário que está logado
			$noticiaServico->atualizar($noticia, $_SESSION['tipo']);

			// Redirecionando para noticias.php
			Utils::redirecionarPara("noticias.php");

		} catch (Throwable $e) {

			$erro = "Erro ao atualizar notícia." . $e->getMessage();
		}
	}
}


require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Atualizar dados da notícia
        </h2>

        <!-- O parágrafo abaixo irá aparecer SOMENTE se houver algum erro. E neste caso, exibirá a mensagem de erro. -->
		<?php if($erro): ?>
		<p class="alert alert-danger text-center" > <?=$erro?> </p>
		<?php endif; ?>	

        <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $dados['id'] ?>">

            <div class="mb-3">
                <label class="form-label" for="titulo">Título:</label>
                <input value="<?= $dados['titulo'] ?>" class="form-control" type="text" id="titulo" name="titulo">
            </div>

            <div class="mb-3">
                <label class="form-label" for="texto">Texto:</label>
                <textarea class="form-control" name="texto" id="texto" cols="50" rows="6"><?= $dados['texto'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="resumo">Resumo (máximo de 300 caracteres):</label>
                <span id="maximo" class="badge bg-danger">0</span>
                <textarea class="form-control" name="resumo" id="resumo" cols="50" rows="2" maxlength="300"><?= $dados['resumo'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="imagem-existente" class="form-label">Imagem da notícia:</label>
                <!-- campo somente leitura, meramente informativo -->
                <input value="<?= $dados['imagem'] ?>" class="form-control" type="text" id="imagem-existente" name="imagem-existente" readonly>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Caso queira mudar, selecione outra imagem:</label>
                <input class="form-control" type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/gif, image/svg+xml">
            </div>

            <button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
        </form>

    </article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>