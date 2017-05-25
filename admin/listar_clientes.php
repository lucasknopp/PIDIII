<?php
include 'tema/cabecalho.php';
require '../config/conexao.php';
$pdo = Conexao();
$listar_clientes = $pdo->prepare("SELECT cli_id, cli_nome FROM clientes ORDER BY cli_nome");
$listar_clientes->execute();
$linha = $listar_clientes->fetchAll();
$quant = $listar_clientes->rowCount();
echo '<section class="Titulo">Lista de clientes</section>';
echo '<section class="Lista">';
echo '<table>';
echo '<thead><tr><td>Nome</td><td>Ações</td></tr></thead>';
echo '<tbody>';
foreach ($linha as $dados) {
    echo "<tr><td>".$dados['cli_nome']."</td><td><a style=\"background-color: #cc0033;color:#fff;border-color:#cc0033;\" onclick=\"ExcluirLinha(".$dados['cli_id'].", 'clientes', 'cli_id', 'Deseja realmente excluir o usuário ".$dados['cli_nome']."?')\" href=\"javascript:void(0)\">Excluir</a><a style=\"background-color: #E8702A;color:#fff;border-color:#E8702A;\" href=\"editar_clientes.php?id=".$dados['cli_id']."\">Editar</a></td></tr>";
}
if($quant == 0){
    echo '<tr><td colspan="2">Nenhum cliente cadastrado!</td></tr>';
}
echo '</tbody>';
echo '</table></section>';
?>



<?php
include 'tema/rodape.php';