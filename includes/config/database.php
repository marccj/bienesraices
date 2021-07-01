<?php

function connectDB() {
    $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
    
    if(!$db) {
        echo "Error al conectarse a la base de datos";
        exit;
    } else {
        $db->set_charset('utf8');
    }

    return $db;
}