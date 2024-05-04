<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //$rutaArchivoXml = $GLOBALS['xmlmodificado'];
    $rutaArchivoXslt = "../transform/data.xsl";

    $xml = new DOMDocument();
    $xml->load($variable_resultado);

    if (file_exists($rutaArchivoXslt)) {
        $xsl = new DOMDocument();
        $xsl->load($rutaArchivoXslt);

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl);
        $html = $proc->transformToXml($xml);

        echo $html;
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

function altaDato()
{
    if (isset($_POST['Nombre']) && isset($_POST['Apellido']) && isset($_POST['Edad']) && isset($_POST['Correo'])) {
        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $edad = $_POST['Edad'];
        $correo = $_POST['Correo'];

        $cargarXml = "../DB/data.xml";
        if (!file_exists($cargarXml)) {
            exit;
        }
        $xml = simplexml_load_file($cargarXml);
        if ($xml === false) {
            echo 'Error al cargar el archivo XML.';
            exit;
        }

        $nuevoNombre = $xml->addChild('dato');
        $nuevoNombre->addChild('nombre', $nombre);
        $nuevoNombre->addChild('apellido', $apellido);
        $nuevoNombre->addChild('edad', $edad);
        $nuevoNombre->addChild('correo', $correo);

        $xml->asXML($cargarXml);
    } else {
        echo 'No se recibieron todos los campos del formulario.';
    }
}

function modificarDato()
{
    if (isset($_POST['Valor'])) {
        $cargarXml = "../DB/data.xml";
        $nombreMod = $_POST['Valor'];
        $xml = simplexml_load_file($cargarXml);
        $resultado = $xml->xpath("//dato[nombre='$nombreMod']");
        if ($resultado) {
            // Convertir el resultado a un array asociativo
            $data = [
                'nombre' => (string) $resultado[0]->nombre,
                'apellido' => (string) $resultado[0]->apellido,
                'edad' => (string) $resultado[0]->edad,
                'correo' => (string) $resultado[0]->correo
            ];
            // Devolver los datos como JSON
            echo json_encode($data);
        } else {
            // Si no se encontró el dato, devolver un mensaje de error
            echo json_encode(['error' => 'No se encontró ningún dato para el nombre proporcionado.']);
        }
    } else {
        echo json_encode(['error' => 'No se recibieron todos los campos del formulario.']);
    }
}
