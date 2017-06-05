<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );
require_once '../config/class/Cidade.class.php';

if(isset($_GET['estado'])){
    $estado = $_GET['estado'];
    $cidadeRepository = new CidadeRepository();
    $cidade = $cidadeRepository->listarPorEstado($estado);
    echo(json_encode($cidade));
}else {
    echo null;
}

