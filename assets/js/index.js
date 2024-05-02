const darAlta = document.getElementById('altaDato');
let modificar = document.getElementById('modificar');
let nombreF = document.getElementById('Nombre');
let apellidoF = document.getElementById('Apellido');
let edadF = document.getElementById('Edad');
let correoF = document.getElementById('Correo');

// Alta de datos
darAlta.addEventListener('click', (event) => {
    event.preventDefault()

    const nombre = nombreF.value;
    console.log(nombre)
    const apellido = apellidoF.value;
    const edad = edadF.value;
    const correo = correoF.value;

    if (nombre === '' && apellido === '' && edad === '' && correo === '') {
        alert('rellena los campos')
    } else {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost/lms-reto/server/server.php', true);

        let formData = new FormData();
        formData.append('Nombre', nombre);
        formData.append('Apellido', apellido);
        formData.append('Edad', edad);
        formData.append('Correo', correo);
        formData.append('action', 'alta');

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Datos guardados correctamente');
                    update();
                } else if (xhr.status === 404) {
                    console.log('Página no encontrada');
                } else {
                    console.log('Error en la solicitud' + xhr.status);
                }
            }
        }
        borrado();
        xhr.send(formData);
    }


})

modificar.addEventListener('click', () => {
    let valor = prompt("Introduce un nombre que quieras modificar: ");
    if (valor !== null) {
        console.log(valor)
    } else {
        console.log('el usuario cancela')
    }
})

//Borrado de datos del formulario
function borrado() {
    document.getElementById('Nombre').value = '';
    document.getElementById('Apellido').value = '';
    document.getElementById('Edad').value = '';
    document.getElementById('Correo').value = '';
}

//Actualizar la pagina tras enviar el formulario
function update() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/lms-reto/server/server.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText)
            document.getElementById('respuesta').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}


// Metodo para la confirmación de que quiere insertar los datos
function submit() {

}