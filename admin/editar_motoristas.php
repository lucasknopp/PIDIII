<?php
include 'tema/cabecalho.php';
require_once '../config/class/Motoristas.class.php';

$ok = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $motoristasRepository = new MotoristasRepository();
    if (isset($_POST["editar"])) {
        $motoristas = new Motoristas($_GET['id'], $_POST["mot_nome"], $_POST["mot_numhabilitacao"]);
        $motoristas->valida();
        $mensagem = $motoristas->getMensagem();
        if (empty($mensagem)) {
            $motoristasRepository->gravar($motoristas);
            $ok = "ok";
        }
    }
    $motoristas = $motoristasRepository->localizarId($id);
}
?>
<section class="Titulo">Editar motorista</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Motorista alterado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>nome</label>
        <input type="text" name="mot_nome" value="<?=$motoristas->getNome() ?>" placeholder="Digite o nome..."/>
        <?= (isset($mensagem["mot_nome"]) ? '<section class="Erro">' . $mensagem["mot_nome"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Número da habilitação</label>
        <input type="text" name="mot_numhabilitacao" value="<?=$motoristas->getNumhabilitacao() ?>" placeholder="Digite o número da habilitação..."/>
        <?= (isset($mensagem["mot_numhabilitacao"]) ? '<section class="Erro">' . $mensagem["mot_numhabilitacao"] . "</section>" : "") ?>
    </section>

    <section class="Item">
        <button type="submit" name="editar">Editar motorista</button>
    </section>
</form>
<?php
include 'tema/rodape.php';
