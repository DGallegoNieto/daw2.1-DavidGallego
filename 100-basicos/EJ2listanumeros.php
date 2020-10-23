<!DOCTYPE html>
<html>
    <head>Ejercicio 2 - Numeros del 1 al 10 en una lista
    </head>
    
    <body>
        <ul>
        <?php 
        $contador = 1;
        while($contador <= 10){
            echo "<li>$contador</li>";
            $contador++;
        }
        ?>
        </ul>
    </body>
</html>