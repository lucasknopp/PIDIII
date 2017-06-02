<?php
include 'tema/cabecalho.php';
require '../config/conexao.php';
$pdo = Conexao();
$listar_encomendas = $pdo->prepare("SELECT enc_id, enc_codrastreio FROM encomendas ORDER BY enc_data DESC");
$listar_encomendas->execute();
$linha = $listar_encomendas->fetchAll();
$quant = $listar_encomendas->rowCount();
echo '<section class="Titulo">Lista de encomendas</section>';
echo '<section class="Lista">';
echo '<table>';
echo '<thead><tr><td>Código</td><td>Ações</td></tr></thead>';
echo '<tbody>';
foreach ($linha as $dados) {
    echo "<tr><td>".$dados['enc_codrastreio']."</td><td><a style=\"background-color: #cc0033;color:#fff;border-color:#cc0033;\" onclick=\"ExcluirLinha(".$dados['enc_id'].", 'encomendas', 'enc_id', 'Deseja realmente excluir a encomenda com o código: ".$dados['enc_id']."?')\" href=\"javascript:void(0)\">Excluir</a><a style=\"background-color: #E8702A;color:#fff;border-color:#E8702A;\" href=\"editar_encomendas.php?id=".$dados['enc_id']."\">Editar</a></td></tr>";
}
if($quant == 0){
    echo '<tr><td colspan="2">Nenhuma encomenda cadastrada!</td></tr>';
}
echo '</tbody>';
echo '</table></section>';
?>



<?php
include 'tema/rodape.php';