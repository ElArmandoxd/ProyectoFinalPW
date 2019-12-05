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

/*         $_SESSION['Usuario']=$fila['id_usuario'];
        $_SESSION['Paquete']=$fila['paquete'];
        $_SESSION['Lugares']=$fila['lugares']; */
        $upPaqueteId=$fila['id'];
        $lugares=$fila['lugares'] - 1;
    }
    else {
        echo "No hay resultados";
    }
    


    $statementr="INSERT INTO reservaciones (id_silla,id_usuario,paquete) VALUES ('$idSilla','$idUsuario','$idPaquete');";
    $statementr .= "UPDATE usuarios_paquetes SET lugares=$lugares WHERE id=$upPaqueteId";
    $resultado= $conexionDB->multi_query($statementr);
    if($resultado){
        echo "Funciona!";
    }
    else{
        echo "Nel :c";
    }
?>