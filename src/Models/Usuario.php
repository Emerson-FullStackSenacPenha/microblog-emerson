<?php
// src/Models/Usuario.php

class Usuario {

    private string $nome;
    private string $email;
    private string $senha;
    private string $tipo;
    private ?int $id;

    public function __construct(
        
        string $valorNome,
        string $valorEmail,
        string $valorSenha,
        string $valorTipo,
        ?int $valorId = null
    
    ) {
      
        $this->setNome($valorNome);
        $this->setEmail($valorEmail);
        $this->setEmail($valorEmail);
        $this->setSenha($valorSenha);
        $this->setTipo($valorTipo);
        $this->setId($valorId);

    }

}

?>