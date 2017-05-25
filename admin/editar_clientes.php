<?php
require '../config/conexao.php';
require '../config/funcoes.php';
include '../config/Bcrypt.php';
include 'validarCPF.php';
$pdo = Conexao();
$erros = array("inseriu" => "");
$vercpf = true;
$values = array("nome" => "", "senha" => "", "email" => "", "dtnasc" => "", "sexo" => "", "cpf" => "");

if(isset($_GET['id'])){
    $sql = "SELECT cli_nome, cli_senha, cli_dtnasc, cli_sexo, cli_email, cli_cpf FROM clientes WHERE cli_id = :id";
    $select_cliente = $pdo->prepare($sql);
    $parametros['id'] = $_GET['id'];
    $select_cliente->execute($parametros);
    $linha = $select_cliente->fetchAll();
    $values['nome'] = $linha[0]['cli_nome'];
    $values['senha'] = $linha[0]['cli_senha'];
    $values['dtnasc'] = $linha[0]['cli_dtnasc'];
    $values['sexo'] = $linha[0]['cli_sexo'];
    $values['cpf'] = $linha[0]['cli_cpf'];
    $values['email'] = $linha[0]['cli_email'];
}

if (isset($_POST['Cadastrar']) && isset($_GET['id'])) {
    $values = ValidaPOST($values);
    $vercpf = validaCPF($values['cpf']);
    if ($values['nome'] != "erro" && $values['senha'] != "erro" && $values['email'] != "erro" && $values['dtnasc'] != "erro" && $values['sexo'] != "erro" && $values['cpf'] != "erro" && $vercpf == true) {
        $erros['inseriu'] = "ok";
        $inserir_cliente = $pdo->prepare("UPDATE clientes SET cli_nome = :nome, cli_dtnasc = :dtnasc, cli_sexo = :sexo, cli_cpf = :cpf, cli_email = :email, cli_senha = :senha WHERE cli_id = :id");
        //perguntar a diferença do bindValue para o array.
        if($values['senha'] != $linha[0]['cli_senha'])
        {
            $values['senha'] = Bcrypt::hash($values['senha']);
        }
        $parametros = array(":nome" => $values['nome'], ":id" => $_GET['id'], ":dtnasc" => $values['dtnasc'], ":sexo" => $values['sexo'], ":cpf" => $values['cpf'], ":email" => $values['email'], ":senha" => $values['senha']);
        $inserir_cliente->execute($parametros);
    }
}
$pdo = null;
?>
<?php include 'tema/cabecalho.php'; ?>
<section class="Titulo">Editar cliente</section>
<form class="FormPadrao" method="post">
    <?php if ($erros['inseriu'] == "ok") { ?>
        <section class="MensagemVerde">Cliente atualizado com sucesso!</section>
    <?php } ?>
    <section class="Item">
        <input type="text" name="nome" value="<?= ($values['nome'] != "erro" ? $values['nome'] : "" ) ?>" placeholder="Digite o seu nome..." />
        <?php ExibeErro($values['nome'], "Preencha o nome!"); ?>
    </section>
    <section class="Item">
        <input type="email" name="email" value="<?= ($values['email'] != "erro" ? $values['email'] : "" ) ?>" placeholder="Digite o seu email..." />
        <?php if ($values['email'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha o e-mail!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="password" name="senha" value="<?= ($values['senha'] != "erro" ? $values['senha'] : "" ) ?>" placeholder="Digite a sua senha..." />
        <?php if ($values['senha'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha a senha!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="date" name="dtnasc" value="<?= ($values['dtnasc'] != "erro" ? $values['dtnasc'] : "" ) ?>" placeholder="Digite a data de nascimento..." />
        <?php if ($values['dtnasc'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha a data de nascimento!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="text" name="cpf" value="<?= ($values['cpf'] != "erro" ? $values['cpf'] : "" ) ?>" placeholder="Digite o seu cpf..." />
        <?php if ($values['cpf'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha o cpf!</section>
        <?php } ?>
        <?php if ($vercpf != true) { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> CPF invalido!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <section class="Sexo">
            <input type="radio" <?php
            if ($values['sexo'] == "M") {
                echo "checked";
            }
            ?> name="sexo" id="S_Masculino" value="M"/><label for="S_Masculino">Masculino</label> 
            <input type="radio" <?php
            if ($values['sexo'] == "F") {
                echo "checked";
            }
            ?> name="sexo" id="S_Feminino" value="F"/><label for="S_Feminino">Feminino</label> 
        </section>
        <?php if ($values['sexo'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Selecione o sexo!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <button type="submit" name="Cadastrar" >Editar</button>
    </section>
</form>
<?php
include 'tema/rodape.php';
