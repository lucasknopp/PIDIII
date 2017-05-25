<?php

require '../config/conexao.php';
$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['tabela']) && isset($_GET['id']) && isset($_GET['coluna'])) {
    $tabela = $_GET['tabela'];
    $id = $_GET['id'];
    $coluna = $_GET['coluna'];
    $pdo = Conexao();
    $sql = "DELETE FROM " . $tabela . " WHERE " . $coluna . " = :id";
    $excluir_linha = $pdo->prepare($sql);
    $parametros = array(":id" => $id);
    $excluir_linha->execute($parametros);
    header("Location: " . $urlvoltar . "?m=" . $id);
} else {
    header("Location: " . $urlvoltar);
}