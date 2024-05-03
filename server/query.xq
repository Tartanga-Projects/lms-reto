

declare variable $nombre as xs:string external;
declare variable $apellido as xs:string external;
declare variable $edad as xs:string external;
declare variable $correo as xs:string external;

(: Encuentra el parque con el código especificado y actualiza sus datos :)
let $parque := //dato[nombre = $nombre]
return (
    replace value of node $parque/nombre with $nombre,
    replace value of node $parque/apellido with $apellido,
    replace value of node $parque/edad with $edad,
    replace value of node $parque/correo with $correo
)
