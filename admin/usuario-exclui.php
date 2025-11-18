<?php

require_once "../src/Database/conecta.php";
require_once "../src/Models/usuario.php";
require_once "../src/Services/UsuarioServico.php";

require_once "../src/Helpers/Utils.php";
require_once "../src/Services/AutenticacaoServico.php";
AutenticacaoServico::exigirLogin();
AutenticacaoServico::exigirAdmin();

require_once "../includes/cabecalho-admin.php";

// Captura o valor do ID via URL e sanitiza para garantir que é valor inteiro
$id = Utils::sanitizar($_GET['id'], 'inteiro');

// Ao tentar abrir usuario-exclui.php sem o parâmetro id, redirecionamos.
if(!$id) Utils::redirecionarPara("usuarios.php");

$erro = null;
$usuarioServico = new UsuarioServico();
$dadosDoUsuario = [];

/* Se o id passado via URL for o mesmo id do usuario que está logado */
if ($id === $_SESSION['id']) {
	// Neste caso, não vamos possibilitar a exclusão, e vamos avisar o usuário
	$erro = "Você não pode excluir seu próprio usuario!";
} else {

	// Caso contrário, siga em frente (carregue os dados e exclua)
	try {

		$dadosDoUsuario = $usuarioServico->buscarPorId($id);
		// Excluir o método de excluir passando o id de quem será escluido
		$usuarioServico->excluirUsuario($id);
	

	} catch (\Throwable $e) {

		// Não deu certo ? Dispare um erro e monte uma mensagem com os detalher
		$erro = "Erro ao excluir usuário. <br>".$e->getMessage();	
	}

}

?>


<div class="row">

	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir usuário
		</h2>

		<?php if($erro):?>
			<p class="alert alert-danger text-center" ><?=$erro?></p>
		<?php else :?>
			<p class="alert alert-success text-center" > O Usuario <b><?=$dadosDoUsuario['nome']?></b> foi excluido com sucesso </p>
		<?php endif;?>

		<div class="text-center" >
			<a class="btn btn-light " href="../admin/usuarios.php">Voltar</a>
		</div>
		
	</article>

</div>


<?php
require_once "../includes/rodape-admin.php";
?>