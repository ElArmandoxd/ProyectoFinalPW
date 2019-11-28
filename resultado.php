<?php
    include("conexion.php");
    $usuario = $_POST["usuario"];
    $password = hash("whirlpool",$_POST["password"]);

    $statement = "SELECT id, nombre
                  FROM usuarios
                  WHERE contrasena = '$password'
                  AND nombre = '$usuario'";

    $resultado = $conexionDB->query($statement);
    
    if($resultado->num_rows > 0){
        session_start();
        $_SESSION["datosUsuario"] = mysqli_fetch_assoc($resultado);
        $_SESSION["usuario"] = $usuario;
        $datos = [
            "mensaje" => "<p class = \"text-sucess\"> Bienvenid@ ", $usuario, "</p>",
            "codigo" => "1"
        ];
        header("Location: vip.php");
    }
    else{
        $datos = [
            "mensaje" => "<p class = \"text-danger\"> Usuario o contraseña incorrectos! </p>",
            "codigo" => "0"
        ];
        echo '<script>
        alert("Hubo un problema al iniciar sesión");
       </script>';
    }
?>