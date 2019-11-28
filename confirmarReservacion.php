<?php
    session_start();
    include("conexion.php");
    $idUsuario=$_SESSION["datosUsuario"]["id"];
    $idSilla=$_POST["silla"];

    $sql = "SELECT * FROM usuarios_paquetes";
    $paquete=$conexionBD->query($sql);
    if(mysqli_num_rows($paquete)>0){
        $fila = $paquete->fetch_array(MYSQLI_ASSOC);

        $_SESSION['Usuario']=$fila['id_usuario'];
        $_SESSION['Paquete']=$fila['paquete'];
        $_SESSION['Lugares']=$fila['lugares'];
    }
    else {
        echo "No hay resultados";
    }
    $paquete1=$_SESSION['Paquete'];


    $statementr="INSERT INTO reservaciones (id_silla,id_usuario,paquete) VALUES ('$idSilla','$idUsuario','$paquete1')";  
    
    $resultado= $conexionBD->query($statementr);
    if($resultado){
        header("Location: reservaciones.php");
    }
    else{
    }
?>