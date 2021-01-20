let loaderUser = document.getElementById('loaderUser');
let modalProductoLabel = document.getElementById('modalProductoLabel');
let modalDescripcion = document.getElementById('modalDescripcion');
let imgModal = document.getElementById('imgModal');
let inputCantidad = document.getElementById('inputCantidad');
let btnAgregarAlCarrito = document.getElementById('btnAgregarAlCarrito');
let formModalProducto = document.getElementById('formModalProducto');
let textAreaComentario = document.getElementById('textAreaComentario');
let spinnerAgregarAlCarrito = document.getElementById('spinnerAgregarAlCarrito');
let cantidadDeitems = document.getElementById('cantidadDeitems');
let totalCarritoBtn = document.getElementById('totalCarritoBtn');
let totalModal = document.getElementById('totalModal');
let bodyTablaCarritoModal = document.getElementById('bodyTablaCarritoModal');
let loaderModalCarrito = document.getElementById('loaderModalCarrito');
let loaderGeneralMenu = document.getElementById('loaderGeneralMenu');
let modalPrecio = document.getElementById('modalPrecio');
let btnSubir = document.getElementById('btnSubir');
let btnConsultarCarrito = document.getElementById('btnConsultarCarrito');
let btnsSecciones = document.getElementsByClassName('btnsSecciones');
let PestaniaMenu = document.getElementsByClassName('PestaniaMenu');
let areas = document.getElementsByClassName('areas');
let secciones = document.getElementsByClassName('secciones');
let divGeneralMenu = document.getElementById('divGeneralMenu');
let dropdownMenu = document.getElementById('dropdownMenu');
let loaderAreas = document.getElementById('loaderAreas');
let seccionGeneral = document.getElementById('seccionGeneral');

let timeout;


let detalleProducto = (id) => {
    loaderUser.classList.remove('oculto');
    inputCantidad.value = 1;
    formModalProducto.innerHTML = '';
    textAreaComentario.value = '';

    let peticion = consulta_bd(`get-info-producto&id=${id}`);

    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);

        btnAgregarAlCarrito.dataset.id = datos[0][0].id;
        modalDescripcion.innerHTML = datos[0][0].descripcion;
        modalProductoLabel.innerHTML = datos[0][0].nombre;
        modalPrecio.innerHTML = `$${datos[0][0].pvp.replaceAll('.', ',')}`;
        imgModal.src = `../assets/img/productos/${datos[0][0].img}`;


        for (let i = 0; i < datos[1].length; i++) {
            formModalProducto.appendChild(crearOpciones(datos[1][i]));
        }

    }

    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            loaderUser.classList.add('oculto');
            $('#modalProducto').modal('show');
        }

    }
}

let restarCantidad = () => {
    if (inputCantidad.value > 1) {
        inputCantidad.value--;
    }
}
let sumarCantidad = () => {
    inputCantidad.value++;
}

let construirTablaCarrito = (datos) => {

    bodyTablaCarritoModal.innerHTML = "";
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
        btnBorrarProducto.setAttribute("onclick", `sacarProductoCarrito(${i})`);
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

        bodyTablaCarritoModal.appendChild(tr);
    }
    actualizarTotales(datos);

}



let sacarProductoCarrito = (posicion) => {
    loaderModalCarrito.classList.remove('oculto');
    let peticion = consulta_bd(`sacar_producto_carrito&posicion=${parseInt(posicion)}`);
    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        construirTablaCarrito(datos);
        cantidadDeitems.innerHTML = datos.length;
        if (datos.length > 0) {
            btnConsultarCarrito.classList.remove('oculto');
        } else {
            btnConsultarCarrito.classList.add('oculto');
        }
        loaderModalCarrito.classList.add('oculto');

    }
}

let consultarCarrito = () => {

    loaderUser.classList.remove('oculto');
    let peticion = consulta_bd(`consultar_carrito`);

    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        construirTablaCarrito(datos);
    }

    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            loaderUser.classList.add('oculto');
            $('#modalCarrito').modal('show');
        }

    }

}


let ContruirArrayDatos = () => {
    let form = formModalProducto;

    arrayProducto = [];
    arrayOpciones = [];
    arrayProducto.push(btnAgregarAlCarrito.dataset.id);
    arrayProducto.push(inputCantidad.value);
    arrayProducto.push(textAreaComentario.value);
    for (let i = 0; i < form.length; i++) {
        if (form[i].type == "checkbox" || form[i].type == "radio") {
            if (form[i].checked == true) {
                arrayOpciones.push(form[i].value);
            }

        }
    }
    arrayProducto.push(arrayOpciones);
    return arrayProducto;
}

let actualizarTotales = (carrito) => {
    totalCarritoBtn.innerHTML = "";
    totalModal.innerHTML = "";
    totalCarritoArea.innerHTML = "";
    let totalCarrito = 0;
    for (let i = 0; i < carrito.length; i++) {
        totalCarrito = parseFloat(totalCarrito) + parseFloat(carrito[i][3]);
    }

    totalCarritoBtn.innerHTML = `$${totalCarrito.toString().replaceAll('.', ',')}`;
    totalModal.innerHTML = `$${totalCarrito.toString().replaceAll('.', ',')}`;
    totalCarritoArea.innerHTML = `$${totalCarrito.toString().replaceAll('.', ',')}`;

}

let agregarAlCarrito = () => {
    spinnerAgregarAlCarrito.classList.remove('oculto');
    let arrayDatos = ContruirArrayDatos();
    let peticion = consulta_bd(`agregar_al_carrito&array_datos=${JSON.stringify(arrayDatos)}`);

    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        cantidadDeitems.innerHTML = datos.length;
        actualizarTotales(datos);
        if (datos.length > 0) {
            btnConsultarCarrito.classList.remove('oculto');
        } else {
            btnConsultarCarrito.classList.add('oculto');
        }
    }
    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            spinnerAgregarAlCarrito.classList.add('oculto');
            $('#modalProducto').modal('hide');
        }

    }
}



let scrollTo = (btn) => {
    let seccion = `#seccion${btn.dataset.seccion}`;
    let offset = $(seccion).offset().top;
    window.scrollTo(0, offset);
}


window.onscroll = function() {

    if (window.scrollY >= seccionGeneral.offsetTop) {
        btnSubir.classList.remove("oculto");
    } else {
        btnSubir.classList.add("oculto");
    }
}

let construirMenu = (datos) => {
    dropdownMenu.innerHTML = '';

    //console.log(datos);

    let posSeccion = 0;
    for (const property in datos) {
        if (datos[property].length > 0) {
            //---------------
            let dropdownItem = document.createElement('a');
            dropdownItem.classList.add('dropdown-item', 'text-capitalize', 'btnsSecciones');
            dropdownItem.setAttribute('data-seccion', posSeccion);
            dropdownItem.setAttribute('href', '#');
            dropdownItem.innerHTML = property;
            dropdownMenu.appendChild(dropdownItem);
            //-----------
            let row = document.createElement('div');
            row.classList.add('row', 'mt-3', 'secciones');
            let column = document.createElement('div');
            column.classList.add('column', 'col-12');
            column.setAttribute('id', `seccion${posSeccion}`);
            posSeccion++;
            tituloSeccion = document.createElement('h2');
            tituloSeccion.classList.add('text-capitalize', 'text-su-amarillo', 'fs-5');
            tituloSeccion.innerHTML = property;
            column.appendChild(tituloSeccion);
            row.appendChild(column);
            divGeneralMenu.appendChild(row);

            let rowProductos = document.createElement('div');
            rowProductos.classList.add('row', 'justify-content-center');
            let columnProductos = document.createElement('div');
            columnProductos.classList.add('column', 'col-12', 'd-flex', 'justify-content-around', 'flex-wrap', 'div-productos-seccion');

            for (let i = 0; i < datos[property].length; i++) {
                var divProducto = document.createElement('div');
                divProducto.classList.add('div-producto', 'd-flex', 'justify-content-start', 'mt-3', 'mb-2', 'col-12', 'col-md-10', 'col-lg-5', 'p-0');
                divProducto.setAttribute('onclick', `detalleProducto(${datos[property][i].idproducto})`);
                let thumbImgProducto = document.createElement('div');
                thumbImgProducto.classList.add('thumb-img-producto');
                let img = document.createElement('img');
                img.setAttribute('src', `../assets/img/productos/${datos[property][i].imgproducto}`);
                thumbImgProducto.appendChild(img);
                divProducto.appendChild(thumbImgProducto);
                let thumbTextProducto = document.createElement('div');
                thumbTextProducto.classList.add('thumb-text-producto', 'ml-2', 'position-relative');
                let h3NombreProducto = document.createElement('h3');
                h3NombreProducto.classList.add('text-su-amarillo', 'fs-3', 'mb-1', 'mt-2', 'text-capitalize', 'font-weight-bold');
                h3NombreProducto.innerHTML = datos[property][i].nombreproducto;
                let descripcion = document.createElement('p');
                descripcion.classList.add('text-white', 'fs-2', 'text-justify', 'mr-2', 'mb-0', 'text-capitalize', 'text-truncado-2lineas');
                descripcion.innerHTML = datos[property][i].descripcionproducto;
                let thumbPrecio = document.createElement('div');
                thumbPrecio.classList.add('thumb-precioProducto', 'col-12', 'absolute-inf-der');
                h5Precio = document.createElement('h5');
                h5Precio.classList.add('text-su-amarillo', 'font-weight-bold', 'text-right', 'fs-3');
                h5Precio.innerHTML = `$${datos[property][i].pvpproducto.replaceAll('.', ',')}`;
                thumbPrecio.appendChild(h5Precio);
                thumbTextProducto.appendChild(h3NombreProducto);
                thumbTextProducto.appendChild(descripcion);
                thumbTextProducto.appendChild(thumbPrecio);
                divProducto.appendChild(thumbTextProducto);
                columnProductos.appendChild(divProducto);


            }


            rowProductos.appendChild(columnProductos);
            divGeneralMenu.appendChild(rowProductos);


        }
        for (let i = 0; i < btnsSecciones.length; i++) {
            btnsSecciones[i].addEventListener("click", function(e) {
                e.preventDefault();
                scrollTo(this);
            });

        }



    }


}

let buscarProducto = (text) => {

    let peticion = consulta_bd(`buscar_producto&text=${text}`);

    peticion.onload = function() {
        var datos = JSON.parse(peticion.responseText);
        if (datos[0] != 0) {
            construirMenu(datos[0]);
        }


    }
    peticion.onreadystatechange = function() {
        if (peticion.readyState == 4 && peticion.status == 200) {
            loaderGeneralMenu.classList.add('oculto');
        }

    }


}


let irA = (pestania) => {

    let area = parseInt(pestania.dataset.area);
    if (area == 2) {
        btnConsultarCarrito.classList.add('oculto');
        mostrarCarrito();
    } else if (cantidadDeitems.innerHTML != "0") {
        btnConsultarCarrito.classList.remove('oculto');
    }

    for (let i = 0; i < areas.length; i++) {
        areas[i].classList.add('oculto');
        PestaniaMenu[i].classList.remove('pestania-activa');
        PestaniaMenu[i].classList.add('text-white');
    }
    areas[area].classList.remove('oculto');
    PestaniaMenu[area].classList.add('pestania-activa');
    PestaniaMenu[area].classList.remove('text-white');

}


btnSubir.addEventListener("click", function(e) {
    window.scrollTo(0, 0);
});


for (let i = 0; i < btnsSecciones.length; i++) {
    btnsSecciones[i].addEventListener("click", function(e) {
        e.preventDefault();
        scrollTo(this);
    });

}
for (let i = 0; i < PestaniaMenu.length; i++) {
    PestaniaMenu[i].addEventListener("click", function(e) {
        e.preventDefault();
        irA(this);
    });

}



btnAgregarAlCarrito.addEventListener('click', () => {
    agregarAlCarrito();
})

$("#inputBuscador").keyup(function() {
    loaderGeneralMenu.classList.remove('oculto');
    divGeneralMenu.innerHTML = '';
    let text = $(this).val();
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        buscarProducto(text);
        clearTimeout(timeout)
    }, 300);

})