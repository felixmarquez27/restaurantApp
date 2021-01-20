<?php
session_start();
    require '../model/config.php';
    require '../model/clases.php';
    if (!isset( $_SESSION['carrito'])) {
        $_SESSION['carrito']=[];
    }
    $todosLosProductos=Producto::getTodosLosProductos();
    //print_r($todosLosProductos);
    $totalCarrito=Carrito::getTotalCarrito($_SESSION['carrito']);
    $tituloPagina='Inicio';
    require '../view/inicio.view.php';
    
?>