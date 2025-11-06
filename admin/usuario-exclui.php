<?php

require_once "../includes/cabecalho-admin.php";
require_once "../src/Services/UsuarioServico.php";

$usuarioServico = new UsuarioServico();

try {
	$dados = $usuarioServico->excluirUsuario($id);
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