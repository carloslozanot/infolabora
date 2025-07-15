console.log("Script.js cargado correctamente");

const body = document.getElementById('body');
const menuSide = document.getElementById('menu_side');
const menuButton = document.getElementById('btn_open');
const contenidoInicio = document.getElementById('contenido-inicio');
const contenidoDatos = document.getElementById('contenido-datos');
const contenidoUsuarios = document.getElementById('contenido-usuarios');
const contenidoIntegrantes = document.getElementById('contenido-integrantes');
const contenidoPermisos = document.getElementById('contenido-permisos');
const contenidoDescargas = document.getElementById('contenido-descargas');
const contenidoVacaciones = document.getElementById('contenido-vacaciones');
const contenidoCerrarSesion = document.getElementById('contenido-cerrar-sesion');
const menuButtons = document.querySelectorAll('.option');

function mostrarContenido(pagina) {
    // Oculta todos los contenidos
    document.querySelectorAll('.contenido').forEach(contenido => {
        contenido.style.display = 'none';
    });

    // Muestra el contenido correspondiente a la página
    document.getElementById(`contenido-${pagina}`).style.display = 'block';
}

menuButtons.forEach(button => {
    button.addEventListener('click', function () {
        const pagina = button.getAttribute('data-pagina');
        mostrarContenido(pagina);

        // Quita la clase 'selected' de todos los elementos
        menuButtons.forEach(btn => {
            btn.classList.remove('selected');
        });

        // Agrega la clase 'selected' al elemento clickeado
        button.classList.add('selected');
    });
});

menuButton.addEventListener('click', open_close_menu);

function open_close_menu() {
    body.classList.toggle('body_move');
    menuSide.classList.toggle('menu_side_move');
}

// Resto del código de formulario y eventos adicionales...


// Declaramos variables adicionales
var formulario_login = document.querySelector(".formulario_login");
var formulario_register = document.querySelector(".formulario_register");
var contenedor_login_register = document.querySelector(".contenedor_login-register");
var caja_trasera_login = document.querySelector(".caja_trasera-login");
var caja_trasera_register = document.querySelector(".caja_trasera-register");

// FUNCIONES adicionales

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

// Eventos adicionales
document.getElementById("btn_iniciar-sesion").addEventListener("click", function () {
    iniciarSesion();
    mostrarContenido('inicio');
});
document.getElementById("btn_registrarse").addEventListener("click", function () {
    register();
    mostrarContenido('inicio');
});
window.addEventListener("resize", anchoPage);

// Si el ancho de la página es menor a 760px, ocultará el menú al recargar la página
if (window.innerWidth < 760) {
    body.classList.add("body_move");
    menuSide.classList.add("menu_side_move");
}

// Haciendo el menú responsive (adaptable)
window.addEventListener("resize", function () {
    if (window.innerWidth > 760) {
        body.classList.remove("body_move");
        menuSide.classList.remove("menu_side_move");
    }

    if (window.innerWidth < 760) {
        body.classList.add("body_move");
        menuSide.classList.add("menu_side_move");
    }
});

// Función para agregar un nuevo usuario a la tabla
document.getElementById('btnAgregarUsuario').addEventListener('click', function () {
    // Debes agregar el código para mostrar un formulario de ingreso de datos y manejar la lógica de agregar usuarios aquí.
    // Puedes utilizar AJAX para enviar datos al servidor y almacenarlos en una base de datos.

    // Ejemplo de cómo agregar una fila de usuario a la tabla:
    const tablaUsuarios = document.getElementById('tablaUsuarios');
    const newRow = tablaUsuarios.insertRow();

    // Añadir celdas con datos de ejemplo (personaliza según tus necesidades)
    const cellId = newRow.insertCell(0);
    const cellNombre = newRow.insertCell(1);
    const cellCorreo = newRow.insertCell(2);
    const cellAcciones = newRow.insertCell(3);

    cellId.innerText = '1'; // ID del usuario
    cellNombre.innerText = 'Nombre de Usuario'; // Nombre del usuario
    cellCorreo.innerText = 'correo@example.com'; // Correo electrónico del usuario

    // Agregar botones de edición y eliminación
    cellAcciones.innerHTML = '<button onclick="editarUsuario(this)">Editar</button> <button onclick="eliminarUsuario(this)">Eliminar</button>';
});

// Función para editar un usuario
function editarUsuario(button) {
    // Debes implementar la lógica para editar un usuario aquí.
    // Puedes mostrar un formulario de edición con los datos del usuario y permitir su modificación.
}

// Función para eliminar un usuario
function eliminarUsuario(button) {
    // Debes implementar la lógica para eliminar un usuario aquí.
    // Puedes eliminar la fila de la tabla y, si es necesario, enviar una solicitud al servidor para eliminar el usuario de la base de datos.
}

$(document).ready(function() {
    $('#formulario').submit(function(event) {
        event.preventDefault(); // Evita que el formulario se envíe por el método tradicional
        
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
