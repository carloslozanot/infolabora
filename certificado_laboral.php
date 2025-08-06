<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Debe iniciar sesión");
            window.location = "index.php";
        </script>
    ';
    exit;
}

$cedula = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Laboral</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="docs/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">
    <header class="index">
        <div class="icon_menu">
            <i class="bi bi-code" id="btn_open"></i>
        </div>
    </header>

    <div class="menu_side" id="menu_side">
        <div class="name_page">
            <i class="bi bi-building"></i>
            <h4>Talento Humano</h4>
        </div>
        <div class="options_menu">
            <a href="#">
                <div class="option" data-pagina="inicio"><i class="bi bi-house-door"></i>
                    <h4>Inicio</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="integrantes"><i class="bi bi-people-fill"></i>
                    <h4>Integrantes</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="th-vacaciones"><i class="bi bi-umbrella"></i>
                    <h4>Vacaciones</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="bitacora"><i class="bi bi-journal-text"></i>
                    <h4>Bitácora</h4>
                </div>
            </a>
            <a href="#">
                <div class="option" data-pagina="cerrar-sesion"><i class="bi bi-box-arrow-right"></i>
                    <h4>Cerrar Sesión</h4>
                </div>
            </a>
        </div>
    </div>
    <main>
        <div id="contenido-certificados-lab">
            <div class="card shadow-lg p-4 seccion-certificados text-center">
                <h2 style="font-size: 35px; font-weight: 700;">CERTIFICADO LABORAL</h2>


                <form method="post" action="fpdf/certificado.php" class="mt-4" target="_blank">
                    <div class="form-group">
                        <label style="font-weight: 600;">Título personal:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="titulo" id="senor" value="Señor" required
                                onchange="toggleDestinatario()">
                            <label class="form-check-label" for="senor">Señor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="titulo" id="senora" value="Señora"
                                onchange="toggleDestinatario()">
                            <label class="form-check-label" for="senora">Señora</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="titulo" id="senores" value="Señores"
                                onchange="toggleDestinatario()">
                            <label class="form-check-label" for="senores">Señores</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="titulo" id="blanco" value="En blanco"
                                onchange="toggleDestinatario()">
                            <label class="form-check-label" for="blanco">En blanco</label>
                        </div>

                        <br><br>
                        <label style="font-weight: 600;">¿Desea presentar su salario?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="salario_sn" id="salario_si" value="SI"
                                required onchange="toggleDestinatario()">
                            <label class="form-check-label" for="salario_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="salario_sn" id="salario_no" value="NO"
                                onchange="toggleDestinatario()">
                            <label class="form-check-label" for="salario_no">No</label>
                        </div>

                        <br><br>
                        <label style="font-weight: 600;">Dirigido a:</label>
                        <input type="text" id="destinatario" name="destinatario" class="form-control mx-auto"
                            style="width: 350px;" placeholder="Escriba a quién va dirigido" required>

                        <input type="hidden" name="id" value="<?php echo $cedula; ?>">

                        <br>
                        <button type="submit" class="btn boton-certificados">
                            <i class="fa-solid fa-file"></i> GENERAR CERTIFICADO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function toggleDestinatario() {
            const radios = document.getElementsByName('titulo');
            const destinatario = document.getElementById('destinatario');

            let seleccionado = '';
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    seleccionado = radios[i].value;
                    break;
                }
            }

            if (seleccionado === 'En blanco') {
                destinatario.value = '';
                destinatario.disabled = true;
                destinatario.removeAttribute('required');
            } else {
                destinatario.disabled = false;
                destinatario.setAttribute('required', 'required');
            }
        }
    </script>
</body>

</html>