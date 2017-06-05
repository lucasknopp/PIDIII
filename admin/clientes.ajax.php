<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );
require_once '../config/class/Clientes.class.php';

if(isset($_GET['nome_user'])){
    $nome = $_GET['nome_user'];
    $clientesRepository = new ClientesRepository();
    $clientes = $clientesRepository->listarPorNome($nome);
    echo(json_encode($clientes));
}else {
    echo null;
}