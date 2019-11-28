<?php
    session_start();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="main.scss">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(function(){
            $boton = $("button_log");
            $spin = $(".fa-spinner");
            $boton.on("click", function(evento){
                evento.preventDefault();

                $boton.prop("disabled", true);
                $spin.fadeIn();
                
                var usuario = $('[name="usuario"]').val();
                var contrasena = $('[name="password"]').val();
                
                $.ajax({
                    url: "resultado.php",
                    method: "POST",
                    dataType: "json",
                    data:{
                        usuario: usuario,
                        password: contrasena
                    }
                })
                .done(function(informacion) {
                    var json = informacion;

                    console.log(json);
                    $boton.prop("disabled", false);
                    $spin.fadeOut();
                    if(json.codigo == "0"){
                        $("#masaje").html(json.mensaje);
                    }
                    else if(json.codigo == "1"){
                        window.location.href = "vip.php";
                    }
                });
            });  
        });
    </script>
    <style>
    .carousel-inner{
        height: 400px;
        width: 100%;
    }
    body{
        background-color: rgb(44, 44, 44);
    }
    .fa-spinner{
            display: none;
    }
    </style>
    <title>Graduación 2021</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Graduación 2021</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Información <span class="sr-only">(current)</span></a>
            </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
            <button type="button_log" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">
                Ingresar
            </button>
            </form>
        </div>
    </nav>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="img/graduacion.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="img/graduacion1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="img/graduacion2.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="container">
        <div class="row">
            <div class="jumbotron bg-dark col-lg-8">
                <h1 class="display-4">¡Bienvenido egresado!</h1>
                <p class="lead">Bienvenidos a la página de graduación de los alumnos de Ingeniería en software, ¡Generación 2018-2021!</p>
                <hr class="my-4">
                <p>Si ya tienes una cuenta de usuario entra a ella para realizar tus reservaciones!</p>
                <!-- Trigger modal -->
                <button type="button_log" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                Ingresar
                </button>
            </div>
            <div class="jumbotron bg-primary col-lg-4">
                <div class="container">
                    <section class="row">
                        <form action="registroProceso.php" method="POST">
                                <h2>¿No estás registrado?¡Registrate!</h2>
                                <br>
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <input type="text" class="form-control" name="usuario">
                                </div>
                                <div class="form-group">
                                    <label for="">Contraseña</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <button class="btn btn-outline-dark">Registrarse</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <section class="container">
                <section class="row">
                    <div class="col-md-6">
                        <form action="resultado.php" method="POST">
                            <div class="form-group">
                                <label for="">Usuario</label>
                                <input type="text" class="form-control" name="usuario">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button class="btn btn-primary">Enviar datos</button>

                            <i class="fas fa-spinner fa-pulse"></i>
                            <div id="masaje">
                            </div>
                        </form>
                    </div>
                </section>
            </section>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
</body>
</html>