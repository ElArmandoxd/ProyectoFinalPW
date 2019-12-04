<?php
    session_start();
    include("conexion.php");
    
    $sesion = $_SESSION["usuario"];

    if(!isset($sesion)){
        header("Location: index.php");
    }
    $usuario = $_SESSION["id"];
    $basico = mysql_query("SELECT (SELECT SUM(lugares)) FROM usuarios_paquetes where id_usuario = $usuario and paquete = 1;");

    $row = mysql_fetch_row($basico);
?>