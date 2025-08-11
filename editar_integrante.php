<?php
session_start();

include("php/conexion.php");

$permiso = $_SESSION['permiso'] ?? null;

if ($permiso == '1') {
    $destino = 'index_admin.php';
} else {
    $destino = 'index_th.php';
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Integrante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>


<div id="contenido-carga">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">

            <div class="col-md-5 mb-4">
                <div class="card card-hover shadow-lg border-0 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <i class="fa-solid fa-file-circle-check fa-3x mb-3"></i>
                        <h5 class="card-title mb-1">Ingresos al sistema</h5>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="certificado_laboral.php" class="text-decoration-none">
                    <div class="card text-center shadow h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-file-circle-check fa-3x mb-3"></i>
                            <h6 class="card-title">Certificado Laboral</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="desprendible_pago.php" class="text-decoration-none">
                    <div class="card text-center shadow h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-file-invoice-dollar fa-3x mb-3"></i>
                            <h6 class="card-title">Desprendible de Pago</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="certificado_ingresos.php" class="text-decoration-none">
                    <div class="card text-center shadow h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-file-invoice fa-3x mb-3"></i>
                            <h6 class="card-title">Certificado de Ingresos</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="vacaciones.php" class="text-decoration-none">
                    <div class="card text-center shadow h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-umbrella-beach fa-3x mb-3"></i>
                            <h6 class="card-title">Vacaciones</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="beneficios.php" class="text-decoration-none">
                    <div class="card text-center shadow h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-gift fa-3x mb-3"></i>
                            <h6 class="card-title">Beneficios</h6>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>


</html>