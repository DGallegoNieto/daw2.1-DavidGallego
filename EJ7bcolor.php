<?php
$color = $_REQUEST["color"];
//echo"$color";
?>
<html>
<head>
    <title>Ejercicio 7 - Color b</title>
    <meta charset="UTF-8">
    <style>
        #texto {
            color: <?=$color?>;
        }
    </style>
</head>
<body>
<p id="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</body>
</html>
