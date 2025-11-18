<?php

require_once "../src/Database/Conecta.php";
require_once "../src/Models/Usuario.php";
require_once "../src/Services/AutenticacaoServico.php";

require_once "../src/Helpers/Utils.php";
require_once "../src/Services/UsuarioServico.php";
require_once "../src/Services/AutenticacaoServico.php";
AutenticacaoServico::exigirLogin();

// Inicialização
$erro = null;
$usuarioServico = new UsuarioServico();

try {
	// Buscar a partit do id do usuario logado
	$dados = $usuarioServico->buscarPorId($_SESSION['id']);
} catch (\Throwable $e) {
	$erro = "Erro ao buscar usuário. <br>".$e->getMessage();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

	if(empty($_POST['nome']) || empty($_POST['email'])){
		$erro = "Nome e e-mail são obrigatórios";
	} else {

		try {
			
			$nome = Utils::sanitizar( $_POST['nome'] );
			$email = Utils::sanitizar( $_POST['email'] );
			
			/*
			Se o campo senha estiver vazio, manter a senha existente.
			Caso contrário, verifique as senhas
			(digitadas no form "Post", e a do banco)
			*/ 
			$senha = empty($_POST['senha']) ? $dados['senha'] : Utils::verificarSenha($_POST['senha'], $dados['senha']);

			// Montando um objeto com os dados do meu perfil (pessoa logada)
			$usuario = new Usuario($nome, $email, $senha, $_SESSION['tipo'], $_SESSION['id']);

			// Executar o serviço para atualizar
			$usuarioServico->atualizar($usuario);
			
			// Forçando a atualização da variavél de sessão
			$_SESSION['nome'] = $nome;

			// Redirecionar para a lista de usuários
			Utils::redirecionarPara("index.php");

		} catch (\Throwable $th) {
			
			$erro = "Erro ao editar usuário. <br>".$e->getMessage();

		}

	}

}


require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Atualizar meus dados
		</h2>

		<?php if($erro): ?>
		<p class="alert alert-danger text-center" > <?=$erro?> </p>
		<?php endif; ?>	

		<form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
			<input type="hidden" name="id" value="<?=$dados['id']?>">

			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input value="<?=$dados['nome']?>" class="form-control" type="text" id="nome" name="nome">
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input value="<?=$dados['email']?>" class="form-control" type="email" id="email" name="email">
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
			</div>

			<button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
		</form>

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>