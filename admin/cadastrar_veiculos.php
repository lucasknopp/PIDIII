<?php
include 'tema/cabecalho.php';
require_once '../config/class/Veiculos.class.php';

$ok = "";
if (isset($_POST["cadastrar"])) {
    $veiculos = new Veiculos(0, strtoupper($_POST["vei_numplaca"]));
    $veiculos->valida();
    $mensagem = $veiculos->getMensagem();
    if (empty($mensagem)) {
        $veiculosRepository = new VeiculosRepository();
        $veiculosRepository->gravar($veiculos);
        $veiculos = new Veiculos();
        $ok = "ok";
    }
}
?>
<section class="Titulo">Cadastro de Veículos</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Veículo adicionado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
    <label>Placa do veículo</label>
    <input type="text" name="vei_numplaca" value="" placeholder="Digite a placa do veículo..."/>
    <?= (isset($mensagem["vei_numplaca"]) ? '<section class="Erro">' . $mensagem["vei_numplaca"] . "</section>" : "") ?>
</section>

    <section class="Item">
        <button type="submit" name="cadastrar">Cadastrar veiculo</button>
    </section>
</form>
<?php
include 'tema/rodape.php';