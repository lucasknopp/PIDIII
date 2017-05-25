<?php
include 'tema/cabecalho.php';
require '../config/conexao.php';
$pdo = Conexao();
$listar_clientes = $pdo->prepare("SELECT uni_id, uni_nome FROM unidades ORDER BY uni_nome");
$listar_clientes->execute();
$linha = $listar_clientes->fetchAll();
$quant = $listar_clientes->rowCount();
echo '<section class="Titulo">Lista de unidades</section>';
echo '<section class="Lista">';
echo '<table>';
echo '<thead><tr><td>Nome</td><td>Ações</td></tr></thead>';
echo '<tbody>';
foreach ($linha as $dados) {
    echo "<tr><td>".$dados['uni_nome']."</td><td><a style=\"background-color: #cc0033;color:#fff;border-color:#cc0033;\" onclick=\"ExcluirLinha(".$dados['uni_id'].", 'unidades', 'uni_id', 'Deseja realmente excluir o usuário ".$dados['uni_nome']."?')\" href=\"javascript:void(0)\">Excluir</a><a style=\"background-color: #E8702A;color:#fff;border-color:#E8702A;\" href=\"editar_unidades.php?id=".$dados['uni_id']."\">Editar</a></td></tr>";
}
if($quant == 0){
    echo '<tr><td colspan="2">Nenhuma unidade cadastrada!</td></tr>';
}
echo '</tbody>';
echo '</table></section>';
?>



<?php
include 'tema/rodape.php';