declare variable $codigo as xs:string external;

for $car in /universidad/carreras/carrera[@id=$codigo]
let $id := $car/@id
return
  <carrera>
   {$car/nombre}
    <alumnos>
      {
	  for $alumno in /universidad/alumnos/alumno[estudios/carrera/@codigo=$id]
      return <alumno>{concat(data($alumno/nombre), " ", data($alumno/apellido1), " ", data($alumno/apellido2))}</alumno>
      }
    </alumnos>
  </carrera>