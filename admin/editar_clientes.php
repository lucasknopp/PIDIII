<?php
require_once '../config/class/Clientes.class.php';
include '../config/Bcrypt.php';

$ok = "";
$urlvoltar = "listar_clientes.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $clientesRepository = new ClientesRepository();
    $clientes = $clientesRepository->localizarId($id);
    if (!empty($clientes)) {
        if (isset($_POST['editar'])) {
            if (isset($_POST["cli_sexo"])) {
                $sexo = $_POST["cli_sexo"];
            } else {
                $sexo = "";
            }
            $senha = $_POST["cli_senha"];
            if ($senha != "") {
                $senha = Bcrypt::hash($senha);
            } else {
                $senha = $clientes->getSenha();
            }
            $clientes = new Clientes($id, $_POST["cli_nome"], $_POST["cli_dtnasc"], $sexo, $_POST["cli_cpf"], $_POST["cli_email"], $senha, date("d/m/Y H:i"), 0);
            $clientes->valida(1);
            $mensagem = $clientes->getMensagem();
            if (empty($mensagem)) {
                $clientesRepository = new ClientesRepository();
                $clientesRepository->gravar($clientes);
                $ok = "ok";
            }
        }
    } else {
        header("Location: " . $urlvoltar . "?red=" . "Cliente não existe!");
        exit;
    }
} else {
    header("Location: " . $urlvoltar . "?red=" . "Cliente não existe!");
    exit;
}
?>
<?php include 'tema/cabecalho.php'; ?>
<section class="Titulo">Editar Cliente</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Clientes atualizado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>nome</label>
        <input type="text" name="cli_nome" value="<?= $clientes->getNome() ?>" placeholder="Digite um nome..."/>
        <?= (isset($mensagem["cli_nome"]) ? '<section class="Erro">' . $mensagem["cli_nome"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Data de Nascimento</label>
        <input type="text" name="cli_dtnasc" value="<?= $clientes->getDtnasc() ?>" placeholder="Digite a data de nascimento..."/>
        <?= (isset($mensagem["cli_dtnasc"]) ? '<section class="Erro">' . $mensagem["cli_dtnasc"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>cpf</label>
        <input type="text" name="cli_cpf" value="<?= $clientes->getCPF() ?>" placeholder="Digite um cpf..."/>
        <?= (isset($mensagem["cli_cpf"]) ? '<section class="Erro">' . $mensagem["cli_cpf"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>email</label>
        <input type="text" name="cli_email" value="<?= $clientes->getEmail() ?>" placeholder="Digite um email..."/>
        <?= (isset($mensagem["cli_email"]) ? '<section class="Erro">' . $mensagem["cli_email"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Nova senha <b style="color: #d9534f">(DEIXE VAZIO PARA NÃO ALTERAR)</b></label>
        <input type="password" name="cli_senha" value="" placeholder="Digite uma nova senha..."/>
        <?= (isset($mensagem["cli_senha"]) ? '<section class="Erro">' . $mensagem["cli_senha"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Sexo</label>
        <section class="Sexo">
            <input type="radio" <?php
            if ($clientes->getSexo() == "M") {
                echo "checked";
            }
            ?> name="cli_sexo" id="S_Masculino" value="M"/><label for="S_Masculino">Masculino</label> 
            <input type="radio" <?php
            if ($clientes->getSexo() == "F") {
                echo "checked";
            }
            ?> name="cli_sexo" id="S_Feminino" value="F"/><label for="S_Feminino">Feminino</label> 
        </section>
        <?= (isset($mensagem["cli_sexo"]) ? '<section class="Erro">' . $mensagem["cli_sexo"] . "</section>" : "") ?>
    </section>    

    <section class="Item">
        <button type="submit" name="editar">Atualizar cliente</button>
    </section>
</form>
<script type="text/javascript">
    $(function () {
        $('input[name="cli_dtnasc"]').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            pick12HourFormat: false,
            maxDate: '<?php echo date("d/m/Y"); ?>',
            locale: {
                format: 'DD/MM/YYYY'
                        // 2016-11-10T03:28:15+00:00
            }
        });
    });
</script>
<?php
include 'tema/rodape.php';
