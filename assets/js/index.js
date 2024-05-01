const darAlta = document.getElementById('altaDato');

// Alta de datos
darAlta.addEventListener('click', (event) => {
    event.preventDefault()
    const Nombre = document.getElementById('Nombre').value;
    const Apellido = document.getElementById('Apellido').value;
    const Edad = document.getElementById('Edad').value;
    const Correo = document.getElementById('Correo').value;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/lms-reto/server/server.php', true);

    let formData = new FormData();
    formData.append('Nombre', Nombre);
    formData.append('Apellido', Apellido);
    formData.append('Edad', Edad);
    formData.append('Correo', Correo);
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