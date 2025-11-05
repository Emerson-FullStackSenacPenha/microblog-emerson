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

    // Buscas (SELECT)
    public function buscar():array {

        $sql = "SELECT * FROM usuarios ORDER BY nome";
        $consulta = $this->conexao->query($sql);
        return $consulta->fetchAll();

    }

    // buscarPorId (SELECT/WHERE)
    public function buscarPorId(int $valorId):?array {

        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $valorId);
        $consulta->execute();

        /* Sobre o ?: conhecido com "Elvis Operator"
        É uma condicional simplificada/abreviada em que, se a condição/expressão for valida (ou seja, tem dados), ela mesma é retornada. Caso contrário, é retornado null
        */

        return $consulta->fetch() ?: null;

    }

    // atualizar (UPDATE/WHERE)
    public function atualizar(Usuario $dadosDoUsuario):void {

        $sql = "UPDATE usuarios SET 
                    nome = :nome,
                    email = :email,
                    tipo = :tipo,
                    senha = :senha

                WHERE id = :id";

        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":nome", $dadosDoUsuario->getNome());
        $consulta->bindValue(":email", $dadosDoUsuario->getEmail());
        $consulta->bindValue(":tipo", $dadosDoUsuario->getTipo());
        $consulta->bindValue(":senha", $dadosDoUsuario->getSenha());
        $consulta->bindValue(":id", $dadosDoUsuario->getId());

        $consulta->execute();

    }

    public function excluirUsuario(Usuario $dadosDoUsuario):void {

        $sql = "DELETE FROM usuarios WHERE id = :id";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $dadosDoUsuario->getId());

        $consulta->execute();

    }

}

?>