<?php
// src/Helpers/Utils.php

class Utils {

    // static pra não precisar criar um objeto
    
    /* Usamos mixed para sinalizar que o método aceita/retorna tipos de dados variados (string, int, array, float etc)
    */
    public static function sanitizar(mixed $valor, string $tipodeSanitizacao = 'texto'):mixed {

        switch($tipodeSanitizacao){

            case 'inteiro':
                return (int) filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
            
            case 'email':
                return trim(filter_var($valor, FILTER_SANITIZE_EMAIL));    

            default:
                return trim(filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS));    

        }

    }

    /* Ao chamar método verificarSenha, passamos para ele a senha digitada no formulário e a senha existente no banco. */

    public static function codificarSenha(string $valorSenha):string {
        return password_hash($valorSenha, PASSWORD_DEFAULT);
    }

    public static function verificarSenha(
        string $senhaDigitadaNoFormulario, string $senhaArmazenadaNoBanco
    ){

        /* Usamo o password_verify para COMPARAR as duas senhas. */
        if(password_verify($senhaDigitadaNoFormulario, $senhaArmazenadaNoBanco)){
            // São iguais ?

                // Então retorne a mesma senha já existente no banco
            return $senhaArmazenadaNoBanco;
        } else {
            // São diferentes ?
                // Então pega a senha digitada e faça um hash novo
            return self::codificarSenha($senhaDigitadaNoFormulario);
        }

    }

    public static function dump(mixed $dados):void {

        echo "<pre>";

        var_dump($dados);
        
        echo "</pre>";

    }

    public static function redirecionarPara(string $paginaDestino):void {

        header("location:".$paginaDestino);
		exit;

    }

}

?>