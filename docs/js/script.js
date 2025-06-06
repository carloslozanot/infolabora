const body = document.getElementById('body');
const menuSide = document.getElementById('menu_side');
const menuButton = document.getElementById('btn_open');
const menuButtons = document.querySelectorAll('.option');

// Función para mostrar el contenido correspondiente
function mostrarContenido(pagina) {
    // Oculta todos los contenidos
    document.querySelectorAll('.contenido').forEach(contenido => {
        contenido.style.display = 'none';
    });

    // Muestra el contenido solicitado
    const elemento = document.getElementById(`contenido-${pagina}`);
    if (elemento) {
        elemento.style.display = 'block';
    }
}

// Evento para cada opción del menú
menuButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Evita el salto del enlace

        const pagina = button.getAttribute('data-pagina');
        mostrarContenido(pagina);

        // Actualiza la clase 'selected' para marcar la opción activa
        menuButtons.forEach(btn => btn.classList.remove('selected'));
        button.classList.add('selected');
    });
});

// Función para abrir/cerrar menú lateral
menuButton.addEventListener('click', open_close_menu);
function open_close_menu() {
    body.classList.toggle('body_move');
    menuSide.classList.toggle('menu_side_move');
}

// Código de login/register y responsive...

var formulario_login = document.querySelector(".formulario_login");
var formulario_register = document.querySelector(".formulario_register");
var contenedor_login_register = document.querySelector(".contenedor_login-register");
var caja_trasera_login = document.querySelector(".caja_trasera-login");
var caja_trasera_register = document.querySelector(".caja_trasera-register");

function anchoPage() {
    if (window.innerWidth > 850) {
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
    }
}

function iniciarSesion() {
    if (window.innerWidth > 850) {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "10px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}

function register() {
    if (window.innerWidth > 850) {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "410px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}

document.getElementById("btn_iniciar-sesion").addEventListener("click", function () {
    iniciarSesion();
    mostrarContenido('inicio');
});
document.getElementById("btn_registrarse").addEventListener("click", function () {
    register();
    mostrarContenido('inicio');
});
window.addEventListener("resize", anchoPage);

// Inicializar estado responsive del menú
if (window.innerWidth < 760) {
    body.classList.add("body_move");
    menuSide.classList.add("menu_side_move");
}

window.addEventListener("resize", function () {
    if (window.innerWidth > 760) {
        body.classList.remove("body_move");
        menuSide.classList.remove("menu_side_move");
    } else {
        body.classList.add("body_move");
        menuSide.classList.add("menu_side_move");
    }
});

// Función para agregar un nuevo usuario a la tabla
document.getElementById('btnAgregarUsuario').addEventListener('click', function () {
    const tablaUsuarios = document.getElementById('tablaUsuarios');
    const newRow = tablaUsuarios.insertRow();

    const cellId = newRow.insertCell(0);
    const cellNombre = newRow.insertCell(1);
    const cellCorreo = newRow.insertCell(2);
    const cellAcciones = newRow.insertCell(3);

    cellId.innerText = '1'; // Ejemplo, cambiar por datos reales
    cellNombre.innerText = 'Nombre de Usuario';
    cellCorreo.innerText = 'correo@example.com';

    cellAcciones.innerHTML = '<button onclick="editarUsuario(this)">Editar</button> <button onclick="eliminarUsuario(this)">Eliminar</button>';
});

// Funciones editar/eliminar usuario (pendientes de implementar)
function editarUsuario(button) {
    // Aquí el código para editar usuario
}
function eliminarUsuario(button) {
    // Aquí el código para eliminar usuario
}

// Código para manejar el envío de formulario con AJAX (jQuery)
$(document).ready(function() {
    $('#formulario').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: 'subir_documento.php',
            type: 'POST',
            data: formData,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#mensaje').html(response);
            }
        });
    });
});
