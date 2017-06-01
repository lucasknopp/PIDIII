<?php
include 'tema/cabecalho.php';
require_once '../config/class/Motoristas.class.php';

$ok = "";
if (isset($_POST["cadastrar"])) {
    $motoristas = new Motoristas(0, $_POST["mot_nome"], $_POST["mot_numhabilitacao"]);
    $motoristas->valida();
    $mensagem = $motoristas->getMensagem();
    if (empty($mensagem)) {
        $motoristasRepository = new MotoristasRepository();
        $motoristasRepository->gravar($motoristas);
        $motoristas = new Motoristas();
        $ok = "ok";
    }
}
?>
<section class="Titulo">Cadastro de Motoristas</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Motoristas adicionado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
    <label>nome</label>
    <input type="text" name="mot_nome" value="" placeholder="Digite o nome..."/>
    <?= (isset($mensagem["mot_nome"]) ? '<section class="Erro">' . $mensagem["mot_nome"] . "</section>" : "") ?>
</section>
<section class="Item">
    <label>Número da habilitação</label>
    <input type="text" name="mot_numhabilitacao" value="" placeholder="Digite o número da habilitação..."/>
    <?= (isset($mensagem["mot_numhabilitacao"]) ? '<section class="Erro">' . $mensagem["mot_numhabilitacao"] . "</section>" : "") ?>
</section>

    <section class="Item">
        <button type="submit" name="cadastrar">Cadastrar motorista</button>
    </section>
</form>
<?php
include 'tema/rodape.php';