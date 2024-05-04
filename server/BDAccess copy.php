<?php
require_once("BDConexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $rutaArchivoXslt = "../transform/data.xsl";
    $xml = consultar();

    if (file_exists($rutaArchivoXslt)) {
        $xsl = new DOMDocument();
        $xsl->load($rutaArchivoXslt);

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $html = $proc->transformToXml($xml);

        echo $html;
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'alta':
                altaDato();
                break;
            case 'modificar':
                modificarDato();
                break;
            case 'eliminar':
                //eliminarDato();
                break;
            default:
                echo 'Papi anda perdido';
        }
    } else {
        echo 'No has metido esa funcion';
    }
}

function modificar()
{
    //Faltan las variables
    try {
        if (isset($_GET["nombre"]) && isset($_GET["apellido"]) && isset($_GET["edad"]) && isset($_GET["correo"])) {

            // Crear sesión
            $session = new Session();
            // Abrir la base de datos
            $session->execute("open PruebaReto");
            // Cargar la consulta XQuery desde el archivo
            $rutaXq = "query.xq";
            $fichero = fopen($rutaXq, "r");
            $xq = fread($fichero, filesize($rutaXq));
            fclose($fichero);
            // Ejecutar la consulta con el parámetro "codigo"
            $query = $session->query($xq);
            // Vincular el valor del parámetro "codigo" a la consulta XQuery
            $query->bind('$nombre', $_GET["nombre"]);
            $query->bind('$apellido', $_GET["apellido"]);
            $query->bind('$edad', $_GET["edad"]);
            $query->bind('$correo', $_GET["correo"]);
            // Ejecutar la consulta
            $result = $query->execute();

            $rutaXq = "consulta.xq";
            $fichero = fopen($rutaXq, "r");
            $xq = fread($fichero, filesize($rutaXq));
            fclose($fichero);
            // Ejecutar la consulta con el parámetro "codigo"
            $query = $session->query($xq);
            $result = $query->execute();
            // Cerrar la consulta y la sesión
            $query->close();
            $session->close();

            $xml = new DOMDocument;
            $xml->loadXML($result);

            return $xml;

            // $xsl = new DOMDocument;
            // $xsl->load('../transform/data.xsl');

            // $proc = new XSLTProcessor;

            // $proc->importStyleSheet($xsl);

            // echo $proc->transformToXML($xml);
        } else {
            // Si no se proporciona el parámetro "codigo", mostrar un mensaje de error
            echo "Por favor, introduzca variables.";
        }
    } catch (Exception $e) {
        // Manejar cualquier excepción que ocurra durante la ejecución
        echo $e->getMessage();
    }
}

function consultar()
{
    try {
        // Crear sesión
        $session = new Session();
        // Abrir la base de datos
        $session->execute("open PruebaReto");
        // Cargar la consulta XQuery desde el archivo
        $rutaXq = "consulta.xq";
        $fichero = fopen($rutaXq, "r");
        $xq = fread($fichero, filesize($rutaXq));
        fclose($fichero);
        // Ejecutar la consulta con el parámetro "codigo"
        $query = $session->query($xq);
        $result = $query->execute();
        // Cerrar la consulta y la sesión
        $query->close();
        $session->close();

        $xml = new DOMDocument;
        $xml->loadXML($result);
        return $xml;

        // 

        // $xsl = new DOMDocument;
        // $xsl->load('../transform/data.xsl');

        // $proc = new XSLTProcessor;

        // $proc->importStyleSheet($xsl);

        // echo $proc->transformToXML($xml);
    } catch (Exception $e) {
        // Manejar cualquier excepción que ocurra durante la ejecución
        echo $e->getMessage();
    }
}
