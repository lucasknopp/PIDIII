<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );

require '../config/conexao.php';
$pdo = Conexao();

if(isset($_GET['nome_user']))
{
$nome_user = $_GET['nome_user'];

$clientes = array();

$select_clientes = $pdo->prepare("SELECT cli_id, cli_nome, cli_cpf FROM clientes WHERE cli_nome LIKE :cli_nome ORDER BY cli_nome");
$parametros = array(":cli_nome" => "%".$nome_user."%");
$select_clientes->execute($parametros);
$linha_clientes = $select_clientes->fetchAll();

foreach ($linha_clientes as $valor)
{
    $clientes[] = array('cod_cliente' => $valor['cli_id'], 'nome' => $valor['cli_nome'], 'cpf' => $valor['cli_cpf']);
}
echo( json_encode( $clientes ) );
}else {
    $clientes[] = array('cod_cliente' => "", 'nome' => "Não foi possível carregar...", 'cpf' => "");
    echo( json_encode( $clientes ) );
}