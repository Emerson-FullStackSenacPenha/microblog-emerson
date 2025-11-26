<?php
// src/Services/NoticiaServico.php

class NoticiaServico {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Conecta::getConexao();
    }
    
    // Versão completa usada em admin/noticias.php
    public function buscar(string $tipoUsuario, int $idUsuario):array {

        if($tipoUsuario == 'admin'){

            $sql = "SELECT  
                        noticias.id,
                        noticias.titulo,
                        noticias.data,
                        usuarios.nome AS autor

                    FROM noticias JOIN usuarios 
                    ON noticias.usuario_id = usuarios.id
                    ORDER BY data DESC";
        } else {

            $sql = "SELECT id, titulo, data FROM noticias
            WHERE usuario_id = :usuario_id
            ORDER BY data DESC";

        }

        $consulta = $this->conexao->prepare($sql);
        
        if ($tipoUsuario !== 'admin'){
            $consulta->bindValue(":usuario_id", $idUsuario);
        }
        
        $consulta->execute();
        
        return $consulta->fetchAll();

    }

    // admin/noticia-insere.php
    public function inserir(Noticia $dadosNoticia):void {
        $sql = "INSERT INTO noticias(titulo, texto, resumo, imagem, usuario_id)
                VALUES (:titulo, :resumo, :texto, :imagem, :usuario_id)";
    
        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":titulo", $dadosNoticia->getTitulo());
        $consulta->bindValue(":texto", $dadosNoticia->getTexto());
        $consulta->bindValue(":resumo", $dadosNoticia->getResumo());
        $consulta->bindValue(":imagem", $dadosNoticia->getImagem());
        $consulta->bindValue(":usuario_id", $dadosNoticia->getUsuarioId());

        $consulta->execute();

    }

    // admin/noticia-atualiza.php
    public function buscarPorId(int $idNoticia, string $tipoUsuario, int $idUsuario): ?array{

        if($tipoUsuario === 'admin'){
            
            /* Pode buscar/exibir qualquer noticia, bastando saber o id da noticia */
            $sql = "SELECT * FROM noticias WHERE id = :id";
        } else {

            /* Senão, pode buscar/exibir qualquer noticia, desde que seja o dele(a)  própria */
            $sql = "SELECT * FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
        }

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $idNoticia); // Fica dora do If porque é usado nos 2 SQL (Editor e Admin)

        if($tipoUsuario !== 'admin'){

            // Fica dentro do if porque é usado apenas no SQL do editor
            $consulta->bindValue(":usuario_id", $idUsuario);
        }

        $consulta->execute();
        return $consulta->fetch() ?: null;

    }

    //admin/noticia-atualiza.php
    public function atualizar(Noticia $dadosNoticia, string $tipoUsuario):void {

        if($tipoUsuario === 'admin'){

            $sql = "UPDATE noticias SET
                    titulo = :titulo,
                    resumo = :resumo,
                    texto = :texto,
                    imagem = :imagem
                WHERE id = :id";

        } else {

            $sql = "UPDATE noticias SET
                    titulo = :titulo,
                    resumo = :resumo,
                    texto = :texto,
                    imagem = :imagem
                WHERE id = :id AND usuario_id = :usuario_id";

        }

        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":titulo", $dadosNoticia->getTitulo());
        $consulta->bindValue(":resumo", $dadosNoticia->getResumo());
        $consulta->bindValue(":texto", $dadosNoticia->getTexto());
        $consulta->bindValue(":imagem", $dadosNoticia->getImagem());
        $consulta->bindValue(":id", $dadosNoticia->getId());

        if($tipoUsuario !== 'admin'){
            $consulta->bindValue(":usuario_id", $dadosNoticia->getUsuarioId());
        }
        
        $consulta->execute();

    }

    //admin/noticia-exclui.php
    public function excluir(int $idNoticia, int $idUsuario, string $tipoUsuario):void {

        if ($tipoUsuario === 'admin') {
            $sql = "DELETE FROM noticias WHERE id = :id";
        } else {
            $sql = "DELETE FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
        }

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $idNoticia);

        if ($tipoUsuario !== 'admin') {
            $consulta->bindValue(":usuario_id", $idUsuario);
        }

        $consulta->execute();

    }    

    // Métodos para a área pública do site
    public function buscarNoticiasParaAreaPublica():array {
        $sql = "SELECT id, titulo, resumo, imagem FROM noticias ORDER BY data DESC";

        $consulta = $this->conexao->query($sql);
        return $consulta->fetchAll();

    }

    public function exibirNoticiaCompleta(int $idNoticia):array {

        $sql = "SELECT
                    noticias.id,
                    noticias.titulo,
                    noticias.data,
                    noticias.texto,
                    noticias.imagem,
                    usuarios.nome AS autor
                FROM noticias JOIN usuarios
                ON noticias.usuario_id = usuarios.id
                WHERE noticias.id = :id";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $idNoticia);
        $consulta->execute();
        return $consulta->fetch();

    }

    public function buscarNoticias(string $valorProcurado):array {

        $sql = "SELECT
                    id, titulo, resumo, data 
                FROM noticias
                WHERE titulo LIKE :valor OR resumo LIKE :valor OR texto LIKE :valor
                ORDER BY data DESC";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":valor", '%'.$valorProcurado. '%');
        $consulta->execute();
        return $consulta->fetchAll();
        
        /* Sobre o operadores LIKE e o % 
        Ao programar buscas em campos, para que a busca não seja restritiva demais,
        em vez de usar coluna = valorProcurado, usamos coluna LIKE valorProcurado.
        Para que a busca possibilite encontrar a palavra/termo em qualquer parte de uma frase/texto,
        aplicamos o operador corinda % antes e depois do que está sendo buscado        
        */

    }

}