<?php
require_once '../config/class/Clientes.class.php';
require_once '../config/Bcrypt.php';
$time = new DateTime('now'); $newtime = $time->modify('-18 year -1 day')->format('d/m/Y'); 
$ok = "";
$clientes = new Clientes();
$clientes->setDtnasc($newtime);
if (isset($_POST['cadastrar'])) {
    if(isset($_POST["cli_sexo"])){
        $sexo = $_POST["cli_sexo"];
    }else{
        $sexo = "";
    }
    $clientes = new Clientes(0, $_POST["cli_nome"], $_POST["cli_dtnasc"], $sexo, $_POST["cli_cpf"], $_POST["cli_email"], $_POST["cli_senha"], date("d/m/Y H:i"), 0);
    $clientes->valida();
    $mensagem = $clientes->getMensagem();
    if (empty($mensagem)) {
        $clientes->setSenha(Bcrypt::hash($_POST["cli_senha"]));
        $clientesRepository = new ClientesRepository();
        $clientesRepository->gravar($clientes);
        $clientes = new Clientes();
        $ok = "ok";
    }
}

$pdo = null;
?>
<?php include 'tema/cabecalho.php'; ?>
<section class="Titulo">Cadastro de Clientes</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Clientes adicionado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Nome completo</label>
        <input type="text" name="cli_nome" value="<?= $clientes->getNome() ?>" placeholder="Digite um nome..."/>
        <?= (isset($mensagem["cli_nome"]) ? '<section class="Erro">' . $mensagem["cli_nome"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Data de Nascimento</label>
        <input type="text" name="cli_dtnasc" value="<?= $clientes->getDtnasc() ?>" placeholder="Digite a data de nascimento..."/>
        <?= (isset($mensagem["cli_dtnasc"]) ? '<section class="Erro">' . $mensagem["cli_dtnasc"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Cpf</label>
        <input type="text" name="cli_cpf" value="<?= $clientes->getCPF() ?>" placeholder="Digite um cpf..."/>
        <?= (isset($mensagem["cli_cpf"]) ? '<section class="Erro">' . $mensagem["cli_cpf"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>E-mail</label>
        <input type="text" name="cli_email" value="<?= $clientes->getEmail() ?>" placeholder="Digite um email..."/>
        <?= (isset($mensagem["cli_email"]) ? '<section class="Erro">' . $mensagem["cli_email"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Senha</label>
        <input type="password" name="cli_senha" value="<?= $clientes->getSenha() ?>" placeholder="Digite um senha..."/>
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
        <button type="submit" name="cadastrar">Cadastrar clientes</button>
    </section>
</form>
<script type="text/javascript">
    $(function () {
        $('input[name="cli_dtnasc"]').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            pick12HourFormat: false,
            maxDate: '<?php echo $newtime; ?>',
            locale: {
                format: 'DD/MM/YYYY'
                        // 2016-11-10T03:28:15+00:00
            }
        });
    });
</script>
<?php
include 'tema/rodape.php';
