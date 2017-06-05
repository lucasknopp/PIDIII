<?php

$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    require_once '../config/class/Romaneios.class.php';
    $id = $_GET['id'];
    $romaneiosRepository = new RomaneiosRepository();
    $romaneios = $romaneiosRepository->excluir($id);
    header("Location: " . $urlvoltar);
} else {
    header("Location: " . $urlvoltar);
}