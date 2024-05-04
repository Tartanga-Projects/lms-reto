var botonModificarClicado = false
var botonEliminarClicado = false
const guardado = document.getElementById('guardar');
let modificarB = document.getElementById('modificar');
let eliminarB = document.getElementById('eliminar');
let nombreF = document.getElementById('Nombre');
let apellidoF = document.getElementById('Apellido');
let edadF = document.getElementById('Edad');
let correoF = document.getElementById('Correo');

// Alta de datos
guardado.addEventListener('click', (event) => {
    event.preventDefault();
    //Obtengo el contenido de las variables
    const nombre = nombreF.value;
    const apellido = apellidoF.value;
    const edad = edadF.value;
    const correo = correoF.value;
    //compruebo que los campos no esten vacios
    if (nombre === '' && apellido === '' && edad === '' && correo === '') {
        alert('No pueden estar los campos vacios');
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/lms-reto/server/BDAccess copy.php', true);

    let formData = new FormData();
    formData.append('Nombre', nombre);
    formData.append('Apellido', apellido);
    formData.append('Edad', edad );
    formData.append('Correo', correo);
    console.log(nombre,apellido,edad,correo)
    if (botonModificarClicado) {
        //Va el metodo de enviar para modificar
        modificar(xhr,formData);
        botonModificarClicado = false;
    } else if (botonEliminarClicado) {
        //Va el metodo de enviar para eliminar
        eliminar(xhr,formData)
        botonEliminarClicado = false;
    } else {
        darAlta(xhr,formData)
    }
})

function darAlta(xhr,formData) {
    formData.append('action', 'alta');
    envioFormulario(xhr,formData);
}

function modificar(xhr,formData) {
    formData.append('action', 'modificar');
    envioFormulario(xhr,formData);
}

function eliminar(xhr,formData) {
    formData.append('action', 'eliminar');
    envioFormulario(xhr,formData);
}

modificarB.addEventListener('click', (event) => {
    event.preventDefault();
    let mod = 'modificar'
    rellenarFormulario(mod)
})

eliminarB.addEventListener('click', (event) => {
    event.preventDefault();
    let mod = 'eliminar'
    rellenarFormulario(mod)
})

function rellenarFormulario(mod){
    let valor = prompt("Introduce un nombre que quieras %s : ",mod);
    let formData = new FormData();
    formData.append('Valor', valor);
    formData.append('action', 'obtenerDatos');
    if (valor !== null) {
        fetch('http://localhost/lms-reto/server/BDAccess copy.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('Nombre').value = data.nombre;
                document.getElementById('Apellido').value = data.apellido;
                document.getElementById('Edad').value = data.edad;
                document.getElementById('Correo').value = data.correo;
                if(mod === "modificar"){
                    botonModificarClicado = true
                }else{
                    botonEliminarClicado = true
                }
                
            })
            .catch(error => {
                console.error('Error: ', error);
            })
    } else {
        console.log('el usuario cancela');
    }
}

//Borrado de datos del formulario
function borrado() {
    document.getElementById('Nombre').value = '';
    document.getElementById('Apellido').value = '';
    document.getElementById('Edad').value = '';
    document.getElementById('Correo').value = '';
}

function envioFormulario(xhr,formData){
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

//Actualizar la pagina tras enviar el formulario, no se si es necesario este metodo teniendo
// el del index.html
function update() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost/lms-reto/server/BDAccess copy.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            document.getElementById('respuesta').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}


// Metodo para la confirmación de que quiere insertar los datos
function submit() {

}