<?php
session_start();
$idUsuario = $_SESSION["datosUsuario"]["id"];
include("conexion.php");
$mesas = "";
$plantillaMesa = file_get_contents("templates/mesa.html");
$plantillaSilla = file_get_contents("templates/silla.html");
$statementMesas = "SELECT id, numero
                   FROM mesas";
$resultadoMesas = $conexionDB->query($statementMesas);
foreach($resultadoMesas as $fila){
    $sillas = "";
    $idMesa = $fila["id"];
    $statementSillas = "SELECT S.id, S.posicion, R.paquete, U.nombre
                        FROM sillas S
                        LEFT JOIN reservaciones R ON R.id_silla = S.id
                        LEFT JOIN usuarios U ON U.id = R.id_usuario
                        WHERE id_mesa = $idMesa";
    $resultadoSillas = $conexionDB->query($statementSillas);
    foreach($resultadoSillas as $fila){
        $idSilla = $fila["id"];
        $nombre = $fila["nombre"];
        $posicion = $fila["posicion"];
        $reservada = $fila["paquete"] ? "silla-reservada" : "";
        $mensaje = $nombre ? "title=\"Esta silla ya la tiene $nombre!\"" : "";
        $sillas .=  sprintf($plantillaSilla, $posicion, $reservada, $mensaje, $idSilla);
    }
    $mesas .= sprintf($plantillaMesa, $idMesa, $sillas);
}
?>