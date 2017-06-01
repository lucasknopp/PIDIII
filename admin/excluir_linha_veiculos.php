<?php

$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    require_once '../config/class/Veiculos.class.php';
    $id = $_GET['id'];
    $veiculosRepository = new VeiculosRepository();
    $veiculos = $veiculosRepository->excluir($id);
    header("Location: " . $urlvoltar . "?m=" . $id);
} else {
    header("Location: " . $urlvoltar);
}