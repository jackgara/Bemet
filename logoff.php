<?
/*-----------------
Inicio de sesiones.
-----------------*/
session_start();

/*-----------------
Archivos de clases.
-----------------*/
require "config.php";
require "repository/cls_seguridad_fo.php";

/*--------------------------
Conexión a la base de datos.
--------------------------*/
$obj_seguridad_fo = new cls_seguridad_fo($obj_void);

/*-------------------
Desloguea al usuario.
-------------------*/
$obj_seguridad_fo->logoff();

/*--------------------
Redirecciona al index.
--------------------*/
header("Location: ".$obj_seguridad_fo->str_retorno);
?>