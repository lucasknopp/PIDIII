<?php
include 'tema/cabecalho.php';
require_once '../config/class/Romaneios.class.php';

$romaneiosRepository = new RomaneiosRepository();
$romaneios = $romaneiosRepository->listarInner();
?>

<section class="Titulo">Lista de romaneios</section>
<section class="Lista">
    <table>
        <thead><tr><td>Identificação</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if(empty($romaneios)){
                echo "<tr><td colspan=\"2\">Nenhum romaneio cadastrado!</td><tr>";
            }
            foreach ($romaneios as $valor) {
                echo "<tr><td><b>Data:</b> ".$valor->getDtorigem()." - <b>Destino:</b> ".$valor->getIdorigem().'</td><td><a style="background-color: #cc0033;color:#fff;border-color:#cc0033;" onclick="ExcluirLinhaRomaneios('.$valor->getId().', \'Deseja realmente deletar o romaneio da <b>Data:</b> '.$valor->getDtorigem().' - <b>Destino:</b> '.$valor->getIdorigem().'\')" href="javascript:void(0)">Excluir</a><a style="background-color: #E8702A;color:#fff;border-color:#E8702A;" href="javascript:void(0)">Editar</a></td></tr>';
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
