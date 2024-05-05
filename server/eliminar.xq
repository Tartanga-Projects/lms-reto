
declare variable $nombre as xs:string external;

let $parque := //dato[nombre = $nombre]
return (
    delete node $parque
)