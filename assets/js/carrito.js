let bodyTablaCarritoArea = document.getElementById('bodyTablaCarritoArea');
let loaderCarritoArea = document.getElementById('loaderCarritoArea');
let formCarrito = document.getElementById('formCarrito');
let spinnerConfirmarPedido = document.getElementById('spinnerConfirmarPedido');
let mensajeError = document.getElementById('mensajeError');

let construirCarritoArea = (datos) => {

    bodyTablaCarritoArea.innerHTML = "";
    for (let i = 0; i < datos.length; i++) {
        let tr = document.createElement('tr');
        let th = document.createElement('th');
        th.classList.add('text-center', 'align-middle');
        let tdNombre = document.createElement('td');
        tdNombre.classList.add('text-left', 'align-middle', 'text-capitalize');
        let tdSubototal = document.createElement('td');
        tdSubototal.classList.add('text-right', 'align-middle');
        let tdButtonBorrar = document.createElement('td');
        tdButtonBorrar.classList.add('text-center', 'align-middle');
        let btnBorrarProducto = document.createElement('button');
        let iconBorrar = document.createElement('i');

        th.setAttribute("scope", "row");
        btnBorrarProducto.setAttribute("onclick", `sacarProductoCarritoArea(${i})`);
        btnBorrarProducto.classList.add('btn');
        iconBorrar.classList.add('fas', 'fa-trash-alt', 'fs-2', 'text-su-amarillo');

        th.innerHTML = datos[i][1];

        tdNombre.innerHTML = datos[i][2];
        tdSubototal.innerHTML = `$${datos[i][3].toString().replaceAll('.', ',')} `;

        //--------OPCIONES--------------------//
        for (let j = 0; j < datos[i][4].length; j++) {
            var divOpciones = document.createElement('div');
            var divOpcion = document.createElement('div');
            divOpcion.innerHTML = `${datos[i][4][j][0].nombre} ($${datos[i][4][j][0].precio.toString().replaceAll('.', ',')})`;
            divOpciones.classList.add('fs-2', 'd-flex', 'text-su-naranja');
            divOpciones.appendChild(divOpcion);
            tdNombre.appendChild(divOpciones);


        }
        var divComentario = document.createElement('div');
        divComentario.classList.add('fs-2', 'd-flex', 'text-su-naranja');
        var thumbComentario = document.createElement('div');
        thumbComentario.innerHTML = datos[i][5];
        divComentario.appendChild(thumbComentario);
        tdNombre.appendChild(divComentario);

        btnBorrarProducto.appendChild(iconBorrar);
        tdButtonBorrar.appendChild(btnBorrarProducto);
        tr.appendChild(th);

        tr.appendChild(tdNombre);
        tr.appendChild(tdSubototal);
        tr.appendChild(tdButtonBorrar);

        bodyTablaCarritoArea.appendChild(tr);
    }

}


let sacarProductoCarritoArea = (posicion) => {
    loaderCarritoArea.classList.remove('oculto');

    let peticion = consulta_bd(`sacar_producto_carrito&posicion=${parseInt(posicion)}`);
    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        construirCarritoArea(datos);
        actualizarTotales(datos);
        cantidadDeitems.innerHTML = datos.length;


    }
    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            loaderCarritoArea.classList.add('oculto');
        }

    }
}

let mostrarCarrito = () => {
    loaderCarritoArea.classList.remove('oculto');
    let peticion = consulta_bd(`consultar_carrito`);

    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        cantidadDeitems.innerHTML = datos.length;
        construirCarritoArea(datos);
        actualizarTotales(datos);


    }
    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            loaderCarritoArea.classList.add('oculto');
        }

    }
}

let enviarCarrito = (form) => {
    mensajeError.classList.add('oculto');
    spinnerConfirmarPedido.classList.remove('oculto');
    array_todos_los_datos = [];
    for (var i = 0; i < form.length - 1; i++) { // form.length-1 para que no incluya el boton de submit
        if (form[i].type == 'radio') {
            if (form[i].checked == true) {
                array_todos_los_datos.push(form[i].value);
            }
        } else {
            array_todos_los_datos.push(form[i].value);
        }
    }

    let peticion = consulta_bd(`confirmarcarrito&array_datos=${JSON.stringify(array_todos_los_datos)}`);

    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        if (datos[0][0] == 0) {
            construirMensajeWs(datos[1], array_todos_los_datos);
        } else {
            mostrarError(datos[1]);
        }
    }

    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            spinnerConfirmarPedido.classList.add('oculto');
        }

    }
}
let mostrarError = (datos) => {
    mensajeError.innerHTML = datos;
    mensajeError.classList.remove('oculto');
}


let construirMensajeWs = (datos, array_todos_los_datos) => {
    let mensajeWs = '';
    for (let i = 0; i < datos.length; i++) {
        mensajeWs = `${mensajeWs}*x${datos[i][1]}%20${datos[i][2]}*%0A`;
        for (let j = 0; j < datos[i][4].length; j++) {
            mensajeWs = `${mensajeWs}${datos[i][4][j][0].nombre}%0A`;
        }
        mensajeWs = `${mensajeWs}SubTotal:%20$${datos[i][3]}%0A${datos[i][5]}%0A`;

    }

    //-------TOTAL--------------//
    let totalCarrito = 0;
    for (let i = 0; i < datos.length; i++) {
        totalCarrito = parseFloat(totalCarrito) + parseFloat(datos[i][3]);
    }
    mensajeWs = `${mensajeWs}*TOTAL:%20$${totalCarrito}*%0A`;
    //Datos del envio//
    mensajeWs = `${mensajeWs}////Datos para el Envío////%0A`;
    for (let k = 0; k < array_todos_los_datos.length; k++) {
        mensajeWs = `${mensajeWs}*${array_todos_los_datos[k]}*%0A`;

    }

    window.location = `https://wa.me/541173665198?text=${mensajeWs}`;

}
formCarrito.addEventListener('submit', function(e) {
    e.preventDefault();
    enviarCarrito(formCarrito);
})