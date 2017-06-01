<?php
include 'tema/cabecalho.php';
require_once '../config/class/Romaneios.class.php';

$romaneiosRepository = new RomaneiosRepository();
$romaneios = $romaneiosRepository->listarViagem();
?>

<section class="Titulo">Lista de romaneios</section>
<?php if(isset($_GET['red'])){
   echo '<section class="MensagemVermelha">'. $_GET['red'] . '</section>';
}?>
<section class="Lista">
    <table>
        <thead><tr><td>Identificação</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if (empty($romaneios)) {
                echo "<tr><td colspan=\"2\">Nenhum romaneio cadastrado!</td><tr>";
            }
            foreach ($romaneios as $valor) {
                if (validaDTMaiorTrue(date("d/m/Y H:i"), $valor->getDtorigem()) || $_SESSION['user'] == 'master') {
                    echo "<tr><td><b>Data:</b> " . $valor->getDtorigem() . " - <b>Destino:</b> " . $valor->getIddestino() . '</td><td><a style="background-color: #cc0033;color:#fff;border-color:#cc0033;" onclick="ExcluirLinhaRomaneios(' . $valor->getId() . ', \'Deseja realmente deletar o romaneio da <b>Data:</b> ' . $valor->getDtorigem() . ' - <b>Destino:</b> ' . $valor->getIdorigem() . '\')" href="javascript:void(0)">Excluir</a><a style="background-color: #E8702A;color:#fff;border-color:#E8702A;" href="editar_romaneios.php?id=' . $valor->getId() . '">Editar</a></td></tr>';
                } else {
                    echo "<tr><td><b>Data:</b> " . $valor->getDtorigem() . " - <b>Destino:</b> " . $valor->getIddestino() . '</td><td>Horário exedido!</td></tr>';
                }
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
