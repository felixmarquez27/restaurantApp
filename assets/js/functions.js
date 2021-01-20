function consulta_bd(consulta) {
    var peticion = new XMLHttpRequest();
    peticion.open('POST', '../model/ajax.php');
    var parametros = 'consulta=' + consulta;
    peticion.setRequestHeader("content-Type", "application/x-www-form-urlencoded");
    peticion.send(parametros);
    return peticion;
}

let crearOpciones = (opciones) => {
    itemsModificadores = opciones.items_modificadores;
    let row = document.createElement('div');
    row.classList.add('row', 'justify-content-center', 'mt-2', 'mb-2');
    let column = document.createElement('div');
    column.classList.add('column', 'col-8');
    let tituloOpcion = document.createElement('h4');
    tituloOpcion.innerHTML = `${opciones.nombre}`;
    tituloOpcion.classList.add('text-su-amarillo', 'fs-3', 'text-capitalize');
    column.appendChild(tituloOpcion);
    let puedeSeleccionar = opciones.puede_seleccionar;

    if (puedeSeleccionar > 1) {
        for (let k = 0; k < itemsModificadores.length; k++) {
            let divInput = document.createElement('div');
            divInput.classList.add('form-check', 'form-check-inline');
            let checkbox = document.createElement('input');
            if (opciones.obligatorio == 1) { checkbox.setAttribute('required', true); }
            checkbox.setAttribute('type', 'checkbox');
            checkbox.setAttribute('id', `checkboxOpcion${itemsModificadores[k].id}`);
            checkbox.setAttribute('value', itemsModificadores[k].id);
            checkbox.setAttribute('data-idgm', opciones.id_grupo);
            checkbox.classList.add('form-check-input');
            let labelCheckbox = document.createElement('label');
            labelCheckbox.setAttribute('for', `checkboxOpcion${itemsModificadores[k].id}`);
            labelCheckbox.classList.add('form-check-label', 'text-white', 'text-capitalize');
            labelCheckbox.innerHTML = itemsModificadores[k].nombre;
            if (itemsModificadores[k].precio != '') {
                let small = document.createElement('small');
                small.classList.add('text-su-amarillo');
                small.innerHTML = ` $${itemsModificadores[k].precio}`;
                labelCheckbox.appendChild(small);
            }
            divInput.appendChild(checkbox);
            divInput.appendChild(labelCheckbox);
            column.appendChild(divInput);
            row.appendChild(column);
        }
    } else {
        for (let k = 0; k < itemsModificadores.length; k++) {
            let divInput = document.createElement('div');
            divInput.classList.add('form-check', 'form-check-inline');
            let radio = document.createElement('input');
            if (k == 0) { radio.setAttribute('checked', true); }
            if (opciones.obligatorio == 1) { radio.setAttribute('required', true); }
            radio.setAttribute('type', 'radio');
            radio.setAttribute('name', 'radioOptions');
            radio.setAttribute('id', `radioOpcion${itemsModificadores[k].id}`);
            radio.setAttribute('value', itemsModificadores[k].id);
            radio.setAttribute('data-idgm', opciones.id_grupo);
            radio.classList.add('form-check-input');
            let labelRadio = document.createElement('label');
            labelRadio.setAttribute('for', `radioOpcion${itemsModificadores[k].id}`);
            labelRadio.classList.add('form-check-label', 'text-white', 'text-capitalize');
            labelRadio.innerHTML = itemsModificadores[k].nombre;
            if (itemsModificadores[k].precio != '') {
                let small = document.createElement('small');
                small.classList.add('text-su-amarillo');
                small.innerHTML = ` $${itemsModificadores[k].precio}`;
                labelRadio.appendChild(small);
            }
            divInput.appendChild(radio);
            divInput.appendChild(labelRadio);
            column.appendChild(divInput);
            row.appendChild(column);
        }

    }
    return row;


}

let crearTextArea = (label) => {
    let row = document.createElement('div');
    row.classList.add('row', 'justify-content-center', 'mt-2', 'mb-2');
    let column = document.createElement('div');
    column.classList.add('column', 'col-8');
    let labeltextArea = document.createElement('h4');
    labeltextArea.innerHTML = label;
    labeltextArea.classList.add('text-su-amarillo', 'fs-3', 'text-capitalize');
    column.appendChild(labeltextArea);
    let inputGroup = document.createElement('div');
    inputGroup.classList.add('input-group');
    textArea = document.createElement('textarea');
    textArea.classList.add('form-control');
    textArea.setAttribute('aria-label', 'With textarea');
    inputGroup.appendChild(textArea);
    column.appendChild(inputGroup);
    row.appendChild(column);
    return row;
}