<?php

require_once "../src/Database/conecta.php";
require_once "../src/Models/usuario.php";
require_once "../src/Services/UsuarioServico.php";
require_once "../src/Helpers/Utils.php";

require_once "../includes/cabecalho-admin.php";

$id = $_GET['id'];
$usuarioServico = new UsuarioServico();

try {
	$usuarioServico->excluirUsuario($id);
} catch (\Throwable $e) {
	
}

?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir usuário
		</h2>
		<p>Usuario excluido com sucesso</p>
		<a href="../admin/usuarios.php">Voltar</a>
			

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>