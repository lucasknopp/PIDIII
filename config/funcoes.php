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
