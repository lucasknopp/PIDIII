<?php
$urlsite = "localhost/PIDIII";
require_once 'validacao.php';
function Conexao(){
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=bancopid", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET CHARACTER SET utf8");
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    return $pdo;
}

function ConexaoDB(){
    $pdo = new PDO("mysql:host=localhost;dbname=bancopid", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
    return $pdo;
}
//ob_start();
//session_start();
