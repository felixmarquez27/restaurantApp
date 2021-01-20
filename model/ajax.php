<?php 
session_start();
header('content-type: application/json; charset=utf-8');
 
require 'config.php';
require 'clases.php';
$conexion=ConexionBD::conexion();
if (!$conexion) {
	 $respuesta=[2,'error de conexion con el servidor'];
}else{
    $consulta=DataCleanner::string_cleanner($_POST['consulta']);
    switch ($consulta) {
        case 'get-info-producto':
            $idProducto=DataCleanner::number_cleanner($_POST['id']);
            $respuesta=Producto::getProducto($idProducto);
            break;
        case 'agregar_al_carrito':
            $carrito=new Carrito;
            $arrayDatos=json_decode($_POST['array_datos']);
            $respuesta=$carrito->agregarAlCarrito($arrayDatos);
            break;
        case 'consultar_carrito':
            $respuesta=Carrito::consultarCarrito();
            break;
        case 'sacar_producto_carrito':
            $posicion=DataCleanner::number_cleanner($_POST['posicion']);
            $respuesta=Carrito::sacarProductoCarrito($posicion);
            break;
        case 'buscar_producto':
            $text=DataCleanner::string_cleanner($_POST['text']);
            $respuesta=Producto::getTodosLosProductosBuscador($text);
            break;

        case 'confirmarcarrito':
            $arrayDatos=json_decode($_POST['array_datos']);
            $respuesta=Carrito::comprobarFormCarrito($arrayDatos);
            break;
            
            
    }



}
echo json_encode($respuesta);
 ?>