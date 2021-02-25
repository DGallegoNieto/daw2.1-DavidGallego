window.onload = inicializaciones;

var tablaCategorias;
var tablaPersonas;


function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    tablaPersonas = document.getElementById("tablaPersonas");

    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria)

    cargarTodasLasCategorias();
    cargarTodasLasPersonas();
}

function cargarTodasLasCategorias() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var categorias = JSON.parse(this.responseText);

            for (var i=0; i<categorias.length; i++) {
                insertarCategoria(categorias[i]);
            }
        }
    };

    request.open("GET", "CategoriaObtenerTodas.php");
    request.send();
}

function clickCrearCategoria() {
    var nombreCategoria = document.getElementById("nombre").value;

    if(nombreCategoria != ""){
        var request = new XMLHttpRequest();

        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var categoria = JSON.parse(this.responseText);
                insertarCategoria(categoria);
                document.getElementById("nombre").value = "";

            }
        };
        request.open("GET", "CategoriaCrear.php?nombre=" + nombreCategoria, true);
        request.send();
    }

}

function insertarCategoria(categoria) {

    var tr = document.createElement("tr");
    tr.setAttribute("id", categoria.id);
    var tdNombre = document.createElement("td");
    var tdEliminar = document.createElement("td");
    var pNombre = document.createElement("p");
    pNombre.setAttribute("class", "categoriaNombre");
    pNombre.addEventListener("click", clickModificarCategoria);
    var bEliminar = document.createElement("button");
    bEliminar.setAttribute("class", "botonEliminar");
    bEliminar.addEventListener("click", eliminarCategoria);
    var textoNombre = document.createTextNode(categoria.nombre);
    var textoEliminar = document.createTextNode("X");

    pNombre.appendChild(textoNombre);
    tdNombre.appendChild(pNombre);
    bEliminar.appendChild(textoEliminar);
    tdEliminar.appendChild(bEliminar);

    tr.appendChild(tdNombre);
    tr.appendChild(tdEliminar);

    tablaCategorias.appendChild(tr);

    ordenarTabla(tablaCategorias);
}

function eliminarCategoria(e) {
    var id = e.target.parentNode.parentNode.id;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id).remove();
        }
    };
    request.open("GET", "CategoriaEliminar.php?id=" + id, true);
    request.send();

}

function clickModificarCategoria(e) {
    var id = e.target.parentNode.parentNode.id;
    var input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("value", e.target.innerText);
    input.setAttribute("id", "input"+id);
    input.addEventListener("blur", modificarCategoria);

    e.target = e.target.parentNode.replaceChild(input, e.target);
    document.getElementById("input"+id).focus();

}

function modificarCategoria(e){
    var id = e.target.parentNode.parentNode.id;

    var pNombre = document.createElement("p");
    pNombre.setAttribute("class", "categoriaNombre");
    pNombre.addEventListener("click", clickModificarCategoria);

    var nombreNuevo = document.getElementById(e.target.id).value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var pNombre = document.createElement("p");
            pNombre.setAttribute("class", "categoriaNombre");
            pNombre.addEventListener("click", clickModificarCategoria);
            var textoNombre = document.createTextNode(nombreNuevo);

            pNombre.appendChild(textoNombre);
            e.target = e.target.parentNode.replaceChild(pNombre, e.target);

            ordenarTabla(tablaCategorias);
        }
    };
    request.open("GET", "CategoriaModificar.php?nombre=" + nombreNuevo + "&id="+ id, true);
    request.send();

}

function ordenarTabla(tabla) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = tabla;
    switching = true;
    /*Hace que el bucle continue hasta que no se haga ningun cambio*/
    while (switching) {
        //Empieza diciendo que no se ha hecho ningun cambio
        switching = false;
        rows = table.rows;
        /*Recorre todas las filas excepto la primera que contiene los titulos*/
        for (i = 1; i < (rows.length - 1); i++) {
            //Empieza diciendo que no debe haber ningun cambio
            shouldSwitch = false;
            /*Recoge los dos elementos a comparar, uno de la fila actual y otro de la siguiente*/
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
            //Comprueba si las filas deben cambiar de lugar
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                //Si deben de cambiar, lo marca y acaba el bucle
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            /*Si se ha marcado que debe haber un cambio, lo hace y marca que se ha hecho el cambio*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/*------------------------------------------Personas--------------------------------------------------------------------------------*/

function cargarTodasLasPersonas(){
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var personas = JSON.parse(this.responseText);

            for (var i = 0; i < personas.length; i++) {
                insertarPersona(personas[i]);
            }
        }
    };

    request.open("GET", "PersonaObtenerTodas.php");
    request.send();
}


function insertarPersona(persona){
    var tr = document.createElement("tr");
    tr.setAttribute("id", persona.id);

    var tdNombre = document.createElement("td");
    var pNombre = document.createElement("p");
    pNombre.appendChild(document.createTextNode(persona.nombre));
    var tdApellidos = document.createElement("td");
    var pApellidos = document.createElement("p");
    pApellidos.appendChild(document.createTextNode(persona.apellidos));
    var tdTelefono = document.createElement("td");
    var pTelefono = document.createElement("p");
    pTelefono.appendChild(document.createTextNode(persona.telefono));
    var tdCategoriaId = document.createElement("td");
    var pCategoriaId = document.createElement("p");
    pCategoriaId.appendChild(document.createTextNode(persona.categoriaId));

    var tdEditar = document.createElement("td");
    var bEditar = document.createElement("button");
    bEditar.appendChild(document.createTextNode("Editar"));
    bEditar.setAttribute("class", "botonEditar");
    bEditar.addEventListener("click", editarPersona);

    var tdEliminar = document.createElement("td");
    var bEliminar = document.createElement("button");
    bEliminar.appendChild(document.createTextNode("X"));
    bEliminar.setAttribute("class", "botonEliminar");
    bEliminar.addEventListener("click", eliminarPersona);


    tdNombre.appendChild(pNombre);
    tdApellidos.appendChild(pApellidos);
    tdTelefono.appendChild(pTelefono);
    tdCategoriaId.appendChild(pCategoriaId);
    tdEditar.appendChild(bEditar);
    tdEliminar.appendChild(bEliminar);

    tr.appendChild(tdNombre);
    tr.appendChild(tdApellidos);
    tr.appendChild(tdTelefono);
    tr.appendChild(tdCategoriaId);
    tr.appendChild(tdEditar);
    tr.appendChild(tdEliminar);

    tablaPersonas.appendChild(tr);
}

function eliminarPersona(e){
    var id = e.target.parentNode.parentNode.id;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id).remove();
        }
    };
    request.open("GET", "PersonaEliminar.php?id=" + id, true);
    request.send();
}

function editarPersona(e){
    var id = e.target.parentNode.parentNode.id;

    var fila = document.getElementById(id);

    alert(id + " " + fila.childElementCount);
    /*
    for(var i = 0; i < fila.childElementCount; i++){
        var input = document.createElement("input");
        input.setAttribute("value", fila.children[i].innerHTML);
        fila.children[i] = input;

    }
    */


}