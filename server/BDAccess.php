<!DOCTYPE html>
<html>

<head>
    <title>Consulta de datos</title>
</head>

<body>
    <h1>ENUNCIADO</h1>
    <p>
        Este PHP va a conectar a BBDD.
    </p>

    <h1>RESULTADO</h1>

    <!-- Formulario para ingresar el parámetro "codigo" -->
    <form action="" method="GET">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" placeholder="Mete el codigo" name="nombre">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" placeholder="Mete el codigo" name="apellido">
        <label for="edad">Edad:</label>
        <input type="text" id="edad" placeholder="Mete el codigo" name="edad">
        <label for="correo">Correo:</label>
        <input type="text" id="correo" placeholder="Mete el codigo" name="correo">
        <input type="submit" value="Enviar">
    </form><br />

    <?php
    require_once("BDConexion.php");

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

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                //$rutaArchivoXml = $GLOBALS['xmlmodificado'];
                $rutaArchivoXslt = "../transform/data.xsl";
            
                $xml = new DOMDocument();
                $xml->load($result);
            
                if (file_exists($rutaArchivoXslt)) {
                    $xsl = new DOMDocument();
                    $xsl->load($rutaArchivoXslt);
            
                    $proc = new XSLTProcessor();
                    $proc->importStylesheet($xsl);
                    $html = $proc->transformToXml($xml);
            
                    echo $html;
                }
            }
            // $xml = new DOMDocument;
            // $xml->loadXML($result);
            
            // $xsl = new DOMDocument;
            // $xsl->load('../transform/data.xsl');

            // $proc = new XSLTProcessor;

            // $proc->importStyleSheet($xsl);

            // echo $proc->transformToXML($xml);
        } else {
            // Si no se proporciona el parámetro "codigo", mostrar un mensaje de error
            echo "Por favor, proporcione un código.";
        }
    } catch (Exception $e) {
        // Manejar cualquier excepción que ocurra durante la ejecución
        echo $e->getMessage();
    }
    ?>


</body>

</html>