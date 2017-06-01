<?php setlocale(LC_ALL, 'pt_BR'); date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Admin 1.0</title>
        <link href="tema/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        
        <script src="tema/js/scripts.js" type="text/javascript"></script>
        <link href="tema/css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="tema/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="tema/js/jquery.min.js" type="text/javascript"></script>
        <script src="tema/js/moment.min.js" type="text/javascript"></script>
        <script src="tema/js/daterangepicker.js" type="text/javascript"></script>
        <link href="tema/css/daterangepicker.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <section class="Cabecalho">
            <section class="Logo">
                <img src="tema/imagens/logow.png" alt="Frases Desmotivacionais"/>
            </section>
            <section class="Usuario">
                <span>Olá, Administrador</span>
                <a href="index.php" style="background-color: #222;border-left:1px solid #333;" class="opcoes"><i class="fa fa-home" aria-hidden="true"></i></a>
                <a href="indisponivel.php" class="opcoes"><i class="fa fa-cog" aria-hidden="true"></i></a>
                <a href="indisponivel.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
            </section>
        </section>
        <?php include 'lateral.php'; ?>
        <section class="Conteudo">