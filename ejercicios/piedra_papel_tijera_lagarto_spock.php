<?php

function piedra_papel_tijera_lagarto_spock($jugador1, $jugador2) {
    // Definir las opciones y sus nombres
    $opciones = array(
        0 => "Piedra",
        1 => "Papel",
        2 => "Tijera",
        3 => "Lagarto",
        4 => "Spock"
    );

    // Mostrar las manos de los jugadores
    echo "Jugador 1: " . $opciones[$jugador1] . "\n";
    echo "Jugador 2: " . $opciones[$jugador2] . "\n";

    // Definir las reglas del juego
    $reglas = array(
        array(0, 2, 3), // Piedra gana a Tijera y Lagarto
        array(1, 0, 4), // Papel gana a Piedra y Spock
        array(2, 1, 3), // Tijera gana a Papel y Lagarto
        array(3, 4, 1), // Lagarto gana a Spock y Papel
        array(4, 2, 0)  // Spock gana a Tijera y Piedra
    );

    // Determinar el ganador
    if ($jugador1 == $jugador2) {
        echo "Empate\n";
    } else {
        foreach ($reglas as $regla) {
            if ($regla[0] == $jugador1 && (in_array($jugador2, array_slice($regla, 1)))) {
                echo "Jugador 1 gana\n";
                return;
            }
            if ($regla[0] == $jugador2 && (in_array($jugador1, array_slice($regla, 1)))) {
                echo "Jugador 2 gana\n";
                return;
            }
        }
    }
}

// Obtener los argumentos de la línea de comandos
$jugador1 = $argv[1];
$jugador2 = $argv[2];

// Llamar a la función con los argumentos
piedra_papel_tijera_lagarto_spock($jugador1, $jugador2);

?>