const coloresNumeros = [
    "blue",
    "green",
    "red",
    "purple",
    "maroon",
    "turquoise",
    "black",
    "gray",
];

let tableroMatriz;
let tablero; 

async function manejarClicIzquierdo(fila, columna, e) {
    const valor = tableroMatriz[fila][columna];
    const spanNumero = document.createElement("span");

    e.target.classList.add("revelada"); 

    if (valor !== -1 && valor !== 0) {
        spanNumero.style.color = coloresNumeros[valor - 1];
        spanNumero.textContent = valor;

        e.target.appendChild(spanNumero);
    } else if (valor === 0) { 
        spanNumero.textContent = "";
        e.target.style.backgroundColor = "gray";
        e.target.appendChild(spanNumero);
        revelarAdyacentes(fila, columna); 
    } else {
        spanNumero.textContent = "💣";
        e.target.appendChild(spanNumero);

        const indicesMinas = calcularIndicesMinas();

        let hijos = tablero.childNodes; 

        for (const indice of indicesMinas) {
            hijos[indice].textContent = "💣";
        }

        setTimeout(function () {
            alert("Has perdido");
            document.getElementById("nivel").value = "";
            tablero.innerHTML = ""; // Limpiar el tablero
            tableroMatriz = null; // Reiniciar la matriz
        }, 100);
    }
}

function revelarAdyacentes(fila, columna) {
    const filas = tableroMatriz.length;
    const columnas = tableroMatriz[0].length;

    for (let i = -1; i <= 1; i++) {
        for (let j = -1; j <= 1; j++) {
            const nuevaFila = fila + i;
            const nuevaColumna = columna + j;

            if (
                nuevaFila >= 0 && nuevaFila < filas &&  nuevaColumna >= 0 && nuevaColumna < columnas && tableroMatriz[nuevaFila][nuevaColumna] !== -1 
            ) {
                const celda = tablero.childNodes[nuevaColumna + nuevaFila * columnas];
                if (!celda.classList.contains("revelada")) { // Solo revelar si no está revelada
                    manejarClicIzquierdo(nuevaFila, nuevaColumna, { target: celda });
                }
            }
        }
    }
}


function calcularIndicesMinas() {
    const indicesMinas = [];

    for (let i = 0; i < tableroMatriz.length; i++) {
        for (let j = 0; j < tableroMatriz[i].length; j++) {
            if (tableroMatriz[i][j] === -1) { 
                indicesMinas.push(j + i * tableroMatriz[i].length);
            }
        }
    }

    return indicesMinas;
}

document.querySelector("#nivel").addEventListener("change", async (e) => {
    const nivel = document.getElementById("nivel").value;

    let filas = 0;
    let columnas = 0;

    switch (nivel) {
        case "facil":
            filas = 8;
            columnas = 8;
            break;
        case "medio":
            filas = 16;
            columnas = 16;
            break;
        case "dificil":
            filas = 16;
            columnas = 30;
            break;
    }

    try {
        const response = await fetch(window.location.href + "generar_tablero.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ nivel }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log(data.tablero);
        tableroMatriz = data.tablero;
        generarTablero(filas, columnas);
    } catch (error) {
        console.error("Error: ", error);
        alert("Error al cargar el tablero. Inténtalo de nuevo."); // Alerta al usuario
    }
});

function generarTablero(filas, columnas) {
    tablero = document.getElementById("tablero"); // Asigna el elemento a la variable global
    tablero.innerHTML = "";

    for (let i = 0; i < filas; i++) {
        for (let j = 0; j < columnas; j++) {
            let celda = document.createElement("div");
            celda.className = "celda";
            celda.textContent = "";

            const fila = i;
            const columna = j;

            const manejarClicIzquierdoHandler = manejarClicIzquierdo.bind(null, fila, columna);

            celda.addEventListener("click", manejarClicIzquierdoHandler);
            celda.addEventListener("contextmenu", (e) => {
                e.preventDefault();

                if (e.target.textContent === "🚩") { 
                    e.target.textContent = "";
                    e.target.addEventListener("click", manejarClicIzquierdoHandler);
                } else {
                    e.target.textContent = "🚩";
                    e.target.removeEventListener("click", manejarClicIzquierdoHandler);
                }
            });

            tablero.appendChild(celda);
        }
    }

    tablero.style.gridTemplateColumns = `repeat(${columnas}, 30px)`;
}