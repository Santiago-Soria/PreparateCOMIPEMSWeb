let preguntas = {};
let materiaActual = "RazoVer";
let preguntaActual = 0;
let respuestasUsuario = {};
let tiempo = 3 * 60 * 60; // 3 horas en segundos

// Cargar preguntas desde un archivo JSON local
function cargarPreguntas(materia) {
    fetch("preguntas.json") // Ruta relativa al archivo JSON
        .then(response => response.json())
        .then(data => {
            preguntas = data; // Guardar todas las preguntas
            materiaActual = materia;
            preguntaActual = 0; // Iniciar con la primera pregunta de la materia
            mostrarPregunta();
            actualizarMenuLateral(data[materia]);
        })
        .catch(error => console.error("Error al cargar preguntas:", error));
}

// Mostrar la pregunta actual
function mostrarPregunta() {
    const contenedorPregunta = document.getElementById("pregunta-contenedor");
    const opcionesDiv = document.getElementById("opciones-respuesta");

    const pregunta = preguntas[materiaActual][preguntaActual];
    contenedorPregunta.textContent = pregunta.pregunta;

    opcionesDiv.innerHTML = pregunta.opciones.map((opcion, index) => `
        <label>
            <input type="radio" name="respuesta" value="${String.fromCharCode(65 + index)}" 
            ${respuestasUsuario[materiaActual]?.[preguntaActual] === String.fromCharCode(65 + index) ? "checked" : ""}>
            ${String.fromCharCode(65 + index)}) ${opcion}
        </label><br>
    `).join("");
}

// Guardar la respuesta seleccionada por el usuario
function seleccionarRespuesta() {
    const seleccionada = document.querySelector("input[name='respuesta']:checked");
    if (seleccionada) {
        if (!respuestasUsuario[materiaActual]) respuestasUsuario[materiaActual] = {};
        respuestasUsuario[materiaActual][preguntaActual] = seleccionada.value;
    }
}

// Actualizar el menú lateral con las preguntas
function actualizarMenuLateral(preguntasMateria) {
    const menuLateral = document.querySelector(`#materiasAccordion .accordion-body`);
    menuLateral.innerHTML = preguntasMateria.map((_, index) => `
        <button class="btn btn-primary btn-sm question-btn" data-question="${index}">
            ${index + 1}
        </button>
    `).join("");

    // Añadir eventos de clic a los botones de preguntas
    document.querySelectorAll(".question-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            seleccionarRespuesta(); // Guardar la respuesta actual
            preguntaActual = parseInt(btn.dataset.question);
            mostrarPregunta();
        });
    });
}

// Navegación entre preguntas
document.getElementById("btn-siguiente").addEventListener("click", () => {
    seleccionarRespuesta(); // Guardar la respuesta actual
    if (preguntaActual < preguntas[materiaActual].length - 1) {
        preguntaActual++;
        mostrarPregunta();
    }
});

document.getElementById("btn-anterior").addEventListener("click", () => {
    seleccionarRespuesta(); // Guardar la respuesta actual
    if (preguntaActual > 0) {
        preguntaActual--;
        mostrarPregunta();
    }
});

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

// Inicializar la aplicación
document.addEventListener("DOMContentLoaded", () => {
    cargarPreguntas("RazoVer"); // Cargar preguntas iniciales de la materia
    iniciarCronometro(); // Iniciar cronómetro
});
