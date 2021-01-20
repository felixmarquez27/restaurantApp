<?php 

date_default_timezone_set('America/Argentina/Buenos_Aires');
const URL_BASE='http://localhost/sazonurbano/view/';
$ruta_raiz='http://localhost'.$_SERVER['SCRIPT_NAME'];
/*
const URL_BASE='https://www.sazonurbano.com/view/';
$ruta_raiz='https://www.sazonurbano.com'.$_SERVER['SCRIPT_NAME'];
$ruta_actual='https://sazonurbano.com'.$_SERVER['REQUEST_URI'];
*/
$openGraph=[
	'url'=>$ruta_actual,
	'type'=>'website',
	'title'=> 'Sazon Urbano',
	'description'=> 'La Mejor Hamburgueseria Artesanal esta en Coghlan',
	'image'=>'https://sazonurbano.com/assets/img/logo.PNG'
];

class ConexionBD{
	public static function conexion(){
		$ip='*****';
		$db='*****';
		$user='******';
		$pass='******';

		try {
			$conexion = new PDO ("mysql:host=$ip;dbname=$db;charset=utf8",$user,$pass);
				return $conexion;
		} catch (PDOException $e) {
				return false;
			
		}
	}
			

}

 ?>