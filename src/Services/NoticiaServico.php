<?php
// src/Services/NoticiaServico.php

class NoticiaServico {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Conecta::getConexao();
    }
    
    // Versão básica (provisória)
    public function buscar():array {

        $sql = "SELECT  
                    noticias.id,
                    noticias.titulo,
                    noticias.data,
                    usuarios.nome AS autor

                FROM noticias JOIN usuarios 
                ON noticias.usuario_id = usuarios.id
                ORDER BY data DESC";
        $consulta = $this->conexao->query($sql);
        return $consulta->fetchAll();

    }


}