<?php
include 'tema/cabecalho.php';
require_once '../config/class/Encomendas.class.php';

$encomendasRepository = new EncomendasRepository();
$encomendas = $encomendasRepository->listar();
?>

<section class="Titulo">Lista de encomendas</section>
<?php
if (isset($_GET['red'])) {
    echo '<section class="MensagemVermelha">' . $_GET['red'] . '</section>';
}
?>
<section class="Lista">
    <table>
        <thead><tr><td>Código de rastreio</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if (empty($encomendas)) {
                echo "<tr><td colspan=\"2\">Nenhuma encomenda cadastrada!</td><tr>";
            }
            foreach ($encomendas as $valor) {
                if ($valor->getControleromaneio() == 0) {
                    echo "<tr><td>" . $valor->getCodrastreio() . '</td><td><a style="background-color: #cc0033;color:#fff;border-color:#cc0033;" onclick="ExcluirLinhaEncomendas(' . $valor->getId() . ', \'Deseja realmente deletar a encomenda: <b>' . $valor->getCodrastreio() . '</b>\')" href="javascript:void(0)">Excluir</a><a style="background-color: #E8702A;color:#fff;border-color:#E8702A;" href="editar_encomendas.php?id=' . $valor->getId() . '">Editar</a></td></tr>';
                } else {
                    echo "<tr><td>" . $valor->getCodrastreio() . '</td><td>Já está em um romaneio!</td></tr>';
                }
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
