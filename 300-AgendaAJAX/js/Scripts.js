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

        var request = new XMLHttpRequest();

        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                xhttp.open("POST", "CategoriaCrear.php?nombre=" + nombreCategoria, true);
                xhttp.send();

                var categoria = JSON.parse(this.responseText);
                insertarCategoria(categoria);

            }

            // Recoger datos del form.
            // Limpiar los datos en el form: .clear()
            // Crear un XMLHttpRequest. Enviar en la URL los datos de la categoria: CategoriaCrear.php?nombre=blablabla
            // Recoger la respuesta del request. Vendrá un objeto categoría.
            // Llamar con ese objeto a insertarCategoria(categoria);
        }
    }

    function insertarCategoria(categoria) {
        // TODO Que la categoría se inserte en el lugar que le corresponda según un orden alfabético.
        // Usar esto: https://www.w3schools.com/jsref/met_node_insertbefore.asp
        var tr = document.createElement("tr");
        var tdNombre = document.createElement("td");
        var tdEliminar = document.createElement("td");
        var aNombre = document.createElement("a");
        aNombre.setAttribute("href", "CategoriaFicha.php?id=" + categoria.id);
        var aEliminar = document.createElement("a");
        aEliminar.setAttribute("href", "CategoriaEliminar.php?id=" + categoria.id);
        var textoNombre = document.createTextNode(categoria.nombre);
        var textoEliminar = document.createTextNode("(X)");


        aNombre.appendChild(textoNombre);
        tdNombre.appendChild(aNombre);
        aEliminar.appendChild(textoEliminar);
        tdEliminar.appendChild(aEliminar);
        tr.appendChild(tdNombre);
        tr.appendChild(tdEliminar);
        tablaCategorias.appendChild(tr);
    }

    function eliminarCategoria(id) {
        // TODO Pendiente de hacer.
        //¿Es necesario hacerlo aquí?
    }

    function modificarCategoria(categoria) {
        // TODO Pendiente de hacer.
    }


// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)