<?php

$urlvoltar = $_SERVER['HTTP_REFERER'];
if (isset($_GET['id'])) {
    require_once '../config/class/Clientes.class.php';
    $id = $_GET['id'];
    $clientesRepository = new ClientesRepository();
    $clientes = $clientesRepository->excluir($id);
    header("Location: " . $urlvoltar);
} else {
    header("Location: " . $urlvoltar);
}