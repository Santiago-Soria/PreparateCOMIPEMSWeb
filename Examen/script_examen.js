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
    const pregunta = preguntas[materiaActual][indicePregunta];
    const preguntaContenedor = document.getElementById("pregunta-contenedor");
    const respuestaContenedor = document.getElementById("opciones-respuesta");

    // Mostrar texto de la pregunta con formato
    preguntaContenedor.innerHTML = pregunta.pregunta.replace(/\n/g, "<br>");

    // Mostrar imagen si existe
    if (pregunta.imagen) {
        const img = document.createElement("img");
        img.src = pregunta.imagen;
        img.alt = "Imagen de apoyo";
        img.style.maxWidth = "100%";
        preguntaContenedor.appendChild(img);
    }

    // Mostrar opciones
    respuestaContenedor.innerHTML = pregunta.opciones
    .map((opcion, i) => `<label><input type="radio" name="respuesta" value="${String.fromCharCode(65 + i)}"> ${opcion}</label><br>`)
    .join("");

// Mostrar/ocultar botón de anterior
document.getElementById("btn-anterior").style.display = indicePregunta > 0 || Object.keys(preguntas).indexOf(materiaActual) > 0
? "inline-block"
: "none";
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
    indicePregunta++;
    if (indicePregunta >= preguntas[materiaActual].length) {
        // Cambiar a la siguiente materia
        const materias = Object.keys(preguntas);
        const index = materias.indexOf(materiaActual);
        if (index + 1 < materias.length) {
            materiaActual = materias[index + 1];
            indicePregunta = 0;
        } else {
            alert("¡Has terminado el examen!");
            return;
        }
    }
    mostrarPregunta();
});

document.getElementById("btn-anterior").addEventListener("click", () => {
    if (indicePregunta > 0) {
        indicePregunta--;
    } else {
        // Cambiar a la materia anterior
        const materias = Object.keys(preguntas);
        const index = materias.indexOf(materiaActual);
        if (index > 0) {
            materiaActual = materias[index - 1];
            indicePregunta = preguntas[materiaActual].length - 1;
        }
    }
    mostrarPregunta();
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
