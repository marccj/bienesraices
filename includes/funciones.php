<?php

require 'app.php';

function incluirTemplate(string $nombreTemplate, bool $inicio = false) {
    $inicio = $inicio;
    include TEMPLATES_URL . "/${nombreTemplate}.php";      
}
