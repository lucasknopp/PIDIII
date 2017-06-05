<?php

$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    require_once '../config/class/Encomendas.class.php';
    $id = $_GET['id'];
    $encomendasRepository = new EncomendasRepository();
    $encomendas = $encomendasRepository->excluir($id);
    header("Location: " . $urlvoltar);
} else {
    header("Location: " . $urlvoltar);
}