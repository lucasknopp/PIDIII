<?php
include 'tema/cabecalho.php';
require_once '../config/class/Romaneios.class.php';

$romaneiosRepository = new RomaneiosRepository();
$romaneios = $romaneiosRepository->listarViagem();
?>

<section class="Titulo">Lista de romaneios</section>
<?php if(isset($_GET['red'])){
   echo '<section class="MensagemVermelha">'. $_GET['red'] . '</section>';
}
if(isset($_GET['green'])){
   echo '<section class="MensagemVerde">'. $_GET['green'] . '</section>';
}?>
<section class="Lista">
    <table>
        <thead><tr><td>Identificação</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if (empty($romaneios)) {
                echo "<tr><td colspan=\"2\">Nenhum romaneio em viagem!</td><tr>";
            }
            foreach ($romaneios as $valor) {
                echo "<tr><td><b>Data:</b> " . $valor->getDtorigem() . " - <b>Destino:</b> " . $valor->getIddestino() . '</td><td><a style="background-color: #009933;color:#fff;border-color:#009933;" href="concluir_romaneios.php?id=' . $valor->getId() . '">Informar chegada</a></td></tr>';
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
