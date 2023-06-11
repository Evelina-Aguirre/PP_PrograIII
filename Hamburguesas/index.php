<?php

switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        // require_once "PizzaConsultar.php";
        break;
    case "POST":
        require_once "HamburguesaCarga.php";
        break;
}