<?php

$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    require_once '../config/class/Unidades.class.php';
    $id = $_GET['id'];
    $unidadesRepository = new UnidadesRepository();
    $unidades = $unidadesRepository->excluir($id);
    header("Location: " . $urlvoltar);
} else {
    header("Location: " . $urlvoltar);
}