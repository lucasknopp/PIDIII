<?php
require_once 'config/sessao.php';

if (isset($_SESSION['user'])) {
    header("Location: admin");
    exit;
}

if (isset($_POST['Logar'])) {
    $usuario = $_POST['gnu'];
    $senha = $_POST['gns'];
    $users = ['admin' => 'admin', 'master' => 'master'];

    foreach ($users as $pos => $valor) {
        if ($pos == $usuario && $valor == $senha) {
            $_SESSION['user'] = $usuario;
            header("Location: admin");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Global Transportadora</title>
        <link href="tema/css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="admin/tema/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <section class="Login">
            <img src="tema/imagens/globaltransportadora.png" width="160" alt=""/>
            <section class="Form">
                <section class="Titulo">Área Restrita</section>
                <form action="index.php" method="post">
                    <section class="Item">
                        <label><i class="fa fa-user" aria-hidden="true"></i></label>
                        <input type="text" value="" placeholder="Usuário" name="gnu" />
                    </section>
                    <section class="Item">
                        <label><i class="fa fa-key" aria-hidden="true"></i></label>
                        <input type="password" value="" placeholder="Senha" name="gns" />
                    </section>
                    <section class="Item">
                        <?php
                        if (isset($_POST['Logar'])) {
                            if (!isset($_SESSION['user'])) {
                                echo '<section class="MensagemVermelha">Usuário ou senha inválidos!</section>';
                            }
                        }
                        ?>
                    </section>
                    <section class="Item" style="padding-bottom: 4px;">
                        <button type="submit" name="Logar"><i class="fa fa-sign-in" aria-hidden="true"></i> Entrar</button>
                    </section>
                </form>
            </section>
            <img src="tema/imagens/webconsutoria.png" width="80" alt=""/>
        </section>
    </body>
</html>
