window.onload = inicializaciones;
var tablaCategorias;
// TODO ¿Útil para mantener un control de eliminaciones, etc.?     var categorias;



function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria)

    cargarTodasLasCategorias();
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
                // Recoger datos del form.
                // Limpiar los datos en el form: .clear()
                // Crear un XMLHttpRequest. Enviar en la URL los datos de la categoria: CategoriaCrear.php?nombre=blablabla
                // Recoger la respuesta del request. Vendrá un objeto categoría.
                // Llamar con ese objeto a insertarCategoria(categoria);
            };
            request.open("GET", "CategoriaCrear.php?nombre=" + nombreCategoria, true);
            request.send();
        }

    }

    function insertarCategoria(categoria) {
        // TODO Que la categoría se inserte en el lugar que le corresponda según un orden alfabético.
        // Usar esto: https://www.w3schools.com/jsref/met_node_insertbefore.asp
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

        ordenarTabla();
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

                ordenarTabla();
            }
        };
        request.open("GET", "CategoriaModificar.php?nombre=" + nombreNuevo + "&id="+ id, true);
        request.send();

    }

function ordenarTabla() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tablaCategorias");
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
            //check if the two rows should switch place:
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                //if so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}


// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)