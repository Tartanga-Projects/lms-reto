const darAlta = document.getElementById('altaDato');

// Alta de datos
darAlta.addEventListener('click', (event) => {
    event.preventDefault()

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/lms-reto/server/server.php', true);

    let formData = new FormData();
    formData.append('Nombre', document.getElementById('Nombre'));
    formData.append('Apellido', document.getElementById('Apellido'));
    formData.append('Edad', document.getElementById('Edad'));
    formData.append('Correo', document.getElementById('Correo'));
    formData.append('action', 'alta');

    xhr.onreadystatechange = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                console.log('Datos guardados correctamente');
            } else if (xhr.status === 404) {
                console.log('Página no encontrada');
            } else {
                console.log('Error en la solicitud' + xhr.status);
            }
        }
    }

    xhr.send(formData);
})



// Metodo para la confirmación de que quiere insertar los datos
function submit() {

}