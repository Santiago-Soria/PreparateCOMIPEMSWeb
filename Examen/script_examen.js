let preguntas = {};
let materiaActual = "RazonamientoVerbal";
let indicePregunta = 0;
let respuestasUsuario = {};
let tiempo = 3 * 60 * 60; // 3 horas en segundos


// Cargar preguntas desde un archivo JSON local
function cargarPreguntas(materia) {
    fetch("preguntas.json") // Ruta relativa al archivo JSON
        .then(response => response.json())
        .then(data => {
            preguntas = data; // Guardar todas las preguntas
            materiaActual = materia;
            indicePregunta = 0; // Iniciar con la primera pregunta de la materia
            mostrarPregunta();
            actualizarMenuLateral(data[materia]);
        })
        .catch(error => console.error("Error al cargar preguntas:", error));
}

function mostrarPregunta() {
    const pregunta = preguntas[materiaActual][indicePregunta];
    const preguntaContenedor = document.getElementById("pregunta-contenedor");
    const respuestaContenedor = document.getElementById("opciones-respuesta");

    // Limpiar contenido previo del contenedor
    preguntaContenedor.innerHTML = "";

    // Crear un div para el texto de la pregunta
    const textoPregunta = document.createElement("div");
    textoPregunta.innerHTML = pregunta.pregunta.replace(/\n/g, "<br>");
    textoPregunta.classList.add("texto-pregunta"); // Clase para estilos específicos
    preguntaContenedor.appendChild(textoPregunta);

    // Mostrar imagen si existe
    if (pregunta.imagen) {
        const img = document.createElement("img");
        img.src = pregunta.imagen;
        img.alt = "Imagen de apoyo";
        img.classList.add("imagen-pregunta"); // Clase para estilos específicos
        preguntaContenedor.appendChild(img);
    }

   // Mostrar opciones con texto e imágenes (si existen)
respuestaContenedor.innerHTML = pregunta.opciones
.map((opcion, i) => {
    const texto = opcion.texto || ""; // Texto de la respuesta, o vacío si no existe
    const imagen = opcion.imagen
        ? `<img src="${opcion.imagen}" alt="${texto}" class="imagen-respuesta">`
        : ""; // Solo agrega la imagen si existe
    return `
        <label class="opcion-respuesta">
            <input type="radio" name="respuesta" value="${String.fromCharCode(65 + i)}">
            ${texto}
            ${imagen}
        </label>
    `;
})
.join("");


    // Mostrar/ocultar botón de anterior
    document.getElementById("btn-anterior").style.display = 
        indicePregunta > 0 || Object.keys(preguntas).indexOf(materiaActual) > 0
        ? "inline-block"
        : "none";
}



// Guardar la respuesta seleccionada por el usuario
function seleccionarRespuesta() {
    const seleccionada = document.querySelector("input[name='respuesta']:checked");
    if (seleccionada) {
        if (!respuestasUsuario[materiaActual]) respuestasUsuario[materiaActual] = {};
        respuestasUsuario[materiaActual][indicePregunta] = seleccionada.value;

        // Actualizar el estilo del botón correspondiente
        document.querySelector(`.question-btn[data-question="${indicePregunta}"]`)
            .classList.add("respondida");
    }
}

// Actualizar el menú lateral con las preguntas
function actualizarMenuLateral(preguntasMateria) {
    const menuLateral = document.querySelector(`#materiasAccordion .accordion-body`);
    menuLateral.innerHTML = preguntasMateria.map((_, index) => `
        <button class="btn btn-primary btn-sm question-btn ${respuestasUsuario[materiaActual] && respuestasUsuario[materiaActual][index] ? 'respondida' : ''}" data-question="${index}">
            ${index + 1}
        </button>
    `).join("");

    // Añadir eventos de clic a los botones de preguntas
    document.querySelectorAll(".question-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            seleccionarRespuesta(); // Guardar la respuesta actual
            indicePregunta = parseInt(btn.dataset.question);
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
    cargarPreguntas("RazonamientoVerbal"); // Cargar preguntas iniciales de la materia
    iniciarCronometro(); // Iniciar cronómetro
});
