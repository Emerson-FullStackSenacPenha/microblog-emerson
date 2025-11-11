<?php 

// src/Services/AutenticacaoServico.php
require_once "src/Helpers/Utils.php";

class AutenticacaoServico {

    public static function iniciarSessao():void {

        // Verificando se não há sessão em andamento ou ativa
        if(session_status() !== PHP_SESSION_ACTIVE ){
            
            // Não havendo, inicializa uma sessão
            session_start();
        }

    }

    public static function exigirLogin():void {

        //self:: pra acessar o método estático ou o nome da classe AutenticacaoServico::
        // Verificando se já tem sessão
        self::iniciarSessao();

        /*Se não existir uma variavél de sessão para o id de um usuário, na p´ratica, é porque NÃO TEM NINGUÉM LOGADO.*/
        if(!isset($_SESSION['id'])){
            Utils::redirecionarPara("../login.php?acesso_proibido");
        }

        

    }


}

?>