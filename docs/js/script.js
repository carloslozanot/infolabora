console.log("Script.js cargado correctamente");

const body = document.getElementById('body');
const menuSide = document.getElementById('menu_side');
const menuButton = document.getElementById('btn_open');
const menuButtons = document.querySelectorAll('.option');

// Función para mostrar solo una sección
function mostrarContenido(pagina) {
    // Oculta todas las secciones con clase 'contenido'
    document.querySelectorAll('.contenido').forEach(seccion => {
        seccion.style.display = 'none';
    });

    // Muestra la que coincide con el id correspondiente
    const target = document.getElementById(`contenido-${pagina}`);
    if (target) {
        target.style.display = 'block';
    }
}

// Asignar eventos de clic al menú lateral
menuButtons.forEach(button => {
    button.addEventListener('click', function () {
        const pagina = button.getAttribute('data-pagina');
        mostrarContenido(pagina);

        // Quitar y agregar clase visual de selección
        menuButtons.forEach(btn => btn.classList.remove('selected'));
        button.classList.add('selected');
    });
});

// Toggle del menú
menuButton.addEventListener('click', open_close_menu);
function open_close_menu() {
    body.classList.toggle('body_move');
    menuSide.classList.toggle('menu_side_move');
}

// ========== Lógica de formulario login/register (si aplica) ==========
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

// Botones de login/register
document.getElementById("btn_iniciar-sesion")?.addEventListener("click", function () {
    iniciarSesion();
    mostrarContenido('inicio');
});
document.getElementById("btn_registrarse")?.addEventListener("click", function () {
    register();
    mostrarContenido('inicio');
});

window.addEventListener("resize", anchoPage);

// Menú responsive al cargar
if (window.innerWidth < 760) {
    body.classList.add("body_move");
    menuSide.classList.add("menu_side_move");
}

// Menú responsive al redimensionar
window.addEventListener("resize", function () {
    if (window.innerWidth > 760) {
        body.classList.remove("body_move");
        menuSide.classList.remove("menu_side_move");
    } else {
        body.classList.add("body_move");
        menuSide.classList.add("menu_side_move");
    }
});

// ===================== Lógica de usuarios (si aplica) =====================
document.getElementById('btnAgregarUsuario')?.addEventListener('click', function () {
    const tablaUsuarios = document.getElementById('tablaUsuarios');
    const newRow = tablaUsuarios.insertRow();

    const cellId = newRow.insertCell(0);
    const cellNombre = newRow.insertCell(1);
    const cellCorreo = newRow.insertCell(2);
    const cellAcciones = newRow.insertCell(3);

    cellId.innerText = '1';
    cellNombre.innerText = 'Nombre de Usuario';
    cellCorreo.innerText = 'correo@example.com';
    cellAcciones.innerHTML = '<button onclick="editarUsuario(this)">Editar</button> <button onclick="eliminarUsuario(this)">Eliminar</button>';
});

function editarUsuario(button) {
    // Lógica de edición de usuario
}

function eliminarUsuario(button) {
    const row = button.closest('tr');
    row.remove();
}

// ===================== Subida de archivo vía AJAX =====================
$(document).ready(function () {
    $('#formulario').submit(function (event) {
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
            success: function (response) {
                $('#mensaje').html(response);
            }
        });
    });
});
