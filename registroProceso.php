<?php
    include("conexion.php");

    $usuario = $_POST["usuario"];
    $contrasena = hash("whirlpool", $_POST["password"]);
    $email = $_POST["email"];

    $statement = "INSERT INTO usuarios(nombre, contrasena, email) Values
                  ('$usuario', '$contrasena', '$email')";

    $resultado = $conexionDB->query($statement);

    if($resultado){
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
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
        ¡Algo ha salido mal! intentalo de nuevo.
      </div>';
    }
?>