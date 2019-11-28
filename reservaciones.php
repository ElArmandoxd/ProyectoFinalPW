<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservaciones</title>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/main.css">
    <style>
        body{
            background-color: rgb(44, 44, 44);
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
        .salon{
        margin: 100px;
        }
        .silla-reservada{
        color:red;
        }
        .contenedor-mesa{
            margin:5px;
            width:150px;
            height:150px;
            position:relative;
            display: inline-block;
        }
        .mesa{
            color: white;
            font-size:6em;
        }
        .silla{
            color: white;
            font-size:1.5em;
            position:absolute;
            cursor:pointer;
        }
        .silla-pos1{
            top:-25px;
            left:18px;
        }
        .silla-pos2{
            top:-25px;
            left:56px;
        }
        .silla-pos3{
            top:15px;
            left:94px;
        }
        .silla-pos4{
            top:56px;
            left:94px;
        }
        .silla-pos5{
            top:96px;
            left:56px;
        }
        .silla-pos6{
            top:96px;
            left:18px;
        }
        .silla-pos7{
            top:15px;
            left:-20px;
        }
        .silla-pos8{
            top:56px;
            left:-20px;
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
        </ul>
    </div>
</nav>
    <section class="salon">
        <?php
            session_start();
    
            $sesion = $_SESSION["usuario"];
            
            if(!isset($sesion)){
                header("Location: index.php");
            }
            include("procesarPlantillas.php");
            echo $mesas;
        ?>
    </section>
    <div class="modal" id="ventanaConfirmacion" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Confirmar reservacion</h5>
                </div>
                <div class="modal-body">
                    <p>¿Confirma su reservacion?</p>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" id="btnCancelar">No</button>
                  <button class="btn btn-primary" id="btnAceptar">Si</button>    
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
    <script>
        var idSilla=0;
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $("#ventanaConfirmacion").modal({show:false});

            $(".silla").on("click",function(){
                var reservada=$(this).hasClass("silla-reservada");
                if(!reservada){
                    idSilla=$(this).attr("data_id");
                    $("#ventanaConfirmacion").modal("show");
                }
                else{

                }
            });
            $("#btnCancelar").on("click",function(){
                $("#ventanaConfirmacion").modal("hide");
            });
            $("#btnAceptar").on("click",function(){
                $.ajax({
                    url:"confirmarReservacion.php",
                    method:"POST",
                    data:{
                        silla:idSilla
                    }
                    })
                    .done(function(){
                        $("#ventanaConfirmacion").modal("hide");
                });
            });
        });
    </script>
</body>
</html>