<?php

require_once("BDConexion.php");

try {

    $rutaXq = "nombres.xq";
    $fichero = fopen($rutaXq, "r"); // Abrimos el fichero $rutaXq en modo lectura "r"
    $xq = fread($fichero, filesize($rutaXq)); // Leemos el contenido del fichero y lo guardamos en la variable $xq
    fclose($fichero); // Cerramos el fichero

    // create session
    $session = new Session();
    // open database
    $session->execute("open PruebaReto"); // open y el nombre de la base de datos en el servidor BaseX
    // xquery
    $query = $session->query($xq);

    // execute result
    $result = $query->execute();
    // close query
    $query->close();
    // close session
    $session->close();

    // Show the result
    echo $result;
} catch (Exception $e) {

    echo $e->getMessage();
}
