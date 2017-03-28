<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );

require 'config/conexao.php';
$pdo = Conexao();

if(isset($_GET['cod_estados']))
{
$cod_estados = $_GET['cod_estados'];

$cidades = array();

$select_cidades = $pdo->prepare("SELECT id, nome FROM cidade WHERE estado = :estado ORDER BY nome");
$parametros = array(":estado" => $cod_estados);
$select_cidades->execute($parametros);
$linha_cidades = $select_cidades->fetchAll();

foreach ($linha_cidades as $valor)
{
    $cidades[] = array('cod_cidades' => $valor['id'], 'nome' => $valor['nome']);
}
echo( json_encode( $cidades ) );
}else {
    $cidades[] = array('cod_cidades' => "", 'nome' => "Não foi possível carregar...");
    echo( json_encode( $cidades ) );
}