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
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {

        $action = $_POST['action'];

        switch ($action) {
            case 'alta':
                altaDato();
                break;
            case 'modificar':
                modificar();
                break;
            case 'obtenerDatos':
                obtenerDatos();
                break;
            case 'eliminar':
                eliminar();
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
    //Faltan las variables de entrada
    try {
        if (isset($_POST['Nombre']) && isset($_POST['Apellido']) && isset($_POST['Edad']) && isset($_POST['Correo'])) {
            $nombre = $_POST['Nombre'];
            $apellido = $_POST['Apellido'];
            $edad = $_POST['Edad'];
            $correo = $_POST['Correo'];

            // Crear sesión
            $session = new Session();
            // Abrir la base de datos
            $session->execute("open PruebaReto");
            // Cargar la consulta XQuery desde el archivo
            $rutaXq = "alta.xq";
            $fichero = fopen($rutaXq, "r");
            $xq = fread($fichero, filesize($rutaXq));
            fclose($fichero);
            // Ejecutar la consulta con el parámetro "codigo"
            $query = $session->query($xq);
            // Vincular el valor del parámetro "codigo" a la consulta XQuery
            $query->bind('$nombre', $_POST['Nombre']);
            $query->bind('$apellido', $_POST['Apellido']);
            $query->bind('$edad', $_POST['Edad']);
            $query->bind('$correo', $_POST['Correo']);
            // Ejecutar la consulta
            $result = $query->execute();

            // $rutaXq = "consulta.xq";
            // $fichero = fopen($rutaXq, "r");
            // $xq = fread($fichero, filesize($rutaXq));
            // fclose($fichero);
            // // Ejecutar la consulta con el parámetro "codigo"
            // $query = $session->query($xq);
            // $result = $query->execute();
            // // Cerrar la consulta y la sesión
            $query->close();
            $session->close();

            //Crea a nivel local
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

            // $xml = new DOMDocument;
            // $xml->loadXML($result);

            // return $xml;

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

function modificar()
{
    //Faltan las variables de entrada
    try {
        if (isset($_GET["nombre"]) && isset($_GET["apellido"]) && isset($_GET["edad"]) && isset($_GET["correo"])) {

            // Crear sesión
            $session = new Session();
            // Abrir la base de datos
            $session->execute("open PruebaReto");
            // Cargar la consulta XQuery desde el archivo
            $rutaXq = "modificacion.xq";
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

            // $rutaXq = "consulta.xq";
            // $fichero = fopen($rutaXq, "r");
            // $xq = fread($fichero, filesize($rutaXq));
            // fclose($fichero);
            // // Ejecutar la consulta con el parámetro "codigo"
            // $query = $session->query($xq);
            // $result = $query->execute();
            // // Cerrar la consulta y la sesión
            $query->close();
            $session->close();

            //Modifica a nivel local
            $cargarXml = "../DB/data.xml";
            if (!file_exists($cargarXml)) {
                exit;
            }
            $xml = simplexml_load_file($cargarXml);
            if ($xml === false) {
                echo 'Error al cargar el archivo XML.';
                exit;
            }

            $nombreModificar = $_GET["nombre"];

            foreach ($xml->dato as $dato) {
                // Verificar si el nombre del elemento 'dato' coincide con el nombre a modificar
                if ((string) $dato->nombre === $nombreModificar) {
                    // Actualizar los datos del elemento 'dato'
                    $dato->nombre = $_GET["nombre"];
                    $dato->apellido = $_GET["apellido"];
                    $dato->edad = $_GET["edad"];
                    $dato->correo = $_GET["correo"];
                    // Guardar los cambios en el archivo XML
                    $xml->asXML($cargarXml);
                    // Mostrar mensaje de éxito
                    echo "Los datos fueron actualizados correctamente.";
                    // Terminar el bucle
                    break;
                }
            }

            // $xml = new DOMDocument;
            // $xml->loadXML($result);

            // return $xml;

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

//Modificar para que obtenga el xml de la consulta xquery, lo hare sin JSON
function obtenerDatos()
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

function eliminar()
{
    //Faltan las variables de entrada
    try {
        if (isset($_GET["nombre"])) {

            // Crear sesión
            $session = new Session();
            // Abrir la base de datos
            $session->execute("open PruebaReto");
            // Cargar la consulta XQuery desde el archivo
            $rutaXq = "eliminar.xq";
            $fichero = fopen($rutaXq, "r");
            $xq = fread($fichero, filesize($rutaXq));
            fclose($fichero);
            // Ejecutar la consulta con el parámetro "codigo"
            $query = $session->query($xq);
            // Vincular el valor del parámetro "codigo" a la consulta XQuery
            $query->bind('$nombre', $_GET["nombre"]);
            // Ejecutar la consulta
            $result = $query->execute();

            // $rutaXq = "consulta.xq";
            // $fichero = fopen($rutaXq, "r");
            // $xq = fread($fichero, filesize($rutaXq));
            // fclose($fichero);
            // // Ejecutar la consulta con el parámetro "codigo"
            // $query = $session->query($xq);
            // $result = $query->execute();
            // // Cerrar la consulta y la sesión
            $query->close();
            $session->close();

            //Modifica a nivel local
            $cargarXml = "../DB/data.xml";
            if (!file_exists($cargarXml)) {
                exit;
            }
            $xml = simplexml_load_file($cargarXml);
            if ($xml === false) {
                echo 'Error al cargar el archivo XML.';
                exit;
            }

            $nombreEliminar = $_GET["nombre"];

            $nodesToDelete = $xml->xpath("//dato[nombre = '$nombreEliminar']");

            // Eliminar los nodos encontrados
            foreach ($nodesToDelete as $node) {
                $domNode = dom_import_simplexml($node);
                $domNode->parentNode->removeChild($domNode);
            }

            // Guardar los cambios de vuelta al archivo
            $xml->asXML($xml);

            // $xml = new DOMDocument;
            // $xml->loadXML($result);

            // return $xml;

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
