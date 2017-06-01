<?php

function validaNulo($string) {
    if (!empty($string)) {
        return true;
    } else {
        return false;
    }
}

function validaDataSimplesEUA($data) { //valida data no formato 2016-12-30
    $dataex = explode("-", $data);
    $dDia = $dataex[2];
    $dMes = $dataex[1];
    $dAno = $dataex[0];

    //echo $dataex[0]

    if (checkdate($dMes, $dDia, $dAno) == "1") {
        return true;
    } else {
        return false;
    }
}

function validaDataSimplesBR($data) { //valida data no formato 30-12-2016
    $dataex = explode("-", $data);
    $dDia = $dataex[0];
    $dMes = $dataex[1];
    $dAno = $dataex[2];

    //echo $dataex[0]

    if (checkdate($dMes, $dDia, $dAno) == "1") {
        return true;
    } else {
        return false;
    }
}

function validaCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) {
        $soma += $cpf{$i} * $j;
    }
    $resto = $soma % 11;
    if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto)) {
        return false;
    }
    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) {
        $soma += $cpf{$i} * $j;
    }
    $resto = $soma % 11;

    $invalidos = array('00000000000','11111111111','22222222222','33333333333','44444444444','55555555555','66666666666','77777777777','88888888888','99999999999');
    
    if (in_array($cpf, $invalidos)){
        return false;
    }
    
    return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
}

function validaDTHR($dataehora){ // valida data e hora no formato 24/05/2017 22:07
    if(!empty($dataehora)){
        $dataehora = trim($dataehora);
        $dataex = explode(" ", $dataehora);
        $data = $dataex[0];
        $hora = $dataex[1];
        if(strlen($data) == "10" && strlen($hora) == "5"){
           $dataex = explode("/", $data);
           $dia = $dataex[0];
           $mes = $dataex[1];
           $ano = $dataex[2];
           if(checkdate($mes, $dia, $ano) == "1"){
               $dataex = explode(":", $hora);
               $hora = $dataex[0];
               $minutos = $dataex[1];
               if($hora >= 00 && $hora <= 23 && $minutos >= 00 && $minutos <= 59){
                   return true;
               }
           }
        }
    }
    return false;
}

function validaQuntCarac($frase, $quantidade){
    if(!empty($frase) && !empty($quantidade)){
        $frase = trim($frase);
        if(strlen(utf8_decode($frase)) <= $quantidade){
            return true;
        }
    }else{
        false;
    } 
}

function validaIgualdade($valorum, $valordois){
    if($valorum == $valordois){
        return true;
    }
    return false;
}

function validaPlacaVeiculo($placa){
    $valido = "/[a-zA-Z]{3}[0-9]{4}/";
    if(!empty($placa) && strlen($placa) == "7"){
        if ( preg_match( $valido, $placa ) == 1 ) {
		return true;
	}
    }
    return false;
}

function inverteDT($data){
    $datainv = explode("/", $data);
    $data = $datainv[2]."".$datainv[1]."".$datainv[0];
    return $data;
}

function validaDTMaior($dataum, $datadois){ // 24/05/2017 22:07
    if(!empty($dataum) && !empty($datadois)){
        $dataex = explode(" ", $dataum);
        $auxdataum = $dataex[0];
        $auxhoraum = $dataex[1];
        $dataex = explode(" ", $datadois);
        $auxdatadois = $dataex[0];
        $auxhoradois = $dataex[1];
        $auxdataum = inverteDT($auxdataum);
        $auxdatadois = inverteDT($auxdatadois);
        if($auxdataum > $auxdatadois){
            return $dataum;
        }else if($auxdataum < $auxdatadois){
            return $datadois;
        }else if($auxdataum == $auxdatadois){
            $auxhoraum = str_replace(":", "", $auxhoraum);
            $auxhoradois = str_replace(":", "", $auxhoradois);
            if($auxhoraum > $auxhoradois){
                return $dataum;
            }else if($auxhoraum < $auxhoradois){
                return $datadois;
            }else{
                return 1;
            }
        }
    }
    return false;
}

function validaDTMaiorTrue($dataum, $datadois){ // 24/05/2017 22:07
    if(!empty($dataum) && !empty($datadois)){
        $dataex = explode(" ", $dataum);
        $auxdataum = $dataex[0];
        $auxhoraum = $dataex[1];
        $dataex = explode(" ", $datadois);
        $auxdatadois = $dataex[0];
        $auxhoradois = $dataex[1];
        $auxdataum = inverteDT($auxdataum);
        $auxdatadois = inverteDT($auxdatadois);
        if($auxdataum > $auxdatadois){
            return false;
        }else if($auxdataum < $auxdatadois){
            return true;
        }else if($auxdataum == $auxdatadois){
            $auxhoraum = str_replace(":", "", $auxhoraum);
            $auxhoradois = str_replace(":", "", $auxhoradois);
            if($auxhoraum > $auxhoradois){
                return false;
            }else if($auxhoraum < $auxhoradois){
                return true;
            }
        }
    }
    return false;
}

$variavel1 = "25/06/2017 22:08";
$variavel2 = "25/06/2017 22:07";

// validaNulo($variavel) | Sim
// validaCPF($variavel) | Sim
// validaQuntCarac($frase, $quantlimite) | Sim
// validaDTHR($dataehora) | Sim
// validaQuntCarac($frase, $quantidade) | Sim
// validaIgualdade($valorum, $valordois) | Sim
// validaPlacaVeiculo($placa) | Sim
// validaDTMaior($dataum, $datadois) | 