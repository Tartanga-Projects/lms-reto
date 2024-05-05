<datos>
    {
        for $car in /datos/dato
        return
        <dato>
            <nombre>{data($car/nombre)}</nombre>
            <apellido>{data($car/apellido)}</apellido>
            <edad>{data($car/edad)}</edad>
            <correo>{data($car/correo)}</correo>
        </dato>
    }
    </datos>