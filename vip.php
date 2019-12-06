<!DOCTYPE html>
<html>
<head>
    <?php
        session_start();
    
        $sesion = $_SESSION["usuario"];
        
        if(!isset($sesion)){
            header("Location: index.php");
        }
    ?>
    <meta charset="UTF-8">
    <title>VIP</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="files/jquery.min.js"></script>
    <script src="files/bootstrap.min.js"></script>
    <script>
    $(function(){
        $paquetes = $("#paquete1, #paquete2, #paquete3");
        $paquetes.on("change", function(){
            var numero = $(this).val();
            var $precioCaja = $(this).next("h4");
            var precio = "$" + ($precioCaja.attr("data-precio")*numero);
            $precioCaja.text(precio);
        });

        $("#modalConfirmar").modal({
            show:false
        });

        $("#btnConfirmar").on("click",function(){
            var total = 0;
            $("#modalConfirmar").modal("show");
            $paquetes.each(function(){
                var numero = $(this).val();
                var $precioCaja = $(this).next("h4");
                var precio = ($precioCaja.attr("data-precio")*numero);
                
                total += parseInt(precio);
                });
                $("#precioFinal").text("El total es: $"+total);
            });
        $("#btnAceptar").on("click", function(){
            $(this).prop("disabled",true);
            var lugaresPaquete1 = $("#paquete1").val();
            var lugaresPaquete2 = $("#paquete2").val();
            var lugaresPaquete3 = $("#paquete3").val();
            
            $.ajax({
                url: "comprar.php",
                method: "POST",
                data: {
                    paquete1: lugaresPaquete1,
                    paquete2: lugaresPaquete2,
                    paquete3: lugaresPaquete3
                }
            })
            .done(function(){
                $(this).prop("disabled",false);
                $("#modalConfirmar").modal("hide");
            });
        });
        $.ajax({
            url: "indicadores.php",
            method: "GET",
            dataType: "json"
        })
        .done(function(indicadores) {
            console.log(indicadores);
            $("#indicador1 p").text(indicadores[0].lugares);
            $("#indicador2 p").text(indicadores[1].lugares);
            $("#indicador3 p").text(indicadores[2].lugares);
        });
    });
    </script>
    <style>
        .modal{
            color: black;
        }
        body{
            background-color: rgb(44, 44, 44);
            color: white;
        }
        img{
            width: 25%;
        }
        aside.indicadores{
            text-align: center;
            position: fixed;
            top: 140px;
            left: 10px;
        }
        aside.indicadores img{
            width: 30px;
        }
    </style>
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
                <a class="nav-link" href="index.php">Información <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="reservaciones.php">Reservar asientos <span class="sr-only">(current)</span></a>
            </li>
            </ul>
        </div>
    </nav>
    <section class="container">
        <section class="row">
            <div class="col-md-12">
                <h3>Selecciona los paquetes</h3>
            </div>
            <div class="jumbotron bg-dark col-md-4">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-10">
                            <h4>Basico</h4>
                            <p>Este es el paquete basico</p>
                            <p>Cuenta con platillo sencillo y una bebida (sin alcohol).</p>
                            <img src="img/Platillo1.png" alt="platillo1">
                            <input type="number" id="paquete1" value="0" min="0" max="10">
                            <h4 data-precio="100">$0</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jumbotron bg-dark col-md-4">
            <div class="container">
                    <div class="row">
                        <div class="col-sm-10">
                            <h4>Medio</h4>
                            <p>Este es el paquete medio</p>
                            <p>Cuenta con platillo preparado y bebida (con o sin alcohol).</p>
                            <img src="img/Platillo2.png" alt="platillo2">
                            <input type="number" id="paquete2" value="0" min="0" max="10">
                            <h4 data-precio="500">$0</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jumbotron bg-dark col-md-4">
            <div class="container">
                    <div class="row">
                        <div class="col-sm-10">
                            <h4>Premium</h4>
                            <p>Este es el paquete premium</p>
                            <p>Cuenta con platillo preparado, bebida (con o sin alcohol) <br>y postre.</p>
                            <img src="img/Platillo3.png" alt="platillo3">
                            <input type="number" id="paquete3" value="0" min="0" max="10">
                            <h4 data-precio="1000">$0</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmar" id="btnConfirmar">
                Confirmar
            </button>
            </div>
        </section>
    </section>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar</h5>
                    <button type="button" class= "close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="confirmarReservacion.php" method="POST">
                    <div class="modal-body">
                        <p>¿Desea confirmar su seleccion?</p>
                        <p id="precioFinal"></p>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnAceptar">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <aside class="indicadores">
        <div id="indicador1">
            <img src="img/Platillo1.png" alt="paquete1">
            <p class="badge badge-danger">0</p>
        </div>
        <div id="indicador2">
            <img src="img/Platillo2.png" alt="paquete2">
            <p class="badge badge-danger">0</p>
        </div>
        <div id="indicador3">
            <img src="img/Platillo3.png" alt="paquete3">
            <p class="badge badge-danger">0</p>
        </div>
    </aside>
</body>
</html>