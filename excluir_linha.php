<?php

require 'config/conexao.php';
if (isset($_GET['tabela']) && isset($_GET['id']) && isset($_GET['p'])) {
    $tabela = $_GET['tabela'];
    $id = $_GET['id'];
    $page = $_GET['p'];
    $pdo = Conexao();
    $sql = "DELETE FROM ".$tabela." WHERE cli_id = :id";
    $excluir_linha = $pdo->prepare($sql);
    $parametros = array(":id" => $id);
    $excluir_linha->execute($parametros);
    header("Location: ".$page."?m=".$id);
}else {
    header("Location: index.php");
}