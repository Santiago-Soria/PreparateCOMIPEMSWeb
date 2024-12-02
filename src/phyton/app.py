from flask import Flask, jsonify, request
from flask_cors import CORS
import json

app = Flask(__name__)
CORS(app)  # Habilitar CORS

# Cargar preguntas desde un archivo JSON
with open("preguntas.json") as f:
    preguntas_data = json.load(f)

# Ruta para obtener preguntas por materia
@app.route("/preguntas/<materia>")
def obtener_preguntas(materia):
    preguntas = preguntas_data.get(materia, [])
    return jsonify(preguntas)

# Ruta para guardar respuestas
@app.route("/guardar_respuestas", methods=["POST"])
def guardar_respuestas():
    data = request.json
    with open("respuestas_usuario.json", "w") as f:
        json.dump(data, f)
    return jsonify({"status": "success", "message": "Respuestas guardadas exitosamente"})

if __name__ == "__main__":
    app.run(port=5000, debug=True)
