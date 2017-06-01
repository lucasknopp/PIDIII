<?php
include 'tema/cabecalho.php';
require_once '../config/class/Veiculos.class.php';

$veiculosRepository = new VeiculosRepository();
$veiculos = $veiculosRepository->listar();
?>

<section class="Titulo">Lista de veículos</section>
<?php if(isset($_GET['red'])){
   echo '<section class="MensagemVermelha">'. $_GET['red'] . '</section>';
}?>
<section class="Lista">
    <table>
        <thead><tr><td>Placa</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if(empty($veiculos)){
                echo "<tr><td colspan=\"2\">Nenhum veículo cadastrado!</td><tr>";
            }
            foreach ($veiculos as $valor) {
                echo "<tr><td>".$valor->getNumplaca().'</td><td><a style="background-color: #cc0033;color:#fff;border-color:#cc0033;" onclick="ExcluirLinhaVeiculos('.$valor->getId().', \'Deseja realmente deletar o veículo com a placa: <b>'.$valor->getNumplaca().'</b>\')" href="javascript:void(0)">Excluir</a><a style="background-color: #E8702A;color:#fff;border-color:#E8702A;" href="editar_veiculos.php?id='.$valor->getId().'">Editar</a></td></tr>';
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
