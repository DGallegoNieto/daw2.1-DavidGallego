<?php
$operando1 = $_REQUEST["operando1"];
$operando2 = $_REQUEST["operando2"];
$operacion = $_REQUEST["operacion"];
$mensaje = null;
$resultado = null;
switch($operacion){
    case 'sum':
        $resultado = $operando1 + $operando2;
        $mensaje = "El resultado de sumar $operando1 más $operando2 es $resultado.";
        break;
    case 'res':
        $resultado = $operando1 - $operando2;
        $mensaje = "El resultado de restar $operando1 menos $operando2 es $resultado.";
        break;
    case 'mult':
        $resultado = $operando1 * $operando2;
        $mensaje = "El resultado de multiplicar $operando1 por $operando2 es $resultado.";
        break;
    case 'div':
        if($operando2 == 0){
            $mensaje = "<b>ERROR.</b> No se puede dividir por 0.";
        } else{
            $resultado = $operando1 / $operando2;
            $mensaje = "El resultado de dividir $operando1 entre $operando2 es $resultado.";
        }
        break;
}
?>
<html>
<head>
    <title>Ejercicio 8 - Calculadora b</title>
</head>
<body>
<h1>Calculadora</h1>
<p><?=$mensaje?></p>
<form action="EJ8aCalculadora.php">
    <input type="submit" name="otraOperacion" value="Otra operación" />
</form>
</body>
</html>
