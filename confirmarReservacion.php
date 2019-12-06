<?php
    session_start();
    include("conexion.php");
    $idUsuario=$_SESSION["datosUsuario"]["id"];
    $idSilla=$_POST["silla"];
    $idPaquete=$_POST["paquete"];
    $sql = "SELECT * FROM usuarios_paquetes WHERE id_usuario=$idUsuario AND paquete=$idPaquete";
    $paquete=$conexionDB->query($sql);
    if(mysqli_num_rows($paquete)>0){
        $fila = $paquete->fetch_array(MYSQLI_ASSOC);
        $upPaqueteId=$fila['id'];
        $lugares=$fila['lugares'];
        if($lugares > 0)
        {
            $lugares=$fila['lugares'] - 1;
            $statementr="INSERT INTO reservaciones (id_silla,id_usuario,paquete) VALUES ('$idSilla','$idUsuario','$idPaquete');";
            $statementr .= "UPDATE usuarios_paquetes SET lugares=$lugares WHERE id=$upPaqueteId";
            $resultado= $conexionDB->multi_query($statementr);
        }
    }
?>