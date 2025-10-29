<?php 

require_once "../src/Models/Usuario.php";

// Variavel que será usada para montar mensagens de erro personalizadas
$erro = null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	// Validação de preenchimento dos campos
	if(
		
		// empty = Vázio, ou seja, Se Post 'nome' estiver vazio
		empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['tipo']) 

	){

		// acionar a váriavel erro com a mensagem "Preencha todos os campos"
		$erro = "Preencha todos os campos";
	} else {

		// Caso contrario exibir "Campos Ok!"
		echo "Campos Ok!";

	}

}

require_once "../includes/cabecalho-admin.php";

?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Inserir novo usuário
		</h2>
				
		<!-- O parágrafo abaixo irá aparecer SOMENTE se houver algum erro. E neste caso, exibirá a mensagem de erro. -->
		<?php if($erro): ?>
		<p class="alert alert-danger text-center" > <?=$erro?> </p>
		<?php endif; ?>	

		<form class="mx-auto w-75" action="" method="post" id="form-inserir" name="form-inserir" autocomplete="off">

			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input class="form-control" type="text" id="nome" name="nome">
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input class="form-control" type="email" id="email" name="email">
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha">
			</div>

			<div class="mb-3">
				<label class="form-label" for="tipo">Tipo:</label>
				<select class="form-select" name="tipo" id="tipo">
					<option value=""></option>
					<option value="editor">Editor</option>
					<option value="admin">Administrador</option>
				</select>
			</div>
			
			<button class="btn btn-primary" id="inserir" name="inserir"><i class="bi bi-save"></i> Inserir</button>
		</form>
		
	</article>
</div>


<?php 
require_once "../includes/rodape-admin.php";
?>

