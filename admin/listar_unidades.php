<?php
include 'tema/cabecalho.php';
require_once '../config/class/Unidades.class.php';

$unidadesRepository = new UnidadesRepository();
$unidades = $unidadesRepository->listar();
?>

<section class="Titulo">Lista de unidades</section>
<?php
if (isset($_GET['red'])) {
    echo '<section class="MensagemVermelha">' . $_GET['red'] . '</section>';
}
?>
<section class="Lista">
    <table>
        <thead><tr><td>Nome</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if (empty($unidades)) {
                echo "<tr><td colspan=\"2\">Nenhum veículo cadastrado!</td><tr>";
            }
            foreach ($unidades as $valor) {
                    echo "<tr><td>" . $valor->getNome() . '</td><td><a style="background-color: #cc0033;color:#fff;border-color:#cc0033;" onclick="ExcluirLinhaUnidades(' . $valor->getId() . ', \'Deseja realmente deletar a unidade: <b>' . $valor->getNome() . '</b>\')" href="javascript:void(0)">Excluir</a><a style="background-color: #E8702A;color:#fff;border-color:#E8702A;" href="editar_unidades.php?id=' . $valor->getId() . '">Editar</a></td></tr>';
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
