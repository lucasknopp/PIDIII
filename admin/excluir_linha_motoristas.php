<?php

$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    require_once '../config/class/Motoristas.class.php';
    $id = $_GET['id'];
    $motoristasRepository = new MotoristasRepository();
    $motoristas = $motoristasRepository->excluir($id);
    header("Location: " . $urlvoltar);
} else {
    header("Location: " . $urlvoltar);
}