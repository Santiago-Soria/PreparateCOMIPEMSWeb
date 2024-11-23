// Variables globales
let datos; // Almacena las preguntas cargadas
let respuestasUsuario = {}; // Guarda las respuestas del usuario
let currentMateria = "RazonamientoVerbal"; // Materia inicial
let currentPregunta = 1; // Pregunta inicial
let tiempo = 3 * 60 * 60; // 3 horas en segundos

// Cargar datos al iniciar
document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch('preguntas.json'); // Ruta al archivo JSON
        datos = await response.json();

        // Escuchar eventos de los botones del menú lateral
        configurarMenuLateral();

        // Cargar la primera pregunta y configurar el cronómetro
        cargarPregunta(currentMateria, currentPregunta);
        iniciarCronometro();
    } catch (error) {
        console.error("Error al cargar preguntas:", error);
    }
});

// Configurar el menú lateral
function configurarMenuLateral() {
    document.querySelectorAll('.btn[data-materia]').forEach(button => {
        button.addEventListener('click', function () {
            const materia = this.dataset.materia;
            const pregunta = parseInt(this.dataset.pregunta);
            cargarPregunta(materia, pregunta);
        });
    });
}

// Función para cargar una pregunta
function cargarPregunta(materia, pregunta) {
    currentMateria = materia;
    currentPregunta = pregunta;

    const preguntas = datos[materia];
    const preguntaData = preguntas[currentPregunta - 1];

    // Mostrar la pregunta
    const preguntaContenedor = document.getElementById('pregunta-contenedor');
    preguntaContenedor.innerHTML = preguntaData.pregunta.replace(/\n/g, "<br>");

    // Mostrar imagen (si existe)
    if (preguntaData.imagen) {
        const img = document.createElement("img");
        img.src = preguntaData.imagen;
        img.alt = "Imagen de apoyo";
        img.classList.add("imagen-pregunta");
        preguntaContenedor.appendChild(img);
    }

    // Mostrar opciones de respuesta (con texto e imágenes si existen)
    const opcionesContenedor = document.getElementById('opciones-respuesta');
    opcionesContenedor.innerHTML = preguntaData.opciones
        .map((opcion, i) => {
            const texto = opcion.texto || "";
            const imagen = opcion.imagen
                ? `<img src="${opcion.imagen}" alt="${texto}" class="imagen-respuesta">`
                : "";
            return `
                <label class="opcion-respuesta">
                    <input type="radio" name="respuesta" value="${String.fromCharCode(65 + i)}">
                    ${texto} ${imagen}
                </label>`;
        })
        .join("");

    // Restaurar respuesta seleccionada
    const idPregunta = `${materia}-${pregunta}`;
    const seleccionada = respuestasUsuario[idPregunta];
    if (seleccionada) {
        document.querySelectorAll("input[name='respuesta']").forEach(opcion => {
            opcion.checked = opcion.value === seleccionada;
        });
    }

    // Actualizar el índice y navegación
    actualizarIndice(materia, pregunta);
    actualizarBotonesNavegacion();
}

// Guardar la respuesta seleccionada
document.getElementById("opciones-respuesta").addEventListener("change", function (e) {
    const seleccionada = e.target.value;
    if (seleccionada) {
        const idPregunta = `${currentMateria}-${currentPregunta}`;
        respuestasUsuario[idPregunta] = seleccionada;
        actualizarEstadoBotones();
    }
});

// Función para actualizar el índice dinámicamente
function actualizarIndice(materia, pregunta) {
    document.getElementById("indice").textContent = `Examen simulacro 1 > Materia: ${materia} > Pregunta: ${pregunta}`;
}

// Navegar entre preguntas con los botones "Anterior" y "Siguiente"
document.getElementById("btn-anterior").addEventListener("click", () => {
    if (currentPregunta > 1) {
        cargarPregunta(currentMateria, currentPregunta - 1);
    } else {
        const materias = Object.keys(datos);
        const materiaIndex = materias.indexOf(currentMateria);
        if (materiaIndex > 0) {
            const materiaAnterior = materias[materiaIndex - 1];
            currentMateria = materiaAnterior;
            currentPregunta = datos[materiaAnterior].length;
            cargarPregunta(currentMateria, currentPregunta);
        }
    }
});

document.getElementById("btn-siguiente").addEventListener("click", () => {
    if (currentPregunta < datos[currentMateria].length) {
        cargarPregunta(currentMateria, currentPregunta + 1);
    } else {
        const materias = Object.keys(datos);
        const materiaIndex = materias.indexOf(currentMateria);
        if (materiaIndex < materias.length - 1) {
            const siguienteMateria = materias[materiaIndex + 1];
            currentMateria = siguienteMateria;
            currentPregunta = 1;
            cargarPregunta(currentMateria, currentPregunta);
        } else {
            alert("¡Has terminado el examen!");
        }
    }
});

// Función para actualizar los botones del menú
function actualizarEstadoBotones() {
    document.querySelectorAll('.btn[data-materia]').forEach(button => {
        const materia = button.dataset.materia;
        const pregunta = button.dataset.pregunta;
        const idPregunta = `${materia}-${pregunta}`;

        if (respuestasUsuario[idPregunta]) {
            button.classList.add('btn-success'); // Contestado
            button.classList.remove('btn-primary');
        } else {
            button.classList.add('btn-primary'); // No contestado
            button.classList.remove('btn-success');
        }
    });
}

// Manejo del cronómetro
function iniciarCronometro() {
    const cronometro = document.getElementById("cronometro");
    const interval = setInterval(() => {
        if (tiempo <= 0) {
            clearInterval(interval);
            alert("El tiempo ha terminado.");
        } else {
            const horas = Math.floor(tiempo / 3600);
            const minutos = Math.floor((tiempo % 3600) / 60);
            const segundos = tiempo % 60;
            cronometro.textContent = `${horas.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}:${segundos.toString().padStart(2, "0")}`;
            tiempo--;
        }
    }, 1000);
}

// Mostrar/ocultar botones de navegación dinámicamente
function actualizarBotonesNavegacion() {
    document.getElementById('btn-anterior').style.display =
        currentPregunta > 1 || Object.keys(datos).indexOf(currentMateria) > 0 ? "block" : "none";
    document.getElementById('btn-siguiente').style.display =
        currentPregunta < datos[currentMateria].length || Object.keys(datos).indexOf(currentMateria) < Object.keys(datos).length - 1
            ? "block"
            : "none";
}
