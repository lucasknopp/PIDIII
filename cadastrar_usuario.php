<?php
require 'config/conexao.php';
require 'config/funcoes.php';
include 'config/Bcrypt.php';
$pdo = Conexao();
$erros = array("inseriu" => "");
$values = array("nome" => "", "senha" => "", "email" => "", "dtnasc" => "", "sexo" => "", "cpf" => "");

if (isset($_POST['Cadastrar'])) {
    $values = ValidaPOST($values);
    if ($values['nome'] != "erro" && $values['senha'] != "erro" && $values['email'] != "erro" && $values['dtnasc'] != "erro" && $values['sexo'] != "erro" && $values['cpf'] != "erro") {
        $erros['inseriu'] = "ok";
        $inserir_cliente = $pdo->prepare("INSERT INTO clientes (nome, dtnasc, sexo, cpf, email, senha, data_cadastro) VALUES (:nome, :dtnasc, :sexo, :cpf, :email, :senha, :data_cadastro)");
        //perguntar a diferença do bindValue para o array.
        $parametros = array(":nome" => $values['nome'], ":dtnasc" => $values['dtnasc'], ":sexo" => $values['sexo'], ":cpf" => $values['cpf'], ":email" => $values['email'], ":senha" => Bcrypt::hash($values['senha']), ":data_cadastro" => date('c', time()));
        $inserir_cliente->execute($parametros);
        $values = array("nome" => "", "senha" => "", "email" => "", "dtnasc" => "", "sexo" => "", "cpf" => "");
    }
}
$pdo = null;
?>
<?php include 'tema/cabecalho.php'; ?>
<h1 class="TituloPagina">Cadastro de usuário</h1>
<form class="FormCadastro" action="cadastrar_usuario.php" method="post">
    <?php if ($erros['inseriu'] == "ok") { ?>
        <section class="MensagemSucesso">Você foi cadastrado com sucesso!</section>
    <?php } ?>
    <section class="Item">
        <input type="text" name="nome" value="<?=($values['nome'] != "erro" ? $values['nome'] : "" ) ?>" placeholder="Digite o seu nome..." />
        <?php if ($values['nome'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha o nome!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="email" name="email" value="<?=($values['email'] != "erro" ? $values['email'] : "" ) ?>" placeholder="Digite o seu email..." />
        <?php if ($values['email'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha o e-mail!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="password" name="senha" value="<?=($values['senha'] != "erro" ? $values['senha'] : "" ) ?>" placeholder="Digite a sua senha..." />
        <?php if ($values['senha'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha a senha!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="date" name="dtnasc" value="<?=($values['dtnasc'] != "erro" ? $values['dtnasc'] : "" ) ?>" placeholder="Digite a data de nascimento..." />
        <?php if ($values['dtnasc'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha a data de nascimento!</section>
        <?php } ?>
    </section>
    <section class="Item">
        <input type="text" name="cpf" value="<?=($values['cpf'] != "erro" ? $values['cpf'] : "" ) ?>" placeholder="Digite o seu cpf..." />
        <?php if ($values['cpf'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Preencha o cpf!</section>
        <?php } ?>
        <section class="Sexo">
            <input type="radio" <?php if($values['sexo'] == "M") {echo "checked";} ?> name="sexo" id="S_Masculino" value="M"/><label for="S_Masculino">Masculino</label> 
            <input type="radio" <?php if($values['sexo'] == "F") {echo "checked";} ?> name="sexo" id="S_Feminino" value="F"/><label for="S_Feminino">Feminino</label> 
        </section>
<?php if ($values['sexo'] == "erro") { ?>
            <section class="Erro"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Selecione o sexo!</section>
<?php } ?>
        <input type="submit" name="Cadastrar" value="Cadastrar" />
</form>
<?php
include 'tema/rodape.php';
