<?php
include 'tema/cabecalho.php';
require_once '../config/class/Veiculos.class.php';

$ok = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $veiculosRepository = new VeiculosRepository();
    if (isset($_POST["cadastrar"])) {
        $veiculos = new Veiculos($id, $_POST["vei_numplaca"]);
        $veiculos->valida();
        $mensagem = $veiculos->getMensagem();
        if (empty($mensagem)) {
            $veiculosRepository->gravar($veiculos);
            $ok = "ok";
        }
    }
    $veiculos = $veiculosRepository->localizarId($id);
}
?>
<section class="Titulo">Editar veículo</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Veículo alterado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Placa do veículo</label>
        <input type="text" name="vei_numplaca" value="<?=$veiculos->getNumplaca() ?>" placeholder="Digite a placa do veículo..."/>
        <?= (isset($mensagem["vei_numplaca"]) ? '<section class="Erro">' . $mensagem["vei_numplaca"] . "</section>" : "") ?>
    </section>

    <section class="Item">
        <button type="submit" name="cadastrar">Editar veículo</button>
    </section>
</form>
<?php
include 'tema/rodape.php';
