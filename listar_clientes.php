<?php

require 'config/conexao.php';
$pdo = Conexao();
$listar_clientes = $pdo->prepare("SELECT cli_id, cli_nome FROM clientes ORDER BY cli_nome");
$listar_clientes->execute();
$linha = $listar_clientes->fetchAll();
$quant = $listar_clientes->rowCount();
foreach ($linha as $dados) {
    echo "<li>".$dados['cli_nome']."<a href=\"excluir_linha.php?tabela=clientes&id=".$dados['cli_id']."&p=listar_clientes.php\">Excluir</a><a href=\"#\">Editar</a></li>";
}
if($quant == 0){
    echo "<br/>Nenhum cliente cadastrado!";
}
?>