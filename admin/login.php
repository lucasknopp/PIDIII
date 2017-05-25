<?php
require 'config/conexao.php';
require 'config/funcoes.php';
require 'config/Bcrypt.php';
$values = array("email" => "", "senha" => "");
if (isset($_POST['Login']) && !empty($_POST['Login'])) {
    $values = ValidaPOST($values);

    $pdo = Conexao();
    $select_login = $pdo->prepare("SELECT email, senha FROM clientes WHERE email = :email ORDER BY id DESC LIMIT 1");
    $parametros = array(":email" => $values['email']);
    $select_login->execute($parametros);
    if ($select_login->rowCount() == 0) {
        echo "e-mail ou senha não encontrada!";
    } else {
        $linha = $select_login->fetchAll();
        $hash_user = $linha[0]['senha'];
        if (Bcrypt::check($values['senha'], $hash_user)) {
            $_SESSION['login'] = $values['email'];
            echo "login efetuado com sucesso!";
        } else {
            echo "e-mail ou senha não encontrada!";
        }
    }
}

//if(isset($_SESSION['login']) && !empty($_SESSION['login'])){} -- Verifica se está logado

include 'tema/cabecalho.php';
?>

<h1 class="TituloPagina">Login</h1>

<form action="login.php" class="FormCadastro" method="post">
    <section class="Item">
        <label>E-mail</label>
        <input type="text" value="" name="email" placeholder="Digite seu e-mail..." />
    </section>
    <section class="Item">
        <label>Senha</label>
        <input type="password" name="senha" value="" placeholder="Digite a sua senha..." />
    </section>
    <section class="Item">
        <input type="submit" name="Login" value="Entrar" />
    </section>
</form>

<?php
include 'tema/cabecalho.php';
