<?php

// src/Services/UsuarioServico.php

class UsuarioServico {

    private PDO $conexao;

    /* Toda vez que criamos um objeto baseado na classe UsuarioServico, este objeto fará uma chamada ao método conexão na classe Conecta. */

    public function __construct()
    {
       $this->conexao = Conecta::getConexao();
    }

    // Métodos CRUD para usuários

    // inerir (ISERT)
    public function inserir(Usuario $dadosDoUsuario):void {

        $sql = "INSERT INTO usuarios(nome, email, tipo, senha)
                VALUES(:nome, :email, :tipo, :senha)";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":nome", $dadosDoUsuario->getNome());
        $consulta->bindValue(":email", $dadosDoUsuario->getEmail());
        $consulta->bindValue(":tipo", $dadosDoUsuario->getTipo());
        $consulta->bindValue(":senha", $dadosDoUsuario->getSenha());

        $consulta->execute();

    }

}

?>