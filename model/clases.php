<?php


class ConsultasBD{
    
    public static function consultaBD($query,$datos){ 
        $conexion=ConexionBD::conexion();
        $respuesta=[];
        $statement = $conexion->prepare($query);
        $statement->execute();
                    while ($fila = $statement->fetch()) {
                        $info = [];	
                        foreach ($datos as $key => $value) {
                            $info[$value]=$fila[$value];
                        }
                                        
                    array_push($respuesta, $info);							
                }
    return $respuesta;


    }

    public static function consulta_bd_simple($campo,$tabla,$condicion,$parametro){
		$conexion=ConexionBD::conexion();
		$statement = $conexion->prepare("SELECT {$campo} FROM {$tabla} WHERE {$condicion}='$parametro'");
		$statement->execute();
		$resultado = $statement->fetch()[$campo];
		return 
		$resultado;
    }

    public static function update_bd($tabla,$datos,$condicion,$id){ 
        $conexion=ConexionBD::conexion();
        $array_keys = array_keys($datos);
    
        foreach($array_keys as $posicion=>$campo){
          $array_campos[$posicion]=$campo.'=?';
        }
        $campos = implode(", ", array_values($array_campos));
        $values = array_values($datos);
         
        $sql = "UPDATE {$tabla} SET {$campos} WHERE {$condicion}='$id'";
        $statement = $conexion->prepare($sql);
        $statement->execute($values); 
        $cuenta = $statement->rowCount();
    
        if ($cuenta>0){
            $respuesta=[0,"Los datos se insertaron correctamente"];
        }else{$respuesta=[1,"No se pudo comprobar la inserción de los datos"];
        }
    
        return $respuesta;
    } 

    public static function cambiarEstado($campo,$tabla,$condicion,$parametro,$estadoActual){
        $conexion=ConexionBD::conexion();
        $estadoBD=ConsultasBD::consulta_bd_simple($campo,$tabla,$condicion,$parametro);
		if ($estadoActual==$estadoBD) {

            if ($estadoBD==1) {
                $estadoNuevo=0;
            }else{
                $estadoNuevo=1;
            }
            $respuesta=ConsultasBD::update_bd($tabla,[$campo=>$estadoNuevo],$condicion,$parametro);
           

        }else{
            $respuesta=[1,"ocurrio un error, recarga la pagina e intenta de nuevo"];
        }

		return $respuesta;
    }

    public static function insert_bd($tabla, $datos){ 
        $conexion=ConexionBD::conexion();
        $campos = implode(", ", array_keys($datos));
        $values =array_values($datos);
        $total_ph = count($datos);
        $ph = str_repeat('?,', $total_ph);
        $ph = substr($ph, 0, -1); // remueve la ultima; 
        $sql = "INSERT INTO $tabla({$campos}) VALUES({$ph})";
      
        $statement = $conexion->prepare($sql);
        $statement->execute($values); 
        $cuenta = $statement->rowCount();
        if ($cuenta>0){
          $respuesta=[0,"Los datos se insertaron correctamente"];
         
        }else{$respuesta=[1,"No se pudo comprobar la inserción de los datos"];}
        return $respuesta;
      } 

      public static function contarElementosTabla($query){
        $conexion=ConexionBD::conexion();
        $respuesta=[];
        $statement = $conexion->prepare($query);
        $statement->execute()->fetchAll();
                $respuesta=count($statement);
        return $respuesta;
      }

}


class Producto{
    
    public static function getTodosLosProductos(){
        $respuesta=[];
        $secciones=self::getSecciones();
        foreach ($secciones as $key => $value) {
            if ($value['nombre']!='ninguno') {
                $respuesta[$value['nombre']]=[];
            }
        }
        $datos=['idproducto','nombreproducto','pvpproducto','descripcionproducto','imgproducto','idseccion','nombreseccion','posseccion'];
        $query="SELECT p.id as idproducto, p.nombre as nombreproducto, p.pvp as pvpproducto, p.descripcion as descripcionproducto, p.img as imgproducto, s.id as idseccion, s.nombre as nombreseccion, s.posicion as posseccion FROM productos p JOIN secciones s ON p.seccion=s.id WHERE p.activo=1 ORDER BY p.nombre ASC";
        $DatosProductos=consultasBD::consultaBD($query,$datos);
        foreach ($DatosProductos as $key => $value) {
            if ($value['nombreseccion']!='ninguno') {
                array_push($respuesta[$value['nombreseccion']],$value);
            }
          
        }
        return $respuesta;
    }

    public static function getTodosLosProductosBuscador($text){
        $respuesta=[];
        $resultado=[];
        $secciones=self::getSecciones();
        $datos=['idproducto','nombreproducto','pvpproducto','descripcionproducto','imgproducto','idseccion','nombreseccion','posseccion'];
        $query="SELECT p.id as idproducto, p.nombre as nombreproducto, p.pvp as pvpproducto, p.descripcion as descripcionproducto, p.img as imgproducto, s.id as idseccion, s.nombre as nombreseccion, s.posicion as posseccion FROM productos p JOIN secciones s ON p.seccion=s.id WHERE p.activo=1 AND p.nombre LIKE '%{$text}%' ORDER BY p.nombre ASC";
        $DatosProductos=consultasBD::consultaBD($query,$datos);
        if (count($DatosProductos)>0) {
            foreach ($secciones as $key => $value) {
                if ($value['nombre']!='ninguno') {
                    $resultado[$value['nombre']]=[];
                }
            }
            foreach ($DatosProductos as $key => $value) {
                if ($value['nombreseccion']!='ninguno') {
                    array_push($resultado[$value['nombreseccion']],$value);
                }
              
            }
            array_push($respuesta,$resultado);
           
        }else {
            $respuesta=[0];
        }
        
        
        return $respuesta;
    }
    public static function getSecciones(){
        $query="SELECT id, nombre from secciones ORDER BY posicion ASC";
        $datos=['id','nombre'];
        $respuesta=consultasBD::consultaBD($query,$datos);
        return $respuesta;
    }

    public static function getProducto($idProducto){
        $respuesta=[];
        array_push($respuesta,self::getInfoProducto($idProducto));
        array_push($respuesta,self::getOpcionesProducto($idProducto));
        return $respuesta;
    }
    public static function getInfoProducto($idProducto){
        $query="SELECT id,nombre,pvp,descripcion,img  FROM productos WHERE id=$idProducto";
        $datos=['id','nombre','pvp','descripcion','img'];
        $respuesta=consultasBD::consultaBD($query,$datos);
        return $respuesta;
    }
    public static function getIngredientesProducto($idProducto){
        $query="SELECT p.id as idIngrediente, p.nombre as nombreIngrediente FROM produccion p JOIN join_receta_productos pp ON p.id=pp.produccion JOIN productos pt ON pt.id=pp.producto  WHERE pp.producto=$idProducto";
        $datos=['idIngrediente','nombreIngrediente'];
        $respuesta=consultasBD::consultaBD($query,$datos);
        return $respuesta;
    }

    public static function getOpcionesProducto($idProducto){
        $respuesta=[];
        $gruposModificadores=self::getGruposModificadoresProducto($idProducto);
        foreach ($gruposModificadores as $key => $value) {
            $value['items_modificadores']=self::getItemsModificadoresProducto($value['grupo_modificador']);
            array_push($respuesta,$value);
        }
        return $respuesta;
    }
    public static function getGruposModificadoresProducto($idProducto){
        $query="SELECT g.id as id_grupo, j.grupo_modificador, g.nombre, g.obligatorio, g.puede_seleccionar FROM join_grupo_modificador_productos j JOIN grupo_modificador g ON j.grupo_modificador=g.id WHERE producto=$idProducto AND activo=1 ORDER BY g.posicion ASC";
        $datos=['id_grupo','grupo_modificador','nombre','obligatorio','puede_seleccionar'];
        $respuesta=consultasBD::consultaBD($query,$datos);
        return $respuesta;
    }
    public static function getItemsModificadoresProducto($idGrupoModificador){
        $query="SELECT nombre, precio,id FROM item_modificador WHERE grupo_modificador=$idGrupoModificador AND activo=1 ORDER BY posicion ASC";
        $datos=['nombre','precio','id'];
        $respuesta=consultasBD::consultaBD($query,$datos);
        return $respuesta;
    }
    public static function getInfoItemModificador($idItem){
        $query="SELECT id, nombre, precio FROM item_modificador WHERE id=$idItem";
        $datos=['id','nombre','precio'];
        $respuesta=consultasBD::consultaBD($query,$datos);
        return $respuesta;
    }
    public static function getsubtotalProducto($cantidad,$pvp,$opciones){
        $subtotal=  intval($cantidad)*floatval($pvp);
        
        foreach ($opciones as $key => $value) {
            $subtotal=floatval($subtotal)+floatval($value[0]['precio']);
        }
        
        return $subtotal;
        
    }


}

class Carrito{
    public $carrito;

    function __construct(){
        if (!$_SESSION['carrito']) {
            $_SESSION['carrito']=[];
        }
    }

    public static function consultarCarrito(){
        return $_SESSION['carrito'];
    }

    public static function agregarAlCarrito($arrayDatos){
        $idProducto=DataCleanner::string_cleanner($arrayDatos[0]);
        $cantidad=DataCleanner::number_cleanner($arrayDatos[1]);
        $comentario=DataCleanner::string_cleanner($arrayDatos[2]);
        $arrayOpciones=$arrayDatos[3];
        $opciones=[];
        foreach ($arrayOpciones as $key => $value) {
            array_push($opciones,Producto::getInfoItemModificador($value));
        }

        $infoProducto=Producto::getInfoProducto($idProducto);
        $subtotal= Producto::getsubtotalProducto($cantidad,$infoProducto[0]['pvp'],$opciones);
        $arrayDatosProducto=[$idProducto,$cantidad,$infoProducto[0]['nombre'],$subtotal,$opciones,$comentario];
        array_push($_SESSION['carrito'],$arrayDatosProducto);
        return $_SESSION['carrito'];

        
    }
   
    public static function getTotalCarrito($carrito){
        $totalCarrito=0;
        foreach ($carrito as $key => $value) {
           $totalCarrito=$totalCarrito+$value[3];
        }
        
        return $totalCarrito;
        
    }

    public static function sacarProductoCarrito($posicion){
        unset($_SESSION['carrito'][$posicion]);
        $nuevoArray=array_values($_SESSION['carrito']);
        $_SESSION['carrito']=$nuevoArray;
        return $_SESSION['carrito'];
        
    }

    public static function comprobarFormCarrito($array_datos){
        $respuesta=[];
            $verificacion=[];
            $errores=0;
            $nombre=DataCleanner::string_cleanner($array_datos[0]);
            $direccion=DataCleanner::number_cleanner($array_datos[1]);
            $telefono=DataCleanner::string_cleanner($array_datos[2]);
            $correo=DataCleanner::email_cleanner($array_datos[3]);
            $comentarioAdicional=DataCleanner::string_cleanner($array_datos[4]);
            $tipoDeEntrega=DataCleanner::string_cleanner($array_datos[5]);
            $formaDePago=DataCleanner::string_cleanner($array_datos[6]);
            
            array_push($verificacion,ComprobacionesDatos::comprobar_correo($correo));
            array_push($verificacion,ComprobacionesDatos::comprobar_vacio([$nombre,$telefono]));
            array_push($verificacion,self::comprobar_carrito_vacio($_SESSION['carrito']));
            
            foreach ($verificacion as $key => $value) {
                if ($value[0]==1) {
                    $respuesta=$value;
                    $errores++;
                break;
                }
            }
    
            if ($errores==0) {
                $respuesta=[self::insertarCarrito($nombre,$correo,$telefono,$_SESSION['carrito']),$_SESSION['carrito']];
                $_SESSION['carrito']=[];
            }
            return $respuesta;
        
    }
    public static function insertarCarrito($nombre,$correo,$telefono,$carrito){
        $respuesta=[];
        $carritoSerializado=serialize($carrito);
        $array_assoc=[
            'nombre'=>$nombre,
            'correo'=>$correo,
            'telefono'=>$telefono,
            'carrito'=>$carritoSerializado
        ];

        $respuesta=consultasBD::insert_bd("ventas_ws",$array_assoc);
        
        return $respuesta;
        
    }

    public static function comprobar_carrito_vacio($carrito){
        if ($carrito==[]) {
           $respuesta=[1,'El Carrito está vacio'];
        }else{
            $respuesta=[0,'El carrito tiene al menos 1 producto'];
        }
        return $respuesta;
    }


}

class DataCleanner{
    public static function string_cleanner($cadena){
        $cadena=trim($cadena);
        $cadena=filter_var($cadena,FILTER_SANITIZE_STRING);
        $cadena=stripcslashes($cadena);
        $cadena=htmlspecialchars($cadena);
        $cadena=strtolower($cadena);	
        return $cadena;
    }

    public static function number_cleanner($numero){
            $numero=filter_var($numero,FILTER_SANITIZE_NUMBER_INT);
            $numero=(int)$numero;
            $numero =trim($numero);
            $numero = str_replace(' ', '', $numero);
            return $numero;
    
    }

    public static function email_cleanner($mail){
        if ($mail!="") {
            $mail=trim($mail);
            $mail = str_replace(' ', '', $mail);
            $mail=filter_var($mail,FILTER_SANITIZE_EMAIL);
            $mail=filter_var($mail,FILTER_VALIDATE_EMAIL);
        }else{$mail='';}
    
    
        return $mail;
    }


    

 }

 class ComprobacionesDatos{

    public static function comprobar_correo($mail){
        $mail=DataCleanner::email_cleanner($mail);
        if ($mail=='') {
            $respuesta=[1,'Por favor escribe un correo válido'];
        }else{
            $respuesta=[0,' formato correo correcto'];
        }
        return $respuesta;
    }

    public static function comprobar_select($select,$msjError){
        
        if ($select==1) {
            $respuesta=[1,$msjError];
        }else{
            $respuesta=[0,' seleccion correcta'];
        }
        return $respuesta;
    }
  
    public static function comprobar_vacio($array){
        $vacio=0;
        foreach ($array as $key => $value) {
            if (empty($value)) {
                $vacio++;
            }
        }
        
        if($vacio>0){
            $resultado=[1,"Hay al menos 1 campo vacio"];
        }else{$resultado=[0,"No hay campos vacios"];}

        return $resultado;
    }

    public static function comprobar_repetidos($dato,$tabla,$campo,$condicion,$parametro,$msjError){
        $repetido=0;
        global $conexion;
        $statement = $conexion->prepare("SELECT {$campo} FROM {$tabla} WHERE {$condicion}='$parametro'");
        $statement->execute();
        $resultado=$statement->fetchAll();
            foreach ($resultado as $key => $value) {
                if ($value[0]==$dato) {$repetido++;}
            }
    
            if ($repetido>0) {$respuesta=[1,$msjError];
            }else{$respuesta=[0,"No hay registros repetidos en la base de datos"];}
    
    
            return $respuesta;
    
        }

        

 }


?>