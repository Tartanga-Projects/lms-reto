let xhr = new XMLHttpRequest();
xhr.open('GET', 'http://localhost/lms-reto/server/server.php', true);
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById('respuesta').innerHTML = xhr.responseText;
    }
};
xhr.send();
