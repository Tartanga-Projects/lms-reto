
declare variable $nombre as xs:string external;
declare variable $apellido as xs:string external;
declare variable $edad as xs:string external;
declare variable $correo as xs:string external;

declare variable $newDato := 
  <dato>
    <nombre>{$nombre}</nombre>
    <apellido>{$apellido}</apellido>
    <edad>{$edad}</edad>
    <correo>{$correo}</correo>
  </dato>;

let $lastDato := //dato[last()]

return insert node $newDato after $lastDato