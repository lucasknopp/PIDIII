<?php
include 'tema/cabecalho.php';
require_once '../config/class/Motoristas.class.php';

$motoristasRepository = new MotoristasRepository();
$motoristas = $motoristasRepository->listar();
?>

<section class="Titulo">Lista de motoristas</section>
<section class="Lista">
    <table>
        <thead><tr><td>Nome</td><td>Ações</td></tr></thead>
        <tbody>
            <?php
            if(empty($motoristas)){
                echo "<tr><td colspan=\"2\">Nenhum motorista cadastrado!</td><tr>";
            }
            foreach ($motoristas as $valor) {
                echo "<tr><td>".$valor->getNome().'</td><td><a style="background-color: #cc0033;color:#fff;border-color:#cc0033;" onclick="ExcluirLinhaMotoristas('.$valor->getId().', \'Deseja realmente deletar o motorista <b>'.$valor->getNome().'</b>\')" href="javascript:void(0)">Excluir</a><a style="background-color: #E8702A;color:#fff;border-color:#E8702A;" href="editar_motoristas.php?id='.$valor->getId().'">Editar</a></td></tr>';
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include 'tema/rodape.php';
