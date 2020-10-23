<?php
    $ciudades = array("Madrid", "Valencia", "Barcelona", "Toledo", "Cuenca", "Murcia");
?>
<html>
<head>
    <title>Ejercicio 4 - Arrays</title>
</head>
<body>
    <select name="ciudades">
        <?php
            foreach($ciudades as $i) {
                echo "<option value=$ciudades>$i</option>";
            }
        ?>

    </select>

</body>
</html>
