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
    if (window.location.pathname.includes("Retroalimentacion.php")) {
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

    // Configurar los enlaces del menú
    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); // Prevenir comportamiento por defecto
            const action = link.getAttribute("onclick");
            if (action) eval(action);
        });
    });
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

    // Mostrar u ocultar el botón "Anterior"
    const indiceMateria = Object.keys(datos).indexOf(materia);
    document.getElementById("btn-anterior").style.display = pregunta > 1 || indiceMateria > 0 ? "block" : "none";
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
        window.location.href = "Retroalimentacion.php";
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

    if (total === 0) {
        // Evitar división por 0
        document.getElementById("detalle-resultado").textContent = "No hay resultados disponibles.";
        document.getElementById("porcentaje-aciertos").textContent = "Porcentaje de aciertos: -";
        document.getElementById("calificacion-aciertos").textContent = "Calificación: -";
        return;
    }

    // Calcular el porcentaje de aciertos
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

    // Actualizar el DOM con los resultados
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


// Mostrar sugerencias de mejora
function mostrarSugerenciasMejora() {
    ocultarSecciones();
    let sugerenciasContainer = document.getElementById("sugerencias-mejora");

    if (!sugerenciasContainer) {
        sugerenciasContainer = document.createElement("div");
        sugerenciasContainer.id = "sugerencias-mejora";
        sugerenciasContainer.innerHTML = `
            <h3 class="text-center">Sugerencias de Mejora</h3>
            <p>Áreas de oportunidad:</p>
            <ul>
                <li>Estudia los temas con menor porcentaje de aciertos.</li>
                <li>Revisa tus respuestas incorrectas y practica más ejercicios.</li>
                <li>Consulta recursos adicionales como guías de estudio.</li>
            </ul>
        `;
        document.getElementById("contenido-principal").appendChild(sugerenciasContainer);
    }

    sugerenciasContainer.style.display = "block";
}

// Mostrar una sola sección y ocultar el resto
function mostrarSeccion(seccionId) {
    const secciones = ["resumen-general", "resultados-asignatura", "sugerencias-mejora"];
    secciones.forEach(id => {
        const seccion = document.getElementById(id);
        if (seccion) {
            seccion.style.display = id === seccionId ? "block" : "none";
        }
    });
}

// Mostrar Resumen General
function mostrarResumenGeneral() {
    mostrarSeccion("resumen-general");
}

// Mostrar Resultados por Asignatura
function mostrarResultadosPorAsignatura() {
    mostrarSeccion("resultados-asignatura");

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

        let colorClase = "";
        if (porcentaje >= 80) colorClase = "table-success"; // Verde
        else if (porcentaje >= 60) colorClase = "table-warning"; // Amarillo
        else colorClase = "table-danger"; // Rojo

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
}

function mostrarSugerenciasPorMateria() {
    // Ocultar otras secciones
    document.getElementById("resumen-general").style.display = "none";
    document.getElementById("resultados-asignatura").style.display = "none";
    document.getElementById("sugerencias-mejora").style.display = "block";

    const resultados = JSON.parse(localStorage.getItem("resultadoExamenPorMateria")) || {};
    const sugerenciasPorMateria = {
        "RazonamientoVerbal": ["Mejora la comprensión lectora", "Práctica con sinónimos y antónimos"],
        "RazonamientoMatematico": ["Revisar álgebra básica", "Estudiar resolución de problemas"],
        "Español": ["Estudia ortografía y redacción", "Repasa las reglas gramaticales"],
        "matematicas": ["Practica ecuaciones y geometría", "Refuerza cálculos básicos"],
        "Biologia": ["Estudia procesos celulares", "Revisa el sistema humano"],
        "Fisica": ["Repasa leyes de Newton", "Practica problemas de movimiento"],
        "Quimica": ["Revisar tabla periódica", "Estudiar reacciones químicas básicas"],
        "Historia": ["Repasar independencia y revolución", "Estudia contexto histórico global"],
        "Geografia": ["Ubicación de continentes", "Estudiar características geográficas"],
        "FCyE": ["Revisar ética y ciudadanía", "Práctica con situaciones de la vida diaria"]
    };

    // Actualizar el contenido dinámico de sugerencias
    const listaSugerencias = document.querySelector("#sugerencias-mejora #lista-sugerencias");

    // Si no existe, creamos la lista dentro del contenedor
    if (!listaSugerencias) {
        const contenedorSugerencias = document.getElementById("sugerencias-mejora");
        contenedorSugerencias.innerHTML = `
            <h3 class="text-center text-primary">Sugerencias de Mejora</h3>
            <ul id="lista-sugerencias"></ul>
        `;
    }

    const listaSugerenciasActualizada = document.getElementById("lista-sugerencias");
    listaSugerenciasActualizada.innerHTML = ""; // Limpiar contenido previo

    for (const materia in resultados) {
        const { correctas, preguntas } = resultados[materia];
        const porcentaje = ((correctas / preguntas) * 100).toFixed(2);

        if (porcentaje < 80) {
            const sugerencias = sugerenciasPorMateria[materia] || ["Estudia más temas en esta materia."];
            const item = document.createElement("li");
            item.innerHTML = `<strong>${materia} (${porcentaje}%):</strong> ${sugerencias.join(", ")}`;
            listaSugerenciasActualizada.appendChild(item);
        }
    }

    if (listaSugerenciasActualizada.childElementCount === 0) {
        listaSugerenciasActualizada.innerHTML = "<li>¡Felicidades! No tienes áreas de mejora específicas.</li>";
    }
}




