let datos; // Almacena las preguntas cargadas
let respuestasUsuario = JSON.parse(localStorage.getItem("respuestasUsuario")) || {};
let currentMateria = "RazonamientoVerbal";
let currentPregunta = 1;
let tiempo = 3 * 60 * 60; // 3 horas en segundos

const respuestasCorrectas = {
    "RazonamientoVerbal": ["A", "B", "C", "D", "A"],
    "RazonamientoMatematico": ["A", "C", "A", "A", "C"],
    "Español": ["A", "B", "A", "C", "C"],
    "matematicas": ["C", "B", "B", "B", "D"],
    "Biologia": ["A", "A", "C", "B", "A"],
    "Fisica": ["A", "D", "A", "C", "C"],
    "Quimica": ["A", "A", "C", "D", "A"],
    "Historia": ["B", "D", "A", "B", "C"],
    "Geografia": ["C", "C", "A", "C", "A"],
    "FCyE": ["A", "A", "D", "D", "B"]
};

// Inicializar el examen o mostrar resultados
document.addEventListener("DOMContentLoaded", async () => {
    if (window.location.pathname.includes("Retroalimentacion.html")) {
        mostrarResultadosRetroalimentacion();
    } else {
        try {
            const response = await fetch("preguntas.json"); // Ruta al archivo JSON
            datos = await response.json();

            configurarBotonesMenu();
            cargarPregunta(currentMateria, currentPregunta);
            iniciarCronometro();
        } catch (error) {
            console.error("Error al cargar preguntas:", error);
        }
    }
});

// Configurar botones del menú lateral
function configurarBotonesMenu() {
    document.querySelectorAll(".btn[data-materia]").forEach(btn => {
        const materia = btn.dataset.materia;
        const pregunta = parseInt(btn.dataset.pregunta);
        const idPregunta = `${materia}-${pregunta}`;

        if (respuestasUsuario[idPregunta]) {
            btn.classList.add("btn-success");
        }

        btn.addEventListener("click", () => {
            currentMateria = materia;
            currentPregunta = pregunta;
            cargarPregunta(currentMateria, currentPregunta);
        });
    });
}

// Cargar una pregunta
function cargarPregunta(materia, pregunta) {
    const preguntaData = datos[materia][pregunta - 1];
    const preguntaContenedor = document.getElementById("pregunta-contenedor");

    preguntaContenedor.innerHTML = `
        <p>${preguntaData.pregunta}</p>
        ${preguntaData.imagen ? `<img src="${preguntaData.imagen}" alt="Imagen de la pregunta" class="imagen-pregunta">` : ""}
    `;

    const opciones = preguntaData.opciones.map((opcion, index) => `
        <label>
            <input type="radio" name="respuesta" value="${String.fromCharCode(65 + index)}"
            ${respuestasUsuario[`${materia}-${pregunta}`] === String.fromCharCode(65 + index) ? "checked" : ""}>
            ${opcion.texto || `<img src="${opcion.imagen}" alt="Opción ${index + 1}" class="imagen-opcion">`}
        </label><br>
    `).join("");

    document.getElementById("opciones-respuesta").innerHTML = opciones;
    document.getElementById("indice").textContent = `Materia: ${materia} > Pregunta: ${pregunta}`;

    document.getElementById("btn-anterior").style.display = pregunta > 1 || Object.keys(datos).indexOf(materia) > 0 ? "block" : "none";
}

// Guardar respuesta seleccionada
document.getElementById("opciones-respuesta").addEventListener("change", (e) => {
    if (e.target.name === "respuesta") {
        const idPregunta = `${currentMateria}-${currentPregunta}`;
        respuestasUsuario[idPregunta] = e.target.value;
        localStorage.setItem("respuestasUsuario", JSON.stringify(respuestasUsuario));
        document.querySelector(`.btn[data-materia="${currentMateria}"][data-pregunta="${currentPregunta}"]`).classList.add("btn-success");
    }
});

// Navegación entre preguntas
document.getElementById("btn-anterior").addEventListener("click", () => {
    if (currentPregunta > 1) {
        currentPregunta--;
    } else {
        const materias = Object.keys(datos);
        const index = materias.indexOf(currentMateria);
        currentMateria = materias[index - 1];
        currentPregunta = datos[currentMateria].length;
    }
    cargarPregunta(currentMateria, currentPregunta);
});

document.getElementById("btn-siguiente").addEventListener("click", () => {
    if (currentPregunta === datos[currentMateria].length && currentMateria === "FCyE") {
        confirmarFinalizar();
    } else if (currentPregunta === datos[currentMateria].length) {
        const materias = Object.keys(datos);
        currentMateria = materias[materias.indexOf(currentMateria) + 1];
        currentPregunta = 1;
    } else {
        currentPregunta++;
    }
    cargarPregunta(currentMateria, currentPregunta);
});

// Finalizar examen
function confirmarFinalizar() {
    if (confirm("¿Deseas finalizar el examen?")) {
        calcularResultados();
        window.location.href = "Retroalimentacion.html";
    }
}

function calcularResultados() {
    let aciertosTotales = 0;
    let totalPreguntasTotales = 0;
    const resultadosPorMateria = {};

    for (const [materia, respuestas] of Object.entries(respuestasCorrectas)) {
        let correctas = 0;
        respuestas.forEach((respuesta, index) => {
            const idPregunta = `${materia}-${index + 1}`;
            if (respuestasUsuario[idPregunta]) {
                totalPreguntasTotales++;
                if (respuestasUsuario[idPregunta] === respuesta) {
                    correctas++;
                    aciertosTotales++;
                }
            }
        });

        // Guardar resultados por materia
        resultadosPorMateria[materia] = {
            correctas: correctas,
            preguntas: respuestas.length,
        };
    }

    // Guardar resultados globales y por materia en localStorage
    localStorage.setItem("resultadoExamen", JSON.stringify({ aciertos: aciertosTotales, total: totalPreguntasTotales }));
    localStorage.setItem("resultadoExamenPorMateria", JSON.stringify(resultadosPorMateria));
}

// Mostrar resultados en Retroalimentacion.html
function mostrarResultadosRetroalimentacion() {
    const resultado = JSON.parse(localStorage.getItem("resultadoExamen"));

    if (!resultado) {
        document.getElementById("detalle-resultado").textContent = "No hay resultados disponibles.";
        document.getElementById("porcentaje-aciertos").textContent = "Porcentaje de aciertos: -";
        document.getElementById("calificacion-aciertos").textContent = "Calificación: -";
        return;
    }

    const { aciertos, total } = resultado;
    const porcentaje = ((aciertos / total) * 100).toFixed(2);

    let calificacion;
    if (porcentaje >= 80) {
        calificacion = "Excelente";
    } else if (porcentaje >= 50) {
        calificacion = "Bueno";
    } else {
        calificacion = "Malo";
    }

    document.getElementById("detalle-resultado").textContent = `Puntaje total: ${aciertos}/${total}`;
    document.getElementById("porcentaje-aciertos").textContent = `Porcentaje de aciertos: ${porcentaje}%`;
    document.getElementById("calificacion-aciertos").textContent = `Calificación: ${calificacion}`;
}



// Cronómetro
function iniciarCronometro() {
    const cronometro = document.getElementById("cronometro");
    const interval = setInterval(() => {
        if (tiempo <= 0) {
            clearInterval(interval);
            alert("El tiempo terminó.");
            confirmarFinalizar();
        } else {
            const horas = Math.floor(tiempo / 3600);
            const minutos = Math.floor((tiempo % 3600) / 60);
            const segundos = tiempo % 60;
            cronometro.textContent = `${horas.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}:${segundos.toString().padStart(2, "0")}`;
            tiempo--;
        }
    }, 1000);
}

function mostrarResumenGeneral() {
    document.getElementById("resumen-general").style.display = "block";
    document.getElementById("resultados-asignatura").style.display = "none";
}

function mostrarResultadosPorAsignatura() {
    const resultados = JSON.parse(localStorage.getItem("resultadoExamenPorMateria")) || {};
    const tablaResultados = document.getElementById("tabla-resultados");

    // Limpiar la tabla antes de llenarla
    tablaResultados.innerHTML = "";

    // Construir las filas dinámicamente
    for (const materia in respuestasCorrectas) {
        const totalPreguntas = respuestasCorrectas[materia].length;
        const correctas = resultados[materia]?.correctas || 0;
        const incorrectas = totalPreguntas - correctas;
        const porcentaje = ((correctas / totalPreguntas) * 100).toFixed(2);

        // Determinar color del porcentaje
        let colorClase = "";
        if (porcentaje >= 80) colorClase = "table-success"; // Verde
        else if (porcentaje >= 60) colorClase = "table-warning"; // Amarillo
        else colorClase = "table-danger"; // Rojo

        // Agregar la fila a la tabla
        const fila = `
            <tr>
                <td>${materia}</td>
                <td>${totalPreguntas}</td>
                <td style="color: green;">${correctas}</td>
                <td style="color: red;">${incorrectas}</td>
                <td class="${colorClase}">${porcentaje}%</td>
            </tr>
        `;
        tablaResultados.innerHTML += fila;
    }

    // Mostrar tabla y ocultar otros contenidos
    document.getElementById("resumen-general").style.display = "none";
    document.getElementById("resultados-asignatura").style.display = "block";
}

let datos; // Almacena las preguntas cargadas
let respuestasUsuario = JSON.parse(localStorage.getItem("respuestasUsuario")) || {};
let currentMateria = "RazonamientoVerbal";
let currentPregunta = 1;
let tiempo = 3 * 60 * 60; // 3 horas en segundos

const respuestasCorrectas = {
    "RazonamientoVerbal": ["A", "B", "C", "D", "A"],
    "RazonamientoMatematico": ["A", "C", "A", "A", "C"],
    "Español": ["A", "B", "A", "C", "C"],
    "matematicas": ["C", "B", "B", "B", "D"],
    "Biologia": ["A", "A", "C", "B", "A"],
    "Fisica": ["A", "D", "A", "C", "C"],
    "Quimica": ["A", "A", "C", "D", "A"],
    "Historia": ["B", "D", "A", "B", "C"],
    "Geografia": ["C", "C", "A", "C", "A"],
    "FCyE": ["A", "A", "D", "D", "B"]
};

// Inicializar el examen o mostrar resultados
document.addEventListener("DOMContentLoaded", async () => {
    if (window.location.pathname.includes("Retroalimentacion.html")) {
        mostrarResultadosRetroalimentacion();
    } else {
        try {
            const response = await fetch("preguntas.json"); // Ruta al archivo JSON
            datos = await response.json();

            configurarBotonesMenu();
            cargarPregunta(currentMateria, currentPregunta);
            iniciarCronometro();
        } catch (error) {
            console.error("Error al cargar preguntas:", error);
        }
    }
});

// Configurar botones del menú lateral
function configurarBotonesMenu() {
    document.querySelectorAll(".btn[data-materia]").forEach(btn => {
        const materia = btn.dataset.materia;
        const pregunta = parseInt(btn.dataset.pregunta);
        const idPregunta = `${materia}-${pregunta}`;

        if (respuestasUsuario[idPregunta]) {
            btn.classList.add("btn-success");
        }

        btn.addEventListener("click", () => {
            currentMateria = materia;
            currentPregunta = pregunta;
            cargarPregunta(currentMateria, currentPregunta);
        });
    });
}

// Cargar una pregunta
function cargarPregunta(materia, pregunta) {
    const preguntaData = datos[materia][pregunta - 1];
    const preguntaContenedor = document.getElementById("pregunta-contenedor");

    preguntaContenedor.innerHTML = `
        <p>${preguntaData.pregunta}</p>
        ${preguntaData.imagen ? `<img src="${preguntaData.imagen}" alt="Imagen de la pregunta" class="imagen-pregunta">` : ""}
    `;

    const opciones = preguntaData.opciones.map((opcion, index) => `
        <label>
            <input type="radio" name="respuesta" value="${String.fromCharCode(65 + index)}"
            ${respuestasUsuario[`${materia}-${pregunta}`] === String.fromCharCode(65 + index) ? "checked" : ""}>
            ${opcion.texto || `<img src="${opcion.imagen}" alt="Opción ${index + 1}" class="imagen-opcion">`}
        </label><br>
    `).join("");

    document.getElementById("opciones-respuesta").innerHTML = opciones;
    document.getElementById("indice").textContent = `Materia: ${materia} > Pregunta: ${pregunta}`;
}

// Guardar respuesta seleccionada
document.getElementById("opciones-respuesta").addEventListener("change", (e) => {
    if (e.target.name === "respuesta") {
        const idPregunta = `${currentMateria}-${currentPregunta}`;
        respuestasUsuario[idPregunta] = e.target.value;
        localStorage.setItem("respuestasUsuario", JSON.stringify(respuestasUsuario));
        document.querySelector(`.btn[data-materia="${currentMateria}"][data-pregunta="${currentPregunta}"]`).classList.add("btn-success");
    }
});

// Navegación entre preguntas
document.getElementById("btn-anterior").addEventListener("click", () => {
    if (currentPregunta > 1) {
        currentPregunta--;
    } else {
        const materias = Object.keys(datos);
        const index = materias.indexOf(currentMateria);
        currentMateria = materias[index - 1];
        currentPregunta = datos[currentMateria].length;
    }
    cargarPregunta(currentMateria, currentPregunta);
});

document.getElementById("btn-siguiente").addEventListener("click", () => {
    if (currentPregunta === datos[currentMateria].length && currentMateria === "FCyE") {
        confirmarFinalizar();
    } else if (currentPregunta === datos[currentMateria].length) {
        const materias = Object.keys(datos);
        currentMateria = materias[materias.indexOf(currentMateria) + 1];
        currentPregunta = 1;
    } else {
        currentPregunta++;
    }
    cargarPregunta(currentMateria, currentPregunta);
});

// Finalizar examen
function confirmarFinalizar() {
    if (confirm("¿Deseas finalizar el examen?")) {
        calcularResultados();
        window.location.href = "Retroalimentacion.html";
    }
}

function calcularResultados() {
    let aciertos = 0;
    let totalPreguntas = 0;

    for (const [materia, respuestas] of Object.entries(respuestasCorrectas)) {
        respuestas.forEach((respuesta, index) => {
            const idPregunta = `${materia}-${index + 1}`;
            if (respuestasUsuario[idPregunta]) { // Si hay respuesta del usuario
                totalPreguntas++;
                if (respuestasUsuario[idPregunta] === respuesta) {
                    aciertos++;
                }
            }
        });
    }

    // Guardar resultados en el localStorage
    localStorage.setItem("resultadoExamen", JSON.stringify({ aciertos, total: totalPreguntas }));
}

function mostrarResultadosRetroalimentacion() {
    const resultado = JSON.parse(localStorage.getItem("resultadoExamen"));

    if (!resultado) {
        document.getElementById("detalle-resultado").textContent = "No hay resultados disponibles.";
        document.getElementById("porcentaje-aciertos").textContent = "Porcentaje de aciertos: -";
        document.getElementById("calificacion-aciertos").textContent = "Calificación: -";
        return;
    }

    const { aciertos, total } = resultado;

    // Calcular porcentaje
    const porcentaje = ((aciertos / total) * 100).toFixed(2);

    // Determinar calificación
    let calificacion;
    if (porcentaje >= 80) {
        calificacion = "Excelente";
    } else if (porcentaje >= 50) {
        calificacion = "Bueno";
    } else {
        calificacion = "Malo";
    }

    // Actualizar valores en el DOM
    document.getElementById("detalle-resultado").textContent = `Puntaje total: ${aciertos}/${total}`;
    document.getElementById("porcentaje-aciertos").textContent = `Porcentaje de aciertos: ${porcentaje}%`;
    document.getElementById("calificacion-aciertos").textContent = `Calificación: ${calificacion}`;
}

// Cronómetro
function iniciarCronometro() {
    const cronometro = document.getElementById("cronometro");
    const interval = setInterval(() => {
        if (tiempo <= 0) {
            clearInterval(interval);
            alert("El tiempo terminó.");
            confirmarFinalizar();
        } else {
            const horas = Math.floor(tiempo / 3600);
            const minutos = Math.floor((tiempo % 3600) / 60);
            const segundos = tiempo % 60;
            cronometro.textContent = `${horas.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}:${segundos.toString().padStart(2, "0")}`;
            tiempo--;
        }
    }, 1000);
}
