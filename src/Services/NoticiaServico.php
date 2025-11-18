<?php
// src/Services/NoticiaServico.php

class NoticiaServico {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Conecta::getConexao();
    }
    
    // Versão básica (provisória)
    public function buscar():array {

        $sql = "SELECT * FROM noticias ORDER BY data DESC";
        $consulta = $this->conexao->query($sql);
        return $consulta->fetchAll();

    }


}