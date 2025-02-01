<?php

function imprimirDiamante($tamano)
{
    if (!is_numeric($tamano) || $tamano <= 0){
        echo "Por favor, ingrese un numero positivo como argumento";
        return ;   
    }

    // imprimir el diamante
    for ($i = 1; $i <= $tamano; $i++) {
        // imprimir espcaios en blanco para la alineacion
        echo str_repeat(" ", $tamano - $i);

        //imprimir asteriscos para la parte superior del diamante
        echo str_repeat("* ", $i);

        echo "\n";
    }

    for ($i = $tamano - 1; $i >= 1; $i--) {
        // imprimir espacios en blanco para la alineacion
        echo str_repeat(" ", $tamano - $i);

        // imprimir asteriscos para la parte inferior del diamante
        echo str_repeat("* ", $i);

        echo "\n";
    }

   
}

 // verifica si se proporciono un argumento
 if (isset($argv[1])){
    //obtener el numero ingresado
    $tamano = intval($argv[1]);

    // llamar a la funcion para imprimir el diamante
    imprimirDiamante($tamano);
}else {
 
    echo "Por favor, ingrese un numero como argumento";
}
