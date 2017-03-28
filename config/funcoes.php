<?php

function ValidaPOST($values) {
    foreach ($values as $valor => $results) {
        if (isset($_POST[$valor]) && !empty($_POST[$valor]))
            $values[$valor] = $_POST[$valor];
        else
            $values[$valor] = "erro";
    }
    return $values;
}

function VerificaArray($values) {
    foreach ($values as $valor => $results) {
        if ($results == "erro") {
            return false;
        }
    }
    return true;
}

function MantemValor($variavel) {
    if($variavel != "erro") {
        echo $variavel;
    }
}

function ExibeErro($variavel, $mensagem) {
    if ($variavel == "erro") {
        echo '<section class = "Erro"><i class = "fa fa-exclamation-circle" aria-hidden = "true"></i> ' . $mensagem . '</section>';
    }
}
