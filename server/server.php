<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $rutaArchivoXml = "../DB/data.xml";
        $rutaArchivoXslt = "../transform/data.xsl";

        if($rutaArchivoXml){
            $xml=new DOMDocument();
            $xml->load($rutaArchivoXml);

            if($rutaArchivoXslt){
                $xsl=new DOMDocument();
                $xsl->load($rutaArchivoXslt);

                $proc=new XSLTProcessor();
                $proc->importStylesheet($xsl);
                $html= $proc->transformToXml($xml);

                echo $html;
            }
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
    
            switch($action) {
                case 'alta':
                    altaDato();
                    break;
                case 'modificar':
                    //modificarDato();
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

    function altaDato() {
        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $edad = $_POST['Edad'];
        $correo = $_POST['Correo'];

        $cargarXml = "../DB/data.xml";
        if(!file_exists($cargarXml)) {
            exit;
        } 
        $xml = simplexml_load_file($cargarXml);
        if($xml === false) {
            echo 'Error al cargar el archivo XML.';
            exit;
        }

        $nuevoNombre = $xml->datos->addChild('dato');
        $nuevoNombre->addChild('nombre', $nombre);
        $nuevoNombre->addChild('apellido', $apellido);
        $nuevoNombre->addChild('edad', $edad);
        $nuevoNombre->addChild('correo', $correo);

        $xml->asXML($cargarXml);
    }