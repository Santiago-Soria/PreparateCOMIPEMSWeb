let preguntas = {};
let materiaActual = "espanol";
let preguntaActual = 0;
let tiempo = 3 * 60 * 60; // 3 horas en segundos

// Cargar preguntas
fetch("preguntas.json")
    .then(response => response.json())
    .then(data => {
        preguntas = data;
        mostrarPregunta();
    });

function mostrarPregunta() {
    const contenedorPregunta = document.getElementById("pregunta-contenedor");
    const contenedorRespuesta = document.getElementById("respuesta-contenedor");
    
    const pregunta = preguntas[materiaActual][preguntaActual];
    contenedorPregunta.textContent = pregunta.pregunta;

    const opciones = document.getElementById("opciones-respuesta");
    opciones.innerHTML = pregunta.opciones.map((opcion, index) => `
        <label><input type="radio" name="respuesta" value="${String.fromCharCode(65 + index)}"> ${opcion}</label><br>
    `).join("");
}

document.getElementById("btn-siguiente").addEventListener("click", () => {
    if (preguntaActual < preguntas[materiaActual].length - 1) {
        preguntaActual++;
        mostrarPregunta();
    }
});

document.getElementById("btn-anterior").addEventListener("click", () => {
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
            cronometro.textContent = `${horas}:${minutos}:${segundos}`;
            tiempo--;
        }
    }, 1000);
}

iniciarCronometro();
